<?php
use yii\widgets\LinkPager;
use common\models\Files;
use common\models\FilesUsage;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Доска объявлений';
?>
<div class="site-index">
    <div class="jumbotron text-center">
    <div class="row text-center slideanim">
        <?php foreach($categories as $category){ ?>
        <div class="col-sm-3">
            <span class="cat_name s1" data-catid="<?= $category->id ?>">  <?php echo $category->name; ?> </span>
        </div>
        <?php  } ?>


    </div>
        <div class="container text-center  subcats">

        </div>
    </div>
    <div class=" text-center load">
        <!--<img src="/frontend/web/uploads/loading.gif"  width="50" height="50"  alt="loading">-->
		<?php echo Html::img('@web/uploads/loading.gif', ["alt"=>"loading","width"=>"50", "height"=>"50"]) ?>
    </div>
    <br />

    <hr />
    <div class="ajax_ad">
    <div class="row text-center slideanim">
        <?php
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
               <?php //echo Html::img(Yii::$app->urlManager->createUrl($file->path)); ?>
				<?php echo Html::img('@web'.$file->path, ["width"=>400, "height"=>300, "alt"=>"pic_$f"]) ?>
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
    </div>

</div>
