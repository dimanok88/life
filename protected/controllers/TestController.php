<?
class TestController extends Controller
{
	public $layout='//layouts/contact';	
	public function actionIndex()
	{
		$tests = Yii::app()->db->createCommand()->select('*')->from('{{tests}}')->where('view=1')->queryAll();

		$this->render('index', array('tests'=>$tests));
	}

	public function actionStart($test_id, $ans)
	{
		$tests = Yii::app()->db->createCommand()->select('*')->from('{{tests}}')->where('id='.$test_id.' AND view=1')->queryRow();
		if(!Yii::app()->request->isAjaxRequest){
			$this->render('start', array('tests'=>$tests, 'ans'=>$ans, 'test_id'=>$test_id));
		}
		else $this->renderPartial('start', array('tests'=>$tests, 'ans'=>$ans, 'test_id'=>$test_id), false, true);

	}
	public function actionT()
	{
		if(!empty($_POST)){
			$data = Yii::app()->db
				->createCommand()
				->select('*')
				->from("{{pages}}")
				->order("RAND()")
				->queryRow();
			if(!Yii::app()->request->isAjaxRequest){
				$this->render('test', array('data'=>$data));
			}
			else $this->renderPartial('test', array('data'=>$data), false, true);
		}
		else throw new CHttpException(404,'Такая страница не найдена.'); 
	}
}
