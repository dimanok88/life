<div class="comment">
   <div class="comment-body">
        <div class="comment-head">
            <div class="comment-author"><span><?= CHtml::encode($data->name_user); ?></span></div>
            <span class="time"><?= CHtml::encode($data->date_add) ?></span></div>
            <p><?= $data->text; ?></p>
    </div>
</div>
<?/* if (!empty($data->answer)): ?>
    <ul class='children'>
        <li class="comment odd alt depth-2" id="li-comment-2">
            <div class="comment-body clearfix">
                <img alt='' src='/resources/images/admin.png' class='avatar avatar-35 photo' height='48' width='48'/>

                <div class="comment-author vcard">Администратор</div>
                <div class="comment-meta commentmetadata">
                    <span class="comment-date"></span>
                </div>
                <div class="comment-inner">
                    <p><?= $data->answer; ?></p>
                </div>
            </div>
        </li>
    </ul>
<? endif;*/
?>