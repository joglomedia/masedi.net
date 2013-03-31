<?php
if(!class_exists('PopUp_Domination')){
	die('No direct access allowed.');
}

class PopUp_Domination_Front extends PopUp_Domination {
	
	function PopUp_Domination_Front(){
		parent::PopUp_Domination();
	}
	
	/**
	* split_calculation()
	*
	* Takes percent and returns a number (representing each campaign) using the percentage to switch between.
	*/
	
	function split_calculation($data, $percent){
		if(empty($percent)){
			$percent = 50;
		}
		$num = count($data)-1;
		$url = $data[$num];
		unset($data[$num]);
		$split_url = $data;
		$d_p = $percent; 
		$url = $url;
		$percentage = '';
		$total_urls = count($split_url) - 1;
		mt_srand ((double) microtime() * 1000000);
		$rand_url_val = mt_rand(0, $total_urls);
		$rand_split_val = mt_rand(1, 100);
		if(!$percentage or !ereg("^([0-9]{1, 2})$",  $percentage)) { $percentage = $d_p; }
		if(!$url) { $url = $split_url[$rand_url_val]; }
		if($percentage >= $rand_split_val) { return $url; } else { return $split_url[$rand_url_val];} 
	}
	
	/**
	* load_lightbox()
	*
	* The magic function which setups up everything for the json to build and animate the PopUp.
	*/

