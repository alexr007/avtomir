<?php

/**
 * Description of GrabPostData
 *
 * @author alexr
 */
class PostData {
	
	// source array _POST to analyze
	// UserProfile[1][up_value]:0
	// 
	private $origin;
	// model name - i.e. UserProfile
	private $model;
	// fields to analyze - i.e. up_value
	private $fields;
	// result
	private $result;
	// strict parse
	private $strict;
	
	public function __construct($post, $modelName, PostFields $fields, $strict = false)
	{
		$this->origin = $post;
		// название модели, первый ключ - i.e. UserProfile
		$this->model = $modelName;
		// $fields это коллекция полей для анализа [up_value]
		$this->fields = $fields;
		// это поле отвечает что параметрод дожно быть ровно столько - сколько задано в PostFields
		$this->strict = $strict;
		// здесь будет результат парсинга 
		// каждая строка парсинга это элемент PostLine
		// каждый элемент PostLine это PostItem
		$this->result = $this->parse();
	}
	
	public function model() {
		return $this->model;
	}
	
	public function keysToArray() {
		$a = [];
		foreach ($this->result as $item) {
			$a[] = $item->id();
		}
		return $a;
	}
	
	public function byId($id) {
		$r = false;
		foreach ($this->result as $item) {
			if ($item->id() == $id) {
				$r = $item;
			break;
			}
		}
		return $r;
	}

	public function count() {
		return $this->items()->count();
	}
	
	public function zero() {
		return $this->items()->count()==0;
	}
	
	private function items() {
		return $this->result;
	}
	
	private function parse()//($post, $modelName, $fieldsName)
	{
		$result = new CList();
		if(isset($this->origin[$this->model]) && is_array($this->origin[$this->model])) {
			foreach ($this->origin[$this->model] as $key=>$items) { // цикл по строкам
				if (is_array($items)) {
					$postLine = new PostLine($key);
					foreach ($items as $var=>$value) { // цикл по элементам строки
						if ($this->fields->contains($var))
							if ($value != null) {
                                $postLine->add(new PostItem($var, $value));
							}
						}
					if ($postLine->count()>0) {
						if (!$this->strict) {
							$result->add($postLine);
						} else {
							if ($postLine->count() == $this->fields->count())
								$result->add($postLine);
						}
							
					}
				}
			}
		}
		return $result;	
	}

	public function updateDataset ($datasetArray) {
        // проверяем массив ли на входе
        if (is_array($datasetArray)) {
            // идем по строкам
            foreach ($datasetArray as $datasetItem) {
                // данные которые изменены и надо изменить их в базе
                $postLine = $this->byId($datasetItem->getPrimaryKey());
                if (!$postLine->equals($datasetItem)) {
                    // если изменены - то применяем
                    $postLine->apply($datasetItem);
                    $datasetItem->save();
                }
            }
        }
    }

    public function splitDataset ($datasetArray) {
        // проверяем массив ли на входе
	    if (is_array($datasetArray)) {
            // идем по строкам
	        foreach ($datasetArray as $datasetItem) {
                // применяем функцию
                $datasetItem->split(
                    (int)
                    $this->byId($datasetItem->getPrimaryKey())
                    ->byKey("oi_split")
                );
            }
        }
    }
}
