<?
include("xml.php");

class CurlRequest
{
    private $ch;
    /**
     * Init curl session
     *
     * $params = array('url' => '',
     *                    'host' => '',
     *                   'header' => '',
     *                   'method' => '',
     *                   'referer' => '',
     *                   'cookie' => '',
     *                   'post_fields' => '',
     *                    ['login' => '',]
     *                    ['password' => '',]     
     *                   'timeout' => 0
     *                   );
     */               
    public function init($params)
    {
        $this->ch = curl_init();
        $user_agent = 'Mozilla/5.0 (Windows; U;Windows NT 5.1; ru; rv:1.8.0.9) Gecko/20061206 Firefox/1.5.0.9';
        $header = array(
        "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
        "Accept-Language: ru-ru,ru;q=0.7,en-us;q=0.5,en;q=0.3",
        "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7",
        "Keep-Alive: 300");
        if (isset($params['host']) && $params['host'])      $header[]="Host: ".$host;
        if (isset($params['header']) && $params['header']) $header[]=$params['header'];
       
        @curl_setopt ( $this -> ch , CURLOPT_RETURNTRANSFER , 1 );
        @curl_setopt ( $this -> ch , CURLOPT_VERBOSE , 1 );
        @curl_setopt ( $this -> ch , CURLOPT_HEADER , 1 );
       
        if ($params['method'] == "HEAD") @curl_setopt($this -> ch,CURLOPT_NOBODY,1);
        @curl_setopt ( $this -> ch, CURLOPT_FOLLOWLOCATION, 1);
        @curl_setopt ( $this -> ch , CURLOPT_HTTPHEADER, $header );
        if ($params['referer'])    @curl_setopt ($this -> ch , CURLOPT_REFERER, $params['referer'] );
        @curl_setopt ( $this -> ch , CURLOPT_USERAGENT, $user_agent);
        if ($params['cookie'])    @curl_setopt ($this -> ch , CURLOPT_COOKIE, $params['cookie']);

        if ( $params['method'] == "POST" )
        {
            curl_setopt( $this -> ch, CURLOPT_POST, true );
            curl_setopt( $this -> ch, CURLOPT_POSTFIELDS, $params['post_fields'] );
        }
        @curl_setopt( $this -> ch, CURLOPT_URL, $params['url']);
        @curl_setopt ( $this -> ch , CURLOPT_SSL_VERIFYPEER, 0 );
        @curl_setopt ( $this -> ch , CURLOPT_SSL_VERIFYHOST, 0 );
        if (isset($params['login']) & isset($params['password']))
            @curl_setopt($this -> ch , CURLOPT_USERPWD,$params['login'].':'.$params['password']);
        @curl_setopt ( $this -> ch , CURLOPT_TIMEOUT, $params['timeout']);
    }
   
    /**
     * Make curl request
     *
     * @return array  'header','body','curl_error','http_code','last_url'
     */
    public function exec()
    {
        $response = curl_exec($this->ch);
        $error = curl_error($this->ch);
        $result = array( 'header' => '',
                         'body' => '',
                         'curl_error' => '',
                         'http_code' => '',
                         'last_url' => '');
        if ( $error != "" )
        {
            $result['curl_error'] = $error;
            return $result;
        }
       
        $header_size = curl_getinfo($this->ch,CURLINFO_HEADER_SIZE);
        $result['header'] = substr($response, 0, $header_size);
        $result['body'] = substr( $response, $header_size );
        $result['http_code'] = curl_getinfo($this -> ch,CURLINFO_HTTP_CODE);
        $result['last_url'] = curl_getinfo($this -> ch,CURLINFO_EFFECTIVE_URL);
        return $result;
    }
}

//////////////////////////////////////////////////////////////////////////////

