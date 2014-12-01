<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php';

$app->session();

// Test form route
$app->router->add('test1', function () use ($app) {

	$app->dispatcher->forward([
			'controller' => 'form',
	]);
	
});

$app->router->handle();
$app->theme->render();