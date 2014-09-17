<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'created_at',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		<?php echo $form->textFieldGroup($model,'text',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>150)))); ?>

		<?php echo $form->textFieldGroup($model,'user_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'contest_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'amv_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'rating',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>2)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
