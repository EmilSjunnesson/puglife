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
	public function logActivity($type, $idType, $idUser, $idQuestion)
	{
		$this->save([
			'type'   	 => $type,
			'idType' 	 => $idType,
			'idUser'     => $idUser,
			'idQuestion' => $idQuestion,
			'timestamp'  => time(),
		]);
	}
	
	
	
	/**
	 * Print activity feed
	 * @param int limit
	 *
	 * @return string html
	 */
	public function printActivityFeed($limit = null, $idUser = null)
	{	
		if (isset($limit) && isset($idUser)) {
			if ((!is_numeric($limit)) || (!is_numeric($limit))) {
				die('parameters no numeric');
			}
			$activties = $this->query()
							  ->where('idUser = ?')
							  ->limit($limit)
							  ->orderBy('timestamp DESC')
							  ->execute([$idUser]);
		} elseif ($limit) {
			if (!is_numeric($limit)) {
				die('limit not numeric');
			}
			$activties = $this->query()
							  ->limit($limit)
							  ->orderBy('timestamp DESC')
							  ->execute([$idUser]);
		} elseif ($idUser) {
			if (!is_numeric($idUser)) {
				die('user id not numeric');
			}
			$activties = $this->query()
							  ->where('idUser = ?')
							  ->orderBy('timestamp DESC')
							  ->execute([$idUser]);
		} else {
			$activties = $this->query()
							  ->orderBy('timestamp DESC')
							  ->execute();
		}
		
		$html = null;
		foreach ($activties as $activty) {
			$user = $this->executeRaw('SELECT name FROM puglife_user WHERE id = ?', [$activty->idUser]);

			$html .= '<div class="activity">';
			$html .= '<a href="' . $this->url->create('users/id/' . $activty->idUser) . '">' . $user[0]->name . '</a>';
			$html .= $this->getTypeText($activty->type, $activty->idType, $activty->idQuestion);
			$html .= ' - ' . $this->time->ago($activty->timestamp);
			$html .= '</div>';
		}
		return $html;
	}
	
	
	
	/**
	 * Get texts depenting on type
	 *
	 * @return string
	 */
	public function getTypeText($type, $idType, $idQuestion)
	{
		$text = null;
		switch ($type) {
			case 'questioncom':
				$text = ' kommenterade en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#questionreply'
				 . '">fråga</a>';
				break;
			case 'answercom':
				$answer = $this->executeRaw('SELECT idAnswer FROM puglife_answercom WHERE id = ?', [$idType]);
				$text = ' kommenterade ett <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#answerreply' . $answer[0]->idAnswer
				 . '">svar</a>';
				break;
			case 'answer':
				$text = ' svarade på en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#answerreply' . $idType
				 . '">fråga</a>';
				break;
			case 'ask':
				$text = ' ställde en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#questionreply'
				 . '">fråga</a>';
				break;
			case 'questionvoteup':
				$text = ' gav en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#questionreply'
				 . '">fråga</a> en positiv röst';
				break;
			case 'questionvotedown':
				$text = ' gav en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#questionreply'
				 . '">fråga</a> en negativ röst';
				break;
			case 'answervoteup':
				$text = ' gav ett <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#answerreply' . $idType
				 . '">svar</a> en positiv röst';
				break;
			case 'answervotedown':
				$text = ' gav ett <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#answerreply' . $idType
				 . '">svar</a> en negativ röst';
				break;
			case 'questioncomvoteup':
				$text = ' gillade en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#questionreply'
				 . '">kommentar</a>';
				break;
			case 'answercomvoteup':
				$answer = $this->executeRaw('SELECT idAnswer FROM puglife_answercom WHERE id = ?', [$idType]);
				$text = ' gillade en <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#answerreply' . $answer[0]->idAnswer
				 . '">kommentar</a>';
				break;
			case 'accepted':
				$text = 's <a href="'
				 . $this->url->create('questions/id/' . $idQuestion) . '#answerreply' . $idType
				 . '">svar</a> accepterades';
				break;
		}
		return $text;
	}
}