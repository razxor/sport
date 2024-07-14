var pg = {
	init: function() {
		$('yr_sel').onchange = function() {
			document.location.href = '/my-picks/scores/?y='+encodeURIComponent(this.value);
		}
		$('wk_sel').onchange = function() {
			document.location.href = '/my-picks/scores/?y='+encodeURIComponent($('yr_sel').value)+'&w='+encodeURIComponent(this.value);
		}
		if ($('nr').innerHTML)
			setTimeout(pg.refSc, 60000);
	},
	refSc: function() {
		var f = $('dfrm');
		var s = 'y='+encodeURIComponent($('yr_sel').value)+'&w='+encodeURIComponent($('wk_sel').value);
		Aj.post('/req/ugm/scores.req.php', s, {f:f}, function() {
			try {
				var a = JSON.parse(this.responseText);
				for (var i = 0; i < a.g.length; i++) {
					if (!$('vs_'+a.g[i].game_id))
						continue;
					$('vs_'+a.g[i].game_id).innerHTML = '<span class="score">'+a.g[i].v_score+'</span>';
					$('hs_'+a.g[i].game_id).innerHTML = '<span class="score">'+a.g[i].h_score+'</span>';
					var rr = $('rr_'+a.g[i].game_id);
					if (a.g[i].p_res === 0)
						rr.innerHTML = '<i class="fa fa-fw fa-refresh"></i> Push';
					else if (a.g[i].p_res == -1)
						rr.innerHTML = '<i class="fa fa-fw fa-close"></i> Loss';
					else if (a.g[i].p_res == 1)
						rr.innerHTML = '<i class="fa fa-fw fa-check"></i> Win';
				}
				if (!a.af)
					setTimeout(pg.refSc, 60000);
			} catch (e) {
				
			}
		});
	}
}

window.addEventListener('load', function() {
	pg.init();
});