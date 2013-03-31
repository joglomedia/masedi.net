<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'legacycomments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if (!empty($post->post_password)) { // if there's a password
if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { // and it doesn't match the cookie
?> 
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','inanis');?><p>
<?php
return;
}
}
/* This variable is for alternating comment background */
$oddcomment = 'alt';
?>
      <div class="win"> 
        <div class="win_tl"></div><div class="win_t"></div><div class="win_tr"></div><div class="win_bl"></div><div class="win_b"></div><div class="win_br"></div><div class="win_r"></div><div class="win_l"></div>
        <div class="win_title"><span class="win_tbl">&nbsp;</span><h3><a name="comments"></a><?php _e('Responses to this post','inanis');?> &raquo; (<?php comments_number(__('None','inanis'), __('One Total','inanis'), __('% Total','inanis') );?>)</h3><span class="win_tbr">&nbsp;</span></div>
    
        <div class="win_ted">
          <div class="win_edt"></div>
          <div class="win_pd"></div>
        </div>                                                                                     
        <div class="win_bg"></div><div class="win_tlgr"></div><div class="win_trgr"></div>
        <div class="win_out">
          <div class="win_in">
            <div class="win_post">
                         <?php if ($comments) : ?>
            <ol id="commentlist">
            <?php foreach ($comments as $comment) : ?> 
              <li id="comment-<?php comment_ID() ?>"> 
                <span class="avatar"><?php echo get_avatar($comment, $size = '50'); ?></span>
                <div class="commentbox <?php echo $oddcomment; ?>">
                  <span class="commentauthor"><?php comment_author_link() ?> <?php _e('said','inanis');?>...</span><br />
                  <span class="comment-time"><?php comment_time() ?> - <?php comment_date('F jS, Y') ?></span>
                  <?php if ($comment->comment_approved == '0') : ?><em><?php _e('Your comment is awaiting moderation.','inanis');?></em><?php endif; ?> 
                  <?php comment_text() ?>
                  
                </div>
              </li>
              <?php /* Changes every other comment to a different class */
              /* if ('greybox' == $oddcomment) $oddcomment = 'alt';
              else $oddcomment = 'greybox'; */
              ?> 
            <?php endforeach; /* end for each comment */ ?> 
            </ol>
            <?php else : // this is displayed if there are no comments so far ?> 
              <?php if ('open' == $post->comment_status) : ?>
                <br /><br />
                <div class="ctr"><?php _e('Comments are open. Feel free to leave a comment below.','inanis');?></div>
                <br /><br />
              <!-- Cmts Open, but there are none -->
              <?php else : // comments are closed ?> 
              <!-- Cmts closed -->
              <p class="nocomments ctr" style="margin:35px 0 35px 0;"><?php _e('Sorry, but comments are closed. Check out another post and speak up!','inanis');?></p>
            <?php endif; ?>
          <?php endif; ?>
            </div>
            
            <div class="win_info">
              <div class="win_infot"></div>
              <div class="win_infod"></div> 
              <img class="win_infoi" src="<?php bloginfo('template_directory'); ?>/images/feed_50.png" alt="Tags" />
              <div class="win_infoc">
                 <small><strong><?php _e('Comment Meta','inanis');?>:</strong></small><br />
                <?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> Feed for comments','inanis')); ?><br />
                <?php if ( pings_open() ) : ?> 
                <a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Uniform Resource Identifier">URI</abbr>','inanis'); ?></a> 
                <?php endif; ?>
              </div>
            </div>
          </div> 
        </div>
      </div>
      
      <?php if ('open' == $post->comment_status){ ?>
      <div class="win"> 
        <div class="win_tl"></div><div class="win_t"></div><div class="win_tr"></div><div class="win_bl"></div><div class="win_b"></div><div class="win_br"></div><div class="win_r"></div><div class="win_l"></div>
        <div class="win_title"><span class="win_tbl">&nbsp;</span><h3><a name="post"></a><?php _e('Leave A Comment','inanis');?> ...</h3><span class="win_tbr">&nbsp;</span></div>
        
        <div class="win_ted">
          <div class="win_edt"></div>
          <div class="win_pd"></div>
        </div>                                                                                     
        <div class="win_bg"></div><div class="win_tlgr"></div><div class="win_trgr"></div>
        <div class="win_out">
          <div class="win_in">
            <div class="win_post">
              <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
                <br /><br />
                <div class="ctr"><?php _e('You must be','inanis');?> 
                  
                <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in','inanis');?></a> 
                
                <?php _e('to post a comment','inanis');?>.</div>
                <br /><br />
                <?php else : ?>
                <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                  <?php if ( $user_ID ) : ?>
                  <p><?php _e('Logged in as ','inanis');?>
                    <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
                    <?php
                        $vers = get_bloginfo('version');
                        if ($vers >= "2.7"){
                          /* Logout button for 2.7 and up */ 
                          $logoutbtn1 = '<a title="'.__('Logout','inanis').'" href="' . wp_logout_url() . '"><span>'.__('Logout','inanis').' &raquo;</span>';
                        }
                        else {
                          /* Logout Button for Less than 2.7 */
                          $logoutbtn1 = '<a title="'.__('Logout','inanis').'" href="' . get_option('siteurl') . '/wp-login.php?action=logout"><span>'.__('Logout','inanis').' &raquo;</span>';
                        }
                        $logoutbtn2 = '</a>';
                    ?>
            
                    <?php echo $logoutbtn1;echo $logoutbtn2;?>
                  </p>
                  <?php else : ?>
                  <p>
                    <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" class="form-text"/>
                    <label for="author"><small><?php _e('Name','inanis');?> <?php if ($req) _e('(required)','inanis'); ?></small></label>
                  </p>
                  <p>
                    <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" class="form-text"/>
                    <label for="email"><small><?php _e('Email (will not be published)','inanis');?> <?php if ($req) _e('(required)','inanis'); ?></small></label>
                  </p>
                  <p>
                    <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" class="form-text"/>
                    <label for="url"><small><?php _e('Website','inanis');?></small></label>
                  </p>
                  <?php endif; ?>
                  <p><textarea name="comment" id="comment" cols="50%" rows="10" tabindex="4" class="form-textarea"></textarea></p>
                  <p>
                    <input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Comment now','inanis');?>" class="form-submit"/>
                    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
                  </p>
                  <?php do_action('comment_form', $post->ID); ?>
                </form>
                <?php endif; // If registration required and not logged in ?>
            </div>
            
            <div class="win_info">
              <div class="win_infot"></div>
              <div class="win_infod"></div> 
              <img class="win_infoi" src="<?php bloginfo('template_directory'); ?>/images/comments_50.png" alt="Tags" />
              <div class="win_infoc">
                 <small><strong>XHTML:</strong><br /><?php _e('You can use these tags','inanis');?>: <?php echo allowed_tags(); ?></small>
              </div>
            </div>
          </div> 
        </div>
      </div>
      <?php } ?>

