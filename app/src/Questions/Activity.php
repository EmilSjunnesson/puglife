<?php
namespace Anax\Questions;
 
/**
 * Model for Questions.
 *
 */
class Activity extends \Anax\Database\CDatabaseModel
{
	/**
	 * Logs actvity
	 *
	 * @return void
	 */
	public function logActivity($type, $idType, $idUser)
	{
		$this->save([
			'type'   	=> $type,
			'idType' 	=> $idType,
			'idUser'    => $idUser,
			'timestamp' => time(),
		]);
	}
}