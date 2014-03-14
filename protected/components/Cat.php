<?php
class Cat extends CWidget {
	public $pc;
    public function run() { 		
    	$criteria=new CDbCriteria;
		$criteria->compare('parent_id',$this->pc);
		$criteria->compare('active',1);
		$criteria->order = 'ord DESC';
		
 		$list_cats = Category::model()->findAll($criteria);
 		$this->render('cat', array('data'=>$list_cats));
    }
}
