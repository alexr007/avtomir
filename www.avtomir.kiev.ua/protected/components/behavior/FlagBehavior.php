<?php
/*
	для работы с флагами модели ActiveRecord

	у модели должно быть определено поле 'flag'
	дальше работаем с
	x=flag1
	flag1=true
	flag1=false
	...
	
*/
class FlagBehavior extends CBehavior {

	public $flagAttribute = 'flag';
	
	const PF_1 = 0; // 2
	const PF_2 = 1; // 2
	const PF_3 = 2; // 4
	const PF_4 = 3; // 8
	const PF_5 = 4; // 16
	const PF_6 = 5; // 32
	const PF_7 = 6; // 64
	const PF_8 = 7; // 128

	// converts 2^x --> x
	public static function bitNumber($flag = null)
	{
		if ($flag === null) return false;
		$bit = 0;
		while ($flag >0) {
			$flag = $flag >> 1;
			$bit++;
		}
		$bit--;
		return $bit;
	}
	
	public function getFlagValue($flag = null)
	{
		return ((($this->owner->{$this->flagAttribute} >> $flag) & 1) == 1);
	}
	
	public function setFlagValue($flag = null, $value = null)
	{
		$this->getOwner()->flag = ($value==true) ?
			$this->owner->{$this->flagAttribute} | (1<<$flag) :
			$this->owner->{$this->flagAttribute} & ~(1<<$flag);
		return $this;
	}

	// flag1
	public function getFlag1()
	{
		return $this->getFlagValue(self::PF_1);
	}
	
	public function setFlag1($value = false)
	{
		$this->setFlagValue(self::PF_1, $value);
		return $this;
	}
	
	// flag2
	public function getFlag2()
	{
		return $this->getFlagValue(self::PF_2);
	}
	
	public function setFlag2($value = false)
	{
		$this->setFlagValue(self::PF_2, $value);
		return $this;
	}
	
	// flag3
	public function getFlag3()
	{
		return $this->getFlagValue(self::PF_3);
	}
	
	public function setFlag3($value = false)
	{
		$this->setFlagValue(self::PF_3, $value);
		return $this;
	}
	
	// flag4
	public function getFlag4()
	{
		return $this->getFlagValue(self::PF_4);
	}
	
	public function setFlag4($value = false)
	{
		$this->setFlagValue(self::PF_4, $value);
		return $this;
	}

	// flag5
	public function getFlag5()
	{
		return $this->getFlagValue(self::PF_5);
	}
	
	public function setFlag5($value = false)
	{
		$this->setFlagValue(self::PF_5, $value);
		return $this;
	}
	
	// flag6
	public function getFlag6()
	{
		return $this->getFlagValue(self::PF_6);
	}
	
	public function setFlag6($value = false)
	{
		$this->setFlagValue(self::PF_6, $value);
		return $this;
	}
	
	// flag7
	public function getFlag7()
	{
		return $this->getFlagValue(self::PF_7);
	}
	
	public function setFlag7($value = false)
	{
		$this->setFlagValue(self::PF_7, $value);
		return $this;
	}
	
	// flag8
	public function getFlag8()
	{
		return $this->getFlagValue(self::PF_8);
	}
	
	public function setFlag8($value = false)
	{
		$this->setFlagValue(self::PF_8, $value);
		return $this;
	}

}
