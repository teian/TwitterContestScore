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
