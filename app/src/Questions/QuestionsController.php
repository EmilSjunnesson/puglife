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
}