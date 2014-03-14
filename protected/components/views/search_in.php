			<?php $url = $this->getController()->createUrl('category/search'); ?>
			<?php echo CHtml::beginForm($url, 'GET', array('class'=>'search-box')); ?>
			<?php echo CHtml::activeTextField($form,'string', array('id'=>"search-input-header", 'placeholder'=>"Поиск", 'autocomplete'=>"off", 'name'=>'searchString')) ?>
			<?php echo CHtml::endForm(); ?>
