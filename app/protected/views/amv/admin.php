<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/
?>

<?php
$this->breadcrumbs=array(
	'Amvs'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Amv','url'=>array('index')),
array('label'=>'Create Amv','url'=>array('create')),
);
?>

<h1>Manage Amvs</h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'amv-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'contest.name',
		'contest_amv_id',
		'avg_rating',
		'min_rating',
		'max_rating',
		'votes',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
