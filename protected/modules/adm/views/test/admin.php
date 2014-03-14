<?php

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('update')),
);
?>

<h1>Тесты</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'options-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name'=>array(
			'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::link("$data->name",array("test/updateQ", "test"=>$data->id))',
		),
		'description',
		array(
            'header'=>'Действия',
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
		),
	),
)); ?>
