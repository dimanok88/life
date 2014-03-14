<h1>Комментарии</h1>

<?php

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(	
		'link'=>array(
        	'name'=>'link',
        	'type'=>'raw',
        	'value'=>'(!empty($data->link)) ? CHtml::link("Ссылка", "$data->link", array("target"=>"_blank")) : "" '
        ),
		'date_add',
		'name_user',
		'text:html',
		'answer:html',
                array(
                    'class'=>'JToggleColumn',
                    'name'=>'active', // boolean model attribute (tinyint(1) with values 0 or 1)
                    'filter' => array('0' => 'Нет', '1' => 'Да'), // filter
                    'htmlOptions'=>array('style'=>'text-align:center;min-width:60px;')
                ),
/*                array(
                    'class'=>'JToggleColumn',
                    'name'=>'is_default', // boolean model attribute (tinyint(1) with values 0 or 1)
                    'filter' => array('0' => 'No', '1' => 'Yes'), // filter
                    'action'=>'switch', // other action, default is 'toggle' action
                    'checkedButtonImageUrl'=>'/images/toggle/yes.png', // checked image
                    'uncheckedButtonImageUrl'=>'/images/toggle/no.png', // unchecked image
                    'checkedButtonLabel'=>'No', // tooltip
                    'uncheckedButtonLabel'=>'Yes', // tooltip
                    'htmlOptions'=>array('style'=>'text-align:center;min-width:60px;')
                ),		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {view} {delete}',
            'buttons'=>array(                
                'view'=>array(
                    'lable'=>'Ответить',
                    'url'=> 'Yii::app()->createUrl("adm/comments/answer", array("id"=>$data->id))'
                ),
            ),
		),
	),
));
?>

