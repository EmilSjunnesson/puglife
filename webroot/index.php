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
	
	$activities = $app->activities->printActivityFeed(10);
	
    $app->theme->setTitle("Hem");
    $app->views->add('default/home', [
    		'title' => 'Välkommen',
    		'questions' => $questions,
    		'tags' => $tags,
    		'users' => $users,
    		'activities' => $activities,
    ], 'flash');

});

$app->router->add('about', function() use ($app) {
	
	$app->theme->setTitle("Om oss");
	
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
			'http://www.kissies.se/feed'
	]);
	
	$app->theme->setTitle("RSS feed");
    $app->theme->addStylesheet('css/rss.css');
    
    $app->views->add('default/page', [
    	'title' => 'RSS-flöde',		
    	'content' => $feed->printFeed(),
    ]);
	
});

$app->router->handle();
$app->theme->render();
