<?php

use yii\db\Schema;
use yii\db\Migration;

class m150725_112406_insert_auth_items_table extends Migration
{
    public function up()
    {
			$this->insert('auth_item', [
                   'name' => 'comments',
                   'type' => '4',
				   'description' => 'comments',
		]);
			$this->insert('auth_item', [
                   'name' => 'comments.create',
                   'type' => '4',
				   'description' => 'comments.create',
		]);
		$this->insert('auth_item', [
                   'name' => 'comments.update',
                   'type' => '4',
				   'description' => 'comments.update',
		]);
		$this->insert('auth_item', [
                   'name' => 'comments.update.own ',
                   'type' => '4',
				   'description' => 'comments.update.own ',
		]);
		$this->insert('auth_item', [
                   'name' => 'comments.delete',
                   'type' => '4',
				   'description' => 'comments.delete',
		]);
		$this->insert('auth_item', [
                   'name' => 'comments.delete.own',
                   'type' => '4',
				   'description' => 'comments.delete.own',
		]);
		$this->insert('auth_item', [
                   'name' => 'content.create',
                   'type' => '4',
				   'description' => 'content.create',
		]);
		$this->insert('auth_item', [
                   'name' => 'content.update ',
                   'type' => '4',
				   'description' => 'content.update ',
		]);
		$this->insert('auth_item', [
                   'name' => 'content.update.own',
                   'type' => '4',
				   'description' => 'content.update.own',
		]);
		
		
    }

    public function down()
    {
        echo "m150725_112406_insert_auth_items_table cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
