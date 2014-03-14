<?php
$this->breadcrumbs=array(
	'Suggestions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Suggestions', 'url'=>array('index')),
	array('label'=>'Create Suggestions', 'url'=>array('create')),
	array('label'=>'View Suggestions', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Suggestions', 'url'=>array('admin')),
);
?>

<h1>Update Suggestions <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>