<?= "<?xml version='1.0' encoding='UTF-8'?>\n" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
  <loc><?= Yii::app()->createAbsoluteUrl('/'); ?></loc>
  <priority>1.00</priority>
</url>	    
	<? foreach($cats as $cat){ ?>
	<url>
	<? $url = Yii::app()->createAbsoluteUrl('category/view', array('id'=>$cat['id'], 'tl'=>$this->translit($cat['title']))); ?>
		<loc><?= $url ?></loc>
		<lastmod><?
		$date = explode(" ", $cat['date_modify']);
		echo $date[0]."T".$date[1]."+00:00";		
		?></lastmod>
		<priority>0.90</priority>
	</url>
	<? } ?>
	<? foreach($pages as $page){ ?>
	<url>
	<? $url = Yii::app()->createAbsoluteUrl('pages/view', array('sys'=>$page['sys'])); ?>
		<loc><?= $url ?></loc>
		<lastmod><?
		 $date = explode(" ", $page['date_modify']);
		 echo $date[0]."T".$date[1]."+00:00";
		 ?></lastmod>
		<priority>0.90</priority>
	</url>
	<? } ?>
</urlset>

