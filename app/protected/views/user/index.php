<?php
$this->breadcrumbs=array(
	Yii::t('labels','User'),
);

$this->menu=array(
	array('label'=>Yii::t('labels', 'List'), 'url'=>array('index')),
	array('label'=>Yii::t('labels', 'Create'), 'url'=>array('create')),
);
?>
<p>
<?php
$this->widget('booster.widgets.TbButton',array(
	'buttonType' => 'link',
	'context'=>'primary',
	'label' => Yii::t("buttons", "Add User"),
	'icon'=>'plus',
	'size' => 'small',		
	'url'=>CHtml::normalizeUrl(array('User/create')),
	'htmlOptions' => array(
        'id'=>'createClaim',
        'class'=>'pull-right'
    )
));
?>
</p>
<?php echo $this->renderPartial('indexGrid', array('model'=>$model)); ?>
