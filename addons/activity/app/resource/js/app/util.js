!
function(a) {
	var b = {};
	b.dialog = function(a, b, c, d) {
		d || (d = {}), d.containerName || (d.containerName = "modal-message");
		var e = $("#" + d.containerName);
		0 == e.length && ($(document.body).append('<div id="' + d.containerName + '" class="modal animated" tabindex="-1" role="dialog" aria-hidden="true"></div>'), e = $("#" + d.containerName));
		var f = '<div class="modal-dialog modal-sm">	<div class="modal-content">';
		if (a && (f += '<div class="modal-header">	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	<h3>' + a + "</h3></div>"), b && (f += $.isArray(b) ? '<div class="modal-body">正在加载中</div>' : '<div class="modal-body">' + b + "</div>"), c && (f += '<div class="modal-footer">' + c + "</div>"), f += "	</div></div>", e.html(f), b && $.isArray(b)) {
			var g = function(a) {
					e.find(".modal-body").html(a)
				};
			2 == b.length ? $.post(b[0], b[1]).success(g) : $.get(b[0]).success(g)
		}
		return e
	}, b.image = function(c, d, e) {
		require(["webuploader", "cropper", "previewer"], function(f) {
			var g, h, i, j = b.querystring("i"),
				k = b.querystring("j");
			defaultOptions = {
				pick: {
					id: "#filePicker",
					label: "点击选择图片",
					multiple: !1
				},
				auto: !0,
				swf: "./resource/componets/webuploader/Uploader.swf",
				server: "./index.php?i=" + j + "&j=" + k + "&c=utility&a=file&do=upload&type=image&thumb=0",
				chunked: !1,
				compress: !1,
				fileNumLimit: 1,
				fileSizeLimit: 4194304,
				fileSingleSizeLimit: 4194304,
				crop: !1,
				preview: !1
			}, "android" == b.agent() && (defaultOptions.sendAsBinary = !0), e = $.extend({}, defaultOptions, e), c && (c = $(c), e.pick = {
				id: c,
				multiple: e.pick.multiple
			}), e.multiple && (e.pick.multiple = e.multiple, e.fileNumLimit = 8), e.crop && (e.auto = !1, e.pick.multiple = !1, e.preview = !1, f.Uploader.register({
				"before-send-file": "cropImage"
			}, {
				cropImage: function(a) {
					if (!a || !a._cropData) return !1;
					var b, c, d = a._cropData;
					return a = this.request("get-file", a), c = f.Deferred(), b = new f.Lib.Image, c.always(function() {
						b.destroy(), b = null
					}), b.once("error", c.reject), b.once("load", function() {
						b.crop(d.x, d.y, d.width, d.height, d.scale)
					}), b.once("complete", function() {
						var d, e;
						try {
							d = b.getAsBlob(), e = a.size, a.source = d, a.size = d.size, a.trigger("resize", d.size, e), c.resolve()
						} catch (f) {
							c.resolve()
						}
					}), a._info && b.info(a._info), a._meta && b.meta(a._meta), b.loadFromBlob(a.source), c.promise()
				}
			})), h = f.create(e), c.data("uploader", h), e.preview && (i = mui.previewImage({
				footer: a.util.templates["image.preview.html"]
			}), $(i.element).find(".js-cancel").click(function() {
				i.close()
			}), $(document).on("click", ".js-submit", function(a) {
				var b = $(i.element).find(".mui-slider-group .mui-active").index();
				if (i.groups.__IMG_UPLOAD && i.groups.__IMG_UPLOAD[b] && i.groups.__IMG_UPLOAD[b].el) {
					var c = "./index.php?i=" + j + "&j=" + k + "&c=utility&a=file&do=delete&type=image",
						d = $(i.groups.__IMG_UPLOAD[b].el).data("id");
					$.post(c, {
						id: d
					}, function(a) {
						var a = $.parseJSON(a);
						$(i.groups.__IMG_UPLOAD[b].el).remove(), i.close()
					})
				}
				return a.stopPropagation(), !1
			})), h.on("fileQueued", function(a) {
				b.loading().show(), e.crop && h.makeThumb(a, function(b, c) {
					h.file = a, b || g.preview(c)
				}, 1, 1)
			}), h.on("uploadSuccess", function(a, c) {
				if (c.error && c.error.message) b.toast(c.error.message, "error");
				else {
					b.loading().close(), h.reset(), g.reset();
					var f = $('<img src="' + c.url + '" data-preview-src="" data-preview-group="' + e.preview + '" />');
					e.preview && i.addImage(f[0]), $.isFunction(d) && d(c)
				}
			}), h.onError = function(a) {
				return g.reset(), b.loading().close(), "Q_EXCEED_SIZE_LIMIT" == a ? void alert("错误信息: 图片大于 4M 无法上传.") : "Q_EXCEED_NUM_LIMIT" == a ? void b.toast("单次最多上传8张") : void alert("错误信息: " + a)
			}, g = function() {
				var c, d;
				return {
					preview: function(f) {
						return c = $(a.util.templates["avatar.preview.html"]), c.css("height", $(a).height()), $(document.body).prepend(c), d = c.find("img"), d.attr("src", f), d.cropper({
							aspectRatio: e.aspectRatio ? e.aspectRatio : 1,
							viewMode: 1,
							dragMode: "move",
							autoCropArea: 1,
							restore: !1,
							guides: !1,
							highlight: !1,
							cropBoxMovable: !1,
							cropBoxResizable: !1
						}), c.find(".js-submit").on("click", function() {
							var a = d.cropper("getData"),
								b = g.getImageSize().width / h.file._info.width;
							a.scale = b, h.file._cropData = {
								x: a.x,
								y: a.y,
								width: a.width,
								height: a.height,
								scale: a.scale
							}, h.upload()
						}), c.find(".js-cancel").one("click", function() {
							c.remove(), h.reset()
						}), b.loading().close(), this
					},
					getImageSize: function() {
						var a = d.get(0);
						return {
							width: a.naturalWidth,
							height: a.naturalHeight
						}
					},
					reset: function() {
						return $(".js-avatar-preview").remove(), h.reset(), this
					}
				}
			}()
		})
	}, b.map = function(a, c) {
		require(["map"], function(d) {
			function e(a) {
				g.getPoint(a, function(a) {
					map.panTo(a), marker.setPosition(a), marker.setAnimation(BMAP_ANIMATION_BOUNCE), setTimeout(function() {
						marker.setAnimation(null)
					}, 3600)
				})
			}
			a || (a = {}), a.lng || (a.lng = 116.403851), a.lat || (a.lat = 39.915177);
			var f = new d.Point(a.lng, a.lat),
				g = new d.Geocoder,
				h = $("#map-dialog");
			if (0 == h.length) {
				var i = '<div class="form-group"><div class="input-group"><input type="text" class="form-control" placeholder="请输入地址来直接查找相关位置"><div class="input-group-btn"><button class="btn btn-default"><i class="icon-search"></i> 搜索</button></div></div></div><div id="map-container" style="height:400px;"></div>',
					j = '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="button" class="btn btn-primary">确认</button>';
				h = b.dialog("请选择地点", i, j, {
					containerName: "map-dialog"
				}), h.find(".modal-dialog").css("width", "80%"), h.modal({
					keyboard: !1
				}), map = b.map.instance = new d.Map("map-container"), map.centerAndZoom(f, 12), map.enableScrollWheelZoom(), map.enableDragging(), map.enableContinuousZoom(), map.addControl(new d.NavigationControl), map.addControl(new d.OverviewMapControl), marker = b.map.marker = new d.Marker(f), marker.setLabel(new d.Label("请您移动此标记，选择您的坐标！", {
					offset: new d.Size(10, -20)
				})), map.addOverlay(marker), marker.enableDragging(), marker.addEventListener("dragend", function(a) {
					var b = marker.getPosition();
					g.getLocation(b, function(a) {
						h.find(".input-group :text").val(a.address)
					})
				}), h.find(".input-group :text").keydown(function(a) {
					if (13 == a.keyCode) {
						var b = $(this).val();
						e(b)
					}
				}), h.find(".input-group button").click(function() {
					var a = $(this).parent().prev().val();
					e(a)
				})
			}
			h.off("shown.bs.modal"), h.on("shown.bs.modal", function() {
				marker.setPosition(f), map.panTo(marker.getPosition())
			}), h.find("button.btn-primary").off("click"), h.find("button.btn-primary").on("click", function() {
				if ($.isFunction(c)) {
					var a = b.map.marker.getPosition();
					g.getLocation(a, function(b) {
						var d = {
							lng: a.lng,
							lat: a.lat,
							label: b.address
						};
						c(d)
					})
				}
				h.modal("hide")
			}), h.modal("show")
		})
	}, b.toast = function(a, b, c) {
		if (c && "success" != c) {
			if ("error" == c) var d = mui.toast('<div class="mui-toast-icon"><span class="fa fa-exclamation-circle"></span></div>' + a)
		} else var d = mui.toast('<div class="mui-toast-icon"><span class="fa fa-check"></span></div>' + a);
		if (b) var e = 3,
			f = setInterval(function() {
				return 0 >= e ? (clearInterval(f), void(location.href = b)) : void e--
			}, 1e3);
		return d
	}, b.loading = function(a) {
		var a = a ? a : "show",
			b = {},
			c = $(".js-toast-loading");
		if (c.size() <= 0) var c = $('<div class="mui-toast-container mui-active js-toast-loading"><div class="mui-toast-message"><div class="mui-toast-icon"><span class="fa fa-spinner fa-spin"></span></div>加载中</div></div>');
		return b.show = function() {
			document.body.appendChild(c[0])
		}, b.close = function() {
			c.remove()
		}, b.hide = function() {
			c.remove()
		}, "show" == a ? b.show() : "close" == a && b.close(), b
	}, b.message = function(b, c, d, e) {
		var f = $("<div>" + a.util.templates["message.html"] + "</div>");
		if (f.attr("class", "mui-content fadeInUpBig animated " + mui.className("backdrop")), f.on(mui.EVENT_MOVE, mui.preventDefault), f.css("background-color", "#efeff4"), e && f.find(".mui-desc").html(e), c) {
			var g = c.replace("##auto");
			if (f.find(".mui-btn-success").attr("href", g), c.indexOf("##auto") > -1) var h = 5,
				i = setInterval(function() {
					return 0 >= h ? (clearInterval(i), void(location.href = g)) : (f.find(".mui-btn-success").html(h + "秒后自动跳转"), void h--)
				}, 1e3)
		}
		f.find(".mui-btn-success").click(function() {
			if (c) {
				var a = c.replace("##auto");
				location.href = a
			} else history.go(-1)
		}), d && "success" != d ? (d = "error") && (f.find(".title").html(b), f.find(".mui-message-icon span").attr("class", "mui-msg-error")) : (f.find(".title").html(b), f.find(".mui-message-icon span").attr("class", "mui-msg-success")), document.body.appendChild(f[0])
	}, b.alert = function(a, b, c, d) {
		return mui.alert(a, b, c, d)
	}, b.confirm = function(a, b, c, d) {
		return mui.confirm(a, b, c, d)
	}, b.poppicker = function(a, b) {
		require(["mui.datepicker"], function() {
			mui.ready(function() {
				var c = new mui.PopPicker({
					layer: a.layer || 1
				});
				c.setData(a.data), c.show(function(a) {
					$.isFunction(b) && b(a), c.dispose()
				})
			})
		})
	}, b.districtpicker = function(a) {
		require(["mui.districtpicker"], function(c) {
			mui.ready(function() {
				var d = {
					layer: 3,
					data: c
				};
				b.poppicker(d, a)
			})
		})
	}, b.datepicker = function(a, b) {
		require(["mui.datepicker"], function() {
			mui.ready(function() {
				var c;
				c = new mui.DtPicker(a), c.show(function(a) {
					$.isFunction(b) && b(a), c.dispose()
				})
			})
		})
	}, b.querystring = function(a) {
		var b = location.search.match(new RegExp("[?&]" + a + "=([^&]+)", "i"));
		return null == b || b.length < 1 ? "" : b[1]
	}, b.tomedia = function(b, c) {
		if (!b) return "";
		if (0 == b.indexOf("./addons")) return a.sysinfo.siteroot + b.replace("./", ""); - 1 != b.indexOf(a.sysinfo.siteroot) && -1 == b.indexOf("/addons/") && (b = b.substr(b.indexOf("images/"))), 0 == b.indexOf("./resource") && (b = "app/" + b.substr(2));
		var d = b.toLowerCase();
		return -1 != d.indexOf("http://") || -1 != d.indexOf("https://") ? b : b = c || !a.sysinfo.attachurl_remote ? a.sysinfo.attachurl_local + b : a.sysinfo.attachurl_remote + b
	}, b.sendCode = function(b, c) {
		var d = {
			btnElement: "",
			showElement: "",
			showTips: "%s秒后重新获取",
			btnTips: "重新获取验证码",
			successCallback: arguments[3]
		};
		if ("object" != typeof arguments[1]) {
			var e = b,
				b = c;
			c = {
				btnElement: $(e),
				showElement: $(e),
				showTips: "%s秒后重新获取",
				btnTips: "重新获取验证码",
				successCallback: arguments[2]
			}
		} else c = $.extend({}, d, c);
		if (!b) return c.successCallback("1", "请填写正确的手机号");
		if (!/^1[3|4|5|7|8][0-9]{9}$/.test(b)) return c.successCallback("1", "手机格式错误");
		var f = 60;
		c.showElement.html(c.showTips.replace("%s", f)), c.showElement.attr("disabled", !0);
		var g = setInterval(function() {
			f--, 0 >= f ? (clearInterval(g), f = 60, c.showElement.html(c.btnTips), c.showElement.attr("disabled", !1)) : c.showElement.html(c.showTips.replace("%s", f))
		}, 1e3),
			h = {};
		h.receiver = b, h.uniacid = a.sysinfo.uniacid, $.post("../web/index.php?c=utility&a=verifycode", h).success(function(a) {
			return "success" == a ? c.successCallback("0", "验证码发送成功") : c.successCallback("1", a)
		})
	}, b.loading1 = function() {
		var a = "modal-loading",
			b = $("#" + a);
		return 0 == b.length && ($(document.body).append('<div id="' + a + '" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>'), b = $("#" + a), html = '<div class="modal-dialog">	<div style="text-align:center; background-color: transparent;">		<img style="width:48px; height:48px; margin-top:100px;" src="../attachment/images/global/loading.gif" title="正在努力加载...">	</div></div>', b.html(html)), b.modal("show"), b.next().css("z-index", 999999), b
	}, b.loaded1 = function() {
		var a = "modal-loading",
			b = $("#" + a);
		b.length > 0 && b.modal("hide")
	}, b.cookie = {
		prefix: "",
		set: function(a, b, c) {
			expires = new Date, expires.setTime(expires.getTime() + 1e3 * c), document.cookie = this.name(a) + "=" + escape(b) + "; expires=" + expires.toGMTString() + "; path=/"
		},
		get: function(a) {
			for (cookie_name = this.name(a) + "=", cookie_length = document.cookie.length, cookie_begin = 0; cookie_begin < cookie_length;) {
				if (value_begin = cookie_begin + cookie_name.length, document.cookie.substring(cookie_begin, value_begin) == cookie_name) {
					var b = document.cookie.indexOf(";", value_begin);
					return -1 == b && (b = cookie_length), unescape(document.cookie.substring(value_begin, b))
				}
				if (cookie_begin = document.cookie.indexOf(" ", cookie_begin) + 1, 0 == cookie_begin) break
			}
			return null
		},
		del: function(a) {
			new Date;
			document.cookie = this.name(a) + "=; expires=Thu, 01-Jan-70 00:00:01 GMT; path=/"
		},
		name: function(a) {
			return this.prefix + a
		}
	}, b.agent = function() {
		var a = navigator.userAgent,
			b = a.indexOf("Android") > -1 || a.indexOf("Linux") > -1,
			c = !! a.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
		return b ? "android" : c ? "ios" : "unknown"
	}, b.removeHTMLTag = function(a) {
		return "string" == typeof a ? (a = a.replace(/<script[^>]*?>[\s\S]*?<\/script>/g, ""), a = a.replace(/<style[^>]*?>[\s\S]*?<\/style>/g, ""), a = a.replace(/<\/?[^>]*>/g, ""), a = a.replace(/\s+/g, ""), a = a.replace(/&nbsp;/gi, "")) : void 0
	}, b.pay = function(c) {
		var d = {
			enabledMethod: [],
			defaultMethod: "wechat",
			orderTitle: "",
			orderTid: ""
		},
			e = mui.className("active"),
			f = mui.className("backdrop"),
			g = $("#pay-detail-modal").size() > 0 ? $("#pay-detail-modal") : $('<div class="mui-modal ' + e + ' js-pay-detail-modal" id="pay-detail-modal"></div>'),
			h = function(a) {
				a ? ($(".mui-content")[0].setAttribute("style", "overflow:hidden;"), document.body.setAttribute("style", "overflow:hidden;")) : ($(".mui-content")[0].setAttribute("style", ""), document.body.setAttribute("style", ""))
			},
			i = function() {
				var a = document.createElement("div");
				return a.classList.add(f), a.addEventListener(mui.EVENT_MOVE, mui.preventDefault), a.addEventListener("click", function(a) {
					return g ? (g.remove(), $(i).remove(), document.body.setAttribute("style", ""), !1) : void 0
				}), a
			}(),
			j = function(a) {
				"main" == a ? (g.find(".js-main-modal").show().addClass("fadeInRight animated"), g.find(".js-switch-pay-modal").hide(), g.find(".js-switch-modal").hide()) : "pay" == a && (g.find(".js-main-modal").hide(), g.find(".js-switch-pay-modal").show().addClass("fadeInRight animated"), g.find(".js-switch-modal").show())
			};
		return c = $.extend({}, d, c), !c.orderFee || c.orderFee <= 0 ? void b.toast("请确认支付金额", "", "error") : (b.loading().show(), $.get("index.php?i=" + a.sysinfo.uniacid + "&j=" + a.sysinfo.acid + "&c=entry&m=core&do=pay", function(a) {
			if (b.loading().hide(), g.html(a), i.setAttribute("style", ""), $(document.body).append(g), $(document.body).append(i), h(!0), g.find(".js-switch-modal").click(function() {
				j("main")
			}), g.find(".js-switch-pay").click(function() {
				j("pay")
			}), g.find(".js-order-title").html(c.orderTitle), g.find(".js-pay-fee").html(c.orderFee), !(g.find(".js-switch-pay-modal li").size() > 0)) return b.toast("暂无有效支付方式"), g.remove(), $(i).remove(), document.body.setAttribute("style", ""), !1;
			if (c.enabledMethod && c.enabledMethod.length > 0 ? g.find(".js-switch-pay-modal li").each(function() {
				-1 == $.inArray($(this).data("method"), c.enabledMethod) && $(this).hide()
			}) : g.find(".js-switch-pay-modal li").each(function() {
				c.enabledMethod.push($(this).data("method"))
			}), c.defaultMethod && $.inArray(c.defaultMethod, c.enabledMethod) > -1) var d = g.find(".js-switch-pay-modal li[data-method=" + c.defaultMethod + "]");
			else var d = $(g.find(".js-switch-pay-modal li:first"));
			g.find(".js-pay-default-method").html(d.data("title"))
		}), !1)
	}, b.card = function() {
		$.post("./index.php?c=utility&a=card", {
			uniacid: a.sysinfo.uniacid,
			acid: a.sysinfo.acid
		}, function(c) {
			b.loading().hide();
			var c = $.parseJSON(c);
			return 0 == c.message.errno ? (b.message("没有开通会员卡功能", "", "info"), !1) : (1 == c.message.errno && wx.ready(function() {
				wx.openCard({
					cardList: [{
						cardId: c.message.message.card_id,
						code: c.message.message.code
					}]
				})
			}), 2 == c.message.errno && (location.href = "./index.php?i=" + a.sysinfo.uniacid + "&c=mc&a=card&do=mycard"), void(3 == c.message.errno && (alert("由于会员卡升级到微信官方会员卡，需要您重新领取并激活会员卡"), wx.ready(function() {
				wx.addCard({
					cardList: [{
						cardId: c.message.message.card_id,
						cardExt: c.message.message.card_ext
					}],
					success: function(a) {}
				})
			}))))
		})
	}, "function" == typeof define && define.amd ? define(function() {
		return b
	}) : a.util = b
}(window), function(a, b) {
	a["avatar.preview.html"] = '<div class="fadeInDownBig animated js-avatar-preview avatar-preview" style="position:relative; width:100%;z-index:9999"><img src="" alt="" class="cropper-hidden"><div class="bar-action mui-clearfix"><a href="javascript:;" class="mui-pull-left js-cancel">取消</a> <a href="javascript:;" class="mui-pull-right mui-text-right js-submit">选取</a></div></div>', a["image.preview.html"] = '<div class="bar-action mui-clearfix"><a href="javascript:;" class="mui-pull-left js-cancel">取消</a> <a href="javascript:;" class="mui-pull-right mui-text-right js-submit">删除</a></div>', a["message.html"] = '<div class="mui-content-padded"><div class="mui-message"><div class="mui-message-icon"><span></span></div><h4 class="title"></h4><p class="mui-desc"></p><div class="mui-button-area"><a href="javascript:;" class="mui-btn mui-btn-success mui-btn-block">确定</a></div></div></div>'
}(this.window.util.templates = this.window.util.templates || {});