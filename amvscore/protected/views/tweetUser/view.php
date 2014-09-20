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
