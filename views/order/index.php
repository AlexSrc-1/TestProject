<?php



/* @var $this View */
/* @var $model DropListUser */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider ActiveDataProvider */

use app\models\DropListUser;
use app\models\Order;
use app\models\Performer;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

?>

    <h2>Заказы</h2>
    <div class="search_content">
        <h4>Фильтр</h4>
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= Html::a('Добавить заказ', ['create'], ['class' => 'btn btn-default btn_create_order']) ?>
<?php
Modal::begin([

    'header' => 'Назначить исполнителя',

    'id' => 'your-modal',

    'size' => 'modal-md',

]);
$form = ActiveForm::begin();
echo $form->field($model, 'users')->label(false)->dropDownList(
    ArrayHelper::map(Users::find()->where(['Role_id' => 3])->all(), 'ID', 'Fullname')
);
echo $form->field($model, 'description')->label(false)->textarea(['rows' => '6', 'id'=>'cause']);
echo Html::a('Назначить',['order/index'],  ['class' => 'btn btn-default', 'id'=>'appointBtn']);
echo Html::a('Отменить', ['order/index'], ['class' => 'btn btn-default', 'id'=>'cancelBtn']);
ActiveForm::end();
?>
<h5 class="modal_error">Ошибка: назначен действующий исполнитель</h5>
<?php
Modal::end();

?>
<?php Pjax::begin(['id' => 'pjax_1']); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary'=>'',
    'rowOptions' => function ($model) {
        $first = DateTime::createFromFormat('Y-m-d H:i:s', $model->Date_from);
        $second = new DateTime();
        if ( ($first < $second) && Performer::find()->where(['Order_id' => $model->ID])->one() == null) {
            return ['class' => 'danger'];
        }
        return false;
    },
    'columns' => [
        [
            'attribute'=>'Fullname',
            'label' => 'ФИО',
            'format' => 'raw',
            'value' => function ($order) {
                $id = Users::find()->where(['id' => $order->Customer_id])->one();
                $id = $id->Fullname;
                return Html::a($id, ['view', 'id' => $order->ID]);
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
        [
            'header'=>"Исполнитель",
            'format' => 'raw',
            'value' => function($order) {
                $performer = Performer::find()->where(['Order_id' => $order->ID])->orderBy(['ID' => SORT_DESC])->limit(1)->one();
                return Html::a('Сменить исполнителя', ['create'], [
                    'class' => 'btn btn-default BtnModalId',
                    'data-toggle' => 'modal',
                    'data-target' => '#your-modal',
                    'id_order' =>$order->ID,
                    'desc_enable' => $performer != null ? $performer->Performer_id : "false"
                ]);
            },
        ],
    ],
]); ?>
<?php Pjax::end(); ?>
