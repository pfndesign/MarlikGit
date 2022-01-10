<?php
/**
*
* @package SITE MAP														
* @version $Id: XML 12:43 PM 3/5/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

require_once("mainfile.php");
global $prefix,$db,$sitename,$nextg,$slogan;
define('WRITE_IN_XML',true);
$module_name = "Site_Map";
get_lang($module_name);
define('IN_SITEMAP', true);
include_once("modules/".$module_name."/includes/functions.php");
$sm_config = sitemap_get_configs();

$out = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.USV_DOMAIN.'/includes/sitemap.xsl"?><!-- generator="MarlikCMS/1.1.4" -->
<!-- sitemap-generator-url="'.USV_DOMAIN.'" sitemap-generator-version="1.1.4" -->
<!-- generated-on="'.date('Y-m-d').'" -->
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">	<url>
		<loc>'.USV_DOMAIN.'</loc>
		<lastmod>'.date('Y-m-d') . '</lastmod>
		<changefreq>Daily</changefreq>
		<priority>1.0</priority>

	</url>
';


/*****[END]********************************************
[ Site Map:  Header                                  ]
******************************************************/



/*****[BEGIN]******************************************
[ Site Map:  Active Modules                          ]
******************************************************/

if ($sm_config['use_sommaire'] == 0) {

	$result = $db->sql_query("SELECT title FROM ".$prefix."_modules WHERE active = '1' ORDER BY custom_title");
	while($row = $db->sql_fetchrow($result)) {
		$title = $row['title'];
		$out .= "<url>";
		$al = "modules.php?name=$title";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= "<lastmod>".date('Y-m-d')."</lastmod>
			  <changefreq>never</changefreq>
			  <priority>1.0</priority>
			 </url>";

	}
	$db->sql_freeresult($result);
} else {
	$result = $db->sql_query("SELECT * FROM ".$prefix."_tree_elements ORDER BY Id");
	while($row = $db->sql_fetchrow($result)) {
		$name = $row['name'];
		$module = $row['module'];
		$link = explode("|",$row['link']);
		if($module != ""){
		$al = (($nextg==1) ? "".USV_DOMAIN."/\"modules.php?name=$module\"" : "".USV_DOMAIN."/modules.php?name=$module" );
		}elseif($link[0] != ""){
			if (preg_match("_http://_",$link[0])) {
				$al = $link[0];
			}else {
				//$al = USV_DOMAIN."/\"".$link[0]."\"";
			}
		}else{
			$al = "";
		}

		if (!empty($al)) {
			$out .= "
		 <url>
		  <loc>$al</loc>
		  <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>never</changefreq>
		  <priority>0.5</priority>
		 </url>";
		}
	}
	$db->sql_freeresult($result);
}
/*****[END]********************************************
[ Site Map:  Active Modules                          ]
******************************************************/

