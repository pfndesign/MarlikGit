function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
function save_edit_my_post(i){
	$("#content"+i).html("<img src='images/loading.gif'/>");
	var text = $("textarea#this_message"+i).val();
	$.post("modules.php?name=Your_Account&op=broadcast&action=blog_edit",
	{op: "broadcast",action: "blog_edit", bid: i, this_message: text },
	function(data){
		alert("id:"+i+"m:"+text);
		$("#content"+i).html(data);
	});
}

function edit_my_post(i){
	$("#content"+i).html("<img src='images/loading.gif'/>");
	var username = $('.blog_username').attr('id');
	$.post("modules.php?name=Your_Account&op=edit_my_post",
	{op: "edit_my_post", bid: i, username: username },
	function(data){
		$("#content"+i).html(data);
	});
}
function slideright(i){
                $(this).hide('slide',{direction:'right'},1000);

    }
    
function cancel_reply(i){
	$("#content"+i).html("<img src='images/loading.gif'/>");
	$.post("modules.php?name=Your_Account&op=edit_my_post",
	{op: "edit_my_post", bid: i, cancel: 1 },
	function(data){
		$("#content"+i).html(data);
	});
}


function show_my_blog(i,b){
	$("#blog_page").html("<img src='images/loading.gif'/>");
	$.post("modules.php?name=Your_Account&op=show_my_blog",
	{op: "show_my_blog", blog_userid: i, page: b },
	function(data){
		$("#blog_page").html(data);
	});
}
function view_comments(i){
	$("#view_comments"+i).html("<img src='images/loading.gif'/>");
	var username = $('.BlogUsername').attr('title');
	$.post("modules.php?name=Your_Account&op=show_more_comments",
	{op: "show_more_comments", msg_id: i , username: username },
	function(data){
		$("#two_comments"+i).hide();
		$("#view_comments"+i).html(data);
	});
}
function view_comments_close(i){
	$("#all_comments").fadeOut(900);
	$("#two_comments"+i).show();
}

function refresh_blog(i){
	$("#blog_page").html("<img src='images/loading.gif'/>");
	$.post("modules.php?name=Your_Account&op=show_my_blog",
	{op: "show_my_blog", blog_userid: i },
	function(data){
		$("#blog_page").fadeIn('slow').html(data);
	});
}

function setting_blog(){
	$('#setting').slideToggle();
	$('#setting').css('display', 'block');
	$('#setting').load('modules.php?name=Your_Account&op=YAB_Setting');
}

function flush_blog(i){
	if(confirm("شما درخواست حذف کلیه مطالب وبلاگ را دارید .  آیا از انجام این کار اطمینان کامل دارید ؟"))
	{
		$.post("modules.php?name=Your_Account&op=flush_blog",
		{op: "flush_blog", blog_id: i },
		function(data){
			$("#blog_page").html(data);
		});
	}
	return false;
}



$(document).ready(function(){
	$("a.vote_up").click(function(){
		//get the id
		the_id = $(this).attr('id');

		// show the spinner
		$(this).parent().html("<img src='images/loading.gif'/>");

		//fadeout the vote-count
		$("#votes_count"+the_id).fadeOut("fast");

		//the main ajax request
		$.ajax({
			type: "POST",
			data: "action=vote_up&id="+$(this).attr("id"),
			url: "modules.php?name=Your_Account&op=VoteBlog",
			success: function(msg)
			{
				$("#votes_count"+the_id).html(msg);
				//fadein the vote count
				$("#votes_count"+the_id).fadeIn();
				//remove the spinner
				$("#vote_buttons"+the_id).remove();
			}
		});
	});

	$("a.vote_down").click(function(){
		//get the id
		the_id = $(this).attr('id');

		// show the spinner
		$(this).parent().html("<img src='images/loading.gif'/>");

		//the main ajax request
		$.ajax({
			type: "POST",
			data: "action=vote_down&id="+$(this).attr("id"),
			url: "modules.php?name=Your_Account&op=VoteBlog",
			success: function(msg)
			{
				$("#votes_count"+the_id).fadeOut();
				$("#votes_count"+the_id).html(msg);
				$("#votes_count"+the_id).fadeIn();
				$("#vote_buttons"+the_id).remove();
			}
		});
	});

	var max = 200;
	$("#the_message").keyup(function()
	{
		var box=$(this).val();
		var main = box.length *100;
		var value= (main / max);
		var count= max - box.length;

		if(box.length <= max)
		{
			$('#counter').html(count);
			$('#bar').animate(
			{
			"width": value+'%',
			}, 1);
		}
		if(
		box.length >= max)
		{
			$('#bar').css('background', '#EC1226');
		} else if (
		box.length > 170)
		{
			$('#bar').css('background', '#F8C137');
		}
		else {
			$('#bar').css('background', '#5fbbde');
		}

		return false;
	});



	$("#the_message").focus(function()
	{
		$(this).animate({"height": "85px",}, "fast" );
		$("#button_the_message").slideDown("fast");
		return false;
	});
	$("#cancel").click(function()
	{
		$("#the_message").animate({"height": "30px",}, "fast" );
		$("#button_the_message").slideUp("fast");
		$('#the_message').val(' ');
		return false;
	});



	function limits(obj, limit){

		var text = $(obj).val();
		var length = text.length;
		if(length > limit-1){
			$(obj).val(text.substr(0,limit));
			return false;
		} else { // alert the user of the remaining char. I do alert here, but you can do any other thing you like
			return true;
		}

	}


	$('#the_message').keyup(function(){

		limits($(this), 200);
	})


	$(".comment_button").click(function() {

		var element = $(this);

		var boxval = $("#the_message").val();
		if ($('#pm:checked').val() !== undefined) {
			var pm = 1;
		}else{
			var pm = 0;
		}

		var dataString = 'content='+ boxval+'&pm='+pm ;

		if(boxval=='')
		{
			alert("لطفا متنی وارد نمایید و سپس مجدد ارسال کنید");

		}
		else
		{

			$("#the_message").animate({"height": "30px",}, "fast" );
			$("#button_the_message").slideUp("fast");
			$('#the_message').val(' ');
			$("#flash").show();
			$("#flash").fadeIn(400).html('<img src="images/loading.gif" align="absmiddle"> وبلاگ');
			$.ajax({
				type: "POST",
				url: "modules.php?name=Your_Account&op=blog_post",
				data: dataString,
				cache: false,
				success: function(msg){

					$("ol#update").prepend(msg);
					$("ol#update li:first").slideDown("slow");
					$("#flash").hide();
					$("#noblogpost").hide();
					$('#the_message').value='';
				}
			});
		}
		return false;
	});

	//commment Submint

	$('.comment_submit').live("click",function()
	{

		var ID = $(this).attr("id");

		var comment_content = $("#textarea"+ID).val();

		var recipient = $("#rec_id"+ID).val();

		var dataString = 'comment_content='+ comment_content+ '&recipient='+ recipient+ '&bid='+ ID;

		if(comment_content=='')
		{
			alert("لطفا متنی وارد نمایید و سپس مجدد ارسال کنید");

		}
		else
		{


			$.ajax({
				type: "POST",
				url: "modules.php?name=Your_Account&op=blog_reply",
				data: dataString,
				cache: false,
				beforeSend : function () {
					$("#commentload"+ID).html("<img src='images/loading.gif'/>");
				},
				success: function(msg){
					$("#commentload"+ID).html(msg);
					document.getElementById("textarea"+ID).value='';
					$("#textarea"+ID).focus();
					$("#c"+ID).remove();



				}
			});


		}

		return false;
	});




	// delete undate

	$('.delete_update').live("click",function()
	{
		var ID = $(this).attr("id");

		var info = 'bid=' + ID;
		if(confirm("از حذف این پست اطمینان دارید ؟"))
		{
			$.ajax({
				type: "POST",
				url: "modules.php?name=Your_Account&op=blog_del",
				data: info,
				beforeSend : function (xhr) {
					$(".bar"+ID).html("<img src='images/loading.gif'/>");
				},
				success: function(data){
					$(".bar"+ID).slideUp();
					$(".bar"+ID).html(data);
				}
			});

		}
		return false;

	});

	//comment delete

	$('.cdelete_update').live("click",function()
	{
		var ID = $(this).attr("id");
		var info = 'bid=' + ID;
		if(confirm("از حذف این پست اطمینان دارید ؟"))
		{
			$.ajax({
				type: "POST",
				url: "modules.php?name=Your_Account&op=blog_del",
				data: info,
				beforeSend : function (xhr) {
					$("#comment"+ID).html("<img src='images/loading.gif'/>");
				},
				success: function(){
					$("#comment"+ID).slideUp();
					$(".bar"+ID).html(data);
				}
			});

		}
		return false;
	});

	//comment slide
	$('.comment').live("click",function()
	{
		var replytomsg = $(this).attr("title");
		var replytomsgtrns = $(this).attr("alt");
		var ID = $(this).attr("id");
		$(".fullbox"+ID).show();
		$("#c"+ID).slideToggle(300);
		alert
		document.getElementById("textarea"+ID).value='@'+replytomsgtrns+' : ';

		return false;
	});

	$('.editsend').live("click",function()	{
		var ID = $(this).attr("id");
		var edit_message = $("#edit_message"+ID).val();
		var dataString = 'op=broadcast&action=blog_edit&edit_message='+ edit_message+'&bid='+ID ;
		if(edit_message=='')
		{
			alert("لطفا متنی وارد نمایید و سپس مجدد ارسال کنید");
		}
		else
		{
			$.ajax({
				type: 'POST',
				url: 'modules.php?name=Your_Account',
				data: dataString,
				cache: false,
				beforeSend: function() {
					$("#content"+ID).html("<img src='images/loading.gif' />");
				},
				success: function(msg) {
					$("#content"+ID).html(msg);
				}
			});
		}
		return false;
	});

	var setting_user = $('.blog_password_div').attr("id");
	$('.blog_password_div').load('modules.php?name=Your_Account&op=YB_Password', {username: setting_user});


});

