<?php

class DefaultController extends ContController
{
	public function actionIndex()
	{
		$this->redirect(array('category/'));
	}

	public function actionPerevod()
	{
		if(isset($_POST['links']))
		{
			$posts = $_POST['links'];
			$links = explode("\n", $posts);
			print_r($links);
			foreach($links as $l){
					$link = 'http://api2.allwomenstalk.com/posts/'.trim($l);
					$link_res = file_get_contents($link);
					$res = json_decode($link_res, true);

					$title = $res['post_title'];
					$text = implode("\n\r", $res['post_content']);
					
					$main = $title."\n\r".$text;
					file_put_contents('./perevod/'.$title.".txt", $main);
			}
			//http://love.allwomenstalk.com/understandable-worries-that-can-ruin-relationships/
			//http://api2.allwomenstalk.com/posts/love/understandable-worries-that-can-ruin-relationships?callback=jQuery183039426449896328986_1385638958107&page=0&format=jsonp&_=1385638958245
		}
		$this->render('perevod');
	}
}
