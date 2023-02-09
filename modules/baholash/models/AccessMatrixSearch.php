<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\AccessMatrix;

/**
 * AccessMatrixSearch represents the model behind the search form of `app\modules\baholash\models\AccessMatrix`.
 */
class AccessMatrixSearch extends AccessMatrix
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'IS_EXCEPTION'], 'integer'],
            [['TYPE', 'VALUE', 'MODUL', 'START_DATE', 'END_DATE'], 'safe'],
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
        $query = AccessMatrix::find();

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
            'IS_EXCEPTION' => $this->IS_EXCEPTION,
            'START_DATE' => $this->START_DATE,
            'END_DATE' => $this->END_DATE,
        ]);

        $query->andFilterWhere(['like', 'TYPE', $this->TYPE])
            ->andFilterWhere(['like', 'VALUE', $this->VALUE])
            ->andFilterWhere(['like', 'MODUL', $this->MODUL]);

        return $dataProvider;
    }
}
