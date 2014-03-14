<?php
class Page extends CWidget {
	public $id_cat ='';
	public $id_page = '';

    public function run() {
 		$nextPage = Pages::model()->NextPage($this->id_cat, $this->id_page);	
 		$prevPage = Pages::model()->PrevPage($this->id_cat, $this->id_page);	
 		     
    	$this->render('page', array('prev'=>$prevPage, 'next'=>$nextPage, 'cat'=>$this->id_cat));
    }
}
