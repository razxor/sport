var pg = {
	init: function() {
		$('wk_sel').onchange = function() {
			pg.load(this.value);
		}
	},
	load: function(w) {
		Aj.getUpd('games', '/req/games/gbl.req.php?wk='+encodeURIComponent(w));
	}
}

window.addEventListener('load', function() {
	pg.init();
});