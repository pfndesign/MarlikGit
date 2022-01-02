<?php

/**
*
* @package BBCODE CLASS														
* @version $Id: inc_bbcode.php RC-7 11:49 AM 1/2/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
//cnstansts-----------------------
define("__SMILEY_DIR","images/smiley/");
define("__SMILEY_FORMAT",".gif");
//----------------------------


function begtoend($htmltag){
	return preg_replace('/<([A-Za-z]+)>/','</$1>',$htmltag);
}
function replace_pcre_array($text,$array){
	$pattern = array_keys($array);
	$replace = array_values($array);
	$text = preg_replace($pattern,$replace,$text);
	return $text;
}
class bbcode{
	var $tags;
	var $settings;
	function __construct(){
		$this->tags = array();
		$this->settings = array('enced'=>true);
	}
	function get_data($name,$cfa = ''){
		if(!array_key_exists($name,$this->tags)) return '';
		$data = $this->tags[$name];
		if($cfa) $sbc = $cfa; else $sbc = $name;
		if(!is_array($data)){
			$data = preg_replace('/^ALIAS(.+)$/','$1',$data);
			return $this->get_data($data,$sbc);
		}else{
			$data['Name'] = $sbc;
			return $data;
		}
	}
	function change_setting($name,$value){
		$this->settings[$name] = $value;
	}
	function add_alias($name,$aliasof){
		if(!array_key_exists($aliasof,$this->tags) or array_key_exists($name,$this->tags)) return false;
		$this->tags[$name] = 'ALIAS'.$aliasof;
		return true;
	}
	function onparam($param,$regexarray){
		$param = replace_pcre_array($param,$regexarray);
		if(!$this->settings['enced']){
			$param = htmlentities($param);
		}
		return $param;
	}
	function export_definition(){
		return serialize($this->tags);
	}
	function import_definiton($definition,$mode = 'append'){
		switch($mode){
			case 'append':
			$array = unserialize($definition);
			$this->tags = $array + $this->tags;
			break;
			case 'prepend':
			$array = unserialize($definition);
			$this->tags = $this->tags + $array;
			break;
			case 'overwrite':
			$this->tags = unserialize($definition);
			break;
			default:
			return false;
		}
		return true;
	}
	function add_tag($params){
		if(!is_array($params)) return 'Paramater array not an array.';
		if(!array_key_exists('Name',$params) or empty($params['Name'])) return 'Name parameter is required.';
		if(preg_match('/[^A-Za-z]/',$params['Name'])) return 'Name can only contain letters.';
		if(!array_key_exists('HasParam',$params)) $params['HasParam'] = false;
		if(!array_key_exists('HtmlBegin',$params)) return 'HtmlBegin paremater not specified!';
		if(!array_key_exists('HtmlEnd',$params)){
			 if(preg_match('/^(<[A-Za-z]>)+$/',$params['HtmlBegin'])){
			 	$params['HtmlEnd'] = begtoend($params['HtmlBegin']);
			 }else{
			 	return 'You didn\'t specify the HtmlEnd parameter, and your HtmlBegin parameter is too complex to change to an HtmlEnd parameter.  Please specify HtmlEnd.';
			 }
		}
		if(!array_key_exists('ParamRegexReplace',$params)) $params['ParamRegexReplace'] = array();
		if(!array_key_exists('ParamRegex',$params)) $params['ParamRegex'] = '[^\\]]+';
		if(!array_key_exists('HasEnd',$params)) $params['HasEnd'] = true;
		if(array_key_exists($params['Name'],$this->tags)) return 'The name you specified is already in use.';
		$this->tags[$params['Name']] = $params;
		return '';
	}
	function parse_bbcode($text){
		foreach($this->tags as $tagname => $tagdata){
			if(!is_array($tagdata)) $tagdata = $this->get_data($tagname);
			$startfind = "/\\[{$tagdata['Name']}";
			if($tagdata['HasParam']){
				$startfind.= '=('.$tagdata['ParamRegex'].')';
			}
			$startfind.= '\\]/';
			if($tagdata['HasEnd']){
				$endfind = "[/{$tagdata['Name']}]";
				$starttags = preg_match_all($startfind,$text,$ignore);
				$endtags = substr_count($text,$endfind);
				if($endtags < $starttags){
					$text.= str_repeat($endfind,$starttags - $endtags);
				}
				$text = str_replace($endfind,$tagdata['HtmlEnd'],$text);
			}
			$replace = str_replace(array('%%P%%','%%p%%'),'\'.$this->onparam(\'$1\',$tagdata[\'ParamRegexReplace\']).\'','\''.$tagdata['HtmlBegin'].'\'');
			$text = preg_replace($startfind.'e',$replace,$text);
		}
		return $text;
	}
}
class SimpleParser
{

    ## First off, the data this class needs in order to work.
    
    private	$smileyList = array(
    
				':D'		=> '<img src="images/smiley/icon_biggrin.gif" >',

				':)'		=> '<img src="images/smiley/icon_smile.gif" >',

				':('		=> '<img src="images/smiley/icon_sad.gif" >',

				':o'		=> '<img src="images/smiley/icon_surprised.gif" >',

				':shock:'	=> '<img src="images/smiley/icon_eek.gif" >',

				 ':?'		=> '<img src="images/smiley/icon_confused.gif" >',

				 ':?:'		=> '<img src="images/smiley/icon_question.gif" >',

				'8)'		=> '<img src="images/smiley/icon_cool.gif" >',

				':lol:'		=> '<img src="images/smiley/icon_lol.gif" >',

				':P'		=> '<img src="images/smiley/icon_razz.gif" >',

				':red:'		=> '<img src="images/smiley/icon_redface.gif" >',

				':cry:'		=> '<img src="images/smiley/icon_cry.gif" >',

				':evil:'	=> '<img src="images/smiley/icon_evil.gif" >',

				'twisted:'	=> '<img src="images/smiley/icon_twisted.gif" >',

				':roll:'	=> '<img src="images/smiley/icon_rolleyes.gif" >',

				':wink:'	=> '<img src="images/smiley/icon_wink.gif" >',

				 ':!:'		=> '<img src="images/smiley/icon_exclaim.gif" >',

				':?:'		=> '<img src="images/smiley/icon_question.gif" >',

				':idea:'	=> '<img src="images/smiley/icon_idea.gif" >',

				':green:'	=> '<img src="images/smiley/icon_mrgreen.gif" >',

				':frown:'	=> '<img src="images/smiley/icon_frown.gif" >',

				':mad:'		=> '<img src="images/smiley/icon_mad.gif" >',

				':neutral:' =>'<img src="images/smiley/icon_neutral.gif" >',

				':arrow:'	=> '<img src="images/smiley/icon_arrow.gif" >'

			);

    
    //Bad word list
    private $badWordList = array('احمق','نفهم','الاغ','خر ');
    //Word to Replace with
    private $goodWord = '-----';
    
    ## Main Functions to interact with class
    public function parseText($text,$smileys=1,$badwords=1){
        $text = str_replace('://','#link#',$text);
        //run
        if($smileys==1){
            $text = $this->parseSmiley($text);
        }
        if($badwords==1){
            $text = $this->parseBadWords($text);
        }
        //fix
        return str_replace('#link#','://',$text);
    }
    //get back orignal string
    public function unParseText($text){
        return $this->unParseSmiley($text);
    }
	public function read_smiley_dir(){

	if($handle = opendir(__SMILEY_DIR)){

		$content =  '';

		while (false !== ($file = readdir($handle))) {

			if(is_file(__SMILEY_DIR.$file)){

				if ((substr($file, -4) == __SMILEY_FORMAT)) {

					$texted_ico = $this->unParseSmiley('<img src="'.__SMILEY_DIR.$file.'" >');

					$content .=  '&nbsp;<a href="javascript:emotion_add_'.$texted_ico.'" class="add_emo" id="'.$texted_ico.'"><img src="'.__SMILEY_DIR.$file.'"></a>'."\n";

				}

			}

		}

	}

	return $content;

	}
	public function jq_toggle_box($id,$atb,$box){
		echo "<script type=\"text/javascript\">
 $(document).ready(function() {
 // toggles the slickbox on clicking the noted link
  $('$atb#$id').click(function() {
 $('#$box').toggle(400);
 return false;
  });

});
</script>";
	}
	
	## Functions to perform actions

    private function parseSmiley($text){
        return str_ireplace(array_keys($this->smileyList),$this->smileyList,$text);
    }
    private function unParseSmiley($text){
        return str_replace($this->smileyList,array_keys($this->smileyList),$text);
    }
    private function parseBadWords($text){
        return str_replace($this->badWordList,$this->goodWord,$text);
    }
} 

?>