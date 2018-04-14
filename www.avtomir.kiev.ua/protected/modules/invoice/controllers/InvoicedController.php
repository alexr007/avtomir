<?php

class InvoicedController extends InvoiceController
{
	public $defaultAction = 'parse';

    public function actionParse()
	{
        $model = new FormInvoice();
        if (!isset($_POST['FormInvoice'])) {
            $this->render('invoice_getinfo',[
                'model' => $model,
                'dealers' => new DbDealer(),
                'methods' => new DbDeliveryType()
            ]);
        }
        else {
            $model->attributes = $_POST['FormInvoice'];
            // строки заказов, прочитанные из БД, прдлежащие обработке
            $parts = new DbParts(
                // инвойс отпарсеный из $_POST['FormInvoice'])
                new Invoice($model->invoice,
                    $model->dealer,
                    $model->method,
                    $model->date,
                    // обрабатываем содержимое инвойса
                    (new InvoiceParsed($model->details))->details()
                )
            );
            //echo "INITIAL ORDER<BR>";new DumpExit($parts->lines(), false);
            //echo "INITIAL INVOICE<BR>";new DumpExit($parts->invoice()->details(), false);
            // сравниваем ORDER vs INVOICE
            $response = $parts->compareToInvoice();
            //echo "NEW ORDER<BR>";new DumpExit($response->order(),false);
            //echo "NEW INVOICE<BR>";new DumpExit($response->invoice()->details(),false);
            // todo 3. пишем $db.orders в БД
            // пройтись по $response->order() и обновить данные о инвойсе
            (new OrderUpdateInvNumber($response->order()))->updateInvoiceNumber($parts->invoice()->id());
            // все что осталось после анализа Invoice и DbParts (остаток коллекции $inv) сохраняем в БД отдельным заказом
            $response->invoice()->storeToDb();

            $this->render('invoice_parsed',[
                'processed' => null,
            ]);
        }

	}

}