//function DoSearch($service, $query, $language = 'en', $num_results = 10, $start_at = 0)
function DoSearch($service, $query, $language, $num_results, $start_at, $searchin)
{
	$excludedsites = '-site:xavier.se -site:xu.edu -site:xavier.edu -site:cstv.com -site:xula.edu';

	$results = array("numresults" => 0);

	$search = new CurlRequest();

	if ($service == "twittersearch")
	{
		$url = 'http://search.twitter.com/search.atom?lang='. $language .'&q='. urlencode($query);
		if ($num_results > 0)
		{
			$url .= '&rpp='. $num_results;
		}
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = '';
		$password = '';
		$footer = '<A HREF="http://twitter.com" REL="nofollow"><IMG SRC="http://search.twitter.com/images/powered-by-twitter-sig.gif" BORDER=0 ALT="Powered by Twitter" /></A>';
	}
	else if ($service == "yahoo")
	{
		$url = 'http://boss.yahooapis.com/ysearch/web/v1/'. urlencode($query .' '. $excludedsites) .'?format=xml&appid=Y5KeN0DV34Gwr0Hv1NVnulsrPQhX27WcRQOGMnT.c7PiITngQTGQgrexq3RiIlAAp.gt&start='. $start_at .'&count='. $num_results .'&lang='. $language;
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = '';
		$password = '';
	}
	else if ($service == "xavier")
	{
//		$url = 'http://boss.yahooapis.com/ysearch/web/v1/'. urlencode($query .' site:xaviermedia.com site:xaviermedia.net site:xavierseek.com -site:xavier.se -site:xu.edu -site:xavier.edu') .'?format=xml&appid=Y5KeN0DV34Gwr0Hv1NVnulsrPQhX27WcRQOGMnT.c7PiITngQTGQgrexq3RiIlAAp.gt&start='. $start_at .'&count='. $num_results .'';
		$url = 'http://boss.yahooapis.com/ysearch/web/v1/'. urlencode($query .' (site:xaviermedia.com OR site:xaviermedia.com OR site:xaviermedia.se OR site:xaviermedia.co.uk) '. $excludedsites) .'?format=xml&appid=Y5KeN0DV34Gwr0Hv1NVnulsrPQhX27WcRQOGMnT.c7PiITngQTGQgrexq3RiIlAAp.gt&start='. $start_at .'&count='. $num_results .'';
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = '';
		$password = '';
		$service = 'yahoo';
	}
	else if ($service == "news")
	{
		$url = 'http://boss.yahooapis.com/ysearch/news/v1/'. urlencode($query .' '. $excludedsites) .'?format=xml&appid=Y5KeN0DV34Gwr0Hv1NVnulsrPQhX27WcRQOGMnT.c7PiITngQTGQgrexq3RiIlAAp.gt&start='. $start_at .'&count='. $num_results .'&lang='. $language;
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = '';
		$password = '';
	}
	else if ($service == "images")
	{
		$url = 'http://boss.yahooapis.com/ysearch/images/v1/'. urlencode($query .' '. $excludedsites) .'?format=xml&appid=Y5KeN0DV34Gwr0Hv1NVnulsrPQhX27WcRQOGMnT.c7PiITngQTGQgrexq3RiIlAAp.gt&start='. $start_at .'&count='. $num_results .'&lang='. $language;
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = '';
		$password = '';
	}
	else if ($service == "spelling")
	{
		$url = 'http://boss.yahooapis.com/ysearch/spelling/v1/'. urlencode($query) .'?appid=Y5KeN0DV34Gwr0Hv1NVnulsrPQhX27WcRQOGMnT.c7PiITngQTGQgrexq3RiIlAAp.gt&format=xml';
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = '';
		$password = '';
	}
	else if ($service == "twitter")
	{
		$url = 'http://twitter.com/account/rate_limit_status.xml';
		$method = 'GET';
		$referer = '';
		$post_fields = '';
		$login = 'xaviermedia';
		$password = 'sc6241';
	}

	$params = array('url' => $url,
		'host' => '',
		'header' => '',
		'method' => $method, // 'POST','HEAD'
		'referer' => $referer,
		'cookie' => '',
	      'post_fields' => $post_fields,// 'var1=value&var2=value
		'timeout' => 20
	);
	if ($login != '')
	{        
	      $params["login"] = $login;
	      $params["password"] = $password;
	}


	$search->init($params);

	$result = $search->exec();

	$data = str_replace("&","ooOoo",$result['body']);
	$data = str_replace('<?xml version="1.0" encoding="UTF-8" ?>','',$data);
	$data = str_replace('<?xml version="1.0" encoding="utf-8"?>','',$data);

	///// Start XML
	$xml = xmlize($data); 


	$results["html"] = '';
	$results["xml"] = '';

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////// Twitter Search http://search.twitter.com ///////////////////////////////////
	if ($service == "twittersearch")
	{
		$entries = count($xml[feed]["#"]["entry"]);
		$results["numresults"] = $entries;

//		echo '<PRE>'. var_dump($xml[feed]) .'</PRE>';
		if ($entries > 0)
		{
			for($j = 0; $j < $entries; $j++) 
			{ 
				$title = str_replace("ooOoo","&",$xml[feed]["#"]["entry"][$j]["#"]["title"][0]["#"]); 

				$str = stristr($title,'http://');
				if ($str === FALSE)
				{
					$str = stristr($title,' www.');
					if ($str === FALSE)
					{



					}
					else
					{
						$str = substr($str,1,strlen($str));
						$strnum = strlen($str);
						$space = stristr($str,' ');
						if ($space === FALSE)
						{
							$url = $str;
						}
						else
						{
							$strnum = strlen($str);
							$spacenum = strlen($space);
							$url = substr($str,0,($strnum-$spacenum));
						}
						$title = str_replace($url,'<A HREF="http://'. $url .'" CLASS=gen TARGET="_blank"><FONT COLOR="#009900">'. $url .'</FONT></A>', $title);

					}



				}
				else
				{
					$space = stristr($str,' ');
					if ($space === FALSE)
					{
						$url = $str;
					}
					else
					{
						$strnum = strlen($str);
						$spacenum = strlen($space);
						$url = substr($str,0,($strnum-$spacenum));
					}
					$title = str_replace($url,'<A HREF="'. $url .'" CLASS=gen TARGET="_blank"><FONT COLOR="#009900">'. $url .'</FONT></A>', $title);

				}


				$picture = $xml[feed]["#"]["entry"][$j]["#"]["link"][1]["@"]["href"]; 
				$author = $xml[feed]["#"]["entry"][$j]["#"]["author"][0]["#"]["name"][0]["#"]; 
				$t = explode(' ',$author);
				$results["html"] .= '		<CENTER><TABLE CLASS=gen WIDTH="99%" CELLPADDING=0 CELLSPACING=0>
			<TR>
				<TD WIDTH=50 VALIGN=top ALIGN=right><A HREF="http://twitter.com/'. $t[0] .'" rel="nofollow"><IMG SRC="'. $picture .'" BORDER=0 ALT="'. $author .'" /></A></TD>
				<TD WIDTH=20 VALIGN=top ALIGN=right><IMG SRC="/images/bubble_2.png"></TD>
				<TD BGCOLOR="#eeeeee" COLSPAN=3 ALIGN=center>'. $title .' <A HREF="http://twitter.com/home?status=@'. $t[0] .'+" CLASS=gen rel="nofollow"><I>Reply</I></A></TD>
			</TR>
			<TR>
				<TD BGCOLOR="#FFFFFF" COLSPAN=4 CLASS=gensmall>&nbsp;</TD>
			</TR>
			</TABLE></CENTER>';

//				$text = str_replace('@'. $twitter_id .' ','',$xml[statuses]["#"]["status"][$j]["#"]["text"][0]["#"]); 
//				$screen_name = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["screen_name"][0]["#"]; 
//				$name = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["name"][0]["#"]; 
//				$short_name = explode(" ",$name); 
//				$short_name = $short_name[0];
//				$location = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["location"][0]["#"]; 
//				$description = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["description"][0]["#"]; 
//				$profile_image_url = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["profile_image_url"][0]["#"]; 
//				$url = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["url"][0]["#"]; 
//				$followers_count = $xml[statuses]["#"]["status"][$j]["#"]["user"][0]["#"]["followers_count"][0]["#"]; 
//				echo '<B>'. $title .'</B><BR>'. $author.'<BR>'. $picture .'<BR />';



			}
		}


	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////// Yahoo! Spelling Suggestions ////////////////////////////////////////////////
	else if ($service == "spelling")
	{
		if ($xml["ysearchresponse"]["#"]["resultset_spell"][0]["#"]["result"] > "0")
		{
			$spellingsuggestion = str_replace("ooOoo","&",$xml["ysearchresponse"]["#"]["resultset_spell"][0]["#"]["result"][0]["#"]["suggestion"][0]["#"]);
			if ($spellingsuggestion != $query)
			{ 
				$results["numresults"] = 1;
				$results["spelling"] = $spellingsuggestion;
				$results["html"] = '		<CENTER><TABLE CLASS=gen WIDTH="95%" CELLPADDING=0 CELLSPACING=0>
			<TR>
				<TD BGCOLOR="#cee7ef" COLSPAN=3 ALIGN=center>Did you mean <A HREF="/search.php?searchin='. $searchin .'&query='. urlencode($spellingsuggestion) .'&language='. $language .'" CLASS=gen><B><I>'. $spellingsuggestion .'</I></B></A>?</TD>
				<TD WIDTH=20 VALIGN=top ALIGN=right><IMG SRC="/images/bubble_1.png"></TD>
				<TD WIDTH=50 VALIGN=top ALIGN=right><A HREF="http://twitter.com/xaviermedia"><IMG SRC="http://s3.amazonaws.com/twitter_production/profile_images/51596032/xavier_125x125_normal.png" BORDER=0 ALT="Xavier Media" /></A></TD>
			</TR>
			<TR>
				<TD BGCOLOR="#FFFFFF" COLSPAN=4 CLASS=gensmall>&nbsp;</TD>
			</TR>
			</TABLE></CENTER>';
			}
			else
			{
				$results["html"] = '';
			}
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////// Yahoo! Search ////////////////////////////////////////////////////
	else if ($service == "yahoo")
	{
		$results["html"] = '';
		if ($xml["ysearchresponse"]["#"]["resultset_web"][0]["@"]["totalhits"] > "0")
		{
			$num = $xml["ysearchresponse"]["#"]["resultset_web"][0]["@"]["count"];
			$results["numresults"] = $xml["ysearchresponse"]["#"]["resultset_web"][0]["@"]["totalhits"];

			for ($i = 0; $i < $num; $i++)
			{
				$abstract 	=	$xml["ysearchresponse"]["#"]["resultset_web"][0]["#"]["result"][$i]["#"]["abstract"][0]["#"];
				$dispurl 	=	$xml["ysearchresponse"]["#"]["resultset_web"][0]["#"]["result"][$i]["#"]["dispurl"][0]["#"];
				$date 	=	$xml["ysearchresponse"]["#"]["resultset_web"][0]["#"]["result"][$i]["#"]["date"][0]["#"];
				$clickurl 	=	$xml["ysearchresponse"]["#"]["resultset_web"][0]["#"]["result"][$i]["#"]["clickurl"][0]["#"];
				$title 	=	$xml["ysearchresponse"]["#"]["resultset_web"][0]["#"]["result"][$i]["#"]["title"][0]["#"];
				$url 		=	$xml["ysearchresponse"]["#"]["resultset_web"][0]["#"]["result"][$i]["#"]["url"][0]["#"];
				$host		= 	parse_url($url);

				$results["html"] .= str_replace("ooOoo","&",'<P CLASS=gen><B><A HREF="'. $clickurl .'" rel="nofollow" CLASS=gen>'. $title .'</A></B><BR />'. $abstract .'<BR /><I><A HREF="'. $clickurl .'" rel="nofollow" CLASS=genmed><FONT COLOR="#009900">'. $dispurl .'</FONT></A></I> [<A HREF="javascript:LookUp(\''. $host[host] .'\');" CLASS=genmed><B>Look up site</B></A>]</P>');
				$results["xml"] .= str_replace("ooOoo","&",'<entry>
	<author>
		<name>XavierSeek.com</name>
		<uri>http://www.xavierseek.com/</uri>
	</author>
	<title type="html"><![CDATA['. $title .']]></title>
	<link rel="alternate" type="text/html" href="'. $clickurl .'" />
	<id>'. $dispurl .'</id>
	<updated>'. $date .'</updated>

	<published>'. $date .'</published>
	<summary type="html"><![CDATA['. $abstract .'[...]]]></summary>
	<content type="html" xml:base="'. $clickurl .'">'. $abstract .'</content>
</entry>');
			}
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////// Yahoo! News ////////////////////////////////////////////////////
	else if ($service == "news")
	{
		$results["html"] = '';
		if ($xml["ysearchresponse"]["#"]["resultset_news"][0]["@"]["totalhits"] > "0")
		{
			$num = $xml["ysearchresponse"]["#"]["resultset_news"][0]["@"]["count"];
			$results["numresults"] = $xml["ysearchresponse"]["#"]["resultset_news"][0]["@"]["totalhits"];

			for ($i = 0; $i < $num; $i++)
			{
				$abstract 	=	$xml["ysearchresponse"]["#"]["resultset_news"][0]["#"]["result"][$i]["#"]["abstract"][0]["#"];
				$dispurl 	=	$xml["ysearchresponse"]["#"]["resultset_news"][0]["#"]["result"][$i]["#"]["sourceurl"][0]["#"];
				$date 	=	$xml["ysearchresponse"]["#"]["resultset_news"][0]["#"]["result"][$i]["#"]["date"][0]["#"];
				$clickurl 	=	$xml["ysearchresponse"]["#"]["resultset_news"][0]["#"]["result"][$i]["#"]["clickurl"][0]["#"];
				$title 	=	$xml["ysearchresponse"]["#"]["resultset_news"][0]["#"]["result"][$i]["#"]["title"][0]["#"];
				$url 		=	$xml["ysearchresponse"]["#"]["resultset_news"][0]["#"]["result"][$i]["#"]["url"][0]["#"];

				$results["html"] .= str_replace("ooOoo","&",'<P CLASS=gen><B><A HREF="'. $clickurl .'" rel="nofollow" CLASS=gen>'. $title .'</A></B><BR />'. $abstract .'<BR /><I><A HREF="'. $url .'" rel="nofollow" CLASS=genmed><FONT COLOR="#009900">'. $dispurl .'</FONT></A></I></P>');
				$results["xml"] .= str_replace("ooOoo","&",'<entry>
	<author>
		<name>'. $dispurl .'</name>
		<uri>'. $dispurl .'</uri>
	</author>
	<title type="html"><![CDATA['. $title .']]></title>
	<link rel="alternate" type="text/html" href="'. $clickurl .'" />
	<id>'. $dispurl .'</id>
	<updated>'. $date .'</updated>

	<published>'. $date .'</published>
	<summary type="html"><![CDATA['. $abstract .'[...]]]></summary>
	<content type="html" xml:base="'. $clickurl .'">'. $abstract .'</content>
</entry>');
			}
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////// Yahoo! Images ////////////////////////////////////////////////////
	else if ($service == "images")
	{
		$results["html"] = '';
		if ($xml["ysearchresponse"]["#"]["resultset_images"][0]["@"]["totalhits"] > "0")
		{
			$num = $xml["ysearchresponse"]["#"]["resultset_images"][0]["@"]["count"];
			$results["numresults"] = $xml["ysearchresponse"]["#"]["resultset_images"][0]["@"]["totalhits"];
			if ($num_results > 10)
			{
				$results["html"] .= '<TABLE WIDTH="100%" BORDER=0>';
			}


			for ($i = 0; $i < $num; $i++)
			{
				$abstract 	=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["abstract"][0]["#"];
				$title 	=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["title"][0]["#"];
				$dispurl 	=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["refererclickurl"][0]["#"];
				$referurl 	=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["refererurl"][0]["#"];
				$clickurl 	=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["clickurl"][0]["#"];
				$url 		=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["url"][0]["#"];
				$th_w		=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["thumbnail_width"][0]["#"];
				$th_h		=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["thumbnail_height"][0]["#"];
				$th_url	=	$xml["ysearchresponse"]["#"]["resultset_images"][0]["#"]["result"][$i]["#"]["thumbnail_url"][0]["#"];

				if ($num_results > 10)
				{
					if ($i % 2 == 0)
					{
						$results["html"] .= '<TR>';
					}
					$results["html"] .= '<TD WIDTH="50%">';
				}
				$results["html"] .= str_replace("ooOoo","&",'<P CLASS=gen ALIGN=center><B>'. $title .'</B><BR /><A HREF="'. $dispurl .'" rel="nofollow" CLASS=gen><IMG SRC="'. $th_url .'" WIDTH="'. $th_w .'" HEIGHT="'. $th_h .'" BORDER=0 ALT="'. $abstract .'" /></A><BR /><A HREF="'. $dispurl .'" rel="nofollow" CLASS=gensmall><I><FONT COLOR="#009900">'. substr($referurl,0,40) .'</FONT></I></A></P>');
				if ($num_results > 10)
				{
					$results["html"] .= '</TD>';
					if ($i % 2 == 1)
					{
						$results["html"] .= '</TR>';
					}
				}
				$results["xml"] .= str_replace("ooOoo","&",'<entry>
	<author>
		<name>'. $dispurl .'</name>
		<uri>'. $dispurl .'</uri>
	</author>
	<title type="html"><![CDATA['. $title .']]></title>
	<link rel="alternate" type="text/html" href="'. $clickurl .'" />
	<id>'. $dispurl .'</id>
	<updated>'. $date .'</updated>

	<published>'. $date .'</published>
	<summary type="html"><![CDATA['. $abstract .'[...]]]></summary>
	<content type="html" xml:base="'. $clickurl .'">'. $abstract .'</content>
</entry>');
			}

			if ($num_results > 10)
			{
				$results["html"] .= '</TABLE>';
			}

		}
	}

	if ($results["html"] != '')
	{
		$results["html"] .= $footer;
	}
	return $results;

}
?>