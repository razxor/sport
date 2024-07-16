var M = {
	e: {
		user: 'Please enter your desired login',
		user_i: 'Invalid login',
		user_d: 'This login is used in another account. Please use the password recovery function to access the account.',
		pass: 'Please enter the password',
		pass_i: 'Incorrect password',
		pass_s: 'The password is too short',
		login_f: 'Login failed',
		name: 'Please enter your name',
		email: 'Please enter your email',
		email_i: 'Invalid email',
		email_d: 'This email is already used in another account. Please use the password recovery function to access the account.',
		email_nf: 'No acceount has been found with this email',
		phone: 'Please enter your phone number',
		phone_i: 'Please enter digits only',
		phone_d: 'This number is already used in another account. Please use the password recovery function to access the account.',
		terms: 'You have to accept the terms and conditions',
		reset_l: 'Please try again later',
		oks: 'Instructions to reset your password have been emailed to you.'
	},
	I: function() {
		$('th_0_0').onclick = function() { Ui.at(0, 0); $('lfrm').l_user.focus(); return false; };
		$('th_0_1').onclick = function() { Ui.at(0, 1); $('rfrm').r_name.focus(); return false; };
		var lfrm = $('lfrm'), rfrm = $('rfrm');
		F.addTrim(lfrm);
		lfrm.onsubmit = function() {
			return M.LDo(this);
		}
		lfrm.l_user.focus();
		F.addTrim(rfrm);
		rfrm.onsubmit = function() {
			return M.RDo(this);
		}
		$('forgot_btn').onclick = function() {
			Ui.R('/req/account/forgot.req.php', {ad: function() {
				var f = $('xdfrm')
				F.addTrim(f);
				f.s_email.focus();
				f.onsubmit = function() { return M.FDo(this); }
			}});
			return false;
		}
		$('terms_btn').onclick = function() {
			Ui.R('/req/account/terms.req.php');
			return false;
		}
	},
	onLogin: function() {
		if (typeof(_bt) != 'undefined') {
			document.location.href = _bt;
			return false;
		}

		document.location.href = "/my-picks/";
		//document.location.reload();
	},
	LDo: function(f) {
		if (!this.LV(f))
			return false;
		$('lbtn').disabled = true;
		Aj.post('/req/account/login_do.req.php', F.GFD(f), {}, function() {
			$('lbtn').disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					M.onLogin();
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				//alert('Login error: ' + e + ' ' + this.responseText);
				console.log(e)
			}
		});
		return false;
	},
	RDo: function(f) {
		if (!this.RV(f))
			return false;
		$('rbtn').disabled = true;
		Aj.post('/req/account/reg_do.req.php', F.GFD(f), {}, function() {
			$('rbtn').disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					M.onLogin();
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				//alert('Login error: ' + e + ' ' + this.responseText);
				console.log(e)
			}
		});
		return false;
	},
	FDo: function(f) {
		if (!this.FV(f))
			return false;
		$('rs_btn').disabled = true;
		$('rs_btn').getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		Aj.post('/req/account/forgot_do.req.php', F.GFD(f), {}, function() {
			$('rs_btn').disabled = false;
			$('rs_btn').getElementsByTagName('i')[0].className = 'fa fa-key';
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					F.M('main', M.e.oks, 'xm');
					$('rs_btn').disabled = true;
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]], 'xe');
					}
				}
			} catch (e) {
				//alert('Login error: ' + e + ' ' + this.responseText);
				console.log(e)
			}
		});
		return false;
	},
	LV: function(f) {
		F.CE(f);
		F.p = true;
		if (!(t=f.l_user).value)
			F.p = F.E(t, M.e.user);
		else if (!F.val_user((t=f.l_user).value) && !F.val_email((t=f.l_user).value))
			F.p = F.E(t, M.e.user_i);
		if (!(t=f.l_pass).value)
			F.p = F.E(t, M.e.pass);
		else if (!F.val_pass((t=f.l_pass).value))
			F.p = F.E(t, M.e.pass_s);
		
		return F.p;
	},
	RV: function(f) {
		F.CE(f);
		F.p = true;
		
		if (!(t=f.r_name).value)
			F.p = F.E(t, M.e.name);
		if (!(t=f.r_email).value)
			F.p = F.E(t, M.e.email);
		else if (!F.val_email((t=f.r_email).value))
			F.p = F.E(t, M.e.email_i);
		if (!(t=f.r_phone).value)
			F.p = F.E(t, M.e.phone);
		else if (!F.val_phone((t=f.r_phone).value))
			F.p = F.E(t, M.e.phone_i);
		if (!(t=f.r_user).value)
			F.p = F.E(t, M.e.user);
		else if (!F.val_user((t=f.r_user).value))
			F.p = F.E(t, M.e.user_i);
		if (!(t=f.r_pass).value)
			F.p = F.E(t, M.e.pass);
		else if (!F.val_pass((t=f.r_pass).value))
			F.p = F.E(t, M.e.pass_s);
		if (!f.terms.checked)
			F.p = F.E('terms', M.e.terms);
		
		return F.p;
	},
	FV: function(f) {
		F.CE(f);
		F.p = true;
		if (!(t=f.s_email).value)
			F.p = F.E(t, M.e.email, 'xe');
		else if (!F.val_email((t=f.s_email).value))
			F.p = F.E(t, M.e.email_i, 'xe');
		
		return F.p;
	}
}

window.addEventListener('load', M.I);