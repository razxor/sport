var M = {
	e:{
		user: 'Please enter the login',
		user_i: 'Invalid login',
		user_d: 'This login is used in another account. Please use the password recovery function to access the account.',
		user_ch: 'The login cannot be changed any more',
		pass: 'Please enter your current password',
		wrong: 'Incorrect password',
		confirm: 'Please enter the password again',
		short: 'The password is too short',
		match: 'The passwords do not match',
		same: 'The password has to be different',
		ok: 'Data saved'
	},
	I: function() {
		var f = $('dfrm');
		F.addTrim(f);
		f.onsubmit = function() {
			return M.SDo(this);
		}
	},
	SDo: function(f) {
		
		if (!this.V(f))
			return false;
		$('sbtn').disabled = true;
		Aj.post('/req/account/acc_do.req.php', F.GFD(f), {f:f}, function() {
			$('sbtn').disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					this.opt.f.pass0.value = this.opt.f.pass1.value = this.opt.f.pass2.value = '';
					F.M('main', M.e.ok);
				} else if (a.ea[0][0] == 'login') {
					document.location.reload();
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				alert('Login error: ' + e + ' ' + this.responseText);
				console.log(e)
			}
		});
		return false;
	},
	V: function(f) {
		F.CE(f);
		F.p = true;
		
		if (f.pass1.value.length) {
			if (!(t=f.pass0).value.length)
				F.p = F.E(t.name, M.e.pass);
			if (!(t=f.pass2).value.length)
				F.p = F.E(t.name, M.e.confirm);
			if ((t=f.pass1).value.length < 6)
				F.p = F.E(t.name, M.e.short);
			else if (f.pass1.value != f.pass2.value && f.pass2.value.length)
				F.p = F.E(f.pass2, M.e.match);
			else if (f.pass1.value == f.pass0.value)
				F.p = F.E(f.pass1, M.e.same);
		}
		
		return F.p;
	}
}

window.addEventListener('load', M.I);
