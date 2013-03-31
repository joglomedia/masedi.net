<div class="after_post">
<div class="promo">
<h3>Bookmark and Promote!</h3>
<ul>
<li class="delicious"><a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>" title="Bookmark this post on del.icio.us">Bookmark on del.icio.us</a></li>
<li class="digg"><a href="http://digg.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>" title="Digg this post!">Digg this post</a></li>
<li class="stumble"><a href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>" title="Stumble this post">Stumble this post</a></li>
<li class="rss"><a href="http://feeds.copyblogger.com/Copyblogger" onclick="javascript:urchinTracker('/outbound/feeds.copyblogger.com');">Subscribe to Copyblogger</a></li>
</ul>
</div>
<h3>Related Articles</h3>
<?php if ( function_exists( 'wp23_related_posts' ) ) wp23_related_posts();?>
</div>