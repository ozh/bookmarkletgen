// Simple Popup (in-page popup dialog)

var d = document,
	w = window,
	sc = d.createElement('script'),
	l = d.location.href,
	enc = encodeURIComponent,
	ups = l.match( /^[a-zA-Z0-9\+\.-]+:(\/\/)?/ )[0],
	ur = l.split(new RegExp(ups))[1],
	ups = ups.split(/\:/),
	p = '?up='+enc(ups[0]+':')+'&us='+enc(ups[1])+'&ur='+enc(ur)+'&t='+enc(d.title);
w.yourls_callback = function (r) {
	if (r.short_url) {
		prompt(r.message, r.short_url);
	} else {
		alert('An error occured: ' + r.message);
	}
};
sc.src = 'http://sho.rt/admin/index.php' + p + '&jsonp=yourls';
void(d.body.appendChild(sc));
