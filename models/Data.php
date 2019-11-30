<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property int $id
 * @property string|null $card_number
 * @property string $date
 * @property float $volume
 * @property string $service
 * @property int|null $address_id
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'volume', 'service'], 'required'],
            [['date'], 'safe'],
            [['volume'], 'number'],
            [['address_id'], 'integer'],
            [['card_number'], 'string', 'max' => 20],
            [['service'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_number' => 'Номер карты',
            'date' => 'Дата/время',
            'volume' => 'Сумма',
            'service' => 'Сервис',
            'address_id' => 'Адрес ID',
        ];
    }

    /**
     * @return array
     */
    public static function getAvailableYears()
    {
        $years = static::find()
            ->distinct()
            ->select(['y' => 'YEAR(`date`)'])
            ->orderBy(['y' => SORT_DESC])
            ->asArray()
            ->column();

        foreach ($years as $k => $y) {
            $years[$y] = $y;
            unset($years[$k]);
        }

        return $years;
    }

    /**
     * @return array
     */
    public static function getYearMonthStats()
    {
        $stats = static::find()
            ->distinct()
            ->select(['y' => 'YEAR(`date`)', 'm' => 'MONTH(`date`)', 'c' => 'COUNT(`id`)'])
            ->groupBy(['y', 'm'])
            ->orderBy(['y' => SORT_DESC, 'm' => SORT_DESC])
            ->asArray()
            ->all();

        foreach ($stats as $k => $item) {
            $stats[$item['y']]['count'] = $stats[$item['y']]['count'] ?? 0;
            $stats[$item['y']]['count'] += $item['c'];

            $stats[$item['y']]['months'][$item['m']] = $item['c'];

            unset($stats[$k]);
        }

        return $stats;
    }

    /**
     * @param int $limit
     *
     * @return self[]
     */
    public static function getBacks($limit)
    {
        $backs = Data::find()->where(['>', 'volume', 0])->limit($limit)->all();

        return $backs;
    }

    /**
     * @param Data $back
     *
     * @return Data|null
     */
    public static function getTransactionForBack(Data $back)
    {
        /** @var Data $transaction */
        $transaction = Data::find()
            ->where(['card_number' => $back->card_number])
            ->andWhere(['address_id' => $back->address_id])
            ->andWhere(['<=', 'date', $back->date])
            ->andWhere(['!=', 'id', $back->id])
            ->orderBy(['date' => SORT_DESC])
            ->limit(1)
            ->one();

        $transaction = $transaction && $transaction->volume < 0 ? $transaction : null;

        return $transaction;
    }
}
