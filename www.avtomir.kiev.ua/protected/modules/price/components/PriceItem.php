<?php
class PriceItem extends CComponent
{
	private	$priceDecimals = 2;
	private	$weightDecimals = 2;
	private	$volumeDecimals = 6;
	
	private $_dealer;
	private $_vendor;
	private $_number;
	private $_replaceNumber;
	private $_desc_en;
	private $_desc_ru;
	private $_price;
	private $_core;			// US only
	private $_total;		// price + core
	private $_weight;
	private $_volume;
	
	private $_qty;  		// UAE only
	private $_currency;		// UAE only
	private $_depot;		// UAE only
	private $_route;		// UAE only
	private $_tarif;		// UAE only
	private $_is_subst;		// UAE only
	private $_end_price;            // UAE only
	
    private $allowedViaCtor = [
        'priceDecimals',
        'weightDecimals',
        'volumeDecimals',
		'_dealer',
		'_vendor',
		'_number',
		'_replaceNumber',
		'_desc_en',
		'_desc_ru',
		'_price',
		'_core'	,	
		'_total',		
		'_weight',
		'_volume',
		'_qty',	
		'_currency',
		'_depot',
		'_route',
		'_tarif',
		'_is_subst',
		'_end_price',
    ];
        
	public function __construct($params = null)
    {
		if (is_array($params))
			foreach ($params as $key=>$value)
				if (in_array($key, $this->allowedViaCtor))
					$this->$key=$value;
				else
					if(YII_DEBUG)
						throw new Exception("Exception: field $key not allowed to change via ctor");
    }
        
	private function formatPrice($value = null)
	{
		return (float)number_format($value, $this->priceDecimals,'.','');
	}
	
	private function formatWeight($value = null)
	{
		return (float)number_format($value, $this->weightDecimals,'.','');
	}
	
	private function formatVolume($value = null)
	{
		return (float)number_format($value, $this->volumeDecimals,'.','');
	}
	
	// dealer
	private function getDealer()
	{
		return $this->_dealer;
	}	
	
	// vendor
	private function getVendor()
	{
		return $this->_vendor;
	}	

	// number
	private function getNumber()
	{
		return $this->_number;
	}	

	// replaceNumber
	private function getReplaceNumber()
	{
		return $this->_replaceNumber;
	}	
	
	// descEn
	private function getDescEn()
	{
		return $this->_desc_en;
	}	

	// descRu
	private function getDescRu()
	{
		return $this->_desc_ru;
	}	

	// price
	private function getPrice()
	{
		return $this->formatPrice($this->_price);
	}	

	// core
	private function getCore()
	{
		return $this->formatPrice($this->_core);
	}	

	// total
	private function getTotal()
	{
		return $this->getPrice()+$this->getCore();
	}	

	// weight
	private function getWeight()
	{
		return $this->formatWeight($this->_weight);
	}	

	// volume
	private function getVolume()
	{
		return $this->formatVolume($this->_volume);
	}	
	
	// qty
	private function getQty()
	{
		return $this->_qty;
	}	
	
	// currency
	private function getCurrency()
	{
		return $this->_сurrency;
	}	
	
	// depot
	private function getDepot()
	{
		return $this->_depot;
	}	
	
	// route
	private function getRoute()
	{
		return $this->_route;
	}	
	
	// tarif
	private function getTarif()
	{
		return $this->_tarif;
	}	
	
	// isSubst
	private function getIsSubst()
	{
		return $this->_is_subst;
	}	
	
	// endPrice
	private function getEndPrice()
	{
		return $this->_end_price;
	}	
	
	public function data()
	{
            return [
                'dealer'=>$this->getDealer(),
                'vendor'=>$this->getVendor(),
                'number'=>$this->getNumber(),
                'replace'=>$this->getReplaceNumber(),
                'desc_en'=>$this->getDescEn(),
                'desc_ru'=>$this->getDescRu(),
                'depot'=>$this->getDepot(),
    //          'price'=>$this->getPrice(),
    //          'core'=>$this->getCore(),
                'total'=>$this->getTotal(),
                'qty'=>$this->getQty(),
                'weight'=>$this->getWeight(),
                'volume'=>$this->getVolume(),
            ];
	}
	
	public function columns()
	{
        return [
			'pp_dealer'=>$this->getDealer(),
			'pp_vendor'=>$this->getVendor(),
			'pp_number'=>$this->getNumber(),
			'pp_replacenumber'=>$this->getReplaceNumber(),
			'pp_desc_en'=>$this->getDescEn(),
			'pp_desc_ru'=>$this->getDescRu(),
			'pp_depot'=>$this->getDepot(),
			'pp_qty'=>$this->getQty(),
			'pp_price'=>$this->getTotal(),
			'pp_weight'=>$this->getWeight(),
			'pp_volume'=>$this->getVolume(),
        ];
	}		
}