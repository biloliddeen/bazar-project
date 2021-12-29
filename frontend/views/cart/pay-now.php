<?php 
/**
 * @var \common\models\Order $order
 */

 $orderAddress = $order->orderAddress;

?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo param('paypalClientId')?>">

</script>


<h3><?php echo \Yii::t('app', 'Order Summary')?> #<?php echo $order->id ?> </h3>
<hr> 
<div class="row">
    <div class="col">
        <h5>
            <?php echo \Yii::t('app', 'Account information');?>
        </h5>
        <table class="table">
                <tr>
                    <th> <?php echo \Yii::t('app', 'Firstname')?> </th>
                    <td> <?php echo $order->firstname?> </td>
                </tr>
                <tr>
                    <th><?php echo \Yii::t('app', 'Lastname')?> </th>
                    <td><?php echo $order->lastname ?></td>
                </tr>
                <tr>
                    <th><?php echo \Yii::t('app', 'Email')?>  </th>
                    <td> <?php echo $order->email ?> </td>
                </tr>
        </table>
      

        <h5>  
            <?php echo \Yii::t('app', 'Address information');?>
        </h5>
        <table class="table">
            <tr>                
                <th> <?php echo \Yii::t('app', 'Address')?> </th>
                <td> <?php echo $orderAddress->address ?> </td>
            </tr>
            <tr>
                <th> <?php echo \Yii::t('app', 'City')?> </th>
                <td> <?php echo $orderAddress->city ?> </td>
            </tr>
            <tr>
                <th> <?php echo \Yii::t('app', 'State')?> </th>
                <td> <?php echo $orderAddress->state ?> </td>
            </tr>
            <tr>
                <th> <?php echo \Yii::t('app', 'Country')?> </th>
                <td> <?php echo $orderAddress->country ?> </td>
            </tr>
            <tr>
                <th> <?php echo \Yii::t('app', 'Zipcode')?> </th>
                <td> <?php echo $orderAddress->zipcode ?> </td>
            </tr>
            
        </table>
    </div>
    
    <div class="col">
        <h5><?php echo \Yii::t('app', 'Products')?></h5>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><?php echo \Yii::t('app', 'Name')?></th>
                    <th><?php echo \Yii::t('app', 'Quantity')?></th>
                    <th><?php echo \Yii::t('app', 'Price')?></th>
                    <th><?php echo \Yii::t('app', 'Total Price')?></th>
                </tr>
            </thead>
            <tbody> 
                <?php foreach($order->orderItems as $item):?>
                <tr>
                    <td>
                        <img src="<?php echo $item->product->getImageUrl() ?>"
                            style="width: 50px;">
                    </td>
                    <td><?php echo \yii\helpers\StringHelper::truncateWords($item->product_name, 5)?></td>
                    <td><?php echo $item->quantity ?></td>
                    <td><?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?></td>
            <?php endforeach;?>
            </tr>
            </tbody>
        </table>
        <hr>
        <table class="dl-horizontal">
            <tr>
                <th><?php echo \Yii::t('app', 'Total Items')?> </th>
                <td class="text-right"><?php echo $order->getItemsQuantity() ?></td>
            </tr>
            <tr>
                <th><?php echo \Yii::t('app', 'Total Price')?></th>
                <td class="text-right"><?php echo Yii::$app->formatter->asCurrency($order->total_price) ?></td>
            </tr>
        </table>

        <div id="paypal-button-container"> </div>
    </div>
</div>
<script>
    paypal.Buttons().render("#paypal-button-container");
</script>
<script src="">
    paypal.Buttons({
        createOrder: function(data, actions){
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $order->total_price ?>
                    }
                
                }]
            });
        },
        onApprove: function(data, actions){
            console.log(data, actions);
            //This function captures the funds from the transaction
            return actions.order.capture().then(function (details){
                console.log(details);
                const $form = $('#checkout-form');  
                const formData = $form.serializeArray();
                formData.push({
                    name: 'transactionId',
                    value: details.id
                });
                formData.push({
                name: 'orderId',
                value: data.orderID
                });
                formData.push({
                    name: 'status',
                    value: details.status
                });
                $.ajax({
                    method: 'post',
                    url: '<?php echo \yii\helpers\Url::to(['/cart/submit-payment', 'orderId' => $order->id])?>',
                    data: formData,
                    success: function(res){
                        // This function shows a transaction success message to your buyer.
                        alert('Thanks for your business');
                        window.location.href = ''; 
                    }
                })
            });
        }
    }).render('#paypal-button-container');
    // This function display Smart Payment Buttons on your web page.
</script>