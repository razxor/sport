var A = {
	e: {
		'user': 'Please enter the username',
		'pass': 'Please enter the password',
		'fail': 'Login failed'
	},
	I: function() {
		var f = $('dfrm');
		f.user.onblur = function() { this.value = this.value.trim(); }
		f.user.focus();
		f.onsubmit = function() { return A.S(this); }
	},
	S: function(f) {
		if (!this.V(f))
			return false;
		
		var x = new XMLHttpRequest();
		x.open("POST", 'req/login/login.req.php', true);
		x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		x.f = f;
		
		x.onload = function() {
			try {
				var a = JSON.parse(this.responseText);
				if (!a.ea.length) {
					var bt = this.f.bt.value;
					if (!bt)
						bt = 'index.php';
					document.location.href = bt;
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						A.E(a.ea[i][0], A.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				alert('Caught: ' + e + ' ' + this.responseText);
			}
		}
		
		x.send(this.GFD(f));

		return false;
	},
	p: false,
	V: function(f) {
		this.p = true;
		this.CE(f);
		
		if (!(x = f.user).value.length)
			this.p = this.E(x, this.e[x.name]);
		if (!(x = f.pass).value.length)
			this.p = this.E(x, this.e[x.name]);
		
		return this.p;
	},
	E: function(e, t) {
		if (a = $('e_'+(typeof(e) == 'string' ? e : e.name))) {
			a.style.display = 'block';
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
	CE: function(f) {
		var a = f.getElementsByTagName('div');
		for (var i = 0; i < a.length; i++)
			if (a[i].className == 'err')
				a[i].innerHTML = '';
	},
	CF: function(f) {
		var b = this.GFE(f);
		for (var i = 0; i < b.length; i++)
			if (b[i].type.toUpperCase() != 'RADIO' && b[i].type.toUpperCase() != 'BUTTON')
				b[i].value = '';
	}
}

function $(e) {
	return document.getElementById(e);
}

String.prototype.trim = function(mask) {
	var mask = mask || '\\s';
	var Re = new RegExp('^['+mask+']+|['+mask+']+$', 'g');
	return this.replace(Re, '');
};

window.addEventListener('load', function() {
	A.I();
});
