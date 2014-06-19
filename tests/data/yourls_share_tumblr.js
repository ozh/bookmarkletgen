// Share on Tumlr

var d = document,
	w = window,
	enc = encodeURIComponent,
	share = 'tumblr',
	e = w.getSelection,
	k = d.getSelection,
	x = d.selection,
	s = (e ? e() : (k) ? k() : (x ? x.createRange().text : 0)),
	s2 = ((s.toString() == '') ? s : '%20%22' + enc(s) + '%22'),
	f = 'http://sho.rt/admin/index.php',
	l = d.location.href,
	ups = l.match( /^[a-zA-Z0-9\+\.-]+:(\/\/)?/ )[0],
	ur = l.split(new RegExp(ups))[1],
	ups = ups.split(/\:/),
	p = '?up=' + enc(ups[0]+':') + '&us=' + enc(ups[1]) + '&ur='+enc(ur) + '&t=' + enc(d.title) + '&s=' + s2 + '&share=' + share,
	u = f + p;
try {
	throw ('ozhismygod');
} catch (z) {
	a = function () {
		if (!w.open(u,'Share','width=450,height=450,left=430','_blank')) l = u;
	};
	if (/Firefox/.test(navigator.userAgent)) setTimeout(a, 0);
	else a();
}
void(0);