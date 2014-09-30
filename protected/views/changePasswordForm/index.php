<?php
/* @var $this ChangePasswordFormController */

$this->breadcrumbs=array(
	'Change Password Form',
);
?>

<h1>Change Passwords</h1>

<p>
	
</p>
<?php var_dump($_POST); ?>
<?php $this->redirect('', array('model'=>$model, 'url'=>array('change'))); ?>
