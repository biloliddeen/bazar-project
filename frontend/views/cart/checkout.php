<?php
use  yii\bootstrap4\ActiveForm;

/**
 * @var \common\models\Order $order
 * @var \common\models\OrderAddress $orderAddress 
 * @var array $cartItems
 * @var int $productQuantity
 * @var float $totalPrice
 */?>
        
<?php $form = ActiveForm::begin([
    'id' => 'checkout-form',
     ]); 
?>
<div class="row">
    <div class="col">
        <div class="card mb-3">
            <div class="card-header">
                <h5>
                    <?php echo \Yii::t('app', 'Account information');?>
                </h5>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                        <?= $form->field($order, 'firstname')->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="col-md-6">
                        <?= $form->field($order, 'lastname')->textInput(['autofocus' => true]) ?>
                        </div>
                    </div>
                    <?= $form->field($order, 'email')->textInput(['autofocus' => true])  ?>       
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>
                    <?php echo \Yii::t('app', 'Address information');?>
                </h5>
            </div>
            <div class="card-body">
                <?php echo $form->field($orderAddress, 'address');?>
                <?php echo $form->field($orderAddress, 'city');?>
                <?php echo $form->field($orderAddress, 'state');?>
                <?php echo $form->field($orderAddress, 'country');?>
                <?php echo $form->field($orderAddress, 'zipcode');?>

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4><?php echo \Yii::t('app','Order Summary')?></h4>
            </div>
            <div class="card-body">
            <table class="table table-sm">
                    <thead>
                    <tr>
                        <th><?php echo \Yii::t('app','Image')?></th>
                        <th><?php echo \Yii::t('app','Name')?></th>
                        <th><?php echo \Yii::t('app','Quantity')?></th>
                        <th><?php echo \Yii::t('app','Price')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr >
                            <td>
                                <img src="<?php echo \common\models\Product::formatImageUrl($item['image']) ?>"
                                     style="width: 50px;"
                                     alt="<?php echo $item['name'] ?>">
                            </td>
                            <td><?php echo \yii\helpers\StringHelper::truncateWords($item['name'], 5) ?></td>
                            <td>
                                <?php echo $item['quantity'] ?>
                            </td>
                            <td><?php echo Yii::$app->formatter->asCurrency($item['total_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>    
            <hr>    
                <table class="table">
                    
                    <tr>
                        <td><?php echo \Yii::t('app','Total Items')?></td>
                        <td class="text-right"><?php echo $productQuantity ?></td>
                    </tr>
                    <tr>
                        <td><?php echo \Yii::t('app','Total Price')?></td>
                        <td class="text-right">
                            <?php echo Yii::$app->formatter->asCurrency($totalPrice);?>
                        </td>
                    </tr>
                </table>
                <p class="text-right mt-3">
                   <button class="btn btn-secondary">
                            <?php echo \Yii::t('app', 'Checkout')?>
                   </button>
                </p>
            </div>
        </div>
       
    </div>
</div>


<?php ActiveForm::end(); ?>

