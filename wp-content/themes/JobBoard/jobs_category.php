<?php
$catsql = "select c.term_id, c.name from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy='category'";
$blogCategoryIdStr = get_category_by_cat_name(get_option('pt_blog_cat'));  //remove blog category start
$catid = get_sub_categories($blogCategoryIdStr,'string');
if($blogCategoryIdStr)
{
	$catsql .= " and c.term_id not in ($catid)";
} //remove blog category end
$catsql .= " order by c.name";
$catinfo = $wpdb->get_results($catsql);
if($catinfo)
{
	$counter = 0;
	foreach($catinfo as $catinfo_obj)
	{
		$counter++;
		$termid = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		?>
		<div class="form_cat" ><label><input type="checkbox" name="category[]" id="category_<?php echo $counter;?>" value="<?php echo $termid; ?>" class="checkbox" <?php if(isset($cat_array) && in_array($termid,$cat_array)){echo 'checked="checked"'; }?> />&nbsp;<?php echo $name; ?></label></div>
		<?php
	}
}

?>