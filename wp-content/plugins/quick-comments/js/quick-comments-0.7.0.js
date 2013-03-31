/**
 * Quick Comments for WordPress
 * Post comments quickly without leaving or refreshing the page.
 * @name quick-comments-0.7.0.js
 * @author wokamoto - http://dogmap.jp
 * @version 0.7.0
 * @date December 15, 2008
 * @copyright (c) 2008 wokamoto (dogmap.jp)
 * @license  Released under the GPL license (http://www.gnu.org/copyleft/gpl.html)
 * @requires jQuery v1.2.3 or later and jQuery.blockUI v2.08 or later and jQuery.ScrollTo V1.4 or later
 */

if (typeof jQuery !== 'undefined') {

jQuery((function(jQuery){
  var qc_opt = jQuery.extend({
    form:'form#commentform'
   ,list:'ol.commentlist:first'
   ,requireNameEmail:false
   ,errMsgNameEmail:'Error: please fill the required fields (name, email).'
   ,errMsgCommentNone:'Error: please type a comment.'
   ,errMsgEmail:'Error: please enter a valid email address.'
   ,message:'wait...'
   ,message2:'loading...'
   ,loader:'ajax-loader.gif'
   ,messageCSS:{border:'1px solid #8C8C8C', font:'normal 12px Arial'}
   ,overlayCSS:{backgroundColor:'#FFF', opacity:'0.6'}
   ,effect:0
   ,speed:'fast'
   ,update:'/wp-content/plugins/quick-comments/quick-comments.php'
   ,editReturn:'#edit-comment-%ID%'
   ,editOffset: -50
   ,editButtonLabel:'Update Comment'
   ,editDisabled:{author:true, email:true, url:true}
   }, quickCommentsL10n);
  var flg_ie  = jQuery.browser.msie;
  var flg_ie6 = flg_ie && jQuery.browser.version < "7.0";

  // get comment form
  var form = jQuery(qc_opt.form).unbind('submit');
  var form_css = {position: form.css('position')};

  // get comment list
  var list = jQuery(qc_opt.list);
  var list_css = {zoom: list.css('zoom')};

  var url_insert = form.attr('action');
  var url_update = qc_opt.update;

  var msg_template = '<div style="margin:0 auto;padding:0 1em 0;"><p style="margin:1.5em 0;white-space: nowrap;"><img src="' + qc_opt.loader + '" alt="loading" style="margin-right:.25em;" />%MESSAGE%</p></div>';

  var default_comment = jQuery('textarea[name^=comment]', form).val();
  default_comment = (typeof default_comment === 'undefined' ? '' : default_comment);

//  var cmdSubmit = jQuery('#submit', form);
  var cmdSubmit = jQuery('input[type=submit]', form).unbind('click');
  var cmdSubmitLabel = cmdSubmit.val();
  var do_edit = false;

  // image loader
  var images = document.images;
  var image_load = function(src, onLoad, onError, delay, timeout) {
    onLoad  = onLoad  || function(){};
    onError = onError || function(){};
    delay   = delay   || 10;
    timeout = timeout || 2000;
    for (var i = 0, sz = images.length; i < sz; ++i) {
      if (images[i].src === src && images[i].complete) {
        onLoad(src, images[i].width, images[i].height);
        return;
      }
    }
    var img = new Image(), tick = 0;

    img.finish = false;
    img.onabort = img.onerror = function() {
      if (img.finish) { return; }
      img.finish = true;
      onError(src);
    };
    img.onload  = function() {
      img.finish = true;
      if (jQuery.browser.opera && !img.complete) {
        onError(src);
        return;
      }
      onLoad(src, img.width, img.height);
    };
    img.src = src;
    if (!img.finish && timeout) {
      setTimeout(function() {
        if (img.finish) { return; }
        if (img.complete) {
          img.finish = true;
          if (img.width) { return; }
          onError(src);
          return;
        }
        if ((tick += delay) > timeout) {
          img.finish = true;
          onError(src);
          return;
        }
        setTimeout(arguments.callee, delay);
      }, 0);
    }
  }

  // Image Pre Load
  image_load(qc_opt.loader);

  // Get Comment Data
  var get_comment = function(){
    cmdSubmitLabel = cmdSubmit.val();
    jQuery.scrollTo(qc_opt.form, 1000, {offset:qc_opt.editOffset});
    form.block({
      message: msg_template.replace('%MESSAGE%', qc_opt.message2)
     ,css: qc_opt.messageCSS
     ,overlayCSS: qc_opt.overlayCSS
    });
    var json_url = url_update
                 + '?json'
                 + '&comment_ID=' + jQuery(this).attr('id').replace(/^[^\d]+/, '');
    jQuery.getJSON(json_url, function(json){
      if (json.status) {
        jQuery('input', form).each(function(){if (this.type == 'text' || this.type == 'checkbox') this.disabled = true;});
        var author = jQuery('input[name^=author]',form)
          , email = jQuery('input[name^=email]', form)
          , url = jQuery('input[name^=url]', form);
        if (author.length > 0)
          author.val(json.author)[0].disabled = qc_opt.editDisabled.author;
        if (email.length > 0)
          email.val(json.email)[0].disabled = qc_opt.editDisabled.email;
        if (url.length > 0)
          url.val(json.url)[0].disabled = qc_opt.editDisabled.url;
        jQuery('textarea[name^=comment]', form).val(json.content);
        //default_comment = json.content;

        if (jQuery('#comment_ID').length > 0) {
          jQuery('#comment_ID').val(json.id);
        } else {
          form.append(jQuery('<input type="hidden" id="comment_ID" name="comment_ID" value="' + json.id + '" />'));
        }
        if (jQuery('#datetime').length > 0) {
          jQuery('#datetime').val(json.datetime);
        } else {
          form.append(jQuery('<input type="hidden" id="datetime" name="datetime" value="' + json.datetime + '" />'));
        }
        if (jQuery('#update').length > 0) {
          jQuery('#update').val('1');
        } else {
          form.append(jQuery('<input type="hidden" id="update" name="update" value="1" />'));
        }

      } else {
        alert(json.message);
      }
      cmdSubmit.val(qc_opt.editButtonLabel);
      form.unblock();
    });
    do_edit = true;
    return false;
  }
  jQuery('a.edit-comment', list).each(function(){
    jQuery(this).unbind('click').click(get_comment);
  });

  // Comment List Effect
  var commentListEffect = function(comments, edit_commentID) {
    switch (qc_opt.effect) {
     case 1:
      list
      .empty()
      .append(comments)
      .children(':hidden').slideDown(qc_opt.speed, function(){
        if (flg_ie)  {list.css(list_css);}
        if (flg_ie6) {form.css(form_css); jQuery('legend', form).show();}
        if (edit_commentID !== false) {jQuery.scrollTo(edit_commentID, 1000, {offset:qc_opt.editOffset});}
        jQuery('a.edit-comment').each(function(){jQuery(this).unbind('click').click(get_comment);});
      });
      break;
     case 2:
      list
      .empty()
      .append(comments)
      .children(':hidden').fadeIn(qc_opt.speed, function(){
        if (flg_ie)  {list.css(list_css);}
        if (flg_ie6) {form.css(form_css); jQuery('legend', form).show();}
        if (edit_commentID !== false) {jQuery.scrollTo(edit_commentID, 1000, {offset:qc_opt.editOffset});}
        jQuery('a.edit-comment').each(function(){jQuery(this).unbind('click').click(get_comment);});
      });
      break;
     default:
      list.animate({opacity:'hide'}, qc_opt.speed, function(){
        jQuery(this)
        .empty()
        .append(comments.show())
        .animate({opacity:'show'}, qc_opt.speed, function(){
          if (flg_ie)  {list.css(list_css);}
          if (flg_ie6) {form.css(form_css); jQuery('legend', form).show();}
          if (edit_commentID !== false) {jQuery.scrollTo(edit_commentID, 1000, {offset:qc_opt.editOffset});}
          jQuery('a.edit-comment').each(function(){jQuery(this).unbind('click').click(get_comment);});
        });
      });
      break;
    }
  }

  // success
  var successCallback = function(responseText) {
    form.unblock();
    if (flg_ie6) {jQuery('legend', form).hide();}

    // Edited comment ID
    var edit_commentID = (jQuery('#comment_ID').length > 0 ? qc_opt.editReturn.replace('%ID%', jQuery('#comment_ID').val()) : false);

    // Get New comment list
    var body_html = responseText.replace(/[\r\n\t]/g, '').replace(/^.*<body ?[^>]*>(.*)<\/body>.*$/i, '$1');
    var comment_count = jQuery('#comment_count', jQuery(body_html)).html();
    var received_comment_count = jQuery('#output_comment_count', jQuery(body_html)).html();
    var last_comment_only = (jQuery('#last_comment_only', jQuery(body_html)).html() === 'TRUE');
    var new_list = jQuery(qc_opt.list, jQuery(body_html));

    // If New Post
    if (list.size() <= 0) {
      // Add comment list before Comment Form
      list = new_list;
      jQuery(qc_opt.form).prepend(list);
    }

    // Merge comment list
    var comments;
    if (last_comment_only) {
      var new_comments = new_list.children().hide();
      if (do_edit) {
        comments = list.clone();
        new_comments.each(function(){
          var id = this.getAttribute('id');
          if (id !== null) comments.children('#' + id).html(this.innerHTML);
        });
        comments = comments.children();
      } else {
        if (comment_count > 1) {
          comments = list.children().clone().get();
          new_comments.each(function(){
            comments.push(this);
          });
          comments = jQuery(comments);
        } else {
          comments = new_comments;
        }
      }
    } else {
      comments = new_list.children().show();
      if (!do_edit) {
        switch (qc_opt.effect) {
         case 1:
         case 2:
          comments = jQuery(jQuery.extend(new_list.children().hide().get(), list.children().get()));
          break;
        }
      }
    }

    if (comments.length > 0) {
      if (do_edit) {
        // Comment Update
        list.animate({opacity:'hide'}, qc_opt.speed, function(){
          jQuery(this)
          .empty()
          .append(comments.show())
          .animate({opacity:'show'}, qc_opt.speed, function(){
            if (flg_ie)  {list.css(list_css);}
            if (flg_ie6) {form.css(form_css); jQuery('legend', form).show();}
            if (edit_commentID !== false) {jQuery.scrollTo(edit_commentID, 1000, {offset:qc_opt.editOffset});}
            jQuery('a.edit-comment').each(function(){jQuery(this).unbind('click').click(get_comment);});
          });
        });
      } else {
        // Comment Insert
        if (list.children().length <= 1) {
          switch (qc_opt.effect) {
           case 1:
            list.children().slideUp(qc_opt.speed, function(){commentListEffect(comments, edit_commentID)});
            break;
           case 2:
            list.children().fadeOut(qc_opt.speed, function(){commentListEffect(comments, edit_commentID)});
            break;
           default:
            commentListEffect(comments, edit_commentID);
            break;
          }
        } else {
          commentListEffect(comments, edit_commentID);
        }
      }
      jQuery('textarea[name^=comment]', form).val(''); // Reset comment

    } else {
      alert(responseText.replace(/[\r\n\t]/g, '').replace(/^.*<body ?[^>]*>(.*)<\/body>.*$/i, '$1').replace(/<[^>]*>/, ''));
    }

    jQuery('#comment_ID').remove();
    jQuery('#datetime').remove();
    jQuery('#update').remove();
    jQuery('#quick-comments').remove();
    cmdSubmit.val(cmdSubmitLabel);
    do_edit = false;
  };

  // error
  var errorCallback = function(httpRequest, status, e) {
    form.unblock();
    if (flg_ie6) {jQuery('legend', form).hide();}
    alert(httpRequest.responseText.replace(/[\r\n\t]/g, '').replace(/^.*<p>(.*?)<\/p>.*$/i, '$1'));
    if (flg_ie6) {form.css(form_css); jQuery('legend', form).show();}
    cmdSubmit.val(cmdSubmitLabel);
    do_edit = false;
  };

  // comment form AJAX submit
  form.submit(function(){
    if (jQuery('#quick-comments').length <= 0) jQuery(this).append('<input type="hidden" name="quick-comments" id="quick-comments" value="1" />');

    var author_name  = jQuery('input[name^=author]', jQuery(this)).val();
    var author_email = jQuery('input[name^=email]', jQuery(this)).val();
    var comment_text = jQuery('textarea[name^=comment]', jQuery(this)).val();

    author_name  = (typeof author_name  === 'undefined' ? '' : author_name);
    author_email = (typeof author_email === 'undefined' ? '' : author_email);
    comment_text = (typeof comment_text === 'undefined' ? '' : comment_text);

    // require Name & Email
    if (qc_opt.requireNameEmail && (author_name === '' || author_email === '')) {
      alert (qc_opt.errMsgNameEmail);
      return false;
    }

    // valid Email ?
    if (author_email !== "" && !(/^([a-z0-9+_]|\-|\.)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/).test(author_email)) {
      alert (qc_opt.errMsgEmail);
      return false;
    }

    // type Comment ?
    if (comment_text === "" || comment_text === default_comment) {
      alert (qc_opt.errMsgCommentNone);
      return false;
    }

    jQuery('input', jQuery(this)).each(function(){this.disabled = false;});
    var url = ( jQuery('input#update').length > 0 ? url_update : url_insert );
    var param = jQuery('input, textarea', jQuery(this)).serialize();

    // Form Block
    jQuery(this).block({
      message: msg_template.replace('%MESSAGE%', qc_opt.message)
     ,css: qc_opt.messageCSS
     ,overlayCSS: qc_opt.overlayCSS
    })

    // Post Comment
    jQuery.ajax({
      type:    "POST"
     ,cache:   false
     ,url:     url
     ,data:    param
     ,success: successCallback
     ,error:   errorCallback
    });

    return false;
   });

})(jQuery));

};
