<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\StudentsMarks;
use yii\filters\auth\QueryParamAuth;

class StudentController  extends \yii\rest\Controller
{
    public function behaviors(){
      $behaviors= parent::behaviors();
      $behaviors['authenticator'] = [
        'class'=> QueryParamAuth::className(),
      ];
      return $behaviors;
    }
    
    protected function verbs()
    {
       return [
           'index' => ['GET', 'POST'],
           'Create' => ['GET', 'POST'],
           'Update' => ['GET'],
           'logout' => ['POST'],
       ];
    }
    
    public function beforeAction($action)
    {
      if ($action->id !='index' && $action->id !='summary' && $action->id !='logout')
      {
          $token = isset($_GET['access-token'])?$_GET['access-token']:'';
          $this->userValidate($token);
      }
      return parent::beforeAction($action);
    }
    
    public function actionLogout() 
    {
        $token = !empty($_POST['token'])?$_POST['token']:'';
        $id = !empty($_POST['id'])?$_POST['id']:'';
        
        $response = [];
        $status_code = '';        
        $userDetails = User::find()->where(["id" => $id])->one();
        
        if (!empty($userDetails)){
            
            $userDetails->accessToken = '';
            if ($userDetails->save()) {                
                 $status_code = 200;
                 $response = [
                    'status' => 'success',
                    'status_code'=>$status_code
                  ];
            } else {
                 $status_code = 400;
                 $response = [
                    'status' => 'error',
                    'status_code'=>$status_code,  
                    'errors' => 'Unable to logout!',
                    'data' => '',
                  ];                
            }           
            
        } else {            
            $status_code = 400;
            $response = [
              'status' => 'error',
              'status_code'=>$status_code,  
              'errors' => 'User not found!',
              'data' => '',
            ];
        }
        $this->setHeader($status_code);
        echo json_encode($response,JSON_PRETTY_PRINT); die();    
    }

    public function actionIndex()
    {
        try {
            $params=$_REQUEST;
            
//            $query = new \yii\db\Query;
//	    $query->from('tbl_students_marks')
//                  ->select("id,student_name,age,math,sci,eng");
            $connection = \Yii::$app->db;

//            $command = $query->createCommand();
//            $models = $command->queryAll();
            
            $command = $connection->createCommand('SELECT id,student_name,age,math,sci,eng,total,average,FIND_IN_SET( average, (SELECT GROUP_CONCAT( Avg
                    ORDER BY Avg DESC ) FROM (SELECT ROUND((SUM(math+sci+eng) * 100 /300),2) as Avg FROM tbl_students_marks GROUP BY id ORDER BY Avg DESC) t )) AS rank
                    FROM (SELECT id,student_name,age,math,sci,eng, (SUM(math+sci+eng)) as total, ROUND((SUM(math+sci+eng) * 100 /300),2) as average FROM 
                    tbl_students_marks GROUP BY id ORDER BY average DESC) t');
            $models = $command->queryAll();

