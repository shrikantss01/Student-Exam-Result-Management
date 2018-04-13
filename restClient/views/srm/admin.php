<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="site-contact">
    <h1>ALL Students</h1>
    <div style="float: right;"><?= Html::a('Summarize data', ['/srm/summary'], ['class'=>'btn btn-primary']) ?>&nbsp;<?= Html::a('Add Students', ['/srm/create'], ['class'=>'btn btn-primary']) ?></div>
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
            <?= GridView::widget([
            'dataProvider' => $dp,
            'columns' => [
                'student_name',
                'age',
                'math',
                'sci',
                'eng',
                'total',
                'average',
                'rank',
                [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($id, $model) {
                        return Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-pencil">Edit</b></span>', ['create', 'id' => $model['id']], ['title' => 'Update', 'id' => 'modal-btn-view']);
                    }
                ]
             ],
                
            ],
        ]) ?>
        </div>
</div>
<style>
.alert-box {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    width: 80%;
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
