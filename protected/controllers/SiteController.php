<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF, //цвет фона капчи
				'testLimit'=>1, //сколько раз капча не меняется
				'maxLength'=> 4,
				'minLength'=> 1,
				'transparent'=>false,
				'foreColor'=>0x000000, //цвет символов				
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
  
		if(!Yii::app()->request->isAjaxRequest)
		{
			if((isset($_GET['page']) && $_GET['page'] > 1) )
		  	{
		  		throw new CHttpException(404,'Такая страница не найдена.');
		  	}
		}
		$criteria = new CDbCriteria;
		$criteria->compare('type','page');
		$criteria->compare('status',1);
		$criteria->order= "id DESC";
		$criteria->limit = 20;
		
        $total = Pages::model()->count();
 
        $page = new CPagination($total);
        $page->pageSize = 20;        
        $page->applyLimit($criteria);
		//$pages = Pages::model()->findAll($criteria);
		$pages = Pages::model()->listpage();
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index', array('pages'=>$pages, 'pager'=>$page));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
        $this->layout = 'contact';
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$model->SendMail($this->getOptions('admin_email'));
				$model->SendMail($model->email);
				Yii::app()->user->setFlash('contact','Спасибо! Ваше сообщение отправлено.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	
	public function actionSitemap()
	{
		$cats = Category::model()->AllCategoryArray(true);
 		//$list_cats = Category::model()->ArrayCategory($cats, 0, true); 	
 		
 		$pages = Pages::model()->AllPages();
 		
 		$this->render('sitemap', array('list_cats'=>$cats, 'pages'=>$pages));
	}
	
	public function actionSiteMapXml()
	{
		$pages = Pages::model()->AllPages();
		$cats = Category::model()->AllCategoryArray(true);
		$this->renderPartial('sitemapXml', array('cats'=>$cats, 'pages'=>$pages));
	}
	
	
	public function actionStarRatingAjax() {
		if(Yii::app()->request->isAjaxRequest)
		{	
		$ratingAjax=isset($_POST['rate']) ? $_POST['rate'] : 0;

		$n = Rating::model()->newRating(CHttpRequest::getUserHostAddress(),$_POST['id_p']);
		if($n == true){
			$current_timestamp = time();
			$seconds_to_add = strtotime('tomorrow', $current_timestamp) - $current_timestamp;
		
			$t = $current_timestamp + $seconds_to_add;
		
			$r = new Rating();
			$r->page_id = $_POST['id_p'];
			$r->ip = CHttpRequest::getUserHostAddress();
			$r->value = $ratingAjax; 
			$r->time = $t;
			if($r->save()) {
				$rat = Rating::model()->ratingSum($_POST['id_p']);
				Pages::model()->updateByPk($_POST['id_p'], array('rating'=>$rat));
				echo "<span style='color:green'>Ваша оценка: ".$ratingAjax. " из 5</span>";
			}
			else echo CHtml::errorSummary($r);
		   	Yii::app()->end();
       	}
       	else echo "<span style='color:red'>Вы голосовали</span>";
       	}
       	else
			throw new CHttpException(400,'Ошибочный запрос.');
	}
	
	public function actionGame()
	{
		Yii::app()->getClientScript()->registerScriptFile('/resources/js/game/jquery-ui-1.8.9.custom.min.js');
		Yii::app()->getClientScript()->registerScriptFile('/resources/js/game/game.js');
		Yii::app()->getClientScript()->registerCssFile('/resources/js/game/game_style.css');		
		$this->render('game');
	}
	
	/*public function actionRss()
	{
		/*$this->layout = "rss";
		$page = '';
		$this->render('rss', array('pages'=>$pages));*/
	/*	Yii::import('ext.feed.*');

        $feed = new EFeed();
        $feed->title = 'Красота и мода';
        $feed->description = 'Наш портал о женщинах и для женщин. Здесь есть обзор последних коллекций и модных трендов, элегантные украшения и стильные аксессуары. Ты узнаешь о том, как быть по-настоящему особенной и неповторимой, посетив раздел "Бижутерия своими руками" с фотографиями и пошаговым руководством. Хочешь знать, как стать красивой? Наши эффективные и действенные советы помогут тебе всегда быть в центре внимания. Безупречный стиль, правильный макияж, здоровье, красота, сексуальность и уверенность в себе - все это есть на страницах нашего портал';
        $feed->addChannelTag('language', 'ru-ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));

        $posts = Pages::model()->AllPages();
        foreach($posts as $post) {
            $item = $feed->createNewItem();
            $item->title = $post->title;
            $item->link = Yii::app()->createAbsoluteUrl('/category/view', array('id'=>$post->id, 'tl'=>Controller::translit($post->title)));
            $item->date = $post->date_add;
            $item->description = $post->small_desc;            
            $feed->addItem($item);
        }
        $feed->generateFeed();
	}*/
}
