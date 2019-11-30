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
            'date' => 'Дата',
            'volume' => 'Сумма',
            'service' => 'Сервис',
            'address_id' => 'Адрес ID',
        ];
    }
}
