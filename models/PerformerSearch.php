<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class PerformerSearch extends Performer
{
    public $id_order = "";
    function  __construct($id){
        $this -> id_order= $id;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'Order_id', 'Performer_id'], 'integer'],
            [['Appointment_date', 'Cause'], 'safe']
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
        $query = Performer::find();

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
            'Order_id' => $this->Order_id,
            'Performer_id' => $this->Performer_id,
            'Appointment_date' => $this->Appointment_date,
            'Cause' => $this->Cause,
        ]);
        $query->where('Order_id='.$this->id_order);
//        $query->andFilterWhere(['1', 'Order_id', $this->Order_id]);

        return $dataProvider;
    }
}
