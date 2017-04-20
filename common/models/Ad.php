<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $subcategory_id
 * @property string $title
 * @property string $description
 * @property double $price
 */
class Ad extends \yii\db\ActiveRecord
{
	
	public $category_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'subcategory_id'], 'required'],
            [['user_id', 'subcategory_id'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['title'], 'string', 'max' => 255],
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
            'category_id' => 'Категория',
            'subcategory_id' => 'Подкатегория',
            'title' => 'Титул',
            'description' => 'Описание',
            'price' => 'Стоимость',
        ];
    }
}
