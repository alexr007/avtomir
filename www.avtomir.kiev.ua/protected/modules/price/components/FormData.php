<?php

class FormData implements IFormData {
	
	private $source;
	private $form;
	private $key;
	
	private $_list;
	private $_processed = false;
	
	public function __construct($source, $form, $key)
	{
		$this->source = $source;
		$this->form = $form;
		$this->key = $key;
		$this->_list = new CList();
		$this->_processed = false;
	}
	
	private function getValue()
	{
		if (isset($this->source[$this->form][$this->key])){
			/*
			 * это занимает 0,006, но можно использовать валидацию формы
			*/
			$form = new $this->form;
			$form->attributes = $this->source[$this->form];
			return $form->{$this->key};
			
			/*
			 * это занимает 0,002
			return $this->source[$this->form][$this->key];
			 * 
			 */
		}
		else return null;
	}
	
	private function parseValue()
	{
		foreach (explode("\n", $this->getValue()) as $item) {
            if ($item) {
                $this->_list->add($item);
            }
        }

		$this->_processed = true;
	}
	
	public function value()
	{
		if (!$this->_processed)
			$this->parseValue();
		
		return $this->_list;
	}
	
}
