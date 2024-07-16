var M = {
	mb: 'c_req',
	sf: 'cr_id',
	so: 'DESC',
	filters: {},
	p: 1,
	e: {
		
	},
	m: {
		
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
		Aj.postUpd('reql1', 'req/'+this.mb+'/view.req.php', 'id='+id, function() {
		});
		return false;
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
	}
}

window.addEventListener('load', function() {
	M.I();
});