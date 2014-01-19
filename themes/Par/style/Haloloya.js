$(function() {

	$("div.block-head").hover(function() {
		$(this).addClass("block_title_hover")
	}
	,function() {
		$(this).removeClass("block_title_hover")
	}
	);
	$("div.story-topBox").click(function() {
		$(this).next().slideToggle("fast")
	}
	);
	$("div.block-head").click(function() {
		$(this).next().slideToggle("fast")
	}
	);
	$("div.rbtopDiv").click(function() {
		$(this).next().slideToggle("fast")
	}
	)
}
);
$(function() {
	$(".openThis").click(function() {
		$("#form_box").addClass("form_box")
	}
	,function() {
		$("#form_box").removeClass("form_box")
	}
	);
	$(".openThis").click(function() {
		$("#form_box").slideToggle("fast")
	}
	)
}
);
$(document).ready(function() {
	$("ul#topnav li").hover(function() {
		$(this).css( {
			background:"#B7372E url(themes/Classio-Mac/images/active-nav.png) repeat-x"
		}
		);
		$(this).find("span").show()
	}
	,function() {
		$(this).css( {
			background:"none"
		}
		);
		$(this).find("span").hide()
	}
	)
}
);
$(document).ready(function() {
	$("ul.subnav").parent().append("<span></span>");
	$("ul.topnav li span").hover(function() {
		$(this).parent().find("ul.subnav").slideDown("fast").show();
		$(this).parent().hover(function() {
		}
		,function() {
			$(this).parent().find("ul.subnav").slideUp("slow")
		}
		)
	}
	).hover(function() {
		$(this).addClass("subhover")
	}
	,function() {
		$(this).removeClass("subhover")
	}
	)
}
);