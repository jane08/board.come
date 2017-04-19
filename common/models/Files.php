<?php

namespace common\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property string $path
 * @property string $filemime
 * @property double $filesize
 * @property integer $status
 * @property string $datetime_created
 * @property string $datetime_updated
 */
class Files extends \yii\db\ActiveRecord
{
    public $file;
	 public $slider;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['filesize'], 'number'],
            [['status'], 'integer'],
            [['datetime_created', 'datetime_updated'], 'safe'],
            [['path', 'filemime'], 'string', 'max' => 255],

            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,jpeg', 'maxFiles' => 50],
			
			[['slider'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg', 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'filemime' => 'Filemime',
            'filesize' => 'Filesize',
            'status' => 'Status',
            'datetime_created' => 'Datetime Created',
            'datetime_updated' => 'Datetime Updated',
        ];
    }
}
