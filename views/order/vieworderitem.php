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
                            .round-corners {
                                            border-radius: 25px;
                                            // background: #c3c388;
                                            padding: 20px;
                                            display: inline-block;
                                            border:4px solid #aaaa55;
                                        }
                            .inline-headers h4{
                              display: inline-block;
                              vertical-align: baseline;
                            }
                       ");
    ?>


<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="container">
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
                <?php
                    $css='';
                                            if($model->fkIntStatus->vchr_status=='Pending'){
                                                $css.=".btn-colour-pending{
                                                                background-color:#30cb00;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            } else {
                                                $css.=".btn-colour-pending{
                                                                background-color: #5BC0DE;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            }

                                            if($model->fkIntStatus->vchr_status=='Packed'){
                                                $css.=".btn-colour-packed{
                                                                background-color:#30cb00;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            } else {
                                                $css.=".btn-colour-packed{
                                                                background-color: #5BC0DE;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            }

                                            if($model->fkIntStatus->vchr_status=='Shipped'){
                                                $css.=".btn-colour-shipped{
                                                                background-color:#30cb00;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            } else {
                                                $css.=".btn-colour-shipped{
                                                                background-color: #5BC0DE;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            }

                                            if($model->fkIntStatus->vchr_status=='Arrived'){
                                                $css.=".btn-colour-arrived{
                                                                background-color:#30cb00;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            } else {
                                                $css.=".btn-colour-arrived{
                                                                background-color: #5BC0DE;
                                                            }
                                                            a {
                                                                color: #000000;
                                                            }";
                                            }
                
                        $this->registerCss(
                                            $css
                                           );
                ?>
                <br>
                <h4>Status</h4>
                <div class="row">
                    <div class="col-lg-6">
                       <a class = "btn btn-colour-pending" style="padding: 2px;width: 50%;" id="btnpending">Pending</a> 
                       <a class = "btn btn-colour-packed" style="padding: 2px;width: 46%;" id="btnpacked">Packed</a>
                    </div>
                </div>
                <div class="row" style="padding-top: 3px;">
                    <div class="col-lg-6">
                       <a class = "btn btn-colour-shipped" style="padding: 2px;width: 50%;" id="btnshipped">Shipped</a>
                       <a class = "btn btn-colour-arrived" style="padding: 2px;width: 46%;" id="btnarrived">Arrived</a>
                    </div>
                <div id="successalert"></div>
                                   
    
                </div> 
                <br>


                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script type="text/javascript">
                   
                  $(document).ready(function(){
                 
                    $("#btnpending").click(function(){
                        $("#successalert").load("index.php?r=order/ajax&id=<?= $model->fkIntOrder->pk_int_order_id ?>&status=1");
                        $("#btnpending").css("background-color", "#30cb00"); 
                        $("#btnpacked").css("background-color", "#5BC0DE");
                        $("#btnshipped").css("background-color", "#5BC0DE");
                        $("#btnarrived").css("background-color", "#5BC0DE");     
                    });
                    $("#btnpacked").click(function(){
                        $("#successalert").load("index.php?r=order/ajax&id=<?= $model->fkIntOrder->pk_int_order_id ?>&status=2");
                        $("#btnpending").css("background-color", "#5BC0DE"); 
                        $("#btnpacked").css("background-color", "#30cb00");
                        $("#btnshipped").css("background-color", "#5BC0DE");
                        $("#btnarrived").css("background-color", "#5BC0DE");       
                    });
                    $("#btnshipped").click(function(){
                        $("#successalert").load("index.php?r=order/ajax&id=<?= $model->fkIntOrder->pk_int_order_id ?>&status=3");
                        $("#btnpending").css("background-color", "#5BC0DE"); 
                        $("#btnpacked").css("background-color", "#5BC0DE");
                        $("#btnshipped").css("background-color", "#30cb00");
                        $("#btnarrived").css("background-color", "#5BC0DE");       
                    });
                    $("#btnarrived").click(function(){
                        $("#successalert").load("index.php?r=order/ajax&id=<?= $model->fkIntOrder->pk_int_order_id ?>&status=4");
                        $("#btnpending").css("background-color", "#5BC0DE"); 
                        $("#btnpacked").css("background-color", "#5BC0DE");
                        $("#btnshipped").css("background-color", "#5BC0DE");
                        $("#btnarrived").css("background-color", "#30cb00");       
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
                   </div> </div></div></body>
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