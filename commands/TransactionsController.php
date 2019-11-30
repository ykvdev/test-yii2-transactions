<?php

namespace app\commands;

use app\models\Data;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class TransactionsController extends Controller
{
    private const LOG_CATEGORY = 'transactions_normalize';

    public $exec = false;

    public $limit = 1000;

    public function options($actionID)
    {
        return ['exec', 'limit'];
    }

    public function optionAliases()
    {
        return ['e' => 'exec', 'l' => 'limit'];
    }

    public function actionNormalize()
    {
        /** @var Data[] $backs */
        $backs = Data::find()->where(['>', 'volume', 0])->limit($this->limit)->all();
        $this->info('Find ' . count($backs) . ' backs');
        foreach ($backs as $back) {
            /** @var Data $transaction */
            $transaction = Data::find()
                ->where(['card_number' => $back->card_number])
                ->andWhere(['address_id' => $back->address_id])
                ->andWhere(['<=', 'date', $back->date])
                ->andWhere(['!=', 'id', $back->id])
                ->orderBy(['date' => SORT_DESC])
                ->limit(1)
                ->one();
            if(!$transaction) {
                $this->warn("Transaction for back id:{$back->id} not found");
                continue;
            }

            $normalizedVolume = $transaction->volume + $back->volume;
            if($this->exec) {
                $dbt = \Yii::$app->db->beginTransaction();
                try {
                    $transaction->volume = $normalizedVolume;
                    $transaction->save();
                    $this->info("Normalized volume {$normalizedVolume} for transaction id:{$transaction->id} saved");

                    $backData = $back->toArray();
                    $back->delete();
                    $this->info("Back id:{$backData['id']} has been deleted " . var_export($backData, true));

                    $dbt->commit();
                } catch(\Throwable $e) {
                    $dbt->rollBack();
                    throw $e;
                }
            } else {
                $this->info("Normalized volume for transaction id:{$transaction->id} is {$normalizedVolume}");
                $this->info("Back id:{$back->id} must be deleted");
            }
        }

        return ExitCode::OK;
    }

    private function info($msg) {
        \Yii::info($msg, self::LOG_CATEGORY);
        $this->stdout($msg . PHP_EOL);
    }

    private function warn($msg) {
        \Yii::warning($msg, self::LOG_CATEGORY);
        $this->stdout($msg . PHP_EOL, Console::FG_YELLOW);
    }
}
