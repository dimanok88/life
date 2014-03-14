<?php

class BlogController extends Controller
{
	public $layout = 'contact';

	public function actionIndex()
	{
		$this->render("index", array());
	}

	public function actionAddpost()
	{
	    $model=new Blog;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='blog-addpost-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['Blog']))
	    {
	        $model->attributes=$_POST['Blog'];
	        if($model->validate())
	        {
	            // form inputs are valid, do something here
	            return;
	        }
	    }
	    $this->render('addpost',array('model'=>$model));
	}
}

?>