<?php
/*
Template Name: Contact ME
*/

/**
 * filename: contact.php
 * part of Simple Contact ME Form
 * installation: upload this file to your theme directory
 *
 * @param:
 *
 * Contributor: me[at]masedi[dot]net - http://www.masedi.net/contactme
 * License: CopyLeft © 2010 under GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
session_start();

get_header();
?>

<!-- begin colLeft -->
	<div id="colLeft">	
    <!-- begin colLeftInner -->	
	<div id="colLeftInner" class="clearfix">
    	<div class="page">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		
		<?php the_content(__('(more...)')); ?>

		<?php endwhile; endif; ?>
		
		<!-- Start Simple Contact ME Form by me[at]masedi[dot]net -->
			<?php 
				//$error_code = $_GET['msg'];
				$error_code = $_SESSION['c_errorcode'];
				if(isset($error_code) && (! is_numeric($error_code) || $error_code > 5)) {
					$message = "Sorry, you request something that isn't here.";
				}else{
					switch($error_code) {
						case 0:
							$message = '';
						break;
						case 1:
							$message = '<p id="success" class="successmsg">SUCCESS: Your message has been sent.</p>';
						break;
						case 2:
							$message = '<p id="failure" class="errormsg">FAILURE: Sorry, Your message couldn\'t been send due to system error.</p>';
						break;
						case 3:
							$message = '<p id="failure" class="errormsg">FAILURE: Please, fill all required form and valid email address!</p>';
						break;
						case 4:
							$message = '<p id="failure" class="errormsg">FAILURE: Header injection detected. Sorry, You are not allowed to do that.</p>';
						break;
						case 5:
							$message = '<p id="failure" class="errormsg">FAILURE: Invalid security questions answer.</p>';
						break;
					}
				}
				
				echo $message;
				
				// reset session, just for pretty up the form :D
				$_SESSION['c_errorcode'] = 0;
			?>
						
			<form id="contact" action="<?php bloginfo('template_url'); ?>/sendcontact.php" method="post">
			<label for="name">Your name: *</label>
			<input type="text" id="nameinput" name="name" value=""/>
			<label for="email">Your email: *</label>
			<input type="text" id="emailinput" name="email" value=""/>
			<label for="comment">Your message: *</label>
			<textarea cols="20" rows="7" id="commentinput" name="comment"></textarea><br />
			<!-- start captcha -->
			<label for="capcay">Sum of<img src="<?php bloginfo('template_url'); ?>/sendcontact.php?captcha=generateimage" /> =</label>
			<input type="text" id="captchainput" name="captchacode" value="" /><br />
			<!-- end captcha -->
			<input type="submit" id="submitinput" name="submit" class="submit" value=""/>
			<input type="hidden" id="receiver" name="receiver" value="<?php echo get_option('designpile_contact_email')?>"/>
			</form>
		<!-- End Simple Contact ME Form by me[at]masedi[dot]net -->
		
		</div>
	</div>
	<!-- end colLeftInner -->
	</div>
<!-- end colLeft -->

			<?php get_sidebar(); ?>	

<?php get_footer(); ?>