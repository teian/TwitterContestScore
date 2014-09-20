<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<?php 
$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'login-form',
        'htmlOptions' => array(
        	'class' => 'well',
        	'role' => 'form',
       	),
       	'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
    )
);
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'username'); ?>

<?php echo $form->passwordFieldGroup($model, 'password', array(
	'hint' => 'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.',
)); ?>

<?php echo $form->checkboxGroup($model, 'rememberMe'); ?>

<?php $this->widget(
    'booster.widgets.TbButton',
    array('buttonType' => 'submit', 'label' => 'Log in')
); ?>

<?php $this->endWidget(); ?>
