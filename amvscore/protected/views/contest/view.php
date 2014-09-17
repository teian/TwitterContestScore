<?php
$this->breadcrumbs=array(
	'Contests'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Contest','url'=>array('index')),
array('label'=>'Create Contest','url'=>array('create')),
array('label'=>'Update Contest','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Contest','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Contest','url'=>array('admin')),
);
?>

<h1>View Contest #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'name',
		'trigger',
		'year',
		'active',
		'parse_from',
		'parse_to',
),
)); ?>

<h2>AMVs</h2>


