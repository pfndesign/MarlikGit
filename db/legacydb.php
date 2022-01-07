<?php

use Medoo\Medoo;

/**
 * @method array select(string $table, array $columns, array $where)
 * @method null select(string $table, array $columns, callable $callback)
 * @method null select(string $table, array $columns, array $where, callable $callback)
 * @method null select(string $table, array $join, array $columns, array $where, callable $callback)
 * @method mixed get(string $table, array|string $columns, array $where)
 * @method bool has(string $table, array $where)
 * @method mixed rand(string $table, array|string $column, array $where)
 * @method int count(string $table, array $where)
 * @method int max(string $table, string $column)
 * @method int min(string $table, string $column)
 * @method int avg(string $table, string $column)
 * @method int sum(string $table, string $column)
 * @method int max(string $table, string $column, array $where)
 * @method int min(string $table, string $column, array $where)
 * @method int avg(string $table, string $column, array $where)
 * @method int sum(string $table, string $column, array $where)
 */
class legacydb extends Medoo
{
	//
	// Base query method
	//
	function sql_query($query = "", $transaction = FALSE)
	{
		return $this->query($query);
	}
	//
	// Other query methods
	//
	function sql_numrows($result = false)
	{
		if (is_object($result))
			return $result->rowCount();
		else
			return 0;
	}
	function sql_fetchrow($result = false)
	{
		if (is_object($result))
			return $result->fetch();
		else
			return [];
	}
	function sql_nextid()
	{
		return $this->id();
	}
	function sql_freeresult($result = false)
	{
		if (is_object($result))
		$result->closeCursor();
		return true;
	}
}
