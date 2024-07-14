<div<?php if (!$mobile_user) { ?> class="half ma"<?php } ?>>
	<h1>Insta-unsubscribe</h1>
	<p>Sorry to be bothersome. We won't send you any more emails. Unless you subscribe again that is.</p>
	<?php if ($status == -1) { ?>
	<div class="errc">You are not subscribed</div>
	<?php } else if ($status == 1) { ?>
	<div class="msgc">You have been unsubscribed from future emails.</div>
	<?php } ?>
</div>