<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170418_174136_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' 		=> 'VARCHAR(255)',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
