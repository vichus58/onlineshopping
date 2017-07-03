<?php

namespace app\controllers;

use app\models\TblOrderDetail;
use app\models\TblOrderDetailStatus;
use app\models\TblOrder;


class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$modeltblorderdetail = new TblOrder;
        $dataProvider = $modeltblorderdetail->getfullOrderAdmin();
        return $this->render('viewfullorder',[
        	'dataProvider' => $dataProvider,
        	]);
    }


    public function actionView($id)
    {
    	$modeltblorderdetail = new TblOrderDetail;
    	$models = $modeltblorderdetail->getById($id);
          // var_dump($models);
         // die;
         return $this->render('vieworderitem',[
         	'models' => $models,
         	]);
    }


    public function actionAjax($id,$status)
    {
    	$modeltblorderdetail = new TblOrderDetail;
    	$modeltblorderdetailstatus = new TblOrderDetailStatus;
    	$modeldetail = $modeltblorderdetail->getByDetailId($id);
    	$modeldetail->fk_int_status_id=(int)$status;
    	$modeldetail->update(false);
    	$modelstatus = $modeltblorderdetailstatus->getById($id);
    	$modelstatus->fk_int_status_id=(int)$status;
    	$modelstatus->update(false);
    }
}
