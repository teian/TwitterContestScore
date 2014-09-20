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
	$model->id,
);

$this->menu=array(
array('label'=>'List Tweet','url'=>array('index')),
array('label'=>'Create Tweet','url'=>array('create')),
array('label'=>'Update Tweet','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Tweet','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Tweet','url'=>array('admin')),
);
?>

<h1>View Tweet #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'created_at',
		'text',
		'user_id',
		'contest_id',
		'amv_id',
		'rating',
),
)); ?>
