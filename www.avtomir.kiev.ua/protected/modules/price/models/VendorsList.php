<?php

/**
 * This is the model class for table "vendors".
 *
 * The followings are the available columns in table 'vendors':
 * @property integer $ve_id
 * @property string $ve_name
 * @property integer $ve_sort
 * @property integer $ve_show
 */
class VendorsList extends Vendors
{
	public function defaultScope() {
		
		return [
			'order'=>'ve_sort asc',
			'condition'=>"ve_show = 1",
//			'limit' => 10,
		];
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
