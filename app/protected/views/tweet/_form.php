<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'tweet-form',
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

	<?php echo $form->textFieldGroup($model,'created_at',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

	<?php echo $form->textFieldGroup($model,'text',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>150)))); ?>

	<?php echo $form->textFieldGroup($model,'user_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

	<?php echo $form->textFieldGroup($model,'contest_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

	<?php echo $form->textFieldGroup($model,'amv_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

	<?php echo $form->textFieldGroup($model,'rating',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>2)))); ?>


<?php $this->widget('booster.widgets.TbButton', array(
	'buttonType'=>'submit',
	'context'=>'primary',
	'label'=>$model->isNewRecord ? 'Create' : 'Save',
)); ?>

<?php $this->endWidget(); ?>
