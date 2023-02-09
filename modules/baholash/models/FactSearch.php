<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\Fact;

/**
 * FactSearch represents the model behind the search form of `app\modules\baholash\models\Fact`.
 */
class FactSearch extends Fact
{
    /**
     * {@inheritdoc}
     */
    public $lovmfo;
    public $nuvmfo;
    public $lovcodedolj;
    public $nuvcodedolj;
    public function rules()
    {
        return [
            [['ID', 'LOV_ID', 'NUV_ID', 'VALUE'], 'integer'],
            [['POKAZ_CODE', 'COMMENT', 'PERIOD','GROUP_CODE'], 'safe'],
            [['lovmfo', 'nuvmfo','lovcodedolj','nuvcodedolj'], 'safe'],
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
        $query = Fact::find();

        // add conditions that should always apply here
        $query->joinWith(['lovmfo', 'nuvmfo','lovcodedolj','nuvcodedolj']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['lovmfo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['assess_zagr.LOCAL_CODE' => SORT_ASC],
            'desc' => ['assess_zagr.LOCAL_CODE' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['nuvmfo'] = [
            'asc' => ['assess_zagr.LOCAL_CODE' => SORT_ASC],
            'desc' => ['assess_zagr.LOCAL_CODE' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['lovcodedolj'] = [
            'asc' => ['assess_zagr.CODE_DOLJ' => SORT_ASC],
            'desc' => ['assess_zagr.CODE_DOLJ' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['nuvcodedolj'] = [
            'asc' => ['assess_zagr.CODE_DOLJ' => SORT_ASC],
            'desc' => ['assess_zagr.CODE_DOLJ' => SORT_DESC],
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
            'LOV_ID' => $this->LOV_ID,
            'NUV_ID' => $this->NUV_ID,
            'VALUE' => $this->VALUE,
            'assess_fact.PERIOD' => $this->PERIOD,
        ]);

        $query->andFilterWhere(['like', 'POKAZ_CODE', $this->POKAZ_CODE])
            ->andFilterWhere(['like', 'GROUP_CODE', $this->GROUP_CODE])
            ->andFilterWhere(['like', 'assess_zagr.LOCAL_CODE', $this->lovmfo])
            ->andFilterWhere(['like', 'assess_zagr.LOCAL_CODE', $this->nuvmfo])
            ->andFilterWhere(['like', 'assess_zagr.CODE_DOLJ', $this->lovcodedolj])
            ->andFilterWhere(['like', 'assess_zagr.CODE_DOLJ', $this->nuvcodedolj])
            ->andFilterWhere(['like', 'COMMENT', $this->COMMENT]);

        return $dataProvider;
    }
}
