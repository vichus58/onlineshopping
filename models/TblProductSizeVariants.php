<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_product_size_variants".
 *
 * @property integer $pk_int_product_size_variants_id
 * @property integer $fk_int_category_id
 * @property integer $fk_int_sub_category_id
 * @property string $vchr_size_names
 *
 * @property TblCategory $fkIntCategory
 * @property TblSubCategory $fkIntSubCategory
 */
class TblProductSizeVariants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_product_size_variants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_int_category_id', 'fk_int_sub_category_id', 'vchr_size_names'], 'required'],
            [['fk_int_category_id', 'fk_int_sub_category_id'], 'integer'],
            [['vchr_size_names'], 'string', 'max' => 50],
            [['fk_int_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblCategory::className(), 'targetAttribute' => ['fk_int_category_id' => 'pk_int_category_id']],
            [['fk_int_sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblSubCategory::className(), 'targetAttribute' => ['fk_int_sub_category_id' => 'pk_int_sub_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_product_size_variants_id' => 'Product Size',
            'fk_int_category_id' => 'Category',
            'fk_int_sub_category_id' => 'Sub Category',
            'vchr_size_names' => 'Size',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntCategory()
    {
        return $this->hasOne(TblCategory::className(), ['pk_int_category_id' => 'fk_int_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntSubCategory()
    {
        return $this->hasOne(TblSubCategory::className(), ['pk_int_sub_category_id' => 'fk_int_sub_category_id']);
    }

    public function getSizeAsArray($category_id,$sub_category_id)
    {
        return ArrayHelper::map(TblProductSizeVariants::find()->where(['fk_int_category_id' => $category_id, 'fk_int_sub_category_id' => $sub_category_id])->all(),'pk_int_product_size_variants_id','vchr_size_names');
    }


    public function getByName($name,$category_id,$sub_category_id)
    {
        return TblProductSizeVariants::find()->where(['vchr_size_names' => $name , 'fk_int_category_id' => $category_id ,'fk_int_sub_category_id' => $sub_category_id])->one();
    }

    public function getByOnlyName($id)
    {
        return TblProductSizeVariants::find()->where(['pk_int_product_size_variants_id' => $id])->one();
    }

}
