<?php
use yii\widgets\LinkPager;
use common\models\Files;
use common\models\FilesUsage;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */


?>


    <div class="row text-center slideanim">
        <?php
        if(empty($ads)){
           echo ('Результаты не найдены! Попробуйте выбрать другую подкатегорию');
        }

        $f=0;
        foreach($ads as $ad)
        {
            $files_usage = FilesUsage::find()
                ->where(['entity_id' => $ad->id,'entity_type' => 'ad'])
                ->one();
            $file = Files::find()
                ->where(['id' => $files_usage->file_id])
                ->one();

            $url='/ad-details/'.($ad->id);
            Yii::setAlias('@myCssAlias', $url);

            ?>
        <div class="col-sm-4">
            <div class="thumbnail">
                <img src="/frontend/web/<?= $file->path ?>"  width="400" height="300" alt="pic_<?= $f ?>">
                <h3><?= \yii\helpers\StringHelper::truncate($ad->title,20,'...') ?></h3>
                <p> <h2><?= $ad->price ?> $</h2></p>
                <p> <?= Html::a('Подробнее', Yii::getAlias('@myCssAlias'), ['class' => 'button9']) ?> </p>
            </div>
        </div>
        <?php $f++; } ?>
    </div>


    <div class="jumbotron text-center">

    <?php
    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);

    ?>
    </div>



