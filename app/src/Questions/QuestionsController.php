<?php
namespace Anax\Questions;

/**
 * A controller for questions.
 *
 */
class QuestionsController implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;
	
	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->vquestions = new \Anax\Questions\Vquestion();
		$this->vquestions->setDI($this->di);
		
		$this->questions = new \Anax\Questions\Question();
		$this->questions->setDI($this->di);
		
		$this->questioncoms = new \Anax\Comments\Questioncom();
		$this->questioncoms->setDI($this->di);
		
		$this->answers = new \Anax\Questions\Answer();
		$this->answers->setDI($this->di);
		
		$this->answercoms = new \Anax\Comments\Answercom();
		$this->answercoms->setDI($this->di);
		
		$this->q2t = new \Anax\Questions\Question2tag();
		$this->q2t->setDI($this->di);
		
		$this->tags = new \Anax\Questions\Tag();
		$this->tags->setDI($this->di);
		
		$this->activities = new \Anax\Questions\Activity();
		$this->activities->setDI($this->di);
	}
	
	
	
	/**
	 * First page with links to functions.
	 *
	 * @return void
	 */
	public function indexAction()
	{

	}
	
	
	
	/**
	 * List all questions.
	 *
	 * @return void
	 */
	public function listAction($where = null, $id = null)
	{
		$order = 'timestamp';
		$title = 'Frågor';
		$tag = null;
		if ($this->request->getGet('rating', 0)) {
			$order = 'rating';
		}
		
		if (isset($where)) {
			if (!isset($id)) {
				die('Missing id');
			}
			$sql = 'SELECT q.*
 			FROM puglife_vquestion AS q
 			LEFT OUTER JOIN puglife_question2tag AS q2t
 			ON q.id = q2t.idQuestion
 			INNER JOIN puglife_tag AS t
 			ON q2t.idTag = t.id
			WHERE t.id = ' . $id
 			. ' GROUP BY q.id
 			ORDER BY q.' . $order . ' DESC, timestamp DESC';
 			$questions = $this->vquestions->executeRaw($sql);
 			$tag = $this->tags->find($id);
 			$tag = $tag->name;
 			$title .= ' | ' . $tag;
		} else {
			$questions = $this->vquestions->query()
						->orderby($order . ' DESC, timestamp DESC')
						->execute();
		}

		// Get the questions user
		foreach ($questions as $question) {
			$question = $this->getUser($question);
			$question->countAnswer = $this->vquestions->getAnswerCount($question->id);
			$question->tags = array_combine(explode(',', $question->idTag), explode(',', $question->tag));
		}
		
		$this->theme->setTitle($title);
		$this->views->add('questions/list', [
				'title' => $title,
				'questions'	=> $questions,
		]);
		$this->views->add('questions/sidebar', [
				'tag' => $tag,
				'order'	=> $order,
				'type' => 'list',
		], 'sidebar');
	}
	
	
	
	/**
	 * List all tags.
	 *
	 * @return void
	 */
	public function tagsAction()
	{
		$order = 'name COLLATE utf8_swedish_ci';
		if ($this->request->getGet('count', 0)) {
			$order = 'count DESC';
		}
		
		$sql = 'SELECT puglife_tag.*, 
				COUNT(puglife_question2tag.idQuestion) AS count 
				FROM puglife_tag JOIN puglife_question2tag 
				ON puglife_tag.id = puglife_question2tag.idTag 
				GROUP BY puglife_tag.id 
				ORDER BY ' . $order;
		$tags = $this->tags->executeRaw($sql);
		
		$this->theme->setTitle("Taggar");
		$this->views->add('questions/tags', [
				'tags'  => $tags,
				'order' => $order,
				'title' => 'Taggar',
		], 'flash');
	}
	/**
	 * List question with id.
	 *
	 * @param int $id of question to display
	 *
	 * @return void
	 */
	public function idAction($id = null, $popup = null)
	{
		if (!isset($id)) {
			$this->views->addString('<output>Frågan du söker finns ej</output>', 'main');
		}
	
		$question = $this->vquestions->find($id);
	
		if (empty($question)) {
			$this->views->addString('<output>Frågan du söker finns ej</output>', 'main');
		} else {
			$question = $this->getUser($question);
			$question->countAnswer = $this->vquestions->getAnswerCount($question->id);
			$question->tags = array_combine(explode(',', $question->idTag), explode(',', $question->tag));
			
			$comments = $this->questioncoms->query()
			->where('idQuestion = ?')
			->orderBy('timestamp')
			->execute([$id]);
			
			// Get the comments user
			foreach ($comments as $comment) {
				$comment = $this->getUser($comment);
			}
			
			$order = 'timestamp';
			if ($this->request->getGet('rating', 0)) {
				$order = 'rating';
			}
			
			$answers = $this->answers->query()
			->where('idQuestion = ?')
			->orderby('accepted DESC, ' . $order . ' DESC, timestamp DESC')
			->execute([$id]);
			
			$question->hasAcceptedAnswer = $this->getHasAcceptedAnswer($answers);
			
			// Get the comments user
			foreach ($answers as $answer) {
				$answer = $this->getUser($answer);
				$answercoms = $this->answercoms->query()
									->where('idAnswer = ?')
									->orderBy('timestamp')
									->execute([$answer->id]);
				foreach ($answercoms as $answercom) {
					$answercom = $this->getUser($answercom);
				}
				$answer->comments = $answercoms;
			}
			
			$this->theme->setTitle($question->title);
			$this->views->add('questions/view', [
					'question' => $question,
					'comments' => $comments,
					'answers'  => $answers,
					'popup'    => $popup,
					'loggedIn' => $this->users->isLoggedIn(),
			]);
			$this->views->add('questions/sidebar', [
					'type' => 'view',
			], 'sidebar');
		}
	}
	
	
	
	/**
	 * Add comment
	 *
	 * @return void
	 */
	public function commentAction($id)
	{	
		$activityIdQuestion = $id;
		if (!isset($id)) {
			$this->theme->setTitle("Kommentera");
			$this->views->addString('<output>Kommentaren misslyckades</output>', 'main');
		}
		
		$isPosted = $this->request->getPost('doComment');
	
		if (!$isPosted || !$this->users->isLoggedIn()) {
			$this->response->redirect($this->url->create('questions/list'));
		}
		
		$model = null;
		$idType = null;
		if ($this->request->getPost('type') == 'question') {
			$model = $this->questioncoms;
			$idType = 'idQuestion';
		} elseif ($this->request->getPost('type') == 'answer') {
			$model = $this->answercoms;
			$idType = 'idAnswer';
			$answer = $this->answers->find($id);
			$activityIdQuestion = $answer->idQuestion;
		}
		
		if(empty($model) || empty($idType)) {
			$this->theme->setTitle("Kommentera");
			$this->views->addString('<output>Kommentaren misslyckades</output>', 'main');
		}
		
		if($model->save([
				'content' => $this->request->getPost('content'),
				'timestamp' => time(),
				'idUser' => $this->session->get('userId'),
				$idType => $id,
		])) {
			$this->activities->logActivity($this->request->getPost('type') . 'com' , $model->lastInsertId(), $this->session->get('userId'), $activityIdQuestion);
			$this->addUserScore(1, $this->session->get('userId'));
			$this->response->redirect($this->request->getPost('redirect'));
		} else {
			$this->theme->setTitle("Kommentera");
			$this->views->addString('<output>Kommentaren misslyckades</output>', 'main');
		}
	}
	
	
	
	/**
	 * Add answer
	 *
	 * @return void
	 */
	public function answerAction($id)
	{
	
		if (!isset($id)) {
			$this->theme->setTitle("Svara");
			$this->views->addString('<output>Svaret misslyckades</output>', 'main');
		}
	
		$isPosted = $this->request->getPost('doAnswer');
	
		if (!$isPosted || !$this->users->isLoggedIn()) {
			$this->response->redirect($this->url->create('questions/list'));
		}
	
		if($this->answers->save([
				'content' => $this->request->getPost('content'),
				'timestamp' => time(),
				'idUser' => $this->session->get('userId'),
				'idQuestion' => $id,
		])) {
			// Todo log in activity
			$this->activities->logActivity('answer' , $this->answers->lastInsertId(), $this->session->get('userId'), $id);
			$this->addUserScore(5, $this->session->get('userId'));
			$this->response->redirect($this->request->getPost('redirect'));
		} else {
			$this->theme->setTitle("Svara");
			$this->views->addString('<output>Svaret misslyckades</output>', 'main');
		}
	}
	
	
	/**
	 * Ask-form
	 *
	 * @return void
	 */
	public function askAction()
	{
		if ($this->users->isLoggedIn()) {
			$this->theme->addJavaScript('js/bootstrap-tagsinput.js');
			$this->theme->setTitle("Ställ en fråga");
			$this->views->add('questions/ask');
		} else {
			$this->response->redirect($this->url->create('users/login/locked'));
		}
	}
	
	
	
	/**
	 * Save question
	 *
	 * @return void
	 */
	public function askedAction()
	{
		$isPosted = $this->request->getPost('doAsk');
	
		if (!$isPosted || !$this->users->isLoggedIn()) {
			$this->response->redirect($this->url->create('questions/list'));
		}
	
		if($this->questions->save([
				'title'		=> $this->request->getPost('title'),
				'content'   => $this->request->getPost('content'),
				'timestamp' => time(),
				'idUser'    => $this->session->get('userId'),
		])) {
			$idQuestion = $this->questions->lastInsertId();
			// Todo log in activity
			$this->activities->logActivity('ask' , $this->questions->lastInsertId(), $this->session->get('userId'), $idQuestion);
			$this->addUserScore(1, $this->session->get('userId'));
			$this->q2t->saveTags($idQuestion, $this->request->getPost('tags'));
			$this->response->redirect($this->url->create('questions/id/' . $idQuestion));
		} else {
			$this->theme->setTitle("Ställ en fråga");
			$this->views->addString('<output>Frågan misslyckades</output>', 'main');
		}
	}
	
	
	/**
	 * Vote on comment, answer or question
	 *
	 * @return void
	 */
	public function voteAction($type, $id, $direction)
	{
		$lastUrl = $this->request->getLastUrl();
		
		if($type == 'answercom') {
			$idParent = $this->answercoms->find($id);
			$hash = 'answerreply' . $idParent->idAnswer;
			$answer = $this->answers->find($idParent->idAnswer);
			$idQuestion = $answer->idQuestion;
		} elseif ($type == 'questioncom') {
			$idParent = $this->questioncoms->find($id);
			$hash = 'questionreply' . $idParent->idQuestion;
			$idQuestion = $idParent->idQuestion;
		} else {
			$hash = $type . 'reply' . $id;
			$idQuestion = $id;
			if($type == 'answer') {
				$answer = $this->answers->find($id);
				$idQuestion = $answer->idQuestion;
			}
		}
		
		$res = $this->activities->query()
			  	                ->where('type = ?')
			        			->andWhere('idType = ?')
			        			->andWhere('idUser = ?')
			        			->execute([$type . 'vote' . $direction, $id, $this->session->get('userId')]);
		if (empty($res)) {
			
			$this->activities->logActivity($type . 'vote' . $direction, $id, $this->session->get('userId'), $idQuestion);
			$this->addUserScore(1, $this->session->get('userId'));
			$model = $type . 's';
			$element = $this->$model->find($id);
			if ($direction === 'up') {
				$element->save([
				'rating' => $element->rating + 1,
				]);
				$this->addUserScore(1, $element->idUser);
			} elseif ($direction === 'down') {
				$element->save([
				'rating' => $element->rating - 1,
				]);
				$this->addUserScore(-1, $element->idUser);
			}
		} else {
			$lastUrl = $this->request->getLastUrlWithoutQuery() . '/denied';
			if (!empty(parse_url($this->request->getLastUrl(), PHP_URL_QUERY))) {
				$lastUrl = $lastUrl . '?' . parse_url($this->request->getLastUrl(), PHP_URL_QUERY);
			}
		}
		$this->response->redirect($lastUrl . '#' . $hash);
	}
	
	
	/**
	 * Mark answer as accepted
	 *
	 * @return void
	 */
	public function acceptAction($id)
	{
		$answer = $this->answers->find($id);
		$answer->save([
			'accepted' => 1,	
		]);
		$this->addUserScore(1, $this->session->get('userId'));
		$this->addUserScore(10, $answer->idUser);
		$this->activities->logActivity('accepted' , $answer->id, $answer->idUser, $answer->idQuestion);
		$this->response->redirect($this->request->getLastUrl() . '#answerreply' . $answer->id);
	}
	
	/**
	 * Add score on user activity
	 *
	 * @return void
	 */
	public function addUserScore($points, $idUser)
	{
		$user = $this->users->find($idUser);

		if($points === -1) {
			$points = abs($points);
			$score = $user->score - $points;
		} else {
			$score = $user->score + $points;
		}
		$this->db->execute('UPDATE puglife_user SET score = ? WHERE id = ?', [$score, $idUser]);
	}
	
	
	
	/**
	 * Get the database models user
	 *
	 * @return model
	 */
	function getUser($model)
	{
		$user = $this->users->find($model->idUser);
		$model->nameUser = $user->name;
		$model->scoreUser = $user->score;
		$model->emailUser = $user->email;
		return $model;
	}
	
	
	
	/**
	 * Check if question as accepted answer
	 *
	 * @return boolean
	 */
	function getHasAcceptedAnswer(array $answers)
	{
		$res = array();
		foreach ($answers as $answer) {
			$res[] = $answer->accepted;
		}
		return in_array(true, $res);
	}
}