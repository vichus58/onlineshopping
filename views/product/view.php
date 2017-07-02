<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblProduct */

$this->title = $model->pk_int_product_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pk_int_product_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pk_int_product_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pk_int_product_id',
            'fkIntCategory.vchr_category_name',
            'fkIntSubCategory.vchr_sub_category_name',
            'vchr_item_name',
            'int_item_price',
            'vchr_description:ntext',
            [
                'attribute' => 'image',
                'format' => 'html',    
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@web').'/'.$model->product_pic,
                        ['width' => '250px']);
                },
            ],
            // 'product_pic',
            'int_quantity',
            'fk_int_product_varients',
        ],
    ]) ?>

</div>
