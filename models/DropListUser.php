<?php

namespace app\models;

use yii\base\Model;

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