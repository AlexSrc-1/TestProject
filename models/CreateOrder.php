<?php

namespace app\models;

use yii\base\Model;

/**
 * Модель создания нового заказа.
 */
class CreateOrder extends Model
{
    public $fullname;
    public $work_list;
    public $date_from;
    public $date_to;
    public $price;

    public function rules()
    {
        return [
            [['fullname', 'work_list', 'date_from', 'price'], 'required'],
            [['fullname'], 'string', 'max' => 1024],
            [['work_list'], 'string'],
            [['date_from', 'date_to'], 'safe'],
            [['price'], 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fullname' => 'ФИО',
            'work_list' => 'Список работы',
            'date_from' => 'Дата начала',
            'date_to' => 'Дата окончания',
            'price' => 'Стоимость',
        ];
    }
}