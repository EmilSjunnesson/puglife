<?php
namespace Anax\Comments;
 
/**
 * Model for comments
 *
 */
class Comment extends \Anax\Database\CDatabaseModel
{
	/**
	 * Delete all comments on page .
	 *
	 * @param integer $pageId to delete.
	 *
	 * @return boolean true or false if deleting went okey.
	 */
	public function deleteAll($id)
	{
		$this->db->delete(
				$this->getSource(),
				'page_id = ?'
		);
	
		return $this->db->execute([$id]);
	}
}