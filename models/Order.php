<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $ID
 * @property int $Customer_id Заказчик
 * @property string|null $Work_list Список работ
 * @property string $Date_from Дата начала работ
 * @property string|null $Date_to Дата окончания работ
 * @property float|null $Price Стоимость работ
 *
 * @property User $customer
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Customer_id', 'Date_from'], 'required'],
            [['Customer_id'], 'integer'],
            [['Work_list'], 'string'],
            [['Date_from', 'Date_to'], 'safe'],
            [['Price'], 'number'],
            [['Customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['Customer_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Customer_id' => 'Customer ID',
            'Work_list' => 'Список работы',
            'Date_from' => 'Дата начала',
            'Date_to' => 'Дата окончания',
            'Price' => 'Стоимость',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['ID' => 'Customer_id']);
    }
}
