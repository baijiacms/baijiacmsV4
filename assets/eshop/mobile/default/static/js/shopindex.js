	$.supports = (function () {
    return {
        touch: !!(('ontouchstart' in window) || window.DocumentTouch && document instanceof window.DocumentTouch)
    };
})();
$.touchEvents = {
    start: $.supports.touch ? 'touchstart' : 'mousedown',
    move: $.supports.touch ? 'touchmove' : 'mousemove',
    end: $.supports.touch ? 'touchend' : 'mouseup'
};

function _bindCssEvent(events, callback) {
    var dom = this;
    function fireCallBack(e) {

        if (e.target !== this) {
            return;
        }
        callback.call(this, e);
        for (var i = 0; i < events.length; i++) {
            dom.off(events[i], fireCallBack);
        }
    }
    if (callback) {
        for (var i = 0; i < events.length; i++) {
            dom.on(events[i], fireCallBack);
        }
    }
}
$.fn.animationEnd = function (callback) {

    _bindCssEvent.call(this, ['webkitAnimationEnd', 'animationend'], callback);
    return this;
};
$.fn.transitionEnd = function (callback) {
    _bindCssEvent.call(this, ['webkitTransitionEnd', 'transitionend'], callback);
    return this;
};
$.fn.transition = function (duration) {
    if (typeof duration !== 'string') {
        duration = duration + 'ms';
    }
    for (var i = 0; i < this.length; i++) {
        var elStyle = this[i].style;
        elStyle.webkitTransitionDuration = elStyle.MozTransitionDuration = elStyle.transitionDuration = duration;
    }
    return this;
};
$.fn.transform = function (transform) {
    for (var i = 0; i < this.length; i++) {
        var elStyle = this[i].style;
        elStyle.webkitTransform = elStyle.MozTransform = elStyle.transform = transform;
    }
    return this;
};
       function FoxUISwipe(swipe, params) {
        var defaults = {
            transition: 300,
            speed: 3000,
            gap: 0,
            touch: true,
            placeholder: "data:image/gif;base64,R0lGODlhAQABAIAAAOXl5QAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
        };
        var self = this;
        swipe = $(swipe);
        self.params = $.extend({}, defaults, params || {});
        self.wrapper = swipe.find('.fui-swipe-wrapper');
        self.items = self.wrapper.find('.fui-swipe-item');
        self.page = swipe.find('.fui-swipe-page');
        self.bullets = self.page.find('.fui-swipe-bullet');
        self.buttons = swipe.find('.fui-swipe-button');
        self.params.speed = swipe.data('speed') || self.params.speed;
        self.params.transition = swipe.data('transition') || self.params.transition;
        self.params.gap = swipe.data('gap') || self.params.gap;
        self.params.touch = swipe.data('touch') || self.params.touch;
        if (self.items.length < 2) {
            return;
        }
        var allowItemClick = true;


        self.interval = 0;
        self.width = swipe.width(); //anjey

        self.setBullet = function () {

            var bullet = $(self.bullets[self.activeIndex]);
            if (bullet.length > 0) {
                self.page.find('.active').removeClass('active');
                bullet.addClass('active');
            }

        };
        self.slide = function (activeIndex, transition) {

            self.items.each(function (index, item) {
                if (index == activeIndex)
                {
                    var data_lazy = $(this).children('img').get(0).getAttribute('data-lazy');
                    if (data_lazy !== null)
                    {
                        $(this).children('img').get(0).setAttribute('src', data_lazy);
                        $(this).children('img').get(0).setAttribute('data-lazyloaded', 'true');
                        $(this).children('img').get(0).removeAttribute('data-lazy');
                    }
                }
            });
            self.activeIndex = activeIndex;
            self.setBullet();
            if (self.params.onStart) {
                self.params.onStart(self);
            }
            transition = transition || self.params.transition;

            var num = -(activeIndex * self.width);

            if (self.params.gap) {

                num -= self.params.gap * (activeIndex - 1) + self.params.gap;

            }
            var transform = 'translate3d(' + num + 'px,0,0)';

            self.wrapper.transition(transition).transform(transform).transitionEnd(function (e) {

                if (self.params.speed) {
                    self.begin();
                }
                allowItemClick = true;
                if (self.params.onChange) {
                    self.params.onChange(self);
                }
            });

        };
        self.prev = function () {

            clearTimeout(self.interval);

            self.activeIndex--;
            if (self.activeIndex < 0) {
                self.activeIndex = 0;
            }
            self.slide(self.activeIndex);

        };
        self.next = function (delay) {

            clearTimeout(this.interval);
            self.activeIndex++;
            if (self.activeIndex > self.items.length - 1) {
                self.activeIndex = 0;
            }
            self.slide(self.activeIndex);

        };

        self.begin = function () {
            if (self.params.speed) {

                self.interval = setTimeout(function () {
                    self.next();
                }, self.params.speed);
            }
        };
        var isTouched, isMoved;
        var onTouchStart = function (e) {
            if (isTouched) {
                return;
            }


            self.start = {
                pageX: e.type === 'touchstart' ? e.originalEvent.targetTouches[0].pageX : e.pageX,
                pageY: e.type === 'touchstart' ? e.originalEvent.targetTouches[0].pageY : e.pageY,
                time: Number(new Date())
            };

            self.isScrolling = undefined;
            self.deltaX = 0;
            self.wrapper.transition(0);

            isTouched = true;
            allowItemClick = true;


        };
        var onTouchMove = function (e) {
            if (!isTouched) {
                return;
            }
            allowItemClick = false;
            var pageX = e.type === 'touchmove' ? e.originalEvent.targetTouches[0].pageX : e.pageX;
            var pageY = e.type === 'touchmove' ? e.originalEvent.targetTouches[0].pageY : e.pageY;
            self.deltaX = pageX - self.start.pageX;

            if (self.isScrolling === undefined) {
                self.isScrolling = !!(self.isScrolling || Math.abs(self.deltaX) < Math.abs(pageY - self.start.pageY));
            }

            if (self.isScrolling) {
                isTouched = false;
                return;
            }
            e.preventDefault();
            allowItemClick = false;
            clearTimeout(self.interval);
            self.deltaX =
                self.deltaX /
                ((!self.activeIndex && self.deltaX > 0 || self.activeIndex == self.items.length - 1 && self.deltaX < 0) ?
                    (Math.abs(self.deltaX) / self.width + 1) : 1);

            var transform = 'translate3d(' + (self.deltaX - self.activeIndex * self.width) + 'px,0,0)';
            self.wrapper.transform(transform);
        };
        var onTouchEnd = function (e) {
            if (!isTouched) {
                isTouched = false;
                return;
            }
            isTouched = false;
            var isValidSlide =
                    Number(new Date()) - self.start.time < 250 && Math.abs(self.deltaX) > 20 || Math.abs(self.deltaX) > self.width / 2,
                isPastBounds = !self.activeIndex && self.deltaX > 0 || self.activeIndex == self.items.length - 1 && self.deltaX < 0;
            if (!self.isScrolling) {
                self.slide(self.activeIndex + (isValidSlide && !isPastBounds ? (self.deltaX < 0 ? 1 : -1) : 0));
            }
        };

        var onItemClick = function (e) {
            if (!allowItemClick) {
                return;
            }
            var url = $(this).data('url') || '';
            if (url) {
                location.href = url;
            }
        };
        if (self.params.gap) {
            $.each(self.items, function () {
                $(this).css('margin-right', self.params.gap + 'px');
            });
        }
        var resizeSwipes = function () {
            self.width = $(document.body).width();
            $.each(self.items, function () {
                $(this).css('width', self.width + 'px');
            });
            self.slide(self.activeIndex, 0);
        };
        $(window).on('resize', resizeSwipes);

        self.init = function () {
            if (self.page.length > 0) {
                if (self.bullets.length <= 0) {
                    var bulletsHTML = '';
                    for (var i = 0; i < self.items.length; i++) {
                        bulletsHTML += '<div class="fui-swipe-bullet"></div>';
                    }
                    self.page.html(bulletsHTML);
                    self.bullets = self.page.find('.fui-swipe-bullet');
                }
                self.bullets.each(function (index) {
                    $(this).click(function () {
                        clearTimeout(self.interval);
                        self.activeIndex = index;
                        self.slide(self.activeIndex);
                    });

                });
            }
            self.buttons.each(function (i) {
                $(this).click(function () {

                    if ($(this).hasClass('left')) {
                        self.prev();
                    } else {
                        self.next();
                    }
                });
            });
        };
        self.init();
        self.slide(0, 0);
        self.begin();

        self.initEvents = function (detach) {
            var method = detach ? 'off' : 'on';
            self.wrapper[method]($.touchEvents.start, onTouchStart);
            self.wrapper[method]($.touchEvents.move, onTouchMove);
            self.wrapper[method]($.touchEvents.end, onTouchEnd);
            self.items[method]('click', onItemClick);
        };
        if (self.params.touch) {
            self.initEvents();
        }

    };
   function swipe() {
        var args = arguments;
        return $('.fui-swipe').each(function () {

            if (!$('.fui-swipe'))
                return;
            var $this = $('.fui-swipe');
            var swipe = $this.data("swipe");
            if (!swipe) {
                params =  {};
                swipe = new FoxUISwipe('.fui-swipe', params);
                $this.data("swipe", swipe);
            }
            if (typeof params === typeof "a") {
                swipe[params].apply(swipe, Array.prototype.slice.call(args, 1));
            }
        });
    };
$(function(){swipe();});