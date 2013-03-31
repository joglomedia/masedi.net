<?php
/**
 * Template Name: Simple-ContactME
 */

/**
 * filename: contact.php
 * part of Simple Contact ME Form
 * installation: upload this file to your theme directory
 *
 * @param:
 *
 * Contributor: me[at]masedi[dot]net - http://www.masedi.net/contactme
 * License: CopyLeft ? 2010 under GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
session_start();

get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post" id="post-<?php the_ID(); ?>">
	<div class="p-head">
		<h1><?php the_title(); ?></h1>
	</div>
	<div class="p-con">
		<?php the_content(__('(more...)')); ?>
		
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
							$message = '<p id="messages" class="successmsg">SUCCESS: Your message has been sent.</p>';
						break;
						case 2:
							$message = '<p id="messages" class="errormsg">FAILURE: Sorry, Your message couldn\'t been send due to system error.</p>';
						break;
						case 3:
							$message = '<p id="messages" class="errormsg">FAILURE: Please, fill all required form and valid email address!</p>';
						break;
						case 4:
							$message = '<p id="messages" class="errormsg">FAILURE: Header injection detected. Sorry, You are not allowed to do that.</p>';
						break;
						case 5:
							$message = '<p id="messages" class="errormsg">FAILURE: Invalid security questions answer.</p>';
						break;
					}
				}
				
				echo $message;
				
				// reset session, just for pretty up the form :D
				$_SESSION['c_errorcode'] = 0;
			?>
		<div>			
			<form id="contact" action="<?php bloginfo('template_url'); ?>/kirimpesan.php" method="post">
			<label for="name">Your name: *</label><br />
			<input type="text" id="nameinput" name="name" value=""/><br />
			<label for="email">Your email: *</label><br />
			<input type="text" id="emailinput" name="email" value=""/><br />
			<label for="comment">Your message: *</label><br />
			<textarea cols="60" rows="10" id="commentinput" name="comment"></textarea><br />
			<!-- start captcha -->
			<label for="capcay">Sum of<img src="<?php bloginfo('template_url'); ?>/kirimpesan.php?captcha=generateimage" /> =</label><br />
			<input type="text" id="captchainput" name="captchacode" value="" /><br />
			<!-- end captcha --><br />
			<input type="submit" id="submitinput" name="submit" class="submit" value="Kirim Pesan"/><br />
			<strong>*</strong> Harus diisi.<br /><br />
			</form>
		</div>
		<!-- End Simple Contact ME Form by me[at]masedi[dot]net -->
</div>

<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

	</div>
	
	<?php if ( comments_open() ) comments_template(); ?>
		<?php endwhile; endif; ?>
		

<?php edit_post_link('Edit this entry.', '<p class="edit">', '</p>'); ?>
<?php get_footer(); ?>
