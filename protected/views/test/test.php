<div id="test">
<? if ($_POST['ans'] < $_POST['question']) {
	$res = Yii::app()->db->createCommand("UPDATE {{tests}} SET count=count+1 WHERE id=".$_POST['test_id'])->execute();?>

	<h1 align="center">Результат теста</h1>
	<p>
	<div>Вы набрали  <?= $_POST['total']?> баллов.</div>
	<? $int = Yii::app()->db->createCommand("SELECT interpretation FROM {{interpretations}} WHERE test_id=".$_POST['test_id']." AND 
	min_width<=".$_POST['total']." AND max_width>=".$_POST['total'])->queryRow(); ?>
	<?=$int['interpretation']?>
	<div class="mini-post related-post clearfix">
	<h2>Возможно вам будет интересна следующая статья</h2>
		<?=	CHtml::link(
				CHtml::image('/resources/upload/'.$data['id'].'_page.jpg', $data['title'], array('style'=>'height:60px; float:left; margin: 0 20px 0 0px;')),
				array('pages/view', 'sys'=>$data['sys']));
		?>
		<?= CHtml::link($data['title'], array('pages/view', 'sys'=>$data['sys']), array('class'=>'entry-link')); ?>
		<div><?= Controller::cutString($data['small_desc'], 100); ?></div>	
	</div>
	<div align="center"><?= CHtml::link('Список тестов', array('test/index'))?></div>
	<p>

<!-- Иначе -->
<? } else { ?>

<!-- Выводим очередной вопрос -->
	<? $start = $_POST['question']-1; 
	$questions = Yii::app()->db->createCommand("SELECT id, question FROM {{questions}} WHERE parent_test=".$_POST['test_id']."
	ORDER BY id LIMIT ".$start.",1 ")->queryRow();
	?>
	<h3 align="center">Вопрос №<?= $_POST['question']?>, осталось <?=$_POST['ans']-$_POST['question']?></h3>
	<p class="text_test"><?=$questions['question']?></p>

	<!-- Формируем ответы -->
	<?
	$qit = Yii::app()->db->createCommand("SELECT id, answer, width FROM {{answers}} WHERE parent_question=".$questions['id']."
	ORDER BY id")->queryAll();
	?>
	<ul id="tests">
	<? $k = 0; 
	foreach($qit as $answers) { ?>
		<li>
		<?= CHtml::form();?>
		<input type="hidden" name="test_id" value="<?= $_POST['test_id']?>">
		<input type="hidden" name="question" value="<?= ($start+2); ?>">
		<input type="hidden" name="total" value="<?=$answers['width']+$_POST['total']?>">
		<input type="hidden" name="ans" value="<?=$_POST['ans']?>"><?
		echo CHtml::ajaxSubmitButton('', array('test/t'), array(
			    'type' => 'POST',
			    'update' => '#test',
			),
			array(
			   'id' => $_POST['ans']."-".(time()+$k),
			   'name' => 'enter',
			   'class'=>"sel",
			)
		);
		?>
		<?= CHtml::endForm();?>
		<div class="ans"><?=$answers['answer']?></div>
		<div class="clear"></div>
		</li>
	<? $k++; 
	} ?>
	</ul>

<? } ?>
</div>
