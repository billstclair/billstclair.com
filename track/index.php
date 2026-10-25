<?php

function mq($x) {
  if (get_magic_quotes_gpc()) return stripslashes($x);
  else return $x;
}

function mqpost($x) {
  return mq($_POST[$x]);
}

function highlight($x) {
  "<span style=\"color: red; text-weight: bold;\">$x</span>";
}

$tracknum = mqpost('tracknum');
$save = mqpost('save');
$ups = mqpost('ups');
$fedex = mqpost('fedex');
$usps = mqpost('usps');

$saved_tracknum = $_COOKIE['tracknum'];
$input_tracknum = $tracknum;

$orig_save = $save;

$saved_save = $_COOKIE['save'];
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $tracknum = $saved_tracknum;
  $save = $saved_save;
}

if ($save) {
  if ($ups) $save = 'ups';
  elseif ($fedex) $save = 'fedex';
  elseif ($usps) $save = 'usps';
}

$urltracknum = urlencode($tracknum);
$hsctracknum = htmlspecialchars($tracknum);

if ($saved_save && !$save) {
  $time = time() - 3600;
  setcookie('save', '', $time);
  setcookie('tracknum', '', $time);
  $tracknum = $input_tracknum;
  $forward = '';
} elseif ($save) {
  $time = time() + 60*60*24*30;
  setcookie('save', $save, $time);
  setcookie('tracknum', $tracknum, $time);
}

if ($tracknum) {
  if ($fedex) {
    header("Location: http://www.fedex.com/Tracking?tracknumbers=$urltracknum");
    return;
  } elseif ($ups) {
    header("Location: http://wwwapps.ups.com/WebTracking/track?trackNums=$urltracknum&track.y=10");
    return;
  } elseif ($usps) {
    header("Location: http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum=$urltracknum");
    return;
  }
}

function button_style($type) {
  global $save;
  if ($save != $type) return '';
  return ' style="color: red; font-size: 120%; font-weight: bold;"';
}

//echo "save: $save, saved_save: $saved_save<br>\n";

?>
<html>
<head>
<title>Fast Package Tracking</title>
</head>
<body onload="document.forms[0].tracknum.focus();">
<h2>Fast Package Tracking</h2>

<p>A quick way to get package tracking for UPS, FedEx, or the US Postal Service. Gives you a bookmarkable URL that you can save for repeated use.</p>

<p>Paste your tracking number in the box, and click the button for your delivery service. More services added on request.</p>

<form action="" method="post">
<table border="0">
<tr><td>Tracking number:</td>
    <td><input type="text" size="50" name="tracknum" autocomplete="off" value="<?php echo $hsctracknum; ?>"/>
  <input type="checkbox" name="save" value="save"<?php if ($save) echo ' checked="checked"' ;?>/> Save</td></tr>
<tr><td></td>
  <td><input<?php echo button_style('ups'); ?> type="submit" name="ups" value="UPS""/>
    <input<?php echo button_style('fedex'); ?> type="submit" name="fedex" value="FedEx"/>
    <input<?php echo button_style('usps'); ?> type="submit" name="usps" value="USPS"/></td></tr>
</table>
</form>

<p>If you check the "Save" box, your tracking number and its type will be saved in your browser as cookies; they'll be restored the next time you visit this page.</p>

<p>This form does not track your submissions, though it does do standard Apache logging of your IP address and browser type. The server is in Panama.</p>

<p><a href="http://junecloud.com/software/mac/delivery-status.html">JuneCloud's Delivery Status</a> is a featureful tracking app for the Mac OS X Dock or iPhone.</p>

  <p><a href="http://www.packagetrackr.com/">Packagetrackr</a> has versions for the web, iPhone, Windows Sidebar, and IE8.</p>

  <p><a href="https://www.parcelmonitor.com/">Parcel Monitor</a> can track parcels from 475 carriers.</p>

<p>Author: Bill St. Clair &lt;bill at billstclair dot com>, 9 January, 2010</p>

<p><a href="viewtext.php?file=index.php">Source code</a><br>
<a href="../">Home</a></p>
</body>
</html>
