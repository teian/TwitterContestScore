<?php
$this->breadcrumbs=array(
	Yii::t('labels','User')=>array('index'),
	Yii::t('labels','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('labels', 'List'), 'url'=>array('index')),
	array('label'=>Yii::t('labels', 'Create'), 'url'=>array('create')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>