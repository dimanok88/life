<?php

/**
 * This is the model class for table "suggestions".
 *
 * The followings are the available columns in table 'suggestions':
 * @property string $id
 * @property string $suggestion
 * @property string $votes_up
 * @property string $votes_down
 * @property integer $rating
 * @property string $dt
 */
class Suggestions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Suggestions the static model class
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
		return '{{suggestions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suggestion, dt', 'required'),
			array('rating', 'numerical', 'integerOnly'=>true),
			array('suggestion', 'length', 'max'=>255),
			array('votes_up, votes_down', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, suggestion, votes_up, votes_down, rating, dt', 'safe', 'on'=>'search'),
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
			'suggestion' => 'Текст',
			'votes_up' => 'За',
			'votes_down' => 'Против',
			'rating' => 'Общий рейтинг',
			'dt' => 'Дата',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('suggestion',$this->suggestion,true);
		$criteria->compare('votes_up',$this->votes_up,true);
		$criteria->compare('votes_down',$this->votes_down,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('dt',$this->dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
