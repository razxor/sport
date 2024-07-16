var pg = {
	init: function() {
		var a = $('sres').getElementsByTagName('a');
		for (var i = 0; i < a.length; i++) {
			var act = a[i].getAttribute('act');
			if (!act)
				continue;
			if (act == 'wstat') {
				a[i].onclick = function() {
					return pg.wstat(this.getAttribute('y'), this.getAttribute('w'));
				}
			} else if (act == 'uwstat') {
				a[i].onclick = function() {
					return pg.uwstat(this.getAttribute('y'), this.getAttribute('w'));
				}
			} else if (act == 'hstat') {
				a[i].onclick = function() {
					return pg.hstat(this.getAttribute('y'), this.getAttribute('w'));
				}
			}
		}
	},
	wstat: function(y, w) {
		Ui.R('/req/games/wk_res.req.php?y='+encodeURIComponent(y)+'&w='+encodeURIComponent(w));
		return false;
	},
	uwstat: function(y, w) {
		Ui.R('/req/ugm/wk_res.req.php?y='+encodeURIComponent(y)+'&w='+encodeURIComponent(w));
		return false;
	},
	hstat: function(y, w) {
		Ui.R('/req/ugm/hh_res.req.php?y='+encodeURIComponent(y)+'&w='+encodeURIComponent(w));
		return false;
	}
}

window.addEventListener('load', function() {
	pg.init();
});