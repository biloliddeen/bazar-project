<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\bootstrap4\Nav;
use yii\bootstrap4\Html;
use common\widgets\Alert;
use yii\bootstrap4\NavBar;
use frontend\assets\AppAsset;
use yii\bootstrap4\ButtonDropdown;
use cetver\LanguageSelector\items\MenuLanguageItems;
use cetver\LanguageSelector\items\DropDownLanguageItem;
use yii\helpers\Url;

$cartItemCount =$this->params['cartItemCount'];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<h2>'.Yii::$app->name.'</h2>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top p-0',
        ],
    ]);
    $menuItems = [
        ['label' => '<i class="fas fa-shopping-cart fa-lg pr-1"></i><span id="cart-quantity" class="badge badge-danger">'.$cartItemCount.'</span>', 
        'url' => ['/cart/index'],
        'encode' => false
    ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => \Yii::$app->user->identity->getDisplayName(),
            'items' => [
                [
                    'label' => Yii::t('app', 'Profile'),
                    'url' => ['/profile/index'],
                ],
                [
                    'label' =>  Yii::t('app', 'Logout'),
                    'url' => ['/site/logout'],
                    'linkOptions' => [
                        'data-method' => 'post'
                    ],
                ]
            ],
        ];
    }
    $menuItems[] = [
        'label' => '<span class="flag-icon flag-icon-'.Yii::$app->request->cookies['language'].'"></span>',
        'encode' => false,
        'items' => [
            [
                'label' => '<span class="flag-icon flag-icon-uz"></span> '.'O`zbekcha',
                'url' => Url::to(['site/language', 'lang' => 'uz']),
                'encode' => false
            ],
            [
                'label' => '<span class="flag-icon flag-icon-us"></span> '.'English',
                'url' => ['/site/language', 'lang'=> 'us'],
                'encode' => false
            ],
            [
                'label' => '<span class="flag-icon flag-icon-de"></span> '.'Deutsch',
                'url' => ['/site/language', 'lang' => 'de'],
                'encode' => false
            ]
        ],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink p-5">
    <div class="container p-3">
    
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
                </div>
                <div class="col text-right">
                <p class="pull-right"><?echo \Yii::t('app','Created by')?> <a href="http://t.me/abdullaev_571" target="_blank">Abdullaev Group</a></p>
            </div>
        </div>

      
        
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();






