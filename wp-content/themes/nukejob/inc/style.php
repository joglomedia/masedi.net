<?php
// Available Google webfont
$google_fonts = array ("PT Sans","PT Serif","Droid Sans","Droid Serif","Nobile","Dancing Script","Cantarel","Josefin Sans","Old Standard TT","Playfair Display","Quattrocento","Quattrocento Sans","The Girl Next Door","Over the Rainbow","Tangerine","Puritan","Goudy Bookletter 1911","Arimo","EB Garamond","Molengo","OFL Sorts Mill Goudy TT","Crimson Text","Cabin","Annie Use Your Telescope","Philosopher","Bitter","Terminal Dosis","Cardo");

// User Input
$body_typo = nuke_get_option('body_typo');
$head_typo = nuke_get_option('head_typo');
$post_title_typo = nuke_get_option('post_title_typo');
$post_title_typo_hover = nuke_get_option('post_title_typo_hover');
$link_typo = nuke_get_option('link_typo');
$link_typo_hover = nuke_get_option('link_typo_hover');
$teaser_head_typo = nuke_get_option('teaser_head_typo');
$teaser_subhead_typo = nuke_get_option('teaser_subhead_typo');

$typo_options = array ( $body_typo["face"], $head_typo, $post_title_typo["face"], $post_title_typo_hover["face"], $link_typo["face"], $link_typo_hover["face"], $teaser_head_typo["face"], $teaser_subhead_typo["face"] );

// Check Type Options
if ( !empty($typo_options) ) {
    foreach ($typo_options as $typo_option) {
        if ( in_array( $typo_option, $google_fonts ) ) {
            $my_fonts .= $typo_option."|";
        }
    }

    //output google font
    if ( !empty($my_fonts) ) {
        $my_fonts = str_replace(" ", "+", $my_fonts);
        //remove the last bit "|" of my_fonts
        $my_fonts = substr($my_fonts, 0, strlen($my_fonts)-1);
        $my_output .= '<link href="http://fonts.googleapis.com/css?family=' . $my_fonts .'" rel="stylesheet" type="text/css" />';
		
		echo $my_output;
    }
}
?>
<style>
<?php
if ($body_typo) {
	echo 'body { font:'.$body_typo['style'] . ' ' . $body_typo['size']. ' ' . $body_typo['face'] . '; color:' . $body_typo['color'] . '; }';
}
if ($head_typo) {
	echo 'h1, h1 a, h2, h2 a, h3, h3 a, h4, h4 a, h5, h5 a, h6, h6 a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover { font-family:' . $head_typo . ', Verdana, Geneva, Sans-Serif; }';
}
if ($link_typo) {
	echo 'a { font:'.$link_typo['style'] . ' ' . $link_typo['size']. ' ' . $link_typo['face'] . '; color:' . $link_typo['color'] . '; }';
}
if ($link_typo_hover) {
	echo 'a:hover { font:'.$link_typo_hover['style'] . ' ' . $link_typo_hover['size']. ' ' . $link_typo_hover['face'] . '; color:'.$link_typo_hover['color'].'; }';
}
if ($post_title_typo) {
	echo '#content .post-title h1, #content .post-title h1 a, #content .post-title h2, #content .post-title h2 a { font:'.$post_title_typo['style'] . ' ' . $post_title_typo['size']. ' ' . $post_title_typo['face'] . '; color:'.$post_title_typo['color'].'; }';
}
if ($post_title_typo_hover) {
	echo '#content .post-title h1 a:hover, #content .post-title h2 a:hover { font:'.$post_title_typo_hover['style'] . ' ' . $post_title_typo_hover['size']. ' ' . $post_title_typo_hover['face'] . '; color:'.$post_title_typo_hover['color'].'; }';
}
if ($teaser_head_typo) {
	echo '.teaser-text h1, .teaser-text h2 { font:'.$teaser_head_typo['style'] . ' ' . $teaser_head_typo['size']. ' ' . $teaser_head_typo['face'] . '; color:' . $teaser_head_typo['color'] . '; }';
}
if ($teaser_subhead_typo) {
	echo '.teaser-text p { font:'.$teaser_subhead_typo['style'] . ' ' . $teaser_subhead_typo['size']. ' ' . $teaser_subhead_typo['face'] . '; color:' . $teaser_subhead_typo['color'] . '; }';
}
?>
</style>