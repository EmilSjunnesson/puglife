<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

require __DIR__.'/config_with_app.php'; 

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

$app->theme->setVariable('title', "Min me-sida i PHPMVC");

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$comments = new \Emsf14\Comments\CComments($app);
 
$app->router->add('', function() use ($app, $comments) {
                
    $app->theme->setTitle("Hem");
 
    $content = $app->fileContent->get('home.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
    
    // adds comments at the bottom of the page
    $id = md5($app->request->getCurrentUrlWithoutQuery());
    $comments->displayComments($id);

});
 
$app->router->add('redovisning', function() use ($app) {
                
    $app->theme->setTitle("Redovisning");
 
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
 
});

$app->router->add('dicegame', function() use ($app, $comments) {
                
    $app->theme->setTitle("Tärningspelet 100");
    $app->theme->addStylesheet('css/dice_game.css');
 
    $game = new \Emsf14\Dicegame\CDiceDisplay($_GET, $app->session);
    $content = $game->PrintHTML();
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
    
    // adds comments at the bottom of the page
    $id = md5($app->request->getCurrentUrlWithoutQuery());
    $comments->displayComments($id);

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
		password_hash('admin', PASSWORD_DEFAULT),
		$now,
		$now
	]);
		
	$app->db->execute([
		'doe',
		'doe@dbwebb.se',
		'John/Jane Doe',
		password_hash('doe', PASSWORD_DEFAULT),
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
