<?php
/**
 * Config-file for navigation bar.
*
*/
return [

		// Use for styling the menu
		'class' => 'navbar',

		// Here comes the menu strcture
		'items' => [

				// This is a menu item
				'home'  => [
						'text'  => '<i class="fa fa-chevron-left"></i> Tillbaka till Me',
						'url'   => $this->di->get('url')->createRelative(''),
						'title' => 'Första sidan'
				],

				// This is a menu item
				'redovisningar'  => [
						'text'  => 'Font Awesome',
						'url'   => $this->di->get('url')->createRelative('theme.php'),
						'title' => 'LESS teman'
				],

				// This is a menu item
				'regioner'  => [
						'text'  => 'Regioner',
						'url'   => $this->di->get('url')->createRelative('theme.php/regioner'),
						'title' => 'Visa regioner'
				],
				 
				// This is a menu item
				'theme'  => [
						'text'  => 'Typography',
						'url'   => $this->di->get('url')->createRelative('theme.php/typography'),
						'title' => 'Visa typografi'
				],
		],

		// Callback tracing the current selected menu item base on scriptname
		'callback' => function ($url) {
			if ($url == $this->di->get('request')->getCurrentUrlWithoutQuery()) {
				return true;
			}
		},

		// Callback to create the urls
		'create_url' => function ($url) {
			return $this->di->get('url')->create($url);
		},
		];
