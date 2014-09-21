<?php
$this->breadcrumbs=array(
	Yii::t('labels','User')=>array('profile', 'id'=>Yii::app()->user->id),
	$model->username,
);

$this->menu=array(
	array('label'=>Yii::t('labels','Show Profile'),'url'=>array('User/profile', 'id'=>Yii::app()->user->id)),
	array('label'=>Yii::t('labels','Update'),'url'=>array('User/updateprofile', 'id'=>Yii::app()->user->id)),
);

$profile_menu = array();

$edit_profile = array(
	'class' => 'booster.widgets.TbButton',
	'buttonType' => 'link',
	'context' => 'primary',
	'label' => Yii::t('labels','Update Profile'),
	'icon'=> 'wrench',
	'size' => 'small',
	'url'=> CHtml::normalizeUrl(array('User/updateprofile', 'id'=>Yii::app()->user->id)),
);
array_push($profile_menu, $edit_profile);

$this->widget('booster.widgets.TbPanel', array(
    'title' => Yii::t('labels', 'Entry Data'),
    'headerIcon' => 'info-sign',
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'size' => 'extra_small',
            'buttons' => $profile_menu,
        ),
    ),                  
    'content' => $this->widget('booster.widgets.TbDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'username',
			'email',
		),
	), true),
));

?>
