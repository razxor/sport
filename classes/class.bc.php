<?php
	class bc
	{
		public static $wk_map = array(18 => '18', 19 => '19', 20 => '20', 22 => '21');
		
		public static function wk_name($wk)
		{
			return isset(self::$wk_map[$wk]) ? self::$wk_map[$wk] : $wk;
		}
		
		public static function season_results_bc($year)
		{
			global $db;
			$ret = array();
			
			$games = $db->query("SELECT week, h_score, v_score, spread, spread_f, pick, pick_mod, status FROM games WHERE year = %u", $year);
			foreach ($games as $r)
			{
				if ($r['status'] != 'F')
					continue;
				if (!$r['pick']/* || $r['pick_mod'] == 'p'*/)
					continue;
				
				$res = self::pick_result($r);
				if (!isset($ret[$r['week']]))
					$ret[$r['week']] = array(-1 => 0, 0 => 0, 1 => 0);
				$ret[$r['week']][$res]++;
			}
			
			$start = $ret ? (max(array_keys($ret)) + 1) : 1;
			
			for ($i = $start; $i <= 22; $i++)
			{
				$ret[$i] = false;
			}
			
			return $ret;
		}
		
		public static function season_results_us($year)
		{
			global $db, $usr;
			$ret = array();
			
			$games = $db->query("SELECT game_id, g_ts, week, h_score, v_score, spread, spread_f, pick, pick_mod, status FROM games WHERE year = %u", $year);
			$uga = db::assoc($db->query("SELECT game_id, spread, spread_f, pick, wager, odds, notes FROM u_picks_gm WHERE user_id = %u AND game_id IN (%s)", $usr->p['user_id'], db::choose($games, 'game_id')));
			pp::add_user_picks($games, $uga, 1);
			foreach ($games as $r)
			{
				if ($r['status'] != 'F')
					continue;
				if (!$r['pick'])
					continue;
				
				$res = self::pick_result($r);
				if (!isset($ret[$r['week']]))
					$ret[$r['week']] = array(-1 => 0, 0 => 0, 1 => 0, 'w' => 0);
				$ret[$r['week']][$res]++;
				if ($res == 1)
					$ret[$r['week']]['w'] += $r['wager'] / $r['odds'] * 100;
				else if ($res == -1)
					$ret[$r['week']]['w'] -= $r['wager'];
			}
			
			return $ret;
		}
		
		public static function season_results_hh($year)
		{
			global $db, $usr;
			$ret = array();
			
			$games = $db->query("SELECT game_id, g_ts, week, h_score, v_score, spread, spread_f, pick, pick_mod, status FROM games WHERE year = %u", $year);
			$uga = db::assoc($db->query("SELECT game_id, spread, spread_f, pick, wager, odds, notes FROM u_picks_gm WHERE user_id = %u AND game_id IN (%s)", $usr->p['user_id'], db::choose($games, 'game_id')));
			
			foreach ($games as $r)
			{
				if ($r['status'] != 'F')
					continue;
				$ug = @$uga[$r['game_id']];
				if (!$ug)
					continue;
				
				if (!$ug['pick'] || !$r['pick'] || $ug['pick'] == $r['pick'])
					continue;
				
				$r2 = $r;
				$r2['pick'] = $ug['pick'];
				$r2['spread'] = $ug['spread'];
				$r2['spread_f'] = $ug['spread_f'];
				$res = self::pick_result($r2);
				if (!isset($ret[$r['week']]))
					$ret[$r['week']] = array(-1 => 0, 0 => 0, 1 => 0);
				$ret[$r['week']][$res]++;
			}
			
			return $ret;
		}
		
		public static function pick_result($r)
		{
			if ($r['spread_f'] == 'a')
				$r['v_score'] -= $r['spread'] / 10;
			else if ($r['spread_f'] == 'h')
				$r['h_score'] -= $r['spread'] / 10;
		
			if ($r['h_score'] > $r['v_score'])
				return $r['pick'] == 'h' ? 1 : -1;
			else if ($r['h_score'] < $r['v_score'])
				return $r['pick'] == 'a' ? 1 : -1;
			return 0;
		}
		
		public static function winner_ats($r)
		{
			if ($r['spread_f'] == 'a')
				$r['v_score'] -= $r['spread'] / 10;
			else if ($r['spread_f'] == 'h')
				$r['h_score'] -= $r['spread'] / 10;
		
			if ($r['h_score'] == $r['v_score'])
				return 0;
			return $r['v_score'] > $r['h_score'] ? -1 : 1;
		}
		
		public static function winner_su($r)
		{
			if ($r['h_score'] == $r['v_score'])
				return 0;
			return $r['v_score'] > $r['h_score'] ? -1 : 1;
		}
		
		public function season_result_stats($recs)
		{
			$ret = array(-1 => 0, 0 => 0, 1 => 0, 'w' => 0, 'pct' => '');
			foreach ($recs as $wk=>$r)
			{
				if (!$r)
					continue;
				foreach ($r as $kk=>$vv)
					$ret[$kk] += $vv;
			}
			
			$total = $ret[1] + $ret[-1];
			if ($total)
				$ret['pct'] = round($ret[1] / $total * 100, 1);
			
			return $ret;
		}
		
		public static function pick_stats($recs)
		{
			$st = array(
				'picks' => array(
					'a' => array('t' => 0, 'w' => 0),
					'h' => array('t' => 0, 'w' => 0)
				),
				'f' => array(
					'a' => array('t' => 0, 'w' => 0),
					'h' => array('t' => 0, 'w' => 0)
				),
				'u' => array(
					'a' => array('t' => 0, 'w' => 0),
					'h' => array('t' => 0, 'w' => 0)
				),
				'wagers' => array(
					'total' => 0,
					'to_win' => 0,
					'pending' => 0,
					'won' => 0,
					'lost' => 0,
					'roi' => 0,
				),
				'won' => 0,
				'lost' => 0,
				'push' => 0,
				'bankroll' => 0
			);
			
			foreach ($recs as $r)
			{
				/*if (!$r['pick'] || $r['wager'] <= 0)
					continue;*/
				if (!$r['pick'])
					continue;
				//I should have mentioned earlier that if a person makes a pick without specifying a dollar amount, the pick itself should still count in the Picks stats section, especially the wins and losses columns.
				
				$st['picks'][$r['pick']]['t']++;
				$kk = $r['pick'] == $r['spread_f'] ? 'f' : 'u';
				$st[$kk][$r['pick']]['t']++;
				
				$st['wagers']['total'] += $r['wager'];
				
				$r['to_win'] = $r['wager'] / $r['odds'] * 100;
				$st['wagers']['to_win'] += $r['to_win'];
				
				$st['bankroll'] -= $r['wager'];
				
				if ($r['status'] == 'F')
				{
					$res = bc::pick_result($r);
					if ($res == 1)
					{
						$st['picks'][$r['pick']]['w']++;
						$st[$kk][$r['pick']]['w']++;
						$st['wagers']['won'] += $r['to_win'];
						$st['won']++;
						$st['bankroll'] += $r['wager'] + $r['to_win'];
					}
					else if ($res == -1)
					{
						$st['lost']++;
						$st['wagers']['lost'] += $r['wager'];
					}
					else
					{
						$st['push']++;
						$st['bankroll'] += $r['wager'];
					}
				}
				else
				{
					$st['wagers']['pending'] += $r['wager'];
				}
			
				$st['wagers']['roi'] = 0;
				if ($st['wagers']['total'] > 0)
					$st['wagers']['roi'] = round(($st['wagers']['won'] - $st['wagers']['lost']) / $st['wagers']['total'] * 100);
				
			}
			
			return $st;
		}
		
		public static function median($a)
		{
			if (!count($a))
				return 0;
			
			sort($a);
			
			$cnt = count($a);
			if ($cnt % 2 == 1)
				return $a[floor($cnt / 2)];
				
			return ($a[floor($cnt / 2) - 1] + $a[floor($cnt / 2)]) / 2;
		}
		
		public static function game_stats($recs)
		{
			$st = array(
				'su' => array(
					'a' => 0,
					'h' => 0
				),
				'fav' => array(
					'a' => array('t' => 0, 'w' => 0),
					'h' => array('t' => 0, 'w' => 0)
				),
				'cover' => array(
					'a' => 0,
					'h' => 0
				),
				'median' => array(
					'a' => 0,
					'h' => 0
				)
			);
			
			$medians = array('a' => array(), 'h' => array());
			
			foreach ($recs as $r)
			{
				if ($r['status'] == 'F' && $r['h_score'] != $r['v_score'])
				{
					$kk = $r['h_score'] > $r['v_score'] ? 'h' : 'a';
					$st['su'][$kk]++;
				}
				
				if ($r['spread_f'])
				{
					$st['fav'][$r['spread_f']]['t']++;
					if ($r['status'] == 'F' && $r['h_score'] != $r['v_score'])
					{
						if ($r['spread_f'] == 'a' && $r['v_score'] > $r['h_score'])
							$st['fav']['a']['w']++;
						else if ($r['spread_f'] == 'h' && $r['v_score'] < $r['h_score'])
							$st['fav']['h']['w']++;
					}
					
					if ($r['status'] == 'F')
					{
						$ret = self::winner_ats($r);
						if ($r['spread_f'] == 'a' && $ret == -1)
							$st['cover']['a']++;
						else if ($r['spread_f'] == 'h' && $ret == 1)
							$st['cover']['h']++;
						/*if ($r['spread_f'] == 'a' && (($r['v_score'] - $r['spread'] / 10) > $r['h_score']))
							$st['cover']['a']++;
						else if ($r['spread_f'] == 'h' && (($r['h_score'] - $r['spread'] / 10) > $r['v_score']))
							$st['cover']['h']++;*/
					}
					
					$medians[$r['spread_f']][] = $r['spread'] / 10;
				}
			}
			
			$st['median']['a'] = bc::median($medians['a']);
			$st['median']['h'] = bc::median($medians['h']);
			
			return $st;
		}
		
		public static function get_season($type)
		{
			global $db, $time_offset;
			
			$ts = time() + $time_offset;
			
			$act_season = db::first($db->query("SELECT * FROM seasons WHERE %u BETWEEN s_ts AND e_ts", $ts));
			
			if ($type == 'A') //return only active season
				return $act_season;
			if ($type == 'N')
			{
				if (!$act_season) //if not in season, return next year (for schedule/purchases/free stuff)
					return db::first($db->query("SELECT * FROM seasons ORDER BY year DESC LIMIT 1"));
				return $act_season;
			}
			if ($type == 'P')
			{
				if (!$act_season) //if not in season, return last year (for season results/user picks)
					return db::first($db->query("SELECT * FROM seasons WHERE s_ts < %u ORDER BY year DESC LIMIT 1", $ts));
				return $act_season;
			}
			
			return false;
		}
		
		public static function get_week($year, $type)
		{
			global $db, $time_offset;
			
			$ts = time() + $time_offset;
			
			if ($type == 'P') //for purchases
			{
				//non-started status, S? - scheduled?
				$wk = db::one($db->query("SELECT week FROM games WHERE year = %u AND status = 'P' AND g_ts > %u ORDER BY g_ts ASC LIMIT 1", $year, $ts)); //get week with any non-started games
				if (!$wk)
					return 3;
				//vvvv there was a game on tuesday, it jumped to next week. guess it doesn't matter
				/*if (count($db->query("SELECT game_id FROM games WHERE year = %u AND week = %u AND status != 'P' LIMIT 1", $year, $wk))) //if there are games started in this week, jump to next week
					$wk++;*/
				if ($wk > 17)
					return false;
				return $wk;
			}
			if ($type == 'G') //game week for email sending, a week where there are any games that did not end 
			{
				$wk = db::one($db->query("SELECT week FROM games WHERE year = %u AND status != 'F' AND g_ts > %u ORDER BY g_ts ASC LIMIT 1", $year, $ts)); //get week with any non-started games
				if (!$wk)
					return 3;
				if ($wk > 17)
					return false;
				return $wk;
			}
		}
		
		public static function season_price($week)
		{
			global $season_price;
			
			if ($week <= 3)
				return $season_price;
			return round(179.95 - ($week - 3) * 10, 2);
		}
		
		public static function get_purchase_item($p)
		{
			global $week_price, $usr;
			
			$d = array();
			
			$ss = bc::get_season('N');
			$year = $ss['year'];
			$week = bc::get_week($year, 'P');
			
			$uid = @$usr->p['user_id'];
			$d['custom'] = "{$p['email']}|{$uid}";
			
			$d['price'] = $week_price;
			$d['item_name'] = "Week {$week} Picks";
			$d['item_number'] = "{$year}.{$week}";
			if ($p['opt'] == 'y')
			{
				$d['item_number'] = $year;
				$d['price'] = bc::season_price($week);
				$d['item_name'] = "{$year} season package";
				if ($week > 3)
					$d['item_name'] = "Remainder of the {$year} season";
			}
			
			return $d;
		}
	}
?>