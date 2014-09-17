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
