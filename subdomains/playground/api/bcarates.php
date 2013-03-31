<?php
/**
 * Plugin Name: Kurs Rupiah BCA
 * Plugin URI: http://masedi.net/wordpress/plugins/woocommerce-ipaymu-gateway.html
 * Description: Kurs BCA API - Indonesia Rupiah (IDR) Currency Rates based on Kurs BCA, Grab content from BCA web page and return a response in JSON or XML fromat.
 * Author: MasEDI
 * Author URI: http://masedi.net/
 * Version: 1.1
 * License: GPLv2 or later
 * Latest Update: 31/12/2012
 **/
 
/**
 * Change Logs
 *
 * 31/12/2012
 * - Get BCA rate and return result in JSON / XML
 *
 * 02/01/2013
 * - Add new parameter: date
 **/

$bca_kurs_url = 'http://www.bca.co.id/en/biaya-limit/kurs_counter_bca/kurs_counter_bca_landing.jsp';

/**
 * @get_kurs_bca
 *
 * $pageurl string url of kurs page
 * $format output format: JSON, XML
 **/
function get_kurs_bca($pageurl, $format='json') {

	$bca_rates = array();
	
	$date = gmt_date(7, "+", false) . " WIB";

	$html = file_get_contents($pageurl);

	// match table from bca kurs html web page
	$table = preg_match_all('#<table[^>]+>(.+?)</table>#ims', $html, $matches, PREG_SET_ORDER);

	// look for table containing Kurs
	$looked_table = $matches[1][0];

	// parse the table raw
	$t_row = preg_match_all('#<tr>(.+?)</tr>#ims', $matches[1][0], $tr_matches, PREG_SET_ORDER);

	if ($t_row) {

		foreach ($tr_matches as $i => $tr_match) {
		
			// parse the table raw data
			$t_data = preg_match_all('#<td[^>]+>(.+?)</td>#ims', $tr_match[1], $td_matches, PREG_SET_ORDER);

			if ($t_data) {
				$cur = trim($td_matches[0][1]);
				$sell_rate = trim($td_matches[1][1]);
				$buy_rate = trim($td_matches[2][1]);
				
				// debug
				//echo "Currency Code: ". $cur .", Sell Rate: " . $sell_rate . ", Buy Rate: " .$buy_rate. "<br />";
				
				// make result in array for JSON output
				$bca_rates[$cur] = array('Sell' => (float) $sell_rate, 'Buy' => (float) $buy_rate, 'Date' => $date);
				
				// make result for XML output
				$xml_body .= '
				<currency>
					<code>' .$cur. '</code>
					<sell>' .$sell_rate. '</sell>
					<buy>' .$buy_rate. '</buy>
					<date>' .$date. '</date>
				</currency>
				';
			}
			
		}
	}

	// return value
	// output the result as JSON
	$bca_rates_json = json_encode($bca_rates);
	$result = $bca_rates_json;

	$format = strtolower($format);
	switch ($format) {
		case 'json':
			return $result;
		break;
		
		case 'xml':
			// output the result as XML
			$bca_rates_xml = '<?xml version="1.0" encoding="utf-8"?>
			<!-- Created with My KursBCA - Indonesia Rupiah BCA Kurs API -->
			<rates>';
			$bca_rates_xml .= $xml_body;
			$bca_rates_xml .= '</rates>';
		
			return $bca_rates_xml;
		break;
		
		default:
			return $result;
		break;
	}
}

/**
 * @gmt_date make date in GMT format
 *
 * $offset Integer offset for time (hours)
 * $sign String direction from GMT to your timezone. + or -
 * $dst Boolean use daylight saving time or not
 * $datum Boolean
 * License: http://php.net/manual/en/function.gmdate.php#75772
 **/
function gmt_date($offset=1, $sign="+", $dst=true, $datum=true) {

	// if daylight saving time is true
	if ($dst == true) {
		$daylight_saving = date('I');
		if ($daylight_saving){
			if ($sign == "-"){ $offset = $offset-1;  }
			else { $offset = $offset+1; }
		}
	}
	
	$hm = $offset * 60;
	$ms = $hm * 60;
	
	if ($sign == "-"){ $timestamp = time()-($ms); }
	else { $timestamp = time()+($ms); }
	
	$gmdate = gmdate("d/m/Y H:i:s", $timestamp);
	
	if($datum == true) {
		return $gmdate;
	}
	else {
		return $timestamp;
	}
}

/* 
 * @save_result()
 * save decoded string in a file
 */
function save_kurs_result($data, $filename) {

	if ($fp = @fopen($filename, 'a')) {
		fwrite($fp, $data);
		fclose($fp);
		return true;
	} 
	else {
		return false;
	}
}

// test
if ( isset( $_GET['apikey'] ) && $_GET['apikey'] == 'asdfASDF1234' ) {
	
	$cur = strtoupper( $_GET['currency'] );
	$format = strtolower( $_GET['format'] );
	
	if (! empty($cur) ) {
	
		if ($cur == 'ALL') {
			$result = get_kurs_bca($bca_kurs_url, $format);
		} 
		else {
			$currencies = get_kurs_bca($bca_kurs_url, 'json');
			$currencies = json_decode($currencies, true);
			
			if ( ! empty ($currencies[$cur]) ) {

				if ($format == 'xml') {
					$result = '<?xml version="1.0" encoding="utf-8"?>
					<!-- Created with My KursBCA - Indonesia Rupiah BCA Kurs API -->
					<rates>
						<currency>
						<code>' .$cur. '</code>
						<sell>' .$currencies[$cur]['Sell']. '</sell>
						<buy>' .$currencies[$cur]['Buy']. '</buy>
						<date>' .$currencies[$cur]['Date']. '</date>
					</currency>
				</rates>';
				} 
				else {
				
					$rate = array();
					$rate[$cur] = $currencies[$cur];
					
					$result = json_encode($rate);
				}
			} 
			else {
				// do nothing
				$result = array('Status' => 0, 'Keterangan' => 'Kurs Tidak Ditemukan');
				$result = json_encode($result);
			}
		}
	} 
	else {
		// do nothing
		$result = array('Status' => -1, 'Keterangan' => 'Unknown');
		$result = json_encode($result);
	}
	
} 
else {
	// do nothing
	$result = array('Status' => -2, 'Keterangan' => 'Invalid API Key');
	$result = json_encode($result);
}

echo $result;
?>