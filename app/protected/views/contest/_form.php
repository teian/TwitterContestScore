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

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'contest-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
    	'class' => 'well',
    	'role' => 'form',
   	),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

<?php echo $form->textFieldGroup($model,'trigger',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

<?php echo $form->textFieldGroup($model,'year',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>4)))); ?>

<?php echo $form->switchGroup($model, 'active'); ?>

<?php echo $form->datepickerGroup($model, 'parse_from', array(
	'hint'=>Yii::t('info', 'Click inside to choose date.'),
	'widgetOptions' => array(
		'options'=>array(
			'format'=> 'yyyy-mm-dd',
			'autoclose' => true,
			'todayHighlight'=> true,
		),
	),
)); ?>	

<?php echo $form->datepickerGroup($model, 'parse_to', array(
	'hint'=>Yii::t('info', 'Click inside to choose date.'),
	'widgetOptions' => array(
		'options' => array(
			'format' => 'yyyy-mm-dd',
			'autoclose' => true,
			'todayHighlight' => true,
		),
	),
)); ?>

<?php $this->widget('booster.widgets.TbButton', array(
	'buttonType'=>'submit',
	'context'=>'primary',
	'label'=>$model->isNewRecord ? 'Create' : 'Save',
)); ?>

<?php $this->endWidget(); ?>
