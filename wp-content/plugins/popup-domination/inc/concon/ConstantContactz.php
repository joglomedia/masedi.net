<?php

class ConstantContact{
	
	private $apikey;
	private $username;
	private $userpass;
	private $authpass;
	
	public function __construct($apikey, $username, $userpassword){
		
		$this->api_key = $apikey;
		$this->user_name = $username;
		$this->user_password = $userpassword;
		$this->auth_pass = $apikey . "%" . $username . ":" . $userpassword;
		
	}
	
	public function __destruct(){
		
	}
	
	/*
	Returns an array containing information about the emails that have been previously sent form this account
	Last Send Date
	Subject
	Archive URL
	*/
	public function getListOfPreviousSentEmails(){
		
		//build the needed urls
		$campaignsURL = "https://api.constantcontact.com/ws/customers/{$this->user_name}/campaigns";
		$individualCampaignRootURL = "https://api.constantcontact.com/ws/customers/{$this->user_name}/campaigns/";
		
		//get all of the campaigns that have been sent and parse the id's
		$campaignRawInfo = $this->doCURLGet($campaignsURL);
		$campaignInfo = new SimpleXMLElement($campaignRawInfo);
		
		$campaignIDS = array();
		foreach($campaignInfo->entry as $campaign){
			
			if($campaign->content->Campaign->Status == "Sent"){
				$c_id_parts= explode( "/", $campaign->id );
				$c_id = $c_id_parts[ sizeOf($c_id_parts) - 1 ];
				array_push($campaignIDS, $c_id);
			}
			
		}
		
		//get all of the xml information for the individual id's
		$individualCampaignRawInfo = array();
		$i = 0;
		while( $i < (sizeOf($campaignIDS)) ){
			$curID = $campaignIDS[$i];
			$curURL = $individualCampaignRootURL . $curID;
			$curRawInfo = $this->doCURLGet($curURL);
			array_push($individualCampaignRawInfo, $curRawInfo);
			$i += 1;
		}
		
		//parse over the individual xml information and get the required info
		$finalInfo = array();
		$j = 0;
		while($j < (sizeOf($individualCampaignRawInfo)) ){
			
			$singleCampaign = array();
			$curXML = new SimpleXMLElement( $individualCampaignRawInfo[$j] );
			$singleCampaign['sent_date'] = $curXML->content->Campaign->LastRunDate;
			$singleCampaign['subject'] = $curXML->content->Campaign->Subject;
			$singleCampaign['archive_url'] = $curXML->content->Campaign->ArchiveURL;
			array_push($finalInfo, $singleCampaign);
			
			$j += 1;
		}
		
		return $finalInfo;
		
	}
	
	public function addContactToMailingList($emailAddressOfUser, $name, $custom1, $custom2, $cfield1, $cfield2,  $contactList){
		
		if(!isset($name) || empty($name)){
			$name =  '';
		}
		if(!isset($custom1) || empty($custom1)){
			$custom1 =  '';
		}
		if(!isset($custom2) || empty($custom2)){
			$custom2 =  '';
		}
		
		$contactURL = "https://api.constantcontact.com/ws/customers/{$this->user_name}/contacts";
		
		$contactListToAddTo = $contactList;
		
		$update_date = date("Y-m-d").'T'.date("H:i:s").'+01:00';
		
		$rawEntry = "<entry xmlns='http://www.w3.org/2005/Atom'></entry>";
		$xml_object = simplexml_load_string($rawEntry);
		$title_node = $xml_object->addChild("title", htmlspecialchars("TitleNode"));
		$updated_node = $xml_object->addChild("updated", htmlspecialchars($update_date));
		$author_node = $xml_object->addChild("author");
		$author_name = $author_node->addChild("name", htmlspecialchars($this->user_name));
		$id_node = $xml_object->addChild("id", "data:,none");
		$summary_node = $xml_object->addChild("summary", htmlspecialchars("Customer document"));
		$summary_node->addAttribute("type", "text");
		$content_node = $xml_object->addChild("content");
		$content_node->addAttribute("type", "application/vnd.ctct+xml");
		$contact_node = $content_node->addChild("Contact", htmlspecialchars("Customer document"));
		$contact_node->addAttribute("xmlns", "http://ws.constantcontact.com/ns/1.0/");
		$email_node = $contact_node->addChild("EmailAddress", urldecode(htmlspecialchars($emailAddressOfUser)));
		$name_node = $contact_node->addChild("FirstName", urldecode(htmlspecialchars($name)));
		if(isset($cfield1) && !empty($cfield1)){
			$custom1_node = $contact_node->addChild($cfield1, urldecode(htmlspecialchars($custom1)));
		}
		if(isset($cfield2) && !empty($cfield2)){
			$custom2_node = $contact_node->addChild($cfield2, urldecode(htmlspecialchars($custom2)));
		}
		$optin_node = $contact_node->addChild("OptInSource", htmlspecialchars('ACTION_BY_CONTACT'));
		$contactlists_node = $contact_node->addChild("ContactLists");
		$contactlist_node = $contactlists_node->addChild("ContactList");
		$contactlist_node->addAttribute("id", urldecode(htmlspecialchars($contactListToAddTo)));
		
		$entry = $xml_object->asXML();
		
		$curl_conn = curl_init($contactURL);
	    // Set up Basic authentication - username and password.
	    curl_setopt($curl_conn, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($curl_conn, CURLOPT_USERPWD, $this->auth_pass);
	    curl_setopt($curl_conn, CURLOPT_FOLLOWLOCATION  ,1);
	    curl_setopt($curl_conn, CURLOPT_POST, 1);
	    curl_setopt($curl_conn, CURLOPT_POSTFIELDS , $entry);
	    curl_setopt($curl_conn, CURLOPT_HTTPHEADER, Array("Content-Type:application/atom+xml"));
	    curl_setopt($curl_conn, CURLOPT_HEADER, 0);   // Do not return headers
	    curl_setopt($curl_conn, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt ($curl_conn, CURLOPT_SSL_VERIFYPEER, 0);
	    $response = curl_exec($curl_conn);
	    curl_close($curl_conn);
		return $response;

		//return true;
		
	}
	
	private function doCURLGet($requestURL){
		
		$request = $requestURL;

		$curl_conn = curl_init();

		curl_setopt($curl_conn, CURLOPT_URL, $request);
		curl_setopt($curl_conn, CURLOPT_GET, 1);
		curl_setopt($curl_conn, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl_conn, CURLOPT_USERPWD, $this->auth_pass);
		curl_setopt($curl_conn, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_conn, CURLOPT_RETURNTRANSFER, 1);

		$output = curl_exec($curl_conn);

		curl_close($curl_conn);
		
		return $output;
		
	}
	
}

?>