<?php

namespace app\controllers;

use Yii;
use app\models\TblCategory;
use app\models\TblSubCategory;
use app\models\TblSearchSubCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SubCategoryController implements the CRUD actions for TblSubCategory model.
 */
class SubCategoryController extends Controller
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
     * Lists all TblSubCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblSearchSubCategory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblSubCategory model.
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
     * Creates a new TblSubCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblSubCategory();
        $category_name=ArrayHelper::map(TblCategory::find()->asArray()->all(), 'pk_int_category_id', 'vchr_category_name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pk_int_sub_category_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'category_name' => $category_name,
            ]);
        }
    }

    /**
     * Updates an existing TblSubCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category_name=ArrayHelper::map(TblCategory::find()->asArray()->all(), 'pk_int_category_id', 'vchr_category_name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pk_int_sub_category_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'category_name' => $category_name,
            ]);
        }
    }

    /**
     * Deletes an existing TblSubCategory model.
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
     * Finds the TblSubCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblSubCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblSubCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


     public function actionGetSubCategory($id)
    {
        //find the SubCategory from TblSubCategory table
        $countSubCategory = TblSubCategory::find()
                    ->where(['fk_int_category_id'=>$id])
                    ->count();
        $subCategory = TblSubCategory::find()
                    ->where(['fk_int_category_id'=>$id])
                    ->all();
        echo "<option>Pls select a category</option>";
        if($countSubCategory> 0)
        {
            foreach ($subCategory as $subCategory) 
            {
                echo "<option value='".$subCategory->pk_int_sub_category_id."'>". $subCategory->vchr_sub_category_name."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
        
    }




}
