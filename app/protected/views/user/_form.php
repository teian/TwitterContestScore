<div class="row">
	<div class="col-sm-12">
		<p class="note"><?php echo Yii::t("info", "Fields with * are required.") ?></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
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
		<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldGroup($model,'username', array(
			'class'=>'col-xs-12', 
			'maxlength'=>45
		)); ?>

		<?php if($model->isNewRecord) : ?>
		
		<?php echo $form->passwordFieldGroup($model,'password', array(
			'class'=>'col-xs-12', 
			'maxlength'=>50,
			'autocomplete'=>'off'
		)); ?>
		
		<?php else : ?>
		
		<?php echo $form->passwordFieldGroup($model,'newPassword', array(
			'class'=>'col-xs-12', 
			'maxlength'=>50,
			'autocomplete'=>'off'
		)); ?>

		<?php echo $form->passwordFieldGroup($model,'passwordConfirm', array(
			'class'=>'col-xs-12', 
			'maxlength'=>50,
			'autocomplete'=>'off'
		)); ?>

		<?php endif; ?>

		<?php echo $form->textFieldGroup($model,'email',array(
			'class'=>'col-xs-12', 
			'maxlength'=>255
		)); ?>

		<?php echo $form->checkboxGroup($model,'requires_new_password'); ?>

		<div class="form-actions">
			<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType'=>'submit',
				'context'=>'primary',
				'label'=>$model->isNewRecord ? Yii::t('labels','Create') : Yii::t('labels','Save'),
			)); ?>
		</div>

	<?php $this->endWidget(); ?>
	</div>
</div>
