function $(el) {
	return typeof el == 'string' ? document.getElementById(el) : el;
}

String.prototype.addClass = function(cn) { 
    var a = this.trim().split(' ').map(function(s) {
    	return s.trim();
    });
    a.push(cn);
    return a.join(' ').trim();
}

String.prototype.removeClass = function(cn) { 
    var a = this.trim().split(' ').map(function(s) {
    	return s.trim();
    });
    var idx = a.indexOf(cn);
    if (idx != -1)
    	a.splice(idx, 1);
    return a.join(' ').trim();
}

String.prototype.hasClass = function(cn) {
	var a = this.trim().split(' ').map(function(s) {
    	return s.trim();
    });
	return a.indexOf(cn) != -1;
}

var bc = {
	init: function() {
		var tgm = $('tgm');
		if (tgm)
			tgm.onclick = function() { return bc.tgm(this); }
		new sl('slider1');
		new cd('cd1');
	},
	tgm: function(el) {
		el.className == 'btn1 fao' ? 'btn1 fao tgm_active' : 'btn1 fao';
		var mnav = $('mnav');
		mnav.className = ((mnav.className == 'mnav') ? 'mnav active' : 'mnav');
		return false;
	}
}

window.addEventListener('load', function() {
	bc.init();
});

/*window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', 'UA-1822520-1', 'auto');
ga('send', 'pageview');*/

var sl = function(el) {
	this.el = typeof(el) == 'string' ? $(el) : el;
	if (!this.el)
		return;
	this.ls = this.el.getElementsByTagName('li');
	if (!this.ls.length)
		return;
	this.ak = -1;
	this.slide = 1;
	
	this.el.onmouseover = (function(o) {
		o.slide = 0;
	}).bind(null, this);
	
	this.el.onmouseout = (function(o) {
		o.slide = 1;
	}).bind(null, this);
	
	this.a = function(k) {
		if (this.ak >= 0)
			this.ls[this.ak].className = '';
		this.ls[k].className = 'active';
		this.ak = k;
	}
	
	this.n = function() {
		var nk = (this.ak >= this.ls.length - 1) ? 0 : this.ak + 1;
		this.a(nk);
	}
	
	this.p = function() {
		var pk = (this.ak > 0) ? this.ak - 1 : this.ls.length - 1;
		this.a(pk);
	}
	
	var cn = this.el.getElementsByTagName('div')[0].getElementsByTagName('a');
	cn[0].onclick = (function(o) {
		o.p();
		return false;
	}).bind(null, this);
	
	cn[1].onclick = (function(o) {
		o.n();
		return false;
	}).bind(null, this);
	
	this.a(0)
	
	setInterval((function(o) { if (o.slide) o.n(); }).bind(null, this), 7000);
}

var cd = function(el) {
	this.el = typeof(el) == 'string' ? $(el) : el;
	if (!this.el)
		return;
	this.bs = this.el.getElementsByTagName('b');
	if (!this.bs.length)
		return;
	this.td = new Date(this.el.getAttribute('ts') * 1000);
	
	this.u = function() {
		var dn = new Date();
		if (dn > this.td) {
			for (var i = 0; i < this.bs.length; i++)
				this.bs[i].innerHTML = '0';
			if (this.tm)
				clearTimeout(this.tm);
			return;
		}
		
		
		var d = new Date(this.td - dn), days = d.getUTCDate() - 1, hrs = d.getUTCHours(), min = d.getUTCMinutes(), sec = d.getUTCSeconds();
		this.bs[0].innerHTML = days;
		this.bs[1].innerHTML = hrs;
		this.bs[2].innerHTML = min;
		this.bs[3].innerHTML = sec;
	}
	
	this.u();
	this.tm = setInterval((function(o) { o.u(); }).bind(null, this), 1000);
}

var Aj = {
	postUpd: function(el, u, p, ol) {
		var el = typeof(el) == 'string' ? $(el) : el;
		var ol = ol || function() { };
		//A.Lo(1);
		var x = new XMLHttpRequest();
		x.open('POST', u, true);
		x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		x.el = el;
		x.ol = ol;
		x.onload = function() {
			this.el.innerHTML = this.responseText;
			this.ol();
			//A.Lo(0);
		}
		x.send(p);
	},
	post: function(u, p, opt, ol) {
		var x = new XMLHttpRequest();
		x.open('POST', u, true);
		if (typeof(p) == 'string')
			x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		x.opt = opt;
		x.onload = ol;
		x.send(p);
	},
	getUpd: function(el, u, ol) {
		var ol = ol || function() { };
		var x = new XMLHttpRequest();
		x.open('GET', u, true);
		x.el = el;
		x.ol = ol;
		x.onload = function() {
			var el = (this.el instanceof Array) ? this.el : [this.el];
			for (var i = 0; i < el.length; i++) {
				var elh = (typeof(el[i]) == 'string') ? $(el[i]) : el[i];
				if (elh)
					elh.innerHTML = this.responseText;
			}
			this.ol();
		}
		x.send();
	},
	get: function(u, opt, ol) {
		var x = new XMLHttpRequest();
		x.open('GET', u, true);
		x.opt = opt;
		x.onload = ol;
		x.send();
	}
}

