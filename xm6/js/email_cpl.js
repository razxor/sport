var M = {
	mb: 'email_cpl',
	e: {
		picks: 'No picks to send',
		ok: 'Data saved'
	},
	m: {
		
	},
	I: function() {
		
		this.L1();
		this.L2();
		this.L3();
		this.type_map = JSON.parse($('type_map').innerHTML);
		for (k in this.type_map)
			this.L4(1, k);
	},
	L1: function(p) {
		Aj.postUpd('reql0', 'req/'+this.mb+'/list_info.req.php', '');
		return false;
	},
	L2: function(p) {
		Aj.postUpd('reql0a', 'req/'+this.mb+'/list_games.req.php', '');
		return false;
	},
	L3: function(p) {
		Aj.postUpd('reql0b', 'req/'+this.mb+'/list_picks.req.php', '');
		return false;
	},
	L4: function(p, t) {
		Aj.postUpd('reql_'+t, 'req/'+this.mb+'/list_grp.req.php', 't='+encodeURIComponent(t));
		return false;
	},
	send: function(mode, t, el) {
		el.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		el.disabled = true;
		Aj.post('req/'+this.mb+'/send.req.php', 'mode='+mode+'&t='+t, {el:el, t:t}, function() {
			this.opt.el.disabled = true;
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					this.opt.el.getElementsByTagName('i')[0].className = 'fa fa-check';
				} else {
					this.opt.el.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					for (var i = 0; i < a.ea.length; i++) {
						A.p = A.E(a.ea[i][0]+'_'+this.opt.t, M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				this.opt.el.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				console.log(e)
			}
		});
		return false;
	},
	vGrp: function(t) {
		Aj.postUpd('reql1', 'req/'+this.mb+'/list_grp_addr.req.php', 't='+t, function() {
		});
		return false;
	},
	autoToggle: function(v, t) {
		if (t) {
			t.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
			t.disabled = true;
		}
		Aj.post('req/'+this.mb+'/auto_toggle.req.php', 'v='+v, {v:v, t:t}, function() {
			if (this.opt.t)
				this.opt.t.disabled = true;
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					if (this.opt.t) {
						this.opt.t.innerHTML = '<i class="fa fa-check"></i>Free emails are '+(this.opt.v ? 'ON' : 'OFF');
						this.opt.t.setAttribute('v', this.opt.v ? 0 : 1);
					}
				} else {
					if (this.opt.t)
						this.opt.t.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					for (var i = 0; i < a.ea.length; i++) {
						A.p = A.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				if (this.opt.t)
					this.opt.t.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				console.log(e)
			}
		});
		return false;
	},
	eTmpl: function(fn) {
		Aj.postUpd('reql1', 'req/'+this.mb+'/e_tmpl.req.php', 'fn='+encodeURIComponent(fn), function() {
			var f = this.el.getElementsByTagName('form')[0];
			A.addTrim(f);
			f.cont.focus();
			f.onsubmit = function() { return M.sTmpl(this); }
		});
		return false;
	},
	sTmpl: function(f) {
		if (!this.vTmpl(f))
			return false;
		f.btn1.disabled = true;
		
		Aj.post('req/'+this.mb+'/s_tmpl.req.php', A.GFD(f), {f:f}, function() {
			this.opt.f.btn1.disabled = false;
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					A.M('main', M.e.ok);
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
	vTmpl: function(f) {
		A.p = true;
		A.CE(f);
		var t;
		return A.p;
	},
	mh: function(act, t) {
		if (act == 'send')
			return M.send(t.getAttribute('mode'), t.getAttribute('t'), t);
		if (act == 'vgrp')
			return M.vGrp(t.getAttribute('t'));
		if (act == 'auto_toggle')
			return M.autoToggle(parseInt(t.getAttribute('v')), t)
		if (act == 'e_tmpl')
			return M.eTmpl(t.getAttribute('fn'));
	}
}

window.addEventListener('load', function() {
	M.I();
});