/*****[BEGIN]******************************************
[ Site Map:  STORY Content                          ]
******************************************************/
//
// News
//
if ($sm_config['show_news'] == 1) {
	$result = $db->sql_query("SELECT sid, title,time FROM ".$prefix."_stories ORDER BY sid DESC LIMIT ".$sm_config['limit_news']."");
	while($row = $db->sql_fetchrow($result)) {
		$out .= "<url>";
		$al = "modules.php?name=News&amp;file=article&amp;sid=".$row['sid']."&amp;title=".Slugit($row['title'])."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d',strtotime($row['time']))."</lastmod>
		  <changefreq>never</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}
//
// Downloads
//
if ($sm_config['show_downloads'] == 1) {
	$result = $db->sql_query("SELECT lid, title, date, description FROM ".$prefix."_nsngd_downloads ORDER BY lid DESC LIMIT ".$sm_config['limit_downloads']."");
	while($row = $db->sql_fetchrow($result)) {
		$lid = intval($row['lid']);
		$title = $row['title'];
		$out .= "<url>";
		$al = "modules.php?name=Downloads&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($title)."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d',strtotime($row['date']))."</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.5</priority>
		 </url>";
	}
	$db->sql_freeresult($result);
}


/*****[BEGIN]******************************************
[ Site Map:  RSS Feeds                               ]
******************************************************/
if ($sm_config['show_rss'] == 1) {

	if ($sm_config['show_news'] == 1) {

		$out .= "
		 <url>
		  <loc>".USV_DOMAIN."/feed.php?mod=News</loc>
		  <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>never</changefreq>
		  <priority>1.0</priority>
		 </url>";
	}
	// If you have more RSS feeds, just add them here on this line!
	if ($sm_config['show_forums'] == 1) {
		$out .= "
		 <url>
		  <loc>".USV_DOMAIN."/feed.php?mod=Forums</loc>
		  <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>never</changefreq>
		  <priority>1.0</priority>
		 </url>";
	}
	if ($sm_config['show_downloads'] == 1) {
		$out .= "
		 <url>
		  <loc>".USV_DOMAIN."/feed.php?mod=Downloads</loc>
		  <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>never</changefreq>
		  <priority>1.0</priority>
		 </url>";
	}
}

/*****[BEGIN]********************************************
[ Site Map:  Article Categories 			            ]
******************************************************/
//
// Categories
//
if ($sm_config['show_news'] == 1) {
	$result = $db->sql_query("SELECT * FROM ".$prefix."_topics  ORDER BY counter DESC LIMIT ".$sm_config['limit_news']."");
	while($row = $db->sql_fetchrow($result)) {
		$out .= "<url>";
		$al = "modules.php?name=News&amp;file=categories&amp;category=".$row['slug']."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}
/*****[BEGIN]********************************************
[ Site Map:  Article TAGS 			            ]
******************************************************/
//
// ARTICLE TAGS
//
if ($sm_config['show_news'] == 1) {
	$result = $db->sql_query("SELECT DISTINCT s.tags,t.* FROM `".$prefix."_tags` AS t
LEFT JOIN `".$prefix."_stories` AS s ON FIND_IN_SET(t.tid, REPLACE(s.tags, ' ', '-'))
WHERE t.count > 0
GROUP BY t.tag
ORDER BY t.count DESC LIMIT ".$sm_config['limit_news']."");
	while($row = $db->sql_fetchrow($result)) {
		$out .= "<url>";
		$al = "modules.php?name=News&amp;file=tags&amp;tag=".$row['slug']."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}

/*****[BEGIN]********************************************
[ Site Map:  Download TAGS 				            ]
******************************************************/
//
// ARTICLE TAGS
//
if ($sm_config['show_downloads'] == 1) {
	$result = $db->sql_query("SELECT DISTINCT dl.tags,t.* FROM `".$prefix."_tags` AS t
LEFT JOIN `".$prefix."_nsngd_downloads` AS dl ON FIND_IN_SET(t.tid, REPLACE(dl.tags, ' ', '-'))
WHERE t.count > 0
GROUP BY t.tag
ORDER BY t.count DESC LIMIT ".$sm_config['limit_downloads']."");
	while($row = $db->sql_fetchrow($result)) {
		$out .= "<url>";
		$al = "modules.php?name=Downloads&amp;op=tags&amp;term=".$row['slug']."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d')."</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}
/*****[BEGIN]********************************************
[ Site Map:  PAGES				            ]
******************************************************/
if ($sm_config['show_news'] == 1) {
	$result = $db->sql_query("SELECT * FROM ".$prefix."_extpages
ORDER BY `counter` DESC LIMIT ".$sm_config['limit_news']."");
	while($row = $db->sql_fetchrow($result)) {
		$slugortitle = (!empty($row['slug'])) ? "".$row['slug']."" : "".$row['pid']."";
		$out .= "<url>";
		$al = "modules.php?name=Pages&amp;term=$slugortitle";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d',strtotime($row['post_time']))."</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}
/*****[BEGIN]********************************************
[ BLOGS :  USERS							            ]
******************************************************/
//
if ($sm_config['show_supporters'] == 1) {
	$result = $db->sql_query("SELECT * FROM ".$prefix."_users  WHERE user_active='1'
ORDER BY `user_id`DESC LIMIT ".$sm_config['limit_supporters']."");
	while($row = $db->sql_fetchrow($result)) {
		$out .= "<url>";
		$al = "modules.php?name=Your_Account&amp;op=userinfo&amp;username=".$row['username']."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d',$row['user_lastvisit'])."</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}
/*****[BEGIN]********************************************
[ BLOGS :  USERS							            ]
******************************************************/
//
if ($sm_config['show_shouts'] ==1) {
	$result = $db->sql_query("SELECT * FROM ".$prefix."_blogs   WHERE tid='0'
ORDER BY `bid`DESC LIMIT ".$sm_config['limit_shouts']."");
	while($row = $db->sql_fetchrow($result)) {
		$out .= "<url>";
		$al = "modules.php?name=Your_Account&amp;op=show_post&amp;bid=".$row['bid']."";
		$out .= (($nextg==1) ? "<loc>".USV_DOMAIN."/\"$al\"</loc>" : "<loc>".USV_DOMAIN."/$al</loc>" );
		$out .= " <lastmod>".date('Y-m-d',strtotime($row['date']))."</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.5</priority>
		 </url>";

	}
	$db->sql_freeresult($result);
}

/*****[END]********************************************
[ Site Map:  RSS Feeds                              				 ]
******************************************************/
$out .= "\n</urlset>";


/*****[BEGIN]********************************************
[ Site Map:  WRITE IT DOWN IN A XML FILE              ]
******************************************************/
if(WRITE_IN_XML == true){
	$file = @fopen("sitemap.xml", "w");
	@fwrite($file, $out);
	@fclose($file);
}

/*****[END]********************************************
[ Site Map:  AT THE END JUST SHOW THE RESULT         ]
******************************************************/
header("Content-type: application/xml");
if ($nextg==1) {
	//GT_Universal_links($out); not exists
}else {
	echo $out;
}
?>