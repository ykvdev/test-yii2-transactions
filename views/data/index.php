<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $years array */
/* @var $months array */
/* @var $stats array */

$this->title = 'Транзакции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <div class="col-md-3">
            <?php  echo $this->render('_search', compact('searchModel', 'years', 'months')); ?>
            <?php  echo $this->render('_stats', compact('stats')); ?>
        </div>

        <div class="col-md-9">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'card_number',
                    'date',
                    'volume',
                    'service',
                ],
            ]); ?>
        </div>
    </div>
</div>
