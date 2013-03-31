<?php
	// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
?>

<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
	<div class="messagebox">
		<div class="content small">
			<?php _e('Enter your password to view comments.', 'elegantbox'); ?>
		</div>
	</div>
<?php return; endif; ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/comment.js"></script>
<?php
	$options = get_option('elegantbox_options');
	$trackbacks = array(); 
?>

<?php if ($comments) : ?>
	<!-- comments START -->
	<ol class="commentlist">
		<?php
			// WordPress 2.7 or higher
			if (function_exists('wp_list_comments')) {
				wp_list_comments('type=comment&callback=custom_comments');
				$trackbacks = $comments_by_type['pings'];
			// WordPress 2.6.3 or lower
			} else {
				foreach ($comments as $comment) {
					if($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback') {
						array_push($trackbacks, $comment);
					} else {
						custom_comments($comment, null, null);
						echo '</li>';
					}
				}
			}
		?>
	</ol>
	<!-- comments END -->

	<!-- comments navi START -->
	<?php
		if(get_option('page_comments')) {
			$comment_pages = paginate_comments_links('echo=0');
			if ($comment_pages) {
	?>
			<div id="commentnavi" class="messagebox">
				<div class="content">
					<span class="pages"><?php _e('Comment pages', 'elegantbox'); ?></span>
					<div id="commentpager">
						<?php echo $comment_pages; ?>

					</div>
				</div>
			</div>
	<?php
			}
		}
	?>
	<!-- comments navi END -->

	<!-- trackback START -->
	<?php if($trackbacks) : ?>
		<div id="trackbacks">
			<div class="caption">
				<h3><?php echo count($trackbacks); _e(' trackbacks', 'elegantbox'); ?></h3>
				<div class="actions">
					<a id="trackbacks_show" href="javascript:void(0);" onclick="MGJS.setStyleDisplay('trackbacks_hide','');MGJS.setStyleDisplay('trackbacks_box','');MGJS.setStyleDisplay('trackbacks_show','none');"><?php _e('Show', 'elegantbox'); ?></a>
					<a id="trackbacks_hide" href="javascript:void(0);" onclick="MGJS.setStyleDisplay('trackbacks_show','');MGJS.setStyleDisplay('trackbacks_box','none');MGJS.setStyleDisplay('trackbacks_hide','none');"><?php _e('Hide', 'elegantbox'); ?></a>
				</div>
				<div class="fixed"></div>
			</div>
			<div id="trackbacks_box" class="content">
				<ol>
					<?php foreach ($trackbacks as $comment) : ?>
						<li>
							<?php comment_author_link(); ?>
							<small>
								<strong><?php comment_type(); ?></strong>
								 | <?php comment_date('Y/m/d'); edit_comment_link(__('Edit', 'elegantbox'), ' | ', ''); ?>
							</small>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
		<script type="text/javascript">MGJS.setStyleDisplay('trackbacks_hide','none');MGJS.setStyleDisplay('trackbacks_box','none');</script>
	<?php endif; ?>
	<!-- trackback END -->

<?php elseif (comments_open()) : // If there are no comments yet. ?>
	<div class="messagebox">
		<div class="content small">
			<?php _e('No comments yet.', 'elegantbox'); ?>
		</div>
	</div>

<?php endif; ?>

<?php if (!comments_open()) : // If comments are closed. ?>
	<div class="messagebox">
		<div class="content small">
			<?php _e('Comments are closed.', 'elegantbox'); ?>
		</div>
	</div>

<?php elseif ( get_option('comment_registration') && !$user_ID ) : // If registration required and not logged in. ?>
	<div class="messagebox">
		<div class="content small">
			<?php
				if (function_exists('wp_login_url')) {
					$login_link = wp_login_url();
				} else {
					$login_link = get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink());
				}
			?>
			<?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'elegantbox'), $login_link); ?>
		</div>
	</div>

