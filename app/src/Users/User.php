<?php
namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\Database\CDatabaseModel
{

	/**
	 * Find and return specific.
	 *
	 * @return this
	 */
	public function findLogin($acronym, $password)
	{
		$this->db->select()
		->from($this->getSource())
		->where("acronym = ?")
		->andWhere('password = ?');
		$this->db->execute([$acronym, md5($password)]);
		return $this->db->fetchInto($this);
	}
	
	
	
	/**
	 * Is there a user logged in.
	 *
	 * @return boolean
	 */
	public function isLoggedIn()
	{
		$val = $this->session->get('userId', -1);
		if ($val > 0) {
			return true;
		} else {
			return false;
		}
	}
}