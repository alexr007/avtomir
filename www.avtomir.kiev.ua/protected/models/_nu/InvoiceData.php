<?php

class InvoiceData extends CComponent
{
	const INVOICE = 'invoice';
	const SELLER = 'seller';
	const BUYER_BILLING = 'buyer_billing';
	const BUYER_SHIPPING = 'buyer_shipping';
	const CONTENT = 'content';
	const FOOTER = 'footer';
	
	
	public function getInvoiceNumber()
	{
		return ['Invoice','#335'];
	}
	
	public function getSellerInfo()
	{
		return ['Seller Info'];
	}
	
	public function getBuyerBilling()
	{
		return ['Buyer Billing'];
	}
	
	public function getBuyerShipping()
	{
		return ['Buyer Shipping'];
	}
	
	public function getContent()
	{
		return [
			'content'=>['Iphone', '1', '225.55$'],
			'total'=>['Total:', '225.55$'],
			];
	}
	
	public function getFooter()
	{
		return ['footer text'];
	}
	
	public function getData()
	{
		return [
			self::INVOICE=>$this->setInvoiceNumber(),
			self::SELLER=>$this->getSellerInfo(),
			self::BUYER_BILLING=>$this->getBuyerBilling(),
			self::BUYER_SHIPPING=>$this->getBuyerShipping(),
			self::CONTENT=>$this->getContent(),
			self::FOOTER=>$this->getFooter(),
		];
	}
}