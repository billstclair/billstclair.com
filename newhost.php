<?php

function mq($x) {
  if (get_magic_quotes_gpc()) return stripslashes($x);
  else return $x;
}

$url = mq($_GET['url']);

?>
<html>
<head>
<title>Welcome to the new home of billstclair.com</title>
</head>
<body>
<p>You have been auto-forwarded to the new home of billstclair.com at <a href="http://hub.org/">hub.org</a></p>

<p>The domain name servers should be updated shortly, but until then, you can visit the page you were trying to get by clicking the link below:</p>

<p><a href="http://200.46.208.214<?php echo $url;?>">billstclair.com<?php echo $url;?></a>
</body>
</html>
