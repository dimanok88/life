<?php

class TestController extends ContController
{
	public function actionUpdate($id = '')
	{
		$data = '';
		if(!empty($id)) $data = Tests::model()->ListTests($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['s']))
		{
			$tests = json_decode($_POST['s'], true);
			foreach($tests as $t){
				//echo $id;
				if(!empty($id)) $model=$this->loadModel($id);
				else $model = new Tests();

				$model->name = $t['name'];
				$model->description = $t['description'];
				if($model->save())
				{
					$command = Yii::app()->db->createCommand();
					//print_r($t['inter']);
					if(count($t['inter'])> 0){
					foreach($t['inter'] as $inter){						
						if(empty($inter['inter_id'])){
							$command->insert('{{interpretations}}', array(
								'test_id'=>$model->id,
								'min_width'=>$inter['min_width'],
								'max_width'=>$inter['max_width'],
								'interpretation'=>$inter['interpretation'],
							));
							echo "insert";
						}
						else
						{
							$command->update('{{interpretations}}', array(								
								'min_width'=>$inter['min_width'],
								'max_width'=>$inter['max_width'],
								'interpretation'=>$inter['interpretation'],
							), "id=:id", array(':id'=>$inter['inter_id']));
							echo "update";
						}
					}
					echo 'true';
					}
				}
				else echo "false";
				

			}
			/*$model->attributes=$_POST['Options'];
			if($model->save())
				$this->redirect(array('index'));*/
		}
		if(!Yii::app()->request->isAjaxRequest)
		{		
			$this->render('update',array(
				'model'=>$model, 'data'=>$data, 'id' => $id
			));
		}
	}
	public function actionUpdateQ($test = '')
	{
		$data = '';
		if(!empty($test)) $data = Questions::model()->ListQ($test);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['s']))
		{	
			$command = Yii::app()->db->createCommand();
			$questions = json_decode($_POST['s'], true);
		//	print_r($questions); exit;
			foreach($questions as $q){
				$last_id = '';
				if(empty($q['question_id'])){
					$command->insert('{{questions}}', array(
						'parent_test'=>$test,
						'question'=>$q['q'],
						'view'=>1,
					));
					echo "insert-q";
					$last_id = Yii::app()->db->lastInsertID;
				}
				else
				{	
					$command->update('{{questions}}', array(								
						'question'=>$q['q'],
					), "id=:id", array(':id'=>$q['question_id']));
					echo "update-q";
					$last_id=$q['question_id'];
				}
				foreach($q['answers'] as $a){
					       if(empty($a['answer_id'])){
							$command->insert('{{answers}}', array(
								'parent_question'=>$last_id,
								'answer'=>$a['ans'],
								'width'=>$a['point'],
								'scale_id'=>7,
								'view'=>1,
							));
							echo "\ninsert-a\n";
						}
						else
						{
							$command->update('{{answers}}', array(								
								'answer'=>$a['ans'],
								'width'=>$a['point'],
							), "id=:id", array(':id'=>$a['answer_id']));
							echo "update-a";
						}
	
				}

			}
			/*$model->attributes=$_POST['Options'];
			if($model->save())
				$this->redirect(array('index'));*/
		}
		if(!Yii::app()->request->isAjaxRequest)
		{		
			$this->render('updateq',array(
				'data'=>$data, 'id' => $test
			));
		}
	}

	public function actionDelInter()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$command = Yii::app()->db->createCommand();
			$command->delete('{{interpretations}}', 'id=:id', array(':id'=>$_POST['inter'])); 			
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}	

	public function actionDelQuest()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$command = Yii::app()->db->createCommand();
			$command->delete('{{questions}}', 'id=:id', array(':id'=>$_POST['q'])); 
			$command->reset();
			$command->delete('{{answers}}', 'parent_question=:id', array(':id'=>$_POST['q'])); 			
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDelAnswer()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$command = Yii::app()->db->createCommand();
			$command->delete('{{answers}}', 'id=:id', array(':id'=>$_POST['a'])); 			
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
			$command = Yii::app()->db->createCommand();
			$command->delete('{{interpretations}}', 'test_id=:id', array(':id'=>$id)); 
			$command->reset();
			Yii::app()->db->createCommand('DELETE {{questions}}, {{answers}} FROM {{questions}}, {{answers}} WHERE {{questions}}.parent_test='.$id.' AND {{answers}}.parent_question={{questions}}.id')->execute(); 

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Tests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tests']))
			$model->attributes=$_GET['Tests'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->actionIndex();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tests::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='options-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
