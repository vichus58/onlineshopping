<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblSearchCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'pk_int_category_id',
            'vchr_category_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
    </div>
</div>
