<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$pages,
	'template'=>'<div id="related">{items}</div>',
	'summaryText'=>"",
	'itemView'=>'_minipage',
    'emptyText'=>'',
    'htmlOptions'=>array(),
    'id'=>'slider'
)); ?>
