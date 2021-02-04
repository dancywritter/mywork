!function(a){"use strict";function b(a){return new RegExp("(^|\\s+)"+a+"(\\s+|$)")}function f(a,b){var f=c(a,b)?e:d;f(a,b)}var c,d,e;"classList"in document.documentElement?(c=function(a,b){return a.classList.contains(b)},d=function(a,b){a.classList.add(b)},e=function(a,b){a.classList.remove(b)}):(c=function(a,c){return b(c).test(a.className)},d=function(a,b){c(a,b)||(a.className=a.className+" "+b)},e=function(a,c){a.className=a.className.replace(b(c)," ")});var g={hasClass:c,addClass:d,removeClass:e,toggleClass:f,has:c,add:d,remove:e,toggle:f};"function"==typeof define&&define.amd?define(g):a.classie=g}(window);
/**
 * mlpushmenu.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
! function(a) {
	"use strict";

	function b(a, b) {
		for (var c in b) b.hasOwnProperty(c) && (a[c] = b[c]);
		return a
	}

	function c(a, b) {

		if (!a) return !1;
		for (var c = a.target || a.srcElement || a || !1; c && c.id != b;) c = c.parentNode || !1;
		return c !== !1
	}

	function d(a, b, c, e) {
		return e = e || 0, a.id.indexOf(b) >= 0 ? e : (classie.has(a, c) && ++e, a.parentNode && d(a.parentNode, b, c, e))
	}

	function e() {
		var b = !1;
		return function(a) {
			(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) && (b = !0)
		}(navigator.userAgent || navigator.vendor || a.opera), b
	}

	function f(a, b) {
		return classie.has(a, b) ? a : a.parentNode && f(a.parentNode, b)
	}

	function g(a, c, d) {

		this.el = a, this.trigger = c, this.options = b(this.defaults, d), this.support = Modernizr.csstransforms3d, this.support && this._init()

	}
	g.prototype = {
		defaults: {
			type: "overlap",
			levelSpacing: 40,
			backClass: "mp-back"
		},
		_init: function() {
			this.open = !1, this.level = 0, this.wrapper = document.getElementById("mp-pusher"), this.levels = Array.prototype.slice.call(this.el.querySelectorAll("div.mp-level"));
			var a = this;
			this.levels.forEach(function(b) {
				b.setAttribute("data-level", d(b, a.el.id, "mp-level"))
			}), this.menuItems = Array.prototype.slice.call(this.el.querySelectorAll("li")), this.levelBack = Array.prototype.slice.call(this.el.querySelectorAll("." + this.options.backClass)), this.eventtype = e() ? "touchstart" : "click", classie.add(this.el, "mp-" + this.options.type), this._initEvents()
		},
		_initEvents: function() {
			var a = this,
			b = function(c) {
				var ac = jQuery("#wrappermain-pix").hasClass('subheader-off')
				var ad = jQuery("#wrappermain-pix").hasClass('header-sticky-off')
				if (ac && ad) {
					a._resetMenu(), c.removeEventListener(a.eventtype, b)
				}
			};

			this.trigger.addEventListener(this.eventtype, function(d) {

				d.stopPropagation(), d.preventDefault(), a.open ? a._resetMenu() : (a._openMenu(), document.addEventListener(a.eventtype, function(d) {
					a.open && !c(d.target, a.el.id) && b(this)
				}))
			}), this.menuItems.forEach(function(b) {
				var d = b.querySelector("div.mp-level");
				d && b.querySelector("a").addEventListener(a.eventtype, function(c) {
					c.preventDefault();
					var e = f(b, "mp-level").getAttribute("data-level");
					a.level <= e && (c.stopPropagation(), classie.add(f(b, "mp-level"), "mp-level-overlay"), a._openMenu(d))


				})
			}), this.levels.forEach(function(b) {
				b.addEventListener(a.eventtype, function(c) {
					c.stopPropagation();
					var d = b.getAttribute("data-level");
					a.level > d && (a.level = d, a._closeMenu())
				})
			}), this.levelBack.forEach(function(b) {
				b.addEventListener(a.eventtype, function(c) {
					c.preventDefault();
					var d = f(b, "mp-level").getAttribute("data-level");
					a.level <= d && (c.stopPropagation(), a.level = f(b, "mp-level").getAttribute("data-level") - 1, 0 === a.level ? a._resetMenu() : a._closeMenu())
				})
			})
		},
		_openMenu: function(a) {
			
			++this.level;
			var b = (this.level - 1) * this.options.levelSpacing,
				c = "overlap" === this.options.type ? this.el.offsetWidth + b : this.el.offsetWidth;
			if (this._setTransform("translate3d(" + c + "px,0,0)"), a) {
				this._setTransform("", a);
				for (var d = 0, e = this.levels.length; e > d; ++d) {
					var f = this.levels[d];
					f == a || classie.has(f, "mp-level-open") || this._setTransform("translate3d(-100%,0,0) translate3d(" + -1 * b + "px,0,0)", f)
				}
			}
			1 === this.level && (classie.add(this.wrapper, "mp-pushed"),(classie.add(document.getElementById("wrappermain-pix"),"mp-wrapper-main")), this.open = !0), classie.add(a || this.levels[0], "mp-level-open")

		},
		_resetMenu: function() {

			this._setTransform("translate3d(0,0,0)"), this.level = 0, classie.remove(this.wrapper, "mp-pushed"),classie.remove(document.getElementById("wrappermain-pix"),"mp-wrapper-main"), this._toggleLevels(), this.open = !1

		},
		_closeMenu: function() {
			var a = "overlap" === this.options.type ? this.el.offsetWidth + (this.level - 1) * this.options.levelSpacing : this.el.offsetWidth;
			this._setTransform("translate3d(" + a + "px,0,0)"), this._toggleLevels()
		},
		_setTransform: function(a, b) {
			b = b || this.wrapper, b.style.WebkitTransform = a, b.style.MozTransform = a, b.style.transform = a
		},
		_toggleLevels: function() {
			for (var a = 0, b = this.levels.length; b > a; ++a) {
				var c = this.levels[a];
				c.getAttribute("data-level") >= this.level + 1 ? (classie.remove(c, "mp-level-open"), classie.remove(c, "mp-level-overlay")) : Number(c.getAttribute("data-level")) == this.level && classie.remove(c, "mp-level-overlay")
			}
		}
	}, a.mlPushMenu = g
}(window);