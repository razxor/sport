<?php if (!$mobile_user) { ?>
<h2 class="alt1">Account menu</h2>
<?php } ?>
<ul class="sbm">
	<li><a href="/my-picks/"<?php if ($page == 'my-picks') { ?> class="active"<?php } ?>><i class="fa fa-th-list"></i> SmartTrack</a></li>
</ul>


<?php if (!$mobile_user) { ?>
    <h2 class="alt1">Settings</h2>
<?php } ?>
<ul class="sbm">
    <li><a href="/account/edit/"<?php if ($page == 'account' && $sub == 'edit') { ?> class="active"<?php } ?>><i class="fa fa-pencil-alt"></i> Contact info</a></li>
    <li><a href="/account/access/"<?php if ($page == 'account' && $sub == 'access') { ?> class="active"<?php } ?>><i class="fa fa-key"></i> Access data</a></li>
    <li><a href="/account/mailing/"<?php if ($page == 'account' && $sub == 'mailing') { ?> class="active"<?php } ?>><i class="fa fa-envelope"></i> Free stuff</a></li>
    <li><a href="/account/logout/"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
</ul>