<?php

use yii\db\Migration;

/**
 * Class m211210_144401_change_product_id_foreign_key_on_order_item_table
 */
class m211210_144401_change_product_id_foreign_key_on_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         // drops foreign key for table `{{%products}}`
         $this->dropForeignKey(
            '{{%fk-order_items-product_id}}',
            '{{%order_items}}'
        );

    //     // drops index for column `product_id`
    //     $this->dropIndex(
    //         '{{%idx-order_items-product_id}}',
    //         '{{%order_items}}'
    //     );

    //        // creates index for column `product_id`
    //        $this->createIndex(
    //         '{{%idx-order_items-product_id}}',
    //         '{{%order_items}}',
    //         'product_id'
    //     );

    //     // add foreign key for table `{{%products}}`
    //     $this->addForeignKey(
    //         '{{%fk-order_items-product_id}}',
    //         '{{%order_items}}',
    //         'product_id',
    //         '{{%products}}',
    //         'id',
    //         'NO ACTION'
    //     );

    // }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211210_144401_change_product_id_foreign_key_on_order_item_table cannot be reverted.\n";

        return false;
    }

   
}
