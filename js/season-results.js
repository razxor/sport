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
			}
		}
	},
	wstat: function(y, w) {
		Ui.R('/req/games/wk_res.req.php?y='+encodeURIComponent(y)+'&w='+encodeURIComponent(w));
		return false;
	}
}

window.addEventListener('load', function() {
	pg.init();
});