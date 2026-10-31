<?
/*
* PageForward v1.4
* by Joshua Dick
* http://pageforward.sourceforge.net
*
* If you did not download this file from Sourceforge.net, please redownload from
* http://sourceforge.net/project/showfiles.php?group_id=156341 to ensure that you have the lastest version.
*
* CHANGELOG:
* 01/15/05: PF v1.1-Initial public release.
* 10/05/05: PF v1.2-Fixed erratic '302 Moved' errors appearing when certain sites were viewed with the proxy.
* 10/25/05: PF v1.3-Improved CSS2 support.
* 12/29/05: PF v1.4-Improved HTML forms code handling (thanks to FlamingCows in ##PHP on Freenode.)
*
* README:
* PageForward (referred to as 'PF' for the remainder of this text) is a PHP program that will let you surf
* the web through a makeshift proxy (the web server the program runs on) to bypass things like internet
* content filters, or to browse the internet anonymously.
*
* INSTALLATION AND USAGE:
* Change the first two uncommented lines (the ones that start with dollar signs) below this information if
* you need to. Upload this file to a web server running PHP. Make sure the program has proper execute permissions.
* The program is used by going to http://your.webserver.com/[x.php]?url=[y] in a browser where [x.php] is the
* name of this file, and [y] is the URL of a site that you wish to view through the proxy. Links you click on
* will be 'redirected' through the proxy; things typed in the address bar of your browser will not (unless they
* appear after the 'url='.) Note that you can change the name of this .php file to anything you want.
*
* KNOWN BUGS/TODO:
* PF v1.4 partially eliminates the last known bug involving forms (there's probably still many unknown ones.)
* Cookies are still not supported; they might be in a future release.
*
* OTHER INFO:
* This program is released under the GNU Lesser GPL. It is a modified version of Simple Browser Proxy
* (located at http://sbp.sf.net) and I'd like to thank the original author for writing and freely distributing
* SBP and its source code. PF is free to use on its own, but if you are integrating it or part of it into your
* own program, please mention PF, the fact that it is released under the LGPL, and its home on the internet,
* http://pageforward.sourceforge.net.
*/

//**BEGIN USER CONFIG**
//Page to display by default (if no URL is supplied)
$default_url = "http://www.google.com";
//Tag to prepend page titles
$title_tag = "PF--";
//**END USER CONFIG**

$start_time = microtime();

//Finds the nth position of a string within a string (stolen from http://us3.php.net/strings)
function strnpos($haystack, $needle, $occurance, $pos = 0) {
	
	for ($i = 1; $i <= $occurance; $i++) {
		$pos = strpos($haystack, $needle, $pos) + 1;
	}
	return $pos - 1;
}

//URL parser that works better than PHP's built-in function
function parseURL($url)
{
	//protocol(1), auth user(2), auth password(3), hostname(4), path(5), filename(6), file extension(7) and query(8) //
	$pattern = "/^(?:(http[s]?):\/\/(?:(.*):(.*)@)?([^\/]+))?((?:[\/])?(?:[^\.]*?)?(?:[\/])?)?(?:([^\/^\.]+)\.([^\?]+))?(?:\?(.+))?$/i";
	preg_match($pattern, $url, $matches);
	
	$URI_PARTS["scheme"] = $matches[1];
	$URI_PARTS["host"] = $matches[4];
	$URI_PARTS["path"] = $matches[5];
	
	return $URI_PARTS;
}

