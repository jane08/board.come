<?php

use yii\db\Schema;
use yii\db\Migration;

class m150725_124004_insert_auth_items_child_table extends Migration
{
    public function up()
    {
		
				   
		$this->insert('auth_item_child', [
                   'parent' => 'advertiser',
                   'child' => 'comments',
				   
		]);
		
		$this->insert('auth_item_child', [
                   'parent' => 'comments',
                   'child' => 'comments.create',
				   
		]);
	
    }

    public function down()
    {
        echo "m150725_124004_insert_auth_items_child_table cannot be reverted.\n";

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
