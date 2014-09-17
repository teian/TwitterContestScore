<?php
$this->breadcrumbs=array(
	'Tweet Users'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List TweetUser','url'=>array('index')),
array('label'=>'Manage TweetUser','url'=>array('admin')),
);
?>

<h1>Create TweetUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>