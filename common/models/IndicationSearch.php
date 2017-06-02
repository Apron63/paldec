<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Indication;

/**
 * IndicationSearch represents the model behind the search form about `common\models\Indication`.
 */
class IndicationSearch extends Indication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'counter_id', 'date', 'value'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $this->load($params);

        $query = Indication::find()->where(['counter_id' => $params['id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC
                ]
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'counter_id' => $this->counter_id,
            'date' => $this->date,
            'value' => $this->value,
        ]);

        return $dataProvider;
    }
}
