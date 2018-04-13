<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $name;
    public $email;
    public $user_code;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['username', 'password', 'name', 'email'], 'required'],
            //[['email'], 'email'],
            [['user_code'], 'string'],
            [['name'],'match', 'not' => true, 'pattern' => '/[^a-zA-Z\s]/','message' => 'Invalid characters in name.'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'user_code' => 'Code',
        ];
    }

}
