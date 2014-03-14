<?php

class CategoryController extends Controller
{

	public $layout='//layouts/main';

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
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Category::model()->findByPk($id, 'active=1');		
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
			
			
			//$pages= '';
			$pages = Pages::model()->listpage($id);
			header("Last-Modified: ".$model->date_modify."GMT");
			$this->render('view',array(
				'model'=>$model, 'pages'=>$pages, 'comments'=>$comment
			));
		}
		else throw new CHttpException(404,'Такая страница не найдена.');
	}
		

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	
	public function actionSearch()
    {
            $search = new SearchForm();
                
                if(isset($_POST['SearchForm'])) {
                        $search->attributes = $_POST['SearchForm'];
                        $_GET['searchString'] = $search->string;
                } else {
                        $search->string = $_GET['searchString'];
                }
                
                $command = Yii::app()->db->createCommand();
                
                if(!empty($search->string)){
		            $command->insert('{{search}}', array(
						'string'=>$search->string,
						'date'=>date('Y-m-d H:i:s'),
						'ip'=>CHttpRequest::getUserHostAddress()
					));
				}
                
                $criteria = new CDbCriteria();                
                //$criteria->order = "id DESC";
                $criteria->condition = '(`full_desc` LIKE :keyword OR title LIKE :t) AND status=1';
				$criteria->params = array(':keyword'=>'%'.$search->string.'%', ':t'=>'%'.$search->string.'%');
                                                  
				$materials =  new CActiveDataProvider("Pages", array(
					'criteria'=>$criteria,
				));                                                             
                                                    
                $this->render('found',array(
                        'materials' => $materials,
                        'search' => $search,
                ));

        }	
}
