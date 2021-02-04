// bezier animations
$ = jQuery;
var bez = jQuery.bez([.19, 1, .22, 1]);
var bezcss = ".19,1,.22,1";

function mg_getProperty(arr0, arr1, arr2) {
    var tmp = document.createElement("div");
    for (var i = 0, len = arr0.length; i < len; i++) {
        tmp.style[arr0[i]] = 800;
        if (typeof tmp.style[arr0[i]] == 'string') {
            return {
                js: arr0[i],
                css: arr1[i],
                jsEnd: arr2[i]
            };
        }
    }
    return null;
}

function mg_getTransition() {
    var arr0 = ["transition", "msTransition", "MozTransition", "WebkitTransition", "OTransition", "KhtmlTransition"];
    var arr1 = ["transition", "-ms-transition", "-moz-transition", "-webkit-transition", "-o-transition", "-khtml-transition"];
    var arr2 = ["transitionend", "MSTransitionEnd", "transitionend", "webkitTransitionEnd", "oTransitionEnd", "khtmlTransitionEnd"];
    return mg_getProperty(arr0, arr1, arr2);
}

function mg_getTransform() {
    var arr0 = ["transform", "msTransform", "MozTransform", "WebkitTransform", "OTransform", "KhtmlTransform"];
    var arr1 = ["transform", "-ms-transform", "-moz-transform", "-webkit-transform", "-o-transform", "-khtml-transform"];
    return mg_getProperty(arr0, arr1, []);
}

function mg_getPerspective() {
    var arr0 = ["perspective", "msPerspective", "MozPerspective", "WebkitPerspective", "OPerspective", "KhtmlPerspective"];
    var arr1 = ["perspective", "-ms-perspective", "-moz-perspective", "-webkit-perspective", "-o-perspective", "-khtml-perspective"];
    return mg_getProperty(arr0, arr1, []);
}
var transition = mg_getTransition();
var transform = mg_getTransform();
var perspective = mg_getPerspective();



if (perspective) {
    $("#playlistitems").css(perspective.css, 400).css(perspective.css + "-origin", "200px 100px");
}
$('[id^="playlistitems-item-"]').css("opacity", 0);
$('[id^="playlistitems-item-"]').each(function(i) {
    var path = $(this);
    if (i < 6) {
        var x = -40;
    } else {
        var x = -380;
    }
    if (perspective && transition) {
        path.css(transition.css, "all 0s linear 0s");
        path.css(transform.css, "translate3d(" + x + "px, 20px,0) scale(0.5)");
        path.css("z-index", 0).css("opacity", 0);
    } else {
        path.clearQueue().stop().animate({
            transformJ: 'translate(' + x + ',20) scale(0.5)',
            opacity: 0
        }, {
            queue: true,
            duration: 0,
            specialEasing: {
                transformJ: bez,
                opacity: bez
            }
        });
        path.css("z-index", 0);
    }
});

var playlistitems = new Mg({
    reference: "playlistitems",
    click: {
        activated: [5],
        interactive: true,
        multiLess: 2,
        multiPlus: 2,
        dragFraction: true,
        scrollWheel: false,
        dragWheel: false

    }
});
playlistitems.click.onEvent = function() {
    var arr = this.multiBeforeOut;
    for (var i = 0; i < arr.length; i++) {
        var path = $("#" + this.reference + "-item-" + arr[i]);
        if (perspective && transition) {
            path.css(transition.css, transform.css + " 1.3s cubic-bezier(" + bezcss + ") 0s" + ", opacity 1.3s cubic-bezier(" + bezcss + ") 0s");
            path.css(transform.css, "translate3d(-40px, 20px,0) scale(0.5)");
            path.css("z-index", 0).css("opacity", 0);
        } else {
            path.clearQueue().stop().animate({
                transformJ: 'translate(-40,20) scale(0.5)',
                opacity: 0
            }, {
                queue: true,
                duration: 1300,
                specialEasing: {
                    transformJ: bez,
                    opacity: bez
                }
            });
            path.css("z-index", 0);
        }
    }
    var arr = this.multiAfterOut;
    for (var i = 0; i < arr.length; i++) {
        var path = $("#" + this.reference + "-item-" + arr[i]);
        if (perspective && transition) {
            path.css(transition.css, transform.css + " 1.3s cubic-bezier(" + bezcss + ") 0s" + ", opacity 1.3s cubic-bezier(" + bezcss + ") 0s");
            path.css(transform.css, "translate3d(380px, 20px,0) scale(0.5)");
            path.css("z-index", 0).css("opacity", 0);
        } else {
            path.clearQueue().stop().animate({
                transformJ: 'translate(380,20) scale(0.5)',
                opacity: 0
            }, {
                queue: true,
                duration: 1300,
                specialEasing: {
                    transformJ: bez,
                    opacity: bez
                }
            });
            path.css("z-index", 0);
        }
    }
    var arr = this.multiActivated;
    var xspace = 0;
    var add = 0;
    var fraction = this.fraction;
    for (var i = 0; i < arr.length; i++) {
        var path = $("#" + this.reference + "-item-" + arr[i]);
        if (i == this.multiLess) {
            add += 100 * (1 - fraction);
        }
        var x = xspace + add;
        if (i < this.multiLess) {
            var rot = 20;
            var depth = 100 + i;
            var scale = 0.8 + (i / 10);
        } else {
            var rot = -20;
            var depth = 200 - i;
            var scale = 1 - ((i - this.multiLess - 1) / 10);
        }
        if (i == this.multiLess) {
            add += 100 * fraction;
            rot = -20 + (40 * fraction);
        }
        xspace += add;
        add = 40;
        //
        if (this.eventType == "fraction" && i == this.multiLess) {
            var speed = 0;
        } else {
            var speed = 1.3;
        }
        if (perspective && transition) {
            path.css(transition.css, transform.css + " " + speed + "s cubic-bezier(" + bezcss + ") 0s" + ", opacity " + speed + "s cubic-bezier(" + bezcss + ") 0s");
            path.css(transform.css, "translate3d(" + x + "px,20px,0) rotateY(" + rot + "deg) scale(" + scale + ")");
            path.css("z-index", depth).css("opacity", 100);
        } else {
            path.clearQueue().stop().animate({
                transformJ: 'translate(' + x + ',20) scale(' + scale + ')',
                opacity: 1
            }, {
                queue: true,
                duration: speed * 1000,
                specialEasing: {
                    transformJ: bez,
                    opacity: bez
                }
            });
            path.css("z-index", depth);
        }
    }
}


playlistitems.init();