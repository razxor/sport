<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	
	$usr = new user();
	if (!$usr->logged_in())
		die('NLI');
	
	$year = (int)@$_GET['y'];
	$week = (int)@$_GET['w'];
	
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $year, $week);
	pp::games($recs);
	$o_recs = $recs;
	
	$uga = db::assoc($db->query("SELECT game_id, spread, spread_f, pick, wager, odds, notes FROM u_picks_gm WHERE user_id = %u AND game_id IN (%s)", $usr->p['user_id'], db::choose($recs, 'game_id')));
	pp::add_user_picks($recs, $uga, 1);
?>
<div>
	<div>
		<h1>Week <?=bc::wk_name($week)?> (<?=$year?>) head to head results<a href="#"><i class="fa fa-times"></i></a></h1>
		<div class="lcont0">
			<?php require '../../pages/my-picks/frag/hh.inc.php'; ?>
		</div>
	</div>
</div>
	