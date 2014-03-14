<?php
class Related extends CWidget {
	public $t = '';
    public function run() {
 	$pages = Pages::model()->Related($this->t);
    	$this->render('related', array('pages'=>$pages));
    }
}
