<?php
/*
 * Site Controller file.
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

class SiteController extends Controller
{

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','login','error'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('logout'),
				'users'=>array('@'),
			),
			array('deny',  // deny everything else!
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(array('site/index'));
		}

		$model = new LoginForm();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
		{
			echo CActiveForm::validate($model, array('username', 'password', 'verifyCode'));
			Yii::app()->end();
		}

		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			
			if ($model->validate(array('username', 'password', 'verifyCode')) && $model->login())
			{
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}

		$this->render('login', array(
			'model' => $model,
		));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}