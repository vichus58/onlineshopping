<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="site-user">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'pk_int_user_id') ?>
        <?= $form->field($model, 'int_ac_lock') ?>
        <?= $form->field($model, 'vchr_fst_name') ?>
        <?= $form->field($model, 'vchr_lst_name') ?>
        <?= $form->field($model, 'vchr_email') ?>
        <?= $form->field($model, 'vchr_password') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-user -->
