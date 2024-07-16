var M = {
	mb: 'users',
	sf: 'user_id',
	so: 'DESC',
	filters: {},
	p: 1,
	e: {
		user: 'Enter the username',
		user_i: 'Invalid username',
		user_d: 'Duplicate username',
		pass: 'Enter the password',
		pass_s: 'Password is too short',
		name: 'Enter the name',
		email: 'Enter the email address',
		email_i: 'Invalid email address',
		email_d: 'Duplicate email address',
		phone_i: 'Invalid phone number',
		phone_d: 'Duplicate phone number',
		subj: 'Please enter the subject',
		msg: 'Please enter the message',
		oks: 'Messages have been sent'
	},
	m: {
		'ok': 'Data saved'
	},
	I: function() {
		$('filters').onsubmit = function() { return M.F(this); }
		this.L();
	},
	L: function(p) {
		var p = p || this.p;
		this.p = p;
		Aj.postUpd('reql0', 'req/'+this.mb+'/list.req.php', A.A2Url(this.filters)+'&p='+p+'&sf='+this.sf+'&so='+this.so);
		return false;
	},
	F: function(f) {
		this.filters = A.GFA(f);
		return this.L(1);
	},
	H: function(k) {
		this.so = (k == this.sf) ? (this.so == 'DESC' ? 'ASC' : 'DESC') : this.so;
		this.sf = k;
		return this.L();
	},
	E: function(id) {
		Aj.postUpd('reql1', 'req/'+this.mb+'/edit.req.php', 'id='+id, function() {
			var f = this.el.getElementsByTagName('form')[0];
			A.addTrim(f);
			if (f.user)
				f.user.focus();
			else
				f.name.focus();
			f.onsubmit = function() { return M.S(this); }
		});
		return false;
	},
	S: function(f) {
		if (!this.V(f))
			return false;
		f.btn1.disabled = true;
		
		Aj.post('req/'+this.mb+'/save.req.php', A.GFD(f), {f:f}, function() {
			this.opt.f.btn1.disabled = false;
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					M.L();
					if (!parseInt(this.opt.f.id.value))
						$('reql1').innerHTML='';
					else {
						A.M('main', M.m['ok']);
					}
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						A.p = A.EF(this.opt.f, a.ea[i][0], M.e[a.ea[i][1]], a.ea[i][2]);
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
		var t;
		return A.p;
	},
	set: function(k, id, v) {
		Aj.post('req/'+this.mb+'/set.req.php', 'id='+id+'&k='+k+'&v='+v, {}, function(t) {
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				a = JSON.parse(this.responseText);
				if (a.status != 1)
					Ui.Alert(e + '<p>' + this.responseText + '</p>');
			} catch (e) {
				Ui.Alert(e + '<p>' + this.responseText + '</p>');
			}
		});
	},
	AD: function(id) {
		return Ui.Confirm('Delete user?', 'Delete', "Don't delete", (function(id) { return M.D(id); }).bind(null, id));
	},
	D: function(id) {
		Aj.post('req/'+this.mb+'/del.req.php', 'id='+id, {}, function(t) {
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					$('reql1').innerHTML = '';
					M.L();
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
	Mass: function() {
		Aj.postUpd('reql1', 'req/'+this.mb+'/mass.req.php', '', function() {
			var f = this.el.getElementsByTagName('form')[0];
			A.addTrim(f);
			f.subj.focus();
			f.onsubmit = function() { return M.MassDo(this); }
		});
		return false;
	},
	VMass: function(f) {
		A.p = true;
		A.CE(f);
		var t;
		
		if (!(t=f.subj).value.length)
			A.p = A.EF(f, t, M.e[t.name]);
		if (!(t=f.msg).value.length)
			A.p = A.EF(f, t, M.e[t.name]);
		
		return A.p;
	},
	MassDo: function(f) {
		if (!this.VMass(f))
			return false;
		
		f.btn1.disabled = true;
		f.btn1.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		
		Aj.post('req/'+this.mb+'/mass_do.req.php', A.GFD(f), {f:f}, function() {
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					A.MF(this.opt.f, 'main', M.e.oks);
					this.opt.f.btn1.getElementsByTagName('i')[0].className = 'fa fa-check';
				} else {
					this.opt.f.btn1.disabled = false;
					this.opt.f.btn1.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					for (var i = 0; i < a.ea.length; i++) {
						A.p = A.EF(this.opt.f, a.ea[i][0], M.e[a.ea[i][1]], a.ea[i][2]);
					}
				}
			} catch (e) {
				this.opt.f.btn1.disabled = false;
				this.opt.f.btn1.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				Ui.Alert(e + '<p>' + this.responseText + '</p>');
			}
		});
		
		return false;
	},
	mh: function(act, t) {
		if (act == 'mass')
			return M.Mass();
	}
}

window.addEventListener('load', function() {
	M.I();
});