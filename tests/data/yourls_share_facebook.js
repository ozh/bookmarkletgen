// Share on Facebook 

var d = document,
	enc = encodeURIComponent,
	share = 'facebook',
	f = 'http://sho.rt/admin/index.php',
	l=d.location.href,
	ups=l.match( /^[a-zA-Z0-9\+\.-]+:(\/\/)?/ )[0];
	var ur=l.split(new RegExp(ups))[1];
	var ups=ups.split(/\:/);
	p = '?up=' + enc(ups[0]+':') + '&us=' + enc(ups[1]) + '&ur=' + enc(ur) + '&t=' + enc(d.title) + '&share=' + share,
	u = f + p;
try {
	throw ('ozhismygod');
} catch (z) {
	a = function () {
		if (!window.open(u,'Share','width=500,height=340,left=100','_blank')) l.href = u;
	};
	if (/Firefox/.test(navigator.userAgent)) setTimeout(a, 0);
	else a();
}
void(0);