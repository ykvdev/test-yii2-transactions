<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Data;

/**
 * DataSearch represents the model behind the search form of `app\models\Data`.
 */
class DataSearch extends Data
{
    const SCENARIO_SEARCH = 'search';

    public $year, $month;

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_SEARCH;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_SEARCH => ['id', 'card_number', 'year', 'month']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'card_number', 'year', 'month'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'year' => 'Год',
            'month' => 'Месяц',
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Data::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'card_number' => $this->card_number,
            'YEAR(date)' => $this->year,
            'MONTH(date)' => $this->month,
        ]);

        return $dataProvider;
    }
}
