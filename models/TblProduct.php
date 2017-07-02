<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_product".
 *
 * @property integer $pk_int_product_id
 * @property integer $fk_int_category_id
 * @property integer $fk_int_sub_category_id
 * @property string $vchr_item_name
 * @property integer $int_item_price
 * @property string $vchr_description
 * @property string $product_pic
 * @property integer $int_quantity
 * @property integer $fk_int_product_varients
 *
 * @property TblOrderDetail[] $tblOrderDetails
 * @property TblCategory $fkIntCategory
 * @property TblSubCategory $fkIntSubCategory
 * @property TblProductSizeVariants $fkIntProductVarients
 * @property TblProductSize[] $tblProductSizes
 */
class TblProduct extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_int_category_id', 'fk_int_sub_category_id', 'vchr_item_name', 'int_item_price', 'int_quantity', 'vchr_description'], 'required'],
            [['fk_int_category_id', 'fk_int_sub_category_id', 'int_item_price', 'int_quantity', 'fk_int_product_varients'], 'integer'],
            [['vchr_description'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg,jpeg' , 'mimeTypes' => 'image/jpeg','maxSize'=>'100000' ],//, 'maxFiles' => 10],
            [['vchr_item_name'], 'string', 'max' => 50],
            [['product_pic'], 'string', 'max' => 255],
            [['fk_int_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblCategory::className(), 'targetAttribute' => ['fk_int_category_id' => 'pk_int_category_id']],
            [['fk_int_sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblSubCategory::className(), 'targetAttribute' => ['fk_int_sub_category_id' => 'pk_int_sub_category_id']],
            [['fk_int_product_varients'], 'exist', 'skipOnError' => true, 'targetClass' => TblProductSizeVariants::className(), 'targetAttribute' => ['fk_int_product_varients' => 'pk_int_product_size_variants_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_product_id' => 'Product ID',
            'fk_int_category_id' => 'Category Name',
            'fk_int_sub_category_id' => 'Sub Category Name',
            'vchr_item_name' => 'Item Name',
            'int_item_price' => 'Price',
            'vchr_description' => 'Description',
            'file' => 'Product Picture',
            'int_quantity' => 'Quantity',
            'fk_int_product_varients' => 'Product Size',
            'product_pic' => 'product_pic',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblOrderDetails()
    {
        return $this->hasMany(TblOrderDetail::className(), ['fk_int_product_id' => 'pk_int_product_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntProductVarients()
    {
        return $this->hasOne(TblProductSizeVariants::className(), ['pk_int_product_size_variants_id' => 'fk_int_product_varients']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblProductSizes()
    {
        return $this->hasMany(TblProductSize::className(), ['fk_int_product_id' => 'pk_int_product_id']);
    }




    public function getProduct()
    {
         return TblProduct::find()
                ->orderBy(['pk_int_product_id'=>SORT_DESC,])
                ->limit(9)
                ->all();
    }


    public function getProductCount()
    {
        return TblProduct::find()
               ->count();
    }


    public function getLastAjaxItem($offseter)
    {
         return TblProduct::find()
         ->orderBy(['pk_int_product_id'=>SORT_DESC,])
         ->limit(1)
         ->offset($offseter)
         ->one();  
    }


    public function getNextAjaxItem($lastid)
    {
        return TblProduct::find()
        ->andFilterWhere(['<', 'pk_int_product_id', $lastid])
        ->orderBy(['pk_int_product_id'=>SORT_DESC,])
        ->limit(9)
        ->all();
    }


    public function getSpecificProduct($id)
    {
        return TblProduct::find()
        ->where(['pk_int_product_id' => $id])
        ->one();
    }
    
}
