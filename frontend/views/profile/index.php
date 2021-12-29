<?php
/**
 * @var \common\models\User $user
 * @var \yii\web\View $this
 * @var \common\models\UserAddress $userAddress 
 */
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="row">
    <div class="col">
       <div class="card">
           <div class="card-header">
               <?php echo Yii::t('app', 'Address information')?>
           </div>
           <div class="card-body">
           <?php Pjax::begin([
               'enablePushState' => false
           ])?>
               <?php echo $this->render('user_address',
            [
                'userAddress' => $userAddress,
                'success' => $success
            ])
            ?>
            <?php Pjax::end()?>

           </div>
       </div>
    </div>
    <div class="col">
      <div class="card">
          <div class="card-header">
          <?php echo Yii::t('app', 'Account information')?>
          </div>
          <div class="card-body">
          <?php Pjax::begin([
        'enablePushState' => false,
        ]);?>
            <?php echo $this->render('user_account',
                [
                    'user' => $user,
                    'success' => $success
                ])
                ?>
                <?php Pjax::end()?>
            
        </div>
      </div>
    </div>
</div>


