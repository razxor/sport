<?php if (!$usr->logged_in()) { ?>
<?php require 'pages/account/frag/nli.inc.php'; ?>
<?php } else { ?>

<?php if ($mobile_user) { ?>
    <?php require 'pages/account/frag/acc_menu2.inc.php'; ?>
<div>
	<select id="yr_sel">
		<?php foreach ($seasons as $p) { ?>
		<option value="<?=$p['year']?>"<?php if ($year == $p['year']) { ?> selected="selected"<?php } ?>><?=$p['year']?></option>
		<?php } ?>
	</select>
	<select id="wk_sel">
		<?php foreach ($weeks as $p) { ?>
		<option value="<?=$p['week']?>"<?php if ($week == $p['week']) { ?> selected="selected"<?php } ?>>Week <?=bc::wk_name($p['week'])?></option>
		<?php } ?>
	</select>
</div>
<br />
<?php } else { ?>
<div class="spl">
	<div class="half"><?php require 'pages/account/frag/acc_menu2.inc.php'; ?></div>
	<div class="half rta">
		<select id="yr_sel">
			<?php foreach ($seasons as $p) { ?>
			<option value="<?=$p['year']?>"<?php if ($year == $p['year']) { ?> selected="selected"<?php } ?>><?=$p['year']?></option>
			<?php } ?>
		</select>
		<select id="wk_sel">
			<?php foreach ($weeks as $p) if ($p['week'] != 21) { ?>
			<option value="<?=$p['week']?>"<?php if ($week == $p['week']) { ?> selected="selected"<?php } ?>>Week <?=bc::wk_name($p['week'])?></option>
			<?php } ?>
		</select>
	</div>
</div>
<?php } ?>
<?php $recs = $games; require 'frag/picks_form.inc.php'; ?>
<?php $recs = $games; require 'frag/stats.inc.php'; ?>
<p>&nbsp;</p>
<?php require 'frag/bankroll.inc.php'; ?>
<p>&nbsp;</p>
<?php $st = $st2; require 'frag/stats2.inc.php'; ?>
<?php } ?>