<?php
/*
 * This is the view file to create a contest.
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
$this->breadcrumbs=array(
	'Contests'=>array('index'),
	'Create',
);

$this->widget('booster.widgets.TbPanel', [
    'title' => Yii::t('contest', 'Create Contest'),
    'headerIcon' => 'plus',
    'content' => $this->renderPartial('_form', array('model'=>$model), true),
]);