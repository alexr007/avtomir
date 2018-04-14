<?php

class Form2Date extends CFormModel
{
	const WEEK1 = '1week';
	const MONTH3 = '3month';
	
	public $date_1;	
	public $date_2;

	public function rules()
	{
		return [
			['date_1, date_2',
				'safe'],
			['date_1, date_2',
				'safe', 'on'=>'search'],
		];
	}
	
	public function setDefaultDates($period = null)
	{

		if ($period == null) $period = self::WEEK1;
		
		/*
		date('w') - номер дня недели 1-7
		date("n") - месяц 1-12
		date("j") - день месяца 1-31
		*/
		
		switch ($period) {
			case self::WEEK1:
				$today = date('w');
				$date1  = mktime(0, 0, 0, date("n")  , date("d")-$today+1, date("Y"));  // monday
				$date2  = mktime(0, 0, 0, date("n")  , date("d")+(7-$today), date("Y")); // sunday
				break;
			case self::MONTH3:
				$date1  = mktime(0, 0, 0, date("n")-3  , date("j"), date("Y"));
				$date2  = mktime(0, 0, 0, date("n")  , date("j"), date("Y"));
			break;
		}
		$this->date_1=date('Y-m-d',$date1);
		$this->date_2=date('Y-m-d',$date2);
	}

	public function attributeLabels()
	{
		return [
			'date_1'=>'Begin Date',
			'date_2'=>'End Date',
		];
	}
	
	public function isEntered1()
	{
		return $this->date_1 != '';
	}

	public function isEntered2()
	{
		return $this->date_2 != '';
	}
	
	public function isEntered()
	{
		return $this->isEntered1() && $this->isEntered2();
	}
	
	public function behaviors() {
		return [
			'ERememberFiltersBehavior' => [
				'class' => 'application.components.ERememberFiltersBehavior',
				'defaults'=>[],
				'defaultStickOnClear'=>false,
				'scenarioName'=>'search',
				'clearAttributes'=>false,
			],
		];
	}
}
?>