<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'Date_from')->label(false)->textInput(['type' => 'date', 'class'=>'search_item'])?>

    <?= $form->field($model, 'Price')->label(false)->textInput(['maxlength' => true, 'class'=>'search_item']) ?>

    <div class="form-group">
        <?= Html::submitButton('Применить', ['class' => 'btn btn-default']) ?>
        <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
