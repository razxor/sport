<?php
	$connect['host'] = '127.0.0.1';
	$connect['user'] = 'root';
	$connect['pass'] = '';
	$connect['db'] = 'fiverr_db';

	$media_base = realpath(dirname(__FILE__).'/../md');
	$tmp_base = '/tmp';

	$home_title = 'BestChancetoWin';

	$maind = 'bestchance.com';
	$maindw = ''.$maind;
	$url_proto = 'https';

	$sender = array();//Football77!
	$sender['name'] = 'Best Chance';
	$sender['email'] = 'info';
	$sender['domain'] = 'bestchance.com';
	$sender['host'] = 'mx.eweb-corporate.com';
	$sender['port'] = 465;
	$sender['username'] = 'info@bestchance.com';
	$sender['password'] = 'Football77!';

	$sender2 = array();//565656QWE!
	$sender2['name'] = 'Best Chance';
	$sender2['email'] = 'info';
	$sender2['domain'] = 'tx.bestchance.com';
	$sender2['host'] = 'email-smtp.us-east-1.amazonaws.com';
	$sender2['port'] = 465;
	$sender2['username'] = 'AKIAINIJH5ET5TRQDS2Q';
	$sender2['password'] = 'AomLLBCXe9u99tp6uzOVGuHdLSc/2RmyMxDEbOWT7aQG';
	
	$sender3 = array();//565656QWE!
	$sender3['name'] = 'Best Chance';
	$sender3['email'] = 'info';
	$sender3['domain'] = 'picks.bestchance.com';
	$sender3['host'] = 'email-smtp.us-east-1.amazonaws.com';
	$sender3['port'] = 465;
	$sender3['username'] = 'AKIAINIJH5ET5TRQDS2Q';
	$sender3['password'] = 'AomLLBCXe9u99tp6uzOVGuHdLSc/2RmyMxDEbOWT7aQG';

	$contact_info = array();
	$contact_info['site'] = 'BestChanceToWin';
	$contact_info['email'] = 'info@bestchance.com';
	$contact_info['phone_fmt'] = '';
	$contact_info['phone'] = '';
	$contact_info['comp'] = 'EG Sports, LLC';
	$contact_info['addr1'] = 'Chicago, Illinois';
	$contact_info['addr2'] = '';
	
	$purchase_notify = 'notify@notify.eweb-corporate.com';

	$fb_page = 'https://www.facebook.com/BestChancetoWin';
	$fb_admins = '100001089063989';
	$fbp_atk = '';
	$tw_page = 'https://twitter.com/BestChanceToWi1';
	$pt_page = '';
	$gp_page = '';
	
	$fb_app_id = '231429610747453';
	$fb_secret = 'cf2df1fb0ee748d1ffde2a70e182b412';
	
	$gg_client_id = '780687449509-31hl3sitldhk8u0a1ndfvh9rl57oa69q.apps.googleusercontent.com';
	$gg_secret = 'IRieMumNbvPqxYvyn45bTXrF';

	$cdn_1 = "https://{$maind}";

	date_default_timezone_set('EST');
	
	$week_price = 19.95;
	$season_price = 159.95;
	
	$paypal_live = true;
	$paypal = array(
		'client_id' => 'AR2fD7NjQ-z1rrXFL50MbNa0qdcajTlTgtZ77zMpSyZD7MD3ogJBieh8b3n7KDj_wJGoS3zYSV_6TU1P',
		'secret' => 'EEBNbPZcFnOakGEqkuxG2v2mLacQOHCqaPzK2m-ZgZDG9M9pwLHy91t1m7HJ1ZrcuWBqoAhKMSI8lY2K'
	);
	
	if ($paypal_live)
	{
		$paypal = array(
			'client_id' => 'Aeqv5qKsYO3cMQ-YAymot2R6hyJb7JsyKP-YUngVFTJ6q5SKa-tfMpC2XYBdTVyunBHrkg3_fZdXWyqY',
			'secret' => 'EIqVMh6mDC7-rsc5UimQYghvww3fMsEq-mxZeziSE6WtLhZJWxBIpqonytwH1NPj_QZf8IMki6NrQDu4'
		);
	}
	
	$time_offset = 0;
?>
