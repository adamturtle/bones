<?php

// Get Bones Core Up & Running!
require_once('library/bones.php');            // core functions (don't remove)
require_once('library/plugins.php');          // plugins & extra functions (optional)
//require_once('library/custom-post-type.php'); // custom post type example

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Sidebar 1',
    	'description' => 'The first (primary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
 
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php echo get_avatar($comment,$size='32',$default='<path_to_url>' ); ?>
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
				<time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s'), get_comment_date(),  get_comment_time()) ?></a></time>
				<?php edit_comment_link(__('(Edit)'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="help">
          			<p><?php _e('Your comment is awaiting moderation.') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search the Site..." />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!

// Google Analytics
function bones_google_analytics(){
    if( defined("GOOGLE_ANALYTICS_ID") ){
        $o = null;
        $o.= '<script type="text/javascript">';
        $o.= "var _gaq = _gaq || [];";
        $o.= "_gaq.push(['_setAccount', '". GOOGLE_ANALYTICS_ID ."']);";
        $o.= "_gaq.push(['_trackPageview']);";

        $o.= '(function() {';
        $o.= "  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
        $o.= "  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
        $o.= "  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
        $o.= "})();";
        $o.= '</script>';
        echo $o;
    }
}
add_action('wp_footer', 'bones_google_analytics');


/* =CUSTOM
---------------------------------------*/

add_action( 'wp_enqueue_scripts', function() {
	
	// Load CSS
	bones_load_css(array(
		'library/css/bootstrap.min.css',
		'library/css/bootstrap-responsive.min.css'
	));
	
	// Load Js
	bones_load_js(array(
		'library/js/libs/bootstrap.min.js'
	));
	
});