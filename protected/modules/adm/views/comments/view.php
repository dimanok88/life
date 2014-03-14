<h1>Оставить ответ</h1>
<div id="mes"></div>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'horizontalForm',
'type'=>'horizontal',
)); ?>
	<?
	    $this->widget('bootstrap.widgets.TbBox', array(
			'title' => 'Комментарий',
			'headerIcon' => 'icon-user',
			'content' => $comment->text // $this->renderPartial('_view')
			));
	?>
	Ответ: <br/>
		
	<?php $this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
                "model"=>$comment,                # Data-Model
                "attribute"=>'answer',         # Attribute in the Data-Model
                "height"=>'400px',
                "width"=>'100%',
                "fckeditor"=>Yii::app()->basePath."/fckeditor/fckeditor.php",
                "fckBasePath"=>Yii::app()->baseUrl."/fckeditor/",
                "config" => array("EditorAreaCSS"=>Yii::app()->baseUrl.'/css/index.css',),
            ) ); ?>
            <br/><br/>
	<?
		if(!Yii::app()->request->isAjaxRequest){
            $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Ответить'));
        }
        else {
            echo CHtml::ajaxButton ("Сохранить",
                              '',
                              array('type'=>'POST',
                                    'update'=>'#mes',
                              ),
                              array('id'=>'saves'));
        }
	?>
<?php $this->endWidget(); ?>
