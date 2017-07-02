<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblProductSizeVariants */

$this->title = 'Update Tbl Product Size Variants: ' . $model->pk_int_product_size_variants_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Product Size Variants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pk_int_product_size_variants_id, 'url' => ['view', 'id' => $model->pk_int_product_size_variants_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-product-size-variants-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
