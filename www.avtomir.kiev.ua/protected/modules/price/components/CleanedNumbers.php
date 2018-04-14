<?php

class CleanedNumbers {
	
	private $source;
	private $filtered;
	
	private $errorHandler;
	
	public function __construct(IFormData $data, ErrorList &$errorHandler)
	{
		$this->filtered = new CUniqueNonEmplyList();
		$this->source = $data->value();
		$this->errorHandler = $errorHandler;
	}
	
	private function cleanNumbers()
	{
		foreach ($this->source as $number)
			$this->processNumber(new PartNumbers($number));
	}
	
	private function processNumber(PartNumbers $partNumbers)
	{
		if ( !$partNumbers->hasErrors() )
			$this->filtered->add($partNumbers->number());
		else
			$this->errorHandler->add($partNumbers->getErrorsMessageFormated(new FormatMessage('html')));
	}
	
	private function checkNull()
	{
		if (($this->source->count != 0)&&($this->filtered->count == 0))
			$this->errorHandler->add("No numbers given, please input numbers.");
	}
	
	public function get()
	{
        $this->cleanNumbers();
        $this->checkNull();
		return $this->filtered;
	}
}
