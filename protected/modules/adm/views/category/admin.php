<?php
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('update')),
);

?>

<h1>Контент</h1>

<p>
Вы можете использовать следующие операторы для поиска (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>)
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUrl' => $this->createUrl('index'),
	'columns'=>array(
		array(
			'name'=>'ord',
			'header'=>'Порядрк',
			'headerHtmlOptions' => array('style' => 'width:50px'),
			'class'=>'bootstrap.widgets.TbJEditableColumn',
			'jEditableOptions' => array(
				'type' => 'text',
				// very important to get the attribute to update on the server!
				'submitdata' => array('attribute'=>'ord', Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
				'cssclass' => 'form',
				'width' => '80px'
			)
		),
		'title',
		'date_modify',
		'parent_id'=>array('name'=>'parent_id',
                          'filter'=>Category::model()->AllCat($cat, 0),
                          'value'=>'Category::model()->getNameCat($data->parent_id)'
                          ),
		
		array(
			'name'=>'meta_title',			
			'class'=>'bootstrap.widgets.TbJEditableColumn',
			'jEditableOptions' => array(
				'type' => 'text',
				// very important to get the attribute to update on the server!
				'submitdata' => array('attribute'=>'meta_title', Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
				'cssclass' => 'form',
			)
		),
			
		array(
                    'class'=>'JToggleColumn',
                    'name'=>'active', // boolean model attribute (tinyint(1) with values 0 or 1)
                    'filter' => array('0' => 'Нет', '1' => 'Да'), // filter
                    'htmlOptions'=>array('style'=>'text-align:center;min-width:60px;')
                ),
		array(
            'header'=>'Действия',
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
            
		),		
	),
)); ?>
