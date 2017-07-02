<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\TblCustomers */

$this->title = $model->vchr_item_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-customers-view">
    <?php
    $this->registerCss("
                                        .round-corners {
                                            border-radius: 25px;
                                            // background: #c3c388;
                                            padding: 20px;
                                            display: inline-block;
                                            border:4px solid #aaaa55;
                                        }
                                        .round-corners-img {
                                            border-radius: 25px;
                                            background: #c3c388;
                                            padding: 20px;
                                            display: inline-block;
                                            border:4px solid #aaaa55;
                                        }
                       ");
    ?>
    <p>
    <script>
        function readCookie(name) {
          alert(document.cookie);
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
    </script>



        <?php 


        $form = ActiveForm::begin([
    'id' => 'login-form', 
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
    'action' => Url::to("index.php?r=customer/buy-cart&id=$model->pk_int_product_id"),
     'method' => 'post',
]); ?>
    </p>
    <div class="row"></div>
    <div id="content" class="row" style="text-align: center;">
        <div class="round-corners">
           <?= Html::img($model->product_pic , ['width'=>350]);?>
           <?php
                        $price=$model->int_item_price;

           echo "<div id='storing' style='visibility:hidden;'>".$price."</div>";
           echo "<br>";
            
            echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'pk_int_product_id',
                  'vchr_item_name',
                  'fkIntCategory.vchr_category_name',
                  'fkIntSubCategory.vchr_sub_category_name',
                   [
                      'label'=>'Price/Piece',
                      'value'=>function($model)
                      {
                          return $model->int_item_price.'/- Rs';
                      },
                   ],
                  // 'vchr_description:ntext',
                  ]]);
           
                $i=0;
                $m='';
                $pieces = explode(" ", $model->vchr_description);
                foreach ($pieces as $key => $value) {
                    $m=$m.' '.$value;
                    $i+=1;
                    if($i>9)
                    {
                        $i=0;
                        $m.=' <br>';
                    }
                }
                echo '<h4 style="text-align:left;text-decoration:underline;"><b>Description</b></h4>';
              echo $m.' <br>';  
              ?>
              <div style="text-align: left;"> 
              <?php
              echo $form->field($model, 'fk_int_product_varients')->radioList($sizes, ['inline'=>true])->label('Size');
              // echo $form->field($model, 'int_quantity')->label('Quantity')->widget(Select2::classname(), 
              //       [
              //             'name' => 'combo',
              //         'data' => [1 => '1', 2 => "2", 3 => "3", 4 => "4", 5 => "5",6 => '6', 7 => "7", 8 => "8", 9 => "9", 10 => "10"],
              //         'language' => 'en',
              //         'options' => ['placeholder' => 'Select Size...'],
              //         'pluginOptions' => [
              //         'allowClear' => true
              //             ],
              //             'pluginEvents' => [
              //                             "change" => "function() 
              //                             { 
              //                               var elem=document.getElementById('changable'); 
              //                               var quantity=$(this).val();
              //                               var name='price';
              //                               var price=document.getElementById('storing').textContent;
              //                               // alert(price);
              //                               var amount=parseInt(price);
              //                               var tot=quantity*amount;
              //                               // alert(tot);
              //                               elem.innerHTML = 'Total '+ tot +' /- Rs';
              //                             }",
              //                             ],
              //     ]);
                echo "<div style='display:inline;'>";
                echo '<label class="control-label">Quantity</label>';
                echo TouchSpin::widget([
                    'model' => $model,
                    'attribute' => 'int_quantity',
                    'options' => ['placeholder' => 'Select quantity','size' => 1,'id'=>'prd_qty',],
                    'pluginOptions' => [
                          'initval' => 1,
                          'min' => 1,
                          'max' => 10,
                          'verticalbuttons'=> true,
                          'verticalupclass'=> 'glyphicon glyphicon-plus',
                          'verticaldownclass'=> 'glyphicon glyphicon-minus',
                      ],
                       'pluginEvents' => [
                                          "change" => "function() 
                                          { 
                                            var elem=document.getElementById('changable'); 
                                            var quantity=$(this).val();
                                            var name='price';
                                            var price=document.getElementById('storing').textContent;
                                            // alert(price);
                                            var amount=parseInt(price);
                                            var tot=quantity*amount;
                                            // alert(tot);
                                            elem.innerHTML = 'Total '+ tot +' /- Rs';
                                          }",
                                          ],
                ]);
                echo "</div>";
              echo "<h5 id='changable'  style='text-align: center;'>Total ".$model->int_item_price."/- Rs</h5>";
              echo "<div style='text-align: center;'>";
              echo Html::submitButton('Add to cart', ['class' => 'btn btn-primary','name' => 'user_action', 'value' => 'cart']);
              echo "&nbsp;&nbsp;";
              echo Html::submitButton('Buy', ['class' => 'btn btn-primary','name' => 'user_action', 'value' => 'buy']);
              echo "</div>";
              ActiveForm::end();
                ?>
        </div>
        </div>
    </div>


</div>
