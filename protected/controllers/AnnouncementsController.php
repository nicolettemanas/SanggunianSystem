<?php

class AnnouncementsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		$role = Yii::app()->user->getState('role');
		
		if($role != "General Public")
			$actions = array('index', 'create', 'update', 'delete', 'view', 'admin', 'search');
		else
			$actions = array('index', 'view');
			
		
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>$actions,
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
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
		$model=new Announcements;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Announcements']))
		{
			$date = new DateTime();
			
			$model->attributes=$_POST['Announcements'];
			$model->setAttribute('ann_creation_date', $date->format('Y-m-d H:i:s'));
			$model->setAttributes(array(
				'ann_id' => com_create_guid(),
				'ann_author' => Yii::app()->user->getState('id'),
			));
			
			if($model->save()){
				
				$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
				
				$log = new Logs();
				$log->setAttributes(array(
					'log_id' => com_create_guid(),
					'log_userid' => $user->user_id,
					'log_username' => $user->user_username,
					'log_activity' => 'Created announcement '.$model->ann_title,
					'log_date' => date('Y-m-d H:m:s')
				));
				
				$log->save();
				
				$this->redirect(array('view','id'=>$model->ann_id));
				
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
		$date = new DateTime();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		if(isset($_POST['Announcements']))
		{
			$model->attributes=$_POST['Announcements'];
			$model->setAttribute('ann_creation_date', $date->format('Y-m-d H:i:s'));
			if($model->save()){
				
				$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
				
				$log = new Logs();
				$log->setAttributes(array(
					'log_id' => com_create_guid(),
					'log_userid' => $user->user_id,
					'log_username' => $user->user_username,
					'log_activity' => 'Updated announcement '.$model->ann_title,
					'log_date' => date('Y-m-d H:m:s')
				));
				
				$log->save();
				
				$this->redirect(array('view','id'=>$model->ann_id));
				
			}
		}

		if(Yii::app()->user->getState('role') != 'Administrator'
			&& $model->ann_author != Yii::app()->user->getState('id')){
				throw new CHttpException(403,'You are not authorized to perform this action.');
		}
		
		$this->render('update',array(
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
		$model=$this->loadModel($id);

		if(Yii::app()->user->getState('role') != 'Administrator'
			&& $model->ann_author != Yii::app()->user->getState('id')){
			throw new CHttpException(403,'You are not authorized to perform this action.');
		}
		else{
			
			$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
			
			$log = new Logs();
			$log->setAttributes(array(
				'log_id' => com_create_guid(),
				'log_userid' => $user->user_id,
				'log_username' => $user->user_username,
				'log_activity' => 'Deleted announcement '.$model->ann_title,
				'log_date' => date('Y-m-d')
			));
			
			$log->save();
			
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Announcements', array(
			'criteria'=>array(
				'order'=>'ann_creation_date DESC',
			)
		));
		$model = new Announcements();
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Announcements('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Announcements']))
			$model->attributes=$_GET['Announcements'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Announcements the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Announcements::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Announcements $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='announcements-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
