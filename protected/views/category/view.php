<?
if(!empty($model->meta_title)) $this->title= $model->meta_title;
else $this->title = $model->title;
$this->pageDesc= $model->meta_desc;
$this->pageKey= $model->meta_keywords;
?>

<div align="center" style="margin: 100px 0 0 0;"><h1><?php echo $model->title; ?></h1></div>
<? if(!isset($_GET['Pages_page']) || $_GET['Pages_page'] == 1){?>
 <div id="content_category">
 <? $ads = '';
$cnt = preg_replace('#^(.*?<p>.*?</p>)(.*?)#sui', '$1'.$ads.'$2', $model->desc);
?>
	<?= $cnt; ?>
<? }?>
</div>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$pages,
    'summaryText'=>"",
    'ajaxUpdate'=>false,
    'template'=>'{pager}<div id="posts" class="box-hold">{items}</div>{pager}',
    'itemView'=>'application.views.site._vp',
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
)); ?>