<? if(empty($search->string)){ ?>
Слишком короткий запрос. 
<? }else{ ?>
<?php if(!empty($search->string)): ?>
<div align="center" style="margin: 100px 0 0 0;"><h1>Поиск по : <i><?php echo CHtml::encode($search->string); ?></i></h1></div>
<?php endif; ?>

<?php if(count($materials)>0): ?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$materials,
	'summaryText'=>"",
	'ajaxUpdate'=>true,
	'itemView'=>'application.views.site._vp',
     'template'=>'<div id="posts" class="box-hold">{items}</div>',
    'emptyText'=>'',
    'pager'=>array(
		'class'=>'CLinkPager',
		'header'=>'',
		'firstPageLabel'=>'&lt;&lt;',
		'prevPageLabel'=>'&lt;',
		'nextPageLabel'=>'&gt;',	
		'lastPageLabel'=>'&gt;&gt;',
		'lastPageCssClass'=>'last-page',
		'firstPageCssClass'=>'first-page',
		'htmlOptions'=>array('class'=>'pager'),
	),
)); ?>
<?php endif; }?>
