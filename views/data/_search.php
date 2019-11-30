<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $years array */
/* @var $months array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-default">
    <div class="panel-heading">Поиск</div>
    <div class="panel-body">
        <div class="data-search">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['autocomplete' => 'off']
            ]); ?>

            <?= $form->field($searchModel, 'id') ?>

            <?= $form->field($searchModel, 'card_number') ?>

            <?= $form->field($searchModel, 'year')->dropDownList($years, ['prompt' => '']) ?>

            <?= $form->field($searchModel, 'month')->dropDownList($months, ['prompt' => '']) ?>

            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Сброс', ['/data'], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>