<?php

class nsPriceFound extends ANutShell {

	public function run()
	{
		$errors = new ErrorList(); // сюда складываются ошибки, которые мы потом может обработаем
		$cleanedNumbers = new CleanedNumbers(new FormData($this->formData,'PriceForm','number'), $errors);

		$providers = new AvailableProviders();
		(new ProcessFilteredNumbers(
				$cleanedNumbers,
				$providers )
		)->process();

		$this->controller->render('index',[
				'controller'=> $this->controller,
				'priceForm'=> new PriceForm(),
				'cleanedNumbers' => $cleanedNumbers->get(),
				'dbPartsPrice' => new DbPartPrice(),
			]
		);
	}
}
