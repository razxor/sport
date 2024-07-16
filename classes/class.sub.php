<?php
	class sub
	{
		public static $type_map = array('probable' => 'Probable', 'final' => 'Final', 'weekend' => 'Weekend preview', 'pow' => 'Free pick of the week', 'all_ko' => 'All picks at kickoff', 'best_ko' => 'Best pick at kickoff');
		public static $subj_map = array(
			'probable' => 'BestChancetoWin: PROBABLE Week %u picks',
			'final' => 'BestChancetoWin: Week %u picks',
			'weekend' => 'BestChancetoWin: Week %u Preview',
			'pow' => 'BestChancetoWin: Week %u free Pick of the Week',
			'all_ko' => 'BestChancetoWin: Week %u free pick(s) at kickoff',
			'best_ko' => 'BestChancetoWin: Week %u free pick at kickoff'
		);
		
		public static function have_paid($r)
		{
			global $db;
			
			$sub_id = db::one($db->query("SELECT sub_id FROM subs WHERE email = '%s' LIMIT 1", $r['email']));
			if (!$sub_id)
			{
				$db->query("INSERT INTO subs (c_ts, email, name) VALUES (%u, '%s', '%s')", time(), $r['email'], $r['name']);
				$sub_id = $db->insert_id();
			}
			
			$db->query("UPDATE subs SET order_id = %u WHERE sub_id = %u", $r['order_id'], $sub_id);
		}
		
		public static function disable_paid($r)
		{
			global $db;
			
			$db->query("UPDATE subs SET order_id = 0 WHERE order_id = %u", $r['order_id']);
		}
		
		public static function get_picks($year, $week, $type, $unset_ko = false, $gids = array())
		{
			global $db, $time_offset;
			
			$fld = '*';
			
			if ($type == 'probable')
				return $db->query("SELECT {$fld} FROM games WHERE year = %u AND week = %u AND pick != '' AND pick_mod = '%s'", $year, $week, 'p');
			if ($type == 'final')
				return $db->query("SELECT {$fld} FROM games WHERE year = %u AND week = %u AND pick != '' AND pick_mod != '%s'", $year, $week, 'p');
			if ($type == 'weekend')
			{
				$recs = $db->query("SELECT {$fld} FROM games WHERE year = %u AND week = %u AND pick != '' ", $year, $week);
				foreach ($recs as $k=>$r)
					$recs[$k]['pick'] = '';
				return $recs;
			}
			if ($type == 'pow')
				return $db->query("SELECT {$fld} FROM games WHERE year = %u AND week = %u AND pick != '' AND pick_mod = '%s'", $year, $week, '?');
			if ($type == 'all_ko')
			{
				//echo date('c', (time() + $time_offset))." < now<br />\n";
				$recs = $db->query("SELECT {$fld} FROM games WHERE year = %u AND week = %u AND pick != '' ORDER BY game_id ASC", $year, $week, '');
				foreach ($recs as $k=>$r)
				{
					//echo date('c', $r['g_ts'])."<br />\n";
					if (($r['g_ts'] > (time() + $time_offset)) || $r['ko_mq'])
					{
						if ($unset_ko && !in_array($r['game_id'], $gids))
							unset($recs[$k]);
					}
				}
				return array_values($recs);
			}
			if ($type == 'best_ko')
			{
				$recs = $db->query("SELECT {$fld} FROM games WHERE year = %u AND week = %u AND pick != '' AND pick_mod IN (%s) ORDER BY game_id ASC", $year, $week, array('*', '!'));
				foreach ($recs as $k=>$r)
				{
					if (($r['g_ts'] > (time() + $time_offset)) || $r['ko_mq'])
					{
						if ($unset_ko && !in_array($r['game_id'], $gids))
							unset($recs[$k]);
					}
				}
				return array_values($recs);
			}
				
			return false;
		}
		
		public static function get_subs($year, $week, $type, $queue = 0)
		{
			global $db;
			
			if ($type == 'probable' || $type == 'final')
				return $db->query("SELECT S.sub_id, O.email, O.name FROM subs S JOIN orders O ON (S.order_id = O.order_id AND O.status = 'C') WHERE O.year = %u AND (O.opt = 'y' OR O.week = %u) AND S.bounced = 0", $year, $week);
			
			$e_ids = array();
			if (in_array($type, array('weekend', 'pow', 'all_ko', 'best_ko')))
				$e_ids = db::choose(self::get_subs($year, $week, 'final'), 'sub_id');
			
			if ($type == 'weekend')
				return $db->query("SELECT sub_id, email, name FROM subs WHERE year = %u AND wknd = 1 AND sub_id NOT IN (%s) AND bounced = 0", $year, $e_ids);
			if ($type == 'pow')
				return $db->query("SELECT sub_id, email, name FROM subs WHERE year = %u AND pow = 1 AND sub_id NOT IN (%s) AND bounced = 0", $year, $e_ids);
			if ($type == 'all_ko')
			{
				if ($queue)
					$recs = $db->query("SELECT S.sub_id, S.email, S.name, Q.gids FROM subs S LEFT JOIN m_q Q ON (S.sub_id = Q.sub_id AND Q.year = %u AND Q.week = %u AND Q.type = '%s') WHERE S.year = %u AND S.opt = 'a' AND S.sub_id NOT IN (%s) AND S.bounced = 0", $year, $week, $type, $year, $e_ids);
				else
					$recs = $db->query("SELECT sub_id, email, name FROM subs WHERE year = %u AND opt = 'a' AND sub_id NOT IN (%s) AND bounced = 0", $year, $e_ids);
				return $recs;
			}
			if ($type == 'best_ko')
				return $db->query("SELECT sub_id, email, name FROM subs WHERE year = %u AND opt = 'b' AND sub_id NOT IN (%s) AND bounced = 0", $year, $e_ids);
			
			return array();
		}
		
		public static function send_one($type, $r)
		{
			$subj = sprintf(self::$subj_map[$type], $r['week']);
			if (count($r['picks']) == 1)
				$subj = str_replace('(s)', '', $subj);
			else
				$subj = str_replace('(s)', 's', $subj);
			$data = $r;
			$data['sender'] = 'sender3';
			
			send_email("sub_{$type}", $data, $subj);
		}
		
		public static function queue_all($type)
		{
			global $db;
			
			$ss = bc::get_season('A');
			$week = bc::get_week($ss['year'], 'G');
			$picks = sub::get_picks($ss['year'], $week, $type, 1);
			pp::games($picks);
			
			if (!count($picks))
				return false;
		
			$gids = '';
			if ($type == 'all_ko' || $type == 'best_ko')
				$gids = implode(',', db::choose($picks, 'game_id'));
			$subs = sub::get_subs($ss['year'], $week, $type);
			foreach ($subs as $r)
			{
				if (!count($db->query("SELECT entry_id FROM m_q WHERE sub_id = %u AND type = '%s' AND year = %u AND week = %u AND gids = '%s' LIMIT 1", $r['sub_id'], $type, $ss['year'], $week, $gids)))
				{
					$db->query("INSERT INTO m_q (c_ts, sub_id, type, year, week, status, gids) VALUES (%u, %u, '%s', %u, %u, '%s', '%s')", time(), $r['sub_id'], $type, $ss['year'], $week, 'Q', $gids);
				}
			}
		}
		
		public static function bounce($email)
		{
			global $db;
			
			$sub = db::first($db->query("SELECT * FROM subs WHERE email = '%s'", $email));
			if (!$sub)
				return;
			
			$db->query("UPDATE m_q SET status = 'B' WHERE sub_id = %u AND status IN ('S', 'Q')", $sub['sub_id']);
			$db->query("UPDATE subs SET bounced = 1 WHERE sub_id = %u", $sub['sub_id']);
		}
	}
?>