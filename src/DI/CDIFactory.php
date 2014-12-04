<?php

namespace Anax\DI;

class CDIFactory extends CDIFactoryDefault
{
	public function __construct()
	{
		parent::__construct();

		$this->setShared('form', '\Mos\HTMLForm\CForm');
		
		$this->setShared('db', function() {
			$db = new \Mos\Database\CDatabaseBasic();
			$db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
			$db->connect();
			return $db;
		});
		
		$this->setShared('users', function() {
			$users = new \Anax\Users\User();
			$users->setDI($this);
			return $users;
		});
		
		$this->setShared('questions', function() {
			$users = new \Anax\Questions\Vquestion();
			$users->setDI($this);
			return $users;
		});
	}
}