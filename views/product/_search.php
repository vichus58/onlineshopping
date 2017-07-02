<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblSearchProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pk_int_product_id') ?>

    <?= $form->field($model, 'fk_int_category_id') ?>

    <?= $form->field($model, 'fk_int_sub_category_id') ?>

    <?= $form->field($model, 'vchr_item_name') ?>

    <?= $form->field($model, 'int_item_price') ?>

    <?php // echo $form->field($model, 'vchr_description') ?>

    <?php // echo $form->field($model, 'product_pic') ?>

    <?php // echo $form->field($model, 'int_quantity') ?>

    <?php // echo $form->field($model, 'fk_int_product_varients') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
