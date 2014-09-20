<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'tweet-user-form',
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

	<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

	<?php echo $form->textFieldGroup($model,'screen_name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'created_at',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>


<?php $this->widget('booster.widgets.TbButton', array(
	'buttonType'=>'submit',
	'context'=>'primary',
	'label'=>$model->isNewRecord ? 'Create' : 'Save',
)); ?>

<?php $this->endWidget(); ?>
