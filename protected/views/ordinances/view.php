<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	$model->ord_id,
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Create Ordinances', 'url'=>array('create')),
	array('label'=>'Update Ordinances', 'url'=>array('update', 'id'=>$model->ord_id)),
	array('label'=>'Delete Ordinances', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ord_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);

$baseUrl = Yii::app()->baseUrl; 
?>

<h1>View Ordinance: <?php echo $model->ord_title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ord_title',
		'ord_no',
		array(
			'name'=>'version',
			'value'=>$model->getV($model->ord_id),
		),
		'ord_description',
		array(
			'name'=>'ord_authors_id',
			'value'=>$model->getAuthor($model->ord_id),
		),
		'ord_creation_date',
		'ord_effectivity_date',
		'ord_approval_date',
		'ord_status',
		'ord_approval_status',
		array(
			'name'=>'ord_committee_id',
			'value'=>$model->getCommittee($model->ord_committee_id),
		),
		'ord_ordtype',
	),
)); ?>

<br />
<br />
<br />
<div class="row">
	<?php echo CHtml::htmlbutton('View Ordinance', array('id'=>'view_ordinance', 'name'=>'toggle_view')); ?>
	<?php echo CHtml::htmlbutton('View Committee Report', array('id'=>'view_report', 'name'=>'toggle_view')); ?>
	<?php echo CHtml::htmlbutton('View Minutes of the Meeting', array('id'=>'view_minutes', 'name'=>'toggle_view')); ?>
	<?php echo CHtml::hiddenField('view_pdf', $model->ord_file_id, array('id'=>'pdf_id')); ?>
	<?php echo CHtml::hiddenField('view_report', $model->ord_committee_report_file_id, array('id'=>'report_id')); ?>
	<?php echo CHtml::hiddenField('view_minutes', $model->get_minutes($model->ord_id), array('id'=>'minutes_id')); ?>
</div>

<div id="pdf" style="height: 700px; width: 129%;" class="row">
</div>


<script type="text/javascript" src="<?php echo $baseUrl ?>/js/pdfobject.js"></script>
<script type='text/javascript'>

  function embedPDF(tag_id){
	var myPDF = new PDFObject({ 
		url: 'uploads/'+tag_id,
		pdfOpenParams: { scrollbars: '1', toolbar: '1', statusbar: '1' }
    }).embed('pdf'); 
  }
	
  window.onload = function(){
	embedPDF($('#pdf_id').val()); 
	console.log(document.getElementById('report_id').value);
	var e = document.getElementsByName('toggle_view');
  
	for(i=0;i<e.length;i++){
		console.log(e[i]);
		//e[0].onclick = function(){alert("dasd")};
		e[i].onclick = function(){
			if(this.id == "view_ordinance"){
				console.log($('#pdf_id').val());
				embedPDF($('#pdf_id').val());
			}
			else if(this.id == "view_report"){
				var val = $('#report_id').val();
				console.log(val);
				if(val == "Approve without report")
					alert('Committee approved the proposal without a report.');
				else if(val == "")
					alert('No reports yet available.');
				else embedPDF(val);
			}
			else if(this.id == "view_minutes"){
				val = $('#minutes_id').val();
				if(val != "")
					embedPDF(val);
				else
					alert("No minutes of the meeting available.");
			}
		}
	}
  }
</script>
	
