<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="site-contact">
    
        <h1>Summarize Data</h1>
        
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
           <h3>Number of pass students : <?php echo isset($data['pass_count']) ? $data['pass_count'] : 0  ?></h3>
	   <h3>Number of fail students : <?php echo isset($data['fail_count']) ? $data['fail_count'] : 0  ?></h3>  	  
        </div>
	<div class="row">
		<h3>Student topper in Math :</h3>
		<table class="table table-striped table-bordered">
			<tr><th>Name</th><th>Marks</th></tr>
		        <?php
			if (!empty($data['mathStudent'])) {
				foreach ($data['mathStudent'] as $mathRow) {
					echo '<tr><td>'.$mathRow['student_name'].'</td><td>'.$mathRow['max_math'].'</td></tr>';
				}
							
			} else {
			 echo '<tr><td colspan="2">No Records</td></tr>';
			}
			?>
		</table>
	</div>

	<div class="row">
		<h3>Student topper in Science :</h3>
		<table class="table table-striped table-bordered">
			<tr><th>Name</th><th>Marks</th></tr>
		        <?php
			if (!empty($data['sciStudent'])) {
				foreach ($data['sciStudent'] as $mathRow) {
					echo '<tr><td>'.$mathRow['student_name'].'</td><td>'.$mathRow['max_sci'].'</td></tr>';
				}
							
			} else {
			 echo '<tr><td colspan="2">No Records</td></tr>';
			}
			?>
		</table>
	</div>

	<div class="row">
		<h3>Student topper in English :</h3>
		<table class="table table-striped table-bordered">
			<tr><th>Name</th><th>Marks</th></tr>
		        <?php
			if (!empty($data['engStudent'])) {
				foreach ($data['engStudent'] as $mathRow) {
					echo '<tr><td>'.$mathRow['student_name'].'</td><td>'.$mathRow['max_eng'].'</td></tr>';
				}
							
			} else {
			 echo '<tr><td colspan="2">No Records</td></tr>';
			}
			?>
		</table>
	</div>

	<div class="row">
		<h3>Student topper in all subject :</h3>
		<table class="table table-striped table-bordered">
			<tr><th>Name</th><th>Math</th><th>Science</th><th>English</th></tr>
		        <?php
			if (!empty($data['subToppers'])) {
				foreach ($data['subToppers'] as $subRow) {
					echo '<tr><td>'.$subRow['student_name'].'</td><td>'.$subRow['max_math'].'</td><td>'.$subRow['max_sci'].'</td><td>'.$subRow['max_eng'].'</td></tr>';
				}
							
			} else {
			 echo '<tr><td colspan="4">No Records</td></tr>';
			}
			?>
		</table>
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
