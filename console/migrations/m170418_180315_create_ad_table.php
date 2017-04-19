<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ad`.
 */
class m170418_180315_create_ad_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ad', [
            'id' => $this->primaryKey(),
			'user_id' => $this->integer()->notNull(),
			'subcategory_id' => $this->integer()->notNull(),
			'title' => $this->string(),
			'description' => $this->text(),
			'price' => 'float',
        ]);
		
		// creates index for column `user_id`
        $this->createIndex(
            'idx-ad-user_id',
            'ad',
            'user_id'
        );
		
		// creates index for column `subcategory_id`
        $this->createIndex(
            'idx-ad-subcategory_id',
            'ad',
            'subcategory_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		
		// drops index for column `user_id`
        $this->dropIndex(
            'idx-ad-user_id',
            'ad'
        );
		
		// drops index for column `user_id`
        $this->dropIndex(
            'idx-ad-subcategory_id',
            'ad'
        );
		
        $this->dropTable('ad');
    }
}
