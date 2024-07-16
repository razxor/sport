var M = {
	e:{
		opt: 'Please choose an option',
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
		Aj.post('/req/account/mailing_do.req.php', F.GFD(f), {f:f}, function() {
			$('sbtn').disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					F.M('main', M.e.ok);
				} else if (a.ea[0][0] == 'login') {
					document.location.reload();
				} else {
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				alert('Login error: ' + e + ' ' + this.responseText);
				console.log(e)
			}
		});
		return false;
	},
	V: function(f) {
		F.CE(f);
		F.p = true;
		
		var opt = F.getOpt('opt');
		
		return F.p;
	}
}

window.addEventListener('load', M.I);
