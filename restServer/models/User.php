<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $authKey
 * @property string $accessToken
 * @property string $user_code
 * @property string $created_date
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'email'], 'required'],
            [['email'], 'email'],
            [['user_code'], 'string'],
            [['name'],'match', 'not' => true, 'pattern' => '/[^a-zA-Z\s]/','message' => 'Invalid characters in name.'],
            ['user_code', 'in',  'range' => ['FCV4RS','WE32MN'], 'message' => 'Code must be either "FCV4RS" Or "WE32MN".' ],
            [['created_date'], 'safe'],
            [['username'], 'string', 'max' => 80],
            [['password', 'authKey', 'accessToken'], 'string', 'max' => 250],
            [['name', 'email'], 'string', 'max' => 100],
            [['username','email'], 'unique'],
        ];
    }   
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'email' => 'Email',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'user_code' => 'User Code',
            'created_date' => 'Created Date',
        ];
    }
    
    public static function findIdentity($id) {
        $user = self::find()->where(["id" => $id])->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
    
    public static function findIdentityByAccessToken($token, $userType = null) {
 
        $user = self::find()
                ->where(["accessToken" => $token])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
    
    public static function findByUsername($username) {
        $user = self::find()
                ->where([
                    "username" => $username
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getAuthKey() {
        return $this->authKey;
    }
    
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }    
    
    public function validatePassword($password) {
        return $this->password === md5($password);
    }
    
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }
    
    public function generateAccessTkn()
    {
        return Yii::$app->security->generateRandomString();
    }

}
