<?php
$this->breadcrumbs=array(
	'Amvs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Amv','url'=>array('index')),
	array('label'=>'Create Amv','url'=>array('create')),
	array('label'=>'View Amv','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Amv','url'=>array('admin')),
	);
	?>

	<h1>Update Amv <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>