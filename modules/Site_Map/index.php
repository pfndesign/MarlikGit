<?php
if (!defined('MODULE_FILE')) {
   die ("You can't access this file directly...");
}

require_once("mainfile.php");

//include("header.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
define('IN_SITEMAP', true);
include_once("modules/".$module_name."/includes/functions.php");
$sm_config = sitemap_get_configs();
if (!$sm_config OR empty($sm_config)) {
    include_once("header.php");
    title(_SM_DBCONFIG);
    include_once("footer.php");
    die();
}
global $prefix,$nextg,$db;

/*****[BEGIN]******************************************
 [ Site Map:  Header                                  ]
 ******************************************************/

if ($sm_config['match_theme'] == 1) {
     include_once("header.php");
      OpenTable();
}else {
	
$metasitemap = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
$metasitemap .= "<html>\n";
$metasitemap .= "<head>\n";
$metasitemap .= "<title>".$sitename." <b>&raquo; نقشه سایت</b></title>\n";
include_once("includes/meta.php");
$metasitemap .= "<base target=\"_top\">\n";
$metasitemap .= "</head>\n";
$metasitemap .= "<body bgcolor=\"#ffffff\">\n"; // (hardcoded due to Google's white background)
$metasitemap .= '<link rel="StyleSheet" href="modules/'.$module_name.'/includes/style.css" type="text/css" />';
echo $metasitemap;
sitemap_copy();
}

/*****[END]********************************************
 [ Site Map:  Header                                  ]
 ******************************************************/




//---- Google Tab system ----
if ($sm_config['use_gt'] == 1) {
      if (function_exists('nextGenTap')) {
            if ($nextg = 1) {
                  nextGenTap(1,0,0);
            }
      }
}

/*****[BEGIN]******************************************
 [ Site Map:  Titles                                  ]
 ******************************************************/
echo "<b><center><a href=\"".$nukeurl."\">".$sitename."</a></center></b>";
echo "<b><center>".$slogan."</center></b>";
/*****[END]********************************************
 [ Site Map:  Titles                                  ]
 ******************************************************/

/*****[BEGIN]******************************************
 [ Site Map:  Google Web & Domain Search              ]
 ******************************************************/
if ($sm_config['show_google_block'] == 1) {

      $domainGoogle = $nukeurl;         // Domain of your web page where google has to search
      $webGoogle = $nukeurl;            // Your web page URL

      //Logo path
      $logoGoogle = "".$nukeurl."/".$sm_config['site_logo_path'] . $sm_config['site_logo']."";



      echo "<!-- Powered by evolved-Systems.net Google SiteSearch -->"
               ."<center><form method=\"get\" action=\"http://www.google.com/custom\" target=\"google_window\">"
                 ."<table align=\"center\"  style='font-size:13px;'>"

                   ."<tr>"
                     ."<td align=\"center\"><input type=\"hidden\" name=\"domains\" value=\"".$nukeurl."\"><a href=\"http://www.google.com/\">"
                     ."<img src=\"".$sm_config['google_logo_path'] . $sm_config['google_logo']."\" border=\"0\" alt=\"Google\"></a>"
                     ."<input type=\"text\" name=\"q\" style='width:70%' maxlength=\"255\" value=\"\"><input type=\"submit\" name=\"sa\" value=\""._SEARCH."\"></td>"
                   ."</tr>"
                   ."<tr>"
                     ."<td align=\"center\">"._SM_GOOGLE."</td>"
                   ."</tr>"
                   ."<tr>"
                     ."<td align=\"center\">"
                       ."<input type=\"radio\" name=\"sitesearch\" value=\"\" checked=\"checked\"> Web "
                       ."<input type=\"radio\" name=\"sitesearch\" value=\"".$nukeurl."\"> ".$sitename.""
                     ."</span>"
                       ."<input type=\"hidden\" name=\"client\" value=\"pub-2213784782027146\">"
                       ."<input type=\"hidden\" name=\"forid\" value=\"1\">"
                       ."<input type=\"hidden\" name=\"channel\" value=\"1795587205\">"
                       ."<input type=\"hidden\" name=\"ie\" value=\"utf-8\">"
                       ."<input type=\"hidden\" name=\"oe\" value=\"utf-8\">"
                       ."<input type=\"hidden\" name=\"cof\" value=\"GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:".$sm_config['google_bg'].";LBGC:".$sm_config['google_header'].";ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;LH:".$sm_config['site_google_logo_height'].";LW:".$sm_config['site_google_logo_width'].";L:".$logoGoogle.";S:".$nukeurl.";FORID:1;\">"
                       ."<input type=\"hidden\" name=\"hl\" value=\"en\">"
                     ."<br /></td></tr>"
                 ."</table>"
               ."</form></center>"
               ."<!-- Powered by evolved-Systems.net Google SiteSearch -->";
}
/*****[END]********************************************
 [ Site Map:  Google Web & Domain Search              ]
 ******************************************************/

