<h1>Предложения по улучшению сайта</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'suggestions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'suggestion',
		'votes_up',
		'votes_down',
		'rating',
		'dt',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}'
		),
	),
)); ?>
