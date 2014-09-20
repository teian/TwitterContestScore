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
	'Manage',
);

$this->menu=array(
array('label'=>'List TweetUser','url'=>array('index')),
array('label'=>'Create TweetUser','url'=>array('create')),
);

?>

<h1>Manage Tweet Users</h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'tweet-user-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'screen_name',
		'created_at',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
