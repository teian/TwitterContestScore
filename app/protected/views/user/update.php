<?php
$this->breadcrumbs=array(
	Yii::t('labels','User')=>array('index'),
	$model->username=>array('view','id'=>$model->id),
	Yii::t('labels','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('labels','List'),'url'=>array('User/index')),
	array('label'=>Yii::t('labels','Create'),'url'=>array('User/create')),
	array('label'=>Yii::t('labels','Update'),'url'=>array('User/update','id'=>$model->id)),
	array('label'=>Yii::t('labels','Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('User/delete','id'=>$model->id),'confirm'=>Yii::t('alerts', 'Are you sure you want to delete this item?'), 'csrf'=>true)),
);
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>