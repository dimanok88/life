<?php

class PagesController extends Controller
{	
	//public $layout = '//layout/page';
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
        );
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($sys)
	{
		$this->layout = 'column2';
		$model = Pages::model()->find("sys=:s AND status=1", array(':s'=>$sys));		
		if(count($model)>0){
		
			$comment = new Comments();
			
			if(isset($_POST['Comments']))
			{
				$comment->attributes=$_POST['Comments'];                        
		        $comment->date_add = new CDbExpression('NOW()');
		        //$comment->text = $_POST['Comments']['text'];
		        if($this->link($comment->text) == true) $comment->active = 0;
				if($comment->save()){
					if($comment->active == 1) Yii::app()->user->setFlash('success','Ваш комментарий добавлен.');
					else Yii::app()->user->setFlash('notice','Ваш комментарий отправлен на проверку.');
					
					if(Yii::app()->user->hasFlash('success')):
						echo "<div class='flash-success'>".Yii::app()->user->getFlash('success')."</div>"; 
					endif;
					if(Yii::app()->user->hasFlash('notice')):
						echo "<div class='flash-notice'>".Yii::app()->user->getFlash('notice')."</div>";
					endif;					
					Yii::app()->end();
		        }
		        else
		        {
		        	echo CHtml::errorSummary($comment);
		        	Yii::app()->end();
		        }
		  	}		
		header("Last-Modified: ".$model['date_modify']."GMT");
		$this->render('view',array(
			'model'=>$model, 'comments'=>$comment
		));
		}
		else throw new CHttpException(404,'Такая страница не найдена.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}		
}
