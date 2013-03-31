<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."/../../../wp-config.php");
if (!current_user_can('level_9')) die('Not Allow');
if (isset($_POST['subject']) && isset($_POST['content'])){
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    echo getPreviewBox($subject, $content);
}

function getPreviewBox($subject, $content) {
    $postTitle = 'Post Title';
    $postPermalink = '#';
    $parentCommentAuthor = 'Parent Comment Author';
    $childCommentAuthor = 'Child Comment Author';
    $parentCommentContent = '<p>Mauris morbi eu ante. vitae semper. eleifend tortor vitae, et Donec Pellentesque feugiat tempor habitant est. ac amet, egestas. leo. egestas libero placerat quam ultricies et amet malesuada senectus quam, Aenean ultricies Vestibulum eget, tristique sit turpis fames mi sit netus</p>';
    $childCommentContent = '<p>egestas. Pellentesque ac turpis morbi tristique fames malesuada senectus et netus habitant et</p>';

    // Retrieves the blog's "name" & "URL".
    $blogName = get_bloginfo('name');
    $blogURL = get_bloginfo('url');

    // Available Template TAGS.
    $pattern = array(0 => '{#blogName}',
                     1 => '{#postTitle}',
                     2 => '{#oriCommentAuthor}',
                     3 => '{#replyCommentAuthor}',
                     4 => '{#post}',
                     5 => '{#blog}',
                     6 => '{#oriContent}',
                     7 => '{#replyContent}');
    // End of Template TAGS.

    $replace = array(0 => $blogName,
                     1 => $postTitle,
                     2 => $parentCommentAuthor,
                     3 => $childCommentAuthor,
                     4 => "<a href=\"{$postPermalink}\">{$postTitle}</a>",
                     5 => "<a href=\"{$blogURL}\">{$blogName}</a>",
                     6 => $parentCommentContent,
                     7 => $childCommentContent,
                 );

    // Replace Subject Template TAGS to HTML tags.
    //$subject = str_replace('&quot;', "'", $subject);
    //$subject = str_replace('&ldquo;', '"', $subject);
    $subject = stripslashes(apply_filters('the_title',$subject));
    $subject = str_replace($pattern[0], $replace[0], $subject);
    $subject = str_replace($pattern[1], $replace[1], $subject);
    $subject = str_replace($pattern[2], $replace[2], $subject);
    $subject = str_replace($pattern[3], $replace[3], $subject);

    // Replace Email Content Template TAGS to HTML tags.
    $content = stripslashes(apply_filters('comment_text',$content));
    $content = convert_smilies($content);
    $content = str_replace($pattern[2], $replace[2], $content);
    $content = str_replace($pattern[3], $replace[3], $content);
    $content = str_replace($pattern[4], $replace[4], $content);
    $content = str_replace($pattern[5], $replace[5], $content);
    $content = str_replace($pattern[6], $replace[6], $content);
    $content = str_replace($pattern[7], $replace[7], $content);

    return <<<RET
        <strong class="ps">Subject:</strong>
        <p id="previewsubject">{$subject}</p>
        <strong class="ps">Content</strong>
        <div id="previewcontent">{$content}</div>
RET;
}