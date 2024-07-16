<?php
	class db
	{
		function db($p)
		{
			$this->p = $p;
			$this->link = false;
		}

		function connect()
		{
			if (isset($this->p['sock']))
				$this->link = mysqli_connect(null, $this->p['user'], $this->p['pass'], $this->p['db'], 3306, $this->p['sock']) or $this->error('Socket Connect');
			else if (isset($this->p['host']))
				$this->link = mysqli_connect($this->p['host'], $this->p['user'], $this->p['pass'], $this->p['db']) or $this->error('Host Connect');
			$this->raw("SET NAMES 'utf8mb4'");
		}

		function query($q)
		{
			if (!$this->link)
				$this->connect();
			$a = func_get_args();
			$a = array_slice($a, 1);
			$a = $this->escape($a);
			foreach ($a as $k=>$v)
				if (is_array($v))
					$a[$k] = "'".implode("','", $v)."'";
			$qs = vsprintf($q, $a);
			$res = mysqli_query($this->link, $qs) or $this->error($qs);
			$this->insert_id = mysqli_insert_id($this->link);
			return db::get_result($res);
		}

		function raw($q)
		{
			if (!$this->link)
				$this->connect();
			$a = func_get_args();
			$a = array_slice($a, 1);
			$a = $this->escape($a);
			foreach ($a as $k=>$v)
				if (is_array($v))
					$a[$k] = "'".implode("','", $v)."'";
				$qs = vsprintf($q, $a);
			$res = mysqli_query($this->link, $qs) or $this->error($qs);
			return $res;
		}

		function queue($q)
		{
			$a = func_get_args();
			$a = array_slice($a, 1);
			$a = $this->escape($a);
			foreach ($a as $k=>$v)
				if (is_array($v))
					$a[$k] = "'".implode("','", $v)."'";
			$qs = vsprintf($q, $a);
			if (mb_strlen($qs, 'utf-8') < 255)
			{
				$this->query("INSERT DELAYED INTO q_q (q) VALUES ('%s')", $qs);
			}
			else
			{
				mysqli_query($this->link, $qs) or $this->error($qs);
			}
		}

		function escape($var)
		{
			if (!$this->link)
				$this->connect();
			if (!is_array($var))
				return mysqli_real_escape_string($this->link, $var);
			else
			{
				foreach ($var as $k=>$v)
					$var[$k] = $this->escape($v);
				return $var;
			}
		}

		function get_result($res)
		{
			if (@mysqli_num_rows($res))
			{
				$arr = array();
				while ($row = mysqli_fetch_assoc($res))
					$arr[] = $row;
				return $arr;
			}

			return array();
		}

		static function shallow($arr)
		{
			$arr2 = array();
			foreach ($arr as $v)
				$arr2[] = array_pop($v);
			return $arr2;
		}

		static function one($arr)
		{
			$x = db::shallow($arr);
			return array_pop($x);
		}

		static function first($arr)
		{
			return count($arr)?array_pop($arr):false;
		}

		static function assoc($arr)
		{
			$ret = array();
			foreach ($arr as $v)
			{
				$key = array_shift($v);
				if (count($v) > 1)
					$val = $v;
				else
					$val = array_shift($v);
				$ret[$key] = $val;
			}
			return $ret;
		}

		static function choose($arr, $k)
		{
			$ret = array();
			foreach ($arr as $v)
				$ret[] = $v[$k];
			return $ret;
		}

		function affected_rows()
		{
			return mysqli_affected_rows($this->link);
		}

		function insert_id()
		{
			return $this->insert_id;
		}

		function found_rows()
		{
			return self::one($this->query("SELECT FOUND_ROWS();"));
		}

		function split_condition($q)
		{
			$args = func_get_args();
			$args = array_slice($args, 1);
			$w = preg_split("/\s+/", $q);
			$w = array_unique($w);
			$w = array_diff($w, array(''));
			$Q = '1';
			foreach ($w as $word)
			{
				$word = $this->escape($word);
				$Q .= ' AND (0';
				foreach ($args as $field)
				{
					$Q .= " OR {$field} LIKE '%%{$word}%%'";
				}
				$Q .= ')';
			}
			return $Q;
		}

		function error($qs)
		{
			$str = '<div style=""><span style="">'.$qs.'</span><br />'.mysqli_error($this->link).'</div>';
			die($str);
		}
	}
?>