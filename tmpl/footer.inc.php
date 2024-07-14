<br /><br />
<div style="<?=$style['box1']?>">
	<table border="0" cellpadding="0" cellspacing="0" style="<?=$style['split_tb2']?>">
		<tr>
			<td width="50%" style="<?=$style['normal']?>" valign="top">
				<strong><?=hsc($contact_info['comp'])?></strong><br />
				<?=hsc($contact_info['addr1'])?><br />
				<?php if ($contact_info['addr2']) { ?><?=hsc($contact_info['addr2'])?><br /><?php } ?>
			</td>
			<td width="50%" align="right" style="<?=$style['normal']?>" valign="top">
				<a href="<?=$url_proto?>://<?=$maindw?>/" style="<?=$style['link']?>"><?=hsc($maindw)?></a><br />
				<a href="mailto:<?=hsc($contact_info['email'])?>" style="<?=$style['link']?>"><?=hsc($contact_info['email'])?></a><br />
				<?php if ($contact_info['phone']) { ?><a href="tel:<?=hsc($contact_info['phone'])?>" style="<?=$style['link']?>"><?=hsc($contact_info['phone_fmt'])?></a><br /><?php } ?>
			</td>
		</tr>
	</table>
</div>