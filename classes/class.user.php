<?php
	class user
	{
		var $p;
		const key = '__basic';
		public function __construct()
		{
			global $db;
			if (@$_SESSION[self::key])
			{
				$a = explode(':', base64_decode($_SESSION[self::key]), 2);
				$recs = $db->query("SELECT * FROM users WHERE user_id = %u AND CONCAT(user, ':', pass) = '%s'", $a[0], @$a[1]);
				if (count($recs))
				{
					$this->p = $recs[0];
				}
			}
			else if (@$_COOKIE[self::key])
			{
				$a = explode(':', base64_decode($_COOKIE[self::key]), 2);
				$recs = $db->query("SELECT * FROM users WHERE user_id = %u AND CONCAT(user, ':', pass) = '%s'", $a[0], @$a[1]);
				if (count($recs))
				{
					$this->p = $recs[0];
					$db->query("UPDATE users SET last_login = %u, last_ip = '%s' WHERE user_id = %u", time(), $_SERVER['REMOTE_ADDR'], $this->p['user_id']);
					$_SESSION[self::key] = $_COOKIE[self::key];
				}
			}
		}

		public function login($user, $pass, $keep = true)
		{
			global $maindw, $db;
			
			$recs = $db->query("SELECT user_id, user, pass, role_id FROM users WHERE (user = '%s' OR email = '%s')", $user, $user);
			if (phash($pass) == $recs[0]['pass'])
			{
				$this->p = $recs[0];
				$db->query("UPDATE users SET last_login = %u, last_ip = '%s' WHERE user_id = %u", time(), $_SERVER['REMOTE_ADDR'], $this->p['user_id']);
				$_SESSION[self::key] = $this->getkey();
				if ($keep)
					setcookie(self::key, $_COOKIE[self::key] = $this->getkey(), time() + 31 * 24 * 60 * 60, '/', $maindw);
				return true;
			}
			return false;
		}
		
		public function login_raw($user, $pass, $keep = true)
		{
			global $maindw, $db;
			
			$recs = $db->query("SELECT user_id, user, pass, role_id FROM users WHERE (user = '%s' OR email = '%s')", $user, $user);
			if ($pass == $recs[0]['pass'])
			{
				$this->p = $recs[0];
				$db->query("UPDATE users SET last_login = %u, last_ip = '%s' WHERE user_id = %u", time(), $_SERVER['REMOTE_ADDR'], $this->p['user_id']);
				$_SESSION[self::key] = $this->getkey();
				if ($keep)
					setcookie(self::key, $_COOKIE[self::key] = $this->getkey(), time() + 31 * 24 * 60 * 60, '/', $maindw);
				return true;
			}
			return false;
		}
		
		public function rekey()
		{
			global $db, $maindw;
			$recs = $db->query("SELECT * FROM users WHERE user_id = %u", $this->p['user_id']);
			$this->p = $recs[0];
			$_SESSION[self::key] = $this->getkey();
			if (@$_COOKIE[self::key])
				setcookie(self::key, $_COOKIE[self::key] = $this->getkey(), time() + 31 * 24 * 60 * 60, '/', $maindw);
		}

		public function getkey()
		{
			return base64_encode("{$this->p['user_id']}:{$this->p['user']}:{$this->p['pass']}");
		}
		
		public function logout()
		{
			if ($this->logged_in())
			{
				global $maindw;
				setcookie(self::key, false, time() + 31 * 24 * 60 * 60, '/', $maindw);
				unset($_SESSION[self::key]);
				$_SESSION[self::key] = '';
				$this->p = false;
			}
		}

		public static function die_login($add = '')
		{
			global $url_proto, $maindw, $bt;
			
			$go = "{$url_proto}://{$maindw}{$bt}";
			if ($add)
				$go .= "?{$add}";
			
			header("Location: {$go}");
			die();
		}
		
		public function logged_in()
		{
			return (bool)$this->p;
		}
	}
?>