<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Files;
use common\models\FilesUsage;


/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $profile->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $profile->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>




    <div class="jumbotron text-center">
        <div class="row text-center slideanim">



            <?php
            $files_usage = FilesUsage::find()
                ->where(['entity_id' => $profile->id, 'entity_type' => 'profile'])
                ->one();
            $file = Files::find()
                ->where(['id' => $files_usage->file_id])
                ->one();

            $url = '/ad';
            Yii::setAlias('@myCssAlias', $url);
            ?>


                <div class="thumbnail">
                  
					<?php echo Html::img('@web'.$file->path, ["width"=>400, "height"=>300, "alt"=>"pic_1"]) ?>
                    <h3><?= $profile->fio ?></h3>
                    <p>Email: <?= $profile->user->email ?> </p>
                    <p>Логин: <?= $profile->user->username ?> </p>
                    <h3>Телефон: <?= $profile->phone ?> </h3>
                    <p>Адрес: <?= $profile->address ?> </p>
                    <p> <?= Html::a('Мои объявления', Yii::getAlias('@myCssAlias'), ['class' => 'button9']) ?> </p>
                </div>


        </div>
    </div>


</div>
