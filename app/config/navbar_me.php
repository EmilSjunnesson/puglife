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
        'ausers'  => [
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
    	'questions'  => [
    		'text'  => 'Frågor',
    		'url'   => 'users',
    		'title' => 'Frågor som användare har ställt',
    		
    		// Here we add the submenu, with some menu items, as part of a existing menu item
    		'submenu' => [
    		
    			'items' => [
    		
    				// This is a menu item of the submenu
    				'item 1'  => [
    					'text'  => 'Ställ en fråga',
    					'url'   => 'users/add',
    					'title' => 'Ställ en fråga som andra användare kan svara på'
    				],
    			],
    		],
    	],
    		
    	// This is a menu item
    	'tags' => [
    		'text'  =>'Taggar',
    		'url'   => 'source',
    		'title' => 'Sök med hjälp av taggar'
    	],
    		
    	// This is a menu item
    	'users' => [
    		'text'  =>'Användare',
    		'url'   => 'source',
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
    		'url'   => 'source',
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
