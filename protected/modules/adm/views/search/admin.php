<h1>Запросы поиска на сайте</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'options-grid',
	'dataProvider'=>$model->filt(),
	'filter'=>$model,
	'columns'=>array(
		'string',
		'ip',
		'date',		
	),
)); ?>
