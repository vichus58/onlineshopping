<?php

namespace app\controllers;

use Yii;
use app\models\TblProduct;
use app\models\TblSearchProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/uploads/';

/**
 * ProductController implements the CRUD actions for TblProduct model.
 */
class ProductController extends Controller
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
     * Lists all TblProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblSearchProduct();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TblProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new TblProduct();
         if ($model->load(Yii::$app->request->post())) {
             $image=UploadedFile::getInstance($model,'file');


             if (!is_null($image)) {
             $model->product_pic = $image->name;
             $tmp = explode(".", $image->name);
             $file_extension = end($tmp);
              // generate a unique file name to prevent duplicate filenames
              $rand_name = Yii::$app->security->generateRandomString().$model->vchr_item_name.".{$file_extension}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
              Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
              $path = Yii::$app->params['uploadPath'] . $rand_name;
              $image->saveAs($path);
                // var_dump(Yii::$app->request->post());
                // die;
                // $model->file=UploadedFile::getInstance($model,'file');
                // $rdm=rand(0,45678);
                $imageName="uploads/$rand_name";
                // $model->file->saveAs($imageName);
                $model->product_pic=$imageName;
                if($model->save(false))
                return $this->redirect(['view', 'id' => $model->pk_int_product_id]);
            }





                

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->pk_int_product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TblProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $image=UploadedFile::getInstance($model,'file');


             if (!is_null($image)) {
                @unlink($model->product_pic);
             $model->product_pic = $image->name;
             $tmp = explode(".", $image->name);
             $file_extension = end($tmp);
              // generate a unique file name to prevent duplicate filenames
              $rand_name = Yii::$app->security->generateRandomString().$model->vchr_item_name.".{$file_extension}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
              Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
              $path = Yii::$app->params['uploadPath'] . $rand_name;
              $image->saveAs($path);
                // var_dump(Yii::$app->request->post());
                // die;
                // $model->file=UploadedFile::getInstance($model,'file');
                // $rdm=rand(0,45678);
                $imageName="uploads/$rand_name";
                // $model->file->saveAs($imageName);
                $model->product_pic=$imageName;
                if($model->save(false))
                return $this->redirect(['view', 'id' => $model->pk_int_product_id]);
        }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TblProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        @unlink($model->product_pic);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
