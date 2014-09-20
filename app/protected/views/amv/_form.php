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
