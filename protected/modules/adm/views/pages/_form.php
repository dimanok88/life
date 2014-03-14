<?php
/* @var $this PagesController */
/* @var $model Pages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pages-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'sys'); ?>
		<?php echo $form->textField($model,'sys',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'sys'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	 <div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'small_desc'); ?>
		<?php 
			$this->widget('ext.ckeditor.CKEditorWidget',array(
  "model"=>$model,                 # Data-Model
  "attribute"=>'small_desc',          # Attribute in the Data-Model
 "defaultValue"=>$model->small_desc,
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
		<?php echo $form->error($model,'small_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_desc'); ?>
		<?php
		$this->widget('ext.ckeditor.CKEditorWidget',array(
		  "model"=>$model,                 # Data-Model
		  "attribute"=>'full_desc',          # Attribute in the Data-Model
		  "defaultValue"=>$model->full_desc,
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
		<?php echo $form->error($model,'full_desc'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'test'); ?>
		<?php echo $form->DropDownList($model,'test', Pages::model()->tests(), array('empty'=>' - ')); ?>
		<?php echo $form->error($model,'test'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>	

	<?if(isset($_GET['type']) && $_GET['type'] == 'page'){ ?>
    <div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->DropDownList($model,'category_id', Category::model()->AllCat($cat, 0)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>
    <? } ?>
    
    <div class="row">
		<?php echo $form->labelEx($model,'meta_title'); ?>
		<?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_desc'); ?>
		<?php echo $form->textField($model,'meta_desc',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_desc'); ?>
	</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
