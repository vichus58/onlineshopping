<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblCategory;
use app\models\TblSubCategory;
use app\models\TblProductSizeVariants;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\TblProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_int_category_id')->dropDownList(
            ArrayHelper::map(TblCategory::find()->all(), 'pk_int_category_id','vchr_category_name'),
            ['prompt'=> 'Select a category',
             'onchange'=>'
                    $.post("index.php?r=sub-category/get-sub-category&id='.'"+$(this).val(), function(data){
                        //alert(data);
                            $("select#tblproduct-fk_int_sub_category_id").html(data);
                    });',       
            ]) ?>

    <?= $form->field($model, 'fk_int_sub_category_id')->dropDownList(
            ArrayHelper::map(TblSubCategory::find()->all(), 'pk_int_sub_category_id','vchr_sub_category_name'),
            ['prompt'=> 'Select Sub category',
                'onchange'=>'
                    $.post("index.php?r=product-size-varient/get-size&id='.'"+$(this).val(), function(data){
                    //alert(data);
                            $("select#tblproduct-fk_int_product_varients").html(data);
                    });',
            ]) ?>

    <?= $form->field($model, 'fk_int_product_varients')->dropDownList(
            ArrayHelper::map(TblProductSizeVariants::find()->all(), 'pk_int_product_size_variants_id','vchr_size_names'),
            ['prompt'=> 'Select Product Size']) ?>

    <?php //$form->field($model, 'file')->fileInput();//['multiple' => true]) ?>
    <?=
     $form->field($model, 'file')->widget(FileInput::classname(),
     [
        'options' => ['multiple' => false, 'accept' => 'image/*'],
        'pluginEvents' => [
            'change' => 'function(event) {
                //alert("File changed");
            }'
        ]
    ])->label('Product picture');
    ?>

    <?= $form->field($model, 'vchr_item_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'int_item_price')->textInput() ?>

    <?= $form->field($model, 'int_quantity')->textInput() ?>

    <?= $form->field($model, 'vchr_description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
