<h1>Тесты</h1>
<ol>
<? 
foreach($tests as $t) { ?>
	<?
	$res = Yii::app()->db->createCommand("SELECT COUNT(*) as c FROM {{questions}} WHERE parent_test=".$t['id'])->queryRow();
	$total_answers = $res['c'];
	?>
	<li>
		<?= CHtml::link($t['name'], array('test/start', 'test_id'=>$t['id'], 'ans'=>$total_answers)); ?>
		<strong> Вопросов: <?=$total_answers?> &nbsp; Тест прошло: <?=$t['count']?> чел. &nbsp;</strong>
	</li>
	<?
} ?>
</ol>

<?
if(!Yii::app()->request->isAjaxRequest){
?>

<?}?>
