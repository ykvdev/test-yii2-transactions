<?php

use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stats array */
?>

<?php foreach ($stats as $y => $yStats): ?>
    <div class="panel panel-default">
        <div class="panel-heading">Статистика <?= $y ?>
            <span class="badge" style="float: right"><?= $yStats['count'] ?></span> </div>
        <div class="list-group">
            <?php foreach ($yStats['months'] as $m => $count): ?>
                <a href="<?= Url::to(['/data', 'DataSearch[year]' => $y, 'DataSearch[month]' => $m]) ?>" class="list-group-item">
                    <span class="badge"><?= $count ?></span>
                    <?= \app\Helpers::getLocalizedMonth($m) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>