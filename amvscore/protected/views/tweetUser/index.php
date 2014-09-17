<?php
$this->breadcrumbs=array(
	'Tweet Users',
);

$this->menu=array(
array('label'=>'Create TweetUser','url'=>array('create')),
array('label'=>'Manage TweetUser','url'=>array('admin')),
);
?>

<h1>Tweet Users</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
