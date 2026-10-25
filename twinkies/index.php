<?php

  /*
   * Record a twinkie sent to Obama
   */

// $file is where the counter is kept.
$dir = "../protected/count";
$file = "$dir/counter.txt";
$visit_file = "$dir/visits.txt";

function mq($x) {
  if (get_magic_quotes_gpc()) return stripslashes($x);
  else return $x;
}

$host = $_SERVER['HTTP_HOST'];
$uri = dirname($_SERVER['REQUEST_URI']);

$count = mq($_REQUEST['count']);

$cnt = 0;

if ($count > 0) {
  $fp = @fopen($file, 'r+');
  if (!$fp) $fp = @fopen($file, 'w');
  if ($fp) {
    if (flock($fp, LOCK_EX)) {
      $cnt = @fread($fp, filesize($file)) + 1;
      fseek($fp, 0);
      fwrite($fp, $cnt);
    }
    fclose($fp);
  }
} else {
  $fp = @fopen($file, 'r');
  if ($fp) {
    if (flock($fp, LOCK_SH)) {
      $cnt = @fread($fp, filesize($file));
    }
    fclose($fp);
  }
}

$visits = 0;
$fp = @fopen($visit_file, 'r+');
if (!$fp) $fp = @fopen($visit_file, 'w');
if ($fp) {
  if (flock($fp, LOCK_EX)) {
    $visits = @fread($fp, filesize($visit_file)) + 1;
    fseek($fp, 0);
    fwrite($fp, $visits);
  }
  fclose($fp);
}

?>
<html>
<head>
<title>Twinkies for Obama</title>
</head>
<body>
<center>
<h2>Twinkies for Obama</h2>
To welcome him to his new job in style, please send a
<a href="http://www.hostesscakes.com/twinkies.asp">
Twinkie</a> to Obama.
<p>
Until he is sworn in on January 20, send it to his 
<a href="http://obama.senate.gov/">
Senate office</a>:
<p>
Twinkies for Obama<br/>
713 Hart Senate Office Building<br/>
Washington, DC 20510
<p>
<img src="twinkies-398x250.jpg" alt="Hostess Twinkies" width="398" height="250"/>
<img src="obama-197x250.jpg" alt="Barack Obama" width="197" height="250"/>
<p style="font-size: 125%;">
Twinkies sent: <b><? echo number_format($cnt); ?></b>
<p>
After you ship your Twinkie, click the button below.<br/>
<form method='post' action=''>
<input type='hidden' name='count' value='1'/>
<input style="font-weight: bold; font-size: 125%;" type='submit' name='sent' value='I SENT ONE'/>
</form>
<p>
<span style="font-size: 80%;">Donations support this site and <a href="http://FreedomOutlaws.com/">FreedomOutlaws.com</a></span>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
<p>
Visits since 6 November, 2008: <b><? echo number_format($visits); ?></b>
</body>
</html>
