<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-order-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'pk_int_order_id',
            'pk_int_product_id',
            'vchr_item_name', 
            'int_quantity',
            [
            'label'=>'Price',
            'format' => 'raw',
            'value' => function ($dataProvider) {
                $total=0;
                $price=(int)$dataProvider['int_item_price'];
                $quantity=(int)$dataProvider['int_quantity'];
                for($i=1;$i<=$quantity;$i++)
                {
                    $total = $total + $price;
                }
                return $total;
            },
            ],
            'vchr_status', 
            // 'fk_int_size_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
