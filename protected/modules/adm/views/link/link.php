<div class="form">

<h1>Перелинковка</h1>

<?= CHtml::form(array('link/addLink')); ?>
<div class="row"> 
<?= CHtml::dropDownList('page', '', $pages, array('id'=>'pages', 'empty'=>' - ', 'ajax'=>array(
	'url'=>array('link/showList'),
	'type'=>'GET',
	'update'=>'#list',
))); ?>
</div>
<div id="list">
</div>

<div>
<?= CHtml::submitButton('Сохранить');?>
</div>
<?= CHtml::endForm(); ?>
</div><!-- form -->
