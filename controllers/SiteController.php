<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TblUsers;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
        $buyflag=$session->get('buyflag');

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(!Yii::$app->CheckAdmin->isAdmin())
            {
                if($buyflag==10)
                {
                    return $this->redirect(['customer/buyit']);
                }
                else if($buyflag==20)
                {
                    return $this->redirect(['customer/checkout']);
                }
                else
                {
                    return $this->redirect(['customer/index']);
                }
                
            }
            else
            {
                return $this->redirect(['site/index']);
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }

            $session->remove('buyflag');
            $session->set('buyflag', 0);
            
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }




    public function actionSignup()
    {
        $session = Yii::$app->session;

            // check if a session is already open
            if (!$session->isActive)
            {
                // open a session
                $session->open();
            }
            $buyflag=$session->get('buyflag');
            $session->remove('buyflag');


        $model = new TblUsers();
        if(Yii::$app->request->post())
        {
            $post_data=Yii::$app->request->post('TblUsers');
            $model->vchr_name=$post_data['vchr_name'];
            $model->vchr_gender=$post_data['vchr_gender'];
            $model->vchr_mobile=$post_data['vchr_mobile'];
            $model->vchr_email=$post_data['vchr_email'];
            $model->vchr_password=$post_data['vchr_password'];
            $model->text_address=$post_data['text_address'];
            $model->int_user_type=0;
                if($model->save(false))
                {
                    if($buyflag==10)
                    {
                        return $this->redirect(['customer/buyit']);
                    }
                    else
                    {
                        return $this->redirect(['site/login']);
                    }
                }
        }
            return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionCreateAdmin()
    {
        $model = new TblUsers();
        if(Yii::$app->request->post())
        {
            $post_data=Yii::$app->request->post('TblUsers');
            $model->vchr_name=$post_data['vchr_name'];
            $model->vchr_gender=$post_data['vchr_gender'];
            $model->vchr_mobile=$post_data['vchr_mobile'];
            $model->vchr_email=$post_data['vchr_email'];
            $model->vchr_password=$post_data['vchr_password'];
            $model->text_address=$post_data['text_address'];
            $model->int_user_type=1;
                if($model->save(false))
                {
                    return $this->redirect(['site/login']);
                }
        }
            return $this->render('createadmin', [
            'model' => $model,
        ]);
    }




}
