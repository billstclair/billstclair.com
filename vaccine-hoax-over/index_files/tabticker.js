/*-----------------------------------------------------------------------------------*/
/* featured slider #2 - SET! */
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($){
	$('#slides').slides({ preload: true, play: 5000, pause: 2500, hoverPause: true, animationStart: function(current){ $('.caption').animate({ 	bottom:-35 },100); if (window.console && console.log) { console.log('animationStart on slide: ', current); }; }, animationComplete: function(current){ 
 $('.caption').animate({ bottom:0 },200); if (window.console && console.log) { console.log('animationComplete on slide: ', current); }; }, slidesLoaded: function() { $('.caption').animate({ bottom:0 },200); } }); 
 
     


 

/*-----------------------------------------------------------------------------------*/
/* NewsTicker - SET! */
/*-----------------------------------------------------------------------------------*/
 

/*-----------------------------------------------------------------------------------*/
/* Missle Is Ready! */
/*-----------------------------------------------------------------------------------*/

	$('<select />').appendTo('#mobile-menu');

$('<option />', {
    'selected': 'selected',
    'value'   : '',
    'text'    : 'Navigate...'
}).appendTo('#mobile-menu select');

$('.menu a').each(function() {
    var el = $(this);
    if(el.parents('.sub-menu').length) {
        $('<option />', {
            'value': el.attr('href'),
            'text':  '— ' + el.text()
        }).appendTo('nav select');
    } else {
        $('<option />', {
            'value': el.attr('href'),
            'text': el.text()
        }).appendTo('nav select');
    }
});
 
$('#mobile-menu select').change(function() { 
    window.location = $(this).find('option:selected').val();
});

			$('#once').list_ticker({
			speed:3500,
			effect:'slide'
		});	


	/* TABS */
	 $(".tab_content").hide(); $("ul.tabs li:first").addClass("active").show(); $(".tab_content:first").show(); 
	 $("ul.tabs li").click(function() {
		  $("ul.tabs li").removeClass("active"); $(this).addClass("active"); $(".tab_content").hide(); var activeTab = $(this).find("a").attr("href"); $(activeTab).fadeIn(); return false;	
	 }); 
	
	
});	

 
  

