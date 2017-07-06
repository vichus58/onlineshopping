<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_sub_category".
 *
 * @property integer $pk_int_sub_category_id
 * @property integer $fk_int_category_id
 * @property string $vchr_sub_category_name
 *
 * @property TblProduct[] $tblProducts
 * @property TblCategory $fkIntCategory
 */
class TblSubCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_sub_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_int_category_id', 'vchr_sub_category_name'], 'required'],
            // [['fk_int_category_id'], 'integer'],
            [['vchr_sub_category_name'], 'string', 'max' => 50],
            [['fk_int_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblCategory::className(), 'targetAttribute' => ['fk_int_category_id' => 'pk_int_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_sub_category_id' => 'Sub Category ID',
            'fk_int_category_id' => 'Category Name',
            'vchr_sub_category_name' => 'Sub Category Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblProducts()
    {
        return $this->hasMany(TblProduct::className(), ['fk_int_sub_category_id' => 'pk_int_sub_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntCategory()
    {
        return $this->hasOne(TblCategory::className(), ['pk_int_category_id' => 'fk_int_category_id']);
    }

    public function getSubCategory($keys)
    {
        return ArrayHelper::map(TblSubCategory::find()->where(['fk_int_category_id' => $keys])->all(),'pk_int_sub_category_id','vchr_sub_category_name');
    }


    public function getSubCategoryById($id)
    {
        return TblProduct::find()->where(['fk_int_sub_category_id' => $id])->all();
    }
}
