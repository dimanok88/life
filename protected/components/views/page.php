<div class="clear"></div>
<div>
<?if(count($prev) > 0 ) {?><div class="prev_p show-com"><?php echo CHtml::link($prev['title'], array('pages/view', 'sys'=>$prev['sys']));?></div> <?}?>
<?if(count($next) > 0 ) {?><div class="next_p show-com"><?php echo CHtml::link($next['title'], array('pages/view', 'sys'=>$next['sys']));?></div> <?}?>
</div>
<br/>
<div class="clear"></div>