/*****[BEGIN]******************************************
 [ Site Map:  Active Modules                          ]
 ******************************************************/
echo "<img src=\"images/icon/house.png\"><a href=\"http://".$nukeurl."\">"._SM_HOME."</a><br /><br />";

echo "<b>&raquo; "._SM_ACTIVE_MODULES.":</b>";

if ($sm_config['use_sommaire'] == 0) {
      if ($sm_config['use_gt'] = 0) {
            $result = $db->sql_query("SELECT title, custom_title FROM ".$prefix."_modules WHERE active = '1' ORDER BY custom_title");
            while($row = $db->sql_fetchrow($result)) {
                  $title = $row['title'];
                  $custom_title = $row['custom_title'];
                  echo "<li><a href=\"modules.php?name=".$title."\"><img src='images/icon/folder.png'>".langit($custom_title)."</a></li><br />";
            }
            $db->sql_freeresult($result);
      } else {
            // GoogleTap installed? If so use the GT equivalents ;)
            if (function_exists('nextGenTap')) {
                  if ($nextg = 1) {
            $result = $db->sql_query("SELECT title, custom_title FROM ".$prefix."_modules WHERE active = '1' ORDER BY custom_title");
            while($row = $db->sql_fetchrow($result)) {
                  $title = $row['title'];
                  $custom_title = $row['custom_title'];
				if (file_exists("$title.html")) {
 				echo "<li><a href=\"$title.html\"><img src='images/icon/folder.png'>".langit($custom_title)."</a></li><br />";
				}else {
 				echo "<li><a href=\"modules.php?name=".$title."\"><img src='images/icon/folder.png'>".langit($custom_title)."</a></li><br />";
				}
            }
            $db->sql_freeresult($result);
                  }
            }
      }
} else {
      $result = $db->sql_query("SELECT id, module, url, url_text FROM ".$prefix."_sommaire_categories ORDER BY id");
      while($row = $db->sql_fetchrow($result)) {
            $module = $row['module'];
            $url = $row['url'];
            $url_text = $row['url_text'];
            if (empty($url)) {
                  echo "<li><a href=\"modules.php?name=".$module."\"><img src='images/icon/bullet_go.png'>".$module."</a></li><br />";
            } else {
                  $url = str_replace('HTTP://', 'http://', $url);
                  echo "<li><a href=\"".$url."\"><img src='images/icon/bullet_go.png'>".$url_text."</a></li><br />";
            }
      }
      $db->sql_freeresult($result);
}
/*****[END]********************************************
 [ Site Map:  Active Modules                          ]
 ******************************************************/

/*****[BEGIN]******************************************
 [ Site Map:  Module Content                          ]
 ******************************************************/
//
// News
//
if ($sm_config['show_news'] == 1) {
      echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_news'] ._SM_NEWS_ART.":</b>";
      $result = $db->sql_query("SELECT sid, title FROM ".$prefix."_stories ORDER BY sid DESC LIMIT ".$sm_config['limit_news']."");
      while($row = $db->sql_fetchrow($result)) {
            $sid = sql_quote(intval($row['sid']));
            $title = sql_quote($row['title']);
            echo "<li><a href='modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."'>
            <img src='images/icon/bullet_go.png'>".$title."</a></li><br />";
      }
      $db->sql_freeresult($result);
}
//
// Downloads
//
if ($sm_config['show_downloads'] == 1) {
      echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_downloads'] ._SM_DL.":</b>";
      $result = $db->sql_query("SELECT lid, title, description FROM ".$prefix."_nsngd_downloads ORDER BY lid DESC LIMIT ".$sm_config['limit_downloads']."");
      while($row = $db->sql_fetchrow($result)) {
            $lid = sql_quote(intval($row['lid']));
            $title = sql_quote($row['title']);
 			$description = ( strlen($row['description']) > 30) ? substr($row['description'], 0, 49) . ' ...' : $row['description'];
            echo "<li><a href=\"modules.php?name=Downloads&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($title)."\"><img src='images/icon/bullet_go.png'>".$title."</a></li><br />";
      }
      $db->sql_freeresult($result);
}

