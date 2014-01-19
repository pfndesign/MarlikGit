<?php
/**************************************************************************/
/* PHP-Nuke INP: Expect to be impressed                                   */
/* ===========================                                            */
/*                               COPYRIGHT                                */
/*                                                                        */
/* Copyright (c) 2003 - 2005 by http://www.irannuke.com                   */
/*                                                                        */
/*     Iran Nuke Premium                         (info@irannuke.com)      */
/*                                                                        */
/* Refer to irannuke.com for detailed information on PHP-Nuke INP         */
/**************************************************************************/
/* Site Links To Us Module for PHP-Nuke                 */
/* Version 2.0 UNIVERSAL 2-04-05                        */
/* By: Telli (telli@codezwiz.com)                       */
/* http://codezwiz.com/                                 */
/* Copyright © 2002-2005 by Codezwiz Network, LLC.      */
/********************************************************/

global $sitename;
//EVERYWHERE
define("_GETZIPALT","برای دریافت کد لینک ما برروی لوگو کلیک کنید!");
define("_RESOURCES","دوستان");
//SIDEBLOCKS
define("_BLOCKTITLE","لینک به سایت<br /><b>$sitename</b>");
define("_CLICKTOVIEW","<a href=\"modules.php?name=Link_To_Us\">مشاهده تمام<br />لینکهای دوستان</a>");
define("_BLOCKRESOURCES","دوستان");
//CENTERBLOCKS
define("_CLICKTOVIEWBIG","<a href=\"modules.php?name=Link_To_Us\">مشاهده تمام لوگوها</a>");
//MODULES
define("_SMALLBUTTONS","<b>در این قسمت می توانید لینک و لوگوی سایت ما را مشاهده کنید<br>و آن را در سایت خود قرار دهید.</b>");
define("_MEDIUMBUTTONS","<b>Here is a collection of some of our medium size link to buttons.</b>");
define("_LARGEBUTTONS","<b>Here is a collection of some of our full size banners.</b>");
define("_TEXTEXPLAIN","لطفا کدهای مربوطه در زیر لوگو را کپی کرده و در قالب سایت خود قرار دهید.");
define("_ZIPEXPLAIN","لطفا برروی لوگوی مورد نظر کلیک کنید تا تصویر و کد مربوطه را در یک فایل فشرده دریافت کنید.<br />اگر لوگوی مورد نظر به صورت فلش بود لطفا در زیر لوگو برروی لینک کلیک کنید تا کد مربوطه را دریک فایل فشرده دریافت کنید.");

