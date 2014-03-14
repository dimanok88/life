<?
echo CHtml::dropDownList('pages_list', '', $pages, array('multiple' => 'multiple', 'id'=>'pages_list'));
echo CHtml::dropDownList('pages[]', $pl, $selpages, array('multiple' => 'multiple', 'id'=>'pagelist'));
?><br/>
<? echo CHtml::button('<', array('class'=>'back'));?>
<? echo CHtml::button('>', array('class'=>'next'));?>

<script>
$('.back').click(function(){
    var new_dd = $('#pagelist option:selected').clone();
    new_dd.attr('selected', 'selected').appendTo('#pages_list'); // append to target
    $("#pagelist option:selected").remove();    
});
$('.next').click(function(){
    var new_dd = $('#pages_list option:selected').clone();
    new_dd.attr('selected', 'selected').appendTo('#pagelist'); // append to target
    $("#pages_list option:selected").remove();    
});
</script>

