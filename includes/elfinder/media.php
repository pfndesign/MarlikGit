<?php
/**
*
* @package Media center														
* @version $Id: Media.php 9:15 PM 1/5/2011 Aneeshtan $						
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
define('INSIDE_MOD',true);
require_once('./../../mainfile.php');
if (!defined("USV_VERSION")) {die("This only works on MarlikCMS Portal ,
<br>So why don't You join us<br><a href='http://www.MarlikCMS.com'>MarlikCMS.com</a>");}

global $admin,$currentlang;
if (is_admin($admin)){
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>فایل منیجر</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="../javascript/jquery/src/jquery-ui.css">
		<script type="text/javascript" src="../javascript/jquery/dist/jquery.min.js"></script>
		<script type="text/javascript" src="../javascript/jquery/src/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
<script type="text/javascript" charset="utf-8">
    // Helper function to get parameters from the query string.
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;
        
        return (match && match.length > 1) ? match[1] : '' ;
    }

    $().ready(function() {
        var funcNum = getUrlParam('media.php');

        var elf = $('#elfinder').elfinder({
            url : 'php/connector.php',
            getFileCallback : function(file) {
				alert("کپی شد داخل فرم اصلی 	ورودی :  <?php echo $_GET['id']?>  ");

				window.opener.document.getElementById("<?php echo $_GET['id']?>").value = file.replace('includes/elfinder/php/../../','includes/');
				window.close();
            },
            resizable: false
        }).elfinder('instance');
    });
</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
<?php
}else{
	die("<b>شما داخل مدیریت نیستید  . لطفا مجدد لاگین کنید 
	<br><a href='index.php'>ورود مجدد به مدیریت </a>
	</b>");
}
?>