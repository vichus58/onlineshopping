<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblCategory;
use app\models\TblSubCategory;
use app\models\TblProductSizeVariants;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TblProductSizeVariants */
/* @var $form yii\widgets\ActiveForm */
?>





<div class="tbl-product-size-variants-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'fk_int_category_id')->textInput() ?>
     <?= $form->field($model, 'fk_int_category_id')->dropDownList(
            ArrayHelper::map(TblCategory::find()->all(), 'pk_int_category_id','vchr_category_name'),
            ['prompt'=> 'Select a category',
             'onchange'=>'
                    $.post("index.php?r=sub-category/get-sub-category&id='.'"+$(this).val(), function(data){
                        //alert(data);
                            $("select#tblproductsizevariants-fk_int_sub_category_id").html(data);
                    });',       
            ]) ?>

    <?= $form->field($model, 'fk_int_sub_category_id')->dropDownList(ArrayHelper::map(TblSubCategory::find()->all(), 'pk_int_sub_category_id','vchr_sub_category_name'),['prompt'=> 'Select Sub category']) ?>

    <?php // $form->field($model, 'fk_int_sub_category_id')->textInput() ?>

    <?= $form->field($model, 'vchr_size_names')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
