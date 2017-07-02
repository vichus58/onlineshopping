<?php

namespace app\controllers;

use Yii;
use app\models\TblProductSizeVariants;
use app\models\TblSearchProductSizeVarients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TblCategory;
use yii\helpers\ArrayHelper;
use app\models\TblSubCategory;

/**
 * ProductSizeVarientController implements the CRUD actions for TblProductSizeVariants model.
 */
class ProductSizeVarientController extends Controller
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
     * Lists all TblProductSizeVariants models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblSearchProductSizeVarients();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblProductSizeVariants model.
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
     * Creates a new TblProductSizeVariants model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblProductSizeVariants();
        $category_name=ArrayHelper::map(TblCategory::find()->asArray()->all(), 'pk_int_category_id', 'vchr_category_name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pk_int_product_size_variants_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'category_name' => $category_name,
            ]);
        }
    }

    /**
     * Updates an existing TblProductSizeVariants model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pk_int_product_size_variants_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TblProductSizeVariants model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblProductSizeVariants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblProductSizeVariants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblProductSizeVariants::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


     public function actionGetSize($id)
    {
        //find the SubCategory from TblSubCategory table
        $countSubCategory = TblProductSizeVariants::find()
                    ->where(['fk_int_sub_category_id'=>$id])
                    ->count();
        $subCategory = TblProductSizeVariants::find()
                    ->where(['fk_int_sub_category_id'=>$id])
                    ->all();
        echo "<option>Pls select a category</option>";
        if($countSubCategory> 0)
        {
            foreach ($subCategory as $subCategory) 
            {
                echo "<option value='".$subCategory->pk_int_product_size_variants_id."'>". $subCategory->vchr_size_names."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
        
    }



}
