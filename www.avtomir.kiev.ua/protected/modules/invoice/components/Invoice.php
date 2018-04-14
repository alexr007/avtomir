<?php
/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 13.03.2017
 * Time: 18:47
 */
class Invoice {
    private $number;
    private $dealer;
    private $method;
    private $date;
    private $details;
    private $id; // DB

    /**
     * @param $number
     * @return DbInvoice instance
     */
    public static function findByNumber($number) {
        return DbInvoice::model()->findByAttributes(['in_number'=>$number]);
    }

    /**
     * Invoice constructor.
     * @param $number
     * @param $dealer
     * @param $method
     * @param $date
     * @param $details
     */
    public function __construct($number, $dealer, $method, $date, $details)
    {
        $this->number = (new NormalizedPartNumber($number))->get();
        $this->dealer = $dealer;
        $this->method = $method;
        $this->date = $date;
        $this->details = $details;
        if (!($dbInvoice = self::findByNumber($this->number))) {
            $dbInvoice = $this->save();
        }
        $this->id = $dbInvoice->in_id;
    }

    private function save() {
        $dbInvoice = new DbInvoice();
        $dbInvoice->in_dealer = $this->dealer;
        $dbInvoice->in_number = $this->number;
        $dbInvoice->in_date = $this->date;
        $dbInvoice->save();
        return $dbInvoice;
    }

    public function dealer() {
        return DbDealer::model()->findByPk($this->dealer);
    }

    private function suffix() {
        return "_".$this->dealer()->name.$this->number;
    }

    public function storeToDb() {
        if ($this->details->count()) {
            $order_id = (new DbCreateNewOrder(new RuntimeUser(), $this->suffix()))->id();
            foreach ($this->details as $item) {
                $orderItem = new DbOrderItem();
                $orderItem->fillWith([
                    'oi_order' => $order_id,
                    'oi_status' => DbOrderItemStatus::OIS_DELIVERY,
                    'oi_ship_method' => $this->method,
                    'oi_dealer' => $this->dealer,
                    'oi_vendor' => $item->pn()->vendor(),
                    'oi_number' => $item->pn()->number(),
                    'oi_qty' => $item->qty(),
                    'oi_invoice' => $this->id,
                ]);
                $orderItem->save();
            }
        }
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }

    /**
     * @return mixed
     */
    public function dealerId()
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
     * @return mixed|string
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function date()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }


}