var M = {
	e: {
		opt: 'Please choose an option',
		email: 'Please enter your email',
		i_email: 'Invalid email address',
		dup_week: 'You have already made a purchase for this week',
		dup_year: 'You have already purchased a season package'
	},
	I: function() {
		var f = $('dfrm');
		F.addTrim(f);
		f.onsubmit = function() {
			return M.RDo(this);
		}
		paypal.Button.render({
			env: f.env.value,
			commit: true,
			client: {
				sandbox: 'AR2fD7NjQ-z1rrXFL50MbNa0qdcajTlTgtZ77zMpSyZD7MD3ogJBieh8b3n7KDj_wJGoS3zYSV_6TU1P',
				production: 'Aeqv5qKsYO3cMQ-YAymot2R6hyJb7JsyKP-YUngVFTJ6q5SKa-tfMpC2XYBdTVyunBHrkg3_fZdXWyqY'
            },
			payment: function() {
				var f = $('dfrm');
				var CREATE_URL = '/req/buy/pp_create.req.php';
				var data = {
					opt: F.getOpt('opt'),
					email: f.email.value
				};
				return new paypal.Promise(function(resolve, reject) {
					paypal.request.post(CREATE_URL, data).then(function(a) {
							if (a.status == 1) {
								resolve(a.paymentID);
							} else {
								for (var i = 0; i < a.ea.length; i++) {
									F.E(a.ea[i][0], M.e[a.ea[i][1]]);
								}
								reject(new Error("Err!"))
							}
						}
					)
		        });
			},
			onAuthorize: function(data, actions) {
				var EXECUTE_URL = '/req/buy/pp_exec.req.php';
				var data = {
					paymentID: data.paymentID,
					payerID: data.payerID
				};
				return paypal.request.post(EXECUTE_URL, data).then(function (a) {
					if (a.status == 1) {
						document.location.href = '/purchases/complete/';
					} else {
						for (var i = 0; i < a.ea.length; i++) {
							F.E(a.ea[i][0], M.e[a.ea[i][1]]);
						}
					}
				});
			}
		}, '#paypal-button');
	},
	V: function(f) {
		F.CE(f);
		F.p = true;
		
		var opt = F.getOpt('opt');
		
		if (!opt)
			F.p = F.E('opt', this.e.opt);
		
		if (!f.email.value.length)
			F.p = F.E(f.email, this.e.email);
		else if (!F.val_email(f.email.value))
			F.p = F.E(f.email, this.e.i_email);
		
		return F.p;
	}
}

window.addEventListener('load', M.I);