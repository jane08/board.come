<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategory */
/* @var $form yii\widgets\ActiveForm */


$сategory = ArrayHelper::map(Category::find()->all(), 'id', 'name');	

?>

<div class="sub-category-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php
		echo $form->field($model, 'category_id')->dropDownList($сategory,['prompt' => 'Выберите категорию','class'=>'form-control']); 
	?>

   

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
