<?php
$this->breadcrumbs=array(
	'Contests',
);

$this->menu=array(
array('label'=>'Create Contest','url'=>array('create')),
array('label'=>'Manage Contest','url'=>array('admin')),
);
?>

<h1>Contests</h1>

<div class="well">
	<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	)); ?>
</div>
