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
	$model->contest->name => array('Contest/view', 'id' =>$model->contest_id),
	'AMV ID ' . $model->contest_amv_id,
);

$this->menu=array(
array('label'=>'List Amv','url'=>array('index')),
array('label'=>'Create Amv','url'=>array('create')),
array('label'=>'Update Amv','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Amv','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Amv','url'=>array('admin')),
);
?>

<h1><?php echo $model->contest->name; ?></h1>
<h2>AMV ID<?php echo $model->contest_amv_id; ?></h2>

<?php $this->widget('booster.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
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
    'pagination'=>array(
		'pageSize'=> 25,
	),
));

$this->widget('booster.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}{pager}',
	'columns' => array(
		'user.screen_name',
		'text',		
	),
));
?>