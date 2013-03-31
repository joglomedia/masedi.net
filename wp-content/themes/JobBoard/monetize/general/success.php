<?php 
$order_id = $_REQUEST['pid'];
if(get_post_type($order_id)== CUSTOM_POST_TYPE1)
{
	if($_REQUEST['renew'])
	{
		$page_title = JOB_RENEW_SUCCESS_TITLE;
	}else
	{
		$page_title = JOB_POSTED_SUCCESS_TITLE;
	}
}
else
{
	if($_REQUEST['renew'])
	{
		$page_title = RESUME_RENEW_SUCCESS_TITLE;
	}else
	{
		$page_title = RESUME_POSTED_SUCCESS_TITLE;
	}
	
}
global $page_title;
?>
<?php get_header(); ?>
<?php 
$paymentmethod = get_post_meta($_REQUEST['pid'],'paymentmethod',true);
$paid_amount = display_amount_with_currency(get_post_meta($_REQUEST['pid'],'paid_amount',true));
global $upload_folder_path;
if($paymentmethod == 'prebanktransfer')
{
	$filecontent = stripslashes(get_option('post_pre_bank_trasfer_msg_content'));
	if(!$filecontent)	{
		$filecontent = JOB_POSTED_SUCCESS_PREBANK_MSG;
	}
}else
{
	if(get_post_type($order_id)== CUSTOM_POST_TYPE1)
	  {
			$filecontent = stripslashes(get_option('post_added_success_msg_content'));
			if(!$filecontent)
			{
				$filecontent = JOB_POSTED_SUCCESS_MSG;
			}
	  }
	else
	  {
		  $filecontent = RESUME_POSTED_SUCCESS_MSG;
	  }
}
?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<?php if (get_option( 'ptthemes_breadcrumbs' ) == 'Yes'): ?>
<div class="breadcums">
	<ul class="page-nav"><li><?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { yoast_breadcrumb('',' &raquo; '.__($page_title)); } ?></li></ul>
</div>    
<?php endif; ?>
<h1 class="page_head"><?php echo $page_title; ?></h1>
<?php
if(get_post_type($order_id)== CUSTOM_POST_TYPE1)
{
	$post_link = get_permalink($_REQUEST['pid']);
}
if(get_post_type($order_id)== CUSTOM_POST_TYPE2)
{
	$post_link = get_permalink($_REQUEST['pid']);
}

$store_name = get_option('blogname');
if($paymentmethod == 'prebanktransfer')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_name='payment_method_".$paymentmethod."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	$paymentInfo = unserialize($paymentupdinfo[0]->option_value);
	$payOpts = $paymentInfo['payOpts'];
	$bankInfo = $payOpts[0]['value'];
	$accountinfo = $payOpts[1]['value'];
}


				$buyer_information = "";
				global $custom_post_meta_db_table_name;
				$post = get_post($_REQUEST['pid']);
				$address = stripslashes(get_post_meta($post->ID,'geo_address',true));
				$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
				$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
				$contact = stripslashes(get_post_meta($post->ID,'contact',true));
				$email = get_post_meta($post->ID,'email',true);
				$website = get_post_meta($post->ID,'website',true);
				$twitter = get_post_meta($post->ID,'twitter',true);
				$facebook = get_post_meta($post->ID,'facebook',true);
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both') ";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,admin_title asc";
				$post_meta_info = $wpdb->get_results($sql);
				$buyer_information .= "<b>".$post->post_title."</b>";
				$buyer_information .= $post->post_content;
				if($address) {  
							$buyer_information .="<p> <span class='i_location'>".ADDRESS." :" ."</span> ". get_post_meta($post->ID,'geo_address',true)."  </p> "; 
							} 
				
				foreach($post_meta_info as $post_meta_info_obj){ 
					
					if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" ){
						if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "timing")
						{
							 
							
						
							$buyer_information .= "<div class='i_customlable'><span class='i_lbl'>".$post_meta_info_obj->site_title." :"."</span>";
							$buyer_information  .="<div class='i_customtext'>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div></div>";
						}
					 }		
		} 

