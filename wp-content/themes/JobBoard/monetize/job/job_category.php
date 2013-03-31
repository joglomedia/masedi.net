<?php
global $wpdb;
$blog_cat = get_option('ptthemes_blogcategory');
if(is_array($blog_cat) && $blog_cat[0]!='')
{
	$blog_cat = get_blog_sub_cats_str($type='string');
}else
{
	$blog_cat = '';	
}
if($blog_cat)
{
	$blog_cat .= ",1";
}else
{
	$blog_cat .= "1";
}
global $price_db_table_name;
$package_cats = $wpdb->get_var("select group_concat(cat) from $price_db_table_name where cat>0 and amount>0");
if($package_cats)
{
	if($blog_cat){
	$blog_cat .= ",".$package_cats;
	}else
	{
	$blog_cat .= $package_cats;
	}
}
if($blog_cat)
{
	//$substr = " and c.term_id not in ($blog_cat)";	
	$substr = "";
}
$catsql = "select * from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy='".CUSTOM_CATEGORY_TYPE1."' and tt.parent=0 and c.name != 'Uncategorized' and c.name != 'Blog'  $substr order by c.term_id";

$catinfo = $wpdb->get_results($catsql);
global $cat_array;
$total_cp_price = 0;
$total_price_sql = $wpdb->get_results("select * from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy='".CUSTOM_CATEGORY_TYPE1."' and c.name != 'Uncategorized' and c.name != 'Blog' $substr order by c.name");
foreach($total_price_sql as $objtotal_price_sql){
	$total_cp_price += $objtotal_price_sql->term_price;
}

if($_REQUEST['backandedit'] != ''){
	$place_cat_arr = $cat_array;

} else {
for($i=0; $i < count($cat_array); $i++){
	$place_cat_arr[] = $cat_array[$i]->term_taxonomy_id;
}
}

if($catinfo) {
	$cat_display= strtolower(get_option('ptthemes_category_dislay'));
	if($cat_display==''){ $cat_display='checkbox'; }
	$counter = 0;
	$catcnt = count($catinfo)/2;
	//if($catcnt%2 !=0){ $catcnt = $catcnt - 0.5; }
	$total_cat = count($catinfo);
	$total_loop = count($catinfo);
	//if($catcnt%2 !=0){ $total_cat = count($catinfo_cnt) +1; }
    foreach($catinfo as $catinfo_obj)
	{
		if($counter == 0){ ?> <div class="container1"> 
		<div class="form_cat select_all" ><label><input type="checkbox" name="selectall" onclick="displaychk();" id="selectall" /><?php echo SELECT_ALL;?></label></div>
		<?php }
		$counter++;
		$termid = $catinfo_obj->term_taxonomy_id;
		$term_tax_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$cat_term = explode(',',$_REQUEST['category']);
	?>   
         <div class="form_cat"  >
         	<label>
            <input type="checkbox" name="category[]" id="category_<?php echo $counter; ?>" value="<?php echo $termid; ?>" class="checkbox" <?php if(isset($place_cat_arr) && in_array($termid,$place_cat_arr)){ echo 'checked=checked'; }?> />&nbsp;<?php echo $name; ?>
            </label>
         </div>   

		<?php
		 $child = get_term_children( $term_tax_id ,CUSTOM_CATEGORY_TYPE1);
		 $p = 0;
		 foreach($child as $child_of)
		 { 
			$term = get_term_by( 'id', $child_of, CUSTOM_CATEGORY_TYPE1);
			$termid = $term->term_taxonomy_id;
			$term_tax_id = $term->term_id;
			$name = $term->name;
			$p++;
			$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where tt.term_taxonomy_id='".$termid."' and t.term_id = tt.term_id");
			$cp = $catprice->term_price;
			$p = $p+15;
		 ?>
			<div class="form_cat" style="margin-left:<?php echo $p; ?>px;"><label><input type="checkbox" name="category[]" id="category_<?php echo $counter; ?>" value="<?php if($cp != ""){ echo $termid.",".$catprice->term_price; }else{ echo $termid.",".'0'; }?>" class="checkbox" <?php if(isset($place_cat_arr) && in_array($termid,$place_cat_arr)){echo 'checked="checked"'; }?>  onclick="fetch_packages('<?php echo $catprice->term_id; ?>',this.form)"/>&nbsp;<?php if($cp != ""){ echo $name; }else{ echo $name; } ?></label></div>
		<?php
		}
		if($counter == $catcnt){ ?></div> <div class="container2"><?php }
		if($counter == $total_cat){  ?></div> <?php }
	}
}
?>
<script type="text/javascript">
function displaychk(){
	dml=document.forms['jobform'];
	chk = dml.elements['category[]'];
	len = dml.elements['category[]'].length;
	if(document.jobform.selectall.checked == true) {
		for (i = 0; i < len; i++)
		chk[i].checked = true ;
	} else {
		for (i = 0; i < len; i++)
		chk[i].checked = false ;
	}
}
</script>