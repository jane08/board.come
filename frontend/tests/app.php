<?php
namespace tests;

use common\models\User;
require(__DIR__ . '/_bootstrap.php');

$user = new User();

//$user->username = 'Eliot';
$user->email = 'el@mail.ru';

print_r($user->getAttributes());

if(empty($user->username)){
    echo" fail ";
}
else{
    echo "ok";
}

//echo Yii::$app->name . PHP_EOL;