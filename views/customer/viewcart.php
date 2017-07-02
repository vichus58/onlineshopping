<?php
use yii\bootstrap\Carousel;
use aki\imageslider\ImageSilderAsset;
use app\assets\AppAsset;
use yii\bootstrap\Alert;
use aki\imageslider\ImageSlider;
use yii\helpers\Html;
use app\models\TblProductSizeVariants;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Cart';
?>



<?php
    $this->registerCss("
                            .round-corners {
                                            border-radius: 25px;
                                            // background: #c3c388;
                                            padding: 20px;
                                            //display: inline-block;
                                            border:4px solid #aaaa55;
                                        }
                       ");
    ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
   
  $(document).ready(function(){
 
    $("#btnclearcart").click(function(){

    	$.ajax({
		  url: "index.php?r=customer/clear-cart",
		});
		location.reload(); 

        // $("#cartclear").text("Cart(0)");
        // document.getElementById('removediv').style.display='none';
    });


    $("#btnbuycart").click(function(){
    	window.location.href='index.php?r=customer/checkout';
    });

    
});



  function amIclicked(e, element)
{
    e = e || event;
    var target = e.target || e.srcElement;
    if(target.id==element.id)
        return true;
    else
        return false;
}
function oneClick(event, element)
{
    if(amIclicked(event, element))
    {
       //window.location="index.php?r=customer/removeonecart&id="+element.id;
       $.ajax({
		  url: "index.php?r=customer/removeonecart&id="+element.id,
		});
       location.reload();
       event.preventDefault();
    }
}



</script>



<?php


	if(!isset($totalModels))
	{
		$url=Url::to('@web/uploads/cart-empty.png');
		$img=Html::img($url , ['width' => 1100]);
		echo "<a href='index.php?r=customer/index'>".$img."</a>";
	}
	else
	{

			$session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $cart_data = $session->get('cart');

            echo "<div class='row'>";
            echo "<div class='col-md-4'></div>";
            echo "<div class='col-md-2'><button class='btn btn-lg btn-brand btn-full-width' style='background-color: #4CAF50;' id='btnclearcart'>Clear cart</button></div>";
             echo "<div class='col-lg-4'><button class='btn btn-lg btn-brand btn-full-width' style='background-color: #4CAF50;' id='btnbuycart'>Check out</button></div>";
            echo "</div><br>";

            echo "<div class='row' style='margin-left : 20px; margin-right : 20px;'>";
			foreach ($totalModels as $key => $value) {
				$sizeId=$cart_data[$key]['size'];
				// var_dump($sizeId);
				$modelTblProductSizeVariants=new TblProductSizeVariants;
				$sizeModel=$modelTblProductSizeVariants->getByOnlyName($sizeId);
				// var_dump($sizeModel);
				
					echo "<div class='round-corners col-lg-6'>";
					
							echo "<div class='col-md-4' onclick=location.href='index.php?r=customer/view&id=$value->pk_int_product_id'>";//style='padding : 0px;'>";
								echo Html::img($value->product_pic , ['width' => 150, 'height' => 150]);
							echo "</div>";
							echo "<div class='col-md-4' onclick=location.href='index.php?r=customer/view&id=$value->pk_int_product_id'>";
							echo "<h4><b>Name</b> <font size='3'>".$value->vchr_item_name."</font></h4>";
							echo "<p><b>Quantity</b> ".$cart_data[$key]['quantity']."</p>";
							echo "<p><b>Size</b> ".$sizeModel['vchr_size_names']."</p>";
							echo "<p><b>Price</b> ".$cart_data[$key]['quantity']*$value->int_item_price."</p>";

							echo "</div>";
							echo "<br><br>";
							//echo "<div onclick=location.href='index.php?r=customer/view&id=$value->pk_int_product_id'><br><br></div>";
							echo "<div class='row'>";
							echo "<button class='btn btn-lg btn-brand btn-full-width' onclick='oneClick(event,this)' style='background-color: #FA9A00;height:45px;width:160px;' id='$key'><font size=3>Remove from cart</font></button>";
							echo "</div>";
							//echo "<div onclick=location.href='index.php?r=customer/view&id=$value->pk_int_product_id'><br><br></div>";
					echo "</div>";

				
			}
			echo "</div>";
	}

?>

   

<body>
<div class="site-index">

<div class="row"><div class="col-sm-4">&nbsp;</div></div>
    <div class="body-content">
        
             
             
</div>
</div>
