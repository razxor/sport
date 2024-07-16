var pg = {
	tid: 0,
	init: function() {
		$('wk_sel').onchange = function() {
			pg.load(this.value);
		}
		pg.tid = setTimeout(function() { pg.load($('wk_sel').value); }, 60000);
	},
	load: function(w) {
		Aj.getUpd('games', '/req/games/wk_live.req.php?w='+encodeURIComponent(w), function() {
			$('week').innerHTML = $('x_wk').innerHTML;
			if (pg.tid)
				clearTimeout(pg.tid);
			if (!parseInt($('af').innerHTML))
				pg.tid = setTimeout(function() { pg.load($('wk_sel').value); }, 60000);
		});
	}
}

window.addEventListener('load', function() {
	pg.init();
});