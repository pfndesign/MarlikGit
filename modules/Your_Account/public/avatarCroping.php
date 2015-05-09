<?php
/**
*
* @package AvatarManagement System														
* @version $Id: 12:10 AM 7/21/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
*
* 
*/
?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='pragma' content='no-cache'>
<script src="modules/Your_Account/includes/style/EditAvatar.js" type="text/javascript"></script>
<?php
session_start();
//Do not remove this
//only assign a new timestamp if the session variable is empty
if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key'])==0) {
	$_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s'));
	//assign the timestamp to the session variable
	$_SESSION['user_file_ext']= "";
}
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
if (is_active("phpBB3")) {
	$avatar_dir = FORUMS_AVATAR_DIR."gallery";
	$upload_dir = FORUMS_AVATAR_DIR."upload";
} else {
	$avatar_dir = "modules/Your_Account/images";
	$upload_dir = "modules/Your_Account/images/upload";
}
$upload_path = $upload_dir."/";
// The path to where the image will be saved
$large_image_prefix = "resize_";
// The prefix name to large image
$thumb_image_prefix = "thumbnail_";
// The prefix name to the thumb image
$large_image_name = $large_image_prefix.$_SESSION['random_key'];
// New name of the large image (append the timestamp to the filename)
$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];
// New name of the thumbnail image (append the timestamp to the filename)
$max_file = "1";
// Maximum file size in MB
$max_width = "500";
// Max width allowed for the large image
$thumb_width = "128";
// Width of thumbnail image
$thumb_height = "128";
// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types);
// do not change this
$image_ext = "";
// initialise variable, do not change this.
foreach ($allowed_image_ext as $mime_type => $ext) {
	$image_ext.= strtoupper($ext)." ";
}
##########################################################################################################
# IMAGE FUNCTIONS																						 #
# You do not need to alter these functions																 #
##########################################################################################################
function resizeImage($image,$width,$height,$scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image);
			break;
		case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image);
			break;
	}
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
			imagegif($newImage,$image);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($newImage,$image,90);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$image);
			break;
	}
	chmod($image, 0777);
	return $image;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image);
			break;
		case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image);
			break;
	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
			imagegif($newImage,$thumb_image_name);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($newImage,$thumb_image_name,90);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);
			break;
	}
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}
//Image Locations
$large_image_location = $upload_path.$large_image_name.$_SESSION['user_file_ext'];
$thumb_image_location = $upload_path.$thumb_image_name.$_SESSION['user_file_ext'];
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_dir)) {
	mkdir($upload_dir, 0777);
	chmod($upload_dir, 0777);
}
//Check to see if any images with the same name already exist
if (file_exists($large_image_location)) {
	if(file_exists($thumb_image_location)) {
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name.$_SESSION['user_file_ext']."\" alt=\"Thumbnail Image\"/>";
	} else {
		$thumb_photo_exists = "";
	}
	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name.$_SESSION['user_file_ext']."\" alt=\"Large Image\"/>";
} else {
	$large_photo_exists = "";
	$thumb_photo_exists = "";
}
if (isset($_POST["upload"])) {
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$userfile_type = $_FILES['image']['type'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
	//Only process if the file is a JPG, PNG or GIF and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		foreach ($allowed_image_types as $mime_type => $ext) {
			//loop through the specified image types and if they match the extension then break out
			//everything is ok so go and check file size
			if($file_ext==$ext && $userfile_type==$mime_type) {
				$error = "";
				break;
			} else {
				$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
			}
		}
		//check if the file size is above the allowed limit
		if ($userfile_size > ($max_file*1048576)) {
			$error.= "Images must be under ".$max_file."MB in size";
		}
	} else {
		$error= "Select an image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0) {
		if (isset($_FILES['image']['name'])) {
			//this file could now has an unknown file extension (we hope it's one of the ones set above!)
			$large_image_location = $large_image_location.".".$file_ext;
			$thumb_image_location = $thumb_image_location.".".$file_ext;
			//put the file ext in the session so we know what file to look for once its uploaded
			$_SESSION['user_file_ext']=".".$file_ext;
			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);
			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width) {
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			} else {
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
		header("Location: modules.php?name=Your_Account&op=edituser");
		exit();
	}
}

//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0) {
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);
}
//Display error message if there are any
if(strlen($error)>0) {
	header("location: modules.php?name=Your_Account&op=edituser");
}


//-------Avatar Status  ---------------------
//--------------------------------------------
list($user_avatar,$user_avatar_type) = $db->sql_fetchrow($db->sql_query("select user_avatar,user_avatar_type  from ".__USER_TABLE." where username='".$userinfo['username']."'"));
//if Forums Avatar exists then there will be no need for our avatar system.
$forum_av_ext = explode("?",$user_avatar);
if(!empty($forum_av_ext[0]) AND file_exists(FORUMS_AVATAR_DIR.$forum_av_ext[0])) {
	echo '<p><center><img src="'.FORUMS_AVATAR_DIR.$forum_av_ext[0].'"></center><br>'._AVATAR_CHECKFORUMS.'<br>
	<img src="'.FORUMS_AVATAR_DIR.$forum_av_ext[0].'"></p>';
	exit;
}