            $this->setHeader(200);         
            echo json_encode(array('status'=>'success','data'=>$models),JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $this->setHeader(500);
            echo json_encode(array('status'=>'error','error_code'=>500,'errors'=>$e->getMessage()),JSON_PRETTY_PRINT);
        }
    }

    public function actionSummary()
    {
        try {
		
            $connection = \Yii::$app->db;      
            $passFailCnt = $connection->createCommand('SELECT SUM(CASE WHEN (math >= 40 AND sci >= 40 AND eng >= 40) THEN 1 ELSE 0 END) AS passCnt,
                                     SUM(CASE WHEN (math < 40 OR sci < 40 OR eng < 40) THEN 1 ELSE 0 END) AS failCnt FROM tbl_students_marks t');
            $users = $passFailCnt->queryOne();
            $pass_count = isset($users['passCnt']) ? $users['passCnt'] : 0;
            $fail_count = isset($users['failCnt']) ? $users['failCnt'] : 0;

            $math = $connection->createCommand('SELECT student_name,max_math FROM tbl_students_marks t
                                    JOIN ( SELECT MAX(mx.math) AS max_math FROM tbl_students_marks mx ) m ON m.max_math = t.math');
            $mathStudent = $math->queryAll();

            $sci= $connection->createCommand('SELECT student_name,max_sci FROM tbl_students_marks t
                                    JOIN ( SELECT MAX(mx.sci) AS max_sci FROM tbl_students_marks mx ) m ON m.max_sci = t.sci');
            $sciStudent = $sci->queryAll();

            $eng = $connection->createCommand('SELECT student_name,max_eng FROM tbl_students_marks t
                                    JOIN ( SELECT MAX(mx.eng) AS max_eng FROM tbl_students_marks mx ) m ON m.max_eng = t.eng');
            $engStudent = $eng->queryAll();


            $allSubTopper = $connection->createCommand('SELECT student_name,max_math,max_sci,max_eng FROM tbl_students_marks t
                    JOIN ( SELECT MAX(mx.math) AS max_math FROM tbl_students_marks mx ) m ON m.max_math = t.math
                    JOIN ( SELECT MAX(mx.sci) AS max_sci FROM tbl_students_marks mx ) s ON s.max_sci = t.sci
                    JOIN ( SELECT MAX(mx.eng) AS max_eng FROM tbl_students_marks mx ) e ON e.max_eng = t.eng');
            $subToppers = $allSubTopper->queryAll();

            $data = ['pass_count' => $pass_count,'fail_count' => $fail_count,'mathStudent' => $mathStudent,'sciStudent' => $sciStudent,'engStudent' => $engStudent,'subToppers' => $subToppers];

            $this->setHeader(200);
            echo json_encode(array('status'=>'success','data'=>$data),JSON_PRETTY_PRINT);
	} catch (Exception $e) {
                $this->setHeader(500);
                echo json_encode(array('status'=>'error','error_code'=>500,'errors'=>$e->getMessage()),JSON_PRETTY_PRINT);
        } 
    } 
    
    private function userValidate($token)
    {
        $user = \app\models\User::findIdentityByAccessToken($token); 
        if ($user != null) {
           $accessAllowed = ['WE32MN','FCV4RS'];
           if (!in_array($user->user_code, $accessAllowed)) {
               $this->setHeader(400);
               echo json_encode(array('status'=>'error','error_code'=>400,'errors'=>'Access denied'),JSON_PRETTY_PRINT); die();
           }
        }
    }   
    
    public function actionCreate() 
    {
        try {
            $params=$_POST;
            $student_name = !empty($params['student_name'])?$params['student_name']:'';
            $age = !empty($params['age'])?$params['age']:'';
            $math = !empty($params['math'])?$params['math']:'';
            $sci = !empty($params['sci'])?$params['sci']:'';
            $eng = !empty($params['eng'])?$params['eng']:'';
            $id = !empty($params['id'])?$params['id']:'';
            
            if ($id != "") {
                $model = StudentsMarks::find()
                        ->where('id = :userid', [':userid' => $id])
                        ->one();
            } else {
                $model = new \app\models\StudentsMarks();
            }
            
            $model->student_name = $student_name;
            $model->age = $age;
            $model->math = $math;
            $model->sci = $sci;
            $model->eng = $eng;
            
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
    
    public function actionUpdate()
    {
        try {            
            $id = $_GET['id'];
            if ($id) {
                $model = new \app\models\StudentsMarks();
                $student = $model::find()
                    ->where(["id" => $id])
                    ->one();
                if (!empty($student)) {
                    $this->setHeader(200);
                    echo json_encode(array('status'=>'success','data'=>array_filter($student->attributes)),JSON_PRETTY_PRINT);
                } else {
                     $this->setHeader(400);
                    echo json_encode(array('status'=>'error','error_code'=>400,'errors'=>'Data not found'),JSON_PRETTY_PRINT);
                }          
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
        header('X-Powered-By: ' . "test <test.com>");
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
