<?php
	$n = 10;
	$page_num = min($page_num, $pages_total);
	$fp = max(1, $page_num - $n - $n + min($pages_total - $page_num, $n));
?>
<?php if ($pages_total > 1) { ?>
<div class="pgc">
	<ul class="paging">
		<li><a href="#" onclick="return M.L(1);"><i class="fa fa-angle-double-left"></i></a></li>
		<?php for ($i = $fp; $i < $page_num; $i++) { ?>
		<li><a href="#" onclick="return M.L(<?=$i?>);"><?=$i?></a>
		<?php } ?>
		<li><span class="active"><?=$page_num?></span></li>
		<?php for ($i = $page_num + 1; $i <= ($lp = min($pages_total, $page_num + $n + $n - min($page_num, $n))); $i++) { ?>
		<li><a href="#" onclick="return M.L(<?=$i?>);"><?=$i?></a></li>
		<?php } ?>
		<li><a href="#" onclick="return M.L(<?=$pages_total?>);"><i class="fa fa-angle-double-right"></i></a></li>
		<div class="clr"></div>
	</ul>
	<div class="clr"></div>
</div>
<?php } ?>