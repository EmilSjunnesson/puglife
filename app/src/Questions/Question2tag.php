<?php
namespace Anax\Questions;
 
/**
 * Model for Questions.
 *
 */
class Question2tag extends \Anax\Database\CDatabaseModel
{
	/**
	 * Save tags
	 *
	 * @return boolean
	 */
	public function saveTags($idQuestion, $tagString)
	{
		$tags = explode(',', $tagString);
		
		foreach ($tags as $tag) {
			$this->db->execute('INSERT INTO puglife_tag (name) VALUES (?) ON DUPLICATE KEY UPDATE name=?', [$tag, $tag]);
			$res = $this->db->executeFetchAll('SELECT id FROM puglife_tag WHERE name = ?', [$tag]);
			$idTag = $res[0]->id;
			$this->db->execute('INSERT INTO puglife_question2tag (idQuestion, idTag) VALUES (?,?)', [$idQuestion, $idTag]);
		}
	}
}