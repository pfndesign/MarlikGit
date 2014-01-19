<?php
/********************************************************/
/* Site Admin Backup & Optimize Module for PHP-Nuke     */
/* Version 1.0.0         10-24-04                       */
/* By: Telli (telli@codezwiz.com)                       */
/* http://codezwiz.com/                                 */
/* Copyright © 2000-2004 by Codezwiz                    */
/* Adjusted fot Iran Nuke Portal / http://irannuke.com	*/
/* http://saqur.com - A. Zakeri / 12-01-2006			*/
/********************************************************/

define("_OPTIMIZEEXPLAIN","<b>بهینه‌سازی</b><br><div align=\"justify\">اگر شما بخش زیادی از اطلاعات را حذف نموده‌اید، یا تغییرات بسیاری در جداول دارای فیلد‌های با طول متغیر (مثل فیلد‌های نوع VARCHAR، BLOB یا TEXT) داده‌اید، باید از بهینه‌سازی استفاده کنید. رکوردهای حذف‌شده در فهرست لینک نگهداری می‌شوند و دستور INSERT بعدی از محل‌های مربوط به رکوردهای قدیمی بهره می‌گیرد. شما می‌توانید بهینه‌سازی کنید تا فضاهای غیرقابل استفاده را احیا کنید و فایل‌های بانک اطلاعاتی را یک‌پارچه نمائید.<br>
در بسیاری اوقات شما نیازی به استفاده از بهینه‌سازی ندارید. در صورتی که به‌روزرسانی‌های بسیاری برای فیلدهای با طول متغیر دارید، لازم نیست که شما بیش از یک‌بار در ماه و حداکثر در هفته، این کار را انجام دهید، آن هم فقط بر روی جداولی که می‌دانید نیاز به بهینه‌سازی دارند.<br>
بهینه‌سازی کارهای زیر را انجام می‌دهد:<ul>
<li>اگر جدولی حذف شده یا سطرهای آن تقسیم شده‌اند، جدول را تعمیر می‌کند.
<li>اگر صفحات لیست ایندکس مرتب نباشند، آنها را مرتب می‌کند.
<li>اگر آمار به روز نباشد (و گزینه رفع اشکالات، با مرتب‌سازی ایندکس این مشکل را حل نکند) آنرا به‌روزرسانی می‌کند.
</ul>توجه: جدول، به هنگام بهینه‌سازی، باید بسته (قفل‌شده و غیرقابل‌دسترس برای تغییر) باشد! (از طریق نگهبان سایت می‌توانید سایت را غیرفعال کنید)</div>");
define("_SELECTFILETOIMPORT","یک فایل SQL/GZip جهت بازگرداندن/افزودن به بانک‌اطلاعاتی برگزینید");
define("_STARTSQL","اجرا");
define("_MENU","<a href=\"".ADMIN_PHP."\">منوی مدیریت</a>");

define("_USECOMPRESSION","فشرده‌سازی");
define("_INCLUDEDROPSTATEMENT","دربرداشتن عبارت drop");
define("_FORBACKUPONLY","انتخاب (فقط برای پشتیبان‌گیری)");
define("_STATUS","وضعیت");
define("_REPAIR","رفع اشکالات");
define("_ANALYZE","تجزیه و تحلیل");
define("_CHECK","بررسی");
define("_OPTIMIZE","بهینه‌سازی");
define("_BACKUP","گرفتن کپی پشتیبان");
define("_CHECKALL","انتخاب همه جداول");
define("_UNCHECKALL","عدم انتخاب همه جداول");
define("_DATABASEMANAGE","مدیریت بانک اطلاعاتی MySQL");
define("_TABLES","جداول بانک اطلاعاتی");
define("_NOTABLESFOUND","جدولی در بانک اطلاعاتی یافت نشد.");
define("_DATABASE","Database ");
define("_TABLESTRUCTURE","Table structure for table");
define("_DUMPINGTABLE","Dumping data for table");
define("_ERROR","Error");
define("_SQLQUERY","Sql Query");
define("_MYSQLSAID","MySQL said");
define("_ACTION","Action");
define("_DONE","On");
define("_AT","at");
define("_BY","by");
define("_FINISHEDADDING","افزودن");
define("_TOTHEDB","به بانک اطلاعاتی پایان یافت.");
define("_ERRORCANTDECOMPRESS","خطا، فایل فشرده باز نمی‌شود");
define("_ADDON","مدیریت بانک اطلاعاتی");
?>