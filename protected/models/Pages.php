<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $title
 * @property string $small_desc
 * @property string $full_desc
 * @property string $date_add
 * @property string $date_modify
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_desc
 * @property string $type
 * @property integer $status
 * @property integer $category_id
 */
class Pages extends CActiveRecord
{
	public $image;
	public $twitt;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pages the static model class
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
		return '{{pages}}';
	}

	public function beforeSave() {
	    if ($this->isNewRecord) {
	        $this->date_add = date('Y-m-d H:i:s');
	    }
	    else $this->date_modify = date('Y-m-d H:i:s');

	    if($this->twitt == true)
	    {
		$url = Yii::app()->createAbsoluteUrl('pages/view', array('sys'=>$this->sys));		
		Controller::postTwitter($this->meta_title, $url);
	    }
	    $this->title = trim($this->title);

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
			array('title, sys, full_desc, small_desc, type', 'required'),
			array('status, category_id, twitt', 'numerical', 'integerOnly'=>true),
			array('title, meta_title, meta_keywords, meta_desc', 'length', 'max'=>255),
			array('type', 'length', 'max'=>10),
			array('sys', 'unique'),
			array('meta_title, meta_keywords, meta_desc, rating, test, date_modify, date_add', 'default'),
			array('image' , 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, sys, small_desc, twitt, image, full_desc, test, rating, date_add, date_modify, meta_title, meta_keywords, meta_desc, type, status, category_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'title' => 'Заголовок',
			'small_desc' => 'Короткое описание',
			'full_desc' => 'Полное описание',
			'date_add' => 'Дата добавления',
			'date_modify' => 'Дата изменения',
			'meta_title' => 'Meta заголовок',
			'meta_keywords' => 'Meta ключевые слова',
			'meta_desc' => 'Meta описание',
			'type' => 'Тип',
			'status' => 'Статус',
			'category_id' => 'Категория',
			'image'=>'Картинка',
			'rating'=>'Рейтинг',
			'sys'=>'Урл',
			'twitt'=>'Твитнуть',
			'test'=>'Тест',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($type)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->order = "id DESC";

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('small_desc',$this->small_desc,true);
		$criteria->compare('full_desc',$this->full_desc,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_modify',$this->date_modify,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_desc',$this->meta_desc,true);
		$criteria->compare('type',$type);
		$criteria->compare('status',$this->status);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
			'defaultOrder' => 'id DESC',
			),
		));
	}
	
	
	public function listpage($id= '', $page='')
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('type','page');
		$criteria->compare('status',1);
		$criteria->order= "id DESC";
		$criteria->limit = 20;
		if(!empty($id)) $criteria->compare('category_id',$id);
		
		if($page == '') {
			$total = Pages::model()->count();
	 
		    $page = new CPagination($total);
		    $page->pageSize = 10;
		    $page->applyLimit($criteria);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>$page
		));
	}
	

	public function Related($words)
	{
		$page_id = $this->find('sys=:s', array(':s'=>$words));
		$select_id = Yii::app()->db->createCommand()->select('*')->from('{{linking}}')->where('id_page='.$page_id->id)->queryRow();
	
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id', explode(',', $select_id['id_pages']));
		$criteria->order = 'date_add DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	

	public function PrevPage($id_cat, $id_page)
    {
    	$pagep = $this->find('category_id=:cat AND id < :p AND status=1', array(':cat'=>$id_cat, ':p'=>$id_page));
        return $pagep;
    }
    
    public function NextPage($id_cat, $id_page)
    {
    	$pagen = $this->find('category_id=:cat AND id > :p AND status=1', array(':cat'=>$id_cat, ':p'=>$id_page));                
        return $pagen;
    }
    
    public function AllPages()
    {
    	$pages = $this->findAll('type="page" ORDER BY date_add DESC');
    	return $pages;
    }
    
    public function NamePage($id)
    {
    	$page = $this->findByPk($id);
    	return $page['title'];
    }
    public function Tests()
    {
	$test = array();
	$tests = Yii::app()->db->createCommand()->select("*")->from('{{tests}}')->queryAll();
	foreach($tests as $t)
	{
		$test[$t['id']] = $t['name'];
	}
	return $test;
    }
}