<?php else : ?>
	<div id="respond">
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<!-- comment info -->
	<div id="comment_header">
		<div id="comment_info">
			<?php if ( $user_ID ) : ?>
				<?php
					if (function_exists('wp_logout_url')) {
						$logout_link = wp_logout_url();
					} else {
						$logout_link = get_option('siteurl') . '/wp-login.php?action=logout';
					}
				?>
				<div class="row">
					<?php _e('Logged in as', 'elegantbox'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><strong><?php echo $user_identity; ?></strong></a>.
					 <a href="<?php echo $logout_link; ?>" title="<?php _e('Log out of this account', 'elegantbox'); ?>"><?php _e('Logout &raquo;', 'elegantbox'); ?></a>
				</div>

			<?php else : ?>
				<?php if ( $comment_author != "" ) : ?>
					<script type="text/javascript">function setStyleDisplay(id, status){document.getElementById(id).style.display = status;}</script>
					<div class="row">
						<?php printf(__('Welcome back <strong>%s</strong>.', 'elegantbox'), $comment_author) ?>
						<span id="show_author_info"><a href="javascript:void(0);" onclick="MGJS.setStyleDisplay('author_info','');MGJS.setStyleDisplay('show_author_info','none');MGJS.setStyleDisplay('hide_author_info','');"><?php _e('Change &raquo;', 'elegantbox'); ?></a></span>
						<span id="hide_author_info"><a href="javascript:void(0);" onclick="MGJS.setStyleDisplay('author_info','none');MGJS.setStyleDisplay('show_author_info','');MGJS.setStyleDisplay('hide_author_info','none');"><?php _e('Close &raquo;', 'elegantbox'); ?></a></span>
					</div>
				<?php endif; ?>

				<div id="author_info">
					<div class="row">
						<input type="text" name="author" id="author" class="textfield" value="<?php echo $comment_author; ?>" size="24" tabindex="1" />
						<label for="author" class="small"><?php _e('Name', 'elegantbox'); ?> <?php if ($req) _e('(required)', 'elegantbox'); ?></label>
					</div>
					<div class="row">
						<input type="text" name="email" id="email" class="textfield" value="<?php echo $comment_author_email; ?>" size="24" tabindex="2" />
						<label for="email" class="small"><?php _e('E-Mail (will not be published)', 'elegantbox');?> <?php if ($req) _e('(required)', 'elegantbox'); ?></label>
					</div>
					<div class="row">
						<input type="text" name="url" id="url" class="textfield" value="<?php echo $comment_author_url; ?>" size="24" tabindex="3" />
						<label for="url" class="small"><?php _e('Website', 'elegantbox'); ?></label>
					</div>
				</div>

				<?php if ( $comment_author != "" ) : ?>
					<script type="text/javascript">setStyleDisplay('hide_author_info','none');setStyleDisplay('author_info','none');</script>
				<?php endif; ?>

			<?php endif; ?>
		</div>
	</div>

	<!-- comment input -->
	<textarea name="comment" id="comment" tabindex="4" rows="8" cols="50"></textarea>

	<!-- comment submit and rss -->
	<div id="submitbox">
		<div id="comments_rss">
			<a href="<?php bloginfo('comments_rss2_url'); ?>">
				<span class="feed"><?php _e('Subscribe to comments feed', 'elegantbox'); ?></span>
			</a>
		</div>

		<div class="act">
			<?php if (function_exists('wp_list_comments')) : ?>
				<?php cancel_comment_reply_link(__('Cancel', 'elegantbox')) ?>
			<?php endif; ?>
			<input name="submit" type="submit" id="submit" class="button" tabindex="5" value="<?php _e('Submit Comment', 'elegantbox'); ?>" />
		</div>
		<?php if (function_exists('highslide_emoticons')) : ?>
			<div id="emoticon"><?php highslide_emoticons(); ?></div>
		<?php endif; ?>

		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		<?php if (function_exists('wp_list_comments')) : ?>
			<?php comment_id_fields(); ?>
		<?php endif; ?>
		<div class="fixed"></div>
	</div>

	<?php do_action('comment_form', $post->ID); ?>
	</form>
	</div>

	<?php if ($options['ctrlentry']) : ?>
		<script type="text/javascript">CMT.loadCommentShortcut('commentform', 'submit', ' (Ctrl+Enter)');</script>
	<?php endif; ?>

<?php endif; ?>
