<?php
	class runner
	{
		public function __construct()
		{
			global $db;
			
			$this->sleep_cycle = 60;
			$this->last_f_news = -1;
			$this->last_sched = -1;
			$this->last_gbook = -1;
			$this->last_s_check = date('j');
			$this->last_l_check = -1;
			$this->last_ko_check = -1;
			$this->last_q_check = -1;
			$this->season = bc::get_season('A');
			$this->in_season = (bool)$this->season;
			if ($this->in_season)
				$this->week = bc::get_week($this->season['year'], 'G');
		}
		
		public function main()
		{
			global $db;
			
			while (1)
			{
				$d_now = date('j');
				$m5_now = floor(date('i') / 5);
				$h_now = date('G');
				if ($h_now < 12 || $h_now >= 23)
				{
					//don't do anything in crazy hours
					sleep($this->sleep_cycle * 10);
					continue;
				}
				
				if ($this->last_s_check != $d_now)
				{
					$this->season = bc::get_season('A');
					$this->in_season = (bool)$this->season;
					if ($this->in_season)
						$this->week = bc::get_week($this->season['year'], 'G');
					$this->last_s_check = $d_now;
					
					if (!$this->in_season)
					{
						//can probably sleep for more if there's no season
						sleep($this->sleep_cycle * 100);
						continue;
					}
				}
				
				if ($this->in_season && $this->last_f_news != $d_now)
				{
					self::f_news();
					$this->last_f_news = $d_now;
				}
				if ($this->in_season && $this->last_sched != $d_now)
				{
					self::sched();
					$this->last_sched = $d_now;
				}
				if ($this->in_season && $this->last_l_check != $m5_now)
				{
					$this->live_upd();
					$this->last_l_check = $m5_now;
				}
				if ($this->in_season && $this->last_gbook != $d_now)
				{
					self::gbook();
					$this->last_gbook = $d_now;
				}
				
				if ($this->in_season && $this->last_ko_check != $m5_now)
				{
					self::ko_check();
					$this->last_ko_check = $m5_now;
				}
				
				if ($this->in_season && $this->last_q_check != $m5_now)
				{
					$ret = self::m_q();
					$this->last_q_check = $m5_now;
					if ($ret)
					{
						//if it did actually send anything only sleep for a fraction of the regular cycle
						sleep(5);
						continue;
					}
				}
				
				sleep($this->sleep_cycle);
			}
		}
		
		public function m_q()
		{
			global $db;
			
			if (!db::one($db->query("SELECT v FROM settings WHERE k = '%s'", 'free_auto')))
				return false;
			
			$cnt = 0;
			
			$picks = array();
			
			$recs = $db->query("SELECT * FROM m_q WHERE year = %u AND week = %u AND status = 'Q' ORDER BY entry_id ASC LIMIT 100", $this->season['year'], $this->week);
			foreach ($recs as $k=>$r)
			{
				//check if this is waaaay over the frame for sending?
				
				if (!isset($picks[$r['type']]))
				{
					$picks[$r['type']] = sub::get_picks($this->season['year'], $this->week, $r['type'], 1, explode(',', $r['gids']));
					pp::games($picks[$r['type']]);
				}
				
				if (!count($picks[$r['type']]))
				{
					//for some reason there are no picks
					echo "No picks for {$r['type']}\n";
					continue;
				}
				
				$sub = db::first($db->query("SELECT * FROM subs WHERE sub_id = %u", $r['sub_id']));
				if ($sub['bounced'])
				{
					$db->query("UPDATE m_q SET status = 'B' WHERE entry_id = %u", $r['entry_id']);
					continue;
				}
				
				$data = $sub;
				$data['year'] = $this->season['year'];
				$data['week'] = $this->week;
				$data['picks'] = $picks[$r['type']];
				
				echo "Send to {$sub['email']}";
				sub::send_one($r['type'], $data);
				$db->query("UPDATE m_q SET status = 'S', s_ts = %u WHERE entry_id = %u", time(), $r['entry_id']);
				echo " K\n";
				if ($k >= count($recs) - 1)
					sleep(2);
				//die();
			}
			
			return $cnt;
		}
		
		public function ko_check()
		{
			global $db, $time_offset;
			
			if (!db::one($db->query("SELECT v FROM settings WHERE k = '%s'", 'free_auto')))
				return false;
			
			echo "KO Check\n";
			
			$merge_period = 21 * 60;
			
			//if there's a game within 15 minutes then return and do it on the next pass
			if (count($recs = $db->query("SELECT game_id, g_ts FROM games WHERE year = %u AND week = %u AND g_ts BETWEEN %u AND %u AND ko_mq = 0 AND pick != ''", $this->season['year'], $this->week, time() + $time_offset + 1, time() + $time_offset + $merge_period)))
			{
				echo "Game within ".(floor(($recs[0]['g_ts'] - time() - $time_offset) / 60))." min\n";
				return;
			}
			
			//add status = q1 or whatever to this query
			$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u AND g_ts < %u AND ko_mq = 0 AND pick != ''", $this->season['year'], $this->week, time() + $time_offset);
			
			echo date('c', time() + $time_offset)." < now\n";
			foreach ($recs as $r)
			{
				echo date('c', $r['g_ts'])." < game\n";
			}
			
			if (!count($recs))
			{
				echo "No picks to queue\n";
				return;
			}
			
			sub::queue_all('all_ko');
			sub::queue_all('best_ko');
			
			$db->query("UPDATE games SET ko_mq = 1 WHERE game_id IN (%s)", db::choose($recs, 'game_id'));
			
			die("KO\n");
		}
		
		public static function gbook()
		{
			global $db, $media_base;
			
			$ta = db::assoc($db->query("SELECT team_id, code FROM teams"));
			
			$recs = $db->query("SELECT game_id, code, h_team_id, gb_ts, gb_link, year FROM games WHERE status = 'F' AND (gb_link = '' OR (g_ts > %u AND gb_ts < %u))", time() - 7 * 24 * 3600, time() - 1 * 24 * 3600);
			foreach ($recs as $r)
			{
				$code = $ta[$r['h_team_id']];
				if ($code == 'LAR')
					$code = 'LA';
				$url = "http://www.nfl.com/liveupdate/gamecenter/{$r['code']}/{$code}_Gamebook.pdf";
				$d = "{$media_base}/gb/{$r['year']}";
				if (!is_dir($d))
				{
					mkdir($d);
					wwwown($d);
				}
				$tf = "{$d}/{$r['game_id']}.pdf";
				
				if (!$r['gb_link'] && $r['gb_ts'] > time() - 1 * 24 * 3600) //no gb_link, but gb_ts -> failed previous download, do not keep banging
					continue;
				
				echo "DL {$url}\n";
				
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_REFERER, 'https://digitalcare.nfl.com/hc/en-us/articles/225722828-Gamebooks');
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HEADER, 1);
				
				$ret = curl_exec($ch);
				$info = curl_getinfo($ch);
				curl_close($ch);
				
				$a = explode("\r\n\r\n", $ret, 2);
				$headers = $a[0];
				$ret = $a[1];
				$a = '';
				
				$h = parse_headers($headers);
				
				if ($info['http_code'] != 200)
				{
					if (!$r['gb_link'])
						$db->query("UPDATE games SET gb_ts = %u WHERE game_id = %u", time(), $r['game_id']);
					echo "HTTP {$info['http_code']} {$url}\n";
					continue;
				}
				
				$m_ts = strtotime($h['Last-Modified']);
				if (!is_file($tf) || $r['gb_ts'] < $m_ts)
				{
					file_put_contents($tf, $ret);
					$ret = '';
					$db->query("UPDATE games SET gb_ts = %u, gb_link = '%s' WHERE game_id = %u", $m_ts, $url, $r['game_id']);
				}
				
				//die();
			}
		}
		
		public function live_upd()
		{
			global $db;
			
			if (!count($db->query("SELECT game_id FROM games WHERE year = %u AND status != 'F' AND g_ts > %u", $this->season['year'], time())))
				return;
			
			$min_wk = db::one($db->query("SELECT MIN(week) FROM games WHERE year = %u AND status != 'F' AND g_ts > %u", $this->season['year'], time()));
			if ($min_wk > 17)
				$url = 'http://www.nfl.com/liveupdate/scorestrip/postseason/ss.xml';
			else
				$url = 'http://www.nfl.com/liveupdate/scorestrip/ss.xml';
			
			$ret = file_get_contents($url);
			$xml = new xml($ret);
			
			$gms = $xml->get_tags('gms');
			if (!count($gms))
				return;
			
			$g_ts = $gms[0]->get_tags('g');
			foreach ($g_ts as $g)
			{
				$p = $g->get_attrs();
				if (!$p['hnn'])
					continue;
				$code = $p['gsis'];
				$h_score = $p['hs'];
				$v_score = $p['vs'];
				$status = $p['q'];
				$game_id = db::one($db->query("SELECT game_id FROM games WHERE code = %u", $code));
				if (!$game_id)
					continue;
				
				$db->query("UPDATE games SET status = '%s', h_score = %u, v_score = %u WHERE game_id = %u", $status, $h_score, $v_score, $game_id);
			}
		}
		
		public static function sched()
		{
			global $db;
			
			$season = bc::get_season('N');
			
			$year = $season['year'];
			$start_wk = db::one($db->query("SELECT MIN(week) FROM games WHERE year = %u AND status = 'P'", $year));
			if (!$start_wk)
				$start_wk = 1;
			
			//1-17 REG
			//18-20 POST
			
			for ($week = $start_wk; $week <= 22; $week++)
			{
				if ($week <= 17)
					$url = "http://www.nfl.com/ajax/scorestrip?season={$year}&seasonType=REG&week={$week}";
				else
					$url = "http://www.nfl.com/ajax/scorestrip?season={$year}&seasonType=POST&week={$week}";
				
				echo "{$url}\n";
				$ret = file_get_contents($url);
				$xml = new xml($ret);
				
				$g_ts = $xml->get_tags('g');
				foreach ($g_ts as $g)
				{
					$p = $g->get_attrs();
					$code = $p['gsis'];
					$h_team = $p['h'];
					$v_team = $p['v'];
					$h_score = $p['hs'];
					$v_score = $p['vs'];
					$status = $p['q'];
					$g_ts = strtotime(substr($p['eid'], 0, 8)." {$p['t']}pm EST");
					
					$game_id = db::one($db->query("SELECT game_id FROM games WHERE code = %u", $code));
					if (!$game_id)
					{
						$h_t = db::first($db->query("SELECT * FROM teams WHERE code = '%s' OR code2 = '%s'", $h_team, $h_team));
						$v_t = db::first($db->query("SELECT * FROM teams WHERE code = '%s' OR code2 = '%s'", $v_team, $v_team));
						
						$db->query("INSERT INTO games (year, week, code, h_team_id, v_team_id) VALUES (%u, %u, %u, %u, %u)", $year, $week, $code, $h_t['team_id'], $v_t['team_id']);
						$game_id = $db->insert_id();
					}
					
					$db->query("UPDATE games SET g_ts = %u, status = '%s' WHERE game_id = %u", $g_ts, $status, $game_id);
					
					if (strlen($h_score) && strlen($v_score))
					{
						$db->query("UPDATE games SET h_score = %u, v_score = %u WHERE game_id = %u", $h_score, $v_score, $game_id);
					}
				}
				//die();
			}
		}
		
		public static function f_news()
		{
			global $db;
			
			$sources = array(array('source_id' => 1, 'link' => 'http://www.rotoworld.com/rss/feed.aspx?sport=nfl&ftype=news&count=12&format=rss'));
			
			foreach ($sources as $s)
			{
				$ret = file_get_contents($s['link']);
				$xml = new xml($ret);
				
				$item_ts = $xml->get_tags('item');
				foreach ($item_ts as $o)
				{
					$code = $o->get_tag('guid')->str();
					$link = $o->get_tag('link')->str();
					$title = $o->get_tag('title')->str();
					$des = html_entity_decode($o->get_tag('description')->str(), ENT_QUOTES, 'utf-8');
					$c_ts = strtotime($o->get_tag('a10:updated')->str());
					
					//echo "{$code}\t{$c_ts}\t{$link}\t{$title}\t{$des}\n";
					
					$team_id = 0;
					if (count($a = explode('|', $title)) >= 2 && ($team_id = db::one($db->query("SELECT team_id FROM teams WHERE code = '%s' OR code2 = '%s'", trim($a[1]), trim($a[1])))))
						$title = trim($a[0]);
					
					if (!count($db->query("SELECT news_id FROM f_news WHERE source_id = %u AND code = %u", $s['source_id'], $code)))
						$db->query("INSERT INTO f_news (c_ts, source_id, code, team_id, link, title, des) VALUES (%u, %u, %u, %u, '%s', '%s', '%s')", $c_ts, $s['source_id'], $code, $team_id, $link, $title, $des);
				}
			}
		}
	}
?>