<h1>Добавить/Редактировать</h1>

<div id='contactsList'>
    <table class='contactsEditor'>
        <tr>
            <th>Вопрос</th>
	    <th>Ответ</th>
        </tr>
        <tbody data-bind="foreach: contacts">
			    <tr>
				<td><span data-bind="text: ($index()+1)"></span></td>
				<td>
					<input data-bind="value: question_id" type="hidden" />
					<input data-bind="value: q" />
				</td>                              
				<td><a href='#' data-bind='click: $root.removeQuestion'>Del</a></td>
				<td>
					<table>
					<tbody data-bind="foreach: answers">
					    <tr>
						<td><span data-bind="text: ($index()+1)"></span></td>							
						<td>
							<input data-bind='value: $parent.question_id' name="q_id" type="hidden" />									
							<input data-bind='value: answer_id' type="hidden" />
							Балл:<input style="width: 30px;" data-bind="value: point" />
							<input data-bind='value: ans' />
						</td>                              
						<td><a href='#' data-bind='click: $root.removeAnswer'>Del</a></td>
					    </tr>
					</tbody>
					</table>
					<a href='#' data-bind='click: $root.addAnswer'>Add</a>
				</td>
			    </tr>
            </tr>
        </tbody>
    </table>
</div>
 
<p>
    <button data-bind='click: addQuestion'>Добавить</button>
    <button data-bind='click: save, enable: contacts().length > 0'>Сохранить</button>
</p>
 
<textarea data-bind='value: lastSavedJson' rows='5' cols='60' disabled='disabled'> </textarea>
<script>
<?if(empty($id)){?>
link = '<?= Yii::app()->createAbsoluteUrl('adm/test/updateQ');?>';
<?} else{ ?>
link = '<?= Yii::app()->createAbsoluteUrl('adm/test/updateQ', array('test'=>$id));?>';
<?}?>
redirect = '<?= Yii::app()->createAbsoluteUrl('adm/test');?>';
deleteQuestion = '<?= Yii::app()->createAbsoluteUrl('adm/test/delQuest');?>';
deleteAns = '<?= Yii::app()->createAbsoluteUrl('adm/test/delAnswer');?>';
var data = <?= (!empty($data)) ? $data : ''?>;
</script>
<script src="/resources/js/qu.js"></script>
