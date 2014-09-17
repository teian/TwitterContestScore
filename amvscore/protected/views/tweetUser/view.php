<?php
$this->breadcrumbs=array(
	'Tweet Users'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List TweetUser','url'=>array('index')),
array('label'=>'Create TweetUser','url'=>array('create')),
array('label'=>'Update TweetUser','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete TweetUser','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage TweetUser','url'=>array('admin')),
);
?>

<h1>View TweetUser #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'screen_name',
		'created_at',
),
)); ?>
