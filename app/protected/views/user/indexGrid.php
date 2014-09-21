<?php 
$this->widget('booster.widgets.TbGridView', array(
	'id'=>'user-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'type' => 'striped bordered condensed',
	'columns' => array(
		'username',
		'email',
		array(
			'header' => Yii::t('labels', 'Action'),
			'class' => 'booster.widgets.TbButtonColumn',
			'afterDelete'=>'function(link,status,data){ 
				if(status) bootbox.confirm(data);
			}',
		),
		
	),
	));
?>