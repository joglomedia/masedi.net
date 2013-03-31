<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'wpnuke') ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
<div id="comments">
	<h3 id="comments"><?php comments_number(__('No Comments', 'wpnuke'), __('One Comment', 'wpnuke'), __('% Comments', 'wpnuke'));?></h3>
	<div class="comment-nav">
		<span class="previous"><?php previous_comments_link(__('Older', 'wpnuke')) ?></span>
		<span class="next"><?php next_comments_link(__('Newer', 'wpnuke')) ?></span>
	</div>
	<ol class="commentlist">
	<?php wp_list_comments('avatar_size=48'); ?>
	</ol>
</div><!--comments-->
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.', 'wpnuke') ?></p>
	<?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<div id="respond">
	<h3><?php comment_form_title(__('Leave a Reply', 'wpnuke')); ?></h3>
	<p class="cancel-comment-reply">
		<?php cancel_comment_reply_link(__('Cancel', 'wpnuke')); ?>
	</p>
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p><?php _e('You must be', 'wpnuke') ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e('logged in', 'wpnuke') ?></a> <?php _e('to post a comment.', 'wpnuke') ?></p>
	<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( is_user_logged_in() ) : ?>
	<p><?php _e('Logged in as', 'wpnuke') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out &raquo;', 'wpnuke') ?></a></p>
	<?php else : ?>
	<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
	<label for="author"><?php _e('Name', 'wpnuke') ?> <small><?php if ($req) _e('required', 'wpnuke'); ?></small></label></p>
	<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
	<label for="email"><?php _e('Mail', 'wpnuke') ?> <small><?php if ($req) _e('required', 'wpnuke'); ?></small></label></p>
	<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
	<label for="url"><?php _e('Website', 'wpnuke') ?></label></p>
	<?php endif; ?>
	<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>
	<p><input type="submit" class="input-btn" value="Submit Comment" /><?php comment_id_fields(); ?></p>
	<?php do_action('comment_form', $post->ID); ?>
	</form>
	<?php endif; // If registration required and not logged in ?>
</div><!--responds-->
<?php endif; // if you delete this the sky will fall on your head ?>