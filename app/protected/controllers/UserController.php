<?php
/**
 * User Controller file.
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

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';


	/**
	 * Check if you have sufficient Permissions
	 * @param CAction $action the action to be executed.
	 * @return mixed whether the action should be executed (true)
     * @throws CHttpException(401).
	 */
	protected function beforeAction($action)
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','profile','updateprofile','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny everything else!
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User('create');

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			if($model->save())
			{
				Yii::app()->user->setFlash('success',Yii::t('alerts', 'The User was successfully added.'));
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			if($model->validate() && $model->save())
			{
				Yii::app()->user->setFlash('success',Yii::t('alerts', 'The User was successfully updated.'));
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionProfile($id)
	{
		$this->render('profile',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateProfile($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->validate() && $model->save())
			{
				Yii::app()->user->setFlash('success',Yii::t('alerts', 'The Profile was successfully updated.'));
				$this->redirect(array('profile','id'=>$model->id));
			}
		}

		$this->render('profile_form',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
			$user = $this->loadModel($id);
			if($user->super_admin)
				throw new CHttpException(400,'You can not delete the Super Admin User.');
			else
			{
				try
				{
					$this->loadModel($id)->delete();

					if(!isset($_GET['ajax']))
						Yii::app()->user->setFlash('success',Yii::t('alerts', 'The User was successfully deleted.'));
					else
					{
						echo Yii::t('alerts', 'The User was successfully deleted.');
					}

				}catch(CDbException $e){
					Yii::app()->user->setFlash('error',Yii::t('alerts', "The User was not deleted."));

					if($e->getCode() == 23000)
					{
						$message = CHtml::encode(Yii::t('alerts', "The User was not deleted."));
					} else {
						$message = Yii::t('alerts', "The User couldn't be deleted.");
					}

					if(!isset($_GET['ajax']))
						Yii::app()->user->setFlash('error',$message);
					else
					{
						echo $message;
						Yii::app()->end();
					}

				}
			}

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		if(Yii::app()->request->isAjaxRequest) 
		{
			$this->renderPartial('indexGrid',array('model'=>$model),false,false);
		} else {
			$this->render('index',array('model'=>$model));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
