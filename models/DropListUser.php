<?php

namespace app\models;

use yii\base\Model;

/**
 * Модель выбора исполнителя.
 */
class DropListUser extends Model
{
    public $users;
    public $description;

    public function rules()
    {
        return [
            [['users', 'description'], 'required'],
            [['description'], 'string'],
        ];
    }
}