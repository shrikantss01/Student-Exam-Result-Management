<?php

namespace app\controllers;
use Yii;
use app\models\Srm;

class SrmController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
      if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
      }
      return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        try {
            $dataArr = array();
            $tmpData = Yii::$app->session['tempUser'];
            $token = (isset($tmpData['accessToken'])) ? $tmpData['accessToken'] : '';
            
            $url = "http://localhost/restServer/web/index.php/student/index?access-token=".$token;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($ch);
            curl_close($ch);
            
            if($res != "") {
                $resArr = json_decode($res, true);
                if(isset($resArr['status']) && $resArr['status'] == 'success') {                    
                    $dataArr = $resArr['data'];
                } else if(isset($resArr['status']) && $resArr['status'] == 'error') {
                    Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
                } else if(isset($resArr['status']) && $resArr['status'] == 401 && $resArr['name'] == 'Unauthorized') {
                    Yii::$app->session->setFlash('errorMsg', $resArr['message']);
                }
             }            
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('errorMsg', $ex->getMessage());
        }
	$dataProvider = new \yii\data\ArrayDataProvider([
                        'key'=>'id',
                        'allModels' => $dataArr,
                        'pagination' => [
                            'pageSize' => 10,
                        ],
                    ]);
        return $this->render('admin',['dp' => $dataProvider]);
    }
    
    public function actionCreate($id = '')
    {
        $model = new Srm();
        if(Yii::$app->request->post()) {
            try {                
                $params = Yii::$app->request->post();
                $tmpData = Yii::$app->session['tempUser'];
                $token = (isset($tmpData['accessToken'])) ? $tmpData['accessToken'] : '';

                $url = "http://localhost/restServer/web/index.php/student/create?access-token=".$token;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);

                $data = $params['Srm'];
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                $res = curl_exec($ch);
                curl_close($ch);
                
                if($res != "") {
                   $resArr = json_decode($res, true);
                   if(isset($resArr['status']) && $resArr['status'] == 'success') {
                       if (isset($data['id'])) {
                           Yii::$app->session->setFlash('successMsg', "Record updated successfully!");
                       } else {
                           Yii::$app->session->setFlash('successMsg', "Record added successfully!");                           
                       }
                       return $this->redirect(['srm/index']);
                   } else if(isset($resArr['status']) && $resArr['status'] == 'error') {
                       Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
                   } else if(isset($resArr['status']) && $resArr['status'] == 401 && $resArr['name'] == 'Unauthorized') {
                       Yii::$app->session->setFlash('errorMsg', $resArr['message']);
                   }
                }                
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('errorMsg', $ex->getMessage());
            }
        }
        if ($id) {
            $userDetails = $this->getUserDetails($id);
            $model->attributes = $userDetails;
            $model->id = (isset($userDetails['id'])) ? $userDetails['id'] : 0;
        }
        return $this->render('index',[ 'model' => $model]);
    }

    public function getUserDetails($id)
    {
        if($id) {            
            $params = Yii::$app->request->post();
            $tmpData = Yii::$app->session['tempUser'];
            $token = (isset($tmpData['accessToken'])) ? $tmpData['accessToken'] : '';

            $url = "http://localhost/restServer/web/index.php/student/update?access-token=".$token.'&id='.$id;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($ch);
            curl_close($ch);
            $data = array();
            if($res != "") {
               $resArr = json_decode($res, true);
               if(isset($resArr['status']) && $resArr['status'] == 'success') {
                   $data = $resArr['data'];
               } else if(isset($resArr['status']) && $resArr['status'] == 'error') {
                   Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
               } else if(isset($resArr['status']) && $resArr['status'] == 401 && $resArr['name'] == 'Unauthorized') {
                   Yii::$app->session->setFlash('errorMsg', $resArr['message']);
               }
            }
            return $data;            
        }        
    }

    public function actionSummary()
    {
        $tmpData = Yii::$app->session['tempUser'];
        $token = (isset($tmpData['accessToken'])) ? $tmpData['accessToken'] : '';
        
        $url = "http://localhost/restServer/web/index.php/student/summary?access-token=".$token;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        curl_close($ch);

        $data = array();
        if($res != "") {
           $resArr = json_decode($res, true);
           if(isset($resArr['status']) && $resArr['status'] == 'success') {
               $data = $resArr['data'];
           } else if(isset($resArr['status']) && $resArr['status'] == 'error') {
               Yii::$app->session->setFlash('errorMsg', $resArr['errors']);
           } else if(isset($resArr['status']) && $resArr['status'] == 401 && $resArr['name'] == 'Unauthorized') {
               Yii::$app->session->setFlash('errorMsg', $resArr['message']);
           }
        }
	 return $this->render('summary',[ 'data' => $data]);        
    }
}
