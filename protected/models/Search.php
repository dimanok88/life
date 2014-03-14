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

class Search extends CActiveRecord
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
	return '{{search}}';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
		array('string, ip, date', 'required'),
		array('id, string, ip, date', 'safe', 'on'=>'search'),
	);
	}

	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels()
	{
		return array(
		'id' => 'ID',
		'string' => 'Строка',
		'ip' => 'IP',
		'date'=>'Время поиска',
		);
	}

	/**
	* Retrieves a list of models based on the current search/filter conditions.
	* @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	*/
	public function filt()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('string',$this->string, true);
		$criteria->compare('ip',$this->ip);
		$criteria->compare('date',$this->date, true);
		return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		));
	}		
}
