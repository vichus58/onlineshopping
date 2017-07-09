<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\TblCategory;
use app\models\TblSubCategory;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    $session = Yii::$app->session;
    $cart_size='';

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $cart_data = $session->get('cart');
            if($cart_data==null)
            {
                $cart_size.='0';
            }
            else
            {
                $cart_size.=sizeof($cart_data);
            }



    $url='';
    if(Yii::$app->user->isGuest)
    {
        $url=['/customer/index'];
    }
    else if (!Yii::$app->CheckAdmin->isAdmin()) 
    {
        $url=['/customer/index'];
    }
    else
    { 
        $url=['/site/index'];
    }


    NavBar::begin([
        'brandLabel' => '<img src='.Url::to('uploads/logo.png')
        .' style="display:inline; vertical-align: top; height:180%; margin-top:-20%;">',
        'brandUrl' => $url,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top nav-custom',
        ],
    ]);


    $menu_bar='<div class="navbar-nav navbar-collapse navbar-right">';

if(!Yii::$app->user->isGuest)
{
    $logout= Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
    'Logout',
     ['class' => 'btn linker']
    )
    . Html::endForm();
}


$text_box_search = "<form class='navbar-form navbar-center' style='position:fixed;display: flex;justify-content: center;float: none;' action='javascript:search();'>
      <div class='form-group' style='position:fixed;display: flex;justify-content: center;float: none;'>
        <input type='text' id='texter' onkeyup='search()' maxlength='20' style='width:200%;' class='form-control' placeholder='Search'> 
        <button type=submit value=submit class='btn btn-success'>
<span class='glyphicon glyphicon-search'></span>
</button>
      </div>
    </form>";



if(Yii::$app->user->isGuest)
{
    $menu_bar_1='<div class="navbar-nav navbar-right">';
     $menu_bar_1.=$text_box_search;
    $menu_bar_1.=
            '<div class="dropdown nav-items">
                  <button class="dropbtn nav-items">Cart('.$cart_size.')</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=customer/viewcart">View Cart</a>'
                  .'</div>
            </div>';
}


if(!Yii::$app->user->isGuest and !Yii::$app->CheckAdmin->isAdmin())
{   
    $menu_bar.=$text_box_search;
    $item_search = menuBuilder();
    $menu_bar.=$item_search;
    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn">Cart('.$cart_size.')</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=customer/viewcart">View Cart</a>'
                  .'</div>
            </div>';
    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn glyphicon glyphicon-user" style="margin-top:8%;"></button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=customer/orderdetail">View My Orders</a>'
                  .$logout
                  .'</div>
            </div>';
}


if(!Yii::$app->user->isGuest and Yii::$app->CheckAdmin->isAdmin())
{
    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn">Product</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=product/index">View Product</a>'
                  .'<a href="index.php?r=product/create">Add Product</a>'
                  .'</div>
            </div>';

    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn">Category</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=category/index">View Category</a>'
                  .'<a href="index.php?r=category/create">Add Category</a>'
                  .'<a href="index.php?r=sub-category/index">View Sub Category</a>'
                  .'<a href="index.php?r=sub-category/create">Add Sub Category</a>'
                  .'</div>
            </div>';

    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn">Order</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=order/index">View Order</a>'
                  .'</div>
            </div>';

    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn">Product Size</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=product-size-varient/index">View Product Size</a>'
                  .'<a href="index.php?r=product-size-varient/create">Add Product Size</a>'
                  .'</div>
            </div>';

    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn">Account</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=site/create-admin">Create Admin Account</a>'
                  .'</div>
            </div>';

    $menu_bar.=
            '<div class="dropdown">
                  <button class="dropbtn glyphicon glyphicon-user" style="margin-top:6%;"></button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=customer/viewcart">Change password</a>'
                  .$logout.
                  '</div>
        </div>';
}


$menu_bar.='</div>';


    function menuBuilder()
    {
        $main_menu='';
        
        $modelTblcategory = new TblCategory;
        $modelTblSubcategory = new TblSubCategory;
        $fullCategory = $modelTblcategory->getCategory();
        foreach ($fullCategory as $keys => $values) {
            $fullSubCategory = $modelTblSubcategory->getSubCategory($keys);
            $main_menu.='<div class="dropdown">
                  <button class="dropbtn">'.$values.'</button>
                  <div class="dropdown-content">';
                foreach ($fullSubCategory as $key => $value) {
                        $main_menu.='<a href="index.php?r=customer/categorywisesearch&cat_id='.$key.'">'.$value.'</a>';
            }
            $main_menu.='</div></div>';
        }
        return $main_menu;
    }
    
?>
    <script>
        function search()
        {
            var textbox = document.getElementById('texter').value;
            // var textvalue = textbox.value;
            // alert(textbox);
            if(textbox!='')
            {
                $('#changeid').empty();
                $.ajax({
                        url: '<?php echo \Yii::$app->getUrlManager()->createUrl('customer/search') ?>',
                        type: 'POST',
                         data: { test: textbox },
                         success: function(data) {
                             // alert(data);
                                    //alert('ajax ready');
                             myArr = JSON.parse(data);
                             var dataArray=myArr[0];
                             //alert(dataArray['test']);
                             document.getElementById('changeid').insertAdjacentHTML('beforeend',dataArray['test']);

                         }
                     }); 
            }
            else
            {
                $('#changeid').empty();
                $.ajax({
                        url: '<?php echo \Yii::$app->getUrlManager()->createUrl('customer/search') ?>',
                        type: 'POST',
                         data: { test: 'int_id' },
                         success: function(data) {
                             //alert(data);
                                    //alert('ajax ready');
                             myArr = JSON.parse(data);
                             var dataArray=myArr[0];
                             //alert(dataArray['test']);
                             document.getElementById('changeid').insertAdjacentHTML('beforeend',dataArray['test']);

                         }
                     });
            }
        }
    </script>
<?php
                
echo $menu_bar;
    ///*onkeypress event can also apply*/

    // $menucart= [
    //     ['label' => 'Cart('.$cart_size.')' ,'options'=>['id'=>'cartcount'] , 'url' => ['/customer/viewcart'],'linkOptions'=>['id'=>'cartclear'],],

    // ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (['label' => 'Signup', 'url' => ['/site/signup']]) : ("")
                    ,
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : ("")
        ],
    ]);
    if (isset($menu_bar_1)) {
        $menu_bar_1.='</div>';
                
        echo $menu_bar_1;
    }
    

    NavBar::end();
    ?>

    <div class="container" id="changeid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
