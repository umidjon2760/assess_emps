<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\KpiCard;

/**
 * KpiCardSearch represents the model behind the search form of `app\modules\baholash\models\KpiCard`.
 */
class KpiCardSearch extends KpiCard
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'ORD', 'MIN_VALUE', 'AVG_VALUE', 'MAX_VALUE', 'VES', 'PLAN', 'FACT', 'BAJARILISH', 'IVSH', 'CRITERIY_KPI'], 'integer'],
            [['PERIOD', 'INPS', 'MFO', 'LOCAL_CODE', 'CODE_DOLJ', 'KPI_METHOD', 'TABNUM', 'CRITERIY_NAME', 'CRITERIY_ALGORITHM'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = KpiCard::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'PERIOD' => $this->PERIOD,
            'ORD' => $this->ORD,
            'MIN_VALUE' => $this->MIN_VALUE,
            'AVG_VALUE' => $this->AVG_VALUE,
            'MAX_VALUE' => $this->MAX_VALUE,
            'VES' => $this->VES,
            'PLAN' => $this->PLAN,
            'FACT' => $this->FACT,
            'BAJARILISH' => $this->BAJARILISH,
            'IVSH' => $this->IVSH,
            'CRITERIY_KPI' => $this->CRITERIY_KPI,
        ]);

        $query->andFilterWhere(['like', 'INPS', $this->INPS])
            ->andFilterWhere(['like', 'MFO', $this->MFO])
            ->andFilterWhere(['like', 'LOCAL_CODE', $this->LOCAL_CODE])
            ->andFilterWhere(['like', 'CODE_DOLJ', $this->CODE_DOLJ])
            ->andFilterWhere(['like', 'KPI_METHOD', $this->KPI_METHOD])
            ->andFilterWhere(['like', 'TABNUM', $this->TABNUM])
            ->andFilterWhere(['like', 'CRITERIY_NAME', $this->CRITERIY_NAME])
            ->andFilterWhere(['like', 'CRITERIY_ALGORITHM', $this->CRITERIY_ALGORITHM]);

        return $dataProvider;
    }
}
