var M = {
	mb: 'games',
	sf: 'game_id',
	so: 'ASC',
	filters: {},
	p: 1,
	e: {
		txt: 'Please paste the pipe-separated data',
		ext: 'Extension not allowed',
		proc: 'Precessing error',
		okp: 'Processed successfully'
	},
	I: function() {
		$('filters').onsubmit = function() { return M.F(this); };
		$('fup').onchange = function() { return M.FUP(this.files); };
		this.L();
		
		document.addEventListener('dragover', function(e) {
			e.preventDefault();
			e.stopPropagation();
			return false;
		}, false);
		
		document.addEventListener('drop', function(e) {
			e.preventDefault();
			e.stopPropagation();
			M.FUP(e.dataTransfer.files);
			return false;
		}, false);
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
			f.pick.focus();
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
						A.M('main', M.e.ok);
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
	P: function() {
		Aj.postUpd('reql1', 'req/'+this.mb+'/paste.req.php', '', function() {
			var f = this.el.getElementsByTagName('form')[0];
			A.addTrim(f);
			f.txt.focus();
			f.onsubmit = function() { return M.PDo(this); }
		});
		return false;
	},
	VP: function(f) {
		A.p = true;
		A.CE(f);
		var t;
		
		if (!(t=f.txt).value.length)
			A.p = A.EF(f, t, M.e[t.name]);
		
		return A.p;
	},
	PDo: function(f) {
		if (!this.VP(f))
			return false;
		
		f.btn1.disabled = true;
		f.btn1.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		
		Aj.post('req/'+this.mb+'/paste_do.req.php', A.GFD(f), {f:f}, function() {
			this.opt.f.btn1.disabled = false;
			this.opt.f.btn1.getElementsByTagName('i')[0].className = 'fa fa-bolt';
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					this.opt.f.txt.value = '';
					M.L();
					A.MF(this.opt.f, 'main', M.e.okp);
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						A.p = A.EF(this.opt.f, a.ea[i][0], M.e[a.ea[i][1]], a.ea[i][2]);
					}
					if (a.estr)
						$('reql2').innerHTML = a.estr;
				}
			} catch (e) {
				Ui.Alert(e + '<p>' + this.responseText + '</p>');
			}
		});
		
		return false;
	},
	FUP: function(fl) {
		if (!fl.length)
			return false;
		
		var b = $('b_upload');
		b.disabled = true;
		b.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		
		var fd = new FormData();
		for (var i = 0; i < fl.length; i++)
			fd.append('f[]', fl[i]);
		
		Aj.post('req/'+this.mb+'/fup_do.req.php', fd, {b:b, fl:fl}, function() {
			this.opt.b.disabled = false;
			if (this.responseText == 'NLI') {
				document.location.href = 'login.php';
				return;
			}
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					M.L();
					this.opt.b.getElementsByTagName('i')[0].className = 'fa fa-check';
				} else {
					this.opt.b.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					if (a.estr)
						$('reql1').innerHTML = a.estr;
				}
			} catch (e) {
				this.opt.b.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				Ui.Alert(e + '<p>' + this.responseText + '</p>');
			}
		});
		
		return false;
	},
	mh: function(act, t) {
		if (act == 'upload') {
			$('fup').click();
			return false;
		} else if (act == 'paste') {
			return M.P();
		}
	}
}

window.addEventListener('load', function() {
	M.I();
});