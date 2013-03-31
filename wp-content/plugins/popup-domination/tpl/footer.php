<div class="clear"></div>
<div id="popup_domination_form_submit">
	<p class="submit">
		<?php echo (isset($footer_fields) && !empty($footer_fields)) ? $footer_fields: ''; ?>
		<?php echo (isset($save_button) && !empty($save_button)) ? $save_button: ''; ?>
		<?php wp_nonce_field('update-options'); ?>
	</p>
	<?php echo ((isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'create'))) ? '<p><strong>Remember:</strong> You must check your Campaign Name before you can create a new campaign.</p>': ''; ?>
	
	<div id="popup_domination_current_version">
		<p>You are currently running <strong>version <?php echo $this->version; ?></strong></p>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	var popup_domination_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>', popup_domination_theme_url = '<?php echo $this->theme_url ?>', popup_domination_form_url = '<?php echo $this->opts_url ?>', popup_domination_url = '<?php echo $this->plugin_url ?>';
	<?php echo (isset($page_javascript) && $page_javascript != '') ? $page_javascript: ''; ?>
</script>