<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use kartik\date\DatePicker;
use app\models\CrawlerProfile;


/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'trigger')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), []); ?>

    <?= $form->field($model, 'parse_from')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter Date where to start parsing ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'parse_to')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter Date where to end parsing ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>


    <?= $form->field($model, 'crawler_profile_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(CrawlerProfile::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Select a Crawler Profile ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'custom_regex_entry')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'custom_regex_rating')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
