<?php
class ThesaurusAPI {
	/*
	 * Altervista Thesaurus.com API
	 * http://thesaurus.altervista.org/testphp
	 * Sample Output:
		array(1) { ["response"]=> array(2) { [0]=> array(1) { ["list"]=> array(2) { ["category"]=> string(6) "(noun)" ["synonyms"]=> string(58) 
"Eden|paradise|Nirvana|promised land|Shangri-la|region|part" } } 
		[1]=> array(1) { ["list"]=> array(2) { ["category"]=> string(6) "(noun)" ["synonyms"]=> string(69) "Heaven|imaginary place|mythical 
place|fictitious place|Hell (antonym)" } } } } 
	 */
	 
	public $apikey = "YOtF2IEHwVUbV2JdCMwF"; // NOTE: replace test_only with your own key
	private $word = "peace"; // any word
	public $language = "en_US"; // you can use: en_US, es_ES, de_DE, fr_FR, it_IT
	public $endpoint = "http://thesaurus.altervista.org/thesaurus/v1";

	function spin_word($word) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "" .$this->endpoint. "?word=" .urlencode($word). "&language=" .$this->language. "&key=" .$this->apikey. 
"&output=json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch); 

		if ($info['http_code'] == 200) {
		  $result = json_decode($data, true);
		  /*
		  echo "Number of lists: ".count($result["response"])."<br>";
		  foreach ($result["response"] as $value) {
			echo $value["list"]["category"]." ".$value["list"]["synonyms"]."<br>";
		  }
		  */

		} else {
			//echo "Http Error: ".$info['http_code'];
			$result = $word;
		}
		
		return $result;
	}
}

$obj = new ThesaurusAPI();
$word = "nirvana";
$spinresult = $obj->spin_word($word);

//Extract result and get the synonyms only
if (is_array($spinresult)) {
	foreach ($spinresult["response"] as $key => $value) {
			$spinwords[$key] = $value["list"]["synonyms"];
	}
} else $spinwords[0] = $word;

//test output
echo "Replace this result to your source word: <br />$word = {".$spinwords[0]."}";
?>
