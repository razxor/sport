var M = {
	mb: 'account',
	e: {
		name: 'Enter your full name',
		email: 'Enter your email address',
		email_i: 'Invalid email address',
		email_d: 'Duplicate email address',
		phone_i: 'Invalid phone number',
		phone_d: 'Duplicate phone number',
		user: 'Enter the username',
		user_i: 'Invalid username',
		user_d: 'Duplicate username',
		pass0: 'Enter your current password',
		pass_i: 'Invalid password',
		pass_s: 'Password is too short'
	},
	m: {
		ok: 'Data saved'
	},
	I: function() {
		var f = $('dfrm');
		A.addTrim(f);
		f.onsubmit = function() { return M.S(this); }
	},
	S: function(f) {
		if (!this.V(f))
			return false;
		
		Aj.post('req/'+this.mb+'/save.req.php', A.GFD(f), {f:f}, function() {
			this.opt.f.btn1.disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					A.M('main', M.m.ok);
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						A.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				Ui.Alert(e + '<p>' + this.responseText + '</p>');
			}
		});
		
		return false;
	},
	V: function(f) {
		A.p = true;
		A.CE(f);
		
		if (!(x = f.name).value.length)
			A.p = A.E(x, this.e['name']);
		if (!(x = f.email).value.length)
			A.p = A.E(x, this.e['email']);
		if (!(x = f.user).value.length)
			A.p = A.E(x, this.e['user']);
		
		if (f.user.value != f.user.defaultValue || f.pass1.value.length) {
			if (!f.pass0.value.length)
				A.p = A.E(f.pass0, this.e.pass0);
		}
		
		if (f.pass1.value.length) {
			if ((x = f.pass1).value.length < 6)
				A.p = A.E(x, this.e.pass_s);
		}
		
		return A.p;
	}
}

window.addEventListener('load', function() {
	M.I();
});