<?
$this->title = "Ваши предложения";
$this->pageDesc= "В этом разделе вы можете оставлять свои пожелания и предложения, касающиеся работы и содержания сайта.";
?>

<h1>Ваши предложения</h1>

<div class="full_desc">
В этом разделе вы можете оставлять свои пожелания и предложения, касающиеся работы и содержания сайта.<br/>
Также у вас есть возможность проголосовать за уже существующие варианты: «за» - зеленая стрелочка, «против» - красная.<br/>
За каждое предложение можно голосовать один раз.<br/>
</div>
<div id="page">
	<ul class="suggestions">
	<?if(count($result)> 0 ):?>
		<? foreach($result as $item):?>
			<li id="s<?= $item['id']; ?>">
			<div class="vote <?= (isset($item['have_voted'])) ? 'inactive' : 'active'; ?>">
				<span class="up"></span>
				<span class="down"></span>
			</div>			
			<div class="text"><?= $item['suggestion']?></div>
			<div class="rating"><?= (int)$item['rating'] ?></div>
			</li>
		<? endforeach;?>
	<? endif; ?>
	</ul>
    
    <?= CHtml::form('', 'post', array('id'=>"suggest"))?>
        <p>
            <?= CHtml::textField('text', '', array('id'=>"suggestionText", 'class'=>"rounded", 'maxlength'=>"255" )); ?>
            <?= CHtml::submitButton('Отправить', array('id'=>"submitSuggestion"));?>
        </p>
	<?= CHtml::endForm();?>
</div>
