$(function() {
	$(".swiper-container").size() > 0 && require(["swiper"], function() {
		new Swiper(".swiper-container", {
			pagination: ".swiper-pagination",
			spaceBetween: 30,
			centeredSlides: !0,
			autoplay: 5e3,
			autoplayDisableOnInteraction: !1,
			loop: !0,
			mode: "horizontal",
			paginationClickable: !0,
			preloadImages: !1,
			lazyLoading: !0
		})
	}), ($(".js-audio-wx").size() > 0 || $(".js-audio-music").size() > 0) && require(["jquery.jplayer"], function() {
		$(".js-audio-wx").each(function() {
			$(this).jPlayer({
				ready: function(a) {
					$(this).jPlayer("setMedia", {
						mp3: window.sysinfo.attachurl + $("#" + $(this).attr("data-id")).attr("data-src")
					})
				},
				playing: function() {
					$("#" + $(this).attr("data-id")).find(".audio-time").show(), $("#" + $(this).attr("data-id")).find(".audioLoading").hide()
				},
				play: function() {
					$("#" + $(this).attr("data-id")).find(".audioLoading").show()
				},
				pause: function() {
					"true" == $("#" + $(this).attr("data-id")).attr("data-reload") && $(this).jPlayer("stop")
				},
				swfPath: "../web/resource/components/jplayer",
				supplied: "mp3,wma,wav,amr",
				solution: "html, flash",
				preload: "none",
				smoothPlayBar: !0,
				cssSelectorAncestor: "#" + $(this).attr("data-id"),
				cssSelector: {
					play: ".js-play",
					pause: ".js-pause",
					duration: ".audio-time"
				}
			})
		}), $(".js-audio-music").each(function() {
			$(this).jPlayer({
				ready: function(a) {
					$(this).jPlayer("setMedia", {
						mp3: window.sysinfo.attachurl + $("#" + $(this).attr("data-id")).attr("data-src")
					}), $(this).jPlayer("option", {
						loop: "true" == $("#" + $(this).attr("data-id")).attr("data-loop")
					})
				},
				playing: function() {
					$("#" + $(this).attr("data-id")).find(".audio-time").show(), $("#" + $(this).attr("data-id")).find(".audioLoading").hide(), $("#" + $(this).attr("data-id")).animate({
						height: "58px"
					})
				},
				play: function() {
					$("#" + $(this).attr("data-id")).find(".audioLoading").show()
				},
				pause: function() {
					"true" == $("#" + $(this).attr("data-id")).attr("data-reload") && $(this).jPlayer("stop")
				},
				swfPath: "../web/resource/components/jplayer",
				supplied: "mp3,wma,wav,amr",
				solution: "html, flash",
				preload: "none",
				smoothPlayBar: !0,
				cssSelectorAncestor: "#" + $(this).attr("data-id"),
				cssSelector: {
					play: ".js-play",
					pause: ".js-pause",
					stop: ".js-stop",
					currentTime: ".audio-current-time",
					duration: ".audio-duration",
					playBar: ".slider-fill",
					seekBar: ".slider-bar"
				}
			})
		})
	}), $(".notice-box").each(function() {
		var a = 0,
			b = $(this).find(".js-scroll-notice"),
			c = $(this);
		setInterval(function() {
			a--, 0 > a + b.width() && (a = c.width()), b.css({
				left: a
			})
		}, 25)
	}), $(".js-quickmenu div").removeClass("on"), $(".js-quickmenu .js-quickmenu-toggle").click(function() {
		$(this).hasClass("on") ? ($(this).removeClass("on"), $(".js-quickmenu .nav-group-item").removeClass("on")) : ($(this).addClass("on"), $(".js-quickmenu .nav-group-item").addClass("on"))
	}), $(".js-quickmenu a[data-toggle='dropdown']").click(function() {
		$(this).hasClass("on") ? ($(this).removeClass("on"), $(this).next("dl").hide()) : ($(".js-quickmenu a[data-toggle='dropdown']").removeClass("on"), $(".js-quickmenu dl").hide(), $(this).addClass("on"), $(this).next("dl").show())
	}), $(function() {
		$("form.js-ajax-form").submit(function(a) {
			return $(this).data("submit", 1), $('button[type="submit"]').prop("disabled", !0), $.ajax(this.action, {
				method: this.method.toUpperCase(),
				data: new FormData(this),
				cache: !1,
				processData: !1,
				contentType: !1,
				dataType: "json"
			}).done(function(a) {
				$(this).data("submit", 0), "success" == a.type ? util.toast(a.message, a.redirect, "success") : (util.toast(a.message, "", "error"), $('button[type="submit"]').prop("disabled", !1), util.toast(a.message, a.redirect, "error"))
			}).fail(function(a) {
				$(this).data("submit", 0), util.toast("操作失败，请重试", "", "error")
			}), a.preventDefault(), !1
		}), $(document).on("click", ".js-scan-rules", function() {
			$(this).parent().parent().next().toggle(), $(this).find("span").toggleClass("fa-angle-up"), $(this).find("span").toggleClass("fa-angle-down")
		}), $(".js-coupon-exchange").click(function() {
			var a = $.trim($(this).data("id")),
				b = ($(this).data("source"), $(this).data("href"));
			$(this).data("cancel-href"), $(this).data("exchange-href");
			return a ? void $.post(b, {
				id: a
			}, function(a) {
				a = $.parseJSON(a), console.dir(a), a.message.errno < 0 ? util.toast(a.message.message, "", "error") : util.toast(a.message.message, a.redirect, "error")
			}) : !1
		})
	}), $(".panes").size() > 0 && require(["hammer"], function(a) {
		function b(b, c, d) {
			return b & a.DIRECTION_HORIZONTAL ? c : d
		}
		function c(c, d) {
			this.container = c, this.direction = d, this.panes = Array.prototype.slice.call($(this.container).children(".pane"), 0), this.containerSize = this.container[b(d, "offsetWidth", "offsetHeight")], this.currentIndex = 0, this.hammer = new a.Manager(this.container), this.hammer.add(new a.Pan({
				direction: this.direction,
				threshold: 10
			})), this.hammer.on("panstart panmove panend pancancel", a.bindFn(this.onPan, this)), this.show(this.currentIndex)
		}
		1 == $(".pane").size() && $("body").css({
			overflow: "hidden"
		});
		var d = changeLockY = changePaneY = 0;
		$("div[type]");
		$("div[type]").each(function() {
			var a = $(this).attr("type").substring(0, 3);
			if ("adi" === a) var b = $(this).find("div[class='app-adImg']");
			else var b = $(this).find("div[class^='app-" + a + "']");
			var c = b.attr("style"),
				d = c.match(/animation\:(?:\s*)(\w+)\s+\d+/);
			if (null !== d && b.data("animateName", d[1]), b.data("animateName")) {
				var e = c.replace(/(-(?:webkit|moz|o|ms)-)?animation\:(?:\s*)(?:\w+)\s+(\d+)/g, "$1animation: noEffect $2");
				b.attr("style", e)
			}
		});
		(function() {
			return window[a.prefixed(window, "requestAnimationFrame")] ||
			function(a) {
				setTimeout(a, 1e3 / 60)
			}
		})();
		c.prototype = {
			show: function(b, c, d, e) {
				d = d || 0;
				var f = b;
				b = f > this.panes.length - 1 ? 0 : 0 > f ? this.panes.length - 1 : Math.max(0, Math.min(b, this.panes.length - 1));
				var g = this.container.className;
				e ? -1 === g.indexOf("animate") && (this.container.className += " animate") : -1 !== g.indexOf("animate") && (this.container.className = g.replace("animate", "").trim());
				var h, i, j;
				for (h = 0; h < this.panes.length; h++) if (i = this.containerSize / 100 * (100 * (h - b) + d), j = this.direction & a.DIRECTION_HORIZONTAL ? "translate3d(" + i + "px, 0, 0)" : "translate3d(0, " + i + "px, 0)", this.panes[h].style.transform = j, this.panes[h].style.mozTransform = j, this.panes[h].style.webkitTransform = j, b != c) {
					if (c == h) {
						var k = $(".pane").eq(h).find("div[type]");
						k.each(function() {
							var a = $(this).attr("type").substring(0, 3);
							if ("adi" === a) var b = $(this).find("div[class='app-adImg']");
							else var b = $(this).find("div[class^='app-" + a + "']");
							var c = b.attr("style"),
								d = c.replace(/(-(?:webkit|moz|o|ms)-)?animation\:(?:\s*)(?:\w+)\s+(\d+)/g, "$1animation: noEffect $2");
							b.attr("style", d)
						})
					}
					if (b == h) {
						var k = $(".pane").eq(h).find("div[type]");
						k.each(function() {
							var a = $(this).attr("type").substring(0, 3);
							if ("adi" === a) var b = $(this).find("div[class='app-adImg']");
							else var b = $(this).find("div[class^='app-" + a + "']");
							var c = b.attr("style"),
								d = b.data("animateName"),
								e = c.replace(/(-(?:webkit|moz|o|ms)-)?animation\:(?:\s*)(?:\w+)\s+(\d+)/g, "$1animation: " + d + " $2");
							b.attr("style", e)
						})
					}
				}
				this.currentIndex = b
			},
			onPan: function(a) {
				if (1 == $(".pane").size()) {
					$("body").css({
						overflow: "hidden"
					});
					var c = $(".panes").parent().css("height"),
						e = a.deltaY - d;
					if (changeLockY += e, changePaneY -= e, changePaneY < 0) return changePaneY = changeLockY = d = 0, !1;
					if (changePaneY + 568 > parseInt(c)) return changePaneY = parseInt(c) - 568, changeLockY = -(parseInt(c) - 568), d = 0, !1;
					if (parseInt(c) > Math.abs(changePaneY) && changePaneY >= 0) {
						var f = $(".alock");
						if (f.length > 0) for (var g = 0; g < f.length; g++) $(f.get(g)).parent("div").css({
							transform: "translate3d(0, " + -changeLockY + "px, 0)",
							"-moz-transform": "translate3d(0, " + -changeLockY + "px, 0)",
							"-webkit-transform": "translate3d(0, " + -changeLockY + "px, 0)",
							"z-index": "2"
						});
						$(".pane").css({
							transform: "translate3d(0, " + -changePaneY + "px, 0)",
							"-moz-transform": "translate3d(0, " + -changePaneY + "px, 0)",
							"-webkit-transform": "translate3d(0, " + -changePaneY + "px, 0)",
							"z-index": "1"
						})
					}
					d = a.deltaY ? a.deltaY : 0, "panend" != a.type && "pancancel" != a.type || (d = 0)
				} else {
					var h = b(this.direction, a.deltaX, a.deltaY),
						i = 100 / this.containerSize * h,
						j = !1,
						k = this.currentIndex;
					"panend" != a.type && "pancancel" != a.type || (Math.abs(i) > 10 && "panend" == a.type && (this.currentIndex += 0 > i ? 1 : -1), i = 0, j = !0), this.show(this.currentIndex, k, i, j)
				}
			}
		};
		var e = new c(document.querySelector(".panes"), a.DIRECTION_VERTICAL);
		e.hammer.get("pan"), function() {
			$(window).on("scroll.elasticity", function(a) {
				a.preventDefault()
			}).on("touchmove.elasticity", function(a) {
				a.preventDefault()
			}), $(window).delegate("img", "mousemove", function(a) {
				a.preventDefault()
			})
		}()
	})
});