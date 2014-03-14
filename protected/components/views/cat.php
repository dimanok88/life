<?if(count($data)>0):?>
<ul class="cat-list">
<? foreach($data as $cat):?>
	<li><?= CHtml::link($cat['title'], array('category/view', 'id'=>$cat['id'], 'tl'=>Controller::translit($cat['title'])));?></li>
<? endforeach;?>							
</ul>
<?else:?>
<br/>
<? endif;?>

