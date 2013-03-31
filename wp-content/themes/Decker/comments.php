<?php
	$req = get_settings('require_name_email'); 
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( ! empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
?>
				<div><?php _e('This post is password protected. Enter the password to view any comments.') ?></div>
			</div>
<?php
		return;
	endif;
endif;

?>
<?php if ( $comments ) : ?>
<?php global $sandbox_comment_alt ?>

<?php 
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>
<?php if ( $comment_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

				<div id="comments-list">
				  <a name="comments"></a>
					<h2><?php printf($comment_count > 1 ? __('<span>%d</span> Comments') : __('<span>One</span> Comment'), $comment_count) ?></h2>

					<ol>
<?php foreach ($comments as $comment) : ?>
<?php if ( get_comment_type() == "comment" ) : ?>
						<li id="comment-<?php comment_ID() ?>" class="some class">
							<div class="comment-author vcard"><span class="fn n"><?php comment_author_link() ?></span></div><div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>'),
										get_comment_date(),
										get_comment_time(),
										'#comment-' . get_comment_ID() );
										?></div>
<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n") ?>
             <div class="comment-content">
							<?php comment_text() ?>
						 </div>	
						</li>
<?php endif;  ?>
<?php endforeach; ?>

					</ol>
				</div>				

<?php endif;  ?>
<?php if ( $ping_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

				<div id="trackbacks-list" class="comments">
					<h2><?php printf($ping_count > 1 ? __('<span>%d</span> Trackbacks') : __('<span>One</span> Trackback'), $ping_count) ?></h2>

					<ol>
<?php foreach ( $comments as $comment ) : ?>
<?php if ( get_comment_type() != "comment" ) : ?>

						<li id="comment-<?php comment_ID() ?>" class="<?php sandbox_comment_class() ?>">
							<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s'),
									get_comment_author_link(),
									get_comment_date(),
									get_comment_time() );
									edit_comment_link(__('Edit'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n') ?>
            <div class="comment-content">
							<?php comment_text() ?>
						</div>	
						</li>
<?php endif  ?>
<?php endforeach; ?>

					</ol>
				</div>
<?php endif  ?>
<?php endif  ?>


<?php if ( 'open' == $post->comment_status ) : ?>
				<div id="respond">
					<h2><?php _e('Post a Comment') ?></h2>
					<div class="hr-comment"></div>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.'),
					get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>
					<div class="formcontainer">	
						<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

<?php if ( $user_ID ) : ?>
							<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>'),
								get_option('siteurl') . '/wp-admin/profile.php',
								wp_specialchars($user_identity, true),
								get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>

							<p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.') ?> <?php if ($req) _e('Required fields are marked <span class="required">*</span>') ?></p>

							<div class="form-label"><label for="author"><?php _e('Name') ?></label> <?php if ($req) _e('<span class="required">*</span>') ?></div>
							<div class="form-input"><input id="author-c" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>

							<div class="form-label"><label for="email"><?php _e('Email') ?></label> <?php if ($req) _e('<span class="required">*</span>') ?></div>
							<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>

							<div class="form-label"><label for="url"><?php _e('Website') ?></label></div>
							<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>

<?php endif  ?>

							<div class="form-label"><label for="comment"><?php _e('Comment') ?></label></div>
							<div class="form-textarea"><textarea id="comment" name="comment" cols="58" rows="8" tabindex="6"></textarea></div>

							<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e('Submit Comment') ?>" tabindex="7" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>

							<?php do_action('comment_form', $post->ID); ?>

						</form>
					</div>
<?php endif ?>

				</div>
<?php endif  ?>