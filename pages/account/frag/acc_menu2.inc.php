<ul class="<?=$mobile_user ? 'sbm' : 'nav2 clrf'?>">
	<li><a href="/my-picks/"<?php if ($page == 'my-picks' && $sub == 'main') { ?> class="active"<?php } ?>><i class="fa fa-th-list"></i> My picks</a></li>
	<li><a href="/my-picks/scores/"<?php if ($page == 'my-picks' && $sub == 'scores') { ?> class="active"<?php } ?>><i class="fa fa-football-ball"></i> Scores</a></li>
	<li><a href="/my-picks/results/"<?php if ($page == 'my-picks' && $sub == 'results') { ?> class="active"<?php } ?>><i class="fa fa-list-ol"></i> Results</a></li>
</ul>