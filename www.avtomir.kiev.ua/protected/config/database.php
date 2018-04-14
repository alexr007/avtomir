<?php

return [
    'class'=>'CDbConnection',
	'connectionString'=>require(dirname(__FILE__).'/access/db_name.php'),
	'username' => require(dirname(__FILE__).'/access/db_login.php'),
	'password' => require(dirname(__FILE__).'/access/db_password.php'),
];