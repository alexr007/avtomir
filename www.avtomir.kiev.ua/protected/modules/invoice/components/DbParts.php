<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.03.2017
 * Time: 12:12
 */
class DbParts {
    private $invoice;
    private $dealer;
    private $method;
    private $lines;

    /**
     * DbParts constructor.
     * @param $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->dealer = $invoice->dealerId();
        $this->method = $invoice->method();
        $this->lines = $this->loadItemsFromDb();
    }

    private function loadItemsFromDb () {
        $dataSet=(new DbOrderItem())->getDatasetByCriteria([
            (new DbOrderItemCriteria())->byItemStatus([DbOrderItemStatus::OIS_ORDERED,DbOrderItemStatus::OIS_BOUGHT]),
            (new DbOrderItemCriteria())->byMethod($this->method),
            (new DbOrderItemCriteria())->byDealer($this->dealer),
            (new DbOrderItemCriteria())->orderByDate(),
        ]);
        $list = new JList();
        foreach ($dataSet as $dsi) {
            $list->add(new DbLine($dsi->oi_id, new InvPartNumber($dsi->oi_vendor, $dsi->oi_number), $dsi->oi_qty));
        }
        return $list;
    }

    /**
     * @return mixed
     */
    public function dealer()
    {
        return $this->dealer;
    }

    /**
     * @return mixed
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * @return JList
     */
    public function lines()
    {
        return $this->lines;
    }

    /**
     * @return Invoice
     */
    public function invoice()
    {
        return $this->invoice;
    }

    public function compareToInvoice(){
        // коллекция оригинальный ЗАКАЗ
        $order = $this->lines();
        // коллекция НОВЫЙ заказ
        $new_order = new JList();
        // коллекция КОПИЯ инвойса (оригинал не портим))
        $new_invoice = $this->invoice()->details();
        // сравниваем ЗАКАЗ и ИНВОЙС
        foreach ($order as $order_item) {
            foreach ($new_invoice as $invoice_item) {
                // бизнес-логика
                if ($order_item->pn()->equals($invoice_item->pn())) {
                    // нашли позицию
                    if ($order_item->qty() == $invoice_item->qty()) {
                        // количество совпадает - просто удаляем строку из инвойса
                        $new_invoice->remove($invoice_item->pn());
                        $new_order->add($order_item);
                    }
                    elseif ($order_item->qty() < $invoice_item->qty()) {
                        // в инвойсе больше чем в заказе
                        // вычитаем из инвойса количество позиций, которое весть в заказе
                        $invoice_item->decQty($order_item->qty());
                        $new_order->add($order_item);
                    }
                    elseif ($order_item->qty() > $invoice_item->qty()) {
                        // в заказе больше чем в инвойсе
                        // разделяем строку заказ на 2 шт
                        DbOrderItem::model()->findByPk($order_item->key())->split($invoice_item->qty());
                        // и удаляем строку из инвойса
                        $new_invoice->remove($invoice_item->pn());
                        $new_order->add(new DbLine($order_item->key(),$order_item->pn(),$invoice_item->qty()));
                    }
                    break;
                }
            }
        }
        return new ResponseTuple($new_order,
            new Invoice(
                $this->invoice->number(),
                $this->invoice->dealerId(),
                $this->invoice->method(),
                $this->invoice->date(),
                $new_invoice)
        );
    }
}