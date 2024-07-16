var M = {
	e: {
		opt: 'Please choose an option',
		email: 'Please enter your email',
		i_email: 'Invalid email address',
		added: 'You have been subscribed',
		unsub: 'You have been unsubscribed',
		saved: 'Your preferences have been saved'
	},
	I: function() {
		F.addTrim($('dfrm'));
		$('dfrm').onsubmit = function() {
			return M.RDo(this);
		}
	},
	RDo: function(f) {
		if (!this.V(f))
			return false;
		$('sbtn').disabled = true;
		$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		Aj.post('/req/sub/do.req.php', F.GFD(f), {f:f}, function() {
			try {
				$('sbtn').disabled = false;
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-check';
					F.M('main', M.e[a.msg]);
				} else {
					$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					for (var i = 0; i < a.ea.length; i++) {
						F.E(a.ea[i][0], M.e[a.ea[i][1]]);
					}
				}
			} catch (e) {
				$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				console.log(e)
			}
		});
		return false;
	},
	V: function(f) {
		F.CE(f);
		F.p = true;
		
		var opt = F.getOpt('opt');
		
		if (!f.email.value.length)
			F.p = F.E(f.email, this.e.email);
		else if (!F.val_email(f.email.value))
			F.p = F.E(f.email, this.e.i_email);
		
		
		return F.p;
	}
}

window.addEventListener('load', M.I);