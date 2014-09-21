<?php 
	$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
		'validateOnType'=>false,
	),
	'htmlOptions'=>array('class'=>'well'),
	)); 
?>
	<p class="note"><?php echo Yii::t("note", "Fields with * are required."); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php if($model->requires_new_password) : ?>
	<div class="alert alert-info">
		<p><?php echo Yii::t("info", "Please change your password."); ?></p>
	</div>
	<?php endif; ?>
	
	<?php echo $form->passwordFieldGroup($model,'newPassword',array(
		'class'=>'col-xs-12', 
		'maxlength'=>50,
		'autocomplete'=>'off'
	)); ?>

	<?php echo $form->passwordFieldGroup($model,'passwordConfirm',array(
		'class'=>'col-xs-12', 
		'maxlength'=>50,
		'autocomplete'=>'off'
	)); ?>

	<?php echo $form->textFieldGroup($model,'email',array(
		'class'=>'col-xs-12', 
		'maxlength'=>255
	)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('labels','Create') : Yii::t('labels','Save'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
