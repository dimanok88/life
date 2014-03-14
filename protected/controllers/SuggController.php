<?
class SuggController extends Controller
{
   public function actionBest()
   {
   		Yii::app()->getClientScript()->registerScriptFile('/resources/sugg/script.js');
		Yii::app()->getClientScript()->registerCssFile('/resources/sugg/styles.css');	
		// Converting the IP to a number. This is a more effective way
		// to store it in the database:

		$ip	= sprintf('%u',ip2long($_SERVER['REMOTE_ADDR']));


		// The following query uses a left join to select
		// all the suggestions and in the same time determine
		// whether the user has voted on them.

		$sql = "
			SELECT s.*, if (v.ip IS NULL,0,1) AS have_voted
			FROM ls_suggestions AS s
			LEFT JOIN ls_suggestions_votes AS v
			ON(
				s.id = v.suggestion_id
				AND v.day = CURRENT_DATE
				AND v.ip = $ip
			)
			ORDER BY s.rating DESC, s.id DESC
		";
		
		$command = Yii::app()->db->createCommand($sql);
		$result = $command->queryAll();
		   		
	 	$this->render('index', array('result'=>$result));
   }
   
   
   public function actionAjax()
   {
		// If the request did not come from AJAX, exit:
		if($_SERVER['HTTP_X_REQUESTED_WITH'] !='XMLHttpRequest'){
			exit;
		}

		// Converting the IP to a number. This is a more effective way
		// to store it in the database:

		$ip	= sprintf('%u',ip2long($_SERVER['REMOTE_ADDR']));

		if($_GET['action'] == 'vote'){

			$v = (int)$_GET['vote'];
			$id = (int)$_GET['id'];

			if($v != -1 && $v != 1){
				exit;
			}

			// Checking to see whether such a suggest item id exists:	
			if(Suggestions::model()->count('id=:id', array(":id"=>$id)) == 0){
				exit;
			}
	
			// The id, ip and day fields are set as a primary key.
			// The query will fail if we try to insert a duplicate key,
			// which means that a visitor can vote only once per day.
	
			$sql ="
				INSERT INTO ls_suggestions_votes (suggestion_id,ip,day,vote)
				VALUES (
					$id,
					$ip,
					CURRENT_DATE,
					$v
				)
			";
			Yii::app()->db->createCommand($sql)->execute();
			
			if(Suggestions::model()->count('id=:id', array(":id"=>$id)) > 0)
			{
				$sql = "UPDATE ls_suggestions SET 
						".($v == 1 ? 'votes_up = votes_up + 1' : 'votes_down = votes_down + 1').",
						rating = rating + $v
					WHERE id = $id";
				Yii::app()->db->createCommand($sql)->execute();
			}
	
		}
		else if($_GET['action'] == 'submit'){

			if(get_magic_quotes_gpc()){
				array_walk_recursive($_GET,create_function('&$v,$k','$v = stripslashes($v);'));
			}

			// Stripping the content	
			$_GET['content'] = htmlspecialchars(strip_tags($_GET['content']));
	
			if(mb_strlen($_GET['content'],'utf-8')<3){
				exit;
			}
			
			if($this->link($_GET['content']) != true) {
			$sql = "INSERT INTO ls_suggestions SET suggestion = '".$_GET['content']."'";
			Yii::app()->db->createCommand($sql)->execute();
			// Outputting the HTML of the newly created suggestion in a JSON format.
			// We are using (string) to trigger the magic __toString() method of the object.
	
			$it = Suggestions::model()->findByPk(Yii::app()->db->getLastInsertID());

			$cont = '
			<li id="s'.$it->id.'">
			<div class="vote '.((isset($it->have_voted)) ? 'inactive' : 'active').'">
				<span class="up"></span>
				<span class="down"></span>
			</div>
			
			<div class="text">'.$it->suggestion.'</div>
			<div class="rating">'.(int)$it->rating.'</div>
			</li>
			';			
	
			echo json_encode(array('html'=> $cont));
			}
			else 
			{
				$cont = '
					<li id="s">
					<div class="vote inactive">
						<span class="up"></span>
						<span class="down"></span>
					</div>
			
					<div class="text">Вы использовали ссылки в своем тексте. Текст не будет сохранен</div>
					<div class="rating">0</div>
					</li>
					';			
	
					echo json_encode(array('html'=> $cont));
			}
		}
   }
}
?>
