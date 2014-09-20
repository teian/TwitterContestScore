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
	$model->name,
);

$this->menu=array(
array('label'=>'List Contest','url'=>array('index')),
array('label'=>'Create Contest','url'=>array('create')),
array('label'=>'Update Contest','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Contest','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Contest','url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?> (<?php echo $model->year; ?>)</h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'trigger',
		'year',
		'active:boolean',	
		'parse_from',
		'parse_to',
),
)); ?>

<h2>AMVs</h2>

<?php

$dataProvider=new CActiveDataProvider('Amv', array(
    'criteria'=>array(
        'condition' => 'contest_id = '.$model->id,
    ),
));

$this->widget('booster.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}',
	'columns' => array(
		array(
			'name' => 'contest_amv_id',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->contest_amv_id), array("Amv/view","id"=>$data->id))',
		),
		'avg_rating',
		'min_rating',
		'max_rating',
		'votes',
	),
));
?>

