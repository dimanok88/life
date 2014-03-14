<?
$this->title = "Карта сайта";
$this->pageDesc= "Карта сайта, краткий обзор всех страниц сайта.";
?>
<h1>Карта сайта</h1>

<h4>Разделы</h4>
<?
$i = 0;
$class= array('purple','violet','pink', "orange","yellow","lime","green","bondi","aqua","blue","navy",);
?>
<div align="center">
<ul class="colors">
<? foreach($list_cats as $cat):?>
	<li class='<?= $class[$i]; ?>' ><?= CHtml::link($cat['title'], array('category/view', 'id'=>$cat['id'], 'tl'=>$this->translit($cat['title'])));?></li>
<? $i++; endforeach;?>
</ul>
</div>
<?
/*$this->widget('CTreeView', array('data' => $list_cats, 'animated'=>"fast",'collapsed'=>true,'htmlOptions' => array('class' => 'treeview-gray list-2')));*/
?>

<? if(count($pages) > 0):?>
<h4>Страницы</h4>
<ul class="list-3">
	<? foreach($pages as $page): ?>
		<li>
		<?= CHtml::link($page['title'], array('pages/view', 'sys'=>$page['sys']))?>
		<div>
			<?= $page['small_desc']; ?>
		</div>
		</li>
	<? endforeach; ?>
</ul>
<? endif;?>

