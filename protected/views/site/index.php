<div align="center" style="margin: 100px 0 0 0;"><h1 style="text-align:center;"><?= $this->getOptions('meta_title');?></h1></div>
<div style="padding: 0 10%;">
<?
if(!isset($_GET['page']) || $_GET['page'] == 1){
 echo $this->getOptions('main_text');
}
 ?>
</div>
<?php
 $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$pages,
	'summaryText'=>"",
	'ajaxUpdate'=>false,
	'template'=>'<div id="posts" class="box-hold">{items}</div>',
	'itemView'=>'_vp',
    'emptyText'=>'',   
    'id'=>'loop',
    'viewData'=>array('no'=>true, 'i'=>0),
    /*'pager'=>array(
        'class'=>'ext.yiinfinite-scroll.YiinfiniteScroller',
        'contentSelector' => '.blog-loop div.items',
        'itemSelector' => 'div.post',
        'donetext'=>'',
        'loadingText'=>'',
    )*/
)); 

?>
