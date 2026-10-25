//navbars-btns.js 
<!--
function MM_preloadImages(){var e=document;if(e.images){if(!e.MM_p)e.MM_p=new Array;var t,n=e.MM_p.length,r=MM_preloadImages.arguments;for(t=0;t<r.length;t++)if(r[t].indexOf("#")!=0){e.MM_p[n]=new Image;e.MM_p[n++].src=r[t]}}}function MM_findObj(e,t){var n,r,i;if(!t)t=document;if((n=e.indexOf("?"))>0&&parent.frames.length){t=parent.frames[e.substring(n+1)].document;e=e.substring(0,n)}if(!(i=t[e])&&t.all)i=t.all[e];for(r=0;!i&&r<t.forms.length;r++)i=t.forms[r][e];for(r=0;!i&&t.layers&&r<t.layers.length;r++)i=MM_findObj(e,t.layers[r].document);if(!i&&t.getElementById)i=t.getElementById(e);return i}function MM_nbGroup(e,t){var n,r,i,s=MM_nbGroup.arguments;if(e=="init"&&s.length>2){if((r=MM_findObj(s[2]))!=null&&!r.MM_init){r.MM_init=true;r.MM_up=s[3];r.MM_dn=r.src;if((i=document[t])==null)i=document[t]=new Array;i[i.length]=r;for(n=4;n<s.length-1;n+=2)if((r=MM_findObj(s[n]))!=null){if(!r.MM_up)r.MM_up=r.src;r.src=r.MM_dn=s[n+1];i[i.length]=r}}}else if(e=="over"){document.MM_nbOver=i=new Array;for(n=1;n<s.length-1;n+=3)if((r=MM_findObj(s[n]))!=null){if(!r.MM_up)r.MM_up=r.src;r.src=r.MM_dn&&s[n+2]?s[n+2]:s[n+1]?s[n+1]:r.MM_up;i[i.length]=r}}else if(e=="out"){for(n=0;n<document.MM_nbOver.length;n++){r=document.MM_nbOver[n];r.src=r.MM_dn?r.MM_dn:r.MM_up}}else if(e=="down"){i=document[t];if(i)for(n=0;n<i.length;n++){r=i[n];r.src=r.MM_up;r.MM_dn=0}document[t]=i=new Array;for(n=2;n<s.length-1;n+=2)if((r=MM_findObj(s[n]))!=null){if(!r.MM_up)r.MM_up=r.src;r.src=r.MM_dn=s[n+1]?s[n+1]:r.MM_up;i[i.length]=r}}}
//-->

<!--
function MM_swapImgRestore(){var e,t,n=document.MM_sr;for(e=0;n&&e<n.length&&(t=n[e])&&t.oSrc;e++)t.src=t.oSrc}function MM_swapImage(){var e,t=0,n,r=MM_swapImage.arguments;document.MM_sr=new Array;for(e=0;e<r.length-2;e+=3)if((n=MM_findObj(r[e]))!=null){document.MM_sr[t++]=n;if(!n.oSrc)n.oSrc=n.src;n.src=r[e+2]}}
//-->

<!--
function update_frame(e){destination=e[e.selectedIndex].value;window.open(destination,"_self");e.selectedIndex=0;return true}
//-->