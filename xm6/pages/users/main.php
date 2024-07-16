<?php
	require 'req/users/common.inc.php';
?>
<div>
	<div class="box2">
		<table>
			<tr>
				<td><h1>Users</h1></td>
				<td>
					<a class="btn1" href="#" act="mass"><i class="fa fa-envelope-o"></i>Mass email</a>
					<a class="btn1" href="#" act="edit" eid="0"><i class="fa fa-plus"></i>New user</a>
					<form class="filters" id="filters">
						<select name="role_id">
							<option value="" class="def">Role</option>
							<option value="0">Site user</option>
							<?php foreach ($_ROLES as $k=>$p) { ?>
							<option value="<?=$k?>"><?=hsc($p['name'])?></option>
							<?php } ?>
						</select>
						<input type="text" name="q" class="txt" placeholder="Search users" />
						<button><i class="fa fa-search"></i></button>
					</form>
				</td>
			</tr>
		</table>
	</div>
	<div id="reql0"></div>
</div>
<div id="reql1"></div>
<div id="reql2"></div>
