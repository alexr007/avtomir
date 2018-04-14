<?php

class PriceFinderExcel implements IPriceFinder
{
	private $file;
    private $connect;
    private $priceCorr = null;
    private $weightCorr = null;

	public function __construct($file, $values = array()) {
        if ($values != null) {
            foreach ($values as $key=>$value) {
                $this->$key=$value;
            }
        }
        $rtUser = new RuntimeUser();
        $this->priceCorr = new PriceBuild($rtUser);
        $this->weightCorr = new WeightBuild($rtUser);
        $this->file = $file;
	}
	
	private function excel()
	{
		if (!$this->connect->count()) {
            $this->connect->add( PHPExcel_IOFactory::load($this->file)	);
        }
		return $this->connect->itemAt(0);
	}
	
	protected function getDealerId()
	{
		return 3;
	}
	
	private function responseParsed($items) {
        $list = new CList();
		// цикл по массиву который нам отдал поиск по файлу
		foreach ($items as $item)
			$list->add(
				new PriceItem([
					'_dealer'=>$this->getDealerId(),
					'_vendor'=>$item['A'],
					'_number'=>$item['B'],
					'_price'=>$this->priceCorr->price($item['C']),
				])
			);
		return $list;
	}
	
    public function search2($numberToSearch)
    {
        $data = new CList();
        $errors = new CList();
        $sheet = $this->excel()->getActiveSheet()->toArray(null,true,true,true);
        foreach ($sheet as $row) {
            foreach ($row as $cell) {
                if (!(mb_strpos(mb_strtoupper((string)$cell), mb_strtoupper($numberToSearch))=== false))
                    $data->add($row);
            }
        }
        $data=$this->responseParsed($data);
        return new SearchResults($data, $errors);
    }
}