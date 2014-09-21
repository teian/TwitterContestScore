<?php
/**
 * This is the login view
 * @author Frank Gehann <fg@code-works.de>
 * @copyright Copyright (c) Code Works 2014
 *
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

$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'htmlOptions'=>array('class'=>'well'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));

echo $form->textFieldGroup($model, 'username', array('autocomplete'=>'off'));
echo $form->passwordFieldGroup($model, 'password', array('autocomplete'=>'off'));
echo $form->checkBoxGroup($model, 'rememberMe');

if($model->requireCaptcha)
{
	echo $form->captchaGroup($model, 'verifyCode', array('autocomplete'=>'off'));
}

$this->widget('booster.widgets.TbButton', array(
	'buttonType'=>'submit',
	'context'=>'primary', 
	'label'=>Yii::t("buttons", "Login"), 
	'icon'=>'glyphicon glyphicon-log-in'
	)
);

$this->endWidget(); 

?>
