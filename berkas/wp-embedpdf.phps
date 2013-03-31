<?Php
/* 
 * Code modified by: Street.Walker [at] masedi [dot] net
 * Simple embedding PDF, Presentation file to blog post with Google view.
 * ex: http://docs.google.com/viewer?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true
 * or: http://docs.google.com/gview?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true
 * embed it with HTML iFrame: <iframe src="http://docs.google.com/gview?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
 * Source from: http://googlesystem.blogspot.com/2009/09/embeddable-google-document-viewer.html
 * implementation for WordPress: use shortcodes
 * usage: [embedpdf width="600px" height="500px"]http://infolab.stanford.edu/pub/papers/google.pdf[/embedpdf]
 * adopted from: http://www.wprecipes.com/wordpress-tip-create-a-pdf-viewer-shortcode
 *
 * Copy the code and paste it to your functions.php file under your active theme
 */
 
 function viewpdf($attr, $url) {
	return '<iframe src="http://docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' .$attr['width']. '; height:' .$attr['height']. ';" frameborder="0">Your browser should support iFrame to view this PDF document</iframe>';
}
add_shortcode('embedpdf', 'viewpdf');
?>