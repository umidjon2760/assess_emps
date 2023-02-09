<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LOGIN', 'PASSWORD', 'MFO', 'LOCAL_CODE', 'NAME', 'BOLIM_CODE', 'CODE_DOLJ','BOLIM_NAME', 'CODE_DOLJ', 'EMAIL','LAVOZIM_NAME','PHONE_NUMBER'], 'safe'],
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
        $query = Users::find();

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
            'LOGIN' => $this->LOGIN,
        ]);
        $query->andFilterWhere(['like', 'PASSWORD', $this->PASSWORD])
            ->andFilterWhere(['like', 'MFO', $this->MFO])
            ->andFilterWhere(['like', 'LOCAL_CODE', $this->LOCAL_CODE])
            ->andFilterWhere(['like', 'CODE_DOLJ', $this->CODE_DOLJ])
            ->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'BOLIM_NAME', $this->BOLIM_NAME])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'PHONE_NUMBER', $this->PHONE_NUMBER])
            ->andFilterWhere(['like', 'LAVOZIM_NAME', $this->LAVOZIM_NAME]);

        return $dataProvider;
    }
}
