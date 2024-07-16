<?php
	class xml
	{
		public function __construct($str, $head = '')
		{
			$this->str = $str;
			$this->head = $head;
		}
		
		public function get_tags($tag, $maxiter = 100000)
		{
			$offset = 0;
			$maxiter--;
			$ret = array();
			do {
				$pos = strpos($this->str, $o = "<{$tag}>", $offset);
				if ($pos === false)
				{
					$pos = strpos($this->str, $o = "<{$tag} ", $offset);
					if ($pos !== false)
					{
						$pos2 = strpos($this->str, '>', $pos) + 1;
						$o = substr($this->str, $pos, $pos2 - $pos);
					}
				}
				if ($pos !== false)
				{
					$pos2 = strpos($this->str, $c = "</{$tag}>", $offset);
					if ($pos2 !== false)
					{
						$head = trim(substr($this->str, $pos + 1 + strlen($tag), strlen($o) - strlen($tag) - 2));
						//var_dump($head);die('here1');
						$ret[] = new xml(substr($this->str, $pos + strlen($o), $pos2 - $pos - strlen($o)), $head);
						$offset = $pos2 + strlen($c);
					}
					else
					{
						$pos2 = strpos($this->str, $c = "/>", $offset);
						$head = trim(substr($this->str, $pos + strlen($tag) + 1, $pos2 - $pos - strlen($tag) - 1));
						//var_dump($head);die('here2');
						$ret[] = new xml('', $head);
						$offset = $pos2 + strlen($c);
					}
				}
			} while ($maxiter-- && $pos !== false && $offset < strlen($this->str));
			return $ret;
		}
		
		public function get_attrs()
		{
			$ret = array();
			
			if (preg_match_all('/\b(\w+)="([^\"]*)"/iUsm', $this->head, $m))
			{
				foreach ($m[1] as $k=>$kk)
					$ret[$kk] = html_entity_decode($m[2][$k], ENT_QUOTES, 'utf-8');
			}
			
			return $ret;
		}
		
		public function get_tag($tag)
		{
			$ret = $this->get_tags($tag, 1);
			if (count($ret))
				return $ret[0];
			return false;
		}
		
		public function str()
		{
			return trim(html_entity_decode($this->str, ENT_QUOTES, 'utf-8'));
		}
	}
?>