<? $text = $this->cutString($data->desc, 300); ?>
<div style="border:1px solid black; padding: 5px 10px;">
	<?php echo CHtml::link($data->title, array('category/view', 'id'=>$data->id, 'tl'=>Controller::translit($data->title)));?>
	<br />
	<?php echo $text; ?>
	<br />
</div>
<br/>
