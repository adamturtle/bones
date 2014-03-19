<?php

// Include Google Analytics
//define('GOOGLE_ANALYTICS_ID', '')

require_once('php/bones.php');                  // core functions (don't remove)
require_once('php/plugins.php');                // plugins & extra functions (optional)
require_once('php/post-types.php');             // custom post types

/*
| -------------------------------------------------------------------
| CSS / JS
| -------------------------------------------------------------------
*/

add_action( 'wp_enqueue_scripts', function() {

	// Load CSS
	bones_load_css(array(
    	//'css/vendor/bootstrap.3.1.1.min.css'
	));

	// Load JS
	bones_load_js(array(
		//'js/vendor/bootstrap.3.1.1.min.js'
	));

});