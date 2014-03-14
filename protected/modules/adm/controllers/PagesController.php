<?php

class PagesController extends ContController
{
	
	public function actionUpdate($id = '', $type= '')
	{
		$model=new Pages;
		$cats = Category::model()->AllCategoryArray(true);
        if(!empty($id)) $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pages']))
		{
			$model->attributes=$_POST['Pages'];
			$imageHandler = new CImageHandler();
            $model->type = $_GET['type'];
	        	       
            if($model->save()){
            	if(!empty($_FILES['Pages']['tmp_name']['image'])){
    	            $path = Yii::app() -> getBasePath() . "/../resources/upload/";    	            
    	            $imageHandler->load ($_FILES['Pages']['tmp_name']['image'])->save($path.$model->id.".jpg")->thumb(440,false)->save($path.$model->id."_page.jpg");
    	            $imageHandler->load ($_FILES['Pages']['tmp_name']['image'])->thumb(590,false)->save($path.$model->id."_page_s.jpg");
                $imageHandler->load ($_FILES['Pages']['tmp_name']['image'])->thumb(100,false)->save($path.$model->id."_page_mini.jpg");
                }
				$this->redirect(array('index', 'type'=>$type));
            }
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
		$cats = Category::model()->AllCategoryArray(true);
		$model=new Pages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pages']))
			$model->attributes=$_GET['Pages'];

		$this->render('admin',array(
			'model'=>$model, 'cat'=>$cats
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$cats = Category::model()->AllCategoryArray(true);
		$model=new Pages();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pages']))
			$model->attributes=$_GET['Pages'];

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
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionSucc($id)
    {
        if(Yii::app()->request->isPostRequest)
		{
			Pages::model()->updateByPk($id, array('status'=>'0'));

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionUnsucc($id)
    {
        if(Yii::app()->request->isPostRequest)
		{
			Pages::model()->updateByPk($id, array('status'=>'1'));

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionPLink()
    {
	    $pages = Pages::model()->findAll();
	    foreach($pages as $page){
		$url1 = Yii::app()->createUrl('pages/view', array('id'=>$page['id'], 'cat'=>$page['category_id'], 'tl'=>Controller::translit($page['title'])));
		$url2 = substr($url1, 0, -5);
		$url = substr($url2, 7);
		echo $url."<br/>";
		Pages::model()->updateByPk($page['id'], array('sys'=>$url));
	    }

    }

}
