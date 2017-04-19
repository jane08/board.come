<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "files_usage".
 *
 * @property integer $file_id
 * @property string $entity_type
 * @property integer $entity_id
 * @property integer $status
 * @property string $name
 */
class FilesUsage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files_usage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'entity_type', 'entity_id'], 'required'],
            [['file_id', 'entity_id', 'status'], 'integer'],
            [['entity_type'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'entity_type' => 'Entity Type',
            'entity_id' => 'Entity ID',
            'status' => 'Status',
            'name' => 'Name',
        ];
    }
}
