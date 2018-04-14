<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PartListToOrder
 *
 * @author alexr
 */
class PartListToOrder {
	
	private $list;
	
	public function __construct($post, $modelName, $fieldsName, $storage) {
		$this->list = $storage;
        //$this->grabData($post, $modelName, $fieldsName);
		$this->grabDataNEW($post, $modelName, $fieldsName);
	}

	private function grabDataNew($post, $modelName, $fieldsName) {
        $postData = new PostData($post, $modelName, new PostFields($fieldsName), true);
        foreach ($postData->keysToArray() as $postlineId) {
            $line = $postData->byId($postlineId);
            if ($line->byKey("pp_dtype")!=null) {
                $this->list->add(
                    new PartLineRecord(
                        $line->id(),
                        [$line->byKey("pp_cnt"), $line->byKey("pp_dtype")]
                    )
                );
            }
        }
    }

	// это старая версия
    private function grabData($post, $modelName, $fieldsName)
	{
		 //$fieldsName - массив допустимых обрабатываемых параметров = ['pp_cnt','pp_dtype']
		if(isset($post[$modelName]))
			foreach ($_POST[$modelName] as $key=>$items) // цикл по строкам
				{
					$data = null;
					foreach ($items as $k=>$item) // цикл по элементам строки
						if (in_array($k, $fieldsName))
							if ((int)$item != null) $data[]=$item; // если значение != 0 -> то добавляем
							else break;
							
					if (count($data)==count($fieldsName)) // если строка полная - то добавляем
						$this->list->add(new PartLineRecord($key, $data));
				}
	}	
	
	public function add($item) {
		$this->list->add($item);
	}
	
	public function data()
	{
		return $this->list;
	}
	
	public function dataOut()
	{
		foreach ($this->list as $item)
			$item->data();
	}
	
	public function contains($id)
	{
		foreach($this->list as $item) 
			if ($item->id()==$id) 
				return true;
			
		return false;	
	}
	
	public function byId($id)
	{
		foreach($this->list as $item) 
			if ($item->id()==$id) 
				return $item;
	}
}
