<h1>Запросы поиска на сайте</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'options-grid',
	'dataProvider'=>$data,
	'columns'=>array(
		'ip',
		'date',
		'zap',		
		'who'
	),
)); ?>
