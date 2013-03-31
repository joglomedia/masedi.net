<?php
	require_once( '../../../wp-load.php' );
	//require_once('wpsmagix.php');
	$wpsp = new wpsmagix();
	if(!isset($_POST['email']))
		echo 'No data submited.';
	else
	{	
		$email_address = $_POST['email'];
		$full_name = $_POST['full_name'];
		
		global $wpdb;
		
		if(!is_email($email_address))
			echo 'Invalid email address.';
		else
		{
			$table_name = $wpsp->tablemail;
			$count 		= $wpdb -> get_var($wpdb -> prepare("SELECT COUNT(*) FROM $table_name WHERE email = '%s'", $email_address));
			
			if($count == '0')
			{
                $full_name = strtolower(str_replace(' ', '_', $full_name));
			    $random_password = wp_generate_password( 12, false );
                $user_id = wp_create_user( $full_name, $random_password, $email_address );
			         
				if($wpdb -> query($wpdb -> prepare("INSERT INTO " . $table_name . "(full_name, email) VALUES('%s', '%s')",$full_name, $email_address)))
					echo 'Ok';
				else 
					echo 'error.';
			}
			else
				echo 'Ok';
		}
	}
?>

<script type="text/javascript">
	function closeWindow()
	{
		self.close();
	}	
	setTimeout(closeWindow, 1000);
</script>