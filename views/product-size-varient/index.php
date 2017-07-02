<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblSearchProductSizeVarients */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Product Size Variants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-product-size-variants-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Product Size Variants', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'pk_int_product_size_variants_id',
            'fkIntCategory.vchr_category_name',
            'fkIntSubCategory.vchr_sub_category_name',
            'vchr_size_names',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
