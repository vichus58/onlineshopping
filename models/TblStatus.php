<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_status".
 *
 * @property integer $pk_int_status_id
 * @property string $vchr_status
 *
 * @property TblOrderDetail[] $tblOrderDetails
 * @property TblOrderDetailStatus[] $tblOrderDetailStatuses
 */
class TblStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vchr_status'], 'required'],
            [['vchr_status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_status_id' => 'Pk Int Status ID',
            'vchr_status' => 'Vchr Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblOrderDetails()
    {
        return $this->hasMany(TblOrderDetail::className(), ['fk_int_status_id' => 'pk_int_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblOrderDetailStatuses()
    {
        return $this->hasMany(TblOrderDetailStatus::className(), ['fk_int_status_id' => 'pk_int_status_id']);
    }
}
