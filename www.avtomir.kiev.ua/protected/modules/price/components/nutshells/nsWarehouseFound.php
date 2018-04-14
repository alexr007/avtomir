<?php

class nsWarehouseFound extends ANutShell {
	
	public function run()
	{
		$errors = new ErrorList(); // сюда складываются ошибки, которые мы потом может обработаем
		$cleanedNumbers = new CleanedNumbers(new FormData($this->formData,'PriceForm','number'), $errors);
		
		(new ProcessFilteredNumbers($cleanedNumbers,	new AvailableProvidersExcel() ))->process();
		
		$this->controller->render('index',[
				'controller'=> $this->controller,
				'priceForm'=> new PriceForm(),
				'cleanedNumbers' => $cleanedNumbers->get(),
				'dbPartsPrice' => new DbPartPrice(),
				]
			);
	}
}
