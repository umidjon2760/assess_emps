<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\RelPokaz;

/**
 * RelPokazSearch represents the model behind the search form of `app\modules\baholash\models\RelPokaz`.
 */
class RelPokazSearch extends RelPokaz
{
    /**
     * {@inheritdoc}
     */
    public $relid;
    public $pokaz;
    public function rules()
    {
        return [
            [['ID', 'REL_ID'], 'integer'],
            [['POKAZ_CODE'], 'safe'],
            [['relid', 'pokaz'], 'safe'],
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
        $query = RelPokaz::find();

        // add conditions that should always apply here
        $query->joinWith(['relid', 'pokaz']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['relid'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['assess_relation.ID' => SORT_ASC],
            'desc' => ['assess_relation.ID' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['pokaz'] = [
            'asc' => ['assess_pokaz.CODE' => SORT_ASC],
            'desc' => ['assess_pokaz.CODE' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'REL_ID' => $this->REL_ID,
            'assess_relation.ID' => $this->relid,
        ]);

        $query->andFilterWhere(['like', 'POKAZ_CODE', $this->POKAZ_CODE])
              ->andFilterWhere(['like', 'assess_pokaz.CODE', $this->pokaz]);

        return $dataProvider;
    }
}
