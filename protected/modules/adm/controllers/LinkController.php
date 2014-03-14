<?php

class LinkController extends ContController
{
	public function actionIndex()
	{
		$allPages = Pages::model()->AllPages();
		$pages = CHtml::listData($allPages, 'id', 'meta_title');
		
		$this->render('link', array('pages'=>$pages));
	}

	public function actionShowList($page)
	{
		$select_pages = Yii::app()->db->createCommand()->select('id_page, id_pages')->from('{{linking}}')->where('id_page='.$page)->queryRow();
		if(!empty($select_pages['id_pages']))
		{
			$p = ' AND id NOT IN('.$select_pages['id_pages'].') ';
			$pn = ' AND id IN('.$select_pages['id_pages'].') ';
		    	$allp = Pages::model()->findAll('status=1 AND type="page" '.$pn.' AND id!='.$page.' ORDER BY date_add DESC');
			$selpages = CHtml::listData($allp, 'id', 'meta_title');		

		}
		else { $p = ''; $pn = ''; $allp = ''; $selpages = array();}
		$pl = explode(',', $select_pages['id_pages']);		
	    	$allPages = Pages::model()->findAll('status=1 AND type="page" '.$p.' AND id!='.$page.' ORDER BY date_add DESC');
		$pages = CHtml::listData($allPages, 'id', 'meta_title');


		$this->renderPartial('list', array('pl'=>$pl, 'pages'=>$pages, 'allp'=>$allp, 'selpages'=>$selpages));
	}

	public function actionAddLink()
	{
		if(isset($_POST))
		{
			$command = Yii::app()->db->createCommand();
			$pages = (!empty($_POST['pages'])) ? implode(',',$_POST['pages']) : '';
			$select_id = Yii::app()->db->createCommand()->select('id_page')->from('{{linking}}')->where('id_page='.$_POST['page'])->queryRow();		
			if(empty($select_id)){
				$command->insert('{{linking}}', array(
					'id_page'=>$_POST['page'],
					'id_pages'=>$pages,
					'date_modify'=>date('Y-m-d H:i:s')
				));
			}
			else{
				$command->update('{{linking}}', array(
					'id_pages'=>$pages,
					'date_modify'=>date('Y-m-d H:i:s')
				), 'id_page=:ip', array(':ip'=>$select_id['id_page']));
			}
			$this->redirect('index');
		}
	}
}
