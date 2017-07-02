<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblProduct;

/**
 * TblSearchProduct represents the model behind the search form about `app\models\TblProduct`.
 */
class TblSearchProduct extends TblProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk_int_product_id', 'fk_int_category_id', 'fk_int_sub_category_id', 'int_item_price', 'int_quantity', 'fk_int_product_varients'], 'integer'],
            [['vchr_item_name', 'vchr_description', 'product_pic'], 'safe'],
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
        $query = TblProduct::find();

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
            'pk_int_product_id' => $this->pk_int_product_id,
            'fk_int_category_id' => $this->fk_int_category_id,
            'fk_int_sub_category_id' => $this->fk_int_sub_category_id,
            'int_item_price' => $this->int_item_price,
            'int_quantity' => $this->int_quantity,
            'fk_int_product_varients' => $this->fk_int_product_varients,
        ]);

        $query->andFilterWhere(['like', 'vchr_item_name', $this->vchr_item_name])
            ->andFilterWhere(['like', 'vchr_description', $this->vchr_description])
            ->andFilterWhere(['like', 'product_pic', $this->product_pic]);

        return $dataProvider;
    }
}
