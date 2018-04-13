<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Srm extends Model
{
    public $id;
    public $student_name;
    public $age;
    public $math;
    public $sci;
    public $eng;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['student_name', 'age', 'math', 'sci', 'eng'], 'required'],
            ['student_name','string'],
            [['student_name'],'match', 'not' => true, 'pattern' => '/[^a-zA-Z\s]/','message' => 'Invalid characters in name.'],
            ['age', 'in','range'=>range(5,50),'message'=>'Age must be in between 5 and 50'],
            [['age','math','sci','eng'],'integer'],
            [['math','sci','eng'],'number','min'=>0,'max'=>100],
//            ['math,science,english','number','length' => [4, 10]]
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'student_name' => 'Name',
            'age' => 'Age',
            'math' => 'Marks in Math',
            'sci' => 'Marks in Science',
            'eng' => 'Marks in English',
        ];
    }
}
