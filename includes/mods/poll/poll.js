/**
 *
 * @package Jquery Survey system													
 * @version 1.0 Final $Aneeshtan  4:18 PM 2/10/2010	
 * @copyright (c)Marlik Group  http://www.nukelearn.com	Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)										
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

$(function() {
	var b=$("#poll_loader").html("<img src='images/loading.gif'>");
	var c=$("#pollcontainer");
	b.fadeIn();
	$.get("modules.php?app=mod&name=poll","",function(e,d) {
		c.find(".viewresult").click(function() {
			b;
			var ID = $(this).attr("id");
			$(this).html("<img src='images/loading.gif' />");
			$.get("modules.php?app=mod&name=poll", { result: "1", pollid: ID },function(g,f) {
				c.fadeOut(1000,function() {
					$(this).html(g);
					a(this)
				}
				);
				b.fadeOut()
			}
			);
			return false
		}
		).end().find("#pollform").submit(function() {
				b;
				$.post("modules.php?app=mod&name=poll",$(this).serialize(),function(h,g) {
					$("#formcontainer").fadeOut(100,function() {
						$(this).html("<img src='images/loading.gif' />");
						$(this).html(h);
						a(this);
						b.fadeOut()
					}
					)
				}
				)
			return false
		}
		);
		b.fadeOut()
	}
	);
	function a(d) {
		$(d).find(".bar").hide().end().fadeIn("slow",function() {
			$(this).find(".bar").each(function() {
				var e=$(this).css("width");
				$(this).css("width","0").animate( {
					width:e
				}
				,1000)
			}
			)
		}
		)
	}
}
);