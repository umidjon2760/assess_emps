<?php

namespace app\modules\baholash\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\baholash\models\Zagr;

/**
 * ZagrSearch represents the model behind the search form of `app\modules\baholash\models\Zagr`.
 */
class ZagrSearch extends Zagr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'CBID', 'INPS'], 'integer'],
            [['MFO', 'LOCAL_CODE', 'NAME', 'BOLIM_CODE', 'BOLIM_NAME', 'CODE_DOLJ', 'LAVOZIM_NAME', 'TABEL','NAME_NAPRAV', 'PERIOD'], 'safe'],
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
        $query = Zagr::find();

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
            'CBID' => $this->CBID,
            'INPS' => $this->INPS,
            'PERIOD' => $this->PERIOD,
        ]);

        $query->andFilterWhere(['like', 'MFO', $this->MFO])
            ->andFilterWhere(['like', 'LOCAL_CODE', $this->LOCAL_CODE])
            ->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'BOLIM_CODE', $this->BOLIM_CODE])
            ->andFilterWhere(['like', 'BOLIM_NAME', $this->BOLIM_NAME])
            ->andFilterWhere(['like', 'CODE_DOLJ', $this->CODE_DOLJ])
            ->andFilterWhere(['like', 'LAVOZIM_NAME', $this->LAVOZIM_NAME])
            ->andFilterWhere(['like', 'NAME_NAPRAV', $this->NAME_NAPRAV])
            ->andFilterWhere(['like', 'TABEL', $this->TABEL]);

        return $dataProvider;
    }
}
