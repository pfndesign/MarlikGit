<?php

/**
 *
 * @package INSTALLATION
 * @version $Id: Persian.php 0999 2009-12-13 Aneeshtan $
 * @copyright (c) Marlik Group  http://www.nukelearn.com
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

define('CHARSET', 'UTF-8');
define("TEXT_INSTALLATION_NOTE","	سيستم مديريت محتواي نيوك ابزاري مفيد و سودمند در اختيار  كساني است كه  مي خواهند  بدون هيچ گونه  پرداخت هزينه  اي و در كوتاه ترين  زمان صاحب يك سايت قدرتمند و ايمن شوند . اين سيستم كه در ابتدا توسط  فردي به  نام  فرانسيسكو بارزي  به صورت عموم عرضه شد  بعد ها  توسعه يافت و نام هاي گوناگون به خود  گرفت . در  بسته ي  نرم افزاري پرتال    كه توسط  گروه   تهيه شده است سعي شده  تا سيستمي قدرمتند و ايمن در اختيار كاربران فارسي زبان قرار بگيرد . يكي از افتخارات  گروه  كاربران بسيار زياد اين سايت است و ما اميدواريم بتوانيم  كاربران خود را با ارائه نسخه هاي ايمن و قدرتمند خشنود كنيم . <br> تيم  منتظر پيشنهادات و انتقادات شما كاربران عزيز مي باشد <br> Nukelearn.COM </div>");
define("TEXT_READ_LICENSE","لطفا اين قوانين را با دقت بخوانيد");
define("TEXT_ACCEPT","با شرايط فوق موافقم");
define("TEXT_LICENSE_STOP","شما قسمت قوانين کلي را تائيد نکرده ايد به همين منظور ادامه نصب مقدور نميباشد<br><br>براي برگشتن به صفحه قبل گزينه سعي دوباره را بزنيد و پس از خواندن متن قانون کلي گزينه من قوانين را قبل دارم را انتخاب کنيد");
define("TEXT_CREATE_DB","براي ادامه نصب يک ديتابيس مخصوص نيوک خود با نام دلخواه ايجاد کنيدبراي مثال در محيط يونيکس و در خط فرمان ميتوانيد از دستور زير استفاده نمائيد:");
define("TEXT_IMPORT_DB","لطفا اطلاعات مربوط به تنظيمات بانک اطلاعاتي را وارد کنيد");
define("TEXT_MISSING_DATA","اطلاعات وارد شده مشکل دارد,<br>لطفا <i>روي بازگشت</i>کليک کرده و اطلاعات را با دقت وارد کنيد");
define("TEXT_ERROR_DB","تست اوليه براي ارتباط با بانک اطلاعاتي با مشکل مواجه است گزينه بازگشت را بزنيد و اطلاعات را با دقت چک کنيد حتما بانک اطلاعاتي را قبلا ايجاد کنيد بعد نام بانک اطلاعاتي نيوک را وارد نمائيد<br>ميباشد  phpmyadmin بهترين روش براي ايجاد ديتابيس استفاده از برنامه");
define("TEXT_ERROR_SQL_FILE","<b>خطا</b>وارد کردن بانک اطلاعاتي <b>با موفقيت انجام نشد</b> مسير صحيح و داده هاي وارد شده را با دقت چک کنيد:");
define("TEXT_IMPORT_DB_OK","اطلاعات بانک اطلاعاتي با موفقيت و بدون اشکال وارد شد");
define("TEXT_ADMIN_FILE","نام فايل بخش مديريت  بصورت پيش فرض '<i>".ADMIN_PHP."</i>'. شما ميتوانيد نام فايل ادمين را بدلخواه تغيير دهيد");
define("TEXT_SUBSCRIPTION","اگر تمايل  داريد سايت شما داراي اينگوه عضويت بعنوان مثال بصورت پرداخت مبلغي براي عضو شدن باشد ادرس اين صفحه را وارد کنيد در غير اين صورت اين فيلد را خالي بگذاريد");
define("TEXT_DIAMAIN_GUIDE","آدرس اينترنتي سايت خود را در اين فيلد بدون WWWبنويسيد");
define("TEXT_ADVANCED_EDITOR","فعال يا غير فعال کردن اديتور.");
define("TEXT_SECURITY_CODE","تنظيمات مربوط به نمايش يا عدم نمايش کد امنيتي در هنگام ورود يا عضويت");
define("TEXT_NOT_WRITABLE","فایل admin.php و یا config.php  در ورت هاست شما غیرقابل نگارش هستند .<br><br>لطفا ابتدا حق دسترسي به اين فايل را 666 قرار دهيد و سپس گزينه ادامه را بزنيد");
define("TEXT_CONFIG_FILE_NOT_FOUND","وجود ندارد config.php اخطار : ");
define("TEXT_FILE_NOT_FOUND","لطفا با دقت مسير اين فايل را چک کنيد که در شاخه اصلي وجود داشته باشدهچنين حق دسترسي به اين فايل را 666 قرار دهيد");
define("TEXT_WRITE_OK","پيکر بندي با موفقيت انجام شد");
define("TEXT_RETRY_CHMOD","حالا مجددآ حق دسترسي فايل config.php و admin.php را به 644 تغيير دهيد.");
define("TEXT_WARNING_CHMOD","حتما حق دسترسي به فايل کانفيگ را به 644 تغيير دهيد در صورتي که حق دسترسي 666 بماند سايت شما با مشکل امنيتي جدي مواجه خواهد شد");
define("TEXT_CREATE_ADMIN","همچنين شما لازم است براي وب سايت خود يک مدير اصلي تعريف کنيد");
define("TEXT_CREATE_USER","آيا ميخواهيد با همين نام يک کاربر عادي نيز اننخاب شود (بله را انتخاب کنيد)");
define("TEXT_ADMIN_STOP","مشکلي پيش آمده است .لطفا مجددا بررسي كنيد");
define("TEXT_ADMIN_CREATED","تبريک ميگوئيم شما با موفقيت مدير اصلي براي سايت خود ايجاد نموديد<br><br>به ياد داشته باشيد كه قبل از استفاده از سايت و عمومي كردن سايت خود حتما از صحت سطح دسترسي پوشه ها  اطمينان حاصل كنيد");
define("TEXT_DB_SERVER","سرور بانک اطلاعاتي :");
define("TEXT_LOCALHOST_IP","( مناسب است localhost بعنوان مثال)");
define("TEXT_DB_NAME","نام بانك اطلاعاتي");
define("TEXT_DB_ETC","( nuke بعنوان مثال )");
define("TEXT_DB_USERNAME","نام كاربري");
define("TEXT_DB_USERNAME1","نام كاربري كه به ديتابيس متصل است");
define("TEXT_DB_PASSWORD","رمز عبور");
define("TEXT_DB_PASSWORD_NOTE","اگر در لوكال نصب مي كنيد و رمز عبور نداريد دكمه space را بزنيد");
define("TEXT_DB_PREFIX","پيشوند جداول :");
define("TEXT_DB_PREFIX1","nuke پيشوند جداول پرتال شما بصورت پيش فرض ");
define("TEXT_DB_USERPREFIX","نام کاربري پيشوند جداول");
define("TEXT_DB_USERPREFIX1","nuke نام کاربري شما براي پيشوند جداول بصورت پيش فرض ");
define("TEXT_DB_TYPE","نوع پايگاه اطلاعاتي");
define("TEXT_SERVER_TYPE","نوع بانک اطلاعاتي :");
define("TEXT_NUKEVERSION","نسخه پرتال ");
define("TEXT_CHOSE_VERSION","نسخه اي كه مي خواهيد اقدام به نصب آن كنيد");
define("TEXT_ERROR","Error");
define("TEXT_SECURITYCODE","تنظيمات كد امنيتي");
define("TEXT_SECURITYCODE1","بدون کد امنيتي");
define("TEXT_SECURITYCODE2","فقط در هنگام ورود مدير");
define("TEXT_SECURITYCODE3","فقط در هنگام ورود کاربران");
define("TEXT_SECURITYCODE4","فقط در هنگام عضويت کاربران");
define("TEXT_SECURITYCODE5","فقط در هنگام ورود کاربران و عضويت در سايت");
define("TEXT_SECURITYCODE6","فقط در هنگام ورود مدير سايت و کاربران");
define("TEXT_SECURITYCODE7","فقط در هنگام در هنگام ورود مدير و عضويت کاربر جديد");
define("TEXT_SECURITYCODE8","در همه حالات  كدامنيتي نشان داده شود");
define("TEXT_SUBSCRIPTIONTITLE","آدرس اعضاي ويژه");
define("TEXT_ADMINFILE","Admin File");
define("TEXT_DOMAIN","نام اينترنتي سايت شما<br>بدون WWW");
define("TEXT_EDITOR","اديتور پيشرفته ");
define("TEXT_EDITOROFF","عيرفعال");
define("TEXT_EDITORON","فعال");
define("TEXT_NICKNAME","نام كاربري مديريت");
define("TEXT_REQUIRED","(لازم)");
define("TEXT_HOMEPAGE","آدرس اينترنتي");
define("TEXT_EMAIL","پست الكترونيك");
define("TEXT_PASSWORD"," رمز عبور");
define("TEXT_ACCOUNTYES","بله");
define("TEXT_ACCOUNTNO"," خير");
define("TEXT_IMPORTANT"," نكته بسيار مهم");
define("TEXT_SITENAME","نام سايت");
define("TEXT_SITEURL","آدرس اينترنتي سايت");
define("TEXT_SITESLOGAN","شعار سايت");
define("TEXT_WEBAMSTERMAIL","پست الكترونيك مدير سايت");
define("TEXT_PERMISSION","تغيير سطح دسترسي فايل ها و پوشه هاي زير ضروري است");
define("TEXT_PERMISSION_CHANGED","تغيير كرد.");
define("TEXT_PERMISSION_FORUMS_FILE","پوشه files که در مسیر Yoursite.com/modules/Forums قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_FORUMS_CACHE","پوشه cache که در مسیر Yoursite.com/modules/Forums قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_GBOOK","فایل config.php که در مسیر Yoursite.com/modules/Gbook قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_IMGLINKS","پوشه links که در مسیر Yoursite.com/images قراردارد مجوز دسترسی (chmod)  به ");
define("TEXT_PERMISSION_IMGRES","پوشه res که در مسیر Yoursite.com/images/links قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_IMGINC","پوشه inc که در مسیر Yoursite.com/images/links قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_IMGZIPS","پوشه zips که در مسیYoursite.com/images/links قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_WCACHE","پوشه cache که در مسیر Yoursite.com/modules/Weather قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_GALDATA","پوشه data و تمام پوشه های موجود در آن که در مسیر Yoursite.com/modules/Gallery قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_GALTEMP","پوشه templates که در مسیر Yoursite.com/modules/Gallery قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_TEMPDEFAULT","پوشه default که در مسیر Yoursite.com/modules/Gallery/templates قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PERMISSION_DEFMEDIA","پوشه media که در مسیر Yoursite.com/modules/Gallery/templates/default قراردارد مجوز دسترسی (chmod)  به");
define("TEXT_PORTALINFO","در حال حاضر پرتال نیوک لرن بر روی سایت شما نصب است . در این صورت شما می بایست حتما این پوشه را پاک کنید . در غیر این صورت می توانید پرتال نیوک لرن را  پاک کنید . <br>اگر چنین تصمیمی گرفتید , ممنون می شویم ما را از مشکلات پرتال قبل از ترک آن مطلع کنید");
define("TEXT_INSTALLATION_OPTIONS","اختيارات نصب");
define("TEXT_MYBB_INSTALL","آیا می خواهید انجمن های گفتگو <b>MyBB</b> نیز نصب شود ؟");
define("TEXT_DEFAULT_VALUES","مقادیر پیش فرض");
define("TEXT_ADMIN_FILE_NAME","نام فایل مدیریت");
define("TEXT_PORTAL_DELETED_SUCCESSFULLY","پرتال سایت شما با موفقیت پاک شد");
define("TEXT_PORTAL_DELETED_UNSUCCESSFULLY","پرتال شما پاک نشد
<br> این مورد می تواند از این باشد که یا اطلاعات دیتابیس شما از قبل پاک شده اند  و یا اینکه  به درستی مشخصات مدیریت سایت را وارد نکرده اید
<br>
");
define("TEXT_DELETE_INFORMATION","اطلاعات سایت را حذف کن");
define("TEXT_USERNAME","نام کاربری");
define("TEXT_PORTAL_DELETE_INFO","شما برای حذف پرتال نیاز به وارد کردن مشخصات مدیریت خود دارید <br> لطفا در این مرحله دقت کنید , در غیر این صورت شما مسدود خواهید شد");
define("TEXT_PORTAL_DELETE","حذف پرتال نیوک لرن");
define("TEXT_DELETE_FOLLOWING_FILES","فایلهای زیر را پاک کنید");
define("TEXT_DELETE_INSTALL_FILE","فایل install.php را پاک کنید");
define("TEXT_DELETE_INSTALLATION_FOLDER","پوشه INSTALLATION را پاک کنید");
define("TEXT_ACCESS_LEVEL_INFO","امکان ذخیره اطلاعات مربوط به انجمن و تنظیم آن ممکن نیست.<br>ابتدا فایل با مسیر زیر را به سطح دسترسی 666 یا 777 تغییر دهید");

define("YES","بلی");
define("NO","خیر");
define("WARNING","خطر");
define("START","شروع نصب");
define("NEXT","مرحله بعد");
define("BACK","مرحله قبل");
define("RETRY","سعی مجدد");
define("CANCEL","لغو نصب");
define("ERROR","خطا در نصب ");
define("EMPTYINPUT","ورودی را کامل پر کنید .");
define("PERM_FOLDER_PATH","مسیر پوشه یا فایل ");
define("PERM_CHANGE_TO","تغییر سطح دسترسی به ");
define("CHANGE_PERM_GUIDE","راهنمای کامل  تغییر سطح دسترسی ");
define("ADMINISTRATOR","مدیریت سایت");
define("SHOWMYSITE","نمایش سایت ");
define("UNINSTALL","حذف پرتال");
define("UPDATE","ارتقا سایت");
define("START_INST","نصب پرتال");
define("NO_DB_FILE","متاسفانه هیچ بانک اطلاعاتی در مسیر مورد نظر وجود ندارد");
define("NO_ADMIN_FILE","فایل مدیریت شما با نام 	".(isset($_POST['admin_file']) ? $_POST['admin_file'] : ""). ".php		وجود ندارد.<br><br>	شما می توانید به صورت دستی فایل 	admin.php	را به نام دلخواه خود تغییر دهید.<br>");

define("STEP_1","مرحله اول : قوانين  بين الملي GPL");
define("STEP_2","Step 2: Copyright Notice");
define("STEP_3","Step 3: Create DataBase");
define("STEP_4","مرحله نصب بانك اطلاعاتي");
define("STEP_5","مرحله تنظيم فايل config.php ");
define("STEP_6","مرحله ايجاد مدير اصلي سايت");
define("STEP_7","مرحله تعيين سطح دسترسي");
define("STEP_8","مرحله آخر :پايان نصب");
define("STEP_9","مرحله آخر :پايان نصب");

define("CONVERT","تبدیل پرتال");
define("_GOBACK","[ <a href=\"javascript:history.go(-1)\">بازگشت</a> ]");
define("_TABLEDELETED","جدول $table_name با موفقیت پاک شد.");
define("_TABLEDELETEFAILED","خطا در پاک کردن جدول $table_name ");


 ?>