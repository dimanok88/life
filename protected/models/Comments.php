<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property integer $id_item
 * @property integer $date_add
 * @property integer $id_user
 * @property string $text
 */
class Comments extends CActiveRecord
{
	public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comments}}';
	}

    public function beforeSave() {
	    if ($this->isNewRecord) {
            $this->date_add = new CDbExpression('NOW()');  
            $this->link = $_SERVER['HTTP_REFERER'];      
	        $this->sendMail($this->id_item, $this->name_user, $this->text);
	    }

	    return parent::beforeSave();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_item, date_add, name_user, text, type_item', 'required'),
			array('id_item, active', 'numerical', 'integerOnly'=>true),
			array('verifyCode', 'captcha', 'allowEmpty'=>!Yii::app()->user->isGuest),
			array('date_add, answer, email, link', 'default'),
			array('email', 'email'),
			array('text, name_user','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_item, date_add, name_user, email, link, text, answer', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Номер',
			'id_item' => 'Контент',
			'date_add' => 'Добавлен',
			'name_user' => 'Имя',
            		'active'=>'Вкл.',
            		'type_item'=>'Тип контента',
			'text' => 'Текст',
			'answer' => 'Ответ',
			'email' => 'Email',
			'active' => 'Вкл.',
			'verifyCode'=>'Код',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_item',$this->id_item);
		$criteria->compare('active',$this->active);
		$criteria->compare('date_add',$this->date_add);
		$criteria->compare('name_user',$this->name_user, true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('email',$this->email,true);
		
		$sort = new CSort();
		// имя $_GET параметра для сортировки,
		// по умолчанию ModelName_sort
		$sort->sortVar = 'sort';
		// сортировка по умолчанию 
		$sort->defaultOrder = 'date_add DESC';
		// включает поддержку мультисортировки, 
		// т.е. можно отсортировать сразу и по названию и по цене
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array(
				'pageSize'=>50,
			),
		));
	}
	
	public function SendMail($id_item, $name, $text)
    {        
    	$email = Yii::app()->email;      	
    	$link = $_SERVER['HTTP_REFERER'];
        $email->from = Controller::getOptions('admin_email');
        $email->language = "ru";
        $email->cc = 'dimanok88@mail.ru';
        //$email->contentType = 'windows-1251';
        $email->to = Controller::getOptions('admin_email');        
        $email->subject = 'Новый комментарий';
        $email->view = 'comments';
        $email->viewVars = array('name'=>$name, 'text'=>$text, 'id_item'=>$id_item, 'link'=>$link);
        $email->send();
    }
    
    public function SendAnswer($mail, $text, $link)
    {        
    	$email = Yii::app()->email;      	
        $email->from = Yii::app()->param->mainLink;
        $email->language = "ru";
        $email->cc = 'dimanok88@mail.ru';
        //$email->contentType = 'windows-1251';
        $email->to = $mail;        
        $email->subject = 'Ответ на комментарий с сайта '.Yii::app()->param->mainLink;
        $email->view = 'answer';
        $email->viewVars = array('text'=>$text, 'link'=>$link);
        $email->send();
    }
    
    public function countComm($post)
    {
    	$count = $this->count('active=1 AND id_item=:it', array(':it'=>$post));
    	
    	return $count;
    }
}
