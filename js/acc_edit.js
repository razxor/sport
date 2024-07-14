var M = {
	e:{
		name: 'Please enter your name',
		email: 'Please enter your email',
		email_i: 'Invalid email',
		email_d: 'This email is already used in another account. Please use the password recovery function to access the account.',
		phone: 'Please enter your phone number',
		phone_i: 'Please enter digits only',
		phone_d: 'This number is already used in another account. Please use the password recovery function to access the account.',
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
		Aj.post('/req/account/edit_do.req.php', F.GFD(f), {}, function() {
			$('sbtn').disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					F.M('main', M.e[a.m]);
				} else if (a.ea[0][0] == 'login') {
					document.location.reload();
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				console.log(e)
			}
		});
		return false;
	},
	V: function(f) {
		F.CE(f);
		F.p = true;
		if (!(t=f.name).value)
			F.p = F.E(t.name, M.e.name);
		if (!(t=f.email).value)
			F.p = F.E(t.name, M.e.email);
		else if (!F.val_email((t=f.email).value))
			F.p = F.E(t.name, M.e.email_i);
		if (!(t=f.phone).value)
			F.p = F.E(t.name, M.e.phone);
		else if (!F.val_phone((t=f.phone).value))
			F.p = F.E(t.name, M.e.phone_i);
		
		return F.p;
	}
}

window.addEventListener('load', M.I);