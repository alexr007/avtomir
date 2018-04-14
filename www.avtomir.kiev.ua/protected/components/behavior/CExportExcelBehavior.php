<?php

class CExportExcelBehavior extends CBehavior {

	const T_DOWNLOAD = 'download';
	const T_CREATEFILE = 'createFile';
	
	const X_FORMAT5 = 'Excel5';
	const X_FORMAT2007 ='Excel2007' ;
	const X_ext5 = '.xls';
	const X_ext2007 = '.xlsx';

	public $exportType = self::T_DOWNLOAD;
//	public $exportType = self::T_CREATEFILE;
	public $filePrefix = 'AM';
	public $fileDelimiter = '_';
	public $excelFormat = self::X_FORMAT5;
	
	public $extraHeader = false;
	public $extraHeaderFunction = 'xlExtraHeader'; // getXlExtraHeader()
	
	public $ownerGetDataFunction = 'xlData'; // getXlData()
	public $ownerHeaderFunction = 'xlReportHeader'; // getXlReportHeader()
	public $ownerRowDataFunction = 'xlReportItem'; // getXlReportItem()
	
	public $ownerLevel1DataFunction = 'getXlLevel1'; // getXlLevel1
	public $ownerLevel1Key = 'si_item';
	
	public $extraParam = null;
	public $deepLevel = 0; // нет рекурсии
	
	private $_excel = null;
	private $_sheet = null;
	private $_writer = null;
	private $_current_row = 1;
	private $_filename = null;
	
	private $data_extraheader = null;
	private $data_header = null;
	private $data = null;
	
	function x1toA_($value) 
	{
		$lit = ' ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return ($value<1 || $value>26) ? '' : $lit[$value];
	}
	
	function xAddr($row, $col) 
	{
		$col1 = (int)(($col-1) / 26);
		$col2 = (int)(($col-1) % 26)+1;
		
		$c1 = ($col1 != 0) ? $this->x1toA_($col1) : '';
		$c2 = $this->x1toA_($col2);
		return $c1.$c2.$row;
	}
	
	private function writeLine($data = []) 
	{
		$current_col=1;
		foreach ($data as $item) 
			$this->_sheet->
				getCell($this->xAddr($this->_current_row, $current_col++))
					->setValue($item);
		$this->_current_row++;
	}
		
	public function getExcelData()
	{
		$this->data = $this->owner->{$this->ownerGetDataFunction};
	}
	
	public function getExtraDataHeader()
	{
		if (!($this->extraHeader)) return;
		$this->data_extraheader = $this->owner->{$this->extraHeaderFunction};
	}
	
	public function getExcelDataHeader()
	{
		$this->data_header = $this->owner->{$this->ownerHeaderFunction};
	}
	
	protected function getUniquePostfix()
	{
		return uniqid();
	}
	
	protected function getFileExtension()
	{
		switch ($this->excelFormat) {
			case self::X_FORMAT5 : return self::X_ext5;
			case self::X_FORMAT2007 : return self::X_ext2007;
		}
	}
	
	protected function setFileName()
	{
		$this->_filename =
			$this->filePrefix
			."_"
			.$this->fileDelimiter
			.$this->getUniquePostfix()
			.$this->getFileExtension();
	}
	
	public function buildExcelHeader()
	{
		$this->_excel = new PHPExcel();
		$this->_excel->getDefaultStyle()->getFont()->setName('Calibri');
		$this->_excel->getDefaultStyle()->getFont()->setSize(11);
		$this->_writer = PHPExcel_IOFactory::createWriter($this->_excel, $this->excelFormat);
		$this->_sheet = $this->_excel->getActiveSheet();
		$this->setFileName();
	}
	
	public function buildExtraHeader()
	{
		if (!($this->extraHeader)) return;
		
		foreach ($this->data_extraheader as $extraheader_line)
			$this->writeLine($extraheader_line);
		$this->_current_row++;
	}
	
	public function buildTableHeader()
	{
		$this->writeLine($this->data_header);
	}
	
	public function buildTableData()
	{
		foreach ($this->data as $item) {
			// обычный обход
			if ($this->deepLevel == 0) 
				$this->writeLine($item->{$this->ownerRowDataFunction});
			// это если есть вложение
			else if ($this->deepLevel == 1) {
				$itemsL2 = $item->{$this->ownerLevel1DataFunction}($item->{$this->ownerLevel1Key});
				
				foreach ($itemsL2 as $itemL2) // цикл по элементам палеты
					$this->writeLine( $itemL2->{$this->ownerRowDataFunction} );
					
			}
		}
	}
	
	public function buildExcelObject()
	{
		$this->buildExcelHeader();
		$this->buildExtraHeader();
		$this->buildTableHeader();
		$this->buildTableData();
	}
	
	public function downloadExcelFile()
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$this->_filename.'"');
		header('Cache-Control: max-age=0');
		$this->_writer->save('php://output');
	}
	
	public function saveExcelFile()
	{
		$path = Yii::getPathOfAlias('webroot.data.output');
		$this->_writer->save($path.'/'.$this->_filename);
	}
	
	public function storeExcelObject()
	{
		switch ($this->exportType) {
			case self::T_DOWNLOAD : $this->downloadExcelFile(); break;
			case self::T_CREATEFILE : $this->saveExcelFile(); break;
		}
	}
	
	public function exportExcel($params = [])
	{
		if ($params != null)
			foreach ($params as $key=>$value)
				$this->$key=$value;
		
		$this->getExtraDataHeader();
		$this->getExcelData();
		$this->getExcelDataHeader();
		$this->buildExcelObject();
		$this->storeExcelObject();
	}
}