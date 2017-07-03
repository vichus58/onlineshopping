<?php

namespace app\controllers;

use Yii;
use app\models\TblCustomers;
use app\models\TblProduct;
use app\models\TblOrder;
use app\models\TblOrderDetail;
use app\models\TblOrderDetailStatus;
use app\models\TblStatus;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TblProductSizeVariants;
use yii\db\Expression;


/**
 * CustomerController implements the CRUD actions for TblCustomers model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TblCustomers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelProducts = new TblProduct;
        $model=$modelProducts->getProduct();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TblCustomers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $modelProducts = new TblProduct;
        $model=$modelProducts->getSpecificProduct($id);
        $model->int_quantity=1;
        $categoryId=$model->fk_int_category_id;
        $subCategoryId=$model->fk_int_sub_category_id;
        $modelProductSizeVarient = new TblProductSizeVariants;
        $sizes=$modelProductSizeVarient->getSizeAsArray($categoryId,$subCategoryId);
        return $this->render('view', [
            'model' => $model,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Finds the TblCustomers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblCustomers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblCustomers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionViewcart()
    {
        $modelProduct = new TblProduct;
        $totalModels=array();
         $session = Yii::$app->session;
            if (!$session->isActive)
            {
                $session->open();
            }
            $cart_data = $session->get('cart');
        if($cart_data!=null)
        {
            foreach ($cart_data as $key => $value) {

                $currentModel=$modelProduct->getSpecificProduct($key);
                $totalModels[$key]=$currentModel;

            }

            return $this->render('viewcart', [
                'totalModels' => $totalModels,            
            ]);
        }
        else
        {
            return $this->render('viewcart');
        }
    }





    public function actionBuyCart($id)
    {
       $post_data=Yii::$app->request->post();
       if($post_data['user_action']=="buy")
       {


        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $session->remove('buyflag');
            $session->set('buyflag', 10);
            $session->remove('buy');
            $size=$post_data['TblProduct']['fk_int_product_varients'];
            $quantity=$post_data['TblProduct']['int_quantity'];
            $cart_data=array('id' => $id,'size' => $size,'quantity' => $quantity);
            $session->set('buy', $cart_data);
            if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
            }
            else
            {
                $session->remove('buyflag');
                $this->actionBuyit();
            }           
       }
       else if($post_data['user_action']=="cart")
       {
            $productSize=$post_data['TblProduct']['fk_int_product_varients'];
            $productQuantity=$post_data['TblProduct']['int_quantity'];
            $this->addToCart($id,$productSize,$productQuantity);
                    $modelProduct = new TblProduct;
                    $model=$modelProduct->getSpecificProduct($id);
                    $categoryId=$model->fk_int_category_id;
                    $subCategoryId=$model->fk_int_sub_category_id;
                    $modelProductSizeVarient = new TblProductSizeVariants;
                    $model->int_quantity=$productQuantity;
                    $sizes=$modelProductSizeVarient->getSizeAsArray($categoryId,$subCategoryId);
                    return $this->render('view', [
                        'model' => $model,
                        'sizes' => $sizes,
                    ]);
       }
    }


    protected function addToCart($id,$size,$quantity)
    {
            $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $cart_data = $session->get('cart');
            if(isset($cart_data[$id]))
            {
                unset($_SESSION['cart'][$id]);
            }
                $cart_data[$id]=array('size' => $size,'quantity' => $quantity);
                $session->set('cart', $cart_data);
    }


    public function actionClearCart()
    {
        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }

            $session->remove('cart');
    }


    public function actionRemoveonecart($id)
    {
        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $cart_data = $session->get('cart');
            unset($cart_data[$id]);
            $session->set('cart', $cart_data);
    }



    public function actionBuyit()
    {
        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }

            $buy_data=$session->get('buy');

            if($buy_data!=null)
            {
                $modelOrder = new TblOrder();
                $modelOrder->fk_int_customer_id = Yii::$app->user->identity->pk_int_customer_id;
                $modelOrder->date_date = new \yii\db\Expression('NOW()');
                $modelOrder->save();

                $lastOrder = $modelOrder->getLastRow();

                $modelOrderDetail = new TblOrderDetail();
                $modelOrderDetail->fk_int_order_id = $lastOrder->pk_int_order_id;
                $modelOrderDetail->fk_int_product_id = $buy_data['id'];
                $modelOrderDetail->int_quantity = $buy_data['quantity'];
                $modelOrderDetail->fk_int_status_id = 1;
                $modelOrderDetail->fk_int_size_id = $buy_data['size'];
                $modelOrderDetail->save(false);

                $lastorderdetail=$modelOrderDetail->getLastRow();
                $modelOrderDetailStatus = new TblOrderDetailStatus();
                $modelOrderDetailStatus->fk_int_order_id = $lastOrder['pk_int_order_id'];
                $modelOrderDetailStatus->fk_int_order_detail_id = $lastorderdetail['pk_int_order_detail_id'];
                $modelOrderDetailStatus->fk_int_status_id = 1;
                $modelOrderDetailStatus->date_date_time = new Expression('NOW()');
                $modelOrderDetailStatus->save(false);

                $session->remove('buy');
                $session->remove('buyflag');
                echo "<script>
                    alert('Order placed successfully !');
                    window.location.href='index.php?r=customer/orderdetail';
                    </script>";
            }
    }


    public function actionCheckout()
    {

        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $session->remove('buyflag');
            $session->set('buyflag', 20);
            $session->remove('buy');
            if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
            }
            else
            {


                $cart_data_buy=$session->get('cart');
                if($cart_data_buy!=null)
                {
                            $modelOrder = new TblOrder();
                            $modelOrder->fk_int_customer_id = Yii::$app->user->identity->pk_int_customer_id;
                            $modelOrder->date_date = new \yii\db\Expression('NOW()');
                            $modelOrder->save();

                            $lastOrder = $modelOrder->getLastRow();

                    foreach ($cart_data_buy as $key => $value) 
                    {
                            $modelOrderDetail = new TblOrderDetail();
                            $modelOrderDetail->fk_int_order_id = $lastOrder->pk_int_order_id;
                            $modelOrderDetail->fk_int_product_id = $key;
                            $modelOrderDetail->int_quantity = $value['quantity'];
                            $modelOrderDetail->fk_int_status_id = 1;
                            $modelOrderDetail->fk_int_size_id = $value['size'];
                            $modelOrderDetail->save(false);

                            $lastorderdetail=$modelOrderDetail->getLastRow();
                            $modelOrderDetailStatus = new TblOrderDetailStatus();
                            $modelOrderDetailStatus->fk_int_order_id = $lastOrder['pk_int_order_id'];
                            $modelOrderDetailStatus->fk_int_order_detail_id = $lastorderdetail['pk_int_order_detail_id'];
                            $modelOrderDetailStatus->fk_int_status_id = 1;
                            $modelOrderDetailStatus->date_date_time = new Expression('NOW()');
                            $modelOrderDetailStatus->save(false);
                    }   
                            $session->remove('buy');
                            $session->remove('cart');
                            $session->remove('buyflag');
                            echo "<script>
                                alert('Order placed successfully !');
                                window.location.href='index.php?r=customer/orderdetail';
                                </script>";
                }
            }

    }






    public function actionOrderdetail()
    {
        $modeltblorderdetail = new TblOrder;
        $dataProvider = $modeltblorderdetail->getfullOrder();
        return $this->render('vieworder', [
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single TblOrderDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewOrder($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }




    //loading index page items dynamically
    public function actionAjax()
    {
            $modelProducts = new TblProduct;
            $post_data=Yii::$app->request->post();
            $data=$post_data['test'];
            $offseter=(int)$data;
            $offseter-=1;
            $count=(int)$modelProducts->getProductCount();
            $model = $modelProducts->getLastAjaxItem($offseter);
            $lastid=$model['pk_int_product_id'];
            $response_data = $modelProducts->getNextAjaxItem($lastid);

//////////////////////

            if($offseter<$count)
            {
                    
                        $html_data=$this->makePage($response_data);
                            return \yii\helpers\Json::encode(                
                            [
                             
                                ['test'=>$html_data,
                                 'id'=>1,
                                 ],
                            // ['test'=>$count,
                            //      'id'=>1,
                            //      ],

                            ]
                            );



            }
            else
            {

                            return \yii\helpers\Json::encode(                
                            [
                             
                                ['test'=>'hi',
                                 'id'=>2,
                                 ],
                            // ['test'=>$count,
                            //      'id'=>1,
                            //      ],

                            ]
                            );

            }              
    }



    public function actionSearch()
    {   
            $modelProducts = new TblProduct;
            $post_data=Yii::$app->request->post();
            $data=(string)$post_data['test'];
            if($data=='int_id')
            {
                $response_data = $modelProducts->getAllProduct();
            }
            else
            {
                $response_data = $modelProducts->getSearchProduct($data);
            }




//////////////////////


                $html_data=$this->makePage($response_data);

                    

                            return \yii\helpers\Json::encode(                
                            [
                             
                                ['test'=>$html_data,
                                 'id'=>1,
                                 ],
                            // ['test'=>$count,
                            //      'id'=>1,
                            //      ],

                            ]
                            );            
    
    }


    protected function makePage($response_data)
    {
                $html_data='';
                $i=3;
                    foreach ($response_data as $models) {
                     $in=$models->pk_int_product_id;
                     if($i%3==0)
                    $html_data.='<div id="content" class="row" style="text-align: center;"> <ul>';
                     $i+=1;
                        
                        $html_data.='<li style="display: block;">';
                         $html_data.="<div onclick=location.href='index.php?r=customer/view&id=$in'".' class="col-lg-4">';
                        $html_data.='<img src="'.$models->product_pic.'" height="200" width="200">';
                             $html_data.='<h4>'.$models->vchr_item_name.' </h4>';
                             $description_data=$models->vchr_description;
                             $descri=(strlen($description_data)<=50) ? $description_data : substr($description_data, 0, 50).'.....';
                             $html_data.='<p>'.$descri.'</p>';
                             $html_data.='<p>'."price ".$models->int_item_price."/-".'</p>';
                             $html_data.='</div>';
                             $html_data.='</li>';
                             if($i%3==0)
                             $html_data.='</ul> </div>';
                        }

                            if($i%3!=0)
                            $html_data.='</ul> </div>';

                    return $html_data;
    }



    public function actionViewindividualorder($id)
    {
        $modeltblorderdetail = new TblOrderDetail;
        $models = $modeltblorderdetail->getfullOrder($id);
        // var_dump($models);
        // die;
        return $this->render('viewindividualorder', [
            'models' => $models,
        ]);
    }





}
