//RATING + - 
$(document).ready(function() {

	$(".rating").children("[id^=up_]").click(function() {

        id = $(this).attr("id").split("_")[1];
        section =  jQuery(".rating").attr("id");
        jQuery('#rate_'+id).html('<div id="rate-loading"></div>');
        jQuery.get('modules.php', { app: "mod",name: "rating", action: "posneg", mode: "+1" , section: section, id: id },
        function(data) {
           jQuery('#rate_'+id).html(data);
        });
        return false;
    });    
    $(".rating").children("[id^=down_]").click(function() {
        id = $(this).attr("id").split("_")[1];
        section =  jQuery(".rating").attr("id");
        jQuery('#rate_'+id).html('<div id="rate-loading"></div>');
        jQuery.get('modules.php', { app: "mod",name: "rating", action: "posneg", mode: "-1" , section: section, id: id },
        function(data) {
           jQuery('#rate_'+id).html(data);
        });
        return false;
    }); 
    $(".cdeleteOnClick").click(function() {
        id = $(this).attr("id").split("_")[1];
        section =  jQuery(".rating").attr("id");
        jQuery('#rate_'+id).html('<div id="rate-loading"></div>');
        jQuery.get('modules.php', { app: "mod",name: "rating", action: "posneg", mode: "-1" , section: section, id: id },
        function(data) {
           jQuery('#rate_'+id).html(data);
        });
        return false;
    });
    
    $(".reply").click(function() {
    	$('html,body').animate({
    		scrollTop: $("#commentform").offset().top
    	}, 2000);
    });
    
});