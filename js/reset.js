var M = {
	e:{
		pass: 'Please enter the new password',
		confirm: 'Please enter the new password again',
		short: 'The password is too short',
		match: 'The passwords do not match',
		same: 'The password has to be different',
		params: 'Parameter error. Please try the reset process again.',
		ok: 'Data saved'
	},
	I: function() {
		$('dfrm').onsubmit = function() {
			return M.SDo(this);
		}
	},
	SDo: function(f) {
		
		if (!this.V(f))
			return false;
		$('sbtn').disabled = true;
		Aj.post('/req/account/reset_do.req.php', F.GFD(f), {f:f}, function() {
			$('sbtn').disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					this.opt.f.pass1.value = this.opt.f.pass2.value = '';
					F.M('main', M.e.ok);
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
		
		if (!(t=f.pass1).value.length)
			F.p = F.E(t, M.e.pass);
		else if ((t=f.pass1).value.length < 6)
			F.p = F.E(t, M.e.short);
		if (!(t=f.pass2).value.length)
			F.p = F.E(t, M.e.confirm);
		else if (f.pass1.value != f.pass2.value && f.pass2.value.length)
			F.p = F.E(f.pass2, M.e.match);
		
		return F.p;
	}
}

window.addEventListener('load', M.I);
