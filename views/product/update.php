<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblProduct */

$this->title = 'Update Tbl Product: ' . $model->pk_int_product_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pk_int_product_id, 'url' => ['view', 'id' => $model->pk_int_product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
