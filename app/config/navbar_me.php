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
            'text'  => 'Hem',
            'url'   => '',
            'title' => 'Första sidan'
        ],
	
    	// This is a menu item
    	'questions'  => [
    		'text'  => 'Frågor',
    		'url'   => 'questions/list',
    		'title' => 'Frågor som användare har ställt',
    		
    		// Here we add the submenu, with some menu items, as part of a existing menu item
    		'submenu' => [
    		
    			'items' => [
    		
    				// This is a menu item of the submenu
    				'item 1'  => [
    					'text'  => 'Ställ en fråga',
    					'url'   => 'questions/ask',
    					'title' => 'Ställ en fråga som andra användare kan svara på'
    				],
    			],
    		],
    	],
    		
    	// This is a menu item
    	'tags' => [
    		'text'  =>'Taggar',
    		'url'   => 'questions/tags',
    		'title' => 'Sök med hjälp av taggar'
    	],
    		
    	// This is a menu item
    	'users' => [
    		'text'  =>'Användare',
    		'url'   => 'users/list',
    		'title' => 'Hitta användare'
    	],
    		
    	// This is a menu item
    	'me' => [
    		'text'  =>'Min sida',
    		'url'   => 'users/id',
    		'title' => 'Mina senaste frågor och svar'
    	],
    		
    		// This is a menu item
    	'about' => [
    		'text'  =>'Om oss',
    		'url'   => 'about',
    		'title' => 'Information om Pug Life'
    	],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getRoute()) {
                return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
];
