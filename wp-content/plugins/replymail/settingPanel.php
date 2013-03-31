<?php
/**
 * add init options
 */
function rmInitOptions() {
    $email = get_option('admin_email');
    if (trim($email) == ''){
        $email = parse_url(get_option('url'));
        $email = $email['host'];
        $email = preg_replace('/^www\./i', '', $email);
        if (empty($email)) $email = 'gmail.com';
        $email = 'no@' . $email;
    }
    $name = get_option('blogname');
    $content = <<<CONTENT
{#oriCommentAuthor},

Hello, <strong>{#replyCommentAuthor}</strong> has replied to your comment at "<strong>{#post}</strong>".

Here is the reply comment content:

{#replyContent}

And here is your original comment content:

{#oriContent}

<p>Powered by <a href="http://wordpress.org">WordPress</a> and <a href="http://wanwp.com/plugins/replymail/">replyMail</a></p>
CONTENT;

    $send_copy_email = FALSE;   // whether send a copy mail to admin's inbox.

    $send_to_user = FALSE;      // whether send mail to the user of your blog.

    $options = array(0 => $email,
                     1 => $name,
                     2 => "Someone on '{$name}' reply to your comment",
                     3 => $content,
                     4 => $send_copy_email,
                     5 => $send_to_user,
                             );

    add_option('rmOptions', $options);
}
/**
 * Add a setting submenu page
 */
function rmAddSettingPage() {
    add_options_page('replyMail', 'replyMail Setting', 9, __FILE__, 'rmSettingPage');
    //add_filter('plugin_action_links', 'rmFilterPluginActions', 10, 2);
}

function rmAddTag($type = 'subject') {
    $subjecttags = array(array('tag' => 'blogName', 'title' => 'The name of this blog.'),
                array('tag' => 'postTitle', 'title' => 'The title of the comment post.'),
                array('tag' => 'oriCommentAuthor', 'title' => "The parent commenter's name."),
                array('tag' => 'replyCommentAuthor', 'title' => "The reply commenter's name."),
                );
    $contenttags = array(array('tag' => 'oriCommentAuthor', 'title' => "The parent commenter's name."),
                array('tag' => 'replyCommentAuthor', 'title' => "The reply commenter's name."),
                array('tag' => 'blog', 'title' => 'Clickable link for the blog.'),
                array('tag' => 'post', 'title' => 'Clickable link for the comment post.'),
                array('tag' => 'replyContent', 'title' => 'Clickable link for the comment post.'),
                array('tag' => 'oriContent', 'title' => 'Clickable link for the comment post.'),
                );
    switch ($type){
        case 'content':
            echo clickTag($contenttags, 'content');
            break;
        default:
            echo clickTag($subjecttags, 'subject');
            break;
    }
}

function clickTag($tags,$type) {
    $tags = (array)$tags;
    if ($type == 'content'){
        foreach($tags as $tag){
            $ret .= '<input type="button" class="clicktag" value="'.$tag['tag'].'" title="{#'.$tag['tag'].'} - '.$tag['title'].'" onclick="addTag(\''.$tag['tag'].'\');" />';
        }
    }else if($type == 'subject'){
        foreach($tags as $tag){
            $ret .= '<input type="button" class="clicktag" value="'.$tag['tag'].'" title="{#'.$tag['tag'].'} - '.$tag['title'].'" onclick="addSubjectTag(\'{#'.$tag['tag'].'}\');" />';
        }
    }
    return $ret;
}
/**
 * add some extra style
 */
function rmSettingCSS() {
    global $pluginUrl;
    echo '<link rel="stylesheet" href="'.$pluginUrl.'/tabs.flora.css" type="text/css" media="screen" title="Flora (Default)">
<style type="text/css">
/*<![CDATA[*/
#rmWrap{width:800px;}
#donatebotton{float:left; margin: 5px 5px 5px 0;}
#rmWrap fieldset{margin:12px 0 0 0;padding:0;}
#rmWrap fieldset{-moz-border-radius:5px;-webkit-border-radius:5px;}
#rmWrap legend{color:blue;font:1.2em bold;}
#rmWrap fieldset ol{list-style:none;margin:0;padding:0;}
#rmWrap fieldset li{margin:12px;}
#rmWrap label{display:block;float:left;width:150px;margin-right:12px;}
#rmWrap .textinput{width:450px;}
#rmWrap fieldset.submit{border-style:none;}
input.clicktag{
    -moz-border-radius-bottomleft:3px;
    -moz-border-radius-bottomright:3px;
    -moz-border-radius-topleft:3px;
    -moz-border-radius-topright:3px;
    background: #FFFFFF url(../images/fade-butt.png) repeat-x scroll 0 -2px;
    border-style:solid;
    border-width:1px;
    font-size:12px;
    line-height:18px;
    margin:3px 1px 4px;
    padding:2px;
    width:auto;
}
#previewbox{background:#FFFEEB;border:1px solid #CCC;min-height:10px;_height:10px;padding:10px;}
#previewbox .ps{font-size:14px;}
#previewsubject, #previewcontent{margin: 15px;}
/*]]>*/
</style>';
}

/**
 * jquery tag
 */
function rmSettingJquery() {
    global $pluginUrl;
    echo <<<RET
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#rmWrap > ul").tabs();
});

jQuery(document).ready(function(){
	jQuery('#preview').click(function() { //start function when any update link is clicked
        subject = $('#emailSubject').val();
        content = $('#emailContent').val();
		$.ajax({
            type: "POST",
            url: "{$pluginUrl}/getdata.php",
            data: "subject="+subject+"&content="+content,
            beforeSend: function(){
                $("#loading").show();
            },
            success: function(html){
                $('#previewbox').empty();
                $("#previewbox").append(html);
                $("#loading").hide();
            }
        });
	});
});
</script>
RET;
}

/**
 * setting page html
 */
function rmSettingPage() {
    global $pluginUrl;
    // If submit, collecting options data
    // serialize them and update database
    if($_POST['rmSubmitHidden'] === 'yes') {

        $options = rmCheckData();
        if ($options[0]){
            update_option('rmOptions', $options);
            unset($options);
?>
<div class="updated"><p><strong><?php _e('Options saved!', 'replymail');?></strong></p></div>
<?php
        }else{
?>
<div class="updated"><p><strong style="color:red;"><?php echo $options[1];?></strong></p></div>
<?php
        }
    }elseif($_POST['rmSubmitUninstall']==='yes'){
        delete_option('rmOptions');
?>
<div class="updated"><p><strong><?php _e('Options uninstalled! just go to <a href="plugins.php">plugins page</a> Deactivate this plugin', 'replymail');?></strong></p></div>
<?php
    }
    $options = get_option('rmOptions');
    rmSettingJquery();
?>
<h2><?php _e('replyMail Setting');?></h2>
<div id="rmWrap">
    <div id="donate">
        <strong><?php _e('Donate', 'replymail');?></strong>
        <form id="donatebotton" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick" />
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----" />
            <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="" />
            <img alt="" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1" />
        </form>
        <p><?php _e('Has This Plugin Helped You?', 'replymail')?><br />
        <?php _e('If so, we welcome your support. Click the Donate button and contribute. Thank you!', 'replymail')?></p>
    </div>
    <hr style="clear:left;"/>
    <ul>
        <li><a href="#setting"><span>Setting</span></a></li>
        <li><a href="#uninstall"><span>Uninstall</span></a></li>
    </ul>
    <div id="setting">
        <form name="form1" method="post" action="<?php echo htmlentities(str_replace( '%7E', '~', $_SERVER['REQUEST_URI']),ENT_QUOTES,'UTF-8'); ?>">
            <fieldset>
                <legend><?php _e('Email From Information: ', 'replymail');?></legend>
                <ol>
                  <li>
                    <label for="fromEmail"><?php _e('Email: ', 'replymail');?></label>
                    <input id="fromEmail" name="fromEmail" type="text" tabindex="1" class="textinput" value="<?php echo $options[0];?>" />
                  </li>
                  <li>
                    <label for="fromName"><?php _e('From Name: ', 'replymail');?></label>
                    <input name="fromName" id="fromName" type="text" tabindex="2" class="textinput" value="<?php echo $options[1];?>" />
                  </li>
                </ol>
            </fieldset>
            <fieldset>
                <legend><?php _e('Email Template Setting: ', 'replymail');?></legend>
                <ol>
                  <li>
                    <label><?php _e('Subject Template Tag: ', 'replymail');?></label>
                    <p><?php rmAddTag('subject')?></p>
                    <small>
                        ps: click subject template tags only add to the end of the text
                        <img src="<?php echo $pluginUrl?>/array.png" alt="" />
                    </small>
                  </li>
                  <li>
                    <label for="emailSubject"><?php _e('Subject: ', 'replymail');?></label>
                    <input name="emailSubject" id="emailSubject" type="text" tabindex="3" class="textinput" value="<?php echo $options[2];?>" />
                  </li>
                  <li>
                    <label><?php _e('Content Template Tag: ', 'replymail');?></label>
                    <p><?php rmAddTag('content')?></p>
                  </li>
                  <li>
                    <label for="emailContent"><?php _e('Email Content Template: ', 'replymail');?></label>
                    <textarea name="emailContent" id="emailContent" cols="85" rows="16" tabindex="4"><?php echo stripslashes(format_to_edit($options[3]));?></textarea>
                  </li>
                </ol>
            </fieldset>
            <fieldset>
                <legend><?php _e('Other: ', 'replymail');?></legend>
                <ol>
                    <li>
                        <label for="sendCopyEmail"><?php _e('Send copy email?', 'replymail'); ?></label>
                        <input name="sendCopyEmail" type="checkbox" tabindex="5"<?php if (true == $options[4]) echo ' checked="checked" '; ?>/>
                    </li>
                    <li>
                        <label for="send2User"><?php _e('Send to user?', 'replymail');?></label>
                        <input name="send2User" type="checkbox" tabindex="6" tabindex="6"<?php if (true == $options[5]) echo ' checked="checked" ';?>/>
                    </li>
                </ol>
            </fieldset>
            <fieldset class="submit">
                <input type="hidden" name="rmSubmitHidden" value="yes" />
                <input name="submit" id="submit1" type="submit" value="<?php _e('Save Options', 'replymail');?>" tabindex="7" />
                <img src="<?php echo $pluginUrl?>/loading.gif" alt="" id="loading" style="display: none;" />
                <input type="button" id="preview" value="<?php _e('Preview', 'replymail')?>" tabindex="8" />
            </fieldset>
            <fieldset>
                <legend><?php _e('Preview Box', 'replymail')?></legend>
                <div id="previewbox"></div>
            </fieldset>
        </form>
        <ol>
            <strong><?php _e('Template Tags Help: ', 'replymail')?></strong>
            <li><em>{#blogName}</em> - <?php _e('The name of this blog. ONLY for Subject.', 'replymail')?></li>
            <li><em>{#postTitle}</em> - <?php _e('The title of the comment post. ONLY for Subject.', 'replymail')?></li>
            <li><em>{#oriCommentAuthor}</em> - <?php _e('The parent commenter\'s name. Can use both for Subject and Email Content.', 'replymail')?></li>
            <li><em>{#replyCommentAuthor}</em> - <?php _e('The reply commenter\'s name. Can use both for Subject and Email Content.', 'replymail')?></li>
            <li><em>{#blog}</em> - <?php _e('Clickable link for the blog. ONLY for Email Content.', 'replymail')?></li>
            <li><em>{#post}</em> - <?php _e('Clickable link for the comment post. ONLY for Email Content.', 'replymail')?></li>
            <li><em>{#replyContent}</em> - <?php _e('Reply comment content. ONLY for Email Content.', 'replymail')?></li>
            <li><em>{#oriContent}</em> - <?php _e('Parent comment content. ONLY for Email Content.', 'replymail')?></li>
            <li><?php _e('Also, your can use these HTML tags: ', 'replymail')?><?php echo allowed_tags();?></li>
        </ol>
    </div>
    <div id="uninstall">
        <strong><?php _e('UNINSTALL!', 'replymail')?></strong>
        <p><?php _e('Attention! UNINSTALL will delete options from database, and can not restore.', 'replymail')?></p>
        <form name="form2" method="post" action="<?php echo htmlentities(str_replace( '%7E', '~', $_SERVER['REQUEST_URI']),ENT_QUOTES,'UTF-8'); ?>">
            <fieldset class="submit">
                <input type="hidden" name="rmSubmitUninstall" value="yes" />
                <input name="submit" id="submit2" type="submit" value="<?php _e('Uninstall', 'replymail');?>" />
            </fieldset>
        </form>
    </div>
    <script src="<?php echo $pluginUrl?>/replyMail.js" type="text/javascript"></script>
</div>
<?php
}

/**
 *
 * @param <type> $nameLength
 * @param <type> $subjectLength
 * @return <type>
 */
function rmCheckData($nameLength=100, $subjectLength=150) {
    $email = rmCheckEmail($_POST['fromEmail']);
    if ($email[0] === false)
        return $email;

    $name = rmCheckName($_POST['fromName'], $nameLength);
    if ($name[0] === false)
        return $name;

    $subject = rmCheckName($_POST['emailSubject'], $subjectLength);
    if ($subject[0] === false)
        return $subject;

    $content = rmCheckContent($_POST['emailContent']);
    if ($content[0] === false)
        return $subject;

    if ('on' == $_POST['sendCopyEmail'])
        $send_copy_email = true;
    else
        $send_copy_email = false;

    if ('on' == $_POST['send2User'])
        $send_to_user = true;
    else
        $send_to_user = false;

    return array($email, $name, $subject, $content, $send_copy_email, $send_to_user);
}

/**
 *
 * @param <type> $email
 * @return <type>
 */
function rmCheckEmail($email) {
    $email = trim($email);
    if (empty($email)) return array(false,__('Blank email address', 'replymail'));
    if (isset($email[100])) return array(false,__('Email address not allow longer than 100 byte', 'replymail'));
    $domain = substr($email, strpos($email, '@')+1);
    if (isset($domain[61])) return array(false, __('Domain name not allow longer than 60 byte', 'replymail'));
    if (!is_email($email)) return array(false, __('Please fill in a real email'));
    return $email;
}

/**
 *
 * @param <type> $name
 * @param <type> $length
 * @return <type>
 */
function rmCheckName($name, $length=100) {
    $name = trim($name);
    if (empty ($name)) return array(false, __('Blank name'));
    $name = htmlspecialchars(stripslashes($name));
    if (isset($name[$length])) return array(false, printf(__("Name not allow longer than %d byte", 'replymail'),$length));
    return $name;
}

/**
 * Check and filter the email content.
 * @param string $content
 * @return string
 */
function rmCheckContent($content) {
    if (isset($content[5120])) return array(false, __('Content not allow longer than 5120 byte', 'replymail'));
    $content = wp_filter_kses($content);
    return $content;
}
/* EOF settingPanel.php */
/* ./wp-content/plugins/replymail/settingPanel.php */