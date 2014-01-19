<?php
global $nukeurl, $sitename;

//
//Administration
//
define('_SMADMIN','مدیریت نقشه تارنما');
define('_SMMAINADMIN','مدیریت تارنما');

//Admin Menu
define('_SMGENCONFIG','تنظیمات عمومی');
define('_SMGENCONFIGDESC','تغییرات عمومی ماژول نقشه تارنما');
define('_SMMODS','ماژولها/مودها');
define('_SMMODSDESC','فعال کردن/غیر فعال کردن ماژولها و مودها');
define('_SMLIMITS','تعداد نمایش');
define('_SMLIMITSDESC','محدود کردن تعداد نمایش لینکها برای هر ماژول یا مود');
define('_SMGOOGLESETUP','تنظیمات بخش گوگل');
define('_SMGOOGLESETUPDESC','تنظیم و تغییرات بخش جستجوی گوگل');

//General Configuration
define('_SMMATCHTHEME','فعال کردن استفاده از قالب پیش فرض');
define('_SMSOMMAIRE','فعال سازی بلوک پیشرفته منوی تارنما');
define('_SMGT','فعال سازی گوگل تپ');
define('_SMGOOGLE','فعال سازی فیلد جستجوی گوگل');
define('_SMGENTIME','فعال سازی مدت زمان ساخت صفحه');

define('_SMEMATCHTHEME','این گزینه گرافیک صفحه نقشه را از قالب تارنما میگیرد');
define('_SMESOMMAIRE','اگر شما از بلوک منوی the Sommaire block, استفاده میکنید این گزینه را بله انتخاب کنید');
define('_SMGOTGT','اگر گوگل تپ را نصب کرده و فعال دارید بله را انتخاب کنید');
define('_SMEGOOGLE','فیلد جستجوی گوگل در نقشه نمایش داده شود؟');
define('_SMEGENTIME','نمایش مدت زمان ساخت صفحه در فوتر؟');

//Modules/Addons
define('_SMNEWS','فعال سازی بخش خبرها');
define('_SMFNA','فعال سازی مود ForumNews Advance');
define('_SMFORUMCAT','نمایش تالارها');
define('_SMFORUMS','نمایش بخشهای تالارها');
define('_SMFORUMTOPICS','نمایش تاپیکهای تالارها');
define('_SMKB','نمایش  Knowledge Base');
define('_SMDL','نمایش بخش دریافت فایل');
define('_SMWL','نمایش بخش پیوندها');
define('_SMFAQ','نمایش  FAQ');
define('_SMCONTENT','نمایش مقالات');
define('_SMREVIEWS','نمایش نقد و بررسی');
define('_SMTUTORIALS','نمایش آموزشها');
define('_SMPJ','نمایش پروژه ها');
define('_SMSUPPORTERS','نمایش Supporters');
define('_SMCOPPERMINE','نمایش گالری تارنما');
define('_SMSPCHAT','نمایش SPChat');
define('_SMSUSERS','نمایش  کاربران');
define('_SMSHOUTS','نمایش وبلاگ کاربران');
define('_SMARCADE','نمایش Arcade Games');
define('_SMRSS','نمایش  RSS Feeds');

//Limit Links
define('_SMLIMITNEWS','تعداد لینک خبرها');
define('_SMLIMITFNA','ForumNews Advance');
define('_SMLIMITFORUMTOPICS','تعداد تاپیکهای تالار');
define('_SMLIMITKB','Knowledge Base');
define('_SMLIMITDL','تعداد فایلهای دریافتی');
define('_SMLIMITWL','تعداد پیوندها');
define('_SMLIMITCONTENT','تعداد مقالات');
define('_SMLIMITREVIEWS','تعداد نقد و بررسی');
define('_SMLIMITTUTORIALS','تعداد آموزشها');
define('_SMLIMITPJ','تعداد پروژه ها');
define('_SMLIMITSUPPORTERS','Supporters');
define('_SMLIMITCOP','تعداد عکسهای گالری');
define('_SMLIMITSHOUTS','پست های کاربران');
define('_SMLIMITUSERS',' کاربران');
define('_SMLIMITARCADE','Arcade Games');

//Google Block Setup
define('_SMGOOGLEURL','نشانی گوگل (پیشفرض: http://www.google.com/)');
define('_SMSITELOGO','نام فایل لوگو تارنما (پیشفرض: logo.gif)');
define('_SMSITELOGOPATH','نشانی لوگوی تارنما (پیشفرض: images/)');
define('_SMSITELOGOHEIGHT','بلندای لوگو (حداکثر. 50)');
define('_SMSITELOGOWIDTH','عرض لوگو (پیشفرض: 425)');
define('_SMSITELOGOHEADER','رنگ سربخش صفحه جستجو (پیشفرض: #ffffff)');
define('_SMSITELOGOBG','رنگ پیش زمینه صفحه جستجو (پیشفرض: #ffffff)');
define('_SMGOOGLELOGO','نام فایل لوگو گوگل (پیش فرض: google.gif)');
define('_SMGOOGLELOGOPATH','نشانی به لوگو گوگل (پیشفرض: images/powered/)');

//
// Module
//
define("_SM","نقشه سايت");
define("_SM_VIEWING","شما هم اکنون صفحه نقشه تارنما را مشاهده می کنید.<br />برای دیدن برگ نخست تارنما <a href=\"".$nukeurl."\">اینجا کلیک کنید.</a><p><br /><br />");
define("_SM_GOOGLE","جستجوی تارنمای ".$sitename." و اینترنت بوسیله گوگل ");
define("_SM_HOME","برگ نخست");
define("_SM_ACTIVE_MODULES","ماژولهای فعال");
define("_SM_NEWS","اخبار");
define("_SM_NEWS_ART"," اخبار");
define("_SM_LATEST","جدیدترین ");
define("_SM_TOP","Top ");
define("_SM_FNA","اخبار تالار");
define("_SM_FNA_TOPICS"," تاپیک خبری");
define("_SM_FNA_CAT"," بخشهای خبری تالار");
define("_SM_FORUMS","تالارها");
define("_SM_FORUM_CAT","بخشهای تالار");
define("_SM_PUB_FORUM","تالارهای همگانی");
define("_SM_PUB_TOPICS_FNA"," تالارهای همگانی (بدون تاپیکهای خبری تالار)");
define("_SM_PUB_TOPICS"," تاپیک همگانی");
define("_SM_KB_CAT","Knowledge Base Categories");
define("_SM_KB_ART"," Knowledge Base Articles");
define("_SM_DL"," فایل در بخش دریافت");
define("_SM_WL"," پیوند ");
define("_SM_FAQ","پرسش و پاسخ");
define("_SM_CONTENT"," مقاله");
define("_SM_REVIEWS"," نقد و بررسی");
define("_SM_TUTORIALS_CAT","بخش آموزشی");
define("_SM_TUTORIALS_ART"," مقاله آموزشی");
define("_SM_PROJECTS"," پروژه");
define("_SM_SUPPORTERS"," Supporters");
define("_SM_HITS","Hits ");
define("_SM_COP_GAL_CAT","آلبومهای گالری");
define("_SM_COP_GAL_ALB","coppermine Gallery Albums");
define("_SM_COP_GAL_PIC"," فرتور گالری");
define("_SM_SPCHAT_ROOMS","SPChat Rooms");
define("_SM_SHOUT_BOX"," پیام در پیامهای سریع");
define("_SM_ARCADE"," بازیها");
define("_SM_RSS","RSS Syndications");


?>