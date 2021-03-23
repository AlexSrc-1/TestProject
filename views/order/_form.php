<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderDelete */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-delete-form">

    <?php $form = ActiveForm::begin(['class' => 'search_input']); ?>
    <?= $form->field($model, 'fullname')->textInput() ?>

    <?= $form->field($model, 'work_list')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_from')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'date_to')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
