<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblSubCategory;

/**
 * TblSearchSubCategory represents the model behind the search form about `app\models\TblSubCategory`.
 */
class TblSearchSubCategory extends TblSubCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk_int_sub_category_id', 'fk_int_category_id'], 'integer'],
            [['vchr_sub_category_name'], 'safe'],
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
        $query = TblSubCategory::find();

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
            'pk_int_sub_category_id' => $this->pk_int_sub_category_id,
            'fk_int_category_id' => $this->fk_int_category_id,
        ]);

        $query->andFilterWhere(['like', 'vchr_sub_category_name', $this->vchr_sub_category_name]);

        return $dataProvider;
    }
}
