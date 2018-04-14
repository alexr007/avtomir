<?php

class CReport extends CComponent
{
	/// reportName
	/// fileName
	/// data - аrray of data
	/// renderFile()
	
	private $_file_path;
	private $_file_name;
	private $_create_type;
	private $_report_name;
	private $_period1;
	private $_period2;
	
	private $_data;
	private $_width;
	private $_explicit;
	
	private $_excel;
	private $_writer;
	private $_sheet;
	
	private $current_row;

	private $_creator;
	private $_title;
	
	const X_CREATE_FILE_ON_FS = 1;
	const X_IMMEDAITELY_DONDLOAD = 2;
	
	function __construct()
	{
		$this->current_row = 1;
	}
	
	// reportName
	public function getReportName()
	{
		return $this->_report_name;
	}
	
	public function setReportName($value = null)
	{
		$this->_report_name = $value;
		return $this;
	}
	
	/// fileName
	public function setFileName($value = null)
	{
		$this->_file_name = $value;
		return $this;
	}
	
	public function getFileName()
	{
		return $this->_file_name;
	}
	
	/// filePath
	public function getFilePath()
	{
		return $this->_file_path;
	}
	
	public function setFilePath($value = null)
	{
		$this->_file_path = $value;
		return $this;
	}
	
	/// fullPath
	public function getFullPath()
	{
		return $this->filePath.'/'.$this->fileName;
	}
	
	/// createType
	public function setCreateType($value = 1)
	{
		$this->_create_type = $value;
		return $this;
	}
	
	public function getCreateType()
	{
		return $this->_create_type;
	}
	
	/// reportPeriod
	public function setReportPeriod($value1, $value2)
	{
		$this->_period1 = $value1;
		$this->_period2 = $value2	;
		return $this;
	}
	
	/// reportPeriod1
	public function getReportPeriod1()
	{
		return $this->_period1;
	}
	
	/// reportPeriod2
	public function getReportPeriod2()
	{
		return $this->_period2;
	}
	
	/// data
	public function setData($value = [])
	{
		$this->_data = $value;
		return $this;
	}
	
	public function getData()
	{
		return $this->_data;
	}
	
	/// width
	public function setWidth($value = [])
	{
		$this->_width = $value;
		return $this;
	}
	
	public function getWidth()
	{
		return $this->_width;
	}
	
	/// explicit
	public function setExplicit($value = [])
	{
		$this->_explicit = $value;
		return $this;
	}
	
	public function getExplicit()
	{
		return $this->_explicit;
	}
	
	/// creator
	public function setCreator($value = [])
	{
		$this->_creator = $value;
		return $this;
	}
	
	public function getCreator()
	{
		return $this->_creator;
	}
	
	/// title
	public function setTitle($value = [])
	{
		$this->_title = $value;
		return $this;
	}
	
	public function getTitle()
	{
		return $this->_title;
	}
	
	// преобразовывает номер столбца в букву 1->A,... 26->Z, 27-> AA
	function x1toA_($value) 
	{
		$lit = ' ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return ($value<1 || $value>26) ? '' : $lit[$value];
	}
	
	// преобразовывает координату row, col в вид A27, B15
	function xAddr($row, $col) 
	{
		$col1 = (int)(($col-1) / 26);
		$col2 = (int)(($col-1) % 26)+1;
		
		$c1 = ($col1 != 0) ? $this->x1toA_($col1) : '';
		$c2 = $this->x1toA_($col2);
		return $c1.$c2.$row;
	}
	
	function writeRow($data = []) 
	{
		$current_col=1;
		foreach ($data as $item)
			if ($this->explicit[$current_col-1]==1)
				$this->_sheet->
					setCellValueExplicit($this->xAddr($this->current_row, $current_col++), $item, PHPExcel_Cell_DataType::TYPE_STRING);
			else	
				$this->_sheet->
					getCell($this->xAddr($this->current_row, $current_col++))
						->setValue($item);
					
		$this->current_row++;
	}
	
	private function renderMetedata()
	{
		$this->_excel = new PHPExcel();

        $this->_excel->getProperties()->setCreator($this->creator)
             ->setLastModifiedBy($this->creator)
             ->setTitle($this->title)
             //->setSubject("YiiExcel Test Document")
             //->setDescription("Test document for YiiExcel, generated using PHP classes.")
             //->setKeywords("office PHPExcel php YiiExcel UPNFM")
             //->setCategory("Test result file")
			;
			
		$this->_excel->getDefaultStyle()->getFont()->setName('Calibri');
		$this->_excel->getDefaultStyle()->getFont()->setSize(11);
		//$this->_writer = PHPExcel_IOFactory::createWriter($this->_excel, "Excel2007");
        $this->_writer = PHPExcel_IOFactory::createWriter($this->_excel, 'Excel5');
		$this->_sheet = $this->_excel->getActiveSheet();
		$this->_sheet->setTitle('AMT Dispatch');

		return $this;
	}
	
	private function renderHeader()
	{
		$this->writeRow([$this->reportName]);
		$this->writeRow(['Period:', $this->reportPeriod1.' - '.$this->reportPeriod2]);
		
		return $this;
	}

	private function renderDataArray()
	{
		$row = $this->current_row;
		
		foreach ($this->data as $line)
			$this->writeRow($line);
		
		// красим первую строку
		$length = count($this->width); // ширина блока
		$letter = $this->x1toA_($length); // его буква
		$area = 'A'.$row.':'.$letter.$row; // область, которую надо красить
		
		$this->_excel->getActiveSheet()->getStyle($area)->applyFromArray(
        [
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'F2F2F2')
            ]
        ]
		);
		
		return $this;
	}

	private function setColumnWidth()
	{
		foreach ($this->width as $index=>$value)
			$this->_excel->getActiveSheet()->getColumnDimension($this->x1toA_($index+1))->setWidth($value);
			
		return $this;
	}
	
	private function renderData()
	{
		$this->renderHeader();
		$this->renderDataArray();
		$this->setColumnWidth();
		return $this;
	}

	private function output()
	{
		switch ($this->createType) {
			case self::X_CREATE_FILE_ON_FS:
				// сохраняем файл
				// VarDumper::dump($this->getFullPath());
				$this->_writer->save($this->getFullPath());
				break;
			case self::X_IMMEDAITELY_DONDLOAD:
				// генерим вывод в файл
				header('Cache-Control: max-age=0');
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$this->fileName.'"');
				$this->_writer->save('php://output');
				break;
		}
		return true;
	}
	
	public function renderFile()
	{
		$this->renderMetedata()
			->renderData()
			->output();
	}
	
}