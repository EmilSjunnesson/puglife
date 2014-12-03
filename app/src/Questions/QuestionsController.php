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
		$this->questions = new \Anax\Questions\Question();
		$this->questions->setDI($this->di);
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
			$user = $this->users->find($question->idUser);
			$question->nameUser = $user->name;
			$question->scoreUser = $user->score;
			$question->emailUser = $user->email;
			$question->countAnswer = $this->questions->getAnswerCount($question->id);
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