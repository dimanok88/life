<?php
class Rat extends CWidget {
	public $page_id ='';
	public $id='ratings_page';
	public $show = true;
	public $class= 'cl_r';
	public $no = false;

    public function run() { 		     
    	$r = Rating::model()->ratingSum($this->page_id);
    	$this->render('rating', array('page_id'=>$this->page_id, 'no'=>$this->no, 'r'=>$r, 'id'=>$this->id, 'show'=>$this->show, 'class'=>$this->class));
    }
}
