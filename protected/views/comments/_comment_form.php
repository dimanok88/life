<!-- Respond -->
<div class="respond">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'commentform',
        //'enableAjaxValidation'=>false,
    )); ?>
    <?php echo $form->textField($comment, 'name_user'); ?>
    <?php echo $form->labelEx($comment, 'name_user'); ?><br/>

    <?php echo $form->textField($comment, 'email'); ?>
    <?php echo $form->labelEx($comment, 'email'); ?><br/>

    <div class="row">
        <div>Для обновления картинки нажмите на нее.</div>
        <?php $this->widget('CCaptcha', array('id' => 'capc', 'clickableImage' => true, 'showRefreshButton' => false,)); ?>
        <br/>
        <?php echo $form->textField($comment, 'verifyCode'); ?>
        <?php echo $form->labelEx($comment, 'verifyCode'); ?>
    </div>

    <?php $this->widget('application.extensions.cleditor.ECLEditor', array(
        'model' => $comment,
        'attribute' => 'text', //Model attribute name. Nome do atributo do modelo.
        'options' => array(
            'width' => '200',
            'height' => 100,
            'useCSS' => true,
            'controls' => 'bold italic underline | removeformat | bullets numbering | cut copy paste',
        ),
    )); ?>

    <?= $form->hiddenField($comment, 'type_item', array('value' => $type)) ?>
    <?= $form->hiddenField($comment, 'id_item', array('value' => $id)) ?>
    <p>
        <?
        echo CHtml::ajaxButton('Отправить', '#',
            array('type' => 'POST', 'success' => 'function(data){$.fn.yiiListView.update("comments-list"); $("#mess").html(data); $("#capc").click(); $("#commentform").get(0).reset()}'),
            array('id' => 'submit', 'placeholder'=>"Добавить комментарий")
        );
        ?>
    </p>


    <?php $this->endWidget(); ?>
</div>
<div class="clear"></div>
<!-- ENDS Respond -->
 
