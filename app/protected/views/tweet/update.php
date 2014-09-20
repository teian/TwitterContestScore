<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/

$this->breadcrumbs=array(
	'Tweets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Tweet','url'=>array('index')),
	array('label'=>'Create Tweet','url'=>array('create')),
	array('label'=>'View Tweet','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Tweet','url'=>array('admin')),
	);
	?>

	<h1>Update Tweet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>