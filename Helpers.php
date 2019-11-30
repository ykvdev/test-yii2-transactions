<?php

namespace app;

class Helpers
{
    /**
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public static function getLocalizedMonths()
    {
        $months = [];
        foreach (range(1, 12) as $m) {
            $months[$m] = static::getLocalizedMonth($m);
        }

        return $months;
    }

    /**
     * @param $m int
     *
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public static function getLocalizedMonth($m)
    {
        $months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль',
            'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь',];
        $month = $months[$m - 1];

        return $month;
    }
}