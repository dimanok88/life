<!-- googleoff: index-->
<noindex>
<?
if($no == true) { echo "&nbsp;&nbsp; Рейтинг <span>".$r."</span>&nbsp;&nbsp;"; }
else{
?>

<?if($show == true){?>
<div id="rating">Общий рейтинг статьи <span><?=$r;?></span></div>
<?
}
else echo "&nbsp;&nbsp; Рейтинг <span>".$r."</span>&nbsp;&nbsp;";
//because we are activating CSRF and se using POST, we must give token to the AJAX Parameter
$this->widget('CStarRating',array(
    'name'=>'ratingAjax',
    'maxRating'=>'5',
   	'htmlOptions'=>array('class'=>$class),
    'id'=>$id,
    'ratingStepSize'=>'1',
    'callback'=>'
        function(){
                $.ajax({
                    type: "POST",
                    url: "'.Yii::app()->createUrl('site/starRatingAjax').'",
                    data: "'.Yii::app()->request->csrfTokenName.'='.Yii::app()->request->getCsrfToken().'&id_p='.$page_id.'&rate=" + $(this).val(),
                    success: function(msg){
                                $("#'.$id.'_result").html(msg);
                        }})}'
  ));
echo "&nbsp;&nbsp;<span id='".$id."_result'></span>&nbsp;&nbsp;";
}
?>
</noindex>
<!--googleon: index-->
