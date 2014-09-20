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
	'Contests'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Contest','url'=>array('index')),
array('label'=>'Create Contest','url'=>array('create')),
);
?>

<h1>Manage Contests</h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'contest-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'name',
		'trigger',
		'year',
		'active',
		'parse_from',
		'parse_to',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
