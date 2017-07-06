<?php
use kartik\touchspin\TouchSpin;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\TblProductSize; 




$this->params['breadcrumbs'][] = ['label' => 'View Item', 'url' => ['index']];                       

    $this->registerCss("
                            a {
                                color: #000000;
                            }
                       ");
    ?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="container">

<?php foreach ($models as $model) { ?>
   <div class="row">
      <div class="col-md-6">
        <figure>
                <img src=<?= "'".$model->fkIntProduct->product_pic."'"?> class="image-responsive" alt=<?= $model->fkIntProduct->vchr_item_name ?> width="500" ><!--- height="400"> -->
           </figure>
      </div>
      <div class="col-md-6">
      <div class="row">
                <div class="col-md-12">
                    <header>
                        <hgroup>
                            <h1><?= $model->fkIntProduct->vchr_item_name ?></h1>
                        </hgroup>
                    </header>
                </div></div>
                <div class="row">
                <div class="col-md-12" align="left">
                      <span class="label label-info">Item No</span>
                      <span class="monospaced"><b><?= $model->fkIntProduct->pk_int_product_id?></b></span>
                
            </div><!-- end row --></div>
              <div class="row" id="product-price">
                <div class="col-md-12 inline-headers" align="left" id="storing">
                <h4>Total Rs.</h4><?=$model->fkIntProduct->int_item_price*$model->int_quantity."/-" ?>
                </div></div>
                 <div class="row">
                  <div class="col-md-12" align="left">
                

                  
                      <p><span class="badge">Quantity</span>
                      <span class="monospaced"><b><?= $model->int_quantity ?></b></span></p>
                   
                  
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 inline-headers" align="left">
                

                  <?php
                    if($model->fkIntSize->pk_int_product_size_variants_id!=null)
                    {
                      ?><h4>Size</h4><span class="btn btn-warning"><?= $model->fkIntSize->vchr_size_names ?></span>
                    <?php } ?></div></div>
                    
                     <!-- <div class="row">
                    <div class="col-md-4" align="left">
                    
                    <h4>Select quantity</h4>
                    
            
                    
                    
                </div>
                  
                  </div> -->
             <div class="row">
             <div class="col-md-8">
                
                </div>
                <div class="col-lg-6">


                <br>
                <h4>Status</h4>
                <div class="row">
                    <div class="col-lg-6">

                    <?php if($model->fkIntStatus->vchr_status=='Pending')
                    { ?>
                        <a class = "btn btn-colour-special" style="padding: 2px;width: 50%;" id="btnpending<?= $model->pk_int_order_detail_id ?>">Pending</a> 
                    <?php }else { ?>
                        <a class = "btn btn-colour-regular" style="padding: 2px;width: 50%;" id="btnpending<?= $model->pk_int_order_detail_id ?>">Pending</a>
                    <?php } ?>

                    <?php if($model->fkIntStatus->vchr_status=='Packed')
                    { ?>
                        <a class = "btn btn-colour-special" style="padding: 2px;width: 46%;" id="btnpacked<?= $model->pk_int_order_detail_id ?>">Packed</a>
                    <?php }else { ?>
                        <a class = "btn btn-colour-regular" style="padding: 2px;width: 46%;" id="btnpacked<?= $model->pk_int_order_detail_id ?>">Packed</a>
                    <?php } ?>

                    </div>
                </div>
                <div class="row" style="padding-top: 3px;">
                    <div class="col-lg-6">

                    <?php if($model->fkIntStatus->vchr_status=='Shipped')
                    { ?>
                        <a class = "btn btn-colour-special" style="padding: 2px;width: 50%;" id="btnshipped<?= $model->pk_int_order_detail_id ?>">Shipped</a>
                    <?php }else { ?>
                        <a class = "btn btn-colour-regular" style="padding: 2px;width: 50%;" id="btnshipped<?= $model->pk_int_order_detail_id ?>">Shipped</a>
                    <?php } ?>

                    <?php if($model->fkIntStatus->vchr_status=='Arrived')
                    { ?>
                        <a class = "btn btn-colour-special" style="padding: 2px;width: 46%;" id="btnarrived<?= $model->pk_int_order_detail_id ?>">Arrived</a>
                    <?php }else { ?>
                        <a class = "btn btn-colour-regular" style="padding: 2px;width: 46%;" id="btnarrived<?= $model->pk_int_order_detail_id ?>">Arrived</a>
                    <?php } ?>

                    </div>
                <div id="successalert<?= $model->pk_int_order_detail_id ?>"></div>
                                   
    
                </div> 
                <br>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script type="text/javascript">
                   
                  $(document).ready(function(){
                    $("#btnpending<?= $model->pk_int_order_detail_id ?>").click(function(){
                        $("#successalert<?= $model->pk_int_order_detail_id ?>").load("index.php?r=order/ajax&id=<?= $model->pk_int_order_detail_id ?>&status=1");
                        $("#btnpending<?= $model->pk_int_order_detail_id ?>").css("background-color", "#30cb00"); 
                        $("#btnpacked<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");
                        $("#btnshipped<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");
                        $("#btnarrived<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");     
                    });
                    $("#btnpacked<?= $model->pk_int_order_detail_id ?>").click(function(){
                        $("#successalert<?= $model->pk_int_order_detail_id ?>").load("index.php?r=order/ajax&id=<?= $model->pk_int_order_detail_id ?>&status=2");
                        $("#btnpending<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE"); 
                        $("#btnpacked<?= $model->pk_int_order_detail_id ?>").css("background-color", "#30cb00");
                        $("#btnshipped<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");
                        $("#btnarrived<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");       
                    });
                    $("#btnshipped<?= $model->pk_int_order_detail_id ?>").click(function(){
                        $("#successalert<?= $model->pk_int_order_detail_id ?>").load("index.php?r=order/ajax&id=<?= $model->pk_int_order_detail_id ?>&status=3");
                        $("#btnpending<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE"); 
                        $("#btnpacked<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");
                        $("#btnshipped<?= $model->pk_int_order_detail_id ?>").css("background-color", "#30cb00");
                        $("#btnarrived<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");       
                    });
                    $("#btnarrived<?= $model->pk_int_order_detail_id ?>").click(function(){
                        $("#successalert<?= $model->pk_int_order_detail_id ?>").load("index.php?r=order/ajax&id=<?= $model->pk_int_order_detail_id ?>&status=4");
                        $("#btnpending<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE"); 
                        $("#btnpacked<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");
                        $("#btnshipped<?= $model->pk_int_order_detail_id ?>").css("background-color", "#5BC0DE");
                        $("#btnarrived<?= $model->pk_int_order_detail_id ?>").css("background-color", "#30cb00");       
                    });
                });
                </script>


            </div>
            </div>
      <!-- // var price = <?php //echo $priceactual; ?>; 
                                            // alert(price);
                                            // var quantity=$(this).val();
                                            // var name="price";
                                            // price=document.getElementById("storing").textContent;
                                            // //alert(price);
                                            // //var amount=parseInt(price);
                                            // //var tot=quantity*amount;
                                            // //alert(tot);
                                            // //elem.innerHTML = "Total "+ tot +"" /- Rs";
             -->
             <div class="row">
             <div class="col-sm-6"><!--  style="padding: 0px;margin: 1px; -->
                        <h4>Product Details:</h4>
                           <h5><?=$model->fkIntProduct->vchr_description?></h5>
                           <div id="successalert"></div>
                   </div> </div></div></div>
                   <?php } ?></div></body>
                    </br>

</div>







<?php

$session = Yii::$app->session;
$cartCount='';
if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $cart_data = $session->get('cart');
            if($cart_data==null)
            {
                $cartCount='0';
            }
            else
            {
                $cartCount=sizeof($cart_data);
            }

            

?>