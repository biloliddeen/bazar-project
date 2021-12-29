<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="text-responsive">
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'class' => \yii\bootstrap4\LinkPager::class,
            ],
            'columns' => [
                [ 
                'attribute' => 'id',
                    'contentOptions' => [
                        'style' => 'width:60px'
                    ]
                ],
                [
                    'attribute' => 'image',
                    'label' => 'Image',
                    'format' => 'html',
                    'content' => function($model){
                        /** @var \common\models\Product $model */
                        return Html::img($model->getImageUrl(),['style' => 'width: 70px']);   
                    }
                ],
                [
                    'attribute' => 'name',
                    'content' => function($model){
                        return \yii\helpers\StringHelper::truncateWords($model->name, 7);
                    }
                ],
                'price:currency',
                [
                    'attribute' => 'status',
                    'content' => function($model){
                        /** @var \common\models\Product $model */
                        return Html::tag('span', $model->status ? 'Active' : 'Draft',[
                            'class' => $model->status ? 'badge badge-success' : 'badge badge-danger'
                        ]);
                    }
                ],
                [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'contentOptions' => [
                    'style' => 'white-space:nowrap'
                ],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'datetime',
                    'contentOptions' => [
                        'style' => 'white-space:nowrap'
                    ],
                ],
                //'created_by', 
                //'updated_by',
                // 'description:ntext',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => [
                        'class' => 'td-actions'
                    ]
                ],
            ],
        ]); ?>
        </div>


</div>
