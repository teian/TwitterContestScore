<?php
$this->breadcrumbs=array(
	Yii::t('labels','User')=>array('profile', 'id'=>$model->id),
	$model->username=>array('profile','id'=>$model->id),
	Yii::t('labels','Profile Update'),
);

$this->menu=array(
	array('label'=>Yii::t('labels','Show Profile'),'url'=>array('User/profile', 'id'=>Yii::app()->user->id)),
	array('label'=>Yii::t('labels','Update'),'url'=>array('User/updateprofile','id'=>$model->id)),
);
?>

<?php echo $this->renderPartial('_profile',array('model'=>$model)); ?>