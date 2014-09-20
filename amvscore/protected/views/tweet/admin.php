<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/

$this->breadcrumbs=array(
	'Tweets'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Tweet','url'=>array('index')),
array('label'=>'Create Tweet','url'=>array('create')),
);

?>

<h1>Manage Tweets</h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'tweet-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'created_at',
		'text',
		'user_id',
		'contest_id',
		'amv_id',
		/*
		'rating',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
