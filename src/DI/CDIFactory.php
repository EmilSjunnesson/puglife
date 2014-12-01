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
	}
}