<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $entity_type
 * @property integer $entity_id
 * @property integer $rate
 * @property integer $status
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'entity_id', 'status'], 'integer'],
            [['rate'], 'safe'],
            [['entity_type'], 'safe'],
            [['entity_type'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'entity_type' => 'Entity Type',
            'entity_id' => 'Entity ID',
            'rate' => 'Rate',
            'status' => 'Status',
        ];
    }
}
