<?php
/* @var $this LogsController */
/* @var $data Logs */
?>

<div class="view">

	User: <?php echo CHtml::encode($data->log_username); ?>
	<?php echo CHtml::encode($data->log_activity); ?>
	at
	<?php echo CHtml::encode($data->log_date); ?>
	<br />
</div>