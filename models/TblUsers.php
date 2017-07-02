<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_users".
 *
 * @property integer $pk_int_customer_id
 * @property string $vchr_name
 * @property string $vchr_gender
 * @property string $vchr_mobile
 * @property string $vchr_email
 * @property string $vchr_password
 * @property string $text_address
 * @property integer $int_user_type
 *
 * @property TblOrder[] $tblOrders
 */
class TblUsers extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vchr_name', 'vchr_gender', 'vchr_mobile', 'vchr_email', 'vchr_password', 'text_address', 'int_user_type'], 'required'],
            [['vchr_email'],'unique','message' => 'This e-mail has been already registered'],
            [['text_address'], 'string'],
            [['int_user_type'], 'integer'],
            [['vchr_name'], 'string', 'max' => 75],
            [['vchr_password'], 'string', 'min' => 6],
            [['vchr_gender', 'vchr_mobile'], 'string', 'max' => 10],
            [['vchr_email', 'vchr_password'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_int_customer_id' => 'Pk Int Customer ID',
            'vchr_name' => 'Vchr Name',
            'vchr_gender' => 'Vchr Gender',
            'vchr_mobile' => 'Vchr Mobile',
            'vchr_email' => 'Vchr Email',
            'vchr_password' => 'Vchr Password',
            'text_address' => 'Text Address',
            'int_user_type' => 'Int User Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblOrders()
    {
        return $this->hasMany(TblOrder::className(), ['fk_int_customer_id' => 'pk_int_customer_id']);
    }

    public function getAuthKey() {
       
    }

    public function getId() {
         return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey){
        
        
        
    }

    public static function findIdentity($id){
        
        return self::findOne($id);
        
    }

    public static function findIdentityByAccessToken($token, $type = null){
        return self::findOne(['access_token'=>$token]);
    }
    public static function findByUsername($email){
        return self::findOne(['vchr_email'=>$email]);
    }

    public function validatePassword($password){
        
        
        return $this->vchr_password;// === sha1($password);
    }



}
