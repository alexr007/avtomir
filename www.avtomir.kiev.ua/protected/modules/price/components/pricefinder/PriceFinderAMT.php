<?php

class PriceFinderAMT implements IPriceFinder {
	public $ws_login = ''; // pass from constructor via parameters
	public $ws_passwd = '';// pass from constructor via parameters

	const MAX_LENGTH=50;
	private $soap = null;
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
        $this->soap = new SOAP(
            "http://automototrade.com/wsdl/server.php?wsdl",
            ['encoding'=>'cp1251','connection_timeout'=>3, 'exceptions'=>0],
            [
                'login'=>$this->ws_login,
                'passwd'=>$this->ws_passwd
            ]
        );
    }

	private function getDealerId() //flag
	{
		return 1;
	}
	
	private function responseParsed($items)
	{
	    $list = new CList();
		foreach ($items as $item) {
		    //new DumpExit($item);
			$list->add(
                new PriceItem([
                    '_dealer'=>$this->getDealerId(),
                    '_vendor'=>$item['brand'],
                    '_number'=>$item['oem_original'],
                    '_replaceNumber'=>(new AMTReplaceParsed($item['replace']))->value(),
                    '_desc_en'=>$item['descr'],
                    '_desc_ru'=> mb_substr($item['descr_ru'], 0, self::MAX_LENGTH)  ,
                    //'_weight'=>(float)$this->weightModify($item['weight']),
                    //'_price'=>(float)$this->priceModify($item['list_price']+$item['core_price']),
                    '_weight'=>(float)$this->weightCorr->weight($item['weight']),
                    '_price'=>(float)$this->priceCorr->price($item['list_price']+$item['core_price']),
                    '_core'=>$item['core_price'],
                ])

            );
        }
        return $list;
    }
					
    public function search2($numberToSearch)
    {
        $response = $this->soap->query('getPriceByOem', [
            [$numberToSearch],
        ]);
        $data = new CList();
        $errors = new CList();
        if ((count($response)==1)&&($response['0']=='Incorrect parametrs...')) {
            $errors->add($response['0']);
        }
        elseif ((count($response)==1)&&($response['0']['oem_original']==null)) {
            $errors->add('OEM Number not found');
        }
        else {
            foreach ($response as &$item) {
                $item['descr_ru'] = iconv("Windows-1251","UTF-8",$item['descr_ru']);
            }
            $data = $this->responseParsed($response);
        }
        return new SearchResults($data, $errors);
    }
}