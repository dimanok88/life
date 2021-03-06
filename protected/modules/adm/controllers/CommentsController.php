<?php

class CommentsController extends ContController
{
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = '')
	{
        $model=new Comments;
        if(!empty($id)) $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];
			if($model->save())
				$this->redirect(array('index'));
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Comments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comments']))
			$model->attributes=$_GET['Comments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Comments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comments']))
			$model->attributes=$_GET['Comments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Comments::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAnswer($id)
	{		
		$comment = Comments::model()->findByPk($id);
		
		if(isset($_POST['Comments']))
		{
			//print_r($_POST)
			//if(Yii::app()->request->isAjaxRequest)
		    //{	
		    	$comment->answer = $_POST['Comments']['answer'];
		    	if($comment->save(false)){
		    		if(!empty($comment->email) && !empty($comment->answer))Comments::model()->SendAnswer($comment->email, $comment->answer, $comment->link);
					/*Yii::app()->user->setFlash('success','Ваш ответ сохранен.');
					if(Yii::app()->user->hasFlash('success')):
				    echo '<div class="flash-success">';
				        echo Yii::app()->user->getFlash('success');
				    echo '</div>';
					endif;*/
					
					$this->redirect(array('comments/index'));
				}
				Yii::app()->end();
		     //}
		     //else $this->redirect(array('comments/'));
		}
				
        
       // if(!Yii::app()->request->isAjaxRequest)
	    //{
            $this->render('view',array(
                'comment'=>$comment,
            ));
        /*}
        else
        {            
            $this->renderPartial('view',array(
                'comment'=>$comment,
            ), false, true);
        }*/
	}

}
