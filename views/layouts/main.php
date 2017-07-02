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
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    $menu_bar='<div class="navbar-nav navbar-right">';

if(!Yii::$app->user->isGuest)
{
    $logout= Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
    'Logout',
     ['class' => 'btn linker']
    )
    . Html::endForm();
}


if(Yii::$app->user->isGuest)
{
    $menu_bar_1='<div class="navbar-nav navbar-right">';
    $menu_bar_1.=
            '<div class="dropdown">
                  <button class="dropbtn">Cart('.$cart_size.')</button>
                  <div class="dropdown-content">'
                  .'<a href="index.php?r=customer/viewcart">View Cart</a>'
                  .'</div>
            </div>';
}


if(!Yii::$app->user->isGuest and !Yii::$app->CheckAdmin->isAdmin())
{
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
                  <button class="dropbtn glyphicon glyphicon-user" style="margin-top:6%;"></button>
                  <div class="dropdown-content">'.
                    $logout.
                  '</div>
        </div>';
}


$menu_bar.='</div>';
                
echo $menu_bar;


    $menucart= [
        ['label' => 'Cart('.$cart_size.')' ,'options'=>['id'=>'cartcount'] , 'url' => ['/customer/viewcart'],'linkOptions'=>['id'=>'cartclear'],],

    ];
    

            // ['label' => 'Home', 'url' => ['/site/index']],
            // ['label' => 'About', 'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],



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

    <div class="container">
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
