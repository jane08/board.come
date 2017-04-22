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
                        3 => "Не пдохо - 3 звезды",
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




