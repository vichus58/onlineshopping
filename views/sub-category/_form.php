<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TblSubCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-sub-category-form">

    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'fk_int_category_id')->label('Category Name')->widget(Select2::classname(), 
    	[
            'name' => 'combo',
		    'data' => $category_name,
		    'language' => 'en',
		    'options' => ['placeholder' => 'Select Category...'],
		    'pluginOptions' => [
		    'allowClear' => true
		        ],
            // 'pluginEvents' => [
            //                 "change" => "function() { Ajax($(this).val()); }",//log('change')
            //                 // "select2:opening" => "function() { log('select2:opening'); }",
            //                 // "select2:open" => "function() { log('open'); }",
            //                 // "select2:closing" => "function() { log('close'); }",
            //                 // "select2:close" => "function() { log('close'); }",
            //                 // "select2:selecting" => "function() { log('selecting'); }",
            //                 // "select2:select" => "function() { log('select'); }",
            //                 // "select2:unselecting" => "function() { log('unselecting'); }",
            //                 // "select2:unselect" => "function() { log('unselect'); }"
            //                 ],
		]);
    ?>

    <?php //$form->field($model, 'fk_int_category_id')->textInput() ?>

    <?= $form->field($model, 'vchr_sub_category_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
