<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $ID
 * @property string $Fullname ФИО
 * @property int|null $Role_id
 *
 * @property Order[] $orders
 * @property Role $role
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Fullname'], 'required'],
            [['Role_id'], 'integer'],
            [['Fullname'], 'string', 'max' => 1024],
            [['Role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['Role_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Fullname' => 'Fullname',
            'Role_id' => 'Role ID',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['Customer_id' => 'ID']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['ID' => 'Role_id']);
    }
}
