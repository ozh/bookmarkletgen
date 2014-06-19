// Custom Popup (prompt for a keyword + on-page popup)

var d = document,
	l = d.location.href,
	k = prompt('Custom URL'),
	enc = encodeURIComponent,
	ups = l.match( /^[a-zA-Z0-9\+\.-]+:(\/\/)?/ )[0],
	ur = l.split(new RegExp(ups))[1],
	ups = ups.split(/\:/),
	p = '?up='+enc(ups[0]+':')+'&us='+enc(ups[1])+'&ur='+enc(ur)+'&t='+enc(d.title);
	sc = d.createElement('script');
if (k != null) {
	window.yourls_callback = function (r) {
		if (r.short_url) {
			prompt(r.message, r.short_url);
		} else {
			alert('An error occured: ' + r.message);
		}
	};
	sc.src = 'http://sho.rt/admin/index.php' + p + '&k=' + k + '&jsonp=yourls';
	void(d.body.appendChild(sc));
}