var Ui = {
	R: function(url, p) {
		var p = p || {};
		p.p = p.p || '';
		p.l = p.l || 0;
		p.ad = p.ad || function() { };
		var m = p.p ? 'POST' : 'GET';
		p.el = $('reql'+p.l);
		
		var x = new XMLHttpRequest();
		x.open(m, url, true);
		x.p = p;
		if (p.p)
			x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		
		x.onload = function() {
			try {
				var a = JSON.parse(this.responseText)[0];
				if (a.status == -2) {
					document.location.href = a.bt + '?bt='+encodeURIComponent(document.location.href);
					return false;
				}
			} catch (e) {
			}
			
			this.p.el.innerHTML = this.responseText;
			Ui.kh_add();
			
			try {
				var a = this.p.el.getElementsByTagName('h1')[0].getElementsByTagName('a')[0];
				a.el = this.p.el;
				a.onclick = function() {
					this.el.innerHTML = '';
					Ui.kh_rem();
					return false;
				}
			} catch (e) {
				
			}
			
			this.p.ad(this.p);
		}
		
		if (m == 'POST')
			x.send(p.p);
		else
			x.send();
		return false;
	},
	S: function(t, s, p) {
		var p = p || {};
		p.l = p.l || 0;
		p.aft = p.aft || '';
		p.oc = p.oc || function() { };
		var h = '<div><div><h1>'+t+'<a href="#"><i class="fa fa-close"></i></a></h1><div class="lcont">'+s+'</div></div></div>'+p.aft;
		var el = $('reql'+p.l);
		el.innerHTML = h;
		Ui.kh_add();
		try {
			var a = el.getElementsByTagName('h1')[0].getElementsByTagName('a')[0];
			a.el = el;
			a.oc = p.oc;
			a.onclick = function() {
				this.el.innerHTML = '';
				Ui.kh_rem();
				this.oc();
				return false;
			}
		} catch (e) {
			
		}
	},
	kh_pres: 0,
	kh_add: function() {
		if (this.kh_pres)
			return;
		
		document.addEventListener('keydown', Ui.kh);
		this.kh_pres = 1;
	},
	kh_rem: function() {
		for (var i = 2; i >= 0; i--) {
			var el = $('reql'+i);
			if (el && el.innerHTML)
				return;
		}
		document.removeEventListener('keydown', Ui.kh);
		this.kh_pres = 0;
	},
	kh: function(e) {
		if (e.keyCode == 27) {
			for (var i = 2; i >= 0; i--) {
				var el = $('reql'+i);
				if (el && el.innerHTML) {
					var a = el.getElementsByTagName('h1')[0].getElementsByTagName('a')[0];
					if (a.oc)
						a.oc();
					el.innerHTML = '';
					Ui.kh_rem();
					return false;
				}
			}
			return false;
		}
	},
	ats:[],
	at: function(j, k) {
		if (!this.ats[j])
			this.ats[j] = 0;
		$('th_'+j+'_'+this.ats[j]).className = '';
		$('tc_'+j+'_'+this.ats[j]).style.display = 'none';
		$('th_'+j+'_'+k).className = 'active';
		$('tc_'+j+'_'+k).style.display = 'block';
		this.ats[j] = k;
		return false;
	}
}

var F = {
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
	M: function(e, t, prefix) {
		var prefix = prefix || 'm';
		var a = $(prefix+'_'+e);
		if (!a)
		{
			alert(t);
			return false;
		}
		a.style.display = t ? 'block' : 'none';
		a.innerHTML = t;
		
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
			if ((e[i].tagName.toLowerCase() == 'input' && (e[i].type == 'text' || e[i].type == 'password' || e[i].type == 'hidden')) || e[i].tagName.toLowerCase() == 'textarea' || (e[i].tagName.toLowerCase() == 'select' && !e[i].multiple))
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
			if ((e[i].tagName.toLowerCase() == 'input' && (e[i].type == 'text' || e[i].type == 'password' || e[i].type == 'hidden')) || e[i].tagName.toLowerCase() == 'textarea' || (e[i].tagName.toLowerCase() == 'select' && !e[i].multiple))
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
	val_email: function(s) {
		return /^[a-zA-Z0-9]([\w\.-]*[a-zA-Z0-9])?@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/.test(s);
	},
	val_phone: function (s) {
		return (s.length >= 10) && /^\+?[0-9\ \-\.]+$/.test(s);
	},
	val_user: function(s) {
		return /^[a-zA-Z0-9\_\.\-]+$/.test(s);
	},
	val_pass: function(s) {
		return s.length >= 6;
	},
	getOpt: function(nm) {
		var el = document.getElementsByName(nm);
		for (var i = 0; i < el.length; i++) {
			if (el[i].checked)
				return el[i].value;
		}
		return false;
	},
	getOpt2: function(nm) {
		var el = document.getElementsByName(nm);
		for (var i = 0; i < el.length; i++) {
			if (el[i].checked)
				return el[i];
		}
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
	}
}