if (is_writable($upload_dir)) {
	if (empty($_SESSION['user_file_ext']) AND (preg_match("/blank.gif/",$user_avatar) OR empty($user_avatar)) ) {
		echo '
	<div id="Form2upload" style="text-align:center;margin:0px auto;">
	<hr>
	<p style="text-align:right;"><img src="images/icon/help.png"></p><br>
	<h2>'. _YA_AVATAR_CREATE.'</h2>
	<form name="photo" enctype="multipart/form-data" action="modules.php?name=Your_Account&op=avatarCroping" method="post">
	<input type="file" name="image" id="uploadImage" size="30" style="border:1px solid #ccc;background:#EEEEEE" /> 
	<input type="submit" name="upload" id="upload"  class="send_upload" value="'._SEND.'" /> 
	</form>
	</div>
	<div id="showResult"></div>
	';
	} elseif (!empty($user_avatar) AND $user_avatar!="blank.gif" AND $user_avatar!="gallery/blank.gif" ) {
		$srcAvatar = ($user_avatar_type==2) ? "$user_avatar" : "$avatar_dir/$user_avatar";
		echo "<div id='uploadPic' style='padding:10px;margin:0px auto;text-align:center;'>
	<img src='$srcAvatar' style='border:1px solid #ccc;text-align:center;padding:10px;background:#EEEEEE;'>";
		echo '<p><img src="images/icon/cross.png"><a href="javascript:removeMyAvatar()" id="'.$srcAvatar.'"  class="delete_update"><b>'._DELETE.'</b></a>
	<p style="text-align:right;"><img src="images/icon/help.png">'._YA_AVATAR_LIVE_CROP.'</p>
	</div>';
	} else {
		?>
		<script src="<?php echo SCRIPT_PATH?>jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="modules/Your_Account/includes/style/EditAvatar.js" type="text/javascript"></script>
		<script src="modules/Your_Account/includes/style/jc/js/jquery.Jcrop.js" type="text/javascript"></script>
		<link rel="stylesheet" href="modules/Your_Account/includes/style/jc/css/jquery.Jcrop.css" type="text/css" />
		
		<script type="text/javascript">

		jQuery(function($){
				
		var jcrop_api;

		initJcrop();

		// The function is pretty simple
		function initJcrop()//{{{
		{
			$('#av_target').Jcrop({
				onChange:   showCoords,
				onSelect:   showCoords,
				aspectRatio: 2/2,
				minSize: [ <?php echo $thumb_width?>, <?php echo $thumb_width?> ],
				onRelease:  clearCoords
			},function(){

				jcrop_api = this;
				jcrop_api.animateTo([100,120,270,270]);
			});

		};

    function showCoords(c)
    {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#x2').val(c.x2);
      $('#y2').val(c.y2);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };
    function clearCoords()
    {
      $('#coords input').val('');
    };
    
});
  </script>
  
		<br><h3><?php echo _YA_AVATAR_CREATE;?></h3><br>
		<center>
		<img style="width:<?php echo $max_width?>;height:<?php echo $max_width?>"src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" id="av_target" alt="av_target" />
		</center>
		
			<form name="FormThumbnail" id="FormThumbnail" class="coords" onsubmit="return false;" action="modules.php?name=Your_Account&op=uploadThumbnail" method="post" >
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<br><center><input type="submit" name="upload_thumbnail" value="<?php echo _SAVE_THUMB;?>" style="font-size:15px;padding:5px;" /></center>
			</form>
	<p><img src="images/icon/help.png"><?php echo _YA_AVATAR_GUIDE_TO_CROP;?></p>
<br style="clear:both;"/>
<?php
	}
} else {
	if (is_admin($admin)) {
		echo "<div class='error' style='text-align:center;'>
			"._PERMISSION_CHANGE_TO_WRITABLE."  
			<b>$upload_dir</b>
			</div>";
	}
}
function uploadThumbnail() {
	global $thumb_width,$large_image_location,$thumb_image_location,$upload_dir,$large_image_prefix,$thumb_image_prefix,$thumb_height,$avatar_dir;
	global $db,$userinfo;
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x"];
	$y1 = $_POST["y"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	if ($w > 0 AND $h >0 ) {
		$scale = $thumb_width/$w;
	}else {
		$scale= 0;
	}

	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	$thumb_image_location2 = str_replace($avatar_dir."/", "", $thumb_image_location);
	$db->sql_query("UPDATE `nuke_bb3users` SET `user_avatar`='$thumb_image_location2',`user_avatar_type`='3',`user_avatar_width`='$thumb_width',`user_avatar_height`='$thumb_height' WHERE `username` = '".$userinfo['username']."'");
	$db->sql_query("UPDATE ".__USER_TABLE." SET `user_avatar`='$thumb_image_location2',`user_avatar_type`='3'  WHERE `username` = '".$userinfo['username']."'");
	@unlink($large_image_location);
}
function deleteThumbnail() {
	global $db,$userinfo,$large_image_location,$thumb_image_location;
	$db->sql_query("UPDATE `nuke_bb3users` SET `user_avatar`='',`user_avatar_type`='0' WHERE `username` = '".$userinfo['username']."'");
	$db->sql_query("UPDATE ".__USER_TABLE." SET `user_avatar`='' WHERE `username` = '".$userinfo['username']."'");
	$src = $_GET['src'];
	$src = sql_quote($src);
	if (file_exists($src)) {
		unlink($src);
	}
	@unlink($large_image_location);
	@unlink($thumb_image_location);
	setcookie("PHPSESSID", false);
	setcookie("PHPSESSID","",time()-31536000);
	//-1year
	session_destroy();
}
?>