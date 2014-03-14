<?php

/**
 * This is the model class for table "rating".
 *
 * The followings are the available columns in table 'rating':
 * @property integer $id
 * @property integer $article_id
 * @property integer $user_id
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Article $article
 */

class Rating extends CActiveRecord
{
	/**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return Rating the static model class
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
	return '{{rating}}';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
	array('page_id, ip, value, time', 'required'),
	array('page_id, value, time', 'numerical', 'integerOnly'=>true),
	// The following rule is used by search().
	// Please remove those attributes that should not be searched.
	array('id, page_id, ip, value, time', 'safe', 'on'=>'search'),
	);
	}

	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels()
	{
		return array(
		'id' => 'ID',
		'page_id' => 'Страница',
		'ip' => 'IP',
		'value' => 'Значение',
		'time'=>'Время голосования',
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
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('ip',$this->ip);
		$criteria->compare('value',$this->value);
		return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		));
	}
	
	public function newRating($ip,$page_id)
	{
		$ra = $this->findAll('ip=:ip AND page_id=:p_id ORDER BY time DESC', array(':ip'=>$ip, ':p_id'=>$page_id));
		
		if(count($ra) > 0){
			foreach($ra as $r)
			{				
				if(time() >= (int)$r['time'])
					return true;
				else return false;
			}
		
			return false;
		}
		else return true;		
	}
	
	public function ratingSum($page_id)
	{
		$rating = Yii::app()->db->createCommand()
				->select('SUM(value) as sum')
				->from('{{rating}}')			
				->where('page_id=:id', array(':id'=>$page_id))
				->queryRow();
				
		return (!empty($rating['sum'])) ? $rating['sum'] : 0;
	}
}
