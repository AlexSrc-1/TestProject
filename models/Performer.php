<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "performer".
 *
 * @property int $ID
 * @property int $Order_id Заказ
 * @property int $Performer_id Пользователь-исполнитель
 * @property string $Appointment_date Дата назначения исполнителя
 * @property string|null $Cause Причина
 */
class Performer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'performer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Order_id', 'Performer_id', 'Appointment_date'], 'required'],
            [['Order_id', 'Performer_id'], 'integer'],
            [['Appointment_date'], 'safe'],
            [['Cause'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Order_id' => 'Заказчик',
            'Performer_id' => 'Performer ID',
            'Appointment_date' => 'Дата изменения',
            'Cause' => 'Причина',
        ];
    }
}