	function load_lightbox(){
		global $post;
		$stop_lightbox = false;
		$form_action = '';
		$conversionpage = '';
		$camp = '';
		$num = '';
		$set = false;
		$split = '';
		$splitcampcookie = false;
		$datasplit = false;
		$curpage = $post->post_name;
		/**
		* Finished getting everything setup.
		*/
		$data = $this->get_db('popdom_campaigns');
		$datasplit = $this->get_db('popdom_ab');
		$i = 0;
		$num = array();
		if($this->option('facebook_enabled', false) == 'Y'){
			$app_access = "https://graph.facebook.com/oauth/access_token?client_id=".$this->option['facebook_id']."&client_secret=".$this->option['facebook_sec']."&grant_type=client_credentials";
			$app_access_token = file_get_contents($app_access);
			$user = $this->facebook->getUser();
			if ($user) {
			  try {
			    $user_profile = $this->facebook->api('/me');
			    $permissions = $this->facebook->api("/me/permissions");
			    $UserName = $user_profile['name'];
			  } catch (FacebookApiException $e) {
			    error_log($e);
			    $user = null;
			  }
			}
			if ($user) {
			  $logoutUrl = $this->facebook->getLogoutUrl();
			  if(!isset($_GET['state'])){
			  	if( array_key_exists('email', $permissions['data'][0]) ) {
					$datasplit = false;
					$data = false;
			  	}
			  }else{
			  	echo '';
			  }
			} else {
			  $loginUrl = $this->facebook->getLoginUrl(array(
			    'scope' => 'email,publish_stream'
			  )
			);
			}
		}
		if($datasplit){
			/**
			* If there is any A/B Split Campaigns setup, rattle through the A/B campaigns.
			*/
			foreach($datasplit as $d){
				$campaign = unserialize($d->campaigns);
				$settings = unserialize($d->absettings);
				$conversionpage = $settings['page'];
				$conversion = get_permalink($post->ID);
				/**
				* If this page is the A/B Split Converstion page, set this as campaign to load and as conversion page.
				*/
				if($settings['page'] == $conversion){
					$camp = $d->id;
					$conversionpage = $settings['page'];
				}
				if(empty($campaign)){
					echo '';
				}else{
					/**
					* If there's campaigns select in for the test, cycle through the display options and pages.
					*/
					$pages = unserialize($d->schedule);
					if(isset($pages['everywhere']) && $pages['everywhere'] == 'Y'){
						/**
						* If A/B is set to appear everywhere, cycle through campaigns selected for A/B test.
						*/
						foreach ($campaign as $c){
							foreach($data as $da){
								$cam = $da->campaign;
								if($cam == $c){
									/**
									* Compare campaign data saved in A/B split data to table of campaigns to get campaign ID. If same, set everything up to show this campaign.
									*/
									$num[] = $da->id;
									$set = true;
									$split = true;
									$camp = $d->id;
									$splitcampcookie = true;
									if($settings['visitsplit']){
										$percent = $settings['visitsplit'];
									}else{
										$percent = 50;
									}
								}
							}
							$i++;
						}
					}else{
						if(isset($pages['front']) && $pages['front'] == 'Y'){
							/**
							* If A/B is set to appear on front page, works out if current page is front page. 
							*/
							if(is_front_page() == 1){
								foreach ($campaign as $c){
									foreach($data as $da){
										$cam = $da->campaign;
										if($cam == $c){
											$num[] = $da->id;
											if($settings['visitsplit']){
												$percent = $settings['visitsplit'];
											}else{
												$percent = 50;
											}
											$set = true;
											$split = true;
											$splitcampcookie = true;
											$camp = $d->id;
											if($settings['page']){	
												$conversionpage = $settings['page'];
											}else{
												$conversionpage = false;
											}
										}
									}
									$i++;
								}
							}else{
								echo '';
							}
						}
						if(isset($pages['pageid']) || isset($pages['caton']) || isset($pages['catid'])){
							/**
							* If A/B is set to appear on a specific category or page.
							*/
							if(isset($pages['pageid']) && $pages['pageid'] != 0){
								/**
								* If it's set to appear on a page, cycle through pages and match their ID to ID selected in plugin's Admin panels.
								*/
								foreach ($pages['pageid'] as $p){
									if($post->ID == $p){
										foreach ($campaign as $c){
											foreach($data as $da){
												$cam = $da->campaign;
												if($cam == $c){
													$num[] = $da->id;
													if($settings['visitsplit']){
														$percent = $settings['visitsplit'];
													}else{
														$percent = 50;
													}
													$set = true;
													$split = true;
													$splitcampcookie = true;
													$camp = $d->id;
													if($settings['page']){	
														$conversionpage = $settings['page'];
													}else{
														$conversionpage = false;
													}
												}
											}
											$i++;
										}
									}else{
										echo '';
									}
								}
							}if(isset($pages['caton']) && $pages['caton'] != 0){
								/**
								* If it's set to appear on a category page but not the post's in that category.
								*/
								if($pages['caton'] == 1){
									if(is_category()){
										/**
										* Fixes bug where campaign appears on front_page.
										*/
										if(is_front_page() != 1){
											$cur_cat_id = get_cat_id( single_cat_title("",false) );
											foreach($pages['catid'] as $p){
												if($cur_cat_id == $p){
													foreach ($campaign as $c){
														foreach($data as $da){
															$cam = $da->campaign;
															if($cam == $c){
																$num[] = $da->id;
																if($settings['visitsplit']){
																	$percent = $settings['visitsplit'];
																}else{
																	$percent = 50;
																}
																$set = true;
																$split = true;
																$splitcampcookie = true;
																$camp = $d->id;
																if($settings['page']){	
																	$conversionpage = $settings['page'];
																}else{
																	$conversionpage = false;
																}
															}
														}
														$i++;
													}
												}
											}
										}
									}
								/**
								* If it's set to appear on the posts in a category but not the category page.
								*/
								}else if($pages['caton'] == 2){
									if(is_category()){
									}else{
										if(is_front_page() != 1){
											$cat = get_the_category($post->ID);
											if(isset($cat) && !empty($cat)):
											foreach($cat as $c){
												foreach($pages['catid'] as $p){
													if($c->term_id == $p){
														foreach ($campaign as $c){
															foreach($data as $da){
																$cam = $da->campaign;
																if($cam == $c){
																	$num[] = $da->id;
																	if($settings['visitsplit']){
																		$percent = $settings['visitsplit'];
																	}else{
																		$percent = 50;
																	}
																	$set = true;
																	$split = true;
																	$splitcampcookie = true;
																	$camp = $d->id;
																	if($settings['page']){	
																		$conversionpage = $settings['page'];
																	}else{
																		$conversionpage = false;
																	}
																}
															}
															
															$i++;
														}
													}
												}
											}
											endif;
										}
									}
								}
							/**
							* If it's set to appear on both the posts in a category and the category page.
							* This is the fallback if $pages['caton'] == 0;
							*/
							}else if(isset($pages['catid']) && $pages['catid'] != 0){
								foreach ($pages['catid'] as $p){
									if(is_front_page() != 1){
										$cat = get_the_category($post->ID);
										if(isset($cat) && !empty($cat)):
										foreach($cat as $c){
											if($c->term_id == $p){
												foreach ($campaign as $c){
													foreach($data as $da){
														$cam = $da->campaign;
														if($cam == $c){
															$num[] = $da->id;
															if($settings['visitsplit']){
																$percent = $settings['visitsplit'];
															}else{
																$percent = 50;
															}
															$set = true;
															$split = true;
															$splitcampcookie = true;
															$camp = $d->id;
															if($settings['page']){	
																$conversionpage = $settings['page'];
															}else{
																$conversionpage = false;
															}
														}
													}
													
													$i++;
												}
											}else{
												echo '';
											}
										}
										endif;
									}
								}
							}
						}
					}
				}
			$i++;
			}
		}
		/**
		* If there is no A/B Split campaigns to show, go loading data for normal campaigns.
		* A/B gets first refusal as you can have campaigns without a A/B test, but not the other way round.
		*/
		if($data && !$split){
			$num = false;
			foreach($data as $d){
				$pages = unserialize($d->pages);
				/**
				* If A/B is set to appear everywhere, cycle through campaigns selected for A/B test.
				*/
				if(isset($pages['everywhere']) && $pages['everywhere'] == 'Y'){
					$num[] = $d->id;
					$set = true;
					$split = false;
				}else{
					/**
					* If A/B is set to appear on front page, works out if current page is front page. 
					*/
					if(isset($pages['front']) && $pages['front'] == 'Y'){
						if(is_front_page() == 1){
							$num[] = $d->id;
							$set = true;
							$split = false;
						}else{
							echo '';
						}
					}
					/**
					* If A/B is set to appear on a specific category or page.
					*/
					if(isset($pages['pageid']) || isset($pages['caton']) || isset($pages['catid'])){
						/**
						* If it's set to appear on a page, cycle through pages and match their ID to ID selected in plugin's Admin panels.
						*/
						if(isset($pages['pageid']) && $pages['pageid'] != 0){
							foreach ($pages['pageid'] as $p){
								if($post->ID == $p){
									$num[] = $d->id;
									$set = true;
									$split = false;
								}else{
									echo '';
								}
							}
						/**
						* If it's set to appear on a category page but not the post's in that category.
						*/
						}if(isset($pages['caton']) && $pages['caton'] != 0){
							if($pages['caton'] == 1){
								if(is_category()){
									if(is_front_page() != 1){
										$cur_cat_id = get_cat_id( single_cat_title("",false) );
										foreach($pages['catid'] as $p){
											if($cur_cat_id == $p){
												$num[] = $d->id;
												$set = true;
												$split = false;
											}
										}
									}
								}
							/**
							* If it's set to appear on the posts in a category but not the category page.
							*/
							}else if($pages['caton'] == 2){
								if(is_category()){
								}else{
									if(is_front_page() != 1){
										$cat = get_the_category($post->ID);
										if(isset($cat) && !empty($cat)):
											foreach($cat as $c){
												if (isset($pages['catid'])){
													foreach($pages['catid'] as $p){
														if($c->term_id == $p){
															$num[] = $d->id;
															$set = true;
															$split = false;
														}
													}
												}
											}
										endif;
									}
								}
							}
						/**
						* If it's set to appear on both the posts in a category and the category page.
						* This is the fallback if $pages['caton'] == 0;
						*/
						}else if(isset($pages['catid']) && $pages['catid'] != 0){
							foreach ($pages['catid'] as $p){
								if(is_front_page() != 1){
									$cat = get_the_category($post->ID);
									if(isset($cat) && !empty($cat)):
										foreach($cat as $c){
											if($c->term_id == $p){
												$num[] = $d->id;
												$set = true;
												$split = false;
											}else{
												echo '';
											}
										}
									endif;
								}
							}
						}
					}
				}
			$i++;
			}
		}
		/*
		* Phew! By this stage we know which campaigns are set to load on this page.
		* the $set will be set if we have a campaign selected, if there is none set to appear, this varible is false and fails the if condition.
		*/
		$temp = false;
		if($set){
				$i = 0;
				/*
				* We work out if a A/B test is to be loaded or a normal campaign.
				* If it's a A/B, we work out which of the selected campaigns in the A/B test is to be loaded.
				*/
				foreach($data as $d){
					foreach($num as $n){
						if($d->id == $n){
							if($split){
								$temp[] = $i;
							}else{
								$finalnum = $i;
							}
						}
					}
					$i++;
				}
				if($temp){
					$finalnum = $this->split_calculation($temp, $percent);
				}
				/**
				* If they have no idea what a A/B Split test is and haven't set it up right, we end it right here.
				*/
				if(!isset($finalnum)){
					echo '<script> console.log("You cannot have one Campaign for A/B Split, please create another or selected another Campaign");</script>';
					return false;
				}
				/**
				* Unscramble the data of the chosen campaign and check it's been setup correctly, stops error appearing.
				*/
				$campaign = unserialize($data[$finalnum]->data);
				$campidnum = $data[$finalnum]->id;				
				$t = $campaign['template']['template'];
				if(!$enabled = $this->option('enabled'))
					return false;
				if($enabled != 'Y')
					return false;
				if(!$t = $campaign['template']['template'])
					return false;
				if(!$themeopts = $this->get_theme_info($t))
					return false;
				if(isset($themeopts['colors']) && !($color = $campaign['template']['color']))
					return false;
				$clickbank = '';
				/**
				* Collect the promote settings from DB.
				*/
				if($promote = $this->option('promote')){
					if($promote == 'Y'){
						$clickbank = $this->option('clickbank');
					}
				} else {
					$promote = 'N';
				}
				/**
				* Collect the mailing list settings from DB.
				*/
				$target = $this->option('new_window') == 'Y' ? ' target="_blank"':'';
				$inputs = array('email'=>$campaign['fields']['field_email_default']);
				$api = unserialize(base64_decode($this->option('formapi')));
				/**
				* Start setting up the custom field parts.
				*/
				$provider = $api['provider'];
				$this->custominputs = $this->option('custom_fields');
				if($provider != 'aw'){
					for($i = 1; $i<=$this->custominputs; $i++){
						$inputs['custom'.$i.'_box'] = $this->option('custom'.$i.'_box');
					}
				}
				/**
				* Work out if the name field is set to be disabled.
				*/
				$disable_name = 'N';
				if(isset($api['disable_name']) && $disable = $api['disable_name']){
					if($disable == 'Y'){
						$disable_name = 'Y';
					}
				}else if($disable = $this->option('disable_name')){
					if($disable == 'Y'){
						$disable_name = 'Y';
					}
				}
				
				
				
				if($provider != 'aw'){
					if($disable_name != 'Y'){
						$inputs['name'] = $campaign['fields']['field_name_default'];
					}
				}else{
					$inputs['name'] = $campaign['fields']['field_name_default'];
				}
				/**
				* Begins the setup for all fields appearing in the popup.
				*/
				$fields = '';
				if($provider == 'nm' || $provider == 'form'){
					/**
					* If popup needs form, gets form action.
					*/
					$form = $this->option('action');
					$form = ($provider == 'nm') ? $this->plugin_url.'inc/email.php': $this->option('action');
					if(!empty($form)){
						$form_action .= ($provider == 'nm') ? $this->plugin_url.'inc/email.php': $this->option('action');
					}else{
						/**
						* Otherwise prepare for API fields.
						*/
						$form_action .= $api['listsid'];
					} 
				}else{
					/**
					* If using Aweber, gets custom form ready.
					* If not, get listid for API.
					*/
					if($provider != 'aw'){
						$form_action = '#';
						$fields .= '<input class="listid" type="hidden" name="listid" value="'.$api['listsid'].'" />';
					}else{
						$fields .= '<form method="post" action="http://www.aweber.com/scripts/addlead.pl"><input type="hidden" name="listname" value="'.$api['listsid'].'" /><input type="hidden" name="meta_adtracking" value="PopUp Domination" /><input type="hidden" name="meta_message" value="1" /><input type="hidden" name="meta_required" value="name,email" />';
					}
				}
				/**
				* Places provider in form for API.
				* Also adds redirect.
				*/
				$fields .= '<input class="provider" type="hidden" name="provider" value="'.$api['provider'].'" />';
				$redirect = $this->option('redirecturl');
				/*
				* Following adds name, email and custom fields to popup.
				*/
				$aw_redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$tmp = explode('?state', $aw_redirect);
				if($provider == 'aw'){
					if(isset($redirect) && !empty($redirect)){
						$fields .= '<input class="redirect" type="hidden" name="redirect" value="'.$redirect.'" />';
					}else{
						$fields .= '<input class="redirect" type="hidden" name="redirect" value="'.$tmp['0'].'" />';
					}
				}else if($provider == 'nm'){
					if(isset($redirect) && !empty($redirect)){
						$fields .= '<input class="redirect" type="hidden" name="redirect" value="'.$redirect.'" />';
					}else{
						$fields .= '<input class="redirect" type="hidden" name="redirect" value="'.$tmp['0'].'" />';
					}
					$fields .= '<input class="master" type="hidden" name="master" value="'.$api['apikey'].'" />';
				}
				if($provider != 'aw'){
					if(isset($api['custom1']) && !empty($api['custom1'])){
						$fields .= '<input class="custom_id1" type="hidden" name="customf1" value="'.$api['custom1'].'" />';
					}
					if(isset($api['custom2']) && !empty($api['custom2'])){
						$fields .= '<input class="custom_id2" type="hidden" name="customf2" value="'.$api['custom2'].'" />';
					}
				}
				/**
				* Adds the extra hidden fields if using a form.
				*/
				if($provider == 'nm' || $provider == 'form'){
					$hidden = $this->option('hidden_fields',false);
					if(isset($hidden)){
						$fields .= $hidden;
					}
				}
				if($f = $campaign['images']){
					if(!empty($f)){
						$fieldsarr = unserialize($f);
						foreach($fieldsarr as $b){
							$fields .= '<div style="display:none"><img src="'.$b.'" alt="" height="1" width="1" /></div>';
						}
					}
				}
				$inputs['hidden'] = $fields;
								
				$list_items = array();
				if($l = $campaign['list']){
					if(!empty($l)){
						foreach($l as $litem){
							$list_items[] = $this->encode($litem);
						}
					}
				}
				$fields = array();
				if(isset($themeopts['fields']) && count($themeopts['fields']) > 0){
					foreach($themeopts['fields'] as $a => $b){
						$id = $b['field_opts']['id'];
						$fields[$b['field_opts']['id']] = $campaign['fields']['field_'.$id];
					}
				}
				$center = $themeopts['center'];
				$delay = $campaign['schedule']['delay'];
				$delay_hide = ' style="display:none"';
				$button_color = $campaign['template']['button_color'];
				$cookie_time = $campaign['schedule']['cookie_time'];
				$base = dirname($this->base_name);
				$theme_url = $this->theme_url.$t;
				$this->currentcss = $this->theme_url.$t;
				$lightbox_id = 'popup_domination_lightbox_wrapper';
				$lightbox_close_id = 'popup_domination_lightbox_close';
				$icount = $campaign['schedule']['impression_count'];
				$show_opt = $campaign['schedule']['show_opt'];
				$close_option = $campaign['schedule']['close_option'];
				$unload_msg = $campaign['schedule']['unload_msg'];
				$name = $this->option('name_box');
				$email = $this->option('email_box');
				$custom1 = $this->option('custom1_box');
				$custom2 = $this->option('custom2_box');
				$arr = array();
				if($provider != 'form'){
					if (isset($fields['email_default'])) {
							if($disable_name == 'N'){
							$arr[] = array('class'=>'name','default'=>((isset($fields['name_default'])) ? $fields['name_default'] : 'name'), 'name'=> 'name');
						}
						$arr[] = array('class'=>'email','default'=>((isset($fields['email_default'])) ? $fields['email_default'] : 'email'), 'name'=> 'email');
					}
				}else{
					if (isset($fields['email_default'])) {
						if($disable_name == 'N'){
							$arr[] = array('class'=>'name','default'=>((isset($fields['name_default'])) ? $fields['name_default'] : 'name'), 'name'=> $name);
						}
						$arr[] = array('class'=>'email','default'=>((isset($fields['email_default'])) ? $fields['email_default'] : 'email'), 'name'=> $email);
					}
				}
								
				if($campaign['num_cus'] > 0):
					if($this->option('custom_fields') > 0){
						if(isset($api['custom1']) && $provider != 'form' && !empty($api['custom1']) || isset($custom1) && $provider == 'form' && !empty($custom1)){
							if($provider != 'aw' && $provider != 'form'){
								$arr[] = array('class'=>'custom1_input','default'=>((isset($fields['custom1_default'])) ? $fields['custom1_default'] : ''), 'name' => 'custom1_default');
							}else if($provider == 'aw'){
								$arr[] = array('class'=>'custom1_input','default'=>((isset($fields['custom1_default'])) ? $fields['custom2_default'] : ''), 'name' => 'custom '.$api['custom1']);
							}else{
								$arr[] = array('class'=>'custom1_input','default'=>((isset($fields['custom1_default'])) ? $fields['custom2_default'] : ''), 'name' => $custom1);
							}
						}
						if(isset($api['custom2']) && $provider != 'form' && !empty($api['custom2']) || isset($custom2) && $provider == 'form' && !empty($custom2)){
							if($provider != 'aw' && $provider != 'form'){
								$arr[] = array('class'=>'custom2_input','default'=>((isset($fields['custom2_default'])) ? $fields['custom2_default'] : ''), 'name' => 'custom2_default');
							}else if($provider == 'aw'){
								$arr[] = array('class'=>'custom2_input','default'=>((isset($fields['custom2_default'])) ? $fields['custom2_default'] : ''), 'name' => 'custom '.$api['custom2']);
							}else{
								$arr[] = array('class'=>'custom2_input','default'=>((isset($fields['custom2_default'])) ? $fields['custom2_default'] : ''), 'name' => $custom2);
							}
						}
					}
				endif;
				$fstr = ''; $js = array();
				foreach($arr as $a){
					if(!empty($a['name']) && !empty($a['default'])){
						$js[$a['name']] = $a['default'];
					}
					$fstr .= '<input type="text" class="'.$a['class'].'" placeholder="'.$a['default'].'" name="'.$a['name'].'" />';
				}
				$promote_link = (($promote=='Y') ? '<p class="powered"><a href="'.((!empty($clickbank))?'http://'.$clickbank.'.popdom.hop.clickbank.net/':'http://www.popupdomination.com/').'" target="_blank">Powered By PopUp Domination</a></p>':'');
				if($promote=='N'){
					$promote_link = '';
				}
				ob_start();
				include $this->theme_path.$t.'/template.php';
				$output = ob_get_contents();
				$output = str_replace('{CURRENT_URL}',$this->input_val($this->get_cur_url()),$output);
				ob_end_clean();
				$arr = array('defaults'=>$js,'delay'=>floatval($delay),'cookie_time'=>floatval($cookie_time),'center'=>$center,'cookie_path'=>COOKIEPATH,'show_opt'=>$show_opt,'unload_msg'=>$unload_msg,'impression_count'=>intval($icount),'redirect' => urlencode($redirect), 'splitcookie' => $splitcampcookie, 'conversionpage' => urlencode($conversionpage), 'campaign' => $camp, 'popupid' => $campidnum, 'close_option' =>$close_option, 'output'=>$output);
			if(!$this->is_enabled())
				return false;
			if(!$t = $this->option('template'))
				return false; ?>
		
		<link rel='stylesheet' id='popup_domination-css'  href='<?php echo $this->currentcss; ?>/lightbox.css' type='text/css' media='all' />
		<script type="text/javascript">
			var popup_domination_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>',popup_domination = <?php echo json_encode($arr); ?>, popup_non = 'false';
		</script><?php
		} else {
			if(isset($camp) && isset($conversionpage)){
				$arr = array('conversionpage' => urlencode($conversionpage), 'campaign' => $camp);
			?>
			<script>
				console.log('The plugin has found no PopUp for this page. If this page should have one, check your setup as verification has failed.');
				var popup_domination_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>', popup_domination = <?php echo json_encode($arr); ?>, popup_non = 'true';
			</script>
			<?php
			}else{
			?>
			<script>
				console.log('The plugin has found no PopUp for this page. If this page should have one, check your setup as verification has failed.');
				var popup_domination_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>', popup_domination = '',  popup_non = 'true';
			</script>
			<?php
			}
		}
	}
	
	/**
	* wp_print_styles()
	*
	* Send alls the needs stylesheets to wordpress to load into the header.
	*/	
	
	function wp_print_styles(){
		if(!$this->is_enabled())
			return false;
		if(!$this->should_show())
			return false;
		if(!$t = $this->option('template'))
			return false;
		//wp_enqueue_style('popup_domination',$this->currentcss.'/lightbox.css');
	}
}

$popup_domination = new PopUp_Domination_Front();