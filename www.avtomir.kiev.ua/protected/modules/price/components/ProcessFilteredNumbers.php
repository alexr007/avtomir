<?php

class ProcessFilteredNumbers {
	private $cleanedNumbers;
	private $providers;
	
	public function __construct(CleanedNumbers $cleanedNumbers, IAvailableProviders $providers)
	{
		$this->cleanedNumbers = $cleanedNumbers;
		$this->providers = $providers;
	}
	
	function process()
	{
		$data = new CList();
		$err = new CList(); // ошибки, возможно, потом обработаем
		foreach ($this->cleanedNumbers->get() as $number)  {
            (new ProcessedNumber($number, $this->providers, $data, $err))
                ->process();
        }
		new FoundResultsStore($data, new RuntimeSession());
	}
}
