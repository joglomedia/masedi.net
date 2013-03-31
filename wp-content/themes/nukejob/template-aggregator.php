<?php
/**
 * Template Name: Simple Agregator
 *
 * Simple Agregator
 * Contributor: Deka.web.id
 * Modified by masedi.net
 * Last Update: 2013/03/02
 */
 
/**
 * Call the wordpress config first!
 */
/*
if (file_exists( ABSPATH . '/wp-config.php' )) {
	require_once( ABSPATH . '/wp-config.php' );
}else{
	require_once( 'wp-config.php' );
}
*/
/*
 * Remove this lines, cos kita udah require file wp-config.php, dimana semua library yg dibutuhkan udah disertakansemua
if (file_exists(ABSPATH . WPINC . '/rss.php')) {
    require_once (ABSPATH . WPINC . '/rss.php');   
} else if(file_exists(ABSPATH . WPINC . '/rss-functions.php')){
    require_once(ABSPATH . WPINC . '/rss-functions.php');      
} else if(file_exists(ABSPATH . WPINC . '/feed.php')){ 
        require_once(ABSPATH . WPINC . '/feed.php');       
}
/*

/**
 * Some parameter, feed url, maximum shown post per feed
 */
 // change the feed url
$feed_urls = array(
			'http://www.sajianku.com/feed',
			'http://www.seksehat.info/feed'
			);
// banyaknya item yg ingin ditampilkan
$max_items = 5;

// Fungsi untuk membatasi deskripsi postingan
function shorten($string, $length)
{
    $suffix = '...';
    $short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
    $desc = trim(substr($short_desc, 0, $length));
    $lastchar = substr($desc, -1, 1);
    if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
    $desc .= $suffix;
    return $desc;
}

/**
 * Lebih baik memindahkan baris code feed_fetch dan kawan2 ke sebuah function, shg dapat dipanggil dan digunakan lagi
 */
function getME_my_feed($feed_url, $maxitems='') {

	$rss = fetch_feed($feed_url);

	if ( '' == $maxitems) {
		$maxitems = $rss->get_item_quantity(1); // 1 = banyaknya postingan yang ingin di tampilkan
	}
	
	$rss_items = $rss->get_items(0, $maxitems);
	ksort($rss_items);
	
	$htmldata = '<ul>';

	if ($maxitems == 0) {
		$htmldata .= '<li>No items found.</li>';
	} else {
		foreach ( $rss_items as $item ) {
		$feed = $item->get_feed();
		$htmldata .= '<li style="text-align: justify;">
			<strong>' .$item->get_date('j M Y'). ' : </strong><a rel="nofollow" href="' .$item->get_permalink(). '" title="' .$item->get_title(). '" target="_blank">' .$item->get_title(). '</a> | <a rel="nofollow" href="' .$feed->get_permalink(). '" title="' .$feed->get_title(). '" target="_blank">' .$feed->get_title(). '</a>';
		$htmldata .= '<p>' .shorten($item->get_description(), 200). '</p>';
		$htmldata .= '</li>';
		
		}
	}
	$htmldata .= '</ul>';
	return $htmldata;
}
?>

<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
				<article class="post-content">
<?php
/**
 * Disini kita akan menampilkan Feed nya sbg postingan/page, dari feed url yg telah didefinisikan di $feed_urls
 */
foreach ($feed_urls as $feed_url) {
	echo '<h3>Latest News from '. $feed_url . '</h3>';
	echo getME_my_feed($feed_url, $max_items);

}
?>
				</article>
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>