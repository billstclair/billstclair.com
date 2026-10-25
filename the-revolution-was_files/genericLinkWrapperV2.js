if(null==idcomments_post_id)
	idcomments_post_id = idcomments_post_url;
if(null==idcomments_post_url)
	idcomments_post_url = window.location.href;
if(null==idcomments_post_id)
	idcomments_post_id = window.location.href;
	
if(idcomments_post_id.indexOf('#')>0)
	idcomments_post_id = idcomments_post_id.substr(0, idcomments_post_id.indexOf('#'));

if(document.getElementById("IDCommentsPostTitle"+idcomments_post_id))
	idcomments_post_title = document.getElementById("IDCommentsPostTitle"+idcomments_post_id).innerHTML;
else
	idcomments_post_title = "";

var commentScript = document.createElement("script");
commentScript.type = "text/javascript";
commentScript.src = "http://www.intensedebate.com/js/getCommentLink.php?acct="+idcomments_acct+"&postid="+id_clean_url(idcomments_post_id)+"&posturl="+id_clean_url(idcomments_post_url)+"&posttitle="+idcomments_post_title;
var scripts = document.getElementsByTagName("script");

var found=false;
for(var i=0; i<scripts.length; i++)
{
	//if(i==3)
		//alert(scripts[i].src + " - " + IDHost+"js/getCommentLink.php?acct="+acct+"&postid=$postid&posttitle=$posttitle&posturl=$posturl&src=blogger");
	if(scripts[i].src.indexOf("genericLinkWrapperV2.js")>=0)
	{
		parentObj = scripts[i].parentNode; 
		theObj = scripts[i];
		
		if(theObj.previousSibling && theObj.previousSibling.src && theObj.previousSibling.src.indexOf('getCommentLink.php?acct')>0)
			continue;
			
		found=true;
		break;
	}
}
if(found)
	parentObj.insertBefore(commentScript, theObj);

function id_clean_url ( url ) {
	return url.replace( /&/g, '%26' ).replace( /\?/g, '%3F' );
}
/*var thisdate = new Date();
var newImage = new Image();
newImage.src ="http://intensedebate.com/remoteCheckin.php?acct="+idcomments_acct+"&time="+thisdate.getTime();
newImage.style.display = "none";*/