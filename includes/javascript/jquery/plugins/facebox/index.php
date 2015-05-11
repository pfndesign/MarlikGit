<?php

/**
*
* @package Facebox														
* @version $Id: 8:26 PM 12/18/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
addJSToHead(SCRIPT_PLUGINS_PATH . 'facebox/style/facebox.js','file');
addCSSToHead(SCRIPT_PLUGINS_PATH . 'facebox/style/facebox.css','file');
$inlineJS ="<script type='text/javascript'>jQuery(document).ready(function($) { $('a[class*=colorbox]').facebox({})})</script>";
addJSToHead($inlineJS,'inline');

?>