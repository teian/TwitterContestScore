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
	'Amvs',
);

$this->menu=array(
array('label'=>'Create Amv','url'=>array('create')),
array('label'=>'Manage Amv','url'=>array('admin')),
);
?>

<h1>Amvs</h1>

<?php
$this->widget('booster.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}',
	'columns' => array(
		'contest_amv_id',
		'contest.name',
		'avg_rating',
		'min_rating',
		'max_rating',
		'votes',
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template' => '{view}',
		),
	)	
));
?>
