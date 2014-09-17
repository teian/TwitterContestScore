<?php
$this->breadcrumbs=array(
	'Tweet Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List TweetUser','url'=>array('index')),
	array('label'=>'Create TweetUser','url'=>array('create')),
	array('label'=>'View TweetUser','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TweetUser','url'=>array('admin')),
	);
	?>

	<h1>Update TweetUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>