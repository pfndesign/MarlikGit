/*
 * jQuery bbcode editor plugin
 *
 * Copyright (C) 2010 Joe Dotoff
 * http://www.w3theme.com/jquery-bbedit/
 *
 * Version 1.0
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
(function($) {
	$.bbedit= {
		lang: {
	  'b' : 'درشت نمایی',
      'i' : 'کج',
      'u' : 'خط زیر',
      's' : 'خط میانی',
      'url' : 'وارد کردن پیوند',
      'img' : 'پیوست تصویر',
      'code' : 'پیوست کد',
      'quote' : 'نقل قول','url':'ایجاد پیوند','img':'ایجاد تصویر','code':'ایجاد کد','quote':'افزودن نقل قول','cool':'Cool','cry':'Cry','embarassed':'Embarassed','foot-in-mouth':'Foot in mouth','frown':'Frown','innocent':'Innocent','kiss':'Kiss','laughing':'Laughing','money-mouth':'Money mouth','sealed':'Sealed','smile':'Smile','surprised':'Surprised','tongue-out':'Tongue out','undecided':'Undecided','wink':'Wink','yell':'Yell'
		}
	}
	;

  $.fn.extend({
    bbedit: function(settings) {
      this.defaults = {
        highlight: false,
        enableToolbar: true,
        enableSmileybar: true,
        lang: 'default',
        smileyPath: 'includes/javascript/jquery/plugins/bbedit/smiley/',
        tags: 'b,i,u,s,url,code,quote',
        smilies: 'biggrin,cry,dizzy,funk,huffy,lol,loveliness,mad,sad,shocked,shy,sleepy,smile,sweat,titter,tongue'
      }
      var settings = $.extend(this.defaults, settings);
      var tags = settings.tags.toLowerCase().split(/,\s*/);
      var toolHtml = '<div class="bbedit-toolbar">';
      for (var i in tags) {
        toolHtml += '<span class="bbedit-' + tags[i] + '" title="' + $.bbedit.lang[tags[i]] + '">&nbsp;</span> ';
      }
      toolHtml += '</div>';
      var smilies = settings.smilies.toLowerCase().split(/,\s*/);
      var smileyHtml = '<div class="bbedit-smileybar">';
      for (var i in smilies) {
        smileyHtml += '<img src="' + settings.smileyPath + '' + smilies[i] + '.gif" class="bbedit-' + smilies[i] + '" alt="' + smilies[i] + '" title="' + $.bbedit.lang[smilies[i]] + '" /> '
      }
      smileyHtml += '</div>';

      return this.each(function() {
        var data = settings;
        data.range = null;
        data.ta = this;
        $(this).bind("select click keyup", function() {
          if (document.selection) {
            data.range = document.selection.createRange();
          }
        });
        if (settings.enableToolbar) {
          var toolbar = $(toolHtml);
          $(this).before(toolbar);
          if ($.browser.msie && parseInt($.browser.version) <= 6) {
            toolbar.children("span").mouseover(function() {
              $(this).addClass("hover");
            }).mouseout(function() {
              $(this).removeClass("hover");
            });
          }
          toolbar.find(".bbedit-b").click(function() {
            insertTag(data, '[b]', '[/b]');
          });
          toolbar.find(".bbedit-i").click(function() {
            insertTag(data, '[i]', '[/i]');
          });
          toolbar.find(".bbedit-u").click(function() {
            insertTag(data, '[u]', '[/u]');
          });
          toolbar.find(".bbedit-s").click(function() {
            insertTag(data, '[s]', '[/s]');
          });
          toolbar.find(".bbedit-code").click(function() {
            insertTag(data, '[code]', '[/code]');
          });
          toolbar.find(".bbedit-quote").click(function() {
            insertTag(data, '[quote]', '[/quote]');
          });
          toolbar.find(".bbedit-url").click(function() {
            insertTag(data, function(text) {
              if (/^https?:\/\//i.test(text)) {
                return '[url]' + text + '[/url]';
              } else {
                var url = prompt('URL: ', '');
                if (url != null && url != '') {
                  if (!/^https?:\/\//i.test(url)) {
                    url = 'http://' + url;
                  }
                  if (text == '') {
                    return '[url]' + url + '[/url]';
                  } else {
                    return '[url=' + url + ']' + text + '[/url]';
                  }
                }
                return false;
              }
            });
          });
          toolbar.find(".bbedit-img").click(function() {
            insertTag(data, function(text) {
              if (/^https?:\/\//i.test(text)) {
                return '[img]' + text + '[/img]';
              } else {
                var url = prompt('Image: ', '');
                if (url != null && url != '') {
                  if (!/^https?:\/\//i.test(url)) {
                    url = 'http://' + url;
                  }
                  return '[img]' + url + '[/img]';
                }
                return false;
              }
            });
          });
        }
        if (settings.enableSmileybar) {
          var smileybar = $(smileyHtml);
          $(this).after(smileybar);
          for (var i in smilies) {
            smileybar.find(".bbedit-" + smilies[i]).click(function() {
              insertTag(data, '[:Q' + $(this).attr("class").replace(/bbedit-/, '') + ']');
            });
          }
        }
      });
    }
  });

  function insertTag(data, tag, tag2) {
    var val, startPos, endPos;
    var ta = data.ta;
    var range = data.range;
    var text = '';
    if (range != null) {
      text = range.text;
    } else if (typeof ta.selectionStart != 'undefined') {
      startPos = ta.selectionStart;
      endPos = ta.selectionEnd;
      text = ta.value.substring(startPos, endPos);
    }
    if (typeof tag == 'function' || typeof tag == 'object') {
      val = tag(text);
      if (val === false) {
        if (range != null) {
          range.moveStart('character', text.length);
          range.select();
        } else if (typeof ta.selectionStart != 'undefined') {
          ta.selectionStart = startPos + text.length;
        }
        ta.focus();
        return;
      }
    } else {
      if (!tag2 || tag2 == '') {
        val = text + tag;
      } else {
        val = tag + text + tag2;
      }
    }
    if (range != null) {
      range.text = val;
      if (data.highlight) {
        range.moveStart('character', -val.length);
        //range.moveEnd('character', 0);
      } else {
        range.moveStart('character', 0);
        //range.moveEnd('character', 0);
      }
      range.select();
    } else if (typeof ta.selectionStart != 'undefined') {
      ta.value = ta.value.substring(0, startPos) + val + ta.value.substr(endPos);
      if (data.highlight) {
        ta.selectionStart = startPos;
        ta.selectionEnd = startPos + val.length;
      } else {
        ta.selectionStart = startPos + val.length;
        ta.selectionEnd = startPos + val.length;
      }
    } else {
      ta.value += val;
    }
    ta.focus();
  }

})(jQuery);