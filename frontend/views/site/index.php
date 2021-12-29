<?php

/* @var $this yii\web\View */
/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\bootstrap4\LinkPager;
use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="body-content">
<?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{summary}<div class="row">{items}</div>{pager}' ,
            'itemView' => '_product_item',
            'itemOptions' => [
                'class' => 'col-lg-4 col-md-6 mb-4 product-item'
                ],
            'pager' => [
                'class' => LinkPager::class,
                'nextPageLabel' => \Yii::t('app', 'Next'),
                'prevPageLabel' => \Yii::t('app', 'Prev'),
         ]
        
]);
?>
    </div>
</div>

