<?php
/*
 * This is the view file to list the contests.
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
$this->breadcrumbs = ['Contests'];
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

$admin = [
    'class' => 'booster.widgets.TbButton',
    'context' => 'primary',
    'buttonType' => 'link',
    'label' => Yii::t("contest", "Manage Contest"),
    'icon'=>'edit',
    'size' => 'mini',       
    'url'=>CHtml::normalizeUrl(['Contest/admin']),
];

// @Todo: implement user role based access
array_push($panel_menue, $create);
array_push($panel_menue, $admin);

$grid = $this->widget('booster.widgets.TbGridView', [
	'dataProvider' => $dataProvider,
	'type' => 'striped bordered condensed',
	'template' => '{items}{pager}',
	'columns' => [
		[
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->name), array("Contest/view","id"=>$data->id))',
		],
		'year',
		'active:boolean',
	],
], true);

$this->widget('booster.widgets.TbPanel', [
    'title' => Yii::t('contest', 'Contests'),
    'headerIcon' => 'list',
    'headerButtons' => [
        [
            'class' => 'booster.widgets.TbButtonGroup',
            'size' => 'extra_small',
            'buttons' => $panel_menue,
        ],
    ],                  
    'content' => $grid,
]);

?>
