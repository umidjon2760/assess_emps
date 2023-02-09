<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\Relation;

/**
 * RelationSearch represents the model behind the search form of `app\modules\baholash\models\Relation`.
 */
class RelationSearch extends Relation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['GROUP_CODE', 'NUV_DOLJ_CODE', 'LOV_DOLJ_CODE1', 'LOV_DOLJ_CODE2', 'LOV_DOLJ_CODE3','POKAZ'], 'safe'],
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
        $query = Relation::find();

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
        ]);

        $query->andFilterWhere(['like', 'GROUP_CODE', $this->GROUP_CODE])
            ->andFilterWhere(['like', 'NUV_DOLJ_CODE', $this->NUV_DOLJ_CODE])
            ->andFilterWhere(['like', 'LOV_DOLJ_CODE1', $this->LOV_DOLJ_CODE1])
            ->andFilterWhere(['like', 'LOV_DOLJ_CODE2', $this->LOV_DOLJ_CODE2])
            ->andFilterWhere(['like', 'LOV_DOLJ_CODE3', $this->LOV_DOLJ_CODE3])
            ->andFilterWhere(['like', 'POKAZ', $this->POKAZ]);

        return $dataProvider;
    }
}
