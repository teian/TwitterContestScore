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
	'Contests',
);

$this->menu=array(
array('label'=>'Create Contest','url'=>array('create')),
array('label'=>'Manage Contest','url'=>array('admin')),
);
?>

<h1>Contests</h1>

<?php

$this->widget('booster.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}{pager}',
	'columns' => array(
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->name), array("Contest/view","id"=>$data->id))',
		),
		'year',
		'active:boolean',
	),
));
?>
