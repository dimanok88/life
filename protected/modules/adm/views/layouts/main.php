<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<script src="/resources/js/knockout-3.0.0.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div>
		<?php $this->widget('application.extensions.mbmenu.MbMenu',array(
			'items'=>array(
				array('label'=>'На сайт', 'url'=>'/', 'linkOptions'=>array('target'=>'_blank')),
				array('label'=>'Контент', 'url'=>array('category/'),
                    'items'=>array(
                    	 array('label'=>'Комментарии', 'url'=>array('comments/index')),
                         array('label'=>'Страницы', 'url'=>array('pages/index', 'type'=>'page')),                         
                         //array('label'=>'Новости', 'url'=>array('pages/index', 'type'=>'news')),
                     ),
                ),
                array('label'=>'Настройки', 'url'=>array('options/'), 
                	'items'=>array(
                    	 array('label'=>'Запросы поиска на сайте', 'url'=>array('search/index')),
                    	 array('label'=>'Access', 'url'=>array('search/acc')),
                    	 array('label'=>'Предложения', 'url'=>array('suggestions/index')),
                     ),
                ),
                array('label'=>'Перелинковка', 'url'=>array('link/index')),
                array('label'=>'Тесты', 'url'=>array('test/index')),
                array('label'=>'Удалить КЭШ', 'url'=>array('options/clearCache')),
				//array('label'=>'Login', 'url'=>array('item/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
