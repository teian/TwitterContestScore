<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

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

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
