<?php

class CategoryController extends ContController
{
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id= '')
	{		
		$cats = Category::model()->AllCategoryArray(true, $id);
		$model= new Category();
		if(!empty($id)) $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$model->date_modify = date('Y-m-d H:i:s');
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model, 'cat'=>$cats
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
		$r = Yii::app()->getRequest();		
		if($r->getParam('editable'))
		{
			$val = $r->getParam('value');
			$id_i = $r->getParam('id');
			$atr = $r->getParam('attribute');
			Category::model()->updateByPk($id_i, array($atr=>$val));
			echo $val;
			Yii::app()->end();
		}
		
		$cats = Category::model()->AllCategoryArray(true);
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model, 'cat'=>$cats
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$r = Yii::app()->getRequest();		
		if($r->getParam('editable'))
		{
			$val = $r->getParam('value');
			$id_i = $r->getParam('id');
			$atr = $r->getParam('attribute');
			Category::model()->updateByPk($id_i, array($atr=>$val));
			echo $val;
			Yii::app()->end();
		}
	
		$cats = Category::model()->AllCategoryArray(true);
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model, 'cat'=>$cats
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
