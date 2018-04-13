<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="site-contact">
    
        <h1><?php echo (isset($model->id) && $model->id != "") ? 'Update' : 'Add'; ?> Student</h1>
        
        <?php if(Yii::$app->session->hasFlash('successMsg')): ?>
		<div class="alert-box success">
			<?php echo Yii::$app->session->getFlash('successMsg'); ?>
		</div>
                <br/>
		<?php endif; ?> 
	
		<?php if(Yii::$app->session->hasFlash('errorMsg')): ?>
		<div class="alert-box failure">
                    <?php 
                    $errMsg = Yii::$app->session->getFlash('errorMsg'); 
                    if (is_array($errMsg)) {
                        foreach($errMsg as $err) {
                                echo $err[0]."<br/>";
                        }
                    } else {
                        echo $errMsg;
                    }
                    ?>
		</div>
                <br/>
		<?php endif; ?> 

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'srm2-form']); ?>

                    <?= $form->field($model, 'student_name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'age') ?>

                    <?= $form->field($model, 'math') ?>
                    <?= $form->field($model, 'eng') ?>
                    <?= $form->field($model, 'sci') ?>
                    <?php
                    if (isset($model->id) && $model->id != "") {
                        echo $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); 
                    }
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton((isset($model->id) && $model->id != "") ? 'Update' : 'Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Cancel', ['/srm/index'], ['class'=>'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
</div>
<style>
.alert-box {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;  
}    
.success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.failure {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
</style>