<?php
use yii\widgets\LinkPager;
use common\models\Files;
use common\models\FilesUsage;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = $ad->title;
?>
<div class="site-index">

    <div class="jumbotron text-center">
    <div class="row text-center slideanim">
        <?php
        $f=0;

            $files_usage = FilesUsage::find()
                ->where(['entity_id' => $ad->id,'entity_type' => 'ad'])
                ->one();
            $file = Files::find()
                ->where(['id' => $files_usage->file_id])
                ->one();



            ?>
        <div class="col-sm-8">
            <div class="thumbnail">
                <img src="/frontend/web/<?= $file->path ?>"  width="400" height="300" alt="pic_<?= $f ?>">
                <h3><?= $ad->title ?></h3>
                <p> <h2><?= $ad->price ?> $</h2></p>
                <hr />
                <p class="left"><?= $ad->description ?> </p>
            </div>
        </div>

        <?php
        $files_usage = FilesUsage::find()
            ->where(['entity_id' => $profile->id,'entity_type' => 'profile'])
            ->one();
        $file = Files::find()
            ->where(['id' => $files_usage->file_id])
            ->one();

        $url='/profile-ads/'.($profile->id);
        Yii::setAlias('@myCssAlias', $url);
        ?>

        <div class="col-sm-4">
            <div class="thumbnail">
                <img src="/frontend/web/<?= $file->path ?>"  width="400" height="300" alt="pic_1">
                <h3><?= $profile->fio ?></h3>
                <p> <h3>Телефон:<?= $profile->phone ?> </h3></p>
                <p> <?= Html::a('Все объявления этого пользователя', Yii::getAlias('@myCssAlias'), ['class' => 'button9']) ?> </p>

            </div>
        </div>

    </div>
    </div>




</div>