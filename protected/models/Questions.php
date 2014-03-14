<?php

/**
 * This is the model class for table "{{questions}}".
 *
 * The followings are the available columns in table '{{questions}}':
 * @property integer $id
 * @property integer $parent_test
 * @property string $question
 * @property integer $view
 */
class Questions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{questions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question', 'required'),
			array('parent_test, view', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_test, question, view', 'safe', 'on'=>'search'),
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
			'parent_test' => 'Parent Test',
			'question' => 'Вопрос',
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
		$criteria->compare('parent_test',$this->parent_test);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('view',$this->view);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Questions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function ListQ($id)
	{
		$quest = Yii::app()->db->createCommand()->select('*')->from('{{questions}}')->where('parent_test='.$id)->queryAll();
		$q = array();
		foreach($quest as $qu)
		{
			$answers = Yii::app()->db->createCommand()->select('*')->from('{{answers}}')->where('parent_question='.$qu['id'])->queryAll();
			$ans = array();
			foreach($answers as $a){
				$ans[] = array('q_id'=>$qu['id'],'answer_id'=>$a['id'], 'ans'=>$a['answer'], 'point'=>$a['width']);
			}
			$q[] = array('question_id'=>$qu['id'],
						'q'=>$qu['question'],
						'answers'=>$ans
					);			
		}
		$all = $q;	
		return json_encode($all);
	}

}
