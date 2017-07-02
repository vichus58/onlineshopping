<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblSearchSubCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Sub Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-sub-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Sub Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'pk_int_sub_category_id',
            'fkIntCategory.vchr_category_name',
            // 'fk_int_category_id',
            'vchr_sub_category_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
