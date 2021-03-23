<?php

namespace app\controllers;

use app\models\CreateOrder;
use app\models\DropListUser;
use app\models\Performer;
use app\models\PerformerSearch;
use app\models\Users;
use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    /**
     * View action
     *
     * Action для отображения информации о заказе
     *
     * @id индентификатор заказа
     * @return string
     */
    public function actionView($id)
    {
        $searchModel = new PerformerSearch($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Index action
     *
     * Action для отображения всех заказов
     *
     * @return string
     */
    public function actionIndex()
    {
        $model=new DropListUser();
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }

    /**
     * Create action
     *
     * Action создания нового заказа
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new CreateOrder();

        if ($model->load(Yii::$app->request->post())) {
            $user = Users::find()->where(['Fullname' => $model->fullname])->one();
            if($user == null){
                $user = new Users();
                $user->Fullname = $model->fullname;
                $user->Role_id = 2;
                $user->validate();
                $user->save();
            }
            $order = new Order();
            $order->Customer_id = $user->ID;
            $order->Work_list = $model->work_list;
            $order->Date_from = $model->date_from;
            $order->Date_to = $model->date_to;
            $order->Price = $model->price;
            $order->validate();
            if ($order->save())
                return $this->redirect(['view', 'id' => $order->ID]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update action
     *
     * Action обновления исполнителя заказа
     */
    public function actionUpdate($order, $performer_id, $cause="Без причины")
    {

        $appdate = date("Y-m-d H:i:s");
        $performer_old = Performer::find()->where(['Order_id' => $order])->orderBy(['ID' => SORT_DESC])->limit(1)->one();
        if ($performer_old != null) {
            $performer_old->Cause = $cause;
            $performer_old->validate();
            $performer_old->save();
        }
        $customer = new Performer();
        $customer->Order_id = $order;
        $customer->Performer_id = $performer_id;
        $customer->Appointment_date = $appdate;
        $customer->Cause = Null;
        $customer->validate();
        $customer->save();
    }

    /**
     * Найти заказ
     *
     * Поиск заказа по идентификатору
     *
     * @return Model
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
