<?
if(isset($_POST['api_key'])){
error_reporting(0);
if (!class_exists('jsonRPCClient', true)){
	require_once 'jsonRPCClient.php';
}
$api_key = $_POST['api_key'];

$api_url = 'http://api2.getresponse.com';


$client = new jsonRPCClient($api_url);

$result = NULL;
$var = 'Please enter all your details into the inputs above and please double check that they are correct.';

try {
	$var = '<span class="mailing-list-small">Your GetResponse Mailing Lists</span><select name="listsid" class="mailing_lists"  id="mc_lists">';
	$name = array();
    $result = $client->get_campaigns(
        $api_key
    );
    foreach($result as $r){
    	$name = $r['name'];
    	$result2 = $client->get_campaigns(
	        $api_key,
	        array (
	        	'name' => array ( 'EQUALS' => $name )
	        )
	    );
	    $CAMPAIGN_ID = array_pop(array_keys($result2));
	    $var .= '<option name="mc_'.$name.'" value="'.$CAMPAIGN_ID.'">'.$name.'</option>';
    }
    $var .= '</select>';
}
catch (Exception $e) {

    die($e->getMessage());
}

echo $var;

}else{
	echo 'Please enter all your details into the inputs above and please double check that they are correct.';
}

?>