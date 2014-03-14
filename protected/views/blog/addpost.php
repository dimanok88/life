<?php
/* @var $this BlogController */
/* @var $model Blog */
/* @var $form CActiveForm */
?>

<h1>Напишите свою Историю</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blog-addpost-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->textField($model,'name', array('class'=>'styler', 'placeholder'=>$model->getAttributeLabel('name'))); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<br/>

	<div class="row">	
		<?php echo $form->textField($model,'email', array('class'=>'styler', 'placeholder'=>$model->getAttributeLabel('email'))); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<br/>

	<div class="row">	
		<?php echo $form->textField($model,'title', array('class'=>'styler', 'placeholder'=>$model->getAttributeLabel('title'))); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<br/>

	<div class="row">
		<?php echo $form->textArea($model,'desc', array('class'=>'styler', 'placeholder'=>$model->getAttributeLabel('desc'))); ?>
		<?php echo $form->error($model,'desc'); ?>
	</div>
	<br/>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', array('class'=>"styler")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->