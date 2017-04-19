<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sub_category`.
 */
class m170418_175443_create_sub_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sub_category', [
            'id' => $this->primaryKey(),
			'category_id' => $this->integer()->notNull(),
			'name' => $this->string(),
        ]);
		
		  // creates index for column `category_id`
        $this->createIndex(
            'idx-subcat-category_id',
            'sub_category',
            'category_id'
        );
		
		// add foreign key for table `category`
        $this->addForeignKey(
            'fk-subcat-category_id',
            'sub_category',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		
		// drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-subcat-category_id',
            'sub_category'
        );
		
		 // drops index for column `category_id`
        $this->dropIndex(
            'idx-subcat-category_id',
            'sub_category'
        );
		
        $this->dropTable('sub_category');
		 
    }
}
