<?php

namespace app\controllers;

use app\models\TblOrderDetail;
use app\models\TblOrderDetailStatus;


class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$modeltblorderdetail = new TblOrderDetail;
        $dataProvider = $modeltblorderdetail->getfullOrderAdmin();
        return $this->render('viewfullorder',[
        	'dataProvider' => $dataProvider,
        	]);
    }


    public function actionView($id)
    {
    	$modeltblorderdetail = new TblOrderDetail;
    	$model = $modeltblorderdetail->getById($id);
         // var_dump($model);
         // die;
         return $this->render('vieworderitem',[
         	'model' => $model,
         	]);
    }


    public function actionAjax($id,$status)
    {
    	$modeltblorderdetail = new TblOrderDetail;
    	$modeltblorderdetailstatus = new TblOrderDetailStatus;
    	$modeldetail = $modeltblorderdetail->getById($id);
    	$modeldetail->fk_int_status_id=(int)$status;
    	$modeldetail->update(false);
    	$modelstatus = $modeltblorderdetailstatus->getById($id);
    	$modelstatus->fk_int_status_id=(int)$status;
    	$modelstatus->update(false);
    }
}
