<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\Session;

/**
 * SessionSearch represents the model behind the search form of `app\modules\baholash\models\Session`.
 */
class SessionSearch extends Session
{
    /**
     * {@inheritdoc}
     */
    public $lovmfo;
    public $lovname;
    public $lovcodedolj;
    public function rules()
    {
        return [
            [['ID', 'SESSION_ID'], 'integer'],
            [['PERIOD','LOV_ID','MFO','GROUP_CODE','lovmfo','lovname','lovcodedolj'], 'safe'],
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
        $query = Session::find();

        // add conditions that should always apply here
        $query->joinWith(['lovmfo','lovname','lovcodedolj']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['lovcodedolj'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['assess_zagr.CODE_DOLJ' => SORT_ASC],
            'desc' => ['assess_zagr.CODE_DOLJ' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['lovmfo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['assess_zagr.MFO' => SORT_ASC],
            'desc' => ['assess_zagr.MFO' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['lovname'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['assess_zagr.NAME' => SORT_ASC],
            'desc' => ['assess_zagr.NAME' => SORT_DESC],
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
            'GROUP_CODE' => $this->GROUP_CODE,
            'LOV_ID' => $this->LOV_ID,
            'MFO' => $this->MFO,
            'SESSION_ID' => $this->SESSION_ID,
            'assess_session.PERIOD' => $this->PERIOD,
        ]);

         $query->andFilterWhere(['like', 'assess_zagr.MFO', $this->lovmfo])
                ->andFilterWhere(['like', 'assess_zagr.CODE_DOLJ', $this->lovcodedolj])
                ->andFilterWhere(['like', 'assess_zagr.NAME', $this->lovname]);

        return $dataProvider;
    }
}
