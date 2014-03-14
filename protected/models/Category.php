<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $desc
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_desc
 * @property string $date_modify
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return '{{category}}';
	}

    public function beforeSave() {
	    $this->date_modify = date('Y-m-d H:i:s');
	    $this->title = trim($this->title);
	    if(empty($this->parent_id)) $this->parent_id = 0;

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
			array('title, date_modify', 'required'),
			array('parent_id, active, ord', 'numerical', 'integerOnly'=>true),
			array('title, meta_title, meta_keywords, meta_desc', 'length', 'max'=>255),
			array('desc', 'default'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, title, ord, desc, meta_title, meta_keywords, meta_desc, date_modify', 'safe', 'on'=>'search'),
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
			'parent_id' => 'Родительская категория',
			'title' => 'Заголовок',
			'desc' => 'Текст',
			'meta_title' => 'Meta заголовок',
			'meta_keywords' => 'Meta ключевые слова',
			'meta_desc' => 'Meta описание',
			'active' => 'Вкл.',
			'date_modify' => 'Дата изменения',	
			'ord'=>'Порядок',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_desc',$this->meta_desc,true);
		$criteria->compare('date_modify',$this->date_modify,true);
		$criteria->compare('ord',$this->ord);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,			
		));
	}
	
	public function AllCategoryArray($xml = false, $id = '')
	{
		if(!empty($id)) $ids = ' AND id!='.$id;
		else $ids="";
		$rs = Yii::app()->db->createCommand()
                ->select('id, parent_id, title, date_modify')
                ->from('{{category}}')->order('ord ASC')->where('active=1'.$ids)
                ->queryAll();
        
        if($xml == true) return $rs;
        
		$rs2=array();
		foreach ($rs as $row)
		{
			$rs2[$row['parent_id']][]=$row;
		}
		
		return $rs2;
	}
	
	public function ArrayCategory(&$rs,$parent, $ex = false)
	{	
			$out=array();
			if (!isset($rs[$parent]))
			{
				return $out;
			}
			$i = 0;
			foreach ($rs[$parent] as $row)
			{
				$out[$i]['text']=CHtml::link($row['title'], array('category/view', 'id'=>$row['id'], 'tl'=>Controller::translit($row['title'])));
				$out[$i]['expanded'] = $ex;
				$chidls=$this->ArrayCategory($rs,$row['id']);
				if ($chidls) 
				{
					$out[$i]['children'] = $chidls;
					$out[$i]['expanded'] = $ex;
				}
				$i++;
			}
			return $out;				
	}
	
	
	public function AllCats($tree, $parent_id=0, $tab = '', $tmp_tab = '')
	{	
			$output = array();
                foreach ($tree as $row) {
                        if ($row['parent_id'] == $parent_id) {
                                array_push($output, array(
                                        'id' => $row['id'],
                                        //'parent_id' => $row['parent_id'],
                                        'title' => $tmp_tab.$row['title'],
                                ));
                                foreach($this->AllCats($tree, $row['id'], $tab, $tmp_tab.$tab) as $subtree) {
                                        array_push($output, array(
                                                'id' => $subtree['id'],
                                                //'parent_id' => $subtree['parent_id'],
                                                'title' => $subtree['title'],
                                        ));
                                }
                        }
                }
                return $output;
	}
	
	public function AllCat($rs,$parent)
	{
		$cats = $this->AllCats($rs, 0, '-');		
		return CHtml::listData($cats, 'id', 'title');
	}

    public function getNameCat($id)
    {
        $cat = $this->findByPk($id);

        return $cat['title'];
    }    
    
    public function Prev($id_cat)
    {
    	$pagep = $this->findAll('id < :p AND active=1', array( ':p'=>$id_cat));
        return $pagep[count($pagep)-1];
    }
    
    public function Next($id_cat)
    {
    	$pagen = $this->findAll('id > :p AND active=1', array( ':p'=>$id_cat));                
        return array_shift($pagen);
    }
	
}
