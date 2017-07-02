<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblUsers */
/* @var $form ActiveForm */
$this->title="Sign up";
?>
<div class="site-signup">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'vchr_name') ?>
         <?php
         echo $form->field($model, 'vchr_gender')->dropDownList(['Male' => 'Male', 'Female' => 'Female'],['prompt'=>'Select Gender']);
        ?>
        <?= $form->field($model, 'vchr_mobile') ?>
        <?= $form->field($model, 'vchr_email') ?>
        <?= $form->field($model, 'vchr_password')->passwordInput() ?>
        <?= $form->field($model, 'text_address')->textArea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Sign up', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-signup -->
