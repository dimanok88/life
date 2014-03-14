<!-- comments list -->
<div id="comments-wrap">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'summaryText'=>"",
	'itemView'=>'application.views.comments._view',
    'emptyText'=>'Нет комментариев',
    'htmlOptions'=>array('class'=>'commentlist'),
    'id'=>'comments-list'
)); ?>
</div>
<!-- ENDS comments list -->
