<?php

class ProcessedNumber {
	private $partNumber;
	private $providers;
	private $dataLink;
	private $errLink;
	
	public function __construct($partNumber, IAvailableProviders $providers, CList &$data, CList &$err)
	{
		$this->partNumber = $partNumber;
		$this->providers = $providers;
		$this->dataLink = $data;
		$this->errLink = $err;
	}
	
	public function process()
	{
	    new PriceLogger($this->partNumber, new DbPartSearchHistory());
		
		foreach ($this->providers->items() as $provider) { // цикл по провайдерам
            $searchResults = $provider->search2($this->partNumber);
            if ($searchResults->hasData()) {
                $this->dataLink->mergeWith($searchResults->data());
            }
            if ($searchResults->hasErrors()) {
                $this->errLink->mergeWith($searchResults->errors());
            }
		}
	}
}
