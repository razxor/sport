var M = {
	mb: 'slider',
	sf: 'd_o',
	so: 'ASC',
	filters: {},
	p: 1,
	e: {
		title: 'Enter the title'
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
			f.title.focus();
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
						$('reql1').innerHTML = '';
					else
						A.M('main', M.m['ok']);
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
	mh: function(act, t) {
		if (act == 'move')
			return M.mv(t.getAttribute('eid'), t.getAttribute('mode'));
	},
	mv: function(id, mode) {
		Aj.post('req/'+this.mb+'/move.req.php', 'id='+id+'&mode='+mode, {}, function(t) {
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				a = JSON.parse(this.responseText);
				if (a.status != 1)
					Ui.Alert(e + '<p>' + this.responseText + '</p>');
				else
					M.L();
			} catch (e) {
				Ui.Alert(e + '<p>' + this.responseText + '</p>');
			}
		});
		return false;
	},
	AD: function(id) {
		return Ui.Confirm('Delete item?', 'Delete', "Don't delete", (function(id) { return M.D(id); }).bind(null, id));
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
	}
}

window.addEventListener('load', function() {
	M.I();
});