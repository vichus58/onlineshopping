<?php
use app\assets\AppAsset;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
// echo Yii::$app->controller->action->id;
$this->title = 'Home';
?>
<?php
	AppAsset::register($this);
    ?>

<body>
<div class="site-index">
<div class="row"><div class="col-sm-4">&nbsp;</div></div>
    <div class="body-content row">
    	<div class="col-sm-2">
    		
    	</div>
    	<div class="col-sm-10">
        	<?php echo $datas; ?>
        </div>
	</div>
</div></body>
