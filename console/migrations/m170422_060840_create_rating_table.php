<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rating`.
 */
class m170422_060840_create_rating_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('rating', [
            'id' => $this->primaryKey(),
            'user_id' => 'INTEGER(11)',
            'entity_type'                => 'VARCHAR (100) NOT NULL',
            'entity_id'                  => 'INTEGER (11)',
            'rate'                => 'float',
            'status'                     => 'INTEGER (2)',

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('rating');
    }
}
