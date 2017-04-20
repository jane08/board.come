<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use common\models\SubCategory;
use yii\helpers\ArrayHelper;
use common\models\Files;
use common\models\FilesUsage;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */

$сategory = ArrayHelper::map(Category::find()->all(), 'id', 'name');
$sub_category = ArrayHelper::map(SubCategory::find()->all(), 'id', 'name');
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
		echo $form->field($model, 'category_id')->dropDownList($сategory,['prompt' => 'Выберите категорию','class'=>'form-control category']); 
	?>
	
	 <?php
		echo $form->field($model, 'subcategory_id')->dropDownList($sub_category,['prompt' => 'Выберите подкатегорию','class'=>'form-control subcat']);
	?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <!-- Для нескольких -->
    <?php //echo $form->field($picture, 'file[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])
    echo FileInput::widget([
        'model' => $picture,
        'attribute' => 'file[]',
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'browseLabel' => 'Выберите картинку',
            'removeLabel' => '',
            'removeClass' => 'btn btn-danger',
            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
            'showUpload' => false
        ],

    ]);

    ?>

    <br />

    <div class='files_usage'>
        <?php
        if(isset($files_usage)){
            foreach ($files_usage as $fls => $fs) {

                $files = Files::find()
                    ->where(['id' => $fs->file_id])
                    ->one();



                echo Html::img('/frontend/web'.$files->path ,['class'=>'img_size']);

            }
        }
        ?>

    </div>
    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
