<?php

namespace console\controllers;
use yii;
use common\models\AdRule;
use yii\console\Controller;

class RbacController extends Controller
{
  public function actionInit()
    {
        $auth = Yii::$app->authManager;

		// add the rule
		$rule = new AdRule;
		$auth->add($rule);

		// добавляем разрешение "updateOwnPost" и привязываем к нему правило.
		$updateOwnPost = $auth->createPermission('updateOwnAd');
		$updateOwnPost->description = 'Update own ad';
		$updateOwnPost->ruleName = $rule->name;
		$auth->add($updateOwnPost);

		// "updateOwnPost" будет использоваться из "updatePost"
		$auth->addChild($updateOwnPost, 'ad.update');

		// разрешаем "автору" обновлять его посты
		$auth->addChild('advertiser', $updateOwnPost);
			
	}
}
