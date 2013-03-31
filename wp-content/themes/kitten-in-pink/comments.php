<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');
if (!empty($post->post_password)) { // if there's a password
	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
	_e('<h2>Password Protected</h2>');
	_e('<p>Enter the password to view comments.</p>');
	return;
	}
}
// Variable for alternating comments with the CSS class "alt"
$oddcomment = 'alternate';

// Start editing here
 if ($comments) :
	echo '<h3 id="comments">';
	comments_number('No Responses', 'One Response', '% Responses' );
	echo ' to &#8220'; the_title();
	echo '&#8221;</h3>';

	echo '<ol class="commentlist">';

	foreach ($comments as $comment) :
	$comment_type = get_comment_type();
	if($comment_type == 'comment') { ?>

	<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">

	<div class="comment-meta-data">
		<?php comment_author_link() ?> on 
		<a class="time" href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('M jS, Y') ?>
		<?php _e(' at '); ?><?php comment_time() ?></a>
		<?php edit_comment_link('<span class="edit"></span>',' ','');
		if ($comment->comment_approved == '0') :
			_e('<em>Your comment is awaiting moderation.</em>');
			endif; ?>
		</div><!-- comment-meta-data -->
	<div class="comment-text">
		<?php 
		if (function_exists('get_avatar')) {
 echo get_avatar( get_comment_author_email(), '60' );
 }else{
 	//
 }
		 ?>
		
		
		
		
		<?php comment_text() ?>
	</div><!-- comment-text -->
	</li>

<?php // Changes every other comment to a different class 
	if ('alternate' == $oddcomment) $oddcomment = '';
	else $oddcomment = 'alternate';
	} // end is_comment
endforeach; // end foreach comment 

foreach ($comments as $comment) :
	$comment_type = get_comment_type();
	if($comment_type != 'comment') { ?>
	<li class="trackback alternate" id="comment-<?php comment_ID() ?>">

<div class="comment-meta-data">
	<em>Trackback:</em> 
	<?php comment_author_link() ?><br />
	<a class="time" href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('M jS, Y') ?> <?php _e(' at ');
	comment_time(); echo '</a>';
	edit_comment_link('<span class="edit"></span>',' ','');
 	if ($comment->comment_approved == '0') :
		_e('<em>Your comment is awaiting moderation.</em>');
 		endif; ?>
</div><!-- comment-meta-data -->

<div class="comment-text"><?php comment_text() ?></div>
	</li>
<?php }
// Changes every other comment to a different class
	if ('alternate' == $oddcomment) $oddcomment = '';
	else $oddcomment = 'alternate';
endforeach; ?>
</ol>
<?php
else : // this is displayed if there are no comments so far

if ('open' == $post->comment_status) :
	// If comments are open, but there are no comments.
	else : // comments are closed 
// If comments are closed ?>
	<p class="nocomments">Comments are closed.</p>

	<?php endif;
endif;

if ('open' == $post->comment_status) : ?>
		<h3 id="respond">Leave a Reply</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
<label for="email">Email (not published) <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
<label for="url">Website</label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" class="comments" cols="10" rows="10" tabindex="4"></textarea></p>

<p><input class="submit-comment" name="submit" type="submit" id="submit" tabindex="5" value="Submit" />
<input class="reset-comment" name="reset" type="reset" id="reset" tabindex="6" value="Reset" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php do_action('comment_form', $post->ID); ?>
</p>

<p><?php _e('<strong>You can use these XHTML tags&#58;</strong>'); ?> <?php echo allowed_tags(); ?></p>

</form>
	<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
