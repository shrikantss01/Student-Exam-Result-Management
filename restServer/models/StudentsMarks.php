<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_students_marks".
 *
 * @property int $id
 * @property string $student_name
 * @property string $age
 * @property double $math
 * @property double $sci
 * @property double $eng
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 */
class StudentsMarks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_students_marks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_name', 'age', 'math', 'sci', 'eng'], 'required'],
            [['student_name'],'match', 'not' => true, 'pattern' => '/[^a-zA-Z\s]/','message' => 'Invalid characters in name.'],
            [['age','math', 'sci', 'eng'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['student_name'], 'string', 'max' => 100],
            ['age', 'in','range'=>range(5,50),'message'=>'Age must be in between 5 and 50'],
            [['age'], 'string', 'max' => 2],
            [['math','sci','eng'],'number','min'=>0,'max'=>100],
            [['created_by', 'updated_by'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_name' => 'Student Name',
            'age' => 'Age',
            'math' => 'Math',
            'sci' => 'Sci',
            'eng' => 'Eng',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }
}
