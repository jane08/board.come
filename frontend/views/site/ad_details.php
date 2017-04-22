<?php
use yii\widgets\LinkPager;
use common\models\Files;
use common\models\FilesUsage;
use yii\helpers\Html;
use rmrevin\yii\module\Comments;

use yii\web\JsExpression;

/* @var $this yii\web\View */

$this->title = $ad->title;
?>

<style>
    /****** Rating Starts *****/
    @import url(http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

</style>
<div class="site-index">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <div class="jumbotron text-center">
        <div class="row text-center slideanim">
            <?php
            $f = 0;

            $files_usage = FilesUsage::find()
                ->where(['entity_id' => $ad->id, 'entity_type' => 'ad'])
                ->one();
            $file = Files::find()
                ->where(['id' => $files_usage->file_id])
                ->one();


            ?>
            <div class="col-sm-8">
                <div class="thumbnail">
                    <img src="/frontend/web/<?= $file->path ?>" width="400" height="300" alt="pic_<?= $f ?>">
                    <h3><?= $ad->title ?></h3>
                    <p>
                    <h2><?= $ad->price ?> $</h2></p>
                    <hr/>
                    <p class="left"><?= $ad->description ?> </p>
                </div>

                <!-- Comments -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            Комментарии
                            </div>
                            <div class="panel-body">
                                <?php
                                echo Comments\widgets\CommentListWidget::widget([
                                    'entity' => (string)'ad-' . $ad->id, // type and id


                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $files_usage = FilesUsage::find()
                ->where(['entity_id' => $profile->id, 'entity_type' => 'profile'])
                ->one();
            $file = Files::find()
                ->where(['id' => $files_usage->file_id])
                ->one();

            $url = '/profile-ads/' . ($profile->id);
            Yii::setAlias('@myCssAlias', $url);
            ?>

            <div class="col-sm-4">
                <div class="thumbnail">
                    <img src="/frontend/web/<?= $file->path ?>" width="400" height="300" alt="pic_1">
                    <h3><?= $profile->fio ?></h3>

                    <h3>Телефон:<?= $profile->phone ?> </h3>
                    <p> <?= Html::a('Все объявления этого пользователя', Yii::getAlias('@myCssAlias'), ['class' => 'button9']) ?> </p>

                </div>



                <div class="rate center">
                            <h3>Оцените этого пользователя</h3>

                    <?php

                    $rate=0;
                    $count=0;
                    foreach($rating as $r)
                    {
                        $rate+=$r->rate;
                        $count++;
                       // echo $count;
                    }
                    if($count!=0) {
                        $rate = round($rate / $count);
                    }



                   $filled=$rate;
                    $titles =[
                        5 => "Классно - 5 звёзд",
                        4 => "Очень хорошо - 4 звезды",
                        3 => "Не плохо - 3 звезды",
                        2 => "Довольно плохо - 2 звезды",
                        1 => "Плохо - 1 звезда",
                    ];

                    $current_user= Yii::$app->user->identity->id;
                    ?>



                     <h3 class="center ajax_rate">
                             <fieldset id='demo1' class="rating">

                                 <?php for($f=5; $f>0; $f--) { ?>
                                <?php
                                     if($filled>=$f){
                                     $class='filled';
                                     }
                                     else{
                                     $class='not_filled';
                                     }
                                  ?>
                                <input data-user="<?= $profile->user_id ?>" data-currentuser="<?=  $current_user ?>" data-status="<?= $rateuser->status ?>" class="stars <?= $class ?>" type="radio" id="star<?= $f ?>" name="rating" value="<?= $f ?>" />
                                 <label class = "full <?= $class ?>" for="star<?= $f ?>" title="<?= $titles[$f] ?>"></label>
                                <!-- <input class="stars <?/*= $class */?>" type="radio" id="star5" name="rating" value="5" />
                                 <label class = "full <?/*= $class */?>" for="star5" title="Awesome - 5 stars"></label>
                                 <input class="stars <?/*= $class */?>" type="radio" id="star4" name="rating" value="4" />
                                 <label class = "full <?/*= $class */?>" for="star4" title="Pretty good - 4 stars"></label>
                                 <input class="stars <?/*= $class */?>" type="radio" id="star3" name="rating" value="3" />
                                 <label class = "full <?/*= $class */?>" for="star3" title="Meh - 3 stars"></label>
                                 <input class="stars <?/*= $class */?>" type="radio" id="star2" name="rating" value="2" />
                                 <label class = "full <?/*= $class */?>" for="star2" title="Kinda bad - 2 stars"></label>
                                 <input class="stars <?/*= $class */?>" type="radio" id="star1" name="rating" value="1" />
                                 <label class = "full <?/*= $class */?>" for="star1" title="Sucks big time - 1 star"></label>-->

                                <?php } ?>
                             </fieldset>
                      </h3>

                </div>

            </div>

        </div>
    </div>


</div>
