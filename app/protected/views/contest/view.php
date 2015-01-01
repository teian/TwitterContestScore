<?php
/*
 * This is the view file to display contest details.
 * @author Frank Gehann <fg@code-works.de>
 * @copyright Copyright (c) Code Works 2014
 *
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <fg@code-works.de> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Frank Gehann
 * ----------------------------------------------------------------------------
 */
?>

<?php
$this->breadcrumbs = [
	'Contests' => ['index'],
	$model->name,
];

$this->menu = [
	[
		'label'=>'Create Contest',
		'url'=>['create']
	], [
		'label'=>'Update Contest',
		'url'=>[
			'update', 
			'id'=>$model->id
		]
	], [
		'label' => 'Delete Contest',
		'url' => '#',
		'linkOptions' => [
			'submit'=> [
				'delete',
				'id' => $model->id
			],
			'confirm' => 'Are you sure you want to delete this item?'
		],
	], [
		'label'=>'Manage Contest',
		'url'=>['admin']
	]
];
?>

<?php 

$panel_menue = [];

$create = [
    'class' => 'booster.widgets.TbButton',
    'context' => 'primary',
    'buttonType' => 'link',
    'label' => Yii::t("contest", "Create Contest"),
    'icon'=>'plus',
    'size' => 'mini',       
    'url'=>CHtml::normalizeUrl(['Contest/create']),
];

$update = [
    'class' => 'booster.widgets.TbButton',
    'context' => 'primary',
    'buttonType' => 'link',
    'label' => Yii::t("contest", "Update Contest"),
    'icon'=>'update',
    'size' => 'mini',       
    'url'=>CHtml::normalizeUrl(['Contest/update', 'id'=>$model->id]),
];

$admin = [
    'class' => 'booster.widgets.TbButton',
    'context' => 'primary',
    'buttonType' => 'link',
    'label' => Yii::t("contest", "Manage Contest"),
    'icon'=>'list',
    'size' => 'mini',       
    'url'=>CHtml::normalizeUrl(['Contest/admin']),
];

// @Todo: implement user role based access
array_push($panel_menue, $create);
array_push($panel_menue, $admin);

$dataProvider=new CActiveDataProvider('Amv', [
    'criteria' => [
        'condition' => 'contest_id = '.$model->id,
    ],
]);

$content .= "<h1>{$model->name} ({$model->year})</h1>";

$content .= $this->widget('booster.widgets.TbDetailView', [
	'data'=>$model,
	'attributes' => [
			'trigger',
			'year',
			'active:boolean',	
			'parse_from',
			'parse_to',
	),
), true);

$content .= "<h2>AMV's</h2>";

$content .= $this->widget('booster.widgets.TbGridView', [
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}',
	'columns' => [
		[
			'name' => 'contest_amv_id',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->contest_amv_id), array("Amv/view","id"=>$data->id))',
		],
		'avg_rating',
		'min_rating',
		'max_rating',
		'votes',
	],
], true);

$this->widget('booster.widgets.TbPanel', [
    'title' => "{$model->name} ({$model->year})",
    'headerIcon' => 'list',
    'headerButtons' => [
        [
            'class' => 'booster.widgets.TbButtonGroup',
            'size' => 'extra_small',
            'buttons' => $panel_menue,
        ],
    ],                  
    'content' => $content,
]);
?>

