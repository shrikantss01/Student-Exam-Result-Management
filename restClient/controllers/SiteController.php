<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $defaultAction = 'login';
            
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
     * {@inheritdoc}
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
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['srm/index']);
        }
        $model = new LoginForm();
        if (Yii::$app->request->post()) {
            try {                
                $params = Yii::$app->request->post();
                $url = "http://localhost/restServer/web/index.php/auth/login";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);

                $data = $params['LoginForm'];
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                $res = curl_exec($ch);
                curl_close($ch);

                if ($res != "") {
                   $resArr = json_decode($res, true);
                   if (isset($resArr['status']) && $resArr['status'] == 'success') {
                      $data = $resArr['data'];

                      if (isset($data['id'])) {
                          \Yii::$app->session['tempUser'] = [
                                'id' => $data['id'],
                                'username' => $data['username'],
                                'password' => $data['username'],
                                'authKey' => $data['token'],
                                'accessToken' => $data['token'],
                            ];
                          $model->username = $data['username'];
                          $model->password = $data['username'];
                          if ($model->login()) {
                                $this->redirect(['srm/index']);
                          }
                      }
                   } else if (isset($resArr['status']) && $resArr['status'] == 'error') {
                       Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
                   }
                }
            
            } catch (Exception $ex) {
                 Yii::$app->session->setFlash('errorMsg', $ex->getMessage());
            }
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        try {
            
            $tmpData = Yii::$app->session['tempUser'];
            $token = (isset($tmpData['accessToken'])) ? $tmpData['accessToken'] : '';

            $url = "http://localhost/restServer/web/index.php/student/logout?access-token=".$token;
 
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            
            $tmpData = Yii::$app->session['tempUser'];
            $token = (isset($tmpData['accessToken'])) ? $tmpData['accessToken'] : '';
            $id = (isset($tmpData['id'])) ? $tmpData['id'] : '';
                
            $params['token'] = $token;
            $params['id'] = $id;
            $data = $params;
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $res = curl_exec($ch);
            curl_close($ch);
            
            if ($res != "") {
                $resArr = json_decode($res, true);
                if (isset($resArr['status']) && $resArr['status'] == 'success') {
                    Yii::$app->user->logout();
                    return $this->goHome();
                } else if (isset($resArr['status']) && $resArr['status'] == 'error') {
                    Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
                } else if(isset($resArr['status']) && $resArr['status'] == 401 && $resArr['name'] == 'Unauthorized') {
                   Yii::$app->session->setFlash('errorMsg', $resArr['message']);
                }
            }            
            
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('errorMsg', $ex->getMessage());
        }
        $this->redirect(['srm/index']);
    }
    
    /**
     * Register action.
     *
     * @return Response
     */
    public function actionRegister() {
        $model = new RegisterForm();
        if (Yii::$app->request->post()) {
            try {
                
                $params = Yii::$app->request->post();
                $url = "http://localhost/restServer/web/index.php/auth/register";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);

                $data['user'] = $params['RegisterForm'];
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                $res = curl_exec($ch);
                curl_close($ch);
                
                if ($res != "") {
                   $resArr = json_decode($res, true);
                   if (isset($resArr['status']) && $resArr['status'] == 'success') {
                       Yii::$app->session->setFlash('successMsg', "Registration done successfully!");
                   } else if (isset($resArr['status']) && $resArr['status'] == 'error') {
                       Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
                   }
                }
                
            } catch (Exception $e) {
                Yii::$app->session->setFlash('errorMsg', $e->getMessage());                
            }
        }
        return $this->render('register',[ 'model' => $model]);
    }
}
