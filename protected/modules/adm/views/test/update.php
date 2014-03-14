<h1>Добавить/Редактировать</h1>

<div id='contactsList'>
    <table class='contactsEditor'>
        <tr>
            <th>Название, Описание</th>
            <th>Результат</th>
        </tr>
        <tbody data-bind="foreach: contacts">
            <tr>
                <td>
                    <input data-bind='value: name' /><br/>
	    	    <textarea data-bind='value: description' rows='5' cols='5'></textarea>
                    <div><a href='#' data-bind='click: $root.removeTest'>Del</a></div>
                </td>
                <td>
                    <table>
                        <tbody data-bind="foreach: inter">
                            <tr>
                                <td>
					<input data-bind="value: inter_id" type="hidden" />
					Min:<input style="width: 30px;" data-bind='value: min_width' /> 
					Max:<input style="width: 30px;" data-bind='value: max_width' />
					<br/>
					<textarea data-bind='value: interpretation' rows='5' cols='5'></textarea>
				</td>                              
                                <td><a href='#' data-bind='click: $root.removeInter'>Del</a></td>				
                            </tr>
                        </tbody>
                    </table>
                    <a href='#' data-bind='click: $root.addInter'>Add</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
 
<p>
    <? if (!$_GET['id']){ ?>  <button data-bind='click: addTest'>Добавить тест</button> <? }?>
    <button data-bind='click: save, enable: contacts().length > 0'>Сохранить</button>
</p>
 
<textarea data-bind='value: lastSavedJson' rows='5' cols='60' disabled='disabled'> </textarea>

<script>
<?if(empty($id)){?>
link = '<?= Yii::app()->createAbsoluteUrl('adm/test/update');?>';
<?} else{ ?>
link = '<?= Yii::app()->createAbsoluteUrl('adm/test/update', array('id'=>$id));?>';
<?}?>
redirect = '<?= Yii::app()->createAbsoluteUrl('adm/test');?>';
deleteInter = '<?= Yii::app()->createAbsoluteUrl('adm/test/delInter');?>';
var data = <?= (!empty($data)) ? '['.$data.']' : 0?>;
</script>
<script src="/resources/js/ico.js"></script>
