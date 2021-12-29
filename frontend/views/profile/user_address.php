<?php
    use \yii\bootstrap4\ActiveForm; 
    use \yii\bootstrap4\Widget; 
    use yii\widgets\Pjax;
/**
 * @var \yii\web\View $this
 * @var \common\models\UserAddress $userAddress 
 */

?>
          
            <?php if(isset($success) && $success):?>
                <div class="alert alert-success">
                    Your account information was successfully updated
                </div>
            <?php endif ?>

           <?php $addressForm = ActiveForm::begin([
               'action' => ['/profile/update-address'],
               'options' => [
                   'data-pjax' => 1,
               ]
           ]) ?>
            <?php echo $addressForm->field($userAddress, 'address');?>
            <?php echo $addressForm->field($userAddress, 'city');?>
            <?php echo $addressForm->field($userAddress, 'state');?>
            <?php echo $addressForm->field($userAddress, 'country');?>
            <?php echo $addressForm->field($userAddress, 'zipcode');?>
            <button class="btn btn-primary">
                <?php echo \Yii::t('app', 'Update')?>
            </button>
        
            <?php ActiveForm::end(); ?>
        
       
