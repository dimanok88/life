<ul id="categories">
	<li><?= CHtml::link('Главная', '/');?></li>
<? foreach($data as $cat):?>
	<li><?= CHtml::link($cat['title'], array('category/view', 'id'=>$cat['id'], 'tl'=>Controller::translit($cat['title'])));?></li>
<? endforeach;?>							
</ul>