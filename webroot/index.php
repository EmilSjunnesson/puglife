<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

require __DIR__.'/config_with_app.php'; 

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->theme->setVariable('title', "Puglife");

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$app->router->add('', function() use ($app) {
	
	$questions = $app->questions->query()
					  ->limit(5)
					  ->orderBy('timestamp DESC')
					  ->execute();
	// Get the questions user
	foreach ($questions as $question) {
		$question = $app->QuestionsController->getUser($question);
		$question->countAnswer = $app->questions->getAnswerCount($question->id);
		$question->tags = array_combine(explode(',', $question->idTag), explode(',', $question->tag));
	}
	
	$sql = 'SELECT puglife_tag.*, 
				COUNT(puglife_question2tag.idQuestion) AS count 
				FROM puglife_tag JOIN puglife_question2tag 
				ON puglife_tag.id = puglife_question2tag.idTag 
				GROUP BY puglife_tag.id
				ORDER BY count DESC
				LIMIT 20';
	$tags = $app->questions->executeRaw($sql);
	
	$users = $app->users->query()
						->limit(5)
						->orderBy('score DESC')
						->execute();
	
	$activities = $app->activities->printActivityFeed(5, null, true);
	
    $app->theme->setTitle("Hem");
    $app->views->add('questions/tags', [
    		'tags'  => $tags,
    		'title' => 'Populäraste taggarna',
    ], 'main');
    $app->views->addString('<p>&nbsp;</p>', 'main');
    $app->views->add('questions/list', [
				'title' => 'Senaste frågorna',
				'questions'	=> $questions,
		], 'main');
    $app->views->add('default/sidebar-home', [
    		'users' => $users,
    		'activities' => $activities,
    ], 'sidebar');

});

$app->router->add('about', function() use ($app) {
	
	$app->theme->setTitle("Om oss");
	$app->views->add('default/article', [
			'content' => $app->fileContent->get('info.html'),
	], 'main');
	$app->views->add('default/article', [
			'content' => $app->fileContent->get('stars-info.html'),
	], 'sidebar');
});

$app->router->add('source', function() use ($app) {
                
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]); 
    
});

$app->router->add('setup', function() use ($app) {
	
	//$app->db->setVerbose();
	
	$app->db->dropTableIfExists('user')->execute();
	
	$app->db->createTable(
		'user',
		[
			'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
			'acronym' => ['varchar(20)', 'unique', 'not null'],
			'email' => ['varchar(80)'],
			'name' => ['varchar(80)'],
			'score' => ['int(11)', 'not null', 'default 0'],
			'password' => ['varchar(255)'],
			'created' => ['datetime'],
			'updated' => ['datetime'],
			'deleted' => ['datetime'],
			'active' => ['datetime'],
		]
	)->execute();
		
	$app->db->insert(
		'user',
		['acronym', 'email', 'name', 'password', 'created', 'active']
	);
		
	$now = date('Y-m-d H:i:s');
		
	$app->db->execute([
		'admin',
		'admin@dbwebb.se',
		'Administrator',
		md5('admin'),
		$now,
		$now
	]);
		
	$app->db->execute([
		'doe',
		'doe@dbwebb.se',
		'John/Jane Doe',
		md5('doe'),
		$now,
		$now
	]);
	
	$url = $app->url->create('users');
	$app->response->redirect($url);
	
});

$app->router->add('rss', function() use ($app) {

	$feed = new \Emsf14\library\CRSS([
			'http://hellyeahpugs.tumblr.com/rss'
	]);
	
	$app->theme->setTitle("I Love Pugs");
    $app->theme->addStylesheet('css/rss.css');
    
    $app->views->add('default/page', [
    	'title' => 'I <i class="fa fa-heart"></i> PUGS',		
    	'content' => 'Detta RSS-flöde finns här för att påminna oss om varför vi älska våra hundar så otroligt mycket.' . $feed->printFeed(),
    ], 'flash');
	
});

$app->router->handle();
$app->theme->render();