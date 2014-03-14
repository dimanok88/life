<?
$this->title = "Обратная связь";
$this->pageDesc= "Обратная связь поможет вам связаться с администрацией сайта.";
?>
<div align="center" style="margin: 0px 0 0 0;">
    <h1>Форма обратной связи</h1>
</div>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contactForm',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Обязательные поля <span class="required">*</span>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div>		
		<?php echo $form->textField($model,'name', array('class'=>'form-poshytip', 'title'=>'Введите свое полное имя')); ?>
		<?php echo $form->labelEx($model,'name'); ?>
	</div>
	<div>
		<?php echo $form->textField($model,'email', array('class'=>'form-poshytip', 'title'=>'Введите ваш email')); ?>
		<?php echo $form->labelEx($model,'email'); ?>
	</div>
	<div>
		<?php echo $form->textField($model,'subject', array('class'=>'form-poshytip', 'title'=>'Введите тему сообщения')); ?>
		<?php echo $form->labelEx($model,'subject'); ?>		
	</div>
	<div>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>30 , 'class'=>'form-poshytip', 'title'=>'Введите текст сообщения')); ?>
	</div>
	<?php if(CCaptcha::checkRequirements()): ?>
	<div>
		<div>Для обновления картинки нажмите на нее.</div>
		<?php $this->widget('CCaptcha', array('clickableImage'=>true, 'showRefreshButton'=>false,)); ?><br/>
		<?php echo $form->textField($model,'verifyCode', array('class'=>'form-poshytip', 'title'=>'Введите код с картинки')); ?>
		<?php echo $form->labelEx($model,'verifyCode'); ?>		
	</div>	
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', array('id'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
