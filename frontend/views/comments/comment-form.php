<?php
/**
 * comment-form.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var Comments\forms\CommentCreateForm $CommentCreateForm
 */

use rmrevin\yii\module\Comments;
use yii\helpers\Html;

/** @var Comments\widgets\CommentFormWidget $Widget */
$Widget = $this->context;

?>

<a name="commentcreateform"></a>

        <?php
        /** @var \yii\widgets\ActiveForm $form */
        $form = \yii\widgets\ActiveForm::begin();

        echo Html::activeHiddenInput($CommentCreateForm, 'id');

        $options = [];
        if ($Widget->Comment->isNewRecord) {
            $options['data-role'] = 'new-comment';
        }
         $options['class'] = 'form-control';
            $options['id'] = 'comment';
            $options['rows'] = '5';

?>

         <div class="form-group row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php

        echo $form->field($CommentCreateForm, 'text')
            ->textarea($options)->label(false);

        ?>
         </div>
         </div>

    
         <div class="btn-block">
            <?php
            echo Html::submitButton(\Yii::t('app', 'Добавить комментарий'), [
                'class' => 'btn btn-success btn-lg',
            ]);
            echo Html::resetButton(\Yii::t('app', 'Отмена'), [
                'class' => 'btn  btn-default btn-lg cancel',
            ]);
            ?>
        </div>
        <?php
        \yii\widgets\ActiveForm::end();
        ?>
    