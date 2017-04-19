<?php

use yii\db\Schema;
use yii\db\Migration;

class m150817_065029_create_files_table extends Migration
{
    
        public function up()
    {
        $this->createTable('files', array(
            'id'                    => 'pk',
            'path'                  => 'VARCHAR (255) NOT NULL ',
            'filemime'              => 'VARCHAR (255) NOT NULL',
            'filesize'              => 'float',
            'status'                => 'INTEGER (2)',
            'datetime_created'      => 'datetime',
            'datetime_updated'      => 'datetime',
        ));
    }
    

    public function down()
    {
         $this->dropTable('files');
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
