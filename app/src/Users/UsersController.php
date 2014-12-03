<?php
namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;
	
	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->di->session();
		$this->users = new \Anax\Users\User();
		$this->users->setDI($this->di);
	}
	
	/**
	 * First page with links to functions.
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$this->session->remove('form-save');
		$all = $this->users->findAll();
		
		$this->theme->setTitle("Hantera användare");
		$this->views->add('users/index');
		$this->views->add('users/list-all', [
				'users' => $all,
				'title' => null,
				'status' => true
		]);
	}
	
	/**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAction()
	{	
		$this->session->remove('form-save');
		$all = $this->users->findAll();

		$this->theme->setTitle("Alla användare");
		$this->views->add('users/list-all', [
				'users' => $all,
				'title' => "Alla användare",
				'status' => true
		]);
	}
	
	
	
	/**
	 * List user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
		$self = false;
		$this->session->remove('form-save');
		if (!isset($id)) {
			if ($this->users->isLoggedIn()) {
				$id = $this->session->get('userId');
			}
			$self = true;
		}
		
		$user = $this->users->find($id);
		
		if (empty($user)) {
			if ($self) {
				$this->response->redirect($this->url->create('users/login'));
			} else {
				$this->theme->setTitle("Visa användare");
				$this->views->addString('<output>Användaren du söker finns ej</output>', 'main');
			}
		} else {
			$this->theme->setTitle("Visa användare");
			$this->views->add('users/view', [
				'user' => $user,
				'title' => $user->name
			]);
		}
	}

	
	
	/**
	 * Add new user.
	 *
	 * @return void
	 */
	public function addAction()
	{
		$this->form();
	}
	
	
	
	/**
     * Callback for submit-button.
     * Adds new user
     *
     */
    public function addUser($form)
    {
        $now = date('Y-m-d H:i:s');
	
		$this->users->save([
				'acronym' => $form->Value('acronym'),
				'email' => $form->Value('email'),
				'name' => $form->Value('name'),
				'password' => password_hash($form->Value('password'), PASSWORD_DEFAULT),
				'created' => $now,
				'active' => $now,
		]);
		
        $form->saveInSession = true;
        return true;
    }
	
	
    /**
     * Update user.
     *
     * @param integer $id of user to uppdate.
     *
     * @return void
     */
    public function updateAction($id = null)
    {
    	if (!isset($id)) {
    		die("Missing id");
    	}
    	$this->form($id);
    }
    
	/**
	 * Update user.
	 *
	 * @param integer $id of user to uppdate.
	 *
	 * @return void
	 */
	public function updateUser($form)
	{
		// Hämta fron post i stället för acronym /kolla i kommentars koden
		$now = date('Y-m-d H:i:s');
		
		$user = $this->users->find($form->Value('id'));
	
		$user->save([
				'acronym' => $form->Value('acronym'),
				'email' => $form->Value('email'),
				'name' => $form->Value('name'),
				'updated' => $now,
		]);
		
		$form->saveInSession = true;
        return true;
	}
	
	
	
	/**
	 * Form to add/update user.
	 *
	 *
	 * @return void
	 */
	public function form($id = null)
	{
		
		$user = isset($id) ? $this->users->find($id) : null;
		
		$form = $this->di->form->create([], [
				'id' => [
						'type'        => 'hidden',
						'value'		  => isset($id) ? $id : null,
				],
				'acronym' => [
						'type'        => 'text',
						'required'    => true,
						'validation'  => ['not_empty'],
						'value'		  => isset($id) ? $user->acronym : null,
				],
				'email' => [
						'type'        => 'text',
						'required'    => true,
						'validation'  => ['not_empty', 'email_adress'],
						'value'		  => isset($id) ? $user->email : null,
				],
				'name' => [
						'type'        => 'text',
						'label'		  => 'Namn',
						'required'    => true,
						'validation'  => ['not_empty'],
						'value'		  => isset($id) ? $user->name : null,
				],
				'password' => [
						'type'        => isset($id) ? 'hidden' : 'password',
						'label'		  => 'Lösenord',
						'required'    => isset($id) ? false : true,
						'validation'  => isset($id)? null : ['not_empty'],
				],
				'spara' => [
						'type'      => 'submit',
						'callback'  => [$this, isset($id) ? 'updateUser' : 'addUser'],
				],
		]);
		
		$form->AddOutput("<p><a href='" . (isset($id) ? "../id/$id" : "../users") . "'>Avbryt</a></p>");
		
		// Check the status of the form
		$status = $form->check();
		$duplicate = false;
		if (array_key_exists('id', $this->users->getProperties())) {
			if ($this->users->id == 0) {
				$status = false;
				$duplicate = true;
			}
		}
		
		// What to do if the form was submitted?
		if($status === true) {
			$this->response->redirect($this->url->create('users/id/' . $this->users->id));
		}
	
		
		// What to do when form could not be processed?
		else if($status === false){
			$form->AddOutput("<p><i>" . (isset($id) ? "Användaren kunde inte uppdateras" : "En ny användare kunde inte skapas.") . "</i></p>");
			if ($duplicate === true) {
				$form->AddOutput("<p><i>Acronymen används redan av en annan användare.</i></p>");
			}
			$this->response->redirect($this->request->getCurrentUrl());
		}
	
		$this->di->theme->setTitle("Lägg till");
		$this->di->views->add('default/page', [
				'title' => isset($id) ? "Uppdatera användare" : "Lägg till en ny användare",
				'content' => $form->getHTML()
		]);
	}
	
	
	
	/**
	 * Delete user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	
		$res = $this->users->delete($id);
	
		$url = $this->url->create('users');
		$this->response->redirect($url);
	}
	
	
	
	/**
	 * Delete (soft) user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function softDeleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	
		$now = date('Y-m-d H:i:s');
	
		$user = $this->users->find($id);
	
		$user->deleted = $now;
		$user->save();
	
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	
	/**
	 * Undo delete (soft) user.
	 *
	 * @param integer $id of user to undo delete.
	 *
	 * @return void
	 */
	public function undoSoftDeleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	
		$user = $this->users->find($id);
	
		$user->deleted = null;
		$user->save();
	
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	
	/**
	 * Activate user.
	 *
	 * @param integer $id of user to activate.
	 *
	 * @return void
	 */
	public function activateAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
		
		$now = date('Y-m-d H:i:s');
	
		$user = $this->users->find($id);
	
		$user->active = $now;
		$user->save();
	
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	
	/**
	 * Deactivate user.
	 *
	 * @param integer $id of user to deactivate.
	 *
	 * @return void
	 */
	public function deactivateAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	
		$user = $this->users->find($id);
	
		$user->active = null;
		$user->save();
	
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	
	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function activeAction()
	{
		$this->session->remove('form-save');
		
		$all = $this->users->query()
		->where('active IS NOT NULL')
		->andWhere('deleted is NULL')
		->execute();
	
		$this->theme->setTitle("Aktiva användare");
		$this->views->add('users/list-all', [
				'users' => $all,
				'title' => "Aktiva användare",
		]);
	}
	
	
	
	/**
	 * List all inactive users.
	 *
	 * @return void
	 */
	public function inactiveAction()
	{
		$this->session->remove('form-save');
		
		$all = $this->users->query()
		->where('active is NULL')
		->andWhere('deleted is NULL')
		->execute();
	
		$this->theme->setTitle("Inaktiva användare");
		$this->views->add('users/list-all', [
				'users' => $all,
				'title' => "Inaktiva användare",
		]);
	}
	
	
	
	/**
	 * List all solf-deleted users. (In the bin)
	 *
	 * @return void
	 */
	public function binAction()
	{
		$this->session->remove('form-save');
		
		$all = $this->users->query()
		->where('deleted IS NOT NULL')
		->execute();
	
		$this->theme->setTitle("Borttagna användare");
		$this->views->add('users/list-all', [
				'users' => $all,
				'title' => "Borttagna användare",
		]);
	}
	
	
	
	/**
	 * Login form
	 *
	 * @return void
	 */
	public function loginAction($output = null)
	{
		$this->theme->setTitle("Logga in");
		$this->views->addString('<h1>Logga in</h1>', 'flash');
		$this->views->add('users/login', [
				'output' => $output,
		],
		'main');
		$info = "Inte medlem än?<br>Klicka <a href='register'>här</a> för att registrera dig.";
		$this->views->addString($info, 'sidebar');
	}
	
	
	
	/**
	 * Login user
	 *
	 * @return void
	 */
	public function loginUserAction() {
		
		$isPosted = $this->request->getPost('doLogin');
		
		if (!$isPosted) {
			$this->response->redirect($this->request->getLastUrl());
		}
		
		$user = $this->users->findLogin($this->request->getPost('acronym'), $this->request->getPost('password'));
		if(isset($user->id)) {
			$this->session->set('userId', $user->id);
			$this->response->redirect($this->url->create('users/id'));
		} else {
			$this->response->redirect($this->url->create('users/login/denied'));
		}
	}
	
	
	
	/**
	 * Logout user
	 *
	 * @return void
	 */
	public function logoutAction() {
		$this->session->remove('userId');
		$this->response->redirect($this->url->create(''));
	}
	
	
	
	/**
	 * Register form
	 *
	 * @return void
	 */
	public function registerAction($output = null)
	{
		$this->theme->setTitle("Registrera dig");
		$this->views->addString('<h1>Registrera dig</h1>', 'flash');
		$this->views->add('users/register', [
				'output' => $output,
		],
				'main');
		$info = "<h3>Villkor</h3>Medlem ansluter sig till Tjänsten genom att acceptera Villkoren och registrera 
				ett Pug life konto enligt Pug life vid var tid gällande rutiner och villkor. Förutom vad som 
				anges i dessa Villkor kan ytterligare villkor och bestämmelser komma att gälla för Tjänsten. 
				Medlemmen förbinder sig att uppmärksamma samt iaktta sådana villkor och bestämmelser vid 
				nyttjande av Tjänsten samt hålla sig uppdaterad om och iaktta förändringar i dessa. Brott mot 
				särskilda villkor och bestämmelser för Tjänsten skall även anses utgöra brott mot dessa Villkor. 
				Pug life tillåter inte betalningar beträffande olaglig verksamhet eller verksamhet som strider 
				mot Pug life från var tid gällande policy.";
		$this->views->addString($info, 'sidebar');
	}
	
	
	
	/**
	 * Register user
	 *
	 * @return void
	 */
	public function registerUserAction() {
	
		$isPosted = $this->request->getPost('doRegister');
	
		if (!$isPosted) {
			$this->response->redirect($this->request->getLastUrl());
		}
		
		$acronym = $this->request->getPost('acronym');
		$name = $this->request->getPost('name');
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$confirm = $this->request->getPost('confirm_password');
		
		if ($password !== $confirm) {
			$this->response->redirect($this->url->create('users/register/password'));
		}
		
		$users = $this->users->query('acronym')
		->execute();
		$acronyms = null;
		foreach($users AS $user) {
			$acronyms[] = $user->acronym;
		}
		
		if(in_array($acronym, $acronyms)) {
			$this->response->redirect($this->url->create('users/register/acronym'));
		}
		
		$now = date('Y-m-d H:i:s');
		
		if($this->users->save([
				'acronym' => $acronym,
				'email' => $email,
				'name' => $name,
				'password' => md5($password),
				'created' => $now,
				'active' => $now,
		])) {
			$this->response->redirect($this->url->create('users/login/registerd'));
		} else {
			$this->response->redirect($this->url->create('users/register/denied'));
		}
	}
}