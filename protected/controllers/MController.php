<?
class MController extends Controller
{
   public function actionIndex()
   {
	$_app = Yii::app();
      	$route = $_app->getUrlManager()->parseUrl($_app->getRequest());		
      	
      	$_app->runController($route);
   }
}
?>
