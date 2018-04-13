<?php

namespace app\controllers;

use Yii;
use app\models\User;

class AuthController  extends \yii\rest\Controller
{
    
    protected function verbs()
    {
       return [
           'login' => ['POST'],
           'register' => ['POST'],
       ];
    }

    public function actionLogin()
    {        
        // get login data from client (username & password)
        $username = !empty($_POST['username'])?$_POST['username']:'';
        $password = !empty($_POST['password'])?$_POST['password']:'';
        $response = [];
        $status_code = '';
        if (empty($username) || empty($password)){
            $status_code = 400;
            $response = [
              'status' => 'error',
              'status_code'=>$status_code,  
              'errors' => 'Username & Password can not be empty!',
              'data' => '',
            ];
            
        } else {
            // search user in the database,
            $user = \app\models\User::findByUsername($username);
            // if the username exists then
            if (!empty($user)){
                //  validate password, if valid then make response success
                if ($user->validatePassword($password)){
                    $userDetails = User::find()->where(["username" => $user->username])->one();
                    $userDetails->accessToken = $user->generateAccessTkn();
                    $userDetails->save();
                    $status_code = 200;
                    $response = [
                        'status' => 'success',
                        'status_code'=>$status_code,
                        'data' => [
                            'id' => $user->id,
                            'username' => $user->username,
                            //token is taken from the accessToken field
                            'token' => $userDetails->accessToken,
                        ]
                      ];
                    
                }
                // If the password is wrong then make a response like this
                else{
                    $status_code = 400;
                    $response = [
                      'status' => 'error',
                      'status_code'=>$status_code,
                      'errors' => 'Wrong password!',
                      'data' => '',
                    ];
                }
            }
            // If the username is not found
            else{
                $status_code = 400;
                $response = [
                  'status' => 'error',
                  'status_code'=>$status_code,  
                  'errors' => 'Username not found!',
                  'data' => '',
                ];
            }
        }
        $this->setHeader($status_code);
        echo json_encode($response,JSON_PRETTY_PRINT); die();
    }
    
    public function actionRegister()
    {
        try {
            $model = new \app\models\User();        
            $params=$_REQUEST['user'];        
            $username = !empty($params['username'])?$params['username']:'';
            $password = !empty($params['password'])?$params['password']:'';
            $name = !empty($params['name'])?$params['name']:'';
            $email = !empty($params['email'])?$params['email']:'';
            $user_code = !empty($params['user_code'])?$params['user_code']:NULL;

            $model->username = $username;
            $model->password = md5($password);
            $model->name = $name;
            $model->email = $email;
            $model->user_code = $user_code;

            if ($model->validate() && $model->save()) {
                $this->setHeader(200);
                echo json_encode(array('status'=>'success','data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
            } else {
                $this->setHeader(400);
                echo json_encode(array('status'=>'error','error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
            }
        } catch (Exception $e) {
                $this->setHeader(500);
                echo json_encode(array('status'=>'error','error_code'=>500,'errors'=>$e->getMessage()),JSON_PRETTY_PRINT);
        }
    }
    
    private function setHeader($status)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Nintriva <nintriva.com>");
    }
    
    private function _getStatusCodeMessage($status)
    {
	$codes = Array(
	    200 => 'OK',
	    400 => 'Bad Request',
	    401 => 'Unauthorized',
	    403 => 'Forbidden',
	    404 => 'Not Found',
	    500 => 'Internal Server Error',
	    501 => 'Not Implemented',
	);
	return (isset($codes[$status])) ? $codes[$status] : '';
    }    
}
