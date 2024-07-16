<?php
	require '../classes/class.bc.php';
	require '../classes/class.sub.php';
	$ss = bc::get_season('A');
	$week = bc::get_week($ss['year'], 'P');
	
	$free_on = db::one($db->query("SELECT v FROM settings WHERE k = 'free_auto'"));
?>
<div>
	<div class="box2">
		<table>
			<tr>
				<td><h1>Email control panel</h1></td>
				<td>
					<a class="btn1" href="#" act="auto_toggle" v="<?=$free_on?0:1?>"><i></i><?php if ($free_on) { ?>Turn auto free emails OFF<?php } else { ?>Turn auto free emails ON<?php } ?></a>
				</td>
			</tr>
		</table>
	</div>
</div>
<div id="reql0" class="fl mr mb"></div>
<div id="reql0a" class="fl mr mb"></div>
<div id="reql0b" class="fl mr mb"></div>
<div id="reql1" class="fl mr mb"></div>
<div id="reql2" class="fl mr mb"></div>
<div class="clr"></div>
<?php foreach (sub::$type_map as $k=>$v) { ?>
<div id="reql_<?=$k?>" class="fl mr mb"></div>
<?php } ?>
<div class="clr"></div>
<div class="hide" id="type_map"><?=json_encode(sub::$type_map)?></div>