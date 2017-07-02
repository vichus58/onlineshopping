<?php

/**
*@author 		:Farsheel
*@Date 			:18/06/2017
*@LastModified 	:20/06/2017
*/

namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class CheckAdmin extends Component
{


	/**
	* Checks the user admin or not
	*/
	public function isAdmin()
	{

			if(Yii::$app->user->identity->int_user_type==1)
		        {
					        
		            return true;
		        }
        

			return false;
 
	}

	/**
    * Checks the user is logged in or not
    *
    */
    public function authCheck()
    {
        if (!Yii::$app->user->isGuest ) {
            if(!$this->isAdmin())
            {
            	return Yii::$app->getResponse()->redirect('/customer/');

            }
        }
        else
        {
        	return Yii::$app->getResponse()->redirect(['site/login']);
            
        }
    }
}
