<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/
?>

<?php
$this->breadcrumbs=array(
	'Contests'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Contest','url'=>array('index')),
	array('label'=>'Create Contest','url'=>array('create')),
	array('label'=>'View Contest','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Contest','url'=>array('admin')),
	);
	?>

	<h1>Update Contest <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>