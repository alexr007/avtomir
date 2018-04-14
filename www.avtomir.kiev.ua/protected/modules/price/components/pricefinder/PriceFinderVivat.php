<?php

class PriceFinderVivat implements IPriceFinder {
	public $login = '';
	public $passwd = '';

	private $ar = null;
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

	private function getDealerId()
	{
		return 2; // mean VIVAT
	}
	
	private function loadAR()
	{
		if (!$this->ar) {
            $this->ar = DbWebService::model()->findByPk(2); // 2 - Mean VIVAT
        }
	}

    private function responseParsed($data) {
        $list = new CList();
		foreach ($data->row as $item) {
            $list->add(
                new PriceItem([
                    '_dealer'=>$this->getDealerId(),
                    '_vendor'=>(string)$item->brand,
                    '_number'=>(int)$item->issubst == 0 ? (string)$item->partno : '',
                    '_replaceNumber'=>$item->issubst > 0 ? (string)$item->partno : '',
                    '_depot'=>(string)$item->depot,
                    '_desc_en'=>(string)$item->desceng,
                    '_desc_ru'=>(string)$item->descrus,
                    '_volume'=>(float)$item->volume,
                    '_weight'=>(float)$this->weightCorr->weight($item->weight),
                    '_price'=>(float)$this->priceCorr->price((float)$item->price),
                    '_qty'=>(int)$item->qty,
                ])
            );
        }
        return $list;
	}

    private function loadTokenFromDb()
	{
		$this->loadAR();
		return $this->ar->getToken();
	}

    private function saveTokenToDb($token)
	{
		$this->loadAR();
		$this->ar->setToken($token)->save();
	}

	private function fetch($path) {
        return @file_get_contents($path);
    }

    private function cleanQuery($search) {
        // should be return false or XML
        // just request and response without any analyze
        $this->loadAR();
        $token = $this->loadTokenFromDb();
        $pathMain=$this->ar->getPathMain();
        $pathPrice=$this->ar->getPathPrice();
        $path=$pathMain.$pathPrice;
        $path=str_replace('$token',$token,$path);
        $path=str_replace('$partno',$search,$path);
        $xml=false;
        if($content=$this->fetch($path)) {
            $xml = new SimpleXMLElement($content);
            $code = (int)$xml->status->id; // mean network error
        }
        else {
            $code = -99; // mean network error
        }
        (new DealerResponse($this->getDealerId()))->putRequest($code);
        return $xml;
    }

    private function getNewTokenFromVivat()
	{
		$this->loadAR();
		$pathMain=$this->ar->getPathMain();
		$pathToken=$this->ar->getPathToken();
		$path=$pathMain.$pathToken;
		$path=str_replace('$login',$this->login,$path);
		$path=str_replace('$passwd',$this->passwd,$path);
//		new DumpExit($path);
		$xml = new SimpleXMLElement(
		    $this->fetch($path)
        );
        $token = (string)$xml->data->row->token;
        $code = (int)$xml->status->id;
        $ret = false;
        // log response
        (new DealerResponse($this->getDealerId()))->putToken($code);
		if ($code == 0) {
			$this->saveTokenToDb($token);
			$ret = true;
		}
		return $ret;
	}

    private function queryToVivat($search = null)
	{
	    // should be return false or XML
        $xml = false;
        if ($search) {
            // есть что искать, ищем
            if ($xml = $this->cleanQuery($search)) {
                // есть ответ, уже хорошо
                if (in_array((int)$xml->status->id, [1,2])) {
                    // ошибка исправима, токен надо просто переполучить
                    if ($this->getNewTokenFromVivat()) {
                        $xml = $this->cleanQuery($search);
                    };
                }
            }
        }
		return $xml;
	}
	
    public function search2($numberToSearch)
    {
        $data = new CList();
        $errors = new CList();
        $xml=$this->queryToVivat($numberToSearch);
        if ($xml === false) {
            $errors->add("server no response");
        }
        elseif (((int)$xml->status->id == 0)&&($xml->status->text=='НЕТ В БАЗЕ ДАННЫХ')) {
            $errors->add("no in database");
        }
        elseif (((int)$xml->status->id == 0)&&($xml->status->text=='НЕТ ЦЕНЫ')) {
            $errors->add("no price");
        }
        elseif ($xml->data->row->price == 0) {
            $errors->add("no price");
        }
        elseif ((int)$xml->status->id == 0) {
            $data = $this->responseParsed($xml->data); //point to xml section <data>
        }
        return new SearchResults($data, $errors);
    }
}