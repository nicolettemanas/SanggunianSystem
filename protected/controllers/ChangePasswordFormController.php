<?php

class ChangePasswordFormController extends Controller
{
	public $id = "Change Password";
	
	public function actionIndex($id)
	{
		$model = new ChangePasswordForm();
		$user=$this->loadModel($id);
		//$this->render('change', array('user'=>$user, 'model'=>$model));
		//var_dump($_POST);
		$this->redirect(array('/changePasswordForm/change','id'=>$id));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionChange()
	{
		$model = new ChangePasswordForm;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
		  echo CActiveForm::validate($model);
		  Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ChangePasswordForm']))
		{
		  $model->attributes=$_POST['ChangePasswordForm'];
		// validate user input and redirect to the previous page if valid
		  if($model->validate() && $model->changePassword())
		  {
		   $this->redirect( $this->action->id );
		  }
		  var_dump($_POST);
		}
		
		$this->render('change',array('model'=>$model));
	}
}