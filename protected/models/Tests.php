<?php

/**
 * This is the model class for table "{{tests}}".
 *
 * The followings are the available columns in table '{{tests}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $date
 * @property integer $count
 * @property integer $view
 */
class Tests extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tests}}';
	}

	public function beforeSave() {
	    if ($this->isNewRecord) {
	        $this->date = date('Y-m-d H:i:s');
		$this->view = 1;
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
			array('name, description', 'required'),
			array('count, view', 'numerical', 'integerOnly'=>true),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, date, count, view', 'safe', 'on'=>'search'),
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
			'name' => 'Название',
			'description' => 'Описание',
			'date' => 'Дата',
			'count' => 'Количество',
			'view' => 'Статус',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('view',$this->view);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function ListTests($id)
	{
		$arr = array();
		$test = $this->findByPk($id);
		$inter = Yii::app()->db->createCommand()->select('*')->from('{{interpretations}}')->where('test_id='.$id)->queryAll();
		$arr[0] = array('name'=>$test->name, 'description'=>$test->description);
		$in = array();
		foreach($inter as $i)
		{
			$in['inter'][] = array('inter_id'=>$i['id'],
						'min_width'=>$i['min_width'],
						'max_width'=>$i['max_width'],
						'interpretation'=>$i['interpretation'],
					);
		}
		$all = array_merge($arr[0], $in);	
		return json_encode($all);
	}
}
