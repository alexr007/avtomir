<?php

class MInvoiceBuilder extends CComponent
{
	private $_invoiceData;
	
	public function getData()
	{
		return $this->_invoiceData;
	}
	
	public function setData($value = null)
	{
		$this->_invoiceData = $value;
		return $this;
	}
	
	
	public function renderSellerInfo()
	{
		$data = $this->data->sellerInfo;
		/// -> PDF
	}
	
	public function renderInvoiceNumber()
	{
		$data = $this->data->invoiceNumber;
		/// -> PDF
	}
	
	public function renderBuyerInfo()
	{
		$data = $this->data->buyerInfo;
		/// -> PDF
	}
	
	public function renderItems()
	{
		$data = $this->data->items;
		/// -> PDF
	}
	
	public function renderTotal()
	{
		$data = $this->data->total;
		/// -> PDF
	}
	
	public function renderFooter()
	{
		$data = $this->data->footer;
		/// -> PDF
	}
	
	public function renderHeader()
	{
		$this->renderSellerInfo();
		$this->renderInvoiceNumber();
		$this->renderBuyerInfo();
	}
	
	public function renderContent()
	{
		$this->renderItems();
		$this->renderTotal();
	}
	
	public function renderInvoice()
	{
		$this->getData();
		$this->renderHeader();
		$this->renderContent();
		$this->renderFooter();
	}
	
}