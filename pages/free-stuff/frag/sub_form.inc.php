<form action="#" method="post" id="dfrm">
	<div class="fc">
		<b>Please indicate which free weekly info you wish to receive:</b><br />
		<table class="data3">
			<tr>
				<td><input type="checkbox" name="<?=$t='wknd'?>" id="cb_<?=$t?>" /></td>
				<td><label for="cb_<?=$t?>">Weekend Preview</label></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="<?=$t='pow'?>" id="cb_<?=$t?>" /></td>
				<td><label for="cb_<?=$t?>">Free Pick of the Week</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="a" id="ra_<?=$t?>_a" /></td>
				<td><label for="ra_<?=$t?>_a">All picks at kickoff</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="b" id="ra_<?=$t?>_b" /></td>
				<td><label for="ra_<?=$t?>_b">Best pick at kickoff</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="" id="ra_<?=$t?>_n" /></td>
				<td><label for="ra_<?=$t?>_n">Neither</label></td>
			</tr>
		</table>
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="fc">
		<div class="fn">Email address</div>
		<input type="text" name="<?=$t='email'?>" value="<?=hsc(@$D[$t])?>" class="txt" maxlength="64" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="msgc" id="m_main"></div>
	<button class="btn1" id="sbtn">Add / update<i class="fa fa-caret-right"></i></button>
</form>