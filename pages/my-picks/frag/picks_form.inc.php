<?php
	$t_now = time() + $time_offset;
?>
<form id="dfrm" method="post" action="#" class="d1cont">
	<input type="hidden" name="nr" value="<?=$needs_refresh?>" />
	<input type="hidden" name="y" value="<?=$year?>" />
	<input type="hidden" name="w" value="<?=$week?>" />
	<div class="fc spl">
		<div class="half">
			<div class="fn">Bankroll</div>
			<?php if (!$mobile_user) { ?>
			<span class="num_c fl money">
				<input type="text" name="<?=$t='bankroll'?>" class="txt num1" value="<?=hsc($ud[$t])?>" />
				<a href="#" act="numc" d="u"><i class="fa fa-caret-up"></i></a>
				<a href="#" act="numc" d="d"><i class="fa fa-caret-down"></i></a>
			</span>
			<?php } else { ?>
			<input type="number" name="<?=$t='bankroll'?>" class="txt num1" pattern="\d*" value="<?=hsc($ud[$t])?>" />
			<?php } ?>
		</div>
		<div class="half rta">
			<div class="fn">&nbsp;</div>
			<button class="btn1" name="btn1">Save&nbsp;<i class="fa fa-save"></i></button>
		</div>
	</div>
	<div class="fc">
	<table class="data1 w100">
		<thead>
			<tr>
				<th class="lta">Away<?php if (!$mobile_user) { ?> team<?php } ?></th>
				<th colspan="3" class="nopad">Spread</th>
				<th class="rta">Home<?php if (!$mobile_user) { ?> team<?php } ?></th>
				<th class="cta">Wager</th>
				<th class="cta">Odds</th>
				<th class="cta" colspan="2">Score</th>
				<th class="cta">Result</th>
				<th class="lta" colspan="2">Notes</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($recs as $k=>$r) { ?>
			<?php
				$p_res = false;
				if ($r['pick'] && $r['status'] == 'F')
					$p_res = bc::pick_result($r);
				$cn_v = array();
				if ($r['pick'] == 'a')
				{
					$cn_v[] = 'picked';
					if ($p_res === 0)
						$cn_v[] = 'p_push';
					else if ($p_res !== false)
						$cn_v[] = $p_res == 1 ? 'p_won' : 'p_lost'; 
				}
				if ($r['winner_su'] == -1)
					$cn_v[] = 'winner_su';
				if ($r['winner_ats'] == -1)
					$cn_v[] = 'winner_ats';
				
				$cn_h = array();
				if ($r['pick'] == 'h')
				{
					$cn_h[] = 'picked';
					if ($p_res === 0)
						$cn_h[] = 'p_push';
					else if ($p_res !== false)
						$cn_h[] = $p_res == 1 ? 'p_won' : 'p_lost'; 
				}
				if ($r['winner_su'] == 1)
					$cn_h[] = 'winner_su';
				if ($r['winner_ats'] == 1)
					$cn_h[] = 'winner_ats';
			?>
			<?php if (!$k || (DT($r['g_ts']) != DT($recs[$k-1]['g_ts']))) { ?>
			<tr>
				<td colspan="12" class="note"><?=DT($r['g_ts'])?></td>
			</tr>
			<?php } ?>
			<tr k="<?=$k?>" gid="<?=$r['game_id']?>">
				<td>
					<a href="#" class="<?=implode(' ', $cn_v)?>" act="pick" w="v" k="<?=$k?>" id="vt_<?=$k?>"><span><?=hsc($mobile_user ? $r['v_team']['code'] : $r['v_team']['name2'])?></span></a>
					<span id="spf_v_<?=$k?>"><?php if ($r['spread_f'] == 'a') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?></span>
				</td>
				<?php if ($mobile_user) { ?>
				<td colspan="3">
					<select name="sp[<?=$k?>]">
						<?php for ($i = 25.5; $i >= 0.5; $i -= 0.5) { ?>
						<option value="<?=$i*10?>.a"<?php if ($r['spread_f'] == 'a' && $i*10 == $r['spread']) { ?> selected="selected"<?php } ?>>&lt; -<?=$i?></option>
						<?php } ?>
						<option value="0.h"<?php if ($r['spread_f'] == 'h' && $i*10 == $r['spread']) { ?> selected="selected"<?php } ?>>even</option>
						<?php for ($i = 0.5; $i <= 25.5; $i += 0.5) { ?>
						<option value="<?=$i*10?>.h"<?php if ($r['spread_f'] == 'h' && $i*10 == $r['spread']) { ?> selected="selected"<?php } ?>> -<?=$i?> &gt;</option>
						<?php } ?>
					</select>
				</td>
				<?php } else { ?>
				<td class="nopad"><a href="#" class="fao" act="spm" d="lt" k="<?=$k?>"><i class="fa fa-caret-left"></i></a></td>
				<td class="cta spread_p">
					<span id="sp_<?=$k?>"><?=$r['spread'] ? -$r['spread']/10 : 'even'?></span>
				</td>
				<td class="rta nopad"><a href="#" class="fao" act="spm" d="rt" k="<?=$k?>"><i class="fa fa-caret-right"></i></a></td>
				<?php } ?>
				<td class="rta">
					<span id="spf_h_<?=$k?>"><?php if ($r['spread_f'] == 'h') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?></span>
					<a href="#" class="<?=implode(' ', $cn_h)?>" act="pick" w="h" k="<?=$k?>" id="ht_<?=$k?>"><span><?=hsc($mobile_user ? $r['h_team']['code'] : $r['h_team']['name2'])?></span></a>
				</td>
				<?php if ($mobile_user) { ?>
				<td class="cta"><input type="number" pattern="\d*" class="txt num1 wager" name="wager[<?=$k?>]" value="<?=@$r['wager']?>" /></td>
				<?php } else { ?>
				<td class="cta">
					<span class="num_c">
						<input type="text" class="txt num1 wager" name="wager[<?=$k?>]" value="<?=@$r['wager']?>" />
						<a href="#" act="numc" d="u"><i class="fa fa-caret-up"></i></a>
						<a href="#" act="numc" d="d"><i class="fa fa-caret-down"></i></a>
					</span>
				</td>
				<?php } ?>
				<td class="cta">
					<?php if ($mobile_user) { ?>
					<select name="odds[<?=$k?>]">
						<?php $i = 100; while ($i < 999) { ?>
						<option value="<?=$i?>"<?php if ($r['odds'] == $i) { ?> selected="selected"<?php } ?>><?=-$i?></option>
						<?php
							if ($i >= 150)
								$i += 10;
							else if ($i >= 115)
								$i += 5;
							else
								$i++;
						}
						?>
					</select>
					<?php } else { ?>
					<span class="num_c">
						<input type="text" class="txt num1 odds" name="odds[<?=$k?>]" value="<?=-$r['odds']?>" maxlength="4" />
						<a href="#" act="numc" d="u"><i class="fa fa-caret-up"></i></a>
						<a href="#" act="numc" d="d"><i class="fa fa-caret-down"></i></a>
					</span>
					<?php } ?>
				</td>
				<td class="rta" id="vs_<?=$r['game_id']?>"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['v_score']?><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></span></td>
				<td id="hs_<?=$r['game_id']?>"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['h_score']?><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></span></td>
				<td id="rr_<?=$r['game_id']?>">
					<?php if ($p_res === 0) { ?>
					<i class="fa fa-fw fa-refresh"></i> Push
					<?php } else if ($p_res == -1) { ?>
					<i class="fa fa-fw fa-close"></i> Loss
					<?php } else if ($p_res === 1) { ?>
					<i class="fa fa-fw fa-check"></i> Win
					<?php } ?>
				</td>
				<td><input type="text" class="txt small notes" name="notes[<?=$k?>]" maxlenght="255" value="<?=hsc(@$r['notes'])?>" /></td>
				<td class="gb">
					<?php if ($r['status'] == 'F' && $r['gb_link']) { ?>
					<a class="btn1 tiny" href="<?=$r['gb_link']?>" target="_blank"><i class="fa fa-book"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
	<div class="fc<?php if (!$mobile_user) { ?> spl<?php } ?>">
		<div class="<?php if (!$mobile_user) { ?>quat3 <?php } ?>legend">
			Legend:
			<span class="picked">Pick</span>
			<span class="winner_su"><span>Winner S-U</span></span>
			<span class="winner_ats">Winner ATS</span>
			<span class="picked p_won">Pick won</span>
			<span class="picked p_lost">Pick lost</span>
			<span class="picked p_push">Pick push</span>
		</div>
		<div class="<?php if (!$mobile_user) { ?>quat<?php } ?> rta">
			<button class="btn1" name="btn2">Save&nbsp;<i class="fa fa-save"></i></button>
		</div>
	</div>
</form>