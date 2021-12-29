<?php

use yii\bootstrap4\LinkPager;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <!-- <i class="fas fa-chevron-up"></i> -->

    <?= GridView::widget([
        'id' => 'ordersTable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class,
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width: 80px;']
            ],
            [ 
                'attribute' => 'fullname',
                 'content' => function($model){
                    return $model->firstname.' '.$model->lastname;
                }
            ],
            'total_price:currency',
            [
                "attribute" => 'status',
                "filter" => Html::activeDropDownList($searchModel,'status', \common\models\Order::getStatusLabels(), 
            [
                'class' => "form-control",
                'prompt' => 'All'
            ]),
                "format" => ["orderStatus"]
            ],
            'created_at:datetime',
            //'email:email',
            //'transaction_id',
            //'paypal_order_id',
            //'created_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'contentOptions' => [
                    'class' => 'td-options'
                ]
            ],
        ],
    ]); ?>


</div>
