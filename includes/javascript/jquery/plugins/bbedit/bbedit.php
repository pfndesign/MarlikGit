<?php
/**
 * jQuery bbcode editor plugin
 *
 * Copyright (C) 2010 Joe Dotoff
 *
 * @version 1.1
 * @link http://www.w3theme.com/jquery-bbedit/
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

define('BBEDIT_TYPE_BOTH', 1);
define('BBEDIT_TYPE_TAG', 0);
define('BBEDIT_TYPE_SMILEY', 0);

/**
 * Convert bbcode to HTML
 *
 * @param string $text  The text to convert.
 * @param int $type  The type of bbcode.
 * @param string $smileyUrl  The URL path of smiley icons.
 * @return string
 */
function bbedit($text, $type = BBEDIT_TYPE_BOTH, $smileyUrl = 'includes/javascript/jquery/plugins/bbedit/smiley')
{
    $search = array(
        '/\[b\]([^(\[\/b\])]+)\[\/b\]/i',
        '/\[i\]([^(\[\/i\])]+)\[\/i\]/i',
        '/\[u\]([^(\[\/u\])]+)\[\/u\]/i',
        '/\[s\]([^(\[\/s\])]+)\[\/s\]/i',
        '/\[code\]([^(\[\/code\])]+)\[\/code\]/i',
        '/\[quote\]([^(\[\/quote\])]+)\[\/quote\]/i',
        //'/\[img\]([^(\[\/img\])]+)\[\/img\]/i',
    );
    $replace = array(
        '<strong>$1</strong>',
        '<em>$1</em>',
        '<span class="underline">$1</span>',
        '<span class="line-through">$1</span>',
        '<code>$1</code>',
        '<blockquote>$1</blockquote>',
        //'<img src="$s" alt="" />',
    );
    $smilies = array('biggrin', 'cry', 'dizzy', 'funk', 'huffy', 'lol', 'loveliness', 'mad', 'sad', 'shocked', 'shy', 'sleepy', 'smile', 'sweat', 'titter', 'tongue');
    if ($type != BBEDIT_TYPE_SMILEY) {
        $text = preg_replace($search, $replace, $text);
        $text = preg_replace_callback(
            '/\[url(=([^\]]+))?\]([^(\[\/url\])]+)\[\/url\]/i',
            create_function(
                '$matches',
                '$text = $matches[3]; $url = !empty($matches[2]) ? $matches[2] : $text; return "<a href=\"$url\">$text</a>";'
            ),
            $text
        );
    }
    if ($type != BBEDIT_TYPE_TAG) {
        $search2 = $replace2 = array();
        for ($i = 0, $len = count($smilies); $i < $len; $i++) {
            $search2[$i] = sprintf('/\[:Q%s\]/', $smilies[$i]);
            $replace2[$i] = sprintf('<img src="%s/%s.gif" alt="%s" />', $smileyUrl, $smilies[$i], $smilies[$i]);
        }
        $text = preg_replace($search2, $replace2, $text);
    }
    $text = preg_replace('/\[[^\]]*\]/', '', $text);

    return $text;
}
?>