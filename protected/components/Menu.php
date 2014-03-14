<?php
class Menu extends CWidget {
    public function run() { 		
 		$list_cats = Category::model()->findAll('parent_id=0 AND active=1 ORDER BY ord ASC'); 		
 		     
    	$this->render('menu', array('data'=>$list_cats));
    }
}
