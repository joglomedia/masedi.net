<div class="title-container">
    <h1 class="title_green">
		<span><?php if($_REQUEST['page']=='sign_up'){ echo REGISTRATION_NOW_TEXT; }else{ echo SIGN_IN_PAGE_TITLE;}?></span>
	</h1>
    <div class="clearfix"></div>
</div>    
<?php
if ( $_REQUEST['emsg']=='fw')
{
	echo "<p class=\"error_msg\"> ".INVALID_USER_FPW_MSG." </p>";
}else
if ( $_REQUEST['emsg']==2)
{
	echo "<p class=\"error_msg\"> ".INVALID_USER_PW_MSG." </p>";
}
if($_REQUEST['checkemail']=='confirm')
{
	echo '<p class="sucess_msg">'.PW_SEND_CONFIRM_MSG.'</p>';
}

?>
<p><?php echo stripslashes(get_option('ptthemes_logoin_page_content'));?></p>
<div class="container-01">
	<div class="graybox">
        <form name="loginform" id="loginform" action="<?php echo get_settings('home').'/?page=register'; ?>" method="post" >
          <div class="form_row clearfix">
            <p><label><?php echo USERNAME_TEXT; ?> <span class="indicates">*</span> </label></p>
            <p><input type="text" name="log" id="user_login" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" /></p>
            <span id="user_loginInfo"></span>
          </div> 
          <div class="form_row clearfix">
            <label>
            	<?php echo PASSWORD_TEXT; ?> <span class="indicates">*</span>
            </label>
            <input type="password" name="pwd" id="user_pass" class="textfield" value="" size="20"  />
            <span id="user_passInfo"></span>
          </div>
          <p class="rember">
            <input name="rememberme" type="checkbox" id="rememberme" value="forever" class="fl" />
            <span style="position:relative; bottom:5px;"><?php esc_attr_e(REMEMBER_ON_COMPUTER_TEXT); ?></span>
          </p>
          <input class="btn_input_highlight btn_spacer" type="submit" value="<?php echo SIGN_IN_BUTTON;?>"  name="submit" />
          <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
          <input type="hidden" name="testcookie" value="1" />
          <input type="hidden" name="loginfrm" value="1" />
       	  <br />
		  <a href="javascript:void(0);showhide_forgetpw();"><?php echo FORGOT_PW_TEXT;?></a>
          <?php if(strtolower(get_option('ptttheme_fb_opt')) == strtolower('Yes')): ?>
					<div class="fbplugin"><?php do_action('login_form'); ?></div>
		  <?php endif; ?>
        </form>
        
        <div id="lostpassword_form" style="display:none;">
        <h1><?php echo FORGOT_PW_TEXT;?></h1>
        <form name="lostpasswordform" id="lostpasswordform" action="<?php echo get_option( 'siteurl' ).'/?page=login&amp;action=lostpassword'; ?>" method="post">
          <div class="form_row clearfix"> <label>
			  <p><?php echo USERNAME_EMAIL_TEXT; ?>: </label></p>
              <p><input type="text" name="user_login" id="user_login1" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" /></p>
              <?php do_action('lostpassword_form'); ?>
          </div>
          <input type="submit" name="get_new_password" value="<?php echo GET_NEW_PW_TEXT;?>" class="btn_input_highlight " />
        </form>
		<?php
		if(strtolower(get_option('ptttheme_fb_opt')) == strtolower('Yes')){ ?>
		<span class="text-or"> <?php _e('OR','templatic'); ?></span>
        <?php
		do_action('fbc_display_login_button');
		}
		?>
        </div>
    </div>    
</div>
<script  type="text/javascript" >
function showhide_forgetpw()
{
	if(document.getElementById('lostpassword_form').style.display=='none')
	{
		document.getElementById('lostpassword_form').style.display = ''
	}else
	{
		document.getElementById('lostpassword_form').style.display = 'none';
	}	
}
</script>