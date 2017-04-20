<?php

use yii\db\Migration;

class m170420_110616_add_colums_to_ad extends Migration
{
    public function up()
    {
        $this->addColumn('ad', 'created_at', $this->datetime());
        $this->addColumn('ad', 'updated_at', $this->datetime());
    }

    public function down()
    {
        $this->dropColumn('ad', 'created_at');
        $this->dropColumn('ad', 'updated_at');
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
