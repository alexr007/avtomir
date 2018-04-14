<?php
class UsersCompany extends User
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function search($id)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('u_id',$this->u_id);
		$criteria->compare('u_login',$this->u_login,true);
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->compare('u_firstname',$this->u_firstname,true);
		$criteria->compare('u_lastname',$this->u_lastname,true);
		
		$criteria->join = 	'JOIN user_profile ON (up_user=u_id)'.
							'JOIN user_profile_fields ON upf_id=up_field';
							
		$criteria->compare('upf_name','company');
//		$criteria->compare('up_value',(string)$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}