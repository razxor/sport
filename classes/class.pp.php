<?php
	class pp
	{
		public static function f_news(&$recs)
		{
			if (!count($recs))
				return;
			
			global $db;
			
			$tids = array_diff(db::choose($recs, 'team_id'), array(0));
			$ta = count($tids) ? db::assoc($db->query("SELECT team_id, name, code, name2 FROM teams WHERE team_id IN (%s)", $tids)) : array();
			
			foreach ($recs as $k=>$r)
			{
				$r['team'] = @$ta[$r['team_id']];
				$r['team_img'] = $r['team'] ? ("/md/teams/".strtolower($r['team']['code']).'.svg') : false;
				$recs[$k] = $r;
			}
		}
		
		public static function games(&$recs)
		{
			if (!count($recs))
				return;
			
			global $db, $media_base;
			
			$tids = array_diff(array_merge(db::choose($recs, 'h_team_id'), db::choose($recs, 'v_team_id')), array(0));
			$ta = count($tids) ? db::assoc($db->query("SELECT team_id, name, code, code2, city, full_name, name2 FROM teams WHERE team_id IN (%s)", $tids)) : array();
			
			foreach ($recs as $k=>$r)
			{
				$r['h_team'] = @$ta[$r['h_team_id']];
				$r['v_team'] = @$ta[$r['v_team_id']];
				$r['h_team_img'] = $r['h_team'] ? ("/md/teams/".strtolower($r['h_team']['code']).'.svg') : false;
				$r['v_team_img'] = $r['v_team'] ? ("/md/teams/".strtolower($r['v_team']['code']).'.svg') : false;
				
				$r['gb_f'] = "{$media_base}/gb/{$r['year']}/{$r['game_id']}.pdf";
				$r['gb_l'] = "/md/gb/{$r['year']}/{$r['game_id']}.pdf";
				$r['spread_dec'] = -$r['spread'] / 10;
				
				$r['winner_su'] = '';
				if ($r['status'] == 'F')
				{
					if ($r['h_score'] == $r['v_score'])
						$r['winner_su'] = '';
					$r['winner_su'] = $r['v_score'] > $r['h_score'] ? -1 : 1;
				}
				
				$recs[$k] = $r;
			}
		}
		
		public static function add_user_picks(&$recs, $uga, $force = false)
		{
			if (!count($recs))
				return;
			
			$t_now = time();
				
			foreach ($recs as $k=>$r)
			{
				if ($r['g_ts'] > $t_now)
					$r['pick'] = '';
				
				$r['odds'] = 105;
				$r['wager'] = '';
				
				$ug = @$uga[$r['game_id']];
				if ($ug || $force)
				{
					foreach (array('spread_f', 'spread', 'pick', 'wager', 'odds', 'notes') as $t)
					{
						if ($ug[$t] || $force || $t == 'spread')
							$r[$t] = @$ug[$t];
					}
					
					if ($ug['wager'] && !$ug['pick'])
						$r['pick'] = '';
				}
				
				$r['winner_ats'] = '';
				if ($r['status'] == 'F' && $r['spread_f'])
					$r['winner_ats'] = bc::winner_ats($r);
				
				$recs[$k] = $r;
			}
		}
	}
?>