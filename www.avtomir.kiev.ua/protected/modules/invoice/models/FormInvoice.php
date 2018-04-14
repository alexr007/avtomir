<?php
/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 07.03.2017
 * Time: 12:32
 */
class FormInvoice extends CFormModel
{
    public $date;
    public $dealer;
    public $invoice;
    public $method;
    public $details;

    public function rules()
    {
        return [
            ['date, dealer, invoice, method, details', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Enter Date',
            'dealer' => 'Select Dealer',
            'invoice' => 'Enter Invoice Number',
            'method' => 'Select Delivery Method',
            'details' => 'Paste Invoice Details'
        ];
    }
}