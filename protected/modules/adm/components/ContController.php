<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ContController extends CController
{
	public function actions(){
        return array(
                'toggle'=>'ext.jtogglecolumn.ToggleAction',
                'switch'=>'ext.jtogglecolumn.SwitchAction', // only if you need it
        );
    }
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	//public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();


    public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

   /* public function init()
    {
        if (!Yii::app()->user->checkAccess('moderator', array('content_id'=>Yii::app()->user->content))) {
            throw new CHttpException(403);
        }
    }*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			 array('allow',
                'users'=>array('@'),
            ),            
            array('deny',
                'roles'=>array('guest'),
            ),
            array('deny',  // deny all users
              'users'=>array('*'),
            ),
		);
	}
}
