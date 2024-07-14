<?php
	require '../../inc/global.inc.php';
	$year = (int)@$_GET['y'];
	$week = (int)@$_GET['w'];
	
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $year, $week);
	pp::games($recs);
?>
<div>
	<div>
		<h1>Week <?=bc::wk_name($week)?> (<?=$year?>) results <a href="#"><i class="fa fa-times"></i></a></h1>
		<div class="lcont0">
			<?php require '../../pages/season-results/frag/gl1.inc.php'; ?>
		</div>
	</div>
</div>
	