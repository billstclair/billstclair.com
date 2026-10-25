//autoblink.js

//<script language="Javascript">
// AutoBlink
// Puts Google's Autolink on the Blink :)
// (c) 2005 Chris Ridings   http://www.searchguild.com
// Redistribute at will but leave this message intact
// -
// 5th March - Implemented speed enhancement suggested by the guy who wrote
// http://www.dougaltoolbar.com/
// -
// 5th March - Added additional elements to reduce machine load
// 5th March - Added option to not remove links but to 
// rewrite ISBN links as amazon affiliate links!
// Fill in the following
// if you wish to do this. e.g.  var amazonaffiliate="goodlookingco-20"
// Leave as is to remove links in the normal way
function checklinks(){if(!(linkcount==document.links.length)){for(i=0;i<document.links.length;i++){if(document.links[i].id.substring(0,5)=="_goog"){if(amazonaffiliate==""){var e=document.links[i].parentTextEdit.createTextRange();e.moveToElementText(document.links[i]);e.execCommand("Unlink",false);e.execCommand("Unselect",false);i--}else{if(document.links[i].href.indexOf("isbn")>0){var t=document.links[i].href.substring(document.links[i].href.indexOf("text")+5,document.links[i].href.length);document.links[i].href="http://www.amazon.com/exec/obidos/external-search?search-type=ss&tag="+amazonaffiliate+"&keyword="+t+"&index=books"}}}}}linkcount=document.links.length;setTimeout("checklinks()",500)}var amazonaffiliate="abelardeducation";var linkcount;if(document.getElementById&&document.createElement){linkcount=document.links.length;setTimeout("checklinks()",500)}
//</script>