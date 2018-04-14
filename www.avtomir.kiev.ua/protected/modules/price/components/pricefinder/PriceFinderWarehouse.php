<?php

class PriceFinderWarehouse implements IPriceFinder
{
    private $priceCorr = null;
    private $weightCorr = null;

    public function __construct(array $values = [])
    {
        if ($values != null) {
            foreach ($values as $key=>$value) {
                $this->$key=$value;
            }
        }
        $rtUser = new RuntimeUser();
        $this->priceCorr = new PriceBuild($rtUser);
        $this->weightCorr = new WeightBuild($rtUser);
    }

	private function getDealerId() //flag
	{
		return 3;
	}
	
	private function responseParsed($response)
	{
        $list = new CList();
	    // $eur = new ExchangeEURUSD();
		foreach ($response as $item) {
		    $list->add(
				new PriceItem([
					'_dealer'=>$this->getDealerId(),
                    '_vendor'=>$item->v_name,
					'_number'=>$item->n_number,
					//'_replaceNumber'=>$this->parseReplace($item['replace']),
					//'_desc_en'=>$item->pr_name,
					//'_desc_ru'=> mb_substr($item['descr_ru'], 0, self::MAX_LENGTH)  ,
                    //'_weight'=>(float)$this->weightCorr->weight($item->pr_weight),
					'_price'=>$this->priceCorr->price($item->in_price),
					//'_core'=>$item->pr_core,
				])
			);
        }
        return $list;
	}

    public function search2($numberToSearch)
    {
        $response = DbWarehouseStockPrice::model()
            ->findAllByAttributes(['n_number'=>$numberToSearch]);
        $data = $this->responseParsed($response);
        $errors = new CList();
        return new SearchResults($data, $errors);
    }
}