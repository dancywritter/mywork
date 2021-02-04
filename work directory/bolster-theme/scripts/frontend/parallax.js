(function(e) {
	var t = e(window);
	var n = t.width();
	t.resize(function() {
		n = t.width()
	});
	e.fn.parallax = function(r, i, s) {
		function l() {
			var s = t.scrollLeft();
			o.each(function() {
				var t = e(this);
				var f = t.offset().left;
				var l = u(t);
				if (f + l < s || f > s + n) {
					return
				}
				o.css("backgroundPosition",  Math.round((a - (s+220)) * i) + "px")
			})
		}
		var o = e(this);
		var u;
		var a;
		var f = 0;
		o.each(function() {
			a = o.offset().left
		});
		if (s) {
			u = function(e) {
				return e.outerWidth(true)
			}
		} else {
			u = function(e) {
				return e.width()
			}
		} if (arguments.length < 1 || r === null) r = "50%";
		if (arguments.length < 2 || i === null) i = .05;
		if (arguments.length < 3 || s === null) s = true;
		t.bind("scroll", l).resize(l);
		l()
	}
})(jQuery)