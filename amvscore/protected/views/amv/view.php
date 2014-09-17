<?php
$this->breadcrumbs=array(
	'AMVs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Amv','url'=>array('index')),
array('label'=>'Create Amv','url'=>array('create')),
array('label'=>'Update Amv','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Amv','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Amv','url'=>array('admin')),
);
?>

<h1>View Amv "ID<?php echo $model->contest_amv_id; ?>" for Contest "<?php echo $model->contest->name; ?>"</h1>

<?php $this->widget('booster.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'contest.name',
			'contest_amv_id',
			'avg_rating',
			'min_rating',
			'max_rating',
			'votes',
	),
)); ?>

<h2>Tweets</h2>

<?php

$dataProvider=new CActiveDataProvider('Tweet', array(
    'criteria'=>array(
        'condition' => 'amv_id = '.$model->id.' AND contest_id = '.$model->contest_id,
    ),
));

$this->widget('booster.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}',
	'columns' => array(
		'user.screen_name',
		'text',		
	),
));
?>