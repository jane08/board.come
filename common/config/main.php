<?php
use \rmrevin\yii\module\Comments\Permission;
use \rmrevin\yii\module\Comments\rbac\ItsMyComment;



return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [ 'class' => 'frontend\components\DbManager', 'defaultRoles' => ['guest'], ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@vendor/rmrevin/yii2-comments/widgets/views' => '@frontend/views/comments', // example: @app/views/comment/comment-form.php
                ],
            ],
        ],
    ],
    'modules' => [
        'comments' => [
            'class' => 'rmrevin\yii\module\Comments\Module',
            'userIdentityClass' => 'backend\models\CommentUser',
            'useRbac' => true,
        ]
    ],
];
