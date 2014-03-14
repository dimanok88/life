<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'suggestions-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'suggestion'); ?>
		<?php echo $form->textField($model,'suggestion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'suggestion'); ?>
	</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
