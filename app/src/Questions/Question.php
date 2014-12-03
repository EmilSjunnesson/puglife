<?php
namespace Anax\Questions;
 
/**
 * Model for Questions.
 *
 */
class Question extends \Anax\Database\CDatabaseModel
{
	/**
	 * Returns the number of answers the question has.
	 *
	 * @param int question id
	 *
	 * @return int number of answers
	 */
	public function getAnswerCount($idQuestion) {
		$sql = 'SELECT COUNT(*) AS count FROM puglife_answer WHERE idQuestion = ?';
		$res = $this->questions->executeRaw($sql, [$idQuestion]);
		return $res[0]->count;
	}
}