<?php

class OrderController extends PriceController {
	
	// all orders
	public function actionIndex()
	{
		$dataProvider = (new DbOrder())
				->with('oCagent')
				->with('oStatus')
				->with('oStatistic');

        $user = new RuntimeUser();

        if ($user->isOperator()) {
            $this->render('index_oper',[
                'user'=>$user,
                'dataProvider'=>$dataProvider->search(
                    (new DbOrderCriteria())->orderByDateDesc()  ),
            ]);
        } else {
            $this->render('index',[
                'user'=>$user,
                'dataProvider'=>$dataProvider->search([
                    (new DbOrderCriteria())->byCagent($user),
                    (new DbOrderCriteria())->orderByDateDesc() ]),
            ]);
        }
	}

    // all new
    public function actionNew()
    {
        $dataProvider = (new DbOrder())
            ->with('oCagent')
            ->with('oStatus')
            ->with('oStatistic');
        $user = new RuntimeUser();
        if ($user->isOperator()) {
            $this->render('index_oper',[
                'user' => $user,
                'dataProvider' => $dataProvider->search([
                    (new DbOrderCriteria())->onlyNewOrders(),
                    (new DbOrderCriteria())->orderByDateDesc(),
                ]),
            ]);
        }
    }

    // all new шеуьы
    public function actionNewItems()
    {
        $dataProvider = (new DbOrderItem())
            ->with('oiOrder')
            ->with('oiOrder.oCagent')
            ->with('oiShipMethod')
            ->with('oiDealer');

        $user = new RuntimeUser();
        if ($user->isOperator()) {
            $this->render('index_oper_new',[
                'user' => $user,
                'dataProvider' => $dataProvider->search([
                    (new DbOrderCriteria())->onlyNewOrders(),
                    (new DbOrderCriteria())->orderByDateDesc(),
                ]),
            ]);
        }
    }

	/*
	public function actionSubmitChanges () {
        $user = new RuntimeUser();
        if ($user->isOperator()) {
            $post = new PostData($_POST, 'DbOrder', new PostFields(['o_status']), true);
            $post->updateDataset(DbOrder::model()->findAllByAttributes(['o_id'=>$post->keysToArray()]));
        }
        $this->redirect(['index']);
    }
	*/
	
	public function actionToExcel()
	{
        if (!isset($_GET['id'])) return false;

		(new DbOrderItem())->exportExcel([
			'extraParam'=>$_GET['id'],
		]);
	}

    public function actionExportExcelNewItems()
    {
        $items = new DbOrderItem();
        // экспортируем в excel
        $items->exportExcel([
            'ownerGetDataFunction'=>'XlDataItems', //getXlDataItems
            'ownerHeaderFunction'=>'XlReportHeaderItems', //getXlReportHeaderItems
            'ownerRowDataFunction'=>'XlReportItemItems', // getXlReportItemItems
            'extraParam'=>DbOrderStatus::OS_CREATED,
        ]);
        $list = new CList();
        $orders = new CUniqueNonEmplyList();
        foreach ($items->getDatasetByCriteria((new DbOrderItemCriteria())->byType(DbOrderStatus::OS_CREATED)) as $row) {
            $list->add($row->oi_id);
            $orders->add($row->oi_order);
        }
        // обновляем статусы позиций (строк) заказов
        $NEW=DbOrderItemStatus::OIS_ORDERED;
        $keys=implode(',',$list->toArray());
        Yii::app()->db->createCommand("UPDATE order_item set oi_status=$NEW WHERE oi_id in ($keys)")->execute();
        // обновляем статусы заказов
        foreach ($orders as $order) {
            new CalculateNewOrderStatus($order);
        }
    }

	// concrete order view
	public function actionView($id)
	{
		$this->render('view', [
			'user'=>new RuntimeUser(),
			'order_id'=>$id,
			'stat'=>  DbOrderStatistics::model()->findByPk($id),
			'orderItems'=>new DbOrderItem()
		]);
	}

    // concrete order view
    public function actionEdit($id)
    {
        $user = new RuntimeUser();
        if ($user->isOperator()) {
            $this->render('edit_oper', [
                'user'=>$user,
                'order_id'=>$id,
                'stat'=>  DbOrderStatistics::model()->findByPk($id),
                'orderItems'=>new DbOrderItem()
            ]);
        }
    }

    public function actionSubmitEditOrderChanges () {
	    $user = new RuntimeUser();
        if ($user->isOperator()) {
            $post = new PostData($_POST, 'DbOrderItem', new PostFields(['oi_status']), true);
            $split = new PostData($_POST, 'DbOrderItem', new PostFields(['oi_split']), true);
            //new DumpExit($split, false);
            //new DumpExit($post, false);
            $post->updateDataset(DbOrderItem::model()->findAllByAttributes(['oi_id'=>$post->keysToArray()]));
            $split->splitDataset(DbOrderItem::model()->findAllByAttributes(['oi_id'=>$split->keysToArray()]));
            // берем номер заказа, чтобы на него сделать redirect
            $orderId = DbOrderItem::model()->findByAttributes(['oi_id'=>$post->keysToArray()])->oi_order;
        }
        $this->redirect(["order/edit/id/$orderId"]); // адресация в рамках модуля
    }

	public function actionOrderDeleteItem($id)
	{
		$order = DbOrder::model()->findByPk($id);
		$order->delete();
		
		$this->redirect('index');
	}
	
}
