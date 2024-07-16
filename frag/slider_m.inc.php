<?php
	if ($season = bc::get_season('A'))
	{
		$sl_recs = $db->query("SELECT * FROM f_news ORDER BY news_id DESC LIMIT 20");
		pp::f_news($sl_recs);
	}
	else
		$sl_recs = $db->query("SELECT * FROM slider ORDER BY d_o ASC, item_id ASC");
?>
<div class="slider" id="slider1">
	<h2>
		<div class="controls clrf">
			<a href="#" class="fao"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="fao"><i class="fa fa-angle-right"></i></a>
		</div>
		Newsflash
	</h2>
	<ul>
		<?php foreach ($sl_recs as $p) { $pu = @parse_url($p['link']); ?>
		<li><?php if (@$p['team_img']) { ?><img src="<?=$p['team_img']?>" /><?php } ?><?=hsc(substr($p['title'], 0, 1000))?><?php if ($p['link']) { ?><a href="<?=$p['link']?>"<?php if (@$pu['host'] || !in_array(@$pu['host'], array($maind, $maindw))) { ?> target="_blank"<?php } ?>><i class="fa fa-arrow-right"></i></a><?php } ?></li>
		<?php } ?>
	</ul>
</div>