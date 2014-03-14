<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $title;
	public $pageKey;

    	public $pageDesc;
	
	//транслит русского текста на английский использую для транслитерации ссылок
	public function translit($str)
	{
	        $tr = array(
        	        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
        	        "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
        	        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        	        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        	        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
        	        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        	        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        	        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        	        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        	        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        	        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        	        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        	        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
        	        " "=> "_", "."=> "", "/"=> "_"
        	);
        	return strtr($str,$tr);
    	} 
    
    //выводим список комментариев по типу
    public function commentsList($id_item, $type)
    {
        $criteria=new CDbCriteria;

		$criteria->compare('id_item',$id_item);
		$criteria->compare('type_item',$type);
		$criteria->compare('active', 1);
		$criteria->order = "date_add DESC";

        $dataProvider=new CActiveDataProvider('Comments', array(
			'criteria'=>$criteria, 

		));
		return $this->renderPartial('application.views.comments._comments',array(
			'dataProvider'=>$dataProvider,			
		), false,false);
    }
    
    
    public function item($id_item, $type)
    {
		if($type=='cat')
		{
			return Category::model()->getNameCat($id_item);
		}
		else
		{
			return Pages::model()->NamePage($id_item);
		}
    }
    
    //вывод значения найтройки по ег осистемному имени.
    public function getOptions($name)
	{
		$options = Options::model()->find('sys_name=:name', array(':name'=>$name));
		return $options['value'];
	}
	
	//обрезаем текст на количество символов
	public function cutString($string, $maxlen) {
        $len = (mb_strlen($string, 'utf-8') > $maxlen)
            ? mb_strripos(mb_substr($string, 0, $maxlen, 'utf-8'), ' ')
            : $maxlen
        ;
        $cutStr = mb_substr(strip_tags($string), 0, $len, 'utf-8');
        return (mb_strlen($string, 'utf-8') > $maxlen)
            ? $cutStr . '...'
            : $cutStr
        ;
    }
    
    //есть ли ссылка в  тексте или нет. если есть то возврашщаем тру иначе фелс
    public function link($text)
    {
    	$url = $text;
		if (preg_match('!.*(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?!ium', $url)) {
			return true;
		}		
		else {
			return false;
		}
    }

	public function postTwitter($text, $url){
		Yii::import('application.components.*');
		require_once 'TwitterOAuth.php';

		$text = $text." ".$url;

		$CONSUMER_KEY = "haZQehKzuDZvZ3cXwaw0g";
		$CONSUMER_SECRET = "mbKOLD7KbwTkJiyAbHQ4o0UhbzTWVOxKkAkS3Swa8I";
		$OAUTH_TOKEN = "1088424775-bGcnwPgLmAyVO3fhvh54Ymsq2FQamsWdgNroPaR";
		$OAUTH_SECRET = "oqRCYFA6EK0xbhXUUsT5BwtX01It34tK3UgO0U3ZNzI";

		$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $OAUTH_TOKEN, $OAUTH_SECRET);
		$content = $connection->get('account/verify_credentials');
		$connection->post('statuses/update', array('status' =>$text));
	}

}
