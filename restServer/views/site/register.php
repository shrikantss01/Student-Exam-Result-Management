<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\user */
/* @var $form ActiveForm */
?>
<div class="site-register">

    <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->errorSummary($model); ?>
    
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'user_code') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
