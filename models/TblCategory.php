<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_category".
 *
 * @property integer $pk_int_category_id
 * @property string $vchr_category_name
 *
 * @property TblProduct[] $tblProducts
 * @property TblSubCategory[] $tblSubCategories
 */
class TblCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vchr_category_name'], 'required'],
            [['vchr_category_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_category_id' => 'Category ID',
            'vchr_category_name' => 'Category Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblProducts()
    {
        return $this->hasMany(TblProduct::className(), ['fk_int_category_id' => 'pk_int_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblSubCategories()
    {
        return $this->hasMany(TblSubCategory::className(), ['fk_int_category_id' => 'pk_int_category_id']);
    }

    public function getCategory()
    {
        return ArrayHelper::map(TblSubCategory::find()->all(),'pk_int_category_id','vchr_category_name');
    }
}
