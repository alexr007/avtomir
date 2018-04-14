<?php

class AvailableProvidersExcel implements IAvailableProviders {

	private $providers;
	
    public function __construct()
	{
		$this->providers = new CList();
		$this->buildProvidersList();
	}
	
	public function items()
	{
		return $this->providers;
	}

    private function buildProvidersList()
    {
		foreach (File::findXls() as $file)
			$this->providers->add(	new PriceFinderNotusedExcel($file->getFullFilePath())	);
    }
}
