<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

/*$this->title = 'Update Profile: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="profile-update">

    <h1>Мой профиль</h1>

    <?= $this->render('_form', [
        'model' => $model,
		'picture' => $picture,
		'files_usage' => $files_usage,
    ]) ?>

</div>
