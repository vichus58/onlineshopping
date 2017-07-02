<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_product_size".
 *
 * @property integer $pk_int_size_id
 * @property integer $fk_int_product_id
 * @property string $vchr_size
 *
 * @property TblProduct $fkIntProduct
 */
class TblProductSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_product_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_int_product_id', 'vchr_size'], 'required'],
            [['fk_int_product_id'], 'integer'],
            [['vchr_size'], 'string', 'max' => 50],
            [['fk_int_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblProduct::className(), 'targetAttribute' => ['fk_int_product_id' => 'pk_int_product_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_size_id' => 'Pk Int Size ID',
            'fk_int_product_id' => 'Fk Int Product ID',
            'vchr_size' => 'Vchr Size',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIntProduct()
    {
        return $this->hasOne(TblProduct::className(), ['pk_int_product_id' => 'fk_int_product_id']);
    }
}