//
// Forums - Public Forums
//
if ($sm_config['show_forums'] == 1 AND is_active("phpBB3")) {
      echo "<br /> <b>&raquo; "._SM_PUB_FORUM.":</b>";
      $result = $db->sql_query("SELECT forum_id, forum_name, forum_desc FROM ".$prefix."_bb3forums WHERE forum_status = '0' ORDER BY forum_name");
      while($row = $db->sql_fetchrow($result)) {
            $forum_id = intval($row['forum_id']);
            $forum_name = $row['forum_name'];
            $forum_desc = $row['forum_desc'];
            echo "<li><a href=\"modules.php?name=Forums&amp;file=viewforum&amp;f=".$forum_id."\">".$forum_name."</a>: ".$forum_desc."</li><br />";
      }
      $db->sql_freeresult($result);
}

//
// Forums - Public Topics (without ForumNews Advance Topics if enabled)
//
if ($sm_config['show_forum_topics'] == 1 AND is_active("phpBB3")) {
            echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_fna'] . _SM_PUB_TOPICS_FNA.":</b>";
            $result = $db->sql_query("SELECT topic_id, forum_id, topic_last_post_id, topic_title, topic_poster, topic_views, topic_replies, topic_moved_id FROM ".$prefix."_bb3topics ORDER BY topic_last_post_id DESC  LIMIT ".$sm_config['limit_fna']."");
            while($row = $db->sql_fetchrow($result)) {
                  $topic_id = intval($row['topic_id']);
                  $topic_title = $row['topic_title'];
                  echo "<li><a href=\"modules.php?name=Forums&file=viewtopic&p=".$topic_id."\"><img src='images/icon/bullet_go.png'>".$topic_title."</a></li><br />";
            }
            $db->sql_freeresult($result);
     
}


//
// Web Links
//
if ($sm_config['show_weblinks'] == 1) {

      $result = $db->sql_query("SELECT lid, title, description FROM ".$prefix."_links_links ORDER BY lid DESC LIMIT ".$sm_config['limit_weblinks']."");
            echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_weblinks'] ._SM_WL.":</b>";
            while($row = $db->sql_fetchrow($result)) {
            $lid = intval($row['lid']);
            $title = $row['title'];
            $description = $row['description'];
            echo "<li><a href=\"modules.php?name=Web_Links&amp;l_op=viewlinkdetails&amp;lid=".$lid."&amp;ttitle=".$title."\"><img src='images/icon/bullet_go.png'>".$title."</a>: ".$description."</li><br />";
      }

      $db->sql_freeresult($result);
}

//
// FAQ
//
/*
if ($sm_config['show_faq'] == 1) {
      $result = $db->sql_query("SELECT id, id_cat, question, answer FROM ".$prefix."_faqanswer ORDER BY id");
		if ($db->sql_numrows($result) > 0) {
      echo "<br /> <b>&raquo; "._SM_FAQ.":</b>";
      while($row = $db->sql_fetchrow($result)) {
            $id = intval($row['id']);
            $id_cat = intval($row['id_cat']);
            $question = $row['question'];
            $answer = $row['answer'];
            echo "<li><a href=\"modules.php?name=FAQ&amp;file=index&amp;myfaq=yes&amp;id_cat=".$id_cat."#".$id."\">".$question."</a>: ".$answer."</li><br />";
      }
		
	}
      $db->sql_freeresult($result);
}
*/
//
// Content
//
if ($sm_config['show_content'] == 1) {
      echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_content'] ._SM_CONTENT.":</b>";
      $result = $db->sql_query("SELECT pid, title, subtitle, page_header FROM ".$prefix."_pages ORDER BY pid DESC LIMIT ".$sm_config['limit_content']."");
      while($row = $db->sql_fetchrow($result)) {
            $pid = intval($row['pid']);
            $title = $row['title'];
            $subtitle = $row['subtitle'];
            $page_header = $row['page_header'];
            echo "<li><a href=\"modules.php?name=Content&amp;pa=showpage&amp;pid=".$pid."\">".$title."</a>: ".$subtitle." - ".$page_header."</li><br />";
      }
      $db->sql_freeresult($result);
}

//
// Reviews
//
if ($sm_config['show_reviews'] == 1) {
      echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_reviews'] ._SM_REVIEWS.":</b>";
      $result = $db->sql_query("SELECT id, date, title, text FROM ".$prefix."_reviews ORDER BY id DESC LIMIT ".$sm_config['limit_reviews']."");
      while($row = $db->sql_fetchrow($result)) {
            $id = intval($row['id']);
            $date = $row['date'];
            $title = $row['title'];
            $text = $row['text'];
            echo "<li><a href=\"modules.php?name=Reviews&amp;rop=showcontent&amp;id=".$id."\">".$title."</a>: ".$text." - ".$date."</li><br />";
      }
      $db->sql_freeresult($result);
}

