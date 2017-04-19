<?php

use yii\db\Schema;
use yii\db\Migration;

class m150818_064657_create_files_usage_table extends Migration
{
    public function up()
    {
        $this->createTable('files_usage', array(
            'file_id'                    => 'INTEGER (11)',
            'entity_type'                => 'VARCHAR (100) NOT NULL',
            'entity_id'                  => 'INTEGER (11)',
            'status'                     => 'INTEGER (2)',
            'name'                       => 'VARCHAR (255) NOT NULL',
            'PRIMARY KEY (`file_id`, `entity_type`,`entity_id`)'

            //'UNIQUE KEY `file_id` (`file_id`)',
           // 'UNIQUE KEY `entity_type` (`entity_type`)',
           // 'UNIQUE KEY `entity_id` (`entity_id`)',
           
        ));
    }

    public function down()
    {
         $this->dropTable('files_usage');
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
