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