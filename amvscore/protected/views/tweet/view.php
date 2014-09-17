<?php
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
