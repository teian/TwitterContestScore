<?php
$this->widget('booster.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}',
	'columns' => array(
		'user.screen_name',
		'text',		
	),
));
?>