<?php
/**
 * Config-file for Anax, theme related settings, return it all as array.
 *
 */
return [

    /**
     * Settings for Which theme to use, theme directory is found by path and name.
     *
     * path: where is the base path to the theme directory, end with a slash.
     * name: name of the theme is mapped to a directory right below the path.
     */
    'settings' => [
        'path' => ANAX_INSTALL_PATH . 'theme/',
        'name' => 'anax-grid',
    ],

    
        /** 
     * Add default views.
     */
    'views' => [
        [
            'region'   => 'header', 
            'template' => 'me/header', 
            'data'     => [
                'siteTitle' => "Pug Life",
                'siteTagline' => "Frågor och svar om mopsar",
            ], 
            'sort'     => -1
        ],
        [
            'region' => 'footer',
            'template' => 'me/footer', 
            'data' => [
                'name' => "Emil Sjunnesson",
                'email' => "pug.life@gmail.com",
            ], 
            'sort' => -1
        ],
        [
            'region' => 'navbar', 
            'template' => [
                'callback' => function() {
                    return $this->di->navbar->create();
                },
            ], 
            'data' => [], 
            'sort' => -1
        ],
        [
        	'region' => 'toolbar',
        	'template' => 'me/toolbar', 
            'data' => [
            	'loggedIn' => $this->di->users->isLoggedIn(),
            ],
       		'sort' => -1
        ],
    ],


    /** 
     * Data to extract and send as variables to the main template file.
     */
    'data' => [

        // Language for this page.
        'lang' => 'sv',

        // Append this value to each <title>
        'title_append' => ' | Pug Life',

        // Stylesheets
        'stylesheets' => ['css/anax-grid/style.php'],
    		
    	// Give page a class for styling
    	'style_theme' => 'pug',

        // Inline style
        'style' => '
    		.order-answers a.active {
    			border: 1px solid #c2c2c2;
    			border-bottom: 1px solid white;
    			background: white;
    			color: #333333;
			}
    		
    		.order-answers a {
    			padding: 0.5em;
    			padding-bottom: 13px;
    			text-decoration: none;
    			color: #C5C5C5;
    			margin-right: 0.5em;
    			border: 1px solid transparent;
			}
    		
    		.count {
    			font-weight: bold;
    			font-size: 24px;
    		}
    		
    		.navbar li.selected-parent, 
			.navbar li.selected {
  				color: white; 
  				background-color:  #333333;
    			border-color: #333333;
			}
    		
    		.navbar li:hover {
  				border-color: #333;
			} 
    		
    		.navbar li li.selected {
 				color: white; 
			}
    		
    		footer a, .content a {
    			color: #A34141;
    		}
    		
    		footer a:hover, .content a:hover {
    			text-decoration: none;
    		}
    		
    		.large {
    			margin-bottom: 0.5em;
    		}
    	',

        // Favicon
        'favicon' => 'favicon.ico',

        // Path to modernizr or null to disable
        'modernizr' => 'js/modernizr.js',

        // Path to jquery or null to disable
        'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',

        // Array with javscript-files to include
        'javascript_include' => [],

        // Use google analytics for tracking, set key or null to disable
        'google_analytics' => null,
    ],
];

