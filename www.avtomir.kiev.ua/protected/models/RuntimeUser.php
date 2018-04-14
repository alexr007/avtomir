<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RuntimeUser
 *
 * @author alexr
 */
class RuntimeUser implements IRuntimeUser, IRuntimeUserRole, IRuntimeCagent {
    private $_id;
    private $_name;
    private $_isGuest;
    
    const R_SCRUM = 'scrum';
    const R_ADMIN = 'admin';
    const R_OPERATOR = 'operator';
    const R_CLIENT = 'client';
    
    public function __construct()
    {
        $this->_isGuest = Yii::app()->user->isGuest;
        $this->_id = Yii::app()->user->id;
        $this->_name = Yii::app()->user->name;
    }
    
    public function isGuest()
    {
        return $this->_isGuest;
    }
    
    public function id()
    {
        return $this->isGuest() ? 0 : $this->_id;
    }
    
    public function name()
    {
        return $this->_name;
    }
	
    // super user
	public function isScrum ()
    {
        return Yii::app()->user->checkAccess(self::R_SCRUM);
    }
    
    public function isAdmin ()
    {
        return Yii::app()->user->checkAccess(self::R_ADMIN);
    }
    
    public function isOperator ()
    {
        return Yii::app()->user->checkAccess(self::R_OPERATOR);
    }
    
    public function isClient ()
    {
        return Yii::app()->user->checkAccess(self::R_CLIENT);
    }
	
    public function cagentId ()
	{
		if ($this->isGuest())
			throw new RuntimeUserException('Guest cant convert cart to order. Please register');
		
		$ar = DbCagent::model()->findByAttributes(['ca_userid'=>$this->id()]);
		if (!$ar)
			throw new RuntimeUserException('Agent not assigned. Contact administrator');
		
		return $ar->getId();
	}
    
}
