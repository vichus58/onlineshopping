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
        // 'rowOptions' => function ($dataProvider) {
        //       if ($dataProvider['pk_int_status_id'] == '1') {
        //           return ['style' => 'background-color:#F25050;'];
        //       }
        //       if ($dataProvider['pk_int_status_id'] == '2') {
        //           return ['style' => 'background-color:#ffff40;'];
        //       }
        //       if ($dataProvider['pk_int_status_id'] == '3') {
        //           return ['style' => 'background-color:#3EACFF;'];
        //       }
        //       if ($dataProvider['pk_int_status_id'] == '4') {
        //           return ['style' => 'background-color:#4AE54A;'];
        //       }
        //   },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'pk_int_order_id',
            'date_date', 
            // 'fk_int_size_id',

                          [
                          //changing default action column to delete and update
                          'class' => 'yii\grid\ActionColumn',
                          //heading of the action column
                          'header' => 'Actions',
                          'headerOptions' => ['style' => 'color:#000000','style' => 'width:20%'],//'color:#337ab7'],
                          'footer' => '',
                          //buttons update,delete,view
                          'template' => '{view}',//{delete}',
                          'buttons' => [
                                         'view' => function ($url, $dataProvider) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open blue"></span>', $url, [
                                                        'title' => Yii::t('app', 'update'),
                                            ]);
                                         },
                                      ],
                          'urlCreator' => function ($action, $dataProvider, $key, $index) {
                            if ($action === 'view') {
                                $url ='index.php?r=order/view&id='.$dataProvider['pk_int_order_id'];
                                return $url;
                            }
                          }
                          ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
