<?php
use yii\bootstrap\Carousel;
use aki\imageslider\ImageSilderAsset;
use app\assets\AppAsset;
use yii\bootstrap\Alert;
use aki\imageslider\ImageSlider;

/* @var $this yii\web\View */

$this->title = 'Home';
?>
<?php
	AppAsset::register($this);
    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
			$('body,html').animate({
				scrollTop: 0
			}, 800);
		$('#btn-go-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});	
</script>
<script type="text/javascript" src="js/custom.js"></script>
<script>

	var myVar;

	window.onscroll = function(ev) {
    			scrollFunction();
			    if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
			    	var a=readCookie('lastElvar');
			    	var int_id=parseInt(a);
			    	var last=int_id+9;
			        document.cookie = "lastElvar="+last;
			    	document.getElementById("loader").style.display = "block";
			    	myFunction();
			    	$.ajax({
			            url: '<?php echo \Yii::$app->getUrlManager()->createUrl('customer/ajax') ?>',
			            type: 'POST',
			             data: { test: int_id },
			             success: function(data) {
			             	 //alert(data);
			             			//alert('ajax ready');
			                 myArr = JSON.parse(data);
			                 var dataArray=myArr[0];
			                 //alert(dataArray['test']);
			                 if(dataArray['id']==1)
			                 {
			                 document.getElementById('lastElement').insertAdjacentHTML('beforebegin',dataArray['test']);
			             	 }
			             	 else if(dataArray['id']==2)
			             	 {
			                		document.getElementById('message').style.display="block";
			             	 }
			             	 // dataArray.forEach(myFunction);
			                // div.insertAdjacentHTML( 'lastElement', str );

			             }
			         });
			    	 
			}

		};
</script>

<body onload="setCookiess()">
<div class="site-index">
<div id="topper" class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	    <?= ImageSlider::widget([
		'baseUrl' => Yii::getAlias('@web/uploads'),
	    'nextPerv' => true,
	    'indicators' => true,
	    // 'height' => '400px',
	    'classes' => 'img-rounded',
	    'images' => [
	        [
	            'active' => true,
	            'src' => 'banner1.jpeg',
	            // 'width' => 800,
	            'title' => 'image',
	            'caption' => '<h4 style="font-size:100%;">This is title</h4><p>This is the caption text</p>',

	        ],
	        [
	            'src' => 'banner1.jpeg',
	            // 'width' => 800,
	            'title' => 'image',
	            'caption' => '<h4 style="font-size:100%;">This is title</h4><p>This is the caption text</p>',
	    	],
	    	[
	            'src' => 'banner1.jpeg',
	            // 'width' => 800,
	            'title' => 'image',
	            'caption' => '<h4 style="font-size:100%;">This is title</h4><p>This is the caption text</p>',
	    	]
	    ],
		]); ?>
	</div>
</div>
<div class="row"><div class="col-sm-4">&nbsp;</div></div>
    <div class="body-content">
        <?php
        function lchar($str)
        {
        	$shortString='';
        	if(strlen($str)<=50)
        	{
        		$shortString.=$str;
        	}
        	else
        	{
        		$shortString.=substr($str,0,50);
        		$shortString.='.....';
        	}
        	return $shortString;
        }
        $i=3;
        foreach ($model as $models) {
        $in=$models->pk_int_product_id;
        if($i%3==0)
       	echo '<div id="content" class="row" style="text-align: center;"> <ul>';
        $i+=1;
        ?>
        	
        	<li style="display: block;">
            <div onclick="location.href=<?php echo "'index.php?r=customer/view&id=$in'"?>" class="col-lg-4 product">
            <img src="<?= $models->product_pic ?>" height="200" width="200">
                <h4><?= $models->vchr_item_name ?> </h4>
                <p><?= lchar($models->vchr_description) ?></p>
                <p><?php echo "price ".$models->int_item_price."/-"; ?></p>
            </div>
            </li>
            <!-- <hr style="visibility: hidden;"> -->
            <?php
            if($i%3==0)
            	echo '</ul> </div>';
            }
             ?>
             <br>
             <div id="lastElement"></div>
             <br><br><br>
             <div id="loader"></div>
             <div id="message" style="display: none;">
             <?php echo Alert::widget([
			    'options' => [
			        'class' => 'alert-info text-center',
			    ],
			    'closeButton' => false,
			    'body' => 'This is the end of page...',
			]);?>
				
			</div>
<div id="btn-go-to-top" class="text-center top">
<img src="uploads/Arrow.png" style="margin: 7px;" width="50%" height="50%">
<span class="tooltiptext">Go to top</span>
</div>

</div>
