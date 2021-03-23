<?php

use app\models\Performer;
use app\models\Users;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $orders \app\models\Order[]|array|\yii\db\ActiveRecord[] */
/* @var $users \app\models\Users[]|array|\yii\db\ActiveRecord[] */
/* @var $performer \app\models\Performer[]|array|\yii\db\ActiveRecord[] */
/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = "Заказ";
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1>Информация о заказе</h1>
<!--    <p>-->
<!--        --><?//= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::a('Delete', ['delete', 'id' => $model->ID], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'ID',
//            'Customer_id',
            [
                'attribute'=>'Fullname',
                'enableSorting'=>TRUE,
                'label' => 'ФИО',
                'value' => function ($order) {
                    $id = Users::find()->where(['id' => $order->Customer_id])->one();
                    $id = $id->Fullname;
                    return $id;
                },

            ],
            [
                'label' => 'Исполнитель',
                'value' => function ($order) {
                    $id = Performer::find()->where(['Order_id' => $order->ID])->orderBy(['ID' => SORT_DESC])->limit(1)->one();
                    if ($id != null) {
                        $id = Users::find()->where(['ID' => $id->Performer_id])->one();
                        $id = $id->Fullname;
                    }else{
                        $id = "Не назначен";
                    }
                    return $id;
                },

            ],
            'Work_list:ntext',
            [
                'attribute'=>'datefrom',
                'label' => "Дата начала",
                'value' => function ($order) {
                    if ($order->Date_from != null)
                        return  date('d.m.Y',strtotime($order->Date_from));
                    else
                        return "Не задано";
                },
            ],
            [
                'attribute'=>'dateto',
                'label' => "Дата конца",
                'value' => function ($order) {
                    if ($order->Date_to != null)
                        return  date('d.m.Y',strtotime($order->Date_to));
                    else
                        return "Не задано";
                },
            ],
//            'Date_from',
//            'Date_to',
            [
                'attribute'=>'dateto',
                'label' => "Стоимость",
                'value' => function ($order) {
                    if ($order->Price != null)
                        return  $order->Price;
                    else
                        return "Не задано";
                },
            ],
        ],
    ]) ?>
    <h3>История исполнителей заказа</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Исполнитель',
                'value' => function ($order) {
                    $id = Users::find()->where(['ID' => $order->Performer_id])->one();
                    $id = $id->Fullname;
                    return $id;
                },

            ],
            [
                'attribute'=>'Appointmentdate',
                'label' => "Дата изменения",
                'value' => function ($order) {
                    if ($order->Appointment_date != null)
                        return  date('d.m.Y',strtotime($order->Appointment_date));
                    else
                        return "Не задано";
                },
            ],
//            'Appointment_date',
            'Cause'
        ],
    ]); ?>
</div>
