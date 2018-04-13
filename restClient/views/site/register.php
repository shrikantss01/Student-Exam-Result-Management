<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="site-contact">
    <h1>Sign Up </h1>
	
		<?php if(Yii::$app->session->hasFlash('successMsg')): ?>
		<div class="alert-success">
			<?php echo Yii::$app->session->getFlash('successMsg'); ?>
		</div>
	    <br/>
		<?php endif; ?> 
	
		<?php if(Yii::$app->session->hasFlash('errorMsg')): ?>
		<div class="flash-error error">
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

                <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password') ?>

                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'user_code') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;<?= Html::a('login', ['/site/login'], ['class'=>'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
</div>
<style>
.error { color: #a94442;}
</style>
