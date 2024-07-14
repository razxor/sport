var M = {
	e: {
		email: 'Please enter your email',
		i_email: 'Invalid email address',
		ns: 'You are not subscribed',
		ok: 'You have been unsubscribed.'
	},
	I: function() {
		$('dfrm').onsubmit = function() {
			return M.UDo(this);
		}
	},
	UDo: function(f) {
		if (!this.V(f))
			return false;
		$('sbtn').disabled = true;
		$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		Aj.post('/req/unsub3/do.req.php', F.GFD(f), {f:f}, function() {
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-check';
					F.M('main', M.e.ok);
				} else {
					$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					$('sbtn').disabled = false;
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				$('sbtn').disabled = false;
				console.log(e)
			}
		});
		return false;
	},
	V: function(f) {
		F.CE(f);
		F.p = true;
		
		
		return F.p;
	}
}

window.addEventListener('load', M.I);