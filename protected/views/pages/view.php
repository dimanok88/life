<?
if(!empty($model['meta_title'])) $this->title= $model['meta_title'];
else $this->title = $model['title'];
$this->pageDesc= $model['meta_desc'];
$this->pageKey= $model['meta_keywords'];
$cat_t = Category::model()->getNameCat($model['category_id']);


$ads = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- life -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-5747646096312950"
     data-ad-slot="5261100868"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';

$ads2 = '<p align="center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- life_bot -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-5747646096312950"
     data-ad-slot="2946762866"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</p>';

$block = '<li><p align="center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- life -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-5747646096312950"
     data-ad-slot="5261100868"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</p></li>';


if(file_exists('./resources/upload/'.$model['id']."_page_s.jpg")){
	$m = CHtml::image('/resources/upload/'.$model['id']."_page_s.jpg", $model['title'], array('class'=>'post-image size-full'));
}
else $m = '';

?>

	<div class="main-area" id="single">
	<div class="post">
	<div class="post-image-wrap wrap-size-full">
		<h1>
			<?= CHtml::link($model['title'],  array('pages/view', 'sys'=>$model['sys']), array('title'=>$model['title']))?>
		</h1>
<?= $ads; ?>
		<?= $m;?>
	</div>	

	<div id="content">
        <div class="post-page" id="page-1">
        <div class="post-box">
<?
$cnt1 = preg_replace('#^(.*?<li>.*?</li>)(.*?)#sui', '$1'.$ads2.'$2', $model['full_desc']);
$cnt = $cnt1.$ads2;?>

		<?=$cnt;?>
		<div class="clear"></div>
		<? if(!empty($model['test'])){
			$res = Yii::app()->db->createCommand("SELECT COUNT(*) as c FROM {{questions}} WHERE parent_test=".$model['test'])->queryRow();
			if($res['c'] > 0){
			$ans = $res['c'];
		?>
		<div id="page_test"></div>
		<script>
		$( "#page_test" ).load('<?= Yii::app()->createAbsoluteUrl('test/start', array('test_id'=>$model['test'],'ans'=>$ans));?>');
		</script>
		<?}}
		else{
			$res1 = Yii::app()->db->createCommand("SELECT (SELECT COUNT(*) FROM {{questions}} WHERE parent_test=q.parent_test) as c, parent_test FROM {{questions}} as q WHERE 1 ORDER BY RAND()")->queryRow();
			if($res1['c'] > 0 && count($res1)){
			   $ans1 = $res1['c'];
			
		?>
		<div id="page_test"></div>
		<script>
		$( "#page_test" ).load('<?= Yii::app()->createAbsoluteUrl('test/start', array('test_id'=>$res1['parent_test'],'ans'=>$ans1));?>');
		</script>
		<?}}?>
		
	

        </div>
        </div>
	</div>

    <div align="center">
		<noindex><!--googleoff: index-->
		<div id="social" rel="nofollow">
		<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
		<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div> 
		</div>
		<!--googleon: index--></noindex>
    </div>
<? $this->widget('Related', array('t'=>$model['sys'])); ?>
		
	<div class="post-box" id="popular-comments">
		<div class="spinner">1</div>
		<div id="show-comments">
			<button class="bt-link" name="show-comments">See all comments</button>
		</div>
	</div>
	
	</div>
	</div><!-- #single -->
	
	<div class="sidebar-area">
		<div id="sidebar-wrapper">
			<div id="sidebar">
			<span data-icon="D" class="sidebar-close"></span>

	<div class="sidebar-widget" id="comments">
            <div id="mess"></div>
            <?php $this->commentsList($model['id'], 'page'); ?>
            <?php echo $this->renderPartial('application.views.comments._comment_form', array('comment'=>$comments, 'id'=>$model['id'], 'type'=>'page'), false, false); ?>
	</div>
		</div>
	</div>
