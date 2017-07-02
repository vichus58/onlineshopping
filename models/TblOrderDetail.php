<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tbl_order_detail".
 *
 * @property integer $pk_int_order_detail_id
 * @property integer $fk_int_order_id
 * @property integer $fk_int_product_id
 * @property integer $int_quantity
 * @property integer $fk_int_status_id
 * @property integer $fk_int_size_id
 *
 * @property TblOrder $fkIntOrder
 * @property TblProduct $fkIntProduct
 * @property TblStatus $fkIntStatus
 * @property TblProductSizeVariants $fkIntSize
 * @property TblOrderDetailStatus[] $tblOrderDetailStatuses
 */
class TblOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_int_order_id', 'fk_int_product_id', 'int_quantity', 'fk_int_status_id', 'fk_int_size_id'], 'required'],
            [['fk_int_order_id', 'fk_int_product_id', 'int_quantity', 'fk_int_status_id', 'fk_int_size_id'], 'integer'],
            [['fk_int_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblOrder::className(), 'targetAttribute' => ['fk_int_order_id' => 'pk_int_order_id']],
            [['fk_int_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblProduct::className(), 'targetAttribute' => ['fk_int_product_id' => 'pk_int_product_id']],
            [['fk_int_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblStatus::className(), 'targetAttribute' => ['fk_int_status_id' => 'pk_int_status_id']],
            [['fk_int_size_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblProductSizeVariants::className(), 'targetAttribute' => ['fk_int_size_id' => 'pk_int_product_size_variants_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_order_detail_id' => 'Pk Int Order Detail ID',
            'fk_int_order_id' => 'Fk Int Order ID',
            'fk_int_product_id' => 'Fk Int Product ID',
            'int_quantity' => 'Int Quantity',
            'fk_int_status_id' => 'Fk Int Status ID',
            'fk_int_size_id' => 'Fk Int Size ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntOrder()
    {
        return $this->hasOne(TblOrder::className(), ['pk_int_order_id' => 'fk_int_order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntProduct()
    {
        return $this->hasOne(TblProduct::className(), ['pk_int_product_id' => 'fk_int_product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntStatus()
    {
        return $this->hasOne(TblStatus::className(), ['pk_int_status_id' => 'fk_int_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntSize()
    {
        return $this->hasOne(TblProductSizeVariants::className(), ['pk_int_product_size_variants_id' => 'fk_int_size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblOrderDetailStatuses()
    {
        return $this->hasMany(TblOrderDetailStatus::className(), ['fk_int_order_detail_id' => 'pk_int_order_detail_id']);
    }




    public function getLastRow()
    {
        return TblOrderDetail::find()
                ->orderBy(['pk_int_order_detail_id'=>SORT_DESC,])
                ->limit(1)
                ->one();
    }

    public function getfullOrder()
    {
        $query = new Query; 
        return new ActiveDataProvider([
            'query' => $query
                            ->select(['tbl_order.pk_int_order_id', 'tbl_product.pk_int_product_id' , 'tbl_product.vchr_item_name', 'tbl_product.int_item_price' , 'tbl_status.vchr_status' , 'tbl_order_detail.int_quantity'])
                            ->from('tbl_order_detail')
                            ->join( 'INNER JOIN', 'tbl_order', 'tbl_order.pk_int_order_id = tbl_order_detail.fk_int_order_id')
                            ->join('INNER JOIN', 'tbl_order_detail_status', 'tbl_order_detail_status.fk_int_order_detail_id = tbl_order_detail.pk_int_order_detail_id')
                            ->join('INNER JOIN', 'tbl_status', 'tbl_status.pk_int_status_id = tbl_order_detail.fk_int_status_id')
                            ->join('INNER JOIN', 'tbl_product', 'tbl_product.pk_int_product_id = tbl_order_detail.fk_int_product_id')
                            ->where(['fk_int_customer_id'=> Yii::$app->user->identity->pk_int_customer_id])
                            ->orderBy('tbl_order_detail.fk_int_order_id desc'),
            'pagination' => [
                    'pageSize' => 20,
                ],
        ]);
    }
    



    public function getfullOrderAdmin()
    {
        $query = new Query; 
        return new ActiveDataProvider([
            'query' => $query
                            ->select(['tbl_order.pk_int_order_id', 'tbl_product.pk_int_product_id' , 'tbl_product.vchr_item_name', 'tbl_product.int_item_price' , 'tbl_status.vchr_status' , 'tbl_status.pk_int_status_id' , 'tbl_order_detail.int_quantity'])
                            ->from('tbl_order_detail')
                            ->join( 'INNER JOIN', 'tbl_order', 'tbl_order.pk_int_order_id = tbl_order_detail.fk_int_order_id')
                            ->join('INNER JOIN', 'tbl_order_detail_status', 'tbl_order_detail_status.fk_int_order_detail_id = tbl_order_detail.pk_int_order_detail_id')
                            ->join('INNER JOIN', 'tbl_status', 'tbl_status.pk_int_status_id = tbl_order_detail.fk_int_status_id')
                            ->join('INNER JOIN', 'tbl_product', 'tbl_product.pk_int_product_id = tbl_order_detail.fk_int_product_id')
                            ->orderBy('tbl_order_detail.fk_int_order_id desc'),
            'pagination' => [
                    'pageSize' => 20,
                ],
        ]);
    }



    public function getById($id)
    {
        return TblOrderDetail::find()->where(['fk_int_order_id' => $id])->one();
    }

}
