<?php
/* 
 * replyMail general functions
 */

/**
 * Retrieves child comment data and its parent comment data
 *
 * @return array
 */
function rm_get_data($comment_id) {
    global $rm_error;

    // Retrieves child comment data
    $comment = get_comment($comment_id);
    
    if ('1' != $comment->comment_approved) {
        $rm_error = __('Comment not approved, do not send replymail', 'replymail');
        rm_error($rm_error, $comment);
        return;
    }

    if ('' != $comment->comment_type) {
        $rm_error = __('Reply to trackback or pingback, do not send replymail.', 'replymail');
        rm_error($rm_error, $comment);
        return;
    }

    if (0 == $comment->comment_parent) {
        $rm_error = __('No parent comment found, do not send replymail', 'replymail');
        rm_error($rm_error, $comment);
        return;
    }

    $comment_parent = get_comment($comment->comment_parent);

    return $data = array (
        'childcomment' => (array)$comment,
        'parentcomment' => (array)$comment_parent
        );

}

/**
 * send replymail
 *
 * @uses $wpdb
 *
 * @param int $commentdata comment ID
 * @return
 */
function rmReplyMail($comment_id){
    // Get the options and the child & parent comments data
    $options = get_option('rmOptions');    
    $chi_par_comments = rm_get_data($comment_id);

    // If the childcomment and the parentcomment have same author email
    // exit, do not send replymail.
    if ($chi_par_comments['childcomment']['comment_author_email']
            == $chi_par_comments['parentcomment']['comment_author_email']){
        $rm_error = __('Reply to own comment, do not send replymail', 'replymail');
        rm_error($rm_error, $chi_par_comments);
        return;
    }

    // If reply to a blog register user and the send to user option is not checked
    // exit, do not send replymail.
    if (0 != $chi_par_comments['parentcomment']['user_ID']
            || TRUE != $options[5]) {
        $rm_error = __('Do not need to send replymail to blog registor user', 'replymail');
        rm_error($rm_error, $chi_par_comments);
        return;
    }

    // Filter the email title and content, and convert them to HTML.
    $replymail_title_content = rm_title_content($options, $chi_par_comments);

    $from = 'From: ' . $options[1] . ' <' . $options[0] . '>' . "\n" .
        'Content-Type: text/html; charset="UTF-8' . "\n" . 'X-Plugin2: replyMail 1.2.0' . "\n";

    $sendcopy = $sendreplymail = 'ready';
    if (TRUE == $options[4]) {
        $sendcopy = wp_mail(
                get_bloginfo('admin_email'),
                'Replymail copy mail: ' . $replymail_title_content['title'],
                'Here is the replymail copy mail: <br />' . $replymail_title_content['content'],
                $from
                );
    }

    $sendreplymail = wp_mail(
            $chi_par_comments['parentcomment']['comment_author_email'],
            $replymail_title_content['title'],
            $replymail_title_content['content'],
            $from
            );

    rm_error($chi_par_comments, $replymail_title_content, $options, $to, $from, $sendcopy, $sendreplymail);
}

function rm_title_content($options, $chi_par_comments) {
    global $wpdb, $table_prefix;

    // Retrieves the 'title' of current post.
    $sql = "SELECT `post_title`
        FROM `{$table_prefix}posts`
        WHERE ID = '{$chi_par_comments['childcomment']['comment_post_ID']}'";
    $post_title = $wpdb->get_var($sql);

    // Retrieves the 'permalink' of current post.
    $post_permalink = get_permalink($chi_par_comments['childcomment']['comment_post_ID']);
    $post_permalink .= '#comment-' . $chi_par_comments['childcomment']['comment_ID'];

    // Retrieves the 'name' of the blog.
    $blog_name = get_bloginfo('name');

    // Retrieves the 'url' of the blog.
    $blog_url = get_bloginfo('url');

    // Available Template TAGS.
    $pattern = array(
        'blogname' => '{#blogName}',
        'posttitle' => '{#postTitle}',
        'parentcommentauthor' => '{#oriCommentAuthor}',
        'childcommentauthor' => '{#replyCommentAuthor}',
        'postpermalink' => '{#post}',
        'bloglink' => '{#blog}',
        'parentcommentcontent' => '{#oriContent}',
        'childcommentcontent' => '{#replyContent}'
        );

    $replace = array(
        'blogname' => $blog_name,
        'posttitle' => $post_title,
        'parentcommentauthor' => $chi_par_comments['parentcomment']['comment_author'],
        'childcommentauthor' => $chi_par_comments['childcomment']['comment_author'],
        'postpermalink' => "<a href=\"{$post_permalink}\">{$post_title}</a>",
        'bloglink' => "<a href=\"{$blog_url}\">{$blog_name}</a>",
        'parentcommentcontent' => $chi_par_comments['parentcomment']['comment_content'],
        'childcommentcontent' => $chi_par_comments['childcomment']['comment_content']
                );

    $title = stripslashes(apply_filters('the_title',$options[2]));
    $title = str_replace($pattern['blogname'], $replace['blogname'], $title);
    $title = str_replace($pattern['posttitle'], $replace['posttitle'], $title);
    $title = str_replace($pattern['parentcommentauthor'], $replace['parentcommentauthor'], $title);
    $title = str_replace($pattern['childcommentauthor'], $replace['childcommentauthor'], $title);

    $content = stripslashes(apply_filters('comment_text',$options[3]));
    $content = convert_smilies($content);
    $content = str_replace($pattern['parentcommentauthor'], $replace['parentcommentauthor'], $content);
    $content = str_replace($pattern['childcommentauthor'], $replace['childcommentauthor'], $content);
    $content = str_replace($pattern['postpermalink'], $replace['postpermalink'], $content);
    $content = str_replace($pattern['bloglink'], $replace['bloglink'], $content);
    $content = str_replace($pattern['parentcommentcontent'], $replace['parentcommentcontent'], $content);
    $content = str_replace($pattern['childcommentcontent'], $replace['childcommentcontent'], $content);

    $title_content = array(
        'title' => $title,
        'content' => $content
    );

    return $title_content;
}

function rm_error() {
    global $rmDebug;

    $args_num = func_num_args();

    if (TRUE == $rmDebug && is_user_logged_in() && $args_num > 0) {
        $error_list = func_get_args();

        echo var_export($error_list, TRUE);
        
        exit ();
    }
}
/* EOF replyMailFunctions.php */
/* ./wp-content/plugins/replymail/replyMailFunctions.php */