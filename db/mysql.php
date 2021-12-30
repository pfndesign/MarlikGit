<?php

/***************************************************************************
 *                                 mysql.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   updated              : Thursday, December 30, 2021 
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: mysql.php 5211 2005-09-18 16:17:21Z acydburn $
 *   $Id: mysql.php 6000 2021-12-30T18:08:04+01:00 pfndesign $
 *
 ***************************************************************************/
/**
 * status : don't use
 */

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if (!defined("SQL_LAYER")) {

	define("SQL_LAYER", "mysql");

	class sql_db
	{

		var $db_connection;
		var $query_result;
		var $row = array();
		var $rowset = array();
		var $num_queries = 0;
		var $sql_time = 0;
		//
		// Constructor
		//
		function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true, $charset = 'utf8')
		{

			$this->persistency = $persistency;
			$this->user = $sqluser;
			$this->password = $sqlpassword;
			$this->server = $sqlserver;
			$this->dbname = $database;

			if ($this->persistency) {
				$this->db_connection = new mysqli('p:' . $this->server, $this->user, $this->password);
			} else {
				$this->db_connection = new mysqli($this->server, $this->user, $this->password);
			}
			// if db is succecfullly connected
			if ($this->db_connection) {
				if ($database != "") {
					// set database
					$this->dbname = $database;
					// select db
					$dbselect = $this->db_connection->select_db($this->dbname);
					// set db charset
					$this->db_connection->set_charset($charset);

					if (!$dbselect) {
						$this->db_connection->close();
						$this->db_connection = false;
					}
				}
				return $this->db_connection;
			} else {
				return false;
			}
		}

		//
		// Other base methods
		//
		function sql_close()
		{
			if ($this->db_connection) {
				if ($this->query_result) {
					$this->query_result->free_result();
				}
				$result = $this->db_connection->close();
				return $result;
			} else {
				return false;
			}
		}

		//
		// Base query method
		//
		function sql_query($query = "", $transaction = FALSE)
		{
			// Remove any pre-existing queries
			unset($this->query_result);
			if ($query != "") {
				$this->num_queries++;
				$this->query_result = $this->db_connection->query($query);
			}
			//Debug
			//if(isset($_COOKIE['admin']))	echo "QUERY: $query | COUNT:  $this->num_queries <hr>=======<hr>" ;
			if ($this->query_result) {
				$rowname = serialize($this->query_result);
				unset($this->row[$rowname]); //hmm
				unset($this->rowset[$rowname]); //hmm
				return $this->query_result;
			} else {
				return ($transaction == END_TRANSACTION) ? true : false;
			}
		}

		//
		// Other query methods
		//
		function sql_numrows($result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$result = mysqli_num_rows($result);
				return $result;
			} else {
				return false;
			}
		}
		function sql_affectedrows()
		{
			if ($this->db_connection) {
				$result = $this->db_connection->affected_rows;
				return $result;
			} else {
				return false;
			}
		}
		function sql_numfields($result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$result = mysqli_num_fields($result);
				return $result;
			} else {
				return false;
			}
		}
		function sql_fieldname(int $offset, $result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$result = mysqli_fetch_field_direct($result, $offset);
				return is_object($result) ? $result->name : false;
			} else {
				return false;
			}
		}
		function sql_fieldtype(int $offset, $result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$result = mysqli_fetch_field_direct($result, $offset);
				return is_object($result) ? $result->type : false;
			} else {
				return false;
			}
		}
		function sql_fetchrow($result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$rowname = serialize($result);
				$this->row[$rowname] = mysqli_fetch_array($result);
				return $this->row[$rowname];
			} else {
				return false;
			}
		}
		function sql_fetchrowset($result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$rowname = serialize($result);
				unset($this->rowset[$rowname]);
				unset($this->row[$rowname]);
				while ($this->rowset[$rowname] = mysqli_fetch_array($result)) {
					$result[] = $this->rowset[$rowname];
				}
				return $result;
			} else {
				return false;
			}
		}
		function mysqli_result($res, $row = 0, $col = 0)
		{
			$numrows = mysqli_num_rows($res);
			if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
				mysqli_data_seek($res, $row);
				$resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
				if (isset($resrow[$col])) {
					return $resrow[$col];
				}
			}
			return false;
		}
		function sql_fetchfield($field, $rownum = -1, $result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				if ($rownum > -1) {
					$result = $this->mysqli_result($result, $rownum, $field);
				} else {
					$rowname = serialize($result);
					if (empty($this->row[$rowname]) && empty($this->rowset[$rowname])) {
						if ($this->sql_fetchrow()) {
							$result = $this->row[$rowname][$field];
						}
					} else {
						if ($this->rowset[$rowname]) {
							$result = $this->rowset[$rowname][0][$field];
						} else if ($this->row[$rowname]) {
							$result = $this->row[$rowname][$field];
						}
					}
				}
				return $result;
			} else {
				return false;
			}
		}
		function sql_rowseek($rownum, $result = false)
		{
			if (is_null(!$result)) {
				$result = $this->query_result;
			}
			if ($result) {
				$result = mysqli_data_seek($result, $rownum);
				return $result;
			} else {
				return false;
			}
		}
		function sql_nextid()
		{
			if ($this->db_connection) {
				$result = $this->db_connection->insert_id;
				return $result;
			} else {
				return false;
			}
		}
		function sql_freeresult($result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			if ($result) {
				$rowname = serialize($result);
				unset($this->row[$rowname]);
				unset($this->rowset[$rowname]);
				if (is_a($result, 'mysqli_result'))
					mysqli_free_result($result);
				return true;
			} else {
				return false;
			}
		}
		function sql_error($result = false)
		{
			if (!$result) {
				$result = $this->query_result;
			}
			$result["message"] = mysqli_error($result);
			$result["code"] = mysqli_errno($result);

			return $result;
		}
	}
}
