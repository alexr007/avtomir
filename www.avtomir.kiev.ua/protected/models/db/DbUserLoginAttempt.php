<?php

class DbUserLoginAttempt extends CActiveRecord
{
	public function tableName()
	{
		return 'user_loginattempts';
	}

	public function rules()
	{
		return [
			['ul_login', 'safe'],
		];
	}

	public function relations()
	{
		return [
			'ulUser' => array(self::BELONGS_TO, 'User', 'ul_userid'),
		];
	}

	public function attributeLabels()
	{
		return array(
			'ul_id' => 'id',
			'ul_login' => 'Login',
			'ul_userid' => 'User ID',
			'ul_performed' => 'Performed date',
			'ul_successful' => 'Is successful',
			'ul_session' => 'Session',
			'ul_ipv4' => 'IPv4',
			'ul_useragent' => 'Useragent',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ul_id',$this->ul_id);
		$criteria->compare('ul_userid',$this->ul_userid);
		$criteria->compare('ul_performed',$this->ul_performed,true);
		$criteria->compare('ul_successful',$this->ul_successful);
		$criteria->compare('ul_session',$this->ul_session,true);
		$criteria->compare('ul_ipv4',$this->ul_ipv4);
		$criteria->compare('ul_useragent',$this->ul_useragent,true);
		$criteria->compare('upper(ul_login)',  mb_strtoupper($this->ul_login),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
    {
        if ($this->isNewRecord) {
            /** @var CHttpRequest */
            $request = Yii::app()->request;
            $this->ul_performed = new DbCurrentTimestamp();
            $this->ul_session = Yii::app()->session->sessionID;
            $this->ul_ipv4 = ip2long($request->userHostAddress);
            $this->ul_useragent = $request->userAgent;
        }
        return parent::beforeSave();
    }
	
    public static function hasTooManyFailedAttempts($username, $count_limit, $time_limit)
    {
        $since = new DateTime();
        $since->sub(new DateInterval("PT{$time_limit}S"));

		$count = (int)self::model()->dbConnection->createCommand()
            ->select('COUNT(*)')
            ->from('user_loginattempts')
            ->where('ul_successful=false AND upper(ul_login) = :username AND ul_performed > :since', 
					[':username'=>mb_strtoupper($username), ':since' => $since->format('Y-m-d H:i:s')])
            ->queryScalar();
			
		return $count > $count_limit;
    }
	
	public function defaultScope() 
	{
		return [
			'order'=>'ul_performed desc',
		];
	}
	
	public function getDate()
	{
		return (new DateFormatted($this->ul_performed, "d.m.Y H:m:s "))->date();
	}
	
	public function getIp()
	{
		return long2ip($this->ul_ipv4);
	}
	
}
