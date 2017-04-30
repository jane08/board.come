<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Files;
use common\models\FilesUsage;
/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Все объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить это объявление?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
           // 'user_id',
            'sub.name',
            'title',
            'description:ntext',
            'price',
            'created_at',
            'updated_at',
        ],
    ]) ?>
   
   <?php
   $files_usage = FilesUsage::find()
            ->where(['entity_id' => $model->id, 'entity_type' => 'ad'])
            ->one();
	if(isset( $files_usage)){		
        $file = Files::find()
            ->where(['id' => $files_usage->file_id])
            ->one();
			$path='@web'.$file->path;
	}
	else{
			$path= '@web/uploads/ad.jpg';
	}
   ?>
   
	<?php echo Html::img($path, ["width"=>400, "height"=>300, "alt"=>"pic_1"]) ?>
</div>
