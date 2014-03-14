<? $link = CHtml::link("Подробнее...", array('pages/view', 'sys'=>$data['sys']), array('class'=>'read-more'));

if(file_exists('./resources/upload/'.$data['id']."_page.jpg")){
	$m = CHtml::image('/resources/upload/'.$data['id']."_page.jpg", $data['title'], array('width'=>'440'));
	$l = '/resources/upload/'.$data['id']."_page.jpg";
	$img = CHtml::link($m, array('pages/view', 'sys'=>$data['sys']));
}
else $img = $m = $l ='';
			?>		
						<div class="type-post hentry category-health has-image box post shown" style="background-image: url('<?= $l; ?>'); margin-bottom: 2px;">
                            <?= CHtml::link('
								<h2>'.$data['title'].'</h2>',
                                array('pages/view', 'sys'=>$data['sys']));?>
						</div>												
