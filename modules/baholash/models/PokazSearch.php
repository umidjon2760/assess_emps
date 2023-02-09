<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\Pokaz;

/**
 * PokazSearch represents the model behind the search form of `app\modules\baholash\models\Pokaz`.
 */
class PokazSearch extends Pokaz
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'MIN_VALUE', 'MAX_VALUE'], 'integer'],
            [['CODE', 'NAME'], 'safe'],
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
        $query = Pokaz::find();

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
            'MIN_VALUE' => $this->MIN_VALUE,
            'MAX_VALUE' => $this->MAX_VALUE,
        ]);

        $query->andFilterWhere(['like', 'CODE', $this->CODE])
            ->andFilterWhere(['like', 'NAME', $this->NAME]);

        return $dataProvider;
    }
}
