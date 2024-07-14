<form action="#" method="post" id="dfrm" class="fwbox">
	<div class="box2">
		<h1>Edit account</h1>
	</div>
	<div class="box1">
		<div class="msgc" id="m_main"></div>
		<div class="fc">
			<div class="fn">Full name</div>
			<input type="text" class="txt" name="<?=$t='name'?>" value="<?=hsc($usr->p[$t])?>" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Email</div>
			<input type="text" class="txt" name="<?=$t='email'?>" value="<?=hsc($usr->p[$t])?>" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Phone</div>
			<input type="text" class="txt" name="<?=$t='phone'?>" value="<?=hsc($usr->p[$t])?>" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">User</div>
			<input type="text" class="txt" name="<?=$t='user'?>" value="<?=hsc($usr->p[$t])?>" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Current password</div>
			<input type="password" class="txt" name="<?=$t='pass0'?>" value="" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">New password</div>
			<input type="password" class="txt" name="<?=$t='pass1'?>" value="" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<footer>
			<table>
				<tr>
					<td><a href="logout.php">Logout</a></td>
					<td>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-save"></i>Save</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>