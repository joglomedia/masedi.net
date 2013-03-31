<?php

function wsc_gocodes_install() {

	//***Installer variables***
	global $wpdb;
	$table_name = $wpdb->prefix . "wsc_gocodes";
	$wsc_gocodes_db_version = "1.1.2";

	//***Installer***
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
			id mediumint(11) NOT NULL AUTO_INCREMENT,
			target varchar(255) NOT NULL,
			key1 varchar(255) NOT NULL,
			docount int(1) NOT NULL,
			hitcount mediumint(15) NOT NULL,
			UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . 'wp-admin/upgrade.php');
		dbDelta($sql);
		$demotarget = "http://www.webmaster-source.com/";
		$demokey = "webresources";
		$insert = "INSERT INTO " . $table_name . " (target, key1) " . "VALUES ('" . $wpdb->escape($demotarget) . "','" . $wpdb->escape($demokey) . "')";
		$results = $wpdb->query( $insert );
		add_option("wsc_gocodes_db_version", $wsc_gocodes_db_version);
		add_option("wsc_gocodes_url_trigger", "go");
	}

	//***Upgrader***
	$installed_ver = get_option( "wsc_gocodes_db_version" );
	if ( $installed_ver != $wsc_gocodes_db_version ) {
		$sql = "CREATE TABLE " . $table_name . " (
			id mediumint(11) NOT NULL AUTO_INCREMENT,
			target varchar(255) NOT NULL,
			key1 varchar(255) NOT NULL,
			docount int(1) NOT NULL,
			hitcount mediumint(15) NOT NULL,
			UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . 'wp-admin/upgrade.php');
		dbDelta($sql);
		update_option( "wsc_gocodes_db_version", $wsc_gocodes_db_version );
		if ($installed_ver < "1.1.2") { add_option("wsc_gocodes_url_trigger", "go"); }
		update_option("wsc_gocodes_url_trigger", "go");
	}

}

?>