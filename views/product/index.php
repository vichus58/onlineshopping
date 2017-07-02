<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblSearchProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'pk_int_product_id',
            'fkIntCategory.vchr_category_name',
            'fkIntSubCategory.vchr_sub_category_name',
            'vchr_item_name',
            'fkIntProductVarients.vchr_size_names',
            'int_item_price',
            // 'vchr_description:ntext',
            // 'product_pic',
            // 'int_quantity',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
