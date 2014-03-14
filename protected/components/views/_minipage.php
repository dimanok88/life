<div class="slide">
	<?=	CHtml::link(
			CHtml::image('../resources/upload/'.$data['id'].'_page.jpg', $data['title']),
			array('pages/view', 'sys'=>$data['sys']));
	?>
	<?= CHtml::link("<span>".$data['title']."</span>", array('pages/view', 'sys'=>$data['sys']), array('class'=>'entry-link')); ?>
	<div><?= Controller::cutString($data['small_desc'], 100); ?></div>	
</div>
