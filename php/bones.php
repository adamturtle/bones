<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

require_once('wp_bootstrap_navwalker.php'); // Bootstrap menu walker

// Adding Translation Option
load_theme_textdomain( 'bonestheme', TEMPLATEPATH.'/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

// Cleaning up the Wordpress Head
function bones_head_cleanup() {
	// remove header links
	remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                         // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                           // WP version
	if (!is_admin()) {
		wp_deregister_script('jquery');                                   // De-Register jQuery
		wp_register_script('jquery', '', '', '', true);                   // It's already in the Header
	}
}
	// launching operation cleanup
	add_action('init', 'bones_head_cleanup');
	// remove WP version from RSS
	function bones_rss_version() { return ''; }
	add_filter('the_generator', 'bones_rss_version');

// loading jquery reply elements on single pages automatically
function bones_queue_js(){ if (!is_admin()){ if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script( 'comment-reply' ); }
}
	// reply on comments script
	add_action('wp_print_scripts', 'bones_queue_js');

// Fixing the Read More in the Excerpts
// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}
add_filter('excerpt_more', 'bones_excerpt_more');

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {
	add_theme_support('post-thumbnails');      // wp thumbnails (sizes handled in functions.php)
	set_post_thumbnail_size(125, 125, true);   // default thumb size
	add_custom_background();                   // wp custom background
	add_theme_support('automatic-feed-links'); // rss thingy
	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	// adding post format support
	add_theme_support( 'post-formats',      // post formats
		array(
			'aside',   // title less blurb
			'gallery', // gallery of images
			'link',    // quick link to other site
			'image',   // an image
			'quote',   // a quick quote
			'status',  // a Facebook like status update
			'video',   // video
			'audio',   // audio
			'chat'     // chat transcript
		)
	);
	add_theme_support( 'menus' );            // wp menus
	register_nav_menus(                      // wp3+ menus
		array(
			'main_nav' => 'The Main Menu',   // main nav in header
			'footer_links' => 'Footer Links' // secondary nav in footer
		)
	);
}

	// launching this stuff after theme setup
	add_action('after_setup_theme','bones_theme_support');
	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'bones_register_sidebars' );
	// adding the bones search form (created in functions.php)
	add_filter( 'get_search_form', 'bones_wpsearch' );



function bones_main_nav(array $args) {

      $defaults = array(
         'logo'   => null,
         'style'  => 'default',
         'invert' => false
      );
      $options = array_merge($defaults, $args);

      // Handle style param
      switch ($options['style']) {
         case 'static':
            $position = "navbar-static-top";
            break;
         case 'fixed':
            $position = "navbar-fixed-top";
            break;
         default:
            $position = null;
            break;
      }

      // Handle invert param
      switch ($options['invert']) {
         case true:
            $style = "navbar-inverse";
            break;
         default:
            $style = "navbar-default";
            break;
      }

      // Handle logo
      if( $options['logo'] ){
         $logo = '<img src="' . get_template_directory_uri() . '/img/' . $options['logo'] . '" alt="' . get_bloginfo('name') . ' logo" />';
      } else {
         $logo = get_bloginfo('name');
      }
   ?>
   <nav class="navbar <?php echo $style; ?> <?php echo $position; ?>" role="navigation">
      <div class="container">
         <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
             </button>
             <a id="logo" class="navbar-brand" href="<?php echo home_url(); ?>" rel="nofollow">
               <?php echo $logo; ?>
            </a>
           </div>
           <?php
            wp_nav_menu( array(
               'menu'              => 'main_nav',
               'theme_location'    => 'main_nav',
               'depth'             => 2,
               'container'         => 'div',
               'container_class'   => 'collapse navbar-collapse',
               'container_id'      => 'main-nav',
               'menu_class'        => 'nav navbar-nav',
               'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
               'walker'            => new wp_bootstrap_navwalker())
            );
         ?>
      </div>
   </nav>
   <?php
}

function bones_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(
    	array(
          'menu'            => 'footer_links', /* menu name */
          'theme_location'  => 'footer_links', /* where in the theme it's assigned */
          'container_class' => 'footer-links clearfix', /* container class */
          'fallback_cb'     => 'bones_footer_links_fallback' /* menu fallback */
    	)
	);
}

// this is the fallback for header menu
function bones_main_nav_fallback() {
	wp_page_menu( 'show_home=Home&menu_class=menu' );
}

// this is the fallback for footer menu
function bones_footer_links_fallback() {
	/* you can put a default here if you like */
}


/****************** PLUGINS & EXTRA FEATURES **************************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; }
	    else { ?>
            <li class="no_related_post">No Related Posts Yet!</li>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
}

// Numeric Page Navi (built into the theme by default)
function page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation pagination"><ol class="bones_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = "First";
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "Last";
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
}

/**
 * Load js
 */
function bones_load_js( $scripts = null ){
	if( $scripts && ! is_admin() ){
		foreach($scripts as $script){
			if( substr($script, 0, 4 ) == "http" ){
				$url = $script;
			}
			$script = explode( '/', $script );
			$array_len = count( $script );
			$filename = str_replace('.js', '' , $script[$array_len - 1]);

			if( $url ){
				wp_register_script( $filename , $url);
				$url = null;
			} else {
				$path = implode('/', str_replace('.js', '' , $script));
				wp_register_script( $filename , get_template_directory_uri() . '/' . $path . '.js', null, null, true);
			}
			wp_enqueue_script( $filename );
		}
	}
}

/**
 * Load CSS
 */
function bones_load_css( $styles = null ){
	if( $styles && ! is_admin() ){
		foreach($styles as $style){
			if( substr($style, 0, 4 ) == "http" ){
				$url = $style;
			}

			$style = explode( '/', $style );
			$array_len = count( $style );
			$filename = str_replace('.css', '' , $style[$array_len - 1]);
			if( $url ){
				wp_register_style( $filename , $url);
				$url = null;
			} else {
				$path = implode('/', str_replace('.css', '' , $style));
				wp_register_style( $filename , get_template_directory_uri() . '/' . $path . '.css');
			}
			wp_enqueue_style( $filename );
		}
	}
}

/**
 * Set Permalinks
 */
 add_action( 'init', function() {
 	global $wp_rewrite;
 	$wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%postname%/' );
 } );

 /*
| -------------------------------------------------------------------
|  Sidebars
| -------------------------------------------------------------------
*/

function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Main sidebar',
    	'description' => 'The first (primary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));

}

/*
| -------------------------------------------------------------------
|  Comments
| -------------------------------------------------------------------
*/

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
}

/*
| -------------------------------------------------------------------
|  Search
| -------------------------------------------------------------------
*/

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