<?php
$this->breadcrumbs=array(
	Yii::t('labels','User')=>array('index'),
	$model->username,
);

$this->menu=array(
	array('label'=>Yii::t('labels','List'),'url'=>array('User/index')),
	array('label'=>Yii::t('labels','Create'),'url'=>array('User/create')),
	array('label'=>Yii::t('labels','Update'),'url'=>array('User/update','id'=>$model->id)),
	array('label'=>Yii::t('labels','Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('User/delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?', 'csrf'=>true)),
);
?>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
	),
)); ?>
