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
		$this->questions = new \Anax\Questions\Vquestion();
		$this->questions->setDI($this->di);
		
		$this->questioncoms = new \Anax\Comments\Questioncom();
		$this->questioncoms->setDI($this->di);
		
		$this->answers = new \Anax\Questions\Answer();
		$this->answers->setDI($this->di);
		
		$this->answercoms = new \Anax\Comments\Answercom();
		$this->answercoms->setDI($this->di);
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
			$questions = $this->questions->query()
			->orderby($order)
			->execute();
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
			$question->countAnswer = $this->questions->getAnswerCount($question->id);
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
	public function idAction($id = null)
	{
		if (!isset($id)) {
			$this->views->addString('<output>Frågan du söker finns ej</output>', 'main');
		}
	
		$question = $this->questions->find($id);
	
		if (empty($question)) {
			$this->views->addString('<output>Frågan du söker finns ej</output>', 'main');
		} else {
			$question = $this->getUser($question);
			$question->countAnswer = $this->questions->getAnswerCount($question->id);
			$question->tags = array_combine(explode(',', $question->idTag), explode(',', $question->tag));
			
			$comments = $this->questioncoms->query()
			->where('idQuestion = ?')
			->execute([$id]);
			
			// Get the comments user
			foreach ($comments as $comment) {
				$comment = $this->getUser($comment);
			}
			
			$order = 'timestamp';
			
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
			
			$this->theme->setTitle("Visa användare");
			$this->views->add('questions/view', [
					'question' => $question,
					'comments' => $comments,
					'answers'  => $answers,
					'timeAgo'  => $timeAgo
			]);
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