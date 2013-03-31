<?php
function wpnuke_breadcrumbs() {
	/* === OPTIONS === */
	$text['pretext'] = 'You\'re here';
	$text['home'] = 'Home'; // text for the 'Home' link
	$text['category'] = 'Posts in the "%s" category'; // text for a category page
	$text['search'] = 'Search results for "%s" query'; // text for a search results page
	$text['tag'] = 'Posts tagged in "%s"'; // text for a tag page
	$text['author'] = 'Articles posted by %s'; // text for an author page
	$text['404'] = 'Error 404'; // text for the 404 page

	$show_current = true; // true - show current post/page title in breadcrumbs, false - don't show
	$show_on_home = false; // true - show breadcrumbs on the homepage, false - don't show
	$delimiter = ' &raquo; '; // delimiter between crumbs
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb
	$before_crumb = true;
	/* === END OF OPTIONS === */

	global $post;
	$home_link = get_bloginfo('url') . '';
	$before_link = '<span typeof="v:Breadcrumb">';
	$after_link = '</span>';
	$link_attr = ' rel="v:url" property="v:title"';
	$link = $before_link . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $after_link;

	$pretext = '';
	if ($before_crumb) {
		$pretext = '<strong>' . $text['pretext'] . '</strong>: ';
	}
	
	if (is_home() || is_front_page()) {

		if ($show_on_home) echo '<div class="breadcrumb" id="breadcrumbs">' . $pretext . '<a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="breadcrumbs" id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . $pretext . sprintf($link, $home_link, $text['home']) . $delimiter;

		// If category page & not a search page (if search form using POST, the search.php page with permalink /search/ will be detected as category)
		if ( is_category() && ! isset($_REQUEST['s'])) {
		
			$cat = get_category(get_query_var('cat'), false);
			if ($cat->parent != '0') {
				$cats = get_category_parents($cat, true, $delimiter);
				$cats = str_replace('<a', $before_link . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $after_link, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
			
		} // If search result
		elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;
			
		} // If archive day
		elseif ( is_day() ) {
		
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;
			
		} // If archive month
		elseif ( is_month() ) {
		
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;
			
		} // If archive year
		elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
			
		} // If single post
		elseif ( is_single() && !is_attachment() ) {
		
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				
				/** for job category breadcrumbs **/
				// get the terms related to job post
				$taxonomy = 'job_category';
				
				global $post;
				$terms = get_the_terms( $post->ID, $taxonomy );
				if ( !empty( $terms ) ) {
					$breadcrumbs = array();
					foreach ( $terms as $term ) {
						$breadcrumbs[] = $before_link . '<a' . $link_attr . ' href="' .get_term_link($term->slug, $taxonomy) .'/">' . $term->name . '</a>' . $after_link;
					}
					$term_links = join( "$delimiter", $breadcrumbs);
					if (! $show_current) $term_links = preg_replace("#^(.+)$delimiter$#", "$1", $term_links);
					echo $delimiter . $term_links;
				}
				/** end job breadcrumbs **/
			
				if ($show_current) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				$cats = get_category_parents($cat, true, $delimiter);
				
				if (! $show_current) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				
				$cats = str_replace('<a', $before_link . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $after_link, $cats);
				echo $cats;
				
				if ($show_current) echo $before . get_the_title() . $after;
			}
			
		} // If a custom post type taxonomy
		elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);

			$taxonomy = get_query_var('taxonomy');
			$breadcrumbs = array();
			if ( taxonomy_exists($taxonomy) ) {
				$term = get_term_by('slug', get_query_var('term'), $taxonomy);
				
				$breadcrumbs[] = $before_link . '<a' . $link_attr . ' href="' .get_term_link($term->slug, $taxonomy) .'/">' . $term->name . '</a>' . $after_link;
				
				if($term->parent != '0') {
					$parent = get_term_by('id', $term->parent, $taxonomy);
					$breadcrumbs[] = $before_link . '<a' . $link_attr . ' href="' .get_term_link($parent->slug, $taxonomy) .'/">' . $parent->name . '</a>' . $after_link;
				}
				
				$breadcrumbs = array_reverse($breadcrumbs);
				$term_links = join( "$delimiter", $breadcrumbs);
				if (! $show_current) $term_links = preg_replace("#^(.+)$delimiter$#", "$1", $term_links);
				echo $delimiter . $term_links;
			}
	
			
		} // If attachment page
		elseif ( is_attachment() ) {
		
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, true, $delimiter);
			$cats = str_replace('<a', $before_link . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $after_link, $cats);
			echo $cats;

			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current) echo $delimiter . $before . get_the_title() . $after;
			
		} // If page parent
		elseif ( is_page() && !$post->post_parent ) {
		
			if ($show_current) echo $before . get_the_title() . $after;
			
		} // If page child
		elseif ( is_page() && $post->post_parent ) {
		
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id = $page->post_parent;
			}
			
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			
			if ($show_current) echo $delimiter . $before . get_the_title() . $after;
			
		} // If tag page
		elseif ( is_tag() ) {
		
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
			
		} // If author page
		elseif ( is_author() ) {
		
			global $author;
			$userdata = get_userdata($author);
			
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;
			
		} // If 404 page
		elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo ' ' . __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div>';

	}
}