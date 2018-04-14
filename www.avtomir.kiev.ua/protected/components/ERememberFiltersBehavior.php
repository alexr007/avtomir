<?php
/**
* Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the 
* documentation and/or other materials provided with the distribution.
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT 
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
* HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT 
* LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON 
* ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
* USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* ERememberFiltersBehavior class file.
*
* @author Pentium10 http://www.yiiframework.com/forum/index.php?/user/8824-pentium10/
* @link http://www.yiiframework.com/
* @version 1.2.1
* Copyright (c) 2011, Pentium10
* All rights reserved.
* The ERememberFiltersBehavior extension adds up some functionality to the default
* possibilites of CActiveRecord/Model implementation.
*
* It will detect the search scenario and it will save the filters from the GridView.
* This comes handy when you need to store them for later use. For heavy navigation and
* heavy filtering this function can be activated by just a couple of lines.
*
* To use this extension, just copy this file to your components/ directory,
* add 'import' => 'application.components.ERememberFiltersBehavior', [...] to your
* config/main.php and paste the following code to your behaviors() method of your model
*
* public function behaviors() {
*        return array(
*            'ERememberFiltersBehavior' => array(
*                'class' => 'application.components.ERememberFiltersBehavior',
*                'defaults'=>array(),
*                'defaultStickOnClear'=>false,
*                'scenarioName'=>'search',
*            ),
*        );
* }
* 
* 'defaults' is a key value pair array, that will hold the defaults for your filters. 
* For example when you initially want to display `active products`, you set to array('status'=>'active'). 
* You can of course put multiple default values.
*
* 'defaultStickOnClear'=>true can be used, if you want the default values to be put back when the user clears the filters
* The default set is 'false' so if the user clears the filters, also the defaults are cleared out.
*
* You can use `scenarios` to remember the filters on multiple states of the same model. This is helpful when you use the same 
* model on different views and you want to remember the state separated from each other.
* Known limitations: the views must be in different actions (not on the same view)
*
* To set a scenario add the set call after the instantiation
* Fragment from actionAdmin():
*
* $model=new Persons('search');
* $model->setRememberScenario('scene1');
*
* 'scenarioName'=>'search' is a name of a search function in your model. Change this, if you use other function name,
* i.e. if your code looks like:
* 
* $model=new Persons('searchSort'));
* 
*
* CHANGELOG
* 
* 2013-11-01
* v1.2.1 
* Clear state if class $attribute is not set.
* 
* 2011-06-02
* v1.2 
* Added support for 'scenarios'. 
* You can now tell your model to use custom scenario. 
*
* 2011-03-06
* v1.1 
* Added support for 'defaults' and 'defaultStickOnClear'. 
* You can now tell your model to set default filters for your form using this extension.
*
* 2011-01-31
* v1.0 
* Initial release
*
* This extension has also a pair Clear Filters Gridview
* http://www.yiiframework.com/extension/clear-filters-gridview
*
* Please VOTE this extension if helps you at:
* http://www.yiiframework.com/extension/remember-filters-gridview
*/
class ERememberFiltersBehavior extends CActiveRecordBehavior {
    /**
     * Array that holds any default filter value like array('active'=>'1')
     *
     * @var array
     */
    public $defaults=array();
    /**
     * When this flag is true, the default values will be used also when the user clears the filters
     *
     * @var boolean
     */
    public $defaultStickOnClear=false;
    /**
     * Default search scenario name
     * 
     * @var string
     */
    public $scenarioName='search';
    
	/**
	* Holds a custom stateId key 
	*
	* @var string
	*/
	private $_rememberScenario=null;
	
    // alexr
	public $clearAttributes=true;
	
	private function getStatePrefix() {
	    $modelName = get_class($this->owner);
	    if ($this->_rememberScenario!=null) {
	        return $modelName.$this->_rememberScenario;
	    } else {
	        return $modelName;
	    }
	}
	
	public function setRememberScenario($value) {
	    $this->_rememberScenario=$value;
	    //$this->doReadSave();
	    return $this->owner;
	}
	
	public function getRememberScenario() {
	    return $this->_rememberScenario;
	}
		
