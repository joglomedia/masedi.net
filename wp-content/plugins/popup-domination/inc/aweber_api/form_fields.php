<?php

/*
   class deciphers a <form> and its field names and values from a given $html string

   can return data as array list
     ->form_to_data()

   or inject into browser/http object
     ->apply_form()

*/
class form_fields {



    // init HTTP_Request object from $HTML string
    function apply_form(&$browser, $HTML_form) {
    
       // get fields
       extract( $this->form_to_data($HTML_form) );
    
       // fill out browser object
       $browser->setMethod($method);
       $browser->setURL($url);
#       $browser->type($enctype);
       foreach ($data as $name=>$val) {
          foreach ($val as $value=>$desc) {
             if (strlen($name)) {
                $browser->setPostData($name, $value);
             }
          }
       }

    }



    // decode HTML <form> into browser object
    function form_to_data($HTML_form) {

       // extract from first <form> block
       if (preg_match("/<form.+?<\/form[^>]*>/ims", $HTML_form, $uu)) {
          $form = $uu[0];
          
          // fetch METHOD=
          if (preg_match("/<form[^>]+method=[\"']?(\w+)/ims", $form, $uu)) {
             $method = strtoupper($uu[1]);
          }
          else {
             $method = "GET";
          }
          // and URL=
          if (preg_match("/<form[^>]+?action=[\"']?([^\"'>\s]+)/ims", $form, $uu)) {
             $url = $uu[1];
          }
          else {
             $url = $browser->url;
          }

          // and type= if any
          if (preg_match("/<form[^>]+enctype=[\"']?([^\"'>\s]+)/ims", $form, $uu)) {
             $ct = $uu[1];
          }
          else {
             $ct = "application/x-www-form-urlencoded";
          }
          
          // getall fields
          $d = array();
          $d_possible = array();
          preg_match_all("/  (<input[^>]+>)  |  <select[^>]+>(.+?)<\/select  |  <textarea[^>]+>([^<]+)  /xims", $form, $matches);
    #print_r($matches);
    $zz=0;
          foreach ($matches[0] as $i=>$_full) {
          
             // general fields
             $name = "";
             $value = "";
             $type = "";
             $desc = "";
             $id = "";
             if (preg_match("/<[^>]+id=\"(.+?)\"[^>]*>/ims", $_full, $uu)) {
                $name = $uu[1];
             }
             if (preg_match("/<[^>]+name=\"(.+?)\"[^>]*>/ims", $_full, $uu)) {
                $id = $uu[1];
             }
             if (preg_match("/<[^>]+value=\"(.+?)\"[^>]*>/ims", $_full, $uu)) {
                $value = $uu[1];
             }
             if (preg_match("/<[^>]+type=\"(.+?)\"[^>]*>/ims", $_full, $uu)) {
                $type = strtolower($uu[1]);
             }
             if (preg_match("/<label[^>]+for=\"$name\"[^>]*>(.+?)<\/label>/ims", $_full, $uu)) {
                $desc = strip_tags($uu[1]);
             }
             $selected = preg_match("/<[^>]+\s(selected|checked)[=>\s]/ims", $_full, $uu);

             // input
             if (strlen($matches[1][$i])) {
             
                if (($type != "radio") or ($selected)) {
                   if($type == 'text'){
                   	$d[$zz]['id'] = "$name";
                   	$d[$zz]['name'] = "$id";
                   	$zz++;
                   }
                }
             }

             // select
             elseif (strlen($matches[2][$i])) {
                preg_match_all("/<option(?: [^>]+value=[\"']?([^\"'>]*)[^>]* )?>([^<]*)/xims", $_full, $uu);
                foreach ($uu[1] as $n=>$value) {

                   // either from value= or plain text following opening <option> tag
                   $desc = $uu[2][$n];
                   if (!$value) {
                      $value = $desc;
                   }
                   
                   // only add the allowed ones
                   if ($selected = preg_match("/<[^>]+\s(selected|checked)[=>\s]/ims", $uu[0][$n])) {
                      $d[$name][$value] = "";
                   }

                   // add possible values + desc              
                   $d_possible[$name][$value] = trim($desc);
                }
                continue; // but skip base
             }
             
             // textarea
             elseif (strlen($matches[3][$i])) {
                $value = $matches[3][$i];
                $d[$name][$value] = "$desc";
             }

             else {
                // ..
             }
             
             // add always
             $d_possible[$name][$value] = "$desc";
          }
       }
    #print_r($d);
    #print_r($d_possible);
    
       // multiple return values
       return array(
          "method" => $method,
          "url" => $url,
          "enctype" => $type,
          "data" => $d,
          "data_possible" => $d_possible,
       );
       
    }
    
    
    
}



?>