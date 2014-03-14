<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'options-form',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sys_name'); ?>
		<?php echo $form->textField($model,'sys_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sys_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php 
			$this->widget('ext.ckeditor.CKEditorWidget',array(
  "model"=>$model,                 # Data-Model
  "attribute"=>'value',          # Attribute in the Data-Model
 "defaultValue"=>$model->value,
  # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
  "config" => array(
      "height"=>"400px",
      "width"=>"100%",
      ),
 
  #Optional address settings if you did not copy ckeditor on application root
  "ckEditor"=>Yii::app()->basePath."/../ed/ckeditor/ckeditor.php",
                                  # Path to ckeditor.php
  "ckBasePath"=>Yii::app()->baseUrl."/ed/ckeditor/",
                                  # Realtive Path to the Editor (from Web-Root)
  ) );
		?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
