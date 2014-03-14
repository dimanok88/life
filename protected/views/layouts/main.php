<!DOCTYPE  html>
<html>
<head profile="http://gmpg.org/xfn/11">
    <meta charset="utf-8">
    <meta name="verify-admitad" content="19a2301f45"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <?
    $this->pageTitle = $this->getOptions('meta_title');

    if (empty($this->title)) $this->title = $this->pageTitle;
    if (empty($this->pageKey)) $this->pageKey = $this->getOptions('meta_keywords');
    if (empty($this->pageDesc)) $this->pageDesc = $this->getOptions('meta_description');
    ?>

    <title><?php echo CHtml::encode($this->title); ?></title>
    <?= CHtml::metaTag($this->pageKey, 'keywords') ?>
    <?= CHtml::metaTag($this->pageDesc, 'description') ?>


    <? Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/resources/css/style.css" type="text/css"
          media="screen"/>
    <!-- ENDS CSS -->

    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- ENDS JS -->

    <!-- JS -->
    <script>
        $(document).ready(function () {
            // hide #back-top first
            $("#toTop").hide();

            // fade in #back-top
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 100) {
                        $('#toTop').fadeIn();
                    } else {
                        $('#toTop').fadeOut();
                    }
                });

                // scroll body to 0px on click
                $('a#toTop').click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
            });
        });
    </script>

</head>
<body class="menu-open">
<div id="wrapper">
    <div id="header">
        <div id="top">
            <div id="logo"><a href="/"><?= Yii::app()->name; ?></a></div>
				<span id="header-links">
                    <? $this->widget('application.components.search_in'); ?>
                    <?= CHtml::link('Связь', array('site/contact'), array('class'=>"top-link")); ?>
				</span>
        </div>
        <div id="menu" style="position: relative; top: 0px; left: 0px; overflow: hidden; z-index: 1;height: 44px;">
            <? $this->widget('application.components.Menu'); ?>
        </div>
    </div>
    <div id="main">
            <?php echo $content; ?>
    </div>

    <a id="toTop" href="#" style="display: none;"><img border="0" src="/resources/images/arrow.png"></a>
</div>
<? $this->widget('application.components.Footer'); ?>
</body>
</html>
