<?php

class SearchController extends ContController
{	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Search('filt');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Search']))
			$model->attributes=$_GET['Search'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAcc()
	{
		$file = "../access_log";
		$res = file_get_contents($file);
		$text = explode("\n", $res);
		$i = 0;
		$array_new = array();
		foreach($text as $t)
		{
			if(strpos($t,'HTTP/1.0" 301') == true || empty($t) || strpos($t, '89.18.136.226'))
			{
				unset($text[$i]);
			}
			else{
				$text[$i] = str_replace(array("- - "), "", $text[$i]);
				preg_match_all('!^.*\s+(.*?)\s+\[(.*?)\]\s+\"(.*?)\"\s+\"(.*?)\"$!i', $text[$i], $p);
				unset($p[0]);
				$array_new[]= array('ip'=>$p[1][0],'date'=>$p[2][0],'zap'=>$p[3][0],'who'=>$p[4][0]);
			}
			$i++;
		}
		//print_r($array_new);
		$itemsProvider = new CArrayDataProvider($array_new, array(
		'sort'=>array(
			'attributes'=>array(
			  'ip', 'date', 'zap', 'who',
		  )), 
        'pagination' => array(
                'pageSize'=>100,
        )));
        
        $this->render('acc',array('data'=>$itemsProvider ));
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Search::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}
