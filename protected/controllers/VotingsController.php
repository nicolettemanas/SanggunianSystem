<?php

class VotingsController extends Controller
{
	public function actionIndex()
	{
		
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		$model = Votings::model()->findByPk($id);
		
		//$comments = $model->getComments($id);
		$this->render('view',array(
			'model'=>$model
		));
	}
		

	public function actionViewOrdinances($id,$vote)
	{
		$model=Users::model()->findByPk($id);

		$this->render('viewOrdinances',array(
			'model'=>$model,
			'vote'=>$vote
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Votings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Votings']))
			$model->attributes=$_GET['Votings'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
}