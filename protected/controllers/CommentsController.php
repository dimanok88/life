<?php

class CommentsController extends Controller
{
	public function actions()    {
        return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF, //цвет фона капчи
				'testLimit'=>1, //сколько раз капча не меняется
				'maxLength'=> 4,
				'minLength'=> 1,
				'transparent'=>false,
				'foreColor'=>0x000000, //цвет символов
			),
            /*'captcha'=>array(
                'class'=>'Yii3dCaptcha',
				'backColor'=>0xD3E5EA, //цвет фона капчи
				'testLimit'=>1, //сколько раз капча не меняется
				'maxLength'=> 20,
				'minLength'=> 1,
				'transparent'=>false,
				'foreColor'=>0x000000, //цвет символов
            ),*/
        );
    }
    
    public function link($text)
    {
    	$url = $text;
		if (preg_match('!.*(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?!ium', $url)) {
			return true;
		}		
		else {
			return false;
		}
    }
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd($type_item='cat', $id_item = 1)
	{
		$model=new Comments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];                        
            $model->type_item = $type_item;
            $model->id_item = $id_item;
            $model->date_add = new CDbExpression('NOW()');
            if($this->link($model->text) == true) $model->active = 0;
			if($model->save()){
				if($model->active == 1) Yii::app()->user->setFlash('success','Ваш комментарий добавлен.');
				else Yii::app()->user->setFlash('notice','Ваш комментарий отправлен на проверку.');
				$this->redirect($_SERVER['HTTP_REFERER']);
            }
		}

		$this->redirect($_SERVER['HTTP_REFERER']);
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
}
