<?php

class AvailableProviders implements IAvailableProviders {
    private $providers;

    public function __construct() {
        $accessVIVATdata = require(
            Yii::getPathOfAlias("application.config.access").DIRECTORY_SEPARATOR.'access_vivat.php'
        );
        $accessVIVAT = (Yii::app()->params->dev)
            ? $accessVIVATdata['dev']
            : $accessVIVATdata['norm'];
        $accessAMT = require(
            Yii::getPathOfAlias("application.config.access").DIRECTORY_SEPARATOR.'access_amt.php'
        );

        $avail =  [
            new PriceFinderConfiguration('amt', 'PriceFinderAMT', $accessAMT),
            new PriceFinderConfiguration('vivat', 'PriceFinderVivat', $accessVIVAT),
            new PriceFinderConfiguration('germany1', 'PriceFinderGermany', []),
            new PriceFinderConfiguration('warehouse', 'PriceFinderWarehouse', []),
        ];

        $this->providers = new CList();
        foreach ($avail as $item) {
            $className = $item->className();
            $this->providers->add(
                new $className($item->access())
            );
        }
    }

    public function items()
	{
		return $this->providers;
	}
}
