<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m170418_173559_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
			'user_id' => 'INTEGER(11)',
			'fio' => 'VARCHAR(255)',
			'phone' 		=> 'VARCHAR(30)',
			'address' 		=> 'VARCHAR(255)',
        ]);
		
		 // creates index for column `user_id`
        $this->createIndex(
            'idx-profile-user_id',
            'profile',
            'user_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		 // drops index for column `category_id`
        $this->dropIndex(
            'idx-profile-user_id',
            'profile'
        );
		
        $this->dropTable('profile');
    }
}