//Turns any local URLs into fully qualified URLs
function completeURLs($HTML, $url)
{
	$URI_PARTS = parseURL($url);
	$path = trim($URI_PARTS["path"], "/");
	$host_url = trim($URI_PARTS["host"], "/");
	
	//$host = $URI_PARTS["scheme"]."://".trim($URI_PARTS["host"], "/")."/".$path; //ORIGINAL
	$host = $URI_PARTS["scheme"]."://".$host_url."/".$path."/";
	$host_no_path = $URI_PARTS["scheme"]."://".$host_url."/";
	
	//Make sure the host doesn't end in '//'
	$host = rtrim($host, '/')."/";
	
	//Replace '//' with 'http://'
	$pattern = "#(?<=\"|'|=)\/\/#"; //the '|=' is experimental as it's probably not necessary
	$HTML = preg_replace($pattern, "http://", $HTML);
	
	//Matches [src|href|background|action]="/ because in the following pattern the '/' shouldn't stay
	$pattern = "#(src|href|background|action)(=\"|='|=(?!'|\"))\/#i";
	$HTML = preg_replace($pattern, "\$1\$2".$host_no_path, $HTML);
	
	$pattern = "#(href|src|background|action)(=\"|=(?!'|\")|=')(?!http|ftp|https|\"|'|javascript:|mailto:)#i";
	$HTML = preg_replace($pattern, "\$1\$2".$host, $HTML);
	
	//Point all form actions back to the proxy
	$pattern = '/<form.+?action=\s*(["\']?)([^>\s"\']+)\\1[^>]*>/i';
	$replace = "<form action=\"{$_SERVER['PHP_SELF']}\"><input type=\"hidden\" name=\"original_url\" value=\"$2\">";
	$HTML = preg_replace($pattern, $replace, $HTML);	

	//Matches '/[any assortment of chars or nums]/../'
	$pattern = "#\/(\w*?)\/\.\.\/(.*?)>#ims";
	$replace = "/\$2>";
	$HTML = preg_replace($pattern, $replace, $HTML);
	
	//Matches '/./'
	$pattern = "#\/\.\/(.*?)>#ims";
	$replace = "/\$1>";
	$HTML = preg_replace($pattern, $replace, $HTML);
	
	//Handles CSS2 imports
	if (strpos($HTML, "import url(\"http") == false && (strpos($HTML, "import \"http") == false) && strpos($HTML, "import url(\"www") == false && (strpos($HTML, "import \"www") == false)) {
		$pattern = "#import .(.*?).;#ims";
		$mainurl = substr($host, 0, strnpos($host, "/", 3));
		$replace = "import '".$mainurl."\$1';";
		$HTML = preg_replace($pattern, $replace, $HTML);
	}
	return $HTML;
}

//Redirects link targets through this proxy
function proxyURLs($HTML)
{
	$edited_tag = "PF"; //used to check if the link has already been modified by the proxy
	
	//BASE tag needs to be removed for sites like yahoo.com
	//OR make the proxy insert the FULL URL to itself
	$pattern = "#\<base(.*?)\>#ims";
	$replacement = "<!-- <base\$1> -->"; //comment it out for now//
	$HTML = preg_replace($pattern, $replacement, $HTML);
	
	//edit <link tags so that 'edited="$edit_tag" ' is just before 'href'
	$pattern = "#\<link(.*?)(\shref=)#ims";
	$HTML = preg_replace($pattern, "<link\$1 edited=\"".$edited_tag."\"\$2", $HTML);
	
	//matches everything with a </a> after it on the same line....fails to match when that is on another line.
	$pattern = "#(?<!edited=\"".$edited_tag."\"\s)(href='|href=\"|href=(?!'|\"))(?=(.+)\</a\>)(?!mailto:|http://ftp|ftp|javascript:|'|\")#ims";
	$HTML = preg_replace($pattern, "edited=\"".$edited_tag."\" \$1".$_SERVER['PHP_SELF'].'?url=', $HTML);
	
	return $HTML;
}

//Calculates the differences in microtime captures
function microtime_diff($a, $b)
{
	
	list($a_dec, $a_sec) = explode(" ", $a);
	list($b_dec, $b_sec) = explode(" ", $b);
	return $b_sec - $a_sec + $b_dec - $a_dec;
}

//Get ready to display data...

$url = $_GET['url'];
if(empty($url)) $url = $default_url;

//Check the URL for protocol, etc....
if(substr($url, 0, 7) != "http://") //didn't start with 'http://'...we have a problem.
{
	$url = "http://".$url;
}

//Checks if there was a form redirected to this proxy.
if(!empty($_POST['original_url']))
{
	$form_submission = true;
}
else if(!empty($_GET['original_url']))
{
	//have to strip off any unwanted stuff from original_url
	$url = explode(" ", $_GET['original_url']);
	$url = $url[0];
	$form_submission = false;
	$url = urldecode($url)."?".str_replace("original_url=".urlencode($_GET['original_url'])."&", "", $_SERVER['QUERY_STRING']);
}
if(!$form_submission) //OK, no redirected form so go ahead and fetch a page.
{
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$page = curl_exec($ch);
	curl_close($ch);
	$HTML = $page;
	//$HTML = preg_replace("#\<TITLE\>#i", "<TITLE>".$title_tag, $HTML, 1);
	$HTML = preg_replace("#\<(title|TITLE)\>#", "<\$1>".$title_tag, $HTML, 1);
	$HTML = completeURLs($HTML, $url); //Complete local links so that they are fully qualified URIs
	$HTML = proxyURLs($HTML);  //Complete links so that they pass through this proxy
	print_r($HTML); //Output the page using print_r so that frames at least partially are written
	flush();
	
	//Calculate execution time and add HTML comment with that info
	$duration = microtime_diff($start_time, microtime());
	$duration = sprintf("%0.3f", $duration);
	echo ("\n<!-- PageForward v1.4 took $duration seconds to construct this page.-->");
}
?>