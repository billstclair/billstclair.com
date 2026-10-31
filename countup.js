/*
Author: Robert Hashemian
http://www.hashemian.com/

Modified to count up instead of down and to keep good time by:
Bill St. Clair
http://billstclair.com/

You can use this code in any manner so long as the author's
name, Web address and this disclaimer is kept intact.
********************************************************
Usage Sample:

<script type="text/javascript">
var StartDate = "11/07/2006 5:00 AM";
var LeadingZero = true;
vat DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
</script>
<script language="JavaScript" src="http://scripts.hashemian.com/js/countdown.js"></script>
*/

function calcage(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (LeadingZero && s.length < 2)
    s = "0" + s;
  return "<b>" + s + "</b>";
}

var lastnow = new Date("1/1/1000");

function CountBack() {
  var dthen = new Date(StartDate);
  var dnow = new Date();
  if (dnow == lastnow) return;
  lastnow = dnow;
  var ddiff = new Date(dnow-dthen);
  var secs = Math.floor(ddiff.valueOf()/1000);

  DisplayStr = DisplayFormat.replace(/%%D%%/g, calcage(secs,86400,1000000));
  DisplayStr = DisplayStr.replace(/%%H%%/g, calcage(secs,3600,24));
  DisplayStr = DisplayStr.replace(/%%M%%/g, calcage(secs,60,60));
  DisplayStr = DisplayStr.replace(/%%S%%/g, calcage(secs,1,60));

  document.getElementById("cntdwn").innerHTML = DisplayStr;
  if (CountActive) {
    setTimeout("CountBack()", 100);
  }
}

function putspan() {
  document.write("<span id='cntdwn'></span>");
}

if (typeof(StartDate)=="undefined")
  StartDate = "11/07/2006 9:30 PM PST";
if (typeof(DisplayFormat)=="undefined")
  DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
if (typeof(LeadingZero)=="undefined")
  LeadingZero = true;
if (typeof(CountActive)=="undefined")
  CountActive = true;

var SetTimeOutPeriod = 990;
putspan();
CountBack();
