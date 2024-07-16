var M = {
	e: {
		name: 'Please enter your name',
		email: 'Please enter your email',
		i_email: 'Invalid email address',
		subject: 'Please enter the subject',
		message: 'Please enter the message',
		s_msg: 'The message is too short',
		f_send: 'The message has not been sent. Please try again later.',
		ok: 'Your message has been sent.'
	},
	I: function() {
		$('dfrm').onsubmit = function() {
			return M.RDo(this);
		}
	},
	RDo: function(f) {
		if (!this.V(f))
			return false;
		$('sbtn').disabled = true;
		$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		Aj.post('/req/contact/send.req.php', F.GFD(f), {f:f}, function() {
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					$('sbtn').getElementsByTagName('i')[0].className = 'fa fa-check';
					F.M('main', M.e.ok);
					F.CF(this.opt.f);
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
		
		if (!f.name.value.length)
			F.p = F.E(f.name, this.e['name']);
		if (!f.email.value.length)
			F.p = F.E(f.email, this.e['email']);
		else if (!F.val_email(f.email.value))
			F.p = F.E(f.email, this.e['i_email']);
		if (!f.subject.value.length)
			F.p = F.E(f.subject, this.e['subject']);
		if (!f.message.value.length)
			F.p = F.E(f.message, this.e['message']);
		else if (f.message.value.length < 10)
			F.p = F.E(f.message, this.e['s_msg']);
		
		return F.p;
	}
}

window.addEventListener('load', M.I);