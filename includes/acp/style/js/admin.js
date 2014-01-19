function fancyalert(message){
		if ($("#alert").length > 0) {
			removeElement("alert");
		}
		var html = '<div id="alert">'+message+'</div>';
		$('body').append(html);
		$alert = $('#alert');
			if($alert.length) {
				var alerttimer = window.setTimeout(function () {
					$alert.trigger('click');
				}, 5000);
				$alert.css('border-bottom','4px solid #76B6D2');
				$alert.animate({height: $alert.css('line-height') || '50px'}, 200)
				.click(function () {
					window.clearTimeout(alerttimer);
					$alert.animate({height: '0'}, 200);
					$alert.css('border-bottom','0px solid #333333');
				});
			}
	}   

function language_updatelanguage(md5,id,file,lang) {
	var url = $('#form-'+md5).attr('action');
	var language = {};
	var Rawlang = {};
	$('#'+md5+' textarea').each(function(index,value) {
		language[index] = $(value).attr('value');	
		Rawlang[index] = $(value).attr('name');	
	})
	$.post(url+'&action=editlanguageprocess', {'action': 'editlanguageprocess','id': id, 'lang': lang, 'file': file, 'language': language, 'Rawlang': Rawlang}, function(data) {
		alert(data);

	});
	return false;
}

function searchtopics(){
	var eurl = $("form#searchtopicsform").attr("action");
	var stq = $("#stq").val();
	
		$.ajax({
				type: "POST",
				url: eurl,
				data: "stq="+stq,
				cache: false,
				beforeSend : function () {
					$("#topiclist").html("<img src='images/loading.gif'/>");
				},
				success: function(msg){
					$("#topiclist").html(msg);
				}
			});
	
	
}