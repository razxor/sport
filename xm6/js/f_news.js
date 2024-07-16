var M = {
	mb: 'f_news',
	sf: 'news_id',
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
	}
}

window.addEventListener('load', function() {
	M.I();
});