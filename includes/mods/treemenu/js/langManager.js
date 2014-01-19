// language class

function languageManager() {
		
	this.load = function(lang) {
		this.lang = lang
		this.url = location.href.substring(0, location.href.lastIndexOf('/'));
		
		document.write("<script language='javascript' src='includes/mods/treemenu/js/langs/fa.js'></script>");
	}
	
	this.addIndexes= function() {
		for (var n in arguments[0]) { 
			this[n] = arguments[0][n]; 
		}
	}	
}