//Admin
global $czlset;
define("_MAINMENU","منو اصلی");
define("_RESOURCES","لینک دوستان");
define("_MYLINKS","لینک سایت");
define("_BACKTOADMIN","برگشت به منو مدیریت");
define("_RESOURCENAME","نام سایت");
define("_RESOURCEIMAGE","لوگو سایت");
define("_RESOURCESTATUS","وضعیت لوگو");
define("_EDITRESOURCE","ویرایش لینک دوستان");
define("_ACTIVATERES","لینکهای فعال دوستان");
define("_ADDRESOURCE","افزودن لینک دوست");
define("_RESOURCEURL","لینک سایت");
define("_MYLINKSNAME","نام سایت");
define("_MYLINKSIMAGE","آدرس لوگو");
define("_MYLINKSIMAGEUPLOAD","مسیر لوگو");
define("_MYLINKSMOUSEOVER","متن هنگام قرارگیری ماوس");
define("_MYLINKSMOUSEOVEREXPLAIN","<br /><small>Only works when <b>NOT</b> using the zip method.</small>");
define("_MYLINKSIMAGEHTMLEXPLAIN","<br /><small>Right click and save your image. Copy and paste the above html into a text document and save. Zip it up and upload it here.</small>");
define("_MYLINKSSTATUS","وضعیت لینک");
define("_MYLINKSSIZE","سایز لوگو");
define("_RESOURCESIZE","سایز لوگو");
define("_MYLINKSURL","آدرس سایت");
define("_MYLINKSZIPURL","آدرس فایل ZIP");
define("_MYLINKSHITS","دریافت");
define("_MYLINKSZIP","فایل Zip");
define("_ADDMYLINK","افزودن لینک");
define("_VIEWIMAGE","مشاهده لوگو");
define("_VIEWSWF","مشاهده Flash");
define("_ACTION","اختیارات");
define("_ACTIVE","فعال");
define("_WHICHONE","");
define("_NOTACTIVE","غیرفعال");
define("_NORESOURCESYET","لینک دوستی در این بخش وجود ندارد!");
define("_NOMYLINKSYET","شما لینکی دراین قسمت ندارید");
define("_EDITMYLINKS","ویرایش لینک سایت");
define("_ADDMYLINKS","افزودن لینک سایت");
define("_AREYOUSUREDELRESOURCE","آیا شما از حذف لوگو این دوست اطمینان کامل دارید؟");
define("_AREYOUSUREDELMYLINK","آیا شما از حذف لینک این سایت اطمینان کامل دارید؟");
define("_NOTHINGUPLOADED","امکان انتقال فایل به پوشه <b>$czlset[path]</b> وجود ندارد.شما باید chmod فایل مربوطه را به 777 تغییر دهید. مجددا سعی کنید.");
define("_NOTHINGUPLOADEDZIP","امکان انتقال فایل به پوشه <b>$czlset[zippath]</b> وجود ندارد.شما باید chmod فایل مربوطه را به 777 تغییر دهید. مجددا سعی کنید.");
define("_ERRORDELETINGIMAGE","There was an error deleting the image you will have to do it manually.");
define("_ERRORDELETINGZIP","There was an error deleting the zip file you will have to do it manually.");
define("_MISSINGZIPS","<b>There are some site links that do not have zip files available for them. Below is a list. Please make sure that you add a zip file if your using the zip option otherwise they won't know how to link to you. After you have added the zip file then change the configuration to use zip's.</b>");
define("_ADDZIPMYLINKS","افزودن لینک Zip");
define("_EDITZIPMYLINKS","ویرایش لینک Zip");
define("_MYLINKSIMAGEHTML","کد لوگو شما");
define("_MYLINKSZIPUPLOAD","مسیر فایل zip");
define("_PATHTOFILES","مسیر ذخیره لوگو");
define("_PATHTOZIPFILES","مسیر ذخیره فایل zip");
define("_PATHTORESFILES","مسیر ذخیره لوگو دوستان");
define("_PATHTOFILES2","<br /><small>(بصورت پیشفرض بهتر است.)</small>");
define("_HOWMANY","تعداد نمایش");
define("_ZIPORTEXT","بصورت فایل Zip یا کد لینک");
define("_ZIP","Zip");
define("_TEXT","کد لینک");
define("_SCROLLDIRECTION","اسکرول");
define("_SCROLLHEIGHT","ارتفاع Scroll");
define("_SCROLLDELAY","سرعت Scroll");
define("_SCROLLORDER","نمایش بصورت");
define("_OTHERSIZE","Other size");
define("_WIDTHHEIGHT","عرض <b>x</b> ارتفاع");
define("_WIDTH","عرض");
define("_HEIGHT","ارتفاع");
define("_MYLINKSSWFSIZE","Flash dimensions");
define("_MOUSEROVERALPHA","هنگام قرارگیری ماوس نمایش بصورت Alfa");
define("_YES","بله");
define("_NO","خیر");
define("_MAINCONFIG","تنظیمات اصلی");
define("_MYLINKSSET","لینک سایت");
define("_RESOURCESSET","لوگوهای دوستان");
define("_MODULESETTINGS","تنظیمات ماژول");
define("_MISSINGDATA","Missing data!");
define("_SUBMIT","ارسال");
define("_ADMINCZLINKTOUS","مدیریت لینک به ما");
define("_CLICKHERECZLINKTOUSD","برای دریافت کد لینک ما برروی لوگو کلیک کنید!");

define("_CONFIG","تنظیمات");

?>