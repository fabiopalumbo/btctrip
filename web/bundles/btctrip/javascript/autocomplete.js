/*!
FRAMEWORK_VERSION:1.1.197
*/
registerNameSpace("Nibbler.Autocomplete.js");~

function (a) {
    function b(c) {
        this.options = {
            template: "script#autocomplete-tpl",
            element: null,
            url: null,
            type: null,
            minChars: 3,
            maxChars: 75,
            keyDelay: 100,
            cache: null,
            storeCache: false,
            customVal: c.type == b.Flights,
            initial: {
                place: null,
                code: null,
                facet: "c"
            },
            classes: {
                empty: "msg-empty",
                blank: "msg-blank",
                error: "msg-error",
                loading: "msg-loading",
                list: "list",
                active: "active",
                maxChars: "msg-max-chars"
            },
            onSelect: jQuery.noop
        };
        this.options = jQuery.extend(true, this.options, c);
        this.element = jQuery(this.options.element);
        this.wrapper = jQuery.tmpl(jQuery(this.options.template)).insertAfter(this.element);
        this.current = -1;
        this.active = {
            place: null,
            code: null,
            facet: null
        };
        this.timer = null;
        this.count = 0;
        this.activity = {
            delay: 1000,
            timeout: null
        };
        this.setup()
    }
    b.prototype = {
        getPlace: function () {
            return this.active.place || this.element.val()
        },
        getCode: function () {
            return this.active.code
        },
        getFacet: function () {
            return this.active.facet
        },
        setup: function () {
            var c = a.Cache;
            this.cache = {
                result: new c(this.options.storeCache).space("result", this.options.cache),
                regexp: new c().space("regexp"),
                render: new c().space("render", this.wrapper.prop(jQuery.expando))
            };
            this.element.data("autocomplete", this);
            this.element.attr("maxlength", this.options.maxChars);
            this.bind();
            this.fill(this.options.initial);
            this.adopt(this.options.classes.empty)
        },
        show: function () {
            this.wrapper.fadeIn(250);
            this.mousedown()
        },
        hide: function () {
            if (this.options.customVal && this.element.val() != this.active.place) {
                this.active.place = this.element.val();
                this.active.code = null;
                this.active.facet = null
            }
            this.wrapper.fadeOut(250)
        },
        adopt: function (e) {
            this.stopActivity();
            var d = this.options.classes,
                c = "";
            jQuery.each(d, function (f, g) {
                c += g + " "
            });
            this.wrapper.removeClass(c).addClass(e);
            if (d.blank == e) {
                this.wrapper.find("." + d.blank + " span").text(this.element.val())
            }
        },
        filter: function (e) {
            this.show();
            this.count++;
            clearTimeout(this.timer);
            if (e.length < this.options.minChars) {
                return this.adopt(this.options.classes.empty)
            } else {
                if (e.length > this.options.maxChars) {
                    return this.adopt(this.options.classes.maxChars)
                }
            }
            this.cacheRegexp(e);
            if (this.cache.result.has(e)) {
                return this.render(this.cache.result.get(e), e)
            }
            var d = this;
            var c = function () {
                d.fetch(e, d.count)
            };
            this.timer = setTimeout(c, this.options.keyDelay)
        },
        fetch: function (e, c) {
            var d = {
                dataType: "json",
                url: this.options.url,
                context: this,
                cache: false,
                data: {
                    product: this.options.type,
                    query: e
                }
            };
            this.startActivity();
            jQuery.ajax(d).always(this.stopActivity).fail(this.error).done(function (g) {
                var f = this.cache.result.set(e, g ? g.data : []);
                if (!f.length) {
                    this.cache.result.del(e)
                }
                if (this.count == c) {
                    this.render(f, e)
                }
            })
        },
        cacheRegexp: function (e) {
            var f = this.strChars(this.strClean(e)).split(" ");
            var h = [" ", ".", ",", "-", "(", "[", "{", "/"];
            var g = [];
            for (var c = 0; c < f.length; c++) {
                if (!f[c]) {
                    continue
                }
                var d = this.cache.regexp.get(f[c], function () {
                    return new RegExp("(?:^|(\\" + h.join("|\\") + "))(" + f[c] + ")+", "ig")
                });
                g.push(d)
            }
            g.sort(function (j, i) {
                return i.toString().length - j.toString().length
            });
            this.cache.regexp.set(":" + e, g)
        },
        render: function (m, g) {
            if (!m.length) {
                return this.adopt(this.options.classes.blank)
            }
            this.adopt(this.options.classes.list);
            var e = this.wrapper.find("> ul");
            e.find("> li").hide();
            for (var d = 0; d < m.length; d++) {
                var j = this.createGroup(m[d]);
                var c = j.find("ul");
                c.find("> li").removeClass(this.options.classes.active).addClass("hidden").removeClass("first");
                var f = m[d].items;
                for (var h = 0; h < f.length; h++) {
                    f[h].facet = m[d].type;
                    var l = this.createItem(f[h]);
                    var k = this.highlight(f[h].place, this.cache.regexp.get(":" + g));
                    c.append(l.find("a").html(k).end().removeClass("hidden"));
                    if (h == 0) {
                        l.addClass("first")
                    }
                }
                e.append(j.show())
            }
            this.wrapper.find("ul ul li:eq(" + this.current + ")").removeClass(this.options.classes.active);
            this.wrapper.find("ul ul li:visible:first").addClass(this.options.classes.active);
            this.current = 0
        },
        createGroup: function (d) {
            var c = this.cache.render.get(d.type + d.name, function () {
                return $('<li><span class="title-' + d.type + '">' + d.name + "</span><ul></ul></li>")
            });
            return c
        },
        createItem: function (d) {
            var c = this.cache.render.get(d.code + d.place, function () {
                return $("<li><a>" + d.place + "</a></li>").data("item", d)
            });
            return c
        },
        highlight: function (e, d) {
            for (var c = 0; c < d.length; c++) {
                e = e.replace(d[c], function (g, f, j, h) {
                    if (e.charAt(--h) != "<") {
                        return (f || "") + "<span>" + j + "</span>"
                    }
                    return g
                })
            }
            return e
        },
        navigate: function (e) {
            var c = this.wrapper.find("ul ul li:visible");
            if (e == "up") {
                var d = this.current - 1
            } else {
                var d = this.current + 1
            } if (d < 0) {
                d = c.length - 1
            }
            if (d > c.length - 1) {
                d = 0
            }
            c.eq(this.current).removeClass(this.options.classes.active);
            c.eq(this.current = d).addClass(this.options.classes.active)
        },
        select: function (d) {
            if (!d) {
                if (this.current == -1) {
                    var c = this.wrapper.find("ul ul li:visible:first").removeClass(this.options.classes.active)
                } else {
                    var c = this.wrapper.find("ul ul li:visible:eq(" + this.current + ")").removeClass(this.options.classes.active)
                }
                d = c.data("item")
            }
            if (d) {
                if (false !== this.options.onSelect.call(this, d)) {
                    this.fill(d)
                }
            }
            this.hide()
        },
        fill: function (c) {
            this.active = {
                place: c.place,
                code: c.code,
                facet: c.facet
            };
            this.element.val(c.place)
        },
        error: function (c) {
            this.adopt(this.options.classes.error)
        },
        startActivity: function () {
            if (!this.activity.timeout) {
                var d = this;
                var c = this.options.classes;
                this.activity.timeout = setTimeout(function () {
                    if (!d.wrapper.hasClass(c.list)) {
                        d.adopt(c.loading);
                        d.wrapper.find("." + c.loading + " span").text(d.element.val())
                    }
                }, this.activity.delay)
            }
        },
        stopActivity: function () {
            clearTimeout(this.activity.timeout);
            this.activity.timeout = null
        },
        bind: function () {
            this.element.on({
                click: jQuery.proxy(this.focus, this),
                blur: jQuery.proxy(this.blur, this),
                keyup: jQuery.proxy(this.keyup, this),
                keydown: jQuery.proxy(this.keydown, this)
            });
            this.wrapper.on({
                click: jQuery.proxy(this.click, this),
                mouseenter: jQuery.proxy(this.mouseenter, this),
                mouseleave: jQuery.proxy(this.mouseleave, this)
            }, "ul li ul li");
            this.wrapper.on("click", jQuery.proxy(function () {
                this.element.focus()
            }, this))
        },
        click: function (c) {
            this.select($(c.target).data("item"))
        },
        mouseenter: function (c) {
            this.wrapper.find("ul ul li." + this.options.classes.active).removeClass(this.options.classes.active);
            var e = $(c.currentTarget).addClass(this.options.classes.active),
                d;
            this.wrapper.find("ul ul li:visible").each(function (f) {
                if (e.is(this)) {
                    d = f;
                    return false
                }
            });
            this.current = d
        },
        mouseleave: function (c) {
            $(c.currentTarget).removeClass(this.options.classes.active);
            this.current = -1
        },
        focus: function (c) {
            this.element.focus();
            this.element.select()
        },
        blur: function (c) {
            if (null != this.active.place) {
                this.element.val(this.active.place)
            }
        },
        keyup: function (c) {
            if ((c.keyCode >= 37 && c.keyCode <= 40) || c.keyCode == 9 || c.keyCode == 13 || c.keyCode == 16 || c.keyCode == 27) {
                return true
            }
            this.filter(this.strClean(this.element.val().toLowerCase()))
        },
        keydown: function (c) {
            if (c.keyCode == 9 || c.keyCode == 13) {
                this.select()
            }
            if (c.keyCode == 27) {
                this.hide()
            }
            if (c.keyCode == 38 || c.keyCode == 40) {
                this.navigate(c.keyCode == 38 ? "up" : "down");
                return false
            }
        },
        mousedown: function () {
            $(document).one("mousedown", $.proxy(function (c) {
                var d = $(c.target);
                if (d.is(this.element) || d.is(this.wrapper) || d.parents("." + this.wrapper.attr("class").replace(/\s/g, ".")).length > 0) {
                    this.mousedown()
                } else {
                    this.hide()
                }
            }, this))
        },
        strClean: function (c) {
            return c.replace(/([.,:;@!~_=<>`#"\'?*%+^$[\]\/\\(){}|-])/g, " ").replace(/\s+/g, " ").replace(/^\s+|\s+$/g, "")
        },
        strChars: function (e) {
            var c = ["\u0061\u00E0\u00E1\u00E2\u00E3\u00E4\u00E5", "\u0065\u00E8\u00E9\u00EA\u00EB", "\u0069\u00EC\u00ED\u00EE\u00EF", "\u006F\u00F2\u00F3\u00F4\u00F5\u00F6", "\u0075\u00F9\u00FA\u00FB\u00FC", "\u006E\u00F1", "\u0060\u0027\u00B4"];
            for (var d = 0; d < c.length; d++) {
                e = e.replace(new RegExp("[" + c[d] + "]", "ig"), "[" + c[d] + "]")
            }
            return e
        }
    };
    b.Hotels = "hotels";
    b.Flights = "flights";
    b.Cars = "cars";
    b.Packages = "packages";
    b.Cruises = "cruises";
    b.FlightsHotels = "flightshotels";
    a.Autocomplete = b.prototype.constructor = b
}(Nibbler.Autocomplete.js);
registerNameSpace("Nibbler.Autocomplete.js");~

function (a) {
    function b(c) {
        this.store = c;
        this.prefix = "nibbler.autocomplete.cache."
    }
    b.prototype = {
        data: {},
        set: function (e, c, d) {
            this.data[e][c] = d;
            if (this.store && amplify) {
                amplify.store(this.prefix + e, this.data[e])
            }
            return d
        },
        has: function (d, c) {
            return c in this.data[d]
        },
        get: function (e, d, c) {
            if (this.has(e, d)) {
                return this.data[e][d]
            }
            if (c) {
                return this.set(e, d, c(d))
            }
        },
        del: function (d, c) {
            if (this.has(d, c)) {
                return delete this.data[d][c]
            }
        },
        space: function (d, g) {
            var f = g ? d + "." + g : d;
            if (!(f in this.data)) {
                this.data[f] = {}
            }
            if (this.store && amplify) {
                var c = amplify.store(this.prefix + f);
                if (c) {
                    this.data[f] = c
                }
            }
            var e = this;
            return {
                set: function (h, i) {
                    return e.set(f, h, i)
                },
                has: function (h) {
                    return e.has(f, h)
                },
                get: function (i, h) {
                    return e.get(f, i, h)
                },
                del: function (h) {
                    return e.del(f, h)
                }
            }
        }
    };
    a.Cache = b.prototype.constructor = b
}(Nibbler.Autocomplete.js);