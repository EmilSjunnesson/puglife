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
        'redovisningar'  => [
            'text'  => 'Redovisningar',
            'url'   => 'redovisning',
            'title' => 'Redovisningar'
        ],
        
        // This is a menu item
        'dicegame'  => [
            'text'  => 'Tärningspelet 100',
            'url'   => 'dicegame',
            'title' => 'Spela tärningspel'
        ],
   		
   		// This is a menu item
    	'theme'  => [
    		'text'  => 'Teman',
   			'url'   => $this->di->get('url')->createRelative('theme.php'),
   			'title' => 'LESS-teman'
    	],
        
        // This is a menu item
        'users'  => [
            'text'  => 'Användare',
            'url'   => 'users',
            'title' => 'Hantera användar-databasen',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 1'  => [
                        'text'  => 'Lägg till',
                        'url'   => 'users/add',
                        'title' => 'Lägg till en ny användare'
                    ],
                		
					// This is a menu item of the submenu
                	'item 2'  => [
               				'text'  => 'Lista alla',
               				'url'   => 'users/list',
               				'title' => 'Visa alla användare'
               		],
                		
               		// This is a menu item of the submenu
               		'item 3'  => [
               				'text'  => 'Lista aktiva',
               				'url'   => 'users/active',
               				'title' => 'Visa alla aktiva användare'
               		],
                		
               		// This is a menu item of the submenu
               		'item 4'  => [
               				'text'  => 'Lista inaktiva',
               				'url'   => 'users/inactive',
               				'title' => 'Visa alla inaktiva användare'
               		],
                		
               		// This is a menu item of the submenu
               		'item 5'  => [
               				'text'  => 'Visa papperskorgen',
               				'url'   => 'users/bin',
                			'title' => 'Visa användare som blivit raderade med soft-delete'
               		],

                    'item 6'  => [
                        'text'  => 'Återställ databas',
                        'url'   => 'setup',
                        'title' => 'Återställer användar-databasen till sitt ursprungliga skick'
                    ],
                ],
            ],
        ],
 
        // This is a menu item
        'rss' => [
            'text'  =>'RSS',
            'url'   => 'rss',
            'title' => 'Visa RSS-flöde'
        ],
    		
    	// This is a menu item
   		'source' => [
   			'text'  =>'Källkod',
   			'url'   => 'source',
   			'title' => 'Visa källkod'
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
