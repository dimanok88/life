<?php

class Search_in extends CWidget 
{
	public function run()
	{
    	$form = new SearchForm();
    	$this->render('search_in', array('form'=>$form));
  	}
}
