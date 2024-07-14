var pg = {
	init: function() {
		$('yr_sel').onchange = function() {
			document.location.href = '/my-picks/?y='+encodeURIComponent(this.value);
		}
		$('wk_sel').onchange = function() {
			document.location.href = '/my-picks/?y='+encodeURIComponent($('yr_sel').value)+'&w='+encodeURIComponent(this.value);
		}
		var f = $('dfrm');
		f.onsubmit = function() {
			return pg.save(this);
		}
		F.addTrim(f);
		if (f.nr.value)
			setTimeout(pg.refSc, 60000);
		
		document.addEventListener('click', pg.ch);
	},
	numc: function(el) {
		var p = el.parentElement.getElementsByTagName('input')[0], a = p.name.split('['), nm = a[0], step = 1, d = el.getAttribute('d'), dd = d == 'u' ? 1 : -1;
		if (nm == 'odds') {
			var v = Math.abs(parseInt(p.value));
			if (dd == 1) {
				if (v >= 150)
					step = 10;
				else if (v >= 115)
					step = 5;
			} else if (dd == -1) {
				if (v > 150)
					step = 10;
				else if (v > 115)
					step = 5;
			}
			
			if (step != 1)
				v = dd == 1 ? (Math.floor(v / step) * step) : (Math.ceil(v / step) * step)
			
			v = v + dd * step;
			v = Math.max(100, v);
			v = Math.min(999, v);
			p.value = -v;
		} else if (nm == 'wager' || nm == 'bankroll') {
			var v = Math.abs(parseInt(p.value)) || 0;
			if (dd == 1) {
				if (v >= 1000)
					step = 100;
				else if (v >= 500)
					step = 50;
				else if (v >= 100)
					step = 25;
				else if (v >= 50)
					step = 10;
				else if (v >= 10)
					step = 5;
			} else if (dd == -1) {
				if (v > 1000)
					step = 100;
				else if (v > 500)
					step = 50;
				else if (v > 100)
					step = 25;
				else if (v > 50)
					step = 10;
				else if (v > 10)
					step = 5;
			}
			
			if (step != 1)
				v = dd == 1 ? (Math.floor(v / step) * step) : (Math.ceil(v / step) * step)
			
			v = v + dd * step;
			v = Math.max(0, v);
			v = Math.min(99999, v);
			p.value = v;
		}
		
		return false;
	},
	spm: function(d, k) {
		var spe = $('sp_'+k); spv = spe.innerHTML, spv = spv == 'even' ? 0 : parseFloat(spv), spf_v = $('spf_v_'+k), spf_h = $('spf_h_'+k);
		var step = 0.5;
		
		if (d == 'lt') {
			if (spf_v.innerHTML && spv >= -25) {
				spv -= step;
				spe.innerHTML = spv;
				spf_v.innerHTML = '('+spv+')';
			} else if (spf_h.innerHTML) {
				spv += step;
				if (spv > 0) {
					spv = -step;
					spe.innerHTML = spv;
					spf_h.innerHTML = '';
					spf_v.innerHTML = '('+spv+')';
				} else {
					spe.innerHTML = spv == 0 ? 'even' : spv;
					spf_h.innerHTML = '('+(spv == 0 ? 'even' : spv)+')';
				}
			}
		} else if (d == 'rt') {
			if (spf_h.innerHTML && spv >= -25) {
				spv -= step;
				spe.innerHTML = spv;
				spf_h.innerHTML = '('+spv+')';
			} else if (spf_v.innerHTML) {
				spv += step;
				if (spv >= 0) {
					spe.innerHTML = spv == 0 ? 'even' : spv;
					spf_v.innerHTML = '';
					spf_h.innerHTML = '('+(spv == 0 ? 'even' : spv)+')';
				} else {
					spe.innerHTML = spv;
					spf_v.innerHTML = '('+spv+')';
				}
			}
		}
		
		return false;
	},
	pick: function(w, k) {
		var vt = $('vt_'+k), ht = $('ht_'+k);
		
		if (w == 'v') {
			ht.className = ht.className.removeClass('picked');
			vt.className = vt.className.hasClass('picked') ? vt.className.removeClass('picked') : vt.className.addClass('picked');
		} else if (w == 'h') {
			vt.className = vt.className.removeClass('picked');
			ht.className = ht.className.hasClass('picked') ? ht.className.removeClass('picked') : ht.className.addClass('picked');
		}
		
		return false;
	},
	brpush: function(el, v) {
		var is = el.getElementsByTagName('i');
		if (!is.length)
			el.appendChild(document.createElement('i'));
		var ico = el.getElementsByTagName('i')[0];
		ico.className = 'fa fa-cog fa-spin';
		
		var f = $('dfrm');
		var s = 'y='+encodeURIComponent(f.y.value)+'&w='+encodeURIComponent(f.w.value)+'&v='+encodeURIComponent(v);
		
		Aj.post('/req/ugm/brpush.req.php', s, {ico:ico}, function() {
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					this.opt.ico.className = 'fa fa-check';
				} else if (a.ea[0][0] == 'login') {
					document.location.reload();
				} else {
					this.opt.ico.className = 'fa fa-exclamation-triangle';
				}
			} catch (e) {
				this.opt.ico.className = 'fa fa-exclamation-triangle';
				console.log(e);
			}
		});
		
		return false;
	},
	ch: function(e) {
		var t = e.target;
		var act = t.getAttribute('act');
		if (!act && t.parentElement) {
			t = t.parentElement;
			act = t.getAttribute('act');
		}
		if (!act)
			return;
		
		if (t.tagName.toLowerCase() != 'input' || t.type.toLowerCase() != 'checkbox')
			e.preventDefault();
		
		if (act == 'spm')
			return pg.spm(t.getAttribute('d'), t.getAttribute('k'));
		else if (act == 'pick')
			return pg.pick(t.getAttribute('w'), t.getAttribute('k'));
		else if (act == 'numc')
			return pg.numc(t);
		else if (act == 'brpush')
			return pg.brpush(t, t.getAttribute('v'));
	},
	getData: function(f) {
		var ret = {
			gid: [], pick: [], spv: [], spf: [],
			wager: [], odds: [], notes: [],
			postify: function() {
				var s = '';
				
				for (k in this) {
					if (typeof(this[k]) != 'object')
						continue;
					for (kk in this[k]) {
						s += '&'+k+'['+kk+']='+encodeURIComponent(this[k][kk])
					}
				}
				
				return s.substr(1);
			}
		};
		var a = f.getElementsByTagName('tr');
		for (var i = 0; i < a.length; i++) {
			var tr = a[i], k = tr.getAttribute('k'), gid = tr.getAttribute('gid');
			if (!gid)
				continue;
			ret.gid[k] = parseInt(gid);
			
			var vt = $('vt_'+k), ht = $('ht_'+k);
			ret.pick[k] = '';
			if (vt.className.hasClass('picked'))
				ret.pick[k] = 'a';
			else if (ht.className.hasClass('picked'))
				ret.pick[k] = 'h';
			
			if ($('sp_'+k)) {
				var spv = $('sp_'+k).innerHTML;
				ret.spv[k] = spv == 'even' ? 0 : -parseFloat(spv)*10;
				
				var spf_v = $('spf_v_'+k), spf_h = $('spf_h_'+k);
				ret.spf[k] = spf_v.innerHTML ? 'a' : 'h';
			}
			
			var b = tr.getElementsByTagName('input');
			for (var j = 0; j < b.length; j++) {
				var c = b[j].name.split('[');
				if (c.length < 2 || c[1] != (k + ']'))
					continue;
				var nm = c[0], vv = b[j].value;
				if (nm == 'odds')
					vv = -parseInt(vv);
				else if (nm == 'wager')
					vv = parseFloat(vv) || 0;
				ret[nm][k] = vv;
			}
			var b = tr.getElementsByTagName('select');
			for (var j = 0; j < b.length; j++) {
				var c = b[j].name.split('[');
				if (c.length < 2 || c[1] != (k + ']'))
					continue;
				var nm = c[0], vv = b[j].value;
				if (nm == 'odds')
					vv = parseInt(vv);
				if (nm == 'sp') {
					var x = vv.split('.');
					ret.spv[k] = parseInt(x[0]);
					ret.spf[k] = x[1];
					continue;
				}
				ret[nm][k] = vv;
			}
		}
		return ret;
	},
	save: function(f) {
		f.btn1.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		f.btn2.getElementsByTagName('i')[0].className = 'fa fa-cog fa-spin';
		f.btn1.disabled = true;
		f.btn2.disabled = true;
		
		var s = 'y='+encodeURIComponent(f.y.value)+'&w='+encodeURIComponent(f.w.value)+'&bankroll='+encodeURIComponent(f.bankroll.value)+'&'+this.getData(f).postify();
		
		Aj.post('/req/ugm/save.req.php', s, {f:f}, function() {
			var f = this.opt.f;
			f.btn1.disabled = false;
			f.btn2.disabled = false;
			try {
				var a = JSON.parse(this.responseText);
				if (a.status == 1) {
					f.btn1.getElementsByTagName('i')[0].className = 'fa fa-check';
					f.btn2.getElementsByTagName('i')[0].className = 'fa fa-check';
					document.location.reload();
				} else if (a.ea[0][0] == 'login') {
					document.location.reload();
				} else {
					f.btn1.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
					f.btn2.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				}
			} catch (e) {
				f.btn1.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				f.btn2.getElementsByTagName('i')[0].className = 'fa fa-exclamation-triangle';
				console.log(e);
			}
		});
		
		return false;
	},
	refSc: function() {
		var f = $('dfrm');
		var s = 'y='+encodeURIComponent(f.y.value)+'&w='+encodeURIComponent(f.w.value);
		Aj.post('/req/ugm/scores.req.php', s, {f:f}, function() {
			try {
				var a = JSON.parse(this.responseText);
				for (var i = 0; i < a.g.length; i++) {
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