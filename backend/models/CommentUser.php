<?php
/**
 * User.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

//namespace rmrevin\yii\module\Comments\tests\unit\models;
namespace backend\models;
use rmrevin\yii\module\Comments\interfaces\CommentatorInterface;
use rmrevin\yii\module\Comments\models\Comment;
use rmrevin\yii\module\Comments;
use common\models\User;
/**
 * Class User
 * @package rmrevin\yii\module\Comments\tests\unit\models
 */
class CommentUser extends  \yii\db\ActiveRecord implements CommentatorInterface
{

	
	public static function tableName()
    {
        return 'user';
    }


    /**
     * @return string|false
     */

    public function getCommentatorAvatar()
    {
        return '';
    }


    /**
     * @return string
     */
    public function getCommentatorName()
    {
        return "user name";
    }

    /**
     * @return string|false
     */
    public function getCommentatorUrl()
    {
        return '';
    }


        public function getUserName($created_by)
        {
            
            $user = User::find()
                         ->where(['id' => $created_by])
                         ->one();
            
            return "($user->username)";
        }




}