<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'contest_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'contest_amv_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

		<?php echo $form->textFieldGroup($model,'avg_rating',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>2)))); ?>

		<?php echo $form->textFieldGroup($model,'min_rating',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>2)))); ?>

		<?php echo $form->textFieldGroup($model,'max_rating',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>2)))); ?>

		<?php echo $form->textFieldGroup($model,'votes',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
