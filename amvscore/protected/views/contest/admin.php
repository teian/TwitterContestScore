<?php
$this->breadcrumbs=array(
	'Contests'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Contest','url'=>array('index')),
array('label'=>'Create Contest','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('contest-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Contests</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'contest-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'name',
		'trigger',
		'year',
		'active',
		'parse_from',
		'parse_to',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
