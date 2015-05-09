<?php

/**
 *
 * @package html editorial source														
 * @version  inc_htmlclean.php $Id: beta6 $ 2:12 AM 12/25/2009						
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_htmlclean.php" )) {
	show_error ( HACKING_ATTEMPT );
}

define ( 'INCLUDES_PATH', 'includes/' );
require_once ("mainfile.php");

class MenuBuilder {
	var $conn;
	var $items;
	var $menu;
	var $html;
	
	function get_menu_data($sql, $link, $column_ID, $column_parent, $column_TITLE, $ui_id, $associated = '', $menu_type = '') {
		
		$this->_SQL = "$sql";
		
		$this->_ID = "$column_ID";
		$this->_PARENT = "$column_parent";
		$this->_TITLE = "$column_TITLE";
		$this->_MENU_UI_ID = "$ui_id";
		$this->_MENU_TYPE = "$menu_type";
		$this->_ASSOCIATED = "$associated";
	}
	
	function fetch_assoc_all($sql) {
		global $db;
		$result = $db->sql_query ( $sql );
		
		if (! $result)
			return false;
		
		$assoc_all = array ();
		
		while ( $fetch = $db->sql_fetchrow ( $result ) )
			$assoc_all [] = $fetch;
		
		$db->sql_freeresult ( $result );
		
		return $assoc_all;
	}
	
	function get_menu_items() {
		return $this->fetch_assoc_all ( $this->_SQL );
	}
	
	function build_menu_array() {
		global $nextg, $currentlang;
		$this->items = $this->get_menu_items ();
		
		if (empty ( $this->items ))
			return '';
		
		foreach ( $this->items as $item )
			$children [$item [$this->_PARENT]] [] = $item;
		
		$root = array ();
		$root ['html_before'] = '<ul  id="' . $this->_MENU_UI_ID . '" class="filetree">';
		$root ['html_after'] = '</ul>';
		
		$parent = 0;
		$tree = array ();
		$current_tree = &$tree;
		$tree_stack = $parent_stack = array ();
		
		if (empty ( $children [$parent] ))
			return '';
		
			
		while ( ($option = each ( $children [$parent] )) || ($parent > 0) ) {
			if ($option === false) {
				unset ( $current_tree );
				$current_tree = &$tree_stack [count ( $tree_stack ) - 1];
				array_pop ( $tree_stack );
				$parent = array_pop ( $parent_stack );
			} elseif (empty ( $children [$option ['value'] [$this->_ID]] )) {
				$data = array ();
				$icon_cat = ($currentlang == "persian") ? "pe-list.png" : "list.png";
				
				if ($this->_PARENT == "ownerEl") {
					$this->_LINK = '' . $this->processEl ( $option ['value'] ['name'], $option ['value'] ['link'], $option ['value'] ['module'], $option ['value'] ['icon'], $option ['value'] ['lang'] ) . '';
				} elseif ($this->_TITLE == "topicname") {
					//CheckBox Selector for CHILDREN-----
					if ($this->_MENU_TYPE == "checkbox") {
						//ASSOCIATES ---CHILDREN---
						$asso_arr = explode ( "-", trim($this->_ASSOCIATED));
						for($i = 0; $i < sizeof ($asso_arr); $i ++) {
							if ($asso_arr[$i] == $option ['value'] ['' . $this->_ID . '']) {
								$checked = "CHECKED ";
								break;
							}
						}
						
						$this->_LINK = '<input type="checkbox"  id="display" name="assotop[]" value="' . $option ['value'] ['' . $this->_ID . ''] . '" ' . $checked . '>' . $option ['value'] ['topicname'] . '';
					} else {
						$this->_LINK = '<a href="modules.php?name=News&file=categories&category=' . $option ['value'] ['slug'] . '" >
						<img src="images/icon/' . $icon_cat . '">' . urldecode($option ['value'] ['topicname']) . '</a>';
					}
				
				} else {
					$this->_LINK = '<img src="images/icon/' . $icon_cat . '">' . "$link";
				}
				
				$data ['html'] = str_repeat ( "\t", count ( $tree_stack ) + 1 ) . '<li><span class="file">' . $this->_LINK . '</span></li>';
				$current_tree [] = $data;
			} else {
				$data = array ();
				
				//ASSOCIATES ---PARENTS---
				$asso_t_p = explode ( "-", trim($this->_ASSOCIATED));
				for($i = 0; $i < sizeof ( $asso_t_p ); $i ++) {
					if ($asso_t_p[$i] == $option ['value'] ['' . $this->_ID . '']) {
						$checkedforParent = "CHECKED ";
					}
				}
				print_r($this->_ASSOCIATED);
				
				$data ['html_before'] = str_repeat ( "\t", count ( $tree_stack ) + 1 );
				$folder_icon = (! empty ( $option ['value'] ['icon'] )) ? $option ['value'] ['icon'] : "folder.png";
				$link = explode ( "|", $option ['value'] ['link'] );
				if (empty ( $option ['value'] ['lang'] ) or $option ['value'] ['lang'] == $currentlang) {
					$data ['html_before'] .= '<li><span class="folder">';
					
					//CheckBox Selector for PARENTS-----
					if ($this->_MENU_TYPE == "checkbox") {
						$data ['html_before'] .= '<input type="checkbox" name="assotop[]" value="' . $option ['value'] ['' . $this->_ID . ''] . '"  ' . $checkedforParent . '>' .langit( $option ['value'] ['' . $this->_TITLE . '']) . '';
					} else {
						
						if ($option ['value'] ['module'] != "") {
							$data ['html_before'] .= '<a href="modules.php?name=' . $option ['value'] ['module'] . '" target="' . $link [1] . '"><img src="images/icon/' . $folder_icon . '" />' . langit( $option ['value'] ['' . $this->_TITLE . '']) . '</a>';
						} elseif ($link [0] != "") {
							$data ['html_before'] .= '<a href="' . $link [0] . '" target="' . $link [1] . '"><img src="images/icon/' . $folder_icon . '" />' .langit( $option ['value'] ['' . $this->_TITLE . '']) . '</a>';
						} else {
							if ($this->_TITLE == "topicname") {
								$data ['html_before'] .= '<a href="modules.php?name=News&file=categories&category=' . $option ['value'] ['slug'] . '" >
						<img src="images/icon/' . $folder_icon . '">' . urldecode($option ['value'] ['topicname']) . '</a>';
							} else {
								$data ['html_before'] .= '<img src="images/icon/' . $folder_icon . '" />' . langit($option ['value'] ['' . $this->_TITLE . '']) . '';
							}
						
						}
					
					}
					
					$data ['html_before'] .= '</span>';
					$data ['html_before'] .= "\r\n" . str_repeat ( "\t", count ( $tree_stack ) + 1 );
					$data ['html_before'] .= '<ul id="' . $option ['value'] ['' . $this->_ID . ''] . '">';
					$data ['html_after'] .= str_repeat ( "\t", count ( $tree_stack ) + 1 ) . '</ul></li>';
					
					$data_children = array ();
					$data ['children'] = &$data_children;
					$current_tree [] = $data;
					$tree_stack [] = &$current_tree;
					array_push ( $parent_stack, $option ['value'] ['' . $this->_PARENT . ''] );
					unset ( $current_tree );
					$current_tree = &$data_children;
					unset ( $data_children );
					$parent = $option ['value'] ['' . $this->_ID . ''];
				}
			}
		unset ( $checked );
		unset ( $checkedforParent );
		}
		
		
		$root ['children'] = $tree;
		return array ($root );
	}
	
	function build_item_html($item) {
		foreach ( $item as $element )
			if (isset ( $element ['html'] ))
				$this->html [] = $element ['html'];
			else {
				$this->html [] = $element ['html_before'];
				$this->build_item_html ( $element ['children'] );
				$this->html [] = $element ['html_after'];
			}
	}
	
	function get_menu_html($item) {
		$this->html = array ();
		$this->menu = $this->build_menu_array ();
		$this->build_item_html ( $this->menu );
		return implode ( "\r\n", $this->html );
	}
	
	function processEl($name, $link, $module, $icon, $lang) {
		global $currentlang;
		$link = explode ( "|", $link );
		if ($currentlang == "persian") {
			$icon = (! empty ( $icon )) ? $icon : "pe-list.png";
		} else {
			$icon = (! empty ( $icon )) ? $icon : "list.png";
		}
		
		if (empty ( $lang ) or $lang == $currentlang) {
			
			if ($module != "") {
				$a = '<a href="modules.php?name=' . $module . '" target="' . $link [1] . '"><img src="images/icon/' . $icon . '" /> ' . langit( $name ) . '</a>';
			} elseif ($link [0] != "") {
				$a = '<a href="' . $link [0] . '" target="' . $link [1] . '"><img src="images/icon/' . $icon . '" />' . langit( $name ) . '</a>';
			} else {
				$a = '<img src="images/icon/' . $icon . '" />' . langit( $name );
			}
		}
		return $a;
	}

}

?>