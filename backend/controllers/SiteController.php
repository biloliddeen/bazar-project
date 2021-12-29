<?php

namespace backend\controllers;

use Yii;
use DateTime;
use yii\web\Response;
use common\models\User;
use yii\web\Controller;
use common\models\Order;
use yii\filters\VerbFilter;
use common\models\OrderItem;
use yii\helpers\ArrayHelper;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use backend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use backend\models\PasswordResetRequestForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','forgot-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $totalEarnings = Order::find()->paid()->sum('total_price');
        $totalOrders = Order::find()->paid()->count();
        $totalProducts = OrderItem::find()
            ->alias('oi')
            ->innerJoin(Order::tableName().' o', 'o.id = oi.order_id')
            ->andWhere(['o.status' => Order::STATUS_PAID])
            ->sum('quantity');
        $totalUsers = User::find()->andWhere(['status' => User::STATUS_ACTIVE])->count();
      
        $orders = '';
                // Order::findBySql("
                // SELECT 
                //     CAST(DATE_FORMAT(FROM_UNIXTIME(o.created_at), '%Y-%m-%d %H:%i:%s') 
                //     as DATE) as 'date', SUM(o.total_price) as 'total_price'
                // FROM orders o
                // WHERE o.status IN (".Order::STATUS_PAID.", ".Order::STATUS_COMPLETED.") 
                // GROUP_BY CAST(DATE_FORMAT(FROM_UNIXTIME(o.created_at), '%Y-%m-%d %H:%i:%s') as DATE)
                // ORDER BY o.created_at")
                //     ->asArray()
                //     ->all();

        // Line chart            
        
        $earningsData = [];
        if(!empty($orders)){
            $minDate = $orders[0]['date'];
            $orderByPriceMap = ArrayHelper::map($orders, 'date', 'total_price');
            $d = new DateTime($minDate);
            $nowDate = new DateTime();
            $dates = [];
            while($d->getTimestamp() < $nowDate->getTimestamp()){
                
                $label = $d->format('d/m/Y');
                $labels[] =  $label;
                $earningsData[] = (float)($orderByPriceMap[$d->format('Y-m-m')] ?? 0);
                $d->setTimestamp($d->getTimestamp() + 86400);
                
              }   
           }
        // Pie chart
        $countriesData = Order::findBySql(
            "SELECT country, 
                SUM(total_price) as total_price     
            FROM orders o 
                INNER JOIN order_addresses oa on o.id = oa.order_id 
            WHERE o.status IN (".Order::STATUS_COMPLETED.", ".Order::STATUS_PAID.")
            GROUP BY country")
                ->asArray()
                ->all(); 

            $countryLabels = ArrayHelper::getColumn($countriesData, 'country');
            $bgColors = [];
            $colorOptions = ['#4e73df', '#1cc88a', '#36b9cc'];

            foreach($countryLabels as $i => $country){
                $bgColors[] = $colorOptions[$i];
            }

            return $this->render('index',[
                'totalEarnings' => $totalEarnings,
                'totalOrders' => $totalOrders,
                'totalProducts' => $totalProducts,
                'totalUsers' => $totalUsers,
                'data' => $earningsData,
                'labels' => $labels,
                'countries' => $countryLabels,
                'bgColors' => $bgColors,
                'countriesData' => ArrayHelper::getColumn($countriesData, 'total_price'),
            ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionForgotPassword(){
        
        $this->layout = 'blank';

        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('forgot_password', [
            'model' => $model,
        ]);
    }

     /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
