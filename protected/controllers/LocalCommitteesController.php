<?php

class LocalCommitteesController extends Controller
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
		$actions = array();
		if($role == "Administrator")
			$actions = array('create','view','index','admin','search','delete','update');
		else if($role == "LGU")
			$actions = array('view', 'index');
		
		array_push($actions, 'view', 'index');
		
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>$actions,
				'users'=>array('@'),
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
	
		$model = $this->loadModel($id);
		$members = $model->loadMembers($model);
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'members'=>$members,
		));
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LocalCommittees;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LocalCommittees']))
		{
			$model->attributes=$_POST['LocalCommittees'];
			$model->setAttribute('lc_id', com_create_guid());
			
			if($model->validate()){
				$model->clearUsers($_POST['LocalCommittees']['lc_members']);
				
				if($model->lc_members!=null)
					$model->saveMembers($model->lc_id, $_POST['LocalCommittees']['lc_members']);
				if($model->save()){
					
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => com_create_guid(),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Created Local Committee '.$model->lc_name,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
					
					$this->redirect(array('view','id'=>$model->lc_id));
					
				}
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LocalCommittees']))
		{
			$model->attributes=$_POST['LocalCommittees'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->lc_id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LocalCommittees');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LocalCommittees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LocalCommittees']))
			$model->attributes=$_GET['LocalCommittees'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LocalCommittees the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LocalCommittees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LocalCommittees $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='local-committees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
