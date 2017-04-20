<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }
	
	public static function getItemsName()
{
    $item = [];
$db = new AuthItem();
			$sql = 'SELECT auth_assignment.*,auth_item.* FROM `auth_assignment`,`auth_item` WHERE auth_item.`name`=auth_assignment.item_name';
					$item = AuthItem::findBySql($sql)->all();
				/*
					foreach($item as $it =>$i){
						echo $i->node->id."<br>";
						echo $i->id."<br>";
					}
				*/
			return $item;		
}
	public static function getUsers()
{
    $item = [];
$db = new User();
			$sql = 'SELECT auth_assignment.*,user.* FROM `auth_assignment`,`user` WHERE user.`id`=auth_assignment.user_id';
					$item = User::findBySql($sql)->all();
				
			return $item;		
}

	
	
}
