<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'amv-form',
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

	<?php echo $form->select2Group($model, 'contest_id', array(			
		'widgetOptions' => array(
			'asDropDownList' => true,
			'data'=> array(''=>Yii::t('labels','')) + CHtml::listData( Contest::model()->findAll(), 'id', 'name'), 
			'options'=>array(
				'placeholder' => Yii::t('labels', 'Select Contest'),
				'allowClear' => true,
				//'width' => '216px',
			),
		)
	));	
	?>

	<?php echo $form->textFieldGroup($model,'contest_amv_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>20)))); ?>


<?php $this->widget('booster.widgets.TbButton', array(
	'buttonType'=>'submit',
	'context'=>'primary',
	'label'=>$model->isNewRecord ? 'Create' : 'Save',
)); ?>

<?php $this->endWidget(); ?>