//
// Tutorials - Categories
//
if ($sm_config['show_tutorials'] == 1) {
      echo "<br /> <b>&raquo; "._SM_TUTORIALS_CAT.":</b>";
      $result = $db->sql_query("SELECT tc_id, tc_title, tc_description FROM ".$prefix."_tutorials_categories ORDER BY tc_title");
      while($row = $db->sql_fetchrow($result)) {
            $tc_id = intval($row['tc_id']);
            $tc_title = $row['tc_title'];
            $tc_description = $row['tc_description'];
            echo "<li><a href=\"modules.php?name=Tutorials&amp;t_op=viewtutorial&amp;tc_id=".$tc_id."\">".$tc_title."</a>: ".$tc_description."</li><br />";
      }
      $db->sql_freeresult($result);

      //
      // Tutorials - Articles
      //
      echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_tutorials'] ._SM_TUTORIALS_ART.":</b>";
      $result = $db->sql_query("SELECT t_id, t_title, t_date, description FROM ".$prefix."_tutorials_tutorials ORDER BY t_id DESC LIMIT ".$sm_config['limit_tutorials']."");
      while($row = $db->sql_fetchrow($result)) {
            $t_id = intval($row['t_id']);
            $t_title = $row['t_title'];
            $t_date = $row['t_date'];
            $description = $row['description'];
            echo "<li><a href=\"modules.php?name=Tutorials&amp;t_op=showtutorial&amp;pid=".$t_id."\">".$t_title."</a>: ".$description." - ".$t_date."</li><br />";
      }
      $db->sql_freeresult($result);
}

//
// Shout Box
//
if ($sm_config['show_shouts'] == 1) {
      echo "<br /> <b>&raquo; "._SM_LATEST . $sm_config['limit_shouts'] . _SM_SHOUT_BOX.":</b>";
      $result = $db->sql_query("SELECT id, name, comment, date, time FROM ".$prefix."_shoutbox_shouts ORDER BY id DESC LIMIT ".$sm_config['limit_shouts']."");
      while($row = $db->sql_fetchrow($result)) {
            $id = intval($row['id']);
            $name = $row['name'];
            $comment = $row['comment'];
            $date = $row['date'];
            $time = $row['time'];
            echo "<li><a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=".$name."\">".$name."</a>: ".$comment." - ".$date." - ".$time."</li><br />";
      }
      $db->sql_freeresult($result);
}

/*****[END]********************************************
 [ Site Map:  Module Content                          ]
 ******************************************************/

/*****[BEGIN]******************************************
 [ Site Map:  RSS Feeds                               ]
 ******************************************************/
if ($sm_config['show_rss'] == 1) {
      echo "<br /> <b>&raquo; "._SM_RSS.":</b>";

      if ($sm_config['show_news'] == 1) {
            echo "<li><a href=\"feed.php?mod=News\"><img src='images/rss/rss.png' title='RSS'> RSS  <b>&raquo; "._SM_NEWS."</a></li><br />";
  }
      // If you have more RSS feeds, just add them here on this line!
      if ($sm_config['show_forums'] == 1 AND  is_active("phpBB3")) {
            echo "<li><a href=\"feed.php?mod=Forums\"><img src='images/rss/rss.png' title='RSS'>RSS  <b>&raquo; "._SM_FORUMS."</a></li><br />";
      }
      if ($sm_config['show_downloads'] == 1) {
            echo "<li><a href=\"feed.php?mod=Downloads\"><img src='images/rss/rss.png' title='RSS'>RSS  <b>&raquo; "._SM_DL."</a></li><br />";
      }

      echo "<li><a href=\"sitemap.php\"><img src='images/icon/star.png' title='xML'>XML Site Map</a></li><br />";
      
}
/*****[END]********************************************
 [ Site Map:  RSS Feeds                               ]
 ******************************************************/

if ($sm_config['use_gt'] == 1) {
      if (function_exists('nextGenTap')) {
            if ($nextg = 1) {
                  nextGenTap(0,1,0);
            }
      }
}

/*****[BEGIN]******************************************
 [ Site Map:  footer                                  ]
 ******************************************************/
if ($sm_config['match_theme'] == 1) {
    CloseTable();
	include_once("footer.php");
}

/*****[END]********************************************
 [ Site Map:  footer                                  ]
 ******************************************************/
