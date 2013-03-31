<?php
/**
 * Simple Agregator
 * Contributor: Deka.web.id
 * Modified by masedi.net
 */
 
/**
 * Call the wordpress config first!
 */
if (file_exists( ABSPATH . '/wp-config.php' )) {
	require_once( ABSPATH . '/wp-config.php' );
}else{
	require_once( 'wp-config.php' );
}

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
			'http://www.masedi.net/feed',
			'http://www.freesoftwarefullversion.com/feed',
			'http://www.mobinesia.com/feed',
			'http://deka.web.id/feed'
			);
// banyaknya item yg ingin ditampilkan
$maxitems = 1;

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

/**
 * Disini kita akan menampilkan Feed nya sbg postingan/page, dari feed url yg telah didefinisikan di $feed_urls
 */
foreach ($feed_urls as $feed_url) {

	echo getME_my_feed($feed_url, 2);

}
?>