    private function readSearchValues() {
        $modelName = get_class($this->owner);
        $attributes = $this->owner->getSafeAttributeNames();
        // set any default value
        if (is_array($this->defaults) && (null==Yii::app()->user->getState($modelName . __CLASS__. 'defaultsSet', null))) {
            foreach ($this->defaults as $attribute => $value) {
                if (null == (Yii::app()->user->getState($this->getStatePrefix() . $attribute, null))) {
                    Yii::app()->user->setState($this->getStatePrefix() . $attribute, $value);
                }
            }
            Yii::app()->user->setState($modelName . __CLASS__. 'defaultsSet', 1);
        }
        
        // set values from session
        foreach ($attributes as $attribute) {
            if (null != ($value = Yii::app()->user->getState($this->getStatePrefix() . $attribute, null))) {
                try
                {
                    $this->owner->$attribute = $value;
                }
                catch (Exception $e) {
                }
            }
        }
    }
    private function saveSearchValues() {
        $attributes = $this->owner->getSafeAttributeNames();
        foreach ($attributes as $attribute) {
            if (isset($this->owner->$attribute)) {
                Yii::app()->user->setState($this->getStatePrefix() . $attribute, $this->owner->$attribute);
            } else {
                Yii::app()->user->setState($this->getStatePrefix() . $attribute, 1, 1);
            }
        }
    }
    
	private function doSaveSort($key = null)
	{
		Yii::app()->user->setState($this->getStatePrefix() . 'sort', $_GET[$key]);		
	}
	
	private function doReadSort($key = null)
	{
		$val = Yii::app()->user->getState($this->getStatePrefix() . 'sort');
		if(!empty($val))
			$_GET[$key] = $val;
	}
	
	private function doSavePage($key, $value = null)
	{
		Yii::app()->user->setState($this->getStatePrefix() . 'page', $value == null ? $_GET[$key] : $value);
	}
	
	private function doReadPage($key)
	{
		$val = Yii::app()->user->getState($this->getStatePrefix() . 'page');
		if(!empty($val))
			$_GET[$key] = $val;
	}
	
	private function doSaveFilter()
	{
		$this->owner->attributes = $_GET[get_class($this->owner)];
		$this->saveSearchValues();
	}
	
	private function doReadFilter()
	{
		$this->readSearchValues();
	}
	
	public function doSave()
	{
		if ($this->owner->scenario == $this->scenarioName || $this->owner->scenario == $this->rememberScenario ) {
			// store also sorting order
			$key = get_class($this->owner).'_sort';
			$this->doSaveSort($key);
			
			// store active page in page
			$key = get_class($this->owner).'_page';
			if(!empty($_GET[$key]))
				$this->doSavePage($key);
			elseif (!empty($_GET["ajax"]))
				$this->doSavePage($key, 1);
			
			// store filter
			$this->doSaveFilter();
		}
	}
	
    public function doRead()
	{
		if ($this->owner->scenario == $this->scenarioName || $this->owner->scenario == $this->rememberScenario ) {
			// read sorting order
			$key = get_class($this->owner).'_sort';
			$this->doReadSort($key);
			
			// read active page
			$key = get_class($this->owner).'_page';
			$this->doReadPage($key);
			
			// read filter
			$this->doReadFilter();
		}
	}
	
    //private function doReadSave() {
    public function doReadSave() {
      if ($this->owner->scenario == $this->scenarioName || $this->owner->scenario == $this->rememberScenario ) {
        // alexr !!!
		if ($this->clearAttributes) $this->owner->unsetAttributes();
		
        // store also sorting order
        $key = get_class($this->owner).'_sort';
		if(!empty($_GET[$key]))
			$this->doSaveSort($key);
        else 
			$this->doReadSort($key);
        
        // store active page in page
        $key = get_class($this->owner).'_page';
        if(!empty($_GET[$key]))
			$this->doSavePage($key);
        elseif (!empty($_GET["ajax"]))
			$this->doSavePage($key, 1);
        else
			$this->doReadPage($key);
		
		// store filter
        if (isset($_GET[get_class($this->owner)]))
			$this->doSaveFilter();
        else
			$this->doReadFilter();
		
      }
    }
    
    /*
	public function afterConstruct($event) {
        $this->doReadSave();
    }
    */
	
    /**
     * Method is called when we need to unset the filters
     *
     * @return owner
     */
    public function unsetFilters() {
        $modelName = get_class($this->owner);
        $attributes = $this->owner->getSafeAttributeNames();
        foreach ($attributes as $attribute) {
            if (null != ($value = Yii::app()->user->getState($this->getStatePrefix() . $attribute, null))) {
                Yii::app()->user->setState($this->getStatePrefix() . $attribute, 1, 1);
            }
        }
        if ($this->defaultStickOnClear) {
            Yii::app()->user->setState($modelName . __CLASS__. 'defaultsSet', 1, 1);
        }
        return $this->owner;
    }
}
?>