/*=======================================================================
 STAR RATING V 1.0.0
 =======================================================================*/
/************************************************************************/
/* Coded By		:  www.boedesign.com			 	                    */
/* Ported By: Exoid - www.nuke-evolution.ir		                        */
/* Developed By: Exoid - www.nukelearn.com		                        */
/************************************************************************/

if (document.images){
  pic2 = new Image(25,75); 
  pic2.src = "includes/mods/rating/images/rating_star.png"; 

  pic3 = new Image(25,75); 
  pic3.src = "includes/mods/rating/images/rating_star.png"; 

}

// AJAX ----------------------------------------

var xmlHttp

function GetXmlHttpObject(){

var xmlHttp = null;

	try {
	  // Firefox, Opera 8.0+, Safari
	  xmlHttp = new XMLHttpRequest();
	  }
	catch (e) {
	  // Internet Explorer
	  try {
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
	  catch (e){
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
	  }
	  
	return xmlHttp;

}


// Calculate the rating
function rate(rating,id,show5,showPerc,showVotes,section){

	xmlHttp = GetXmlHttpObject()
	
	if(xmlHttp == null){
		alert ("Your browser does not support AJAX!");
		return;
	  }

	xmlHttp.onreadystatechange = function(){
		
	var loader = document.getElementById('loading_'+id);
	var uldiv = document.getElementById('ul_'+id);
	
		if (xmlHttp.readyState == 4){ 
			
			//loader.style.display = 'none';
			var res = xmlHttp.responseText;
			
			//alert(res);
var patt1=/already_voted/gi;
if(res.match(patt1)){
				
				loader.style.display = 'block';
				loader.innerHTML = '';
				rez = res.replace(patt1, "");
				alert(rez);
				

				
			} else {
				
				loader.style.display = 'block';
				loader.innerHTML = '';

				if(show5 == true){
					var out = document.getElementById('outOfFive_'+id);
					var calculate = res/20;
					out.innerHTML = Math.round(calculate*100)/100; // 3.47;
					//out.innerHTML = Math.round((calculate*2),0)/2; // 3.5;
				} 
				
				if(showPerc == true){
					var perc = document.getElementById('percentage_'+id);
					//var newPerc = Math.round(Math.ceil(res/5))*5;
					var newPerc = res;
					perc.innerHTML = newPerc+'%';
				}
				
				else if(showPerc == false){
					var newPerc = res;
				}
				
				if(showVotes == true){
					var votediv = document.getElementById('showvotes_'+id).firstChild.nodeValue;
					var splitted = votediv.split(' ');
					var newval = parseInt(splitted[0]) + 1;
					if(newval == 1){
						document.getElementById('showvotes_'+id).innerHTML = newval+' Vote';
					} else {
						document.getElementById('showvotes_'+id).innerHTML = newval+' Votes';
					}
				}
				
				var ulRater = document.getElementById('rater_'+id);
				ulRater.className = 'star-rating2';
				
				var all_li = ulRater.getElementsByTagName('li');
				
				// start at 1 because the first li isn't a star
				for(var i=1;i<all_li.length;i++){
					
					all_li[i].getElementsByTagName('a')[0].onclick = 'return false;';
					all_li[i].getElementsByTagName('a')[0].setAttribute('href','#');
					
				}
				
				if(navigator.appName == 'Microsoft Internet Explorer'){
					uldiv.style.setAttribute('width',newPerc+'%'); // IE
				 } else {
					uldiv.setAttribute('style','width:'+newPerc+'%'); // Everyone else
				 }
				
			}
		} else {
			loader.innerHTML = '<center><img src="images/loading.gif" alt="loading" /></center>';	
		}
	
	}
	var url = "modules.php?app=mod&name=rating";
	var params = "id="+id+"&rating="+rating+"&section="+section;
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", params.length);
	xmlHttp.setRequestHeader("Connection", "close");
	xmlHttp.send(params);

} 






// The cookie name to use for storing the blog-side comment session cookie.
var mtCookieName = "mt_blog_user";
var mtCookieDomain = window.location.hostname;
var mtCookiePath = "/";
var mtCookieTimeout = 14400;


function mtHide(id) {
    var el = (typeof id == "string") ? document.getElementById(id) : id;
    if (el) el.style.display = 'none';
}


function mtShow(id) {
    var el = (typeof id == "string") ? document.getElementById(id) : id;
    if (el) el.style.display = 'block';
}


function mtReplyCommentOnClick(parent_id, author) {
    mtShow('comment-form-reply');

    var checkbox = document.getElementById('comment-reply');
    var label = document.getElementById('comment-reply-label');
    var text = document.getElementById('comment-text');
    var replytratext = document.getElementById('replytratext');

    // Populate label with new values
    var reply_text = replytratext.value + ' \<a href=\"#comment-__PARENT__\" onclick=\"location.href=this.href; return false\"\>__AUTHOR__\<\/a\>';
    reply_text = reply_text.replace(/__PARENT__/, parent_id);
    reply_text = reply_text.replace(/__AUTHOR__/, author);
    label.innerHTML = reply_text;

    checkbox.value = parent_id; 
    checkbox.checked = true;
	oFormObject.elements["comment-reply"].value = parent_id;

    try {
        // text field may be hidden
        text.focus();
    } catch(e) {
    }

    mtSetCommentParentID();
}


function mtSetCommentParentID() {
    var checkbox = document.getElementById('comment-reply');
    var parent_id_field = document.getElementById('comment-parent-id');
    if (!checkbox || !parent_id_field) return;

    var pid = 0;
    if (checkbox.checked == true)
        pid = checkbox.value;
    parent_id_field.value = pid;
}