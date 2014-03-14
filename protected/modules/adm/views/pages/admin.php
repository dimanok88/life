<?php
$page = array();
$visible = false;
$title = 'Новости';
$type = $_GET['type'];
if(isset($_GET['type']) && $_GET['type'] == 'page')
{
    $page = array('label'=>'Категории', 'url'=>array('category/'));
    $title = 'Страницы';
    $visible = true;
}
$this->menu=array(
	    array('label'=>'Добавить', 'url'=>array('update', 'type'=>$type)),
        $page
    );

?>

<h1><?= $title?></h1>

<p>
Вы можете использовать следующие операторы для поиска (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>)
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pages-grid',
	'dataProvider'=>$model->search($type),
	'filter'=>$model,
	'columns'=>array(
		'rating',
		'title',
		'date_add',
		'date_modify',
		//'small_desc:html',		
        'meta_title',
        'category_id'=>array('name'=>'category_id',
                          'filter'=>Category::model()->AllCat($cat, 0, '-'),
                          'value'=>'Category::model()->getNameCat($data->category_id)',
                          'visible'=>$visible),
		array(
                    'class'=>'JToggleColumn',
                    'name'=>'status', // boolean model attribute (tinyint(1) with values 0 or 1)
                    'filter' => array('0' => 'Нет', '1' => 'Да'), // filter
                    'htmlOptions'=>array('style'=>'text-align:center;min-width:60px;')
                ),
        
		array(
            'header'=>'Действия',
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons'=>array
             (
                'delete' => array
                (
                    'label'=>'Удалить',
                    'url'=>'Yii::app()->createUrl("adm/pages/delete", array("id"=>$data->id))',
                ),
                'update'=>array(
                   'label'=>'Редактировать',
                   'url'=>'Yii::app()->createUrl("adm/pages/update", array("id"=>$data->id,"type"=>"'.$type.'"))',
                ),                               
            ),
		),
	),
)); ?>


<?
Yii::app()->clientScript->registerScript('succ', "
jQuery('#pages-grid a.succ').live('click',function() {
	//if(!confirm('Вы уверены, что хотите отменить бронирование?')) return false;
	var th=this;
	var afterDelete=function(){};
	$.fn.yiiGridView.update('pages-grid', {
		type:'POST',
		data: '".Yii::app()->request->csrfTokenName."=".Yii::app()->request->getCsrfToken()."',
		url:$(this).attr('href'),
		success:function(data) {
			$.fn.yiiGridView.update('pages-grid');
			afterDelete(th,true,data);
		},
		error:function(XHR) {
			return afterDelete(th,false,XHR);
		}
	});
	return false;
});");
?>
