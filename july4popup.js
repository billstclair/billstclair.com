// July 4 Popup
// Add the following to your page header to popup an upside-down US flag
// on the Fourth of July
//
//  <script type="text/javascript" src="http://billstclair.com/july4popup.js"></script>
function hideEtwofPopup() {
  var d = document.getElementById('etwof-popup');
  d.setAttribute('style','display:none;');
}
(function() {
  if (typeof(skipJuly4PopupDateCheck) == 'undefined') {
    var d = new Date();
    if (!(d.getDate()==4 && d.getMonth()==6)) return;
  }
  document.write("\
<div id='etwof-popup' style='width:100%;position:absolute;left:0;top:0;display:block;'>\n\
  <div style='width:60%;margin:0 auto;border-radius:7px;background:gray;margin:30px auto 0;padding:6px;'>\n\
    <div style='background:#fff;padding: 28px 26px 33px 25px;'>\n\
      <h1 style='text-align:center;margin:0;'>Turn Your Back This Fourth of July</h1>\n\
      <center>\n\
        <a href='http://ericpetersautos.com/2013/06/27/turn-your-back-this-fourth-of-july/'>\n\
          <img src='http://billstclair.com/blog/images/upside-down-us-flag.jpg' width='100%'>\n\
          <h2 style='text-align: center;margin: 0;'>We Are Not OK</h2>\n\
        </a>\n\
        <br>\n\
        <button onClick='hideEtwofPopup()'>Hide</button>\n\
      </center>\n\
    </div>\n\
  </div>\n\
</div>");
})();
