<div id="test">
	<center><h2><?= $tests['name']?></h2></center>
	<p><?=$tests['description']?><p>
	<strong>Вопросов: <?=$ans?> &nbsp; Тест прошло: <?=$tests['count']?> чел.</strong>

	<p align="center">
		<?= CHtml::form(array('test/t'));?>
		<input type="hidden" name="test_id" value="<?=$test_id?>">
		<input type="hidden" name="question" value="1">
		<input type="hidden" name="total" value="0">
		<input type="hidden" name="ans" value="<?=$ans?>">	
		<?
		echo CHtml::ajaxSubmitButton('Начать тестирование', array('test/t'), array(
			    'type' => 'POST',
			    'update' => '#test',
			),
			array(
			   'id' => $ans."-".time(),
			   'name' => 'enter',
			   'style'=>"background: #A4D639; border: none; padding: 10px; color: #000; font-size: 16px; border-radius:5px;",
			)
		);
		?>
		<?= CHtml::endForm();?>
	</p>
</div>
<?
if(!Yii::app()->request->isAjaxRequest){
?>
<p align="center">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5747646096312950";
/* baf_block_post */
google_ad_slot = "4924456466";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5747646096312950";
/* baf_block_post */
google_ad_slot = "4924456466";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</p>
<?}?>
