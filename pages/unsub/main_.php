<?php
	$meta['title'] = 'Insta-unsubscribe';
	$meta['robots'] = 'noindex,nofollow';
	
	$status = 0;
	$email = @$_GET['email'];
	if (!count($db->query("SELECT sub_id FROM subs WHERE email = '%s'", $email)))
		$status = -1;
	else
	{
		$db->query("DELETE FROM subs WHERE email = '%s'", $email);
		$status = 1;
	}
?>