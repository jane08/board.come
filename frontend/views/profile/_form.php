<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Files;
use common\models\FilesUsage;
use kartik\file\FileInput;
use frontend\assets\AddressAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

   

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true , 'encode'=>true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'id'=>'autocomplete', 'onFocus'=>'geolocate()']) ?>
	
	 <!-- Для нескольких -->
    <?php //echo $form->field($picture, 'file[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) 
		echo FileInput::widget([
				'model' => $picture,
				'attribute' => 'file[]',
				'options' => ['multiple' => true],
				    'pluginOptions' => [
						'browseLabel' => 'Выберите своё фото',
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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- Auto complete addresses script -->

<?php
AddressAsset::register($this);
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG8UcqzVNCTcovPhkz9D-LwzLdUKPojzk&libraries=places&callback=initAutocomplete"
        async defer></script>