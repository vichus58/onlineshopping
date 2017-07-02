<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblProductSizeVariants */

$this->title = 'Create Tbl Product Size Variants';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Product Size Variants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-product-size-variants-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category_name' => $category_name,
    ]) ?>

</div>
