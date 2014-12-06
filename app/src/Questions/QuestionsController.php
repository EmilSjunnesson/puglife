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
	public function listAction($order = 'timestamp')
	{
		if($order == 'timestamp' || $order == 'rating') {	
// 			$questions = $this->vquestions->query()
// 			->orderby($order)
// 			->execute();
			$sql = 'SELECT q.*
			FROM puglife_vquestion AS q
			LEFT OUTER JOIN puglife_question2tag AS q2t
			ON q.id = q2t.idQuestion
			INNER JOIN puglife_tag AS t
			ON q2t.idTag = t.id 
			GROUP BY q.id';
			// where t.id innan Grup by
			// order by efter group by
			$questions = $this->vquestions->executeRaw($sql);
		} else {
			if($order == 'unanswered') {
				// Hämta unanswered på nåt sätt
			} else {
				die('databaseError');
			}	
		}
		
		// Get the questions user
		foreach ($questions as $question) {
			$question = $this->getUser($question);
			$question->countAnswer = $this->vquestions->getAnswerCount($question->id);
			$question->tags = array_combine(explode(',', $question->idTag), explode(',', $question->tag));
		}
		
		$timeAgo = function ($time) {return $this->ago($time);};
		
		$this->theme->setTitle("Frågor");
		$this->views->add('questions/list', [
				'title' => "Frågor",
				'questions'	=> $questions,
				'timeAgo' => $timeAgo,
		]);
	}
	
	
	
	/**
	 * List question with id.
	 *
	 * @param int $id of question to display
	 *
	 * @return void
	 */
	public function idAction($id = null, $order = 'timestamp')
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
			->execute([$id]);
			
			// Get the comments user
			foreach ($comments as $comment) {
				$comment = $this->getUser($comment);
			}
			
			$answers = $this->answers->query()
			->where('idQuestion = ?')
			->orderby($order)
			->execute([$id]);
			
			// Get the comments user
			foreach ($answers as $answer) {
				$answer = $this->getUser($answer);
				$answercoms = $this->answercoms->query()
									->where('idAnswer = ?')
									->execute([$answer->id]);
				foreach ($answercoms as $answercom) {
					$answercom = $this->getUser($answercom);
				}
				$answer->comments = $answercoms;
			}
			
			$timeAgo = function ($time) {return $this->ago($time);};
			
			$this->theme->setTitle($question->title);
			$this->views->add('questions/view', [
					'question' => $question,
					'comments' => $comments,
					'answers'  => $answers,
					'timeAgo'  => $timeAgo
			]);
		}
	}
	
	
	
	/**
	 * Add comment
	 *
	 * @return void
	 */
	public function commentAction($id)
	{	
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
			// Todo log in activity
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
			// Todo log in activity
			$idQuestion = $this->questions->lastInsertId();
			$this->q2t->saveTags($idQuestion, $this->request->getPost('tags'));
			$this->response->redirect($this->url->create('questions/id/' . $idQuestion));
		} else {
			$this->theme->setTitle("Ställ en fråga");
			$this->views->addString('<output>Frågan misslyckades</output>', 'main');
		}
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
	 * Get time ago from unix-timestap.
	 *
	 * @return string
	 */
	function ago($time)
	{
		$periods = array("sekund", "minut", "timme", "dag", "vecka", "månad", "år", "årtionde");
		$lengths = array("60","60","24","7","4.35","12","10");
	
		$now = time();
	
		$difference     = $now - $time;
		$tense         = "sedan";
	
		if($difference < 10) {
			return "alldeles nyss";
		}
	
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	
		$difference = round($difference);
	
		if($difference != 1) {
			if ($periods[$j] == "timme") {
				$periods[$j] = "timmar";
			} elseif($periods[$j] == "dag") {
				$periods[$j].= "ar";
			} elseif($periods[$j] == "vecka") {
				$periods[$j] = "veckor";
			} elseif($periods[$j] == "år") {
					
			} elseif($periods[$j] == "årtionde") {
				$periods[$j].= "n";
			} else {
				$periods[$j].= "er";
			}
		}
	
		return "för $difference $periods[$j] $tense ";
	}
}