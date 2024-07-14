var Aj = {
	postUpd: function(el, u, p, ol) {
		var el = typeof(el) == 'string' ? $(el) : el;
		var ol = ol || function() { };
		var x = new XMLHttpRequest();
		x.open('POST', u, true);
		x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		x.el = el;
		x.ol = ol;
		x.onload = function() {
			this.el.innerHTML = this.responseText;
			this.ol();
		}
		x.send(p);
	},
	post: function(u, p, opt, ol) {
		var opt = opt || {};
		opt.lc = opt.lc || 1;
		var x = new XMLHttpRequest();
		x.open('POST', u, true);
		if (typeof(p) == 'string')
			x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		x.opt = opt;
		x.ol = ol;
		x.onload = function() {
			if (this.opt.lc && this.responseText == 'NLI') {
				document.location.href = 'login.php?bt='+encodeURIComponent(document.location.href);
				return false;
			}
			this.ol();
		}
		x.send(p);
	}
}

var T = {
	a: {},
	A: function(g, k) {
		if (!this.a[g])
			this.a[g] = 0;
		if (this.a[g] == k)
			return false;
		$('th_'+g+'_'+this.a[g]).className = '';
		$('tc_'+g+'_'+this.a[g]).style.display = 'none';
		$('th_'+g+'_'+k).className = 'active';
		$('tc_'+g+'_'+k).style.display = 'block';
		this.a[g] = k;
		return false;
	}
}

var Ui = {
	S: function(h, add) {
		var add = add || '';
		var s = '<div class="ui_el"><div><div>' + h + '</div></div>'+add+'</div>';
		$('ui_el').innerHTML = s;
	},
	CM: function(el) {
		var x = el, te = $('reql1'), te2 = $('reql2');
		do {
			if (x.parentElement == te || x.parentElement == te2) {
				x.parentElement.removeChild(x);
				break;
			}
			x = x.parentElement;
		} while (x);
		return false;
	},
	MR: function(tt, u, p, ol) {
		var ol = ol || function() { };
		Aj.post(u, p, {tt:tt, ol:ol}, function() {
			Ui.M(this.opt.tt, this.responseText);
			this.opt.ol();
		});
	},
	M: function(t, h) {
		var s = '<div class="modal"><div><div><div class="tt">'+t+'<a class="mclose" href="#" onclick="return Ui.MC();"><i class="fa fa-fw fa-close"></i></a></div>' + h + '</div></div></div>';
		$('modal').innerHTML = s;
	},
	MC: function() {
		$('modal').innerHTML = '';
		return false;
	},
	Confirm: function(t, yt, nt, ya, na) {
		var na = na || function() { return false; };
		var s = '<div class="modal"><div><div class="tt">'+t+'</div><div class="fr"><a href="#" class="btn1 alt2" act="ya">'+yt+'</a><a href="#" class="btn1" act="na">'+nt+'</a></div><div class="clr"></div></div></div>'
		var m = $('modal');
		m.innerHTML = s;
		m.ya = ya;
		m.na = na;
		return false;
	},
	Alert: function(t) {
		var s = '<div class="modal"><div><div class="tt">'+t+'</div><div class="fr"><a href="#" class="btn1" onclick="Ui.MC();return false;">Close</a></div><div class="clr"></div></div></div>'
		$('modal').innerHTML = s;
	},
	getDirect: function(e, t) {
		var a = [];
		var b = e.getElementsByTagName(t);
		for (var i = 0; i < b.length; i++)
			if (b[i].parentElement == e)
				a.push(b[i]);
		return a;
	},
	Khs: function() {
		document.onkeydown = function(e) {
			if (e.keyCode == 27) {
				if ($('modal').innerHTML)
					return Ui.MC();
				var el = $('reql2');
				if (el && el.innerHTML) {
					el.innerHTML = '';
					return false;
				}
				var el = $('reql1');
				if (el && el.innerHTML) {
					el.innerHTML = '';
					return false;
				}
			}
			if (e.keyCode == 37 || e.keyCode == 39) {
				if (typeof(M) == 'undefined' || typeof(M.L) != 'function')
					return;
				if ($('modal').innerHTML)
					return;
				var el = $('reql2');
				if (el && el.innerHTML)
					return;
				var el = $('reql1');
				if (el && el.innerHTML)
					return;
				var tn = e.target.tagName.toLowerCase();
				if (tn == 'input' || tn == 'textarea' || tn == 'select')
					return;
				if (e.keyCode == 37 && M.p > 1) {
					M.L(M.p - 1);
					return false;
				}
				if (e.keyCode == 39) {
					M.L(M.p + 1);
					return false;
				}
			}
		}
	},
	rss: function(w, h, tw, th) {
		tw = Math.min(tw, w);
		th = Math.min(th, h);
		src_ratio = w / h;
		dst_ratio = tw / th;
		if (src_ratio > dst_ratio)
			th = tw / src_ratio;
		else
			tw = th * src_ratio;

		return [Math.round(tw), Math.round(th)];
	},
	gws: function() {
		var winW = 630, winH = 460;
		if (document.body && document.body.offsetWidth) {
			winW = document.body.offsetWidth;
			winH = document.body.offsetHeight;
		}
		if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth) {
			winW = document.documentElement.offsetWidth;
			winH = document.documentElement.offsetHeight;
		}
		if (window.innerWidth && window.innerHeight) {
			winW = window.innerWidth;
			winH = window.innerHeight;
		}
		return [winW, winH];
	}
}

Ui.Khs();

var A = {
	p: false,
	E: function(e, t, prefix) {
		var prefix = prefix || 'e';
		if (a = $(prefix + '_'+(typeof(e) == 'string' ? e : e.name))) {
			a.style.display = t ? 'block' : 'none';
			a.innerHTML = t;
		}
		else
			alert(t);
		if (this.p) {
			try {
				e.focus();
			} catch (e) { };
		}
		return false;
	},
	M: function(e, t) {
		var a = $('m_'+e);
		if (!a)
		{
			alert(t);
			return false;
		}
		a.style.display = t ? 'block' : 'none';
		a.innerHTML = t;
		
		return false;
	},
	FF: function(e) {
		var x = e;
		do {
			if (x.parentElement.tagName.toUpperCase() == 'FORM')
				return x.parentElement;
			x = x.parentElement;
		} while (x);
		return false;
	},
	EF: function(f, e, t, trig) {
		var a = A.GEA(f, typeof(e) == 'string' ? e : e.name);
		var el = typeof(e) == 'string' ? eval("f."+e) : e;
		if (a) {
			a.style.display = t ? 'block' : 'none';
			a.innerHTML = t;
		} else
			alert(t);
		if (this.p) {
			try {
				if (trig)
					eval(trig);
				el.focus();
			} catch (ex) { };
		}
		return false;
	},
	MF: function(f, e, t) {
		var a = A.GEA(f, e);
		if (!a)
		{
			alert(t);
			return false;
		}
		a.style.display = t ? 'block' : 'none';
		a.innerHTML = t;
		
		return false;
	},
	GEA: function(f, n) {
		var a = f.getElementsByTagName('div');
		for (var i = 0; i < a.length; i++) {
			if ((a[i].className == 'err' || a[i].className == 'errc' || a[i].className == 'msgc') && a[i].getAttribute('assoc') == n)
				return a[i];
		}
		return false;
	},
	GFE: function(f) {
		var ret = [];
		var e = f.getElementsByTagName('input');
		for (var i = 0; i < e.length; i++)
			if (e[i].type.toLowerCase() != 'submit')
				ret.push(e[i]);
		var e = f.getElementsByTagName('textarea');
		for (var i = 0; i < e.length; i++)
			ret.push(e[i]);
		var e = f.getElementsByTagName('select');
		for (var i = 0; i < e.length; i++)
			ret.push(e[i]);
		return ret;
	},
	GFD: function(f) {
		var s = '';
		var e = this.GFE(f);
		for (var i = 0; i < e.length; i++)
			if ((e[i].tagName.toLowerCase() == 'input' && (e[i].type == 'text' || e[i].type == 'password' || e[i].type == 'hidden' || e[i].type == 'date')) || e[i].tagName.toLowerCase() == 'textarea' || (e[i].tagName.toLowerCase() == 'select' && !e[i].multiple))
				s += '&' + encodeURIComponent(e[i].name) + '=' + encodeURIComponent(e[i].value);
			else if (e[i].tagName.toLowerCase() == 'select' && e[i].multiple) {
				for (var j = 0; j < e[i].options.length; j++)
					if (e[i].options[j].selected)
						s += '&' + encodeURIComponent(e[i].name) + '=' + encodeURIComponent(e[i].options[j].value);
			}
			else if (e[i].tagName.toLowerCase() == 'input' && e[i].type == 'checkbox')
				s += '&' + encodeURI(e[i].name).replace(/&/g, '%26') + '=' + (e[i].checked?1:0);
			else if (e[i].tagName.toLowerCase() == 'input' && e[i].type == 'radio' && e[i].checked)
				s += '&' + encodeURI(e[i].name).replace(/&/g, '%26') + '=' + encodeURIComponent(e[i].value);
		return s.substr(1);
	},
	GFA: function(f) {
		var a = {};
		var e = this.GFE(f);
		for (var i = 0; i < e.length; i++)
			if ((e[i].tagName.toLowerCase() == 'input' && (e[i].type == 'text' || e[i].type == 'password' || e[i].type == 'hidden' || e[i].type == 'date')) || e[i].tagName.toLowerCase() == 'textarea' || (e[i].tagName.toLowerCase() == 'select' && !e[i].multiple))
				a[e[i].name] = e[i].value;
			else if (e[i].tagName.toLowerCase() == 'select' && e[i].multiple) {
				for (var j = 0; j < e[i].options.length; j++)
					if (e[i].options[j].selected)
						a[e[i].name] = e[i].options[j].value;
			}
			else if (e[i].tagName.toLowerCase() == 'input' && e[i].type == 'checkbox')
				a[e[i].name] = e[i].checked?1:0;
			else if (e[i].tagName.toLowerCase() == 'input' && e[i].type == 'radio' && e[i].checked)
				a[e[i].name] = e[i].value;
		return a;
	},
	A2Url: function(a) {
		var s = '';
		for (var k in a)
			s += '&' + encodeURIComponent(k) + '=' + encodeURIComponent(a[k]);
		return s.substr(1);
	},
	CE: function(f) {
		var a = f.getElementsByTagName('div');
		for (var i = 0; i < a.length; i++)
			if (a[i].className == 'err' || a[i].className == 'errc') {
				a[i].style.display = 'none';
				a[i].innerHTML = '';
			}
	},
	CF: function(f) {
		var b = this.GFE(f);
		for (var i = 0; i < b.length; i++)
			if (b[i].type.toUpperCase() != 'RADIO' && b[i].type.toUpperCase() != 'BUTTON')
				b[i].value = '';
	},
	Lo: function(f) {
		$('loading').style.display = f ? 'block' : 'none';
	},
	RLCl: function(id) {
		$('reql'+id).innerHTML = '';
		$('reql0').style.height = '';
		return false;
	},
	cA: function(c) {
		var a = document.getElementsByTagName('input');
		for (var i = 0; i < a.length; i++)
			if (a[i].className == 'cbc')
				a[i].checked = c;
		return false;
	},
	gC: function(c) {
		var ret = [];
		var a = document.getElementsByTagName('input');
		for (var i = 0; i < a.length; i++)
			if (a[i].className == 'cbc' && a[i].checked)
				ret.push(a[i].getAttribute('cid'));
		return ret;
	},
	val_email: function(s) {
		return /^[a-zA-Z0-9]([\w\.-]*[a-zA-Z0-9])?@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/.test(s);
	},
	val_phone: function (s) {
		return /^[0-9]+$/.test(s);
	},
	val_login: function(s) {
		return /^[a-zA-Z0-9\_\.]+$/.test(s);
	},
	val_pass: function(s) {
		return s.length >= 6;
	},
	get_option: function(nl) {
		for (var i = 0; i < nl.length; i++) {
			if (nl[i].checked)
				return nl[i].value;
		}
		return false;
	},
	AH: function(sec) {
		Aj.postUpd('reql1', 'req/a_help/sec.req.php', 'sec='+sec);
		return false;
	},
	addTrim: function(pa) {
		var b = pa.getElementsByTagName('textarea');
		for (var i = 0; i < b.length; i++)
			b[i].onblur = function() { this.value = this.value.trim(); }
		var b = pa.getElementsByTagName('input');
		for (var i = 0; i < b.length; i++)
			if (b[i].type.toLowerCase() == 'text')
				b[i].onblur = function() { this.value = this.value.trim(); }
	},
	mh: function(e) {
		if (!M)
			return;
		var t = e.target;
		var act = t.getAttribute('act');
		if (!act && t.parentElement) {
			t = t.parentElement;
			act = t.getAttribute('act');
		}
		if (!act)
			return;
		
		if (t.tagName.toLowerCase() != 'input' || t.type.toLowerCase() != 'checkbox')
			e.preventDefault();
		if (act == 'edit')
			return M.E(t.getAttribute('eid'));
		if (act == 'del')
			return M.AD(t.getAttribute('eid'));
		if (act == 'sort')
			return M.H(t.getAttribute('sf'));
		if (act == 'close') {
			$(t.getAttribute('reql')).innerHTML = '';
			return false;
		}
		if (act == 'set')
			return M.set(t.getAttribute('k'), t.getAttribute('eid'), t.checked ? 1 : 0);
		if (act == 'toggle') {
			var te = $(t.getAttribute('tid'));
			te.style.display = te.style.display == 'block' ? 'none' : 'block';
			return false;
		}
		
		if (act == 'ya') {
			$('modal').innerHTML = '';
			return $('modal').ya();
		}
		if (act == 'na') {
			$('modal').innerHTML = '';
			return $('modal').na();
		}
		
		if (M.mh)
			return M.mh(act, t);
		
		console.log(e)
	}
}

document.addEventListener('click', A.mh);

function $(e) {
	return document.getElementById(e);
}

String.prototype.trim = function(mask) {
	var mask = mask || '\\s';
	var Re = new RegExp('^['+mask+']+|['+mask+']+$', 'g');
	return this.replace(Re, '');
};

String.prototype.makeURL = function() {
	var s = this.replace(/'/g, '');
	s = s.trim();
	s = s.replace(/[^\w]+/g, '-');
	s = s.toLowerCase();
	s = s.trim('-');
	return s;
}
