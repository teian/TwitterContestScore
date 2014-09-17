<?php
$this->breadcrumbs=array(
	'Amvs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Amv','url'=>array('index')),
array('label'=>'Manage Amv','url'=>array('admin')),
);
?>

<h1>Create Amv</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>