<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

require __DIR__.'/config_with_app.php'; 

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->theme->setVariable('title', "Min me-sida i PHPMVC");

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

 
$app->router->add('', function() use ($app) {

	$app->theme->addStylesheet('css/awsome_demo.css');
    $app->theme->setTitle("Font Awesome");
    
    $main = '<h1>Font Awesome</h1>
    	<i class="fa fa-spinner fa-spin"></i>
		<i class="fa fa-circle-o-notch fa-spin"></i>
		<i class="fa fa-refresh fa-spin"></i>
		<i class="fa fa-cog fa-spin"></i>
    	<div class="test-radius-left"></div><div class="test-radius-top"></div><div class="test-radius-right"></div>
    	(Test: border-radius.less) 
    	<hr>
    	<i class="fa fa-quote-left fa-3x pull-left fa-border"></i>
		Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. 
    	Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet 
    	quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est 
    	et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, 
    	wisi. Aenean fermentum, elit eget tincidunt condimentum.
   	';
    
    $sidebar = '<ul class="fa-ul">
  		<li><i class="fa-li fa fa-check-square"></i>List icons</li>
  		<li><i class="fa-li fa fa-check-square"></i>can be used</li>
  		<li><i class="fa-li fa fa-spinner fa-spin"></i>as bullets</li>
  		<li><i class="fa-li fa fa-square"></i>in lists</li>
		</ul>
    	<span class="fa-stack fa-lg">
  			<i class="fa fa-square-o fa-stack-2x"></i>
  			<i class="fa fa-twitter fa-stack-1x"></i>
		</span>
		fa-twitter on fa-square-o<br>
		<span class="fa-stack fa-lg">
  			<i class="fa fa-circle fa-stack-2x"></i>
  			<i class="fa fa-flag fa-stack-1x fa-inverse"></i>
		</span>
		fa-flag on fa-circle<br>
		<span class="fa-stack fa-lg">
  			<i class="fa fa-square fa-stack-2x"></i>
  			<i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
		</span>
		fa-terminal on fa-square<br>
		<span class="fa-stack fa-lg">
  			<i class="fa fa-camera fa-stack-1x"></i>
  			<span class=red><i class="fa fa-ban fa-stack-2x text-danger"></i></span>
		</span>
		fa-ban on fa-camera
    ';

	$app->views->addString($main, 'main')
	->addString($sidebar, 'sidebar')
	->addString('<i class="fa fa-youtube fa-3x"></i>', 'footer-col-1')
	->addString('<i class="fa fa-twitter fa-3x"></i>', 'footer-col-2')
	->addString('<i class="fa fa-facebook fa-3x"></i>', 'footer-col-3')
	->addString('<i class="fa fa-google-plus fa-3x"></i>', 'footer-col-4');

});

$app->router->add('regioner', function() use ($app) {
	
	$app->theme->addStylesheet('css/regions_demo.css');
	$app->theme->setTitle("Regioner");
	
	if ($app->request->getGet('show-grid', 1)) {
		$showGrind = "<h1><a href='?show-grid'>Visa rutnät</a></h1>";
	} else {
		$showGrind = "<h1><a href='?'>Göm rutnät</a></h1>";
	}

	$app->views->addString('flash' . $showGrind, 'flash')
	->addString('featured-1', 'featured-1')
	->addString('featured-2', 'featured-2')
	->addString('featured-3', 'featured-3')
	->addString('main', 'main')
	->addString('sidebar', 'sidebar')
	->addString('triptych-1', 'triptych-1')
	->addString('triptych-2', 'triptych-2')
	->addString('triptych-3', 'triptych-3')
	->addString('footer-col-1', 'footer-col-1')
	->addString('footer-col-2', 'footer-col-2')
	->addString('footer-col-3', 'footer-col-3')
	->addString('footer-col-4', 'footer-col-4');
	
});

	$app->router->add('typography', function() use ($app) {
	
		$app->theme->setTitle("Typography");
		
		if ($app->request->getGet('show-grid', 1)) {
			$showGrind = "<h1><a href='?show-grid'>Visa rutnät</a></h1>";
		} else {
			$showGrind = "<h1><a href='?'>Göm rutnät</a></h1>";
		}
		
		$content = $app->fileContent->get('typography.html');
	
		$app->views->addString($showGrind . $content, 'main');
		
		$app->views->addString($content, 'sidebar');
	
	});

$app->router->handle();
$app->theme->render();
