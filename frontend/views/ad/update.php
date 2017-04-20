<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = 'Изменение объявления: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Все объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'picture' => $picture,
        'files_usage' => $files_usage,
    ]) ?>

</div>