$orderId = $_REQUEST['pid'];
$siteName = "<a href='".site_url()."'>".$store_name."</a>";
$search_array = array('[#payable_amt#]','[#bank_name#]','[#account_number#]','[#submition_Id#]','[#store_name#]','[#submited_information_link#]','[#submited_information#]','[#site_name#]');
$replace_array = array($paid_amount,$bankInfo,$accountinfo,$order_id,$store_name,$post_link,$buyer_information,$siteName);
$filecontent = str_replace($search_array,$replace_array,$filecontent); 
echo $filecontent;

?>
<?php if(get_post_type($order_id)== CUSTOM_POST_TYPE1){ ?>
<h1><?php echo get_the_title($_REQUEST['pid']); ?></h1>
<div class="detail_list">
    <div class="col_right">
          <h2><?php echo get_post_meta($post->ID,'company_name', $single = true); ?></h2>
            <?php	
                global $custom_post_meta_db_table_name;
                $sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail = 1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both')";
                if($fields_name)
                {
                    $fields_name = '"'.str_replace(',','","',$fields_name).'"';
                    $sql .= " and htmlvar_name in ($fields_name) ";
                }
                $sql .=  " order by sort_order asc,cid asc";
                $post_meta_info = $wpdb->get_results($sql);
                foreach($post_meta_info as $post_meta_info_obj){
                    if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
                            if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "position_title" && $post_meta_info_obj->htmlvar_name != "company_name" && $post_meta_info_obj->htmlvar_name != "how_to_apply" && $post_meta_info_obj->htmlvar_name != "job_desc")
                                {
                                    if($post_meta_info_obj->ctype =='texteditor') {
                                        echo "<div class='text-editor'><span>".$post_meta_info_obj->site_title."</span> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</div>";
                                    }
                                    elseif($post_meta_info_obj->ctype =='textarea') {
                                        echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
                                    }
                                    else {
                                        if($post_meta_info_obj->ctype == 'multicheckbox'):
                                            $checkArr = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true);
                                            if($checkArr):
                                                foreach($checkArr as $_checkArr)
                                                {
                                                    $check .= $_checkArr.",";
                                                }
                                            endif;	
											$check = substr($check,0,-1);
											if($check):
	                                            echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".$check."</p>";
											endif;	
                                        else:
                                            if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != ""):
                                                echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
                                            endif;	
                                        endif;	
                                    } 
                        }?>
                     <?php  $i++;
                     }
        }			
        ?>
    </div>
    <div class="clear"></div>
</div>
<?php } ?>
<?php if(get_post_type($order_id)== CUSTOM_POST_TYPE2){ ?>
	<div class="detail_list">
        <div class="col_right">
        	<h2><?php echo get_post_meta($post->ID,'fname', $single = true); ?> <?php echo get_post_meta($post->ID,'lname', $single = true); ?></h2>
            <?php	
				global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail = 1 and (post_type='".CUSTOM_POST_TYPE2."' or post_type='both')";
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype !='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
							if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "position_title" && $post_meta_info_obj->htmlvar_name != "company_name" && $post_meta_info_obj->htmlvar_name != "lname" && $post_meta_info_obj->htmlvar_name != "fname" && $post_meta_info_obj->htmlvar_name != "activities" && $post_meta_info_obj->htmlvar_name != "skills")
								{
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true);
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											if($check):
												echo "<p><span>".$post_meta_info_obj->site_title." :</span></p><p class='text-width'> ".$check."</p>";
											endif;	
										else:
											if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != ""):
	                                        	echo "<p><span>".$post_meta_info_obj->site_title." :</span></p><p class='text-width'>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
											endif;
										endif;	
						}?>
					 <?php  $i++;
					 }
		}			
		?>
       </div>
       <div class="clear"></div>
    
    <h3> <?php _e('Professional Informaion');?> : </h3>
    <?php foreach($post_meta_info as $post_meta_info_obj){
				if($post_meta_info_obj->ctype =='text' && $post_meta_info_obj->htmlvar_name == "skills") {
					echo "<p><span>".$post_meta_info_obj->site_title." :</span></p><p class='text-width'>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
				}
				elseif($post_meta_info_obj->ctype =='texteditor') {
					echo "<div class='text-editor'><span>".$post_meta_info_obj->site_title." :</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</div>";
				}
				elseif($post_meta_info_obj->ctype =='textarea') {
					echo "<p><span>".$post_meta_info_obj->site_title." :</span></p><p class='text-width'>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
				}
	}
	?>
    </div>
<?php } ?>    
<!-- content #end -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>