registerNameSpace("Nibbler.Searchbox.js");
Nibbler.Searchbox.js.Searchbox = function (a) {
    this.options = $.extend(true, {
        context: null,
        config: {
            currentDate: new Date,
            country: "US",
            locale: "en"
        },
        activations: {},
        boxes: []
    }, a);
    this.boxes = {};
    this.observer = new Nibbler.Searchbox.js.Searchbox.Observer;
    this.activator = new Nibbler.Searchbox.js.Searchbox.Activator;
    this.addBox = function (d) {
        if (!d.box) {
            throw "It can't be loaded '" + d.id + "'"
        }
        var c = {
            config: this.options.config,
            context: this.options.context.find(d.selector),
            product: d.product,
            id: d.id,
            activations: this.options.activations
        };
        var e = $.extend(true, c, d.options || {});
        var f = new d.box(e);
        f.setActivator(this.activator);
        f.setObserver(this.observer);
        f.setSearcher(new d.searcher(e));
        f.boot();
        this.boxes[d.product] = {
            init: d.init || false,
            box: f
        }
    };
    this.setBoxOptions = function (c) {
        for (var d in this.boxes) {
            if (d in c) {
                this.boxes[d].box.setOptions(c[d])
            }
        }
    };
    this.loadBoxOptions = function () {
        for (var c in this.boxes) {
            this.boxes[c].box.load()
        }
    };
    this.init = function () {
        if (this.options.context.is("form")) {
            this.options.context.get(0).reset()
        }
        for (var c in this.boxes) {
            if (this.boxes[c].init) {
                this.boxes[c].box.init();
                this.boxes[c].box.initialized = true;
                this.options.context.addClass(c);
          //      break
            }
        }
/*        if (this.options.boxes.length > 1) {
            new Nibbler.Searchbox.js.Searchbox.Module.Tabs({
                context: this.options.context
            })
        }  */
    };
    this.listen = function () {
        this.observer.listen.apply(this.observer, arguments)
    };
    this.notify = function () {
        this.observer.notify.apply(this.observer, arguments)
    };
    amplify.subscribe("module.tabs.change", this, function (c) {
        this.options.context.attr("class", "searchbox " + (/^tab-(.+)/.exec(c.attr("class"))[1]))
    });
    for (var b = 0; b < this.options.boxes.length; b++) {
        this.addBox(this.options.boxes[b])
    }
    if (!("hasNewAutocomplete" in Nibbler.Searchbox)) {
        Nibbler.Searchbox.hasNewAutocomplete = this.activator.raffle({
            chance: 50,
            item: 1
        }, {
            chance: 50,
            item: 0
        })
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox");
Nibbler.Searchbox.js.Searchbox.Activator = function () {
    this.unique = null;
    this.minRange = 0;
    this.maxRange = 4294967295;
    this.getRandom = function (b, a) {
        return Math.floor(Math.random() * (a - b + 1)) + b
    };
    this.getUnique = function () {
        if (null == this.unique) {
            var a = this.readCookie("trackerid");
            if (a) {
                this.unique = parseInt(a, 16)
            } else {
                this.unique = this.getRandom(this.minRange, this.maxRange)
            }
        }
        return this.unique
    };
    this.expose = function (a) {
        var b = this;
        return {
            getActivation: function (c) {
                return b.getActivation(c, a)
            }
        }
    };
    this.getActivation = function (c, b) {
        var a = this.getConfig(b.config.country, this.getConfig(b.product, this.getConfig(b.config.brand, b.activations)));
        if (c in a) {
            return a[c]
        }
    };
    this.raffle = function () {
        var d = this.getUnique();
        var f = 0;
        for (var c = 0, e = 0, a = arguments.length; c < a; c++) {
            e += arguments[c].chance
        }
        for (c = 0; c < a; c++) {
            var b = arguments[c].chance / e * this.maxRange;
            if (d >= f && d <= b + f) {
                return arguments[c].item
            }
            f += b
        }
        if ("console" in window) {
            console.log("Activator.raffle " + d + " fuera de rango")
        }
        return arguments[0].item
    };
    this.getConfig = function (c, b) {
        var a;
        if ("*" in b) {
            a = this.getConfigValue(b["*"])
        }
        if (c in b) {
            a = $.extend(true, {}, a, this.getConfigValue(b[c]))
        } else {
            for (var d in b) {
                if (-1 != jQuery.inArray(c, d.split(/,\s*/g))) {
                    a = $.extend(true, {}, a, this.getConfigValue(b[d]))
                }
            }
        }
        return a
    };
    this.getConfigValue = function (a) {
        if (jQuery.isPlainObject(a)) {
            return a
        }
        if (jQuery.isFunction(a)) {
            return a.call(this)
        }
    };
    this.readCookie = function (b) {
        var c = new RegExp("(^|; )" + encodeURIComponent(b) + "=([^;]*)"),
            a;
        if (a = c.exec(document.cookie)) {
            return a[2]
        }
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox");
Nibbler.Searchbox.js.Searchbox.Observer = function () {
    this.listeners = {};
    this.listen = function (b, a, c) {
        if (!this.listeners[b]) {
            this.listeners[b] = []
        }
        this.listeners[b].push({
            context: c ? a : null,
            callback: c ? c : a
        })
    };
    this.unlisten = function (b, c) {
        if (this.listeners[b]) {
            for (var a = 0; a < this.listeners[b].length; a++) {
                if (c === this.listeners[b][a].callback) {
                    this.listeners[b].slice(a)
                }
            }
        }
    };
    this.notify = function (b) {
        if (this.listeners[b]) {
            for (var a = 0; a < this.listeners[b].length; a++) {
                this.listeners[b][a].callback.apply(this.listeners[b][a].context, [].slice.call(arguments, 1))
            }
        }
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox");
Nibbler.Searchbox.js.Searchbox.Validator = function (b) {
    this.rules = b;
    this.validate = function () {
        var f = true,
            e, d;
        b: for (d in this.rules) {
            e = b[d];
            if (!("validated" in e)) {
                e.validated = null
            }
            if (false === e.validate) {
                continue
            }
            if (e.depends) {
                if ($.type(e.depends) == "string" && !this.rules[e.depends].validated) {
                    continue
                }
                if ($.type(e.depends) == "array") {
                    for (var c = 0; c < e.depends.length; c++) {
                        if (!this.rules[e.depends[c]].validated) {
                            continue b
                        }
                    }
                }
            }
            e.validated = e.callback.call(a, e.element);
            if (!e.validated) {
                f = e.validated = false
            }
        }
        this.check(this.rules);
        return f
    };
    this.check = function (c) {
        for (key in c) {
            if (true === c[key].validated || null === c[key].validated) {
                this.clean(key)
            }
        }
        for (key in c) {
            if (false === c[key].validated) {
                this.error(key)
            }
        }
        return this
    };
    this.error = function (c) {
        if (!(c in this.rules)) {
            return false
        }
        var d = this.rules[c];
        if (d.element) {
            $(d.element).addClass("error")
        }
        if (d.message) {
            $(d.message).removeClass("hidden")
        }
        return this
    };
    this.clean = function (c) {
        if (!(c in this.rules)) {
            return false
        }
        var d = this.rules[c];
        if (d.element) {
            $(d.element).removeClass("error")
        }
        if (d.message) {
            $(d.message).addClass("hidden")
        }
        return this
    };
    this.cleanOnFocus = function () {
        var d = this;
        for (var c in this.rules) {
            $(this.rules[c].element).data("validator.rules", false)
        }
        for (c in this.rules) {
            $(this.rules[c].element).each(function () {
                var e = $(this).data("validator.rules");
                if (!e) {
                    e = {}
                }
                e[c] = d.rules[c];
                var f = function () {
                    if (!$(this).hasClass("error")) {
                        return true
                    }
                    var h = $(this).data("validator.rules"),
                        g;
                    for (g in h) {
                        if (false === h[g].validated) {
                            d.clean(g)
                        }
                    }
                };
                $(this).data("validator.rules", e).off(".validation").on("focus.validation", f)
            })
        }
        return this
    };
    var a = {
        isEmpty: function (c) {
            return $.trim(c).length == 0
        },
        isNumber: function (c) {
            return !isNaN(c)
        },
        isDate: function (c, e) {
            var d = (e || "d/m/Y").replace(/[a-z]/ig, function (f) {
                switch (f) {
                    case "d":
                        return "(0?[1-9]|[12][0-9]|3[01])";
                    case "m":
                        return "(0?[1-9]|1[012])";
                    case "Y":
                        return "(\\d\\d\\d\\d)"
                }
            });
            if (new RegExp("^" + d + "$").test(c)) {
                return false != this.parseDate(c, e)
            }
            return false
        },
        parseDate: function (e, h) {
            if (e instanceof Date) {
                return e
            }
            var g = e.split(/\D+/g),
                h = (h || "d/m/Y").split(/\W+/g),
                k, c, j, f;
            for (f = 0; f < g.length; f++) {
                switch (h[f]) {
                    case "d":
                        k = parseInt(g[f], 10);
                        break;
                    case "m":
                        c = parseInt(g[f], 10) - 1;
                        break;
                    case "Y":
                        if (g[f].toString().length == 2) {
                            g[f] = 20 + "" + g[f]
                        }
                        j = parseInt(g[f], 10);
                        break
                }
            }
            var e = new Date(j, c, k, 12);
            if (e.getFullYear() == j && e.getMonth() == c && e.getDate() == k) {
                return e
            }
            return false
        },
        dateDiff: function (e, c, d) {
            return (+this.parseDate(c, d) - +this.parseDate(e, d)) / (1000 * 60 * 60 * 24)
        }
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox");
Nibbler.Searchbox.js.Searchbox.Box = function (a) {
    this.options = a;
    this.searcher = null;
    this.storable = {
        _expires: false
    };
    this.activator = null;
    this.observer = null;
    this.modules = {};
    this.setOptions = function (b) {
        this.options = $.extend(true, this.options || {}, b)
    };
    this.setSearcher = function (b) {
        this.searcher = b
    };
    this.setActivator = function (b) {
        this.activator = b.expose(this.options)
    };
    this.setObserver = function (b) {
        this.observer = b
    };
    this.init = function () {};
    this.exclude = function () {};
    this.search = function (c) {
        var b = this.activator.getActivation("searcher");
        if (b) {
            this.searcher = new b
        }
        this.searcher.setOptions(this.options);
        this.searcher.search(c)
    };
    this.addModule = function (d) {
        if (!d.module) {
            throw "No se puede cargar el modulo '" + d.name + "' en la caja '" + this.options.id + "'"
        }
        var c = {
            context: d.selector ? this.options.context.find(d.selector) : this.options.context,
            name: d.name,
            product: this.options.product,
            id: this.options.id
        };
        this.storable[d.name] = false !== d.store;
        var b = new d.module($.extend(true, c, this.options.config, d.options || {}, this.options[d.name] || {}));
        if (b.setObserver) {
            b.setObserver(this.observer)
        } else {
            b.observer = this.observer
        }
        if (b.init) {
            b.init()
        }
        this.modules[d.name] = b
    };
    this.addModules = function (c) {
        for (var b = 0; b < c.length; b++) {
            this.addModule(c[b])
        }
    };
    this.boot = function () {
        amplify.subscribe("module.tabs.change", this, this.onTabChange);
        amplify.subscribe("module.search.now", this, this.onSearch)
    };
    this.load = function () {
        this.options.store = true;
        this.setOptions(amplify.store(this.options.id) || {})
    };
    this.saveData = function (d) {
        var b = {
            expires: false
        };
        if (d._expires) {
            b.expires = parseInt(d._expires) - (+new Date)
        }
        for (var c in d) {
            if (c in this.storable && !this.storable[c]) {
                delete d[c]
            }
        }
        amplify.store(this.options.id, d, b)
    };
    this.onSearch = function (d) {
        if (this.options.id == d) {
            var c = {}, b;
            amplify.publish("validateAndGetData", c, d, this.exclude());
            amplify.publish("module.validate.get.data", c, d, this.exclude());
            for (b in c) {
                if (null == c[b]) {
                    return false
                }
            }
            if (this.options.store) {
                this.saveData(JSON.parse(JSON.stringify(c)))
            }
            this.search(c)
        }
    };
    this.onTabChange = function (b) {
        if (b.hasClass("tab-" + this.options.id)) {
            if (!this.initialized) {
                this.init();
                this.initialized = true
            }
            this.options.context.removeClass("hidden")
        } else {
            this.options.context.addClass("hidden")
        }
    };
    this.hasPlaceHolderSupport = function () {
        return "placeholder" in document.createElement("input")
    };
    this.afterInit = function () {
        if (this.hasPlaceHolderSupport()) {
            return false
        }
        var b = function () {
            (function (c) {
                setTimeout(function () {
                    if (c.val() != "" && c.val() != c.attr("placeholder")) {
                        c.removeClass("placeholder")
                    }
                }, 10)
            }($(this)))
        };
        this.options.context.find("input[placeholder]").change(b).prop("onchange", b).focus(function () {
            var c = $(this);
            if (c.val() == c.attr("placeholder")) {
                c.removeClass("placeholder").val("")
            }
        }).blur(function () {
            var c = $(this);
            if (c.val() == "" || c.val() == c.attr("placeholder")) {
                c.addClass("placeholder").val(c.attr("placeholder"))
            }
        }).blur()
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox.Box");
Nibbler.Searchbox.js.Searchbox.Box.Hotels = function (d) {
    Nibbler.Searchbox.js.Searchbox.Box.call(this, d);
    this.init = function () {
        var k = Nibbler.Searchbox.js.Searchbox.Module;
        var j = this.activator.getActivation("places");
        this.addModules([ {
            name: "places",
            module: j,
            selector: "div.mod-places-hotels",
            store: true,
            options: {
                disambiguation: false
            }
        }, {
            name: "dates",
            module: k.Dates,
            selector: "div.mod-dates",
            store: true
        }, {
            name: "search",
            module: k.Search,
            selector: "div.mod-searchbutton"
        } ]);
        this.afterInit();
        this.setupNoDatesChange(d);
    };
    this.setupNoDatesChange = function (c) {
   	 c.context.find("#no-dates-cb").on("click", function () {
   		 if (this.checked) {
   			 amplify.publish("module.dates.nodates.change", true);
   			 $(this.form).find('input#sb-datein-hotels').prop("disabled", true).val('');
   			 $(this.form).find('input#sb-dateout-hotels').prop("disabled", true).val('');
   			 $(this.form).find('div.com-datein span.buttonCalendarOn').removeClass('buttonCalendarOn');
   			 $(this.form).find('div.com-dateout span.buttonCalendarOn').removeClass('buttonCalendarOn');
   		 } else {
   			 amplify.publish("module.dates.nodates.change", false);
   			 $(this.form).find('input#sb-datein-hotels').prop("disabled", false);
   			 $(this.form).find('input#sb-dateout-hotels').prop("disabled", false);
   			 $(this.form).find('div.com-datein span.commonSprite').addClass('buttonCalendarOn');
   			 $(this.form).find('div.com-dateout span.commonSprite').addClass('buttonCalendarOn');
   		 }
        });
   };    
    var e = "hidden";
    var c = "error";
    var f = "fast";

    this.exclude = function () {
        return ["multiple"];
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox");
Nibbler.Searchbox.js.Searchbox.Searcher = function (a) {
    var b = 200;
    this.setOptions = function (c) {
        this.options = $.extend(true, this.options || {}, c)
    };
    this.search = function (c) {};
    this.buildUrl = function (d, g) {
        var c = d.join("/");
        if (g) {
            var f = [],
                e;
            for (e in g) {
                f.push(e + "=" + encodeURIComponent(g[e]))
            }
            c += "?" + f.join("&")
        }
        return c
    };
    this.getFormattedPlaces = function (d) {
        var c = [];
        if (d.originValue) {
            c.push(d.originValue)
        }
        c.push(d.destinationValue);
        return c
    };
    this.getFormattedDates = function (c) {
        var d = [];
        for (date in c) {
            if ("_expires" != date) {
                d.push(c[date])
            }
        }
        return this.convertDate(d, "-")
    };
    this.getFormattedPassengers = function (f, e) {
        var g = [],
            c = [],
            e = e || false,
            d = 0;
        $.each(f, function (h, j) {
            g.push(j.adults);
            $.each(j.childs, function (k, l) {
                if (l.age >= 0) {
                    g.push(l.age)
                }
                if (e && l.seatType == 1) {
                    d++
                }
            });
            c.push(g.join("-"));
            g = []
        });
        if (e) {
            return [c.join("!"), d]
        } else {
            return c.join("!")
        }
    };
    this.convertDate = function (d, f) {
        var c;
        if ($.isArray(d)) {
            var e = [];
            $.each(d, function (h, g) {
                if (g.indexOf("/") != "-1") {
                    c = g.split("/")
                } else {
                    c = g.split("-")
                }
                e[h] = c[2] + f + c[1] + f + c[0]
            });
            return e
        } else {
            if (d.indexOf("/") != "-1") {
                c = d.split("/")
            } else {
                c = d.split("-")
            }
            return (c[2] + f + c[1] + f + c[0])
        }
    };
    this.redirect = function (c, e, f) {
        if ($.isArray(c)) {
            c = this.buildUrl(c, e)
        }
        if (f && $.isArray(f)) {
            f = this.buildUrl(f, e);
            var d = setTimeout(function () {
                location.href = c
            }, b);
            $.ajax({
                url: f,
                complete: function (g, h) {
                    clearTimeout(d);
                    window.location.href = c
                }
            })
        } else {
            window.location.href = c
        }
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox.Searcher");
Nibbler.Searchbox.js.Searchbox.Searcher.Hotels = function (c) {
    this.options = {
        urlSearchPrefix: urlSearchPrefixHotelsG,
        urlShowPrefix: urlShowPrefixHotelsG,
        urlAnticipatedSearchPrefix: "/results/begin",
        anticipatedSearch: false
    };
    Nibbler.Searchbox.js.Searchbox.Searcher.call(this, c);
    var b;
    var a = 1;
    this.search = function (h) {
    	 
    	if (h.places.destinationFacet == 'h') {
    		b = [this.options.urlShowPrefix];
    	} else {
    		b = [this.options.urlSearchPrefix];
    	}

        b = b.concat(this.getFormattedPlaces(h.places));
        b = b.concat(this.getFormattedDates(h.dates));
            
        b = b.concat(armarDistribution());
        if (h.places.destinationFacet != 'h') {
	        // document.location.href='/hotels/result/'+hotels_id+'/'+check_in+'/'+check_out+'/'+distribution+'/'+type+'/'+page+'/'+destino_hotel;
	        page = 1;
	        //type = $("#hidden-destination-type").val();
	     //   type = 'city';
            b = b.concat(page);
	    
            // b = b.concat(destino_hotel);
        } 
            
        if (this.options.anticipatedSearch) {
            var j = [].concat(b);
            j[0] = this.options.urlAnticipatedSearchPrefix;
            this.redirect(b, null, j)
        } else {
            this.redirect(b)
        } 
    };
    
/*    this.getFormattedTriptype = function (g) {
        return g.currentType.toLowerCase()
    }; */
    
   /* this.getFormattedAdvancedOptions = function (g) {
        var h = false;
        for (option in g) {
            if (g[option] != "" && g[option] != "NA") {
                h = true;
                break
            }
        }
        if (h) {
            if (b[a] == f) {
                return [g.departureTime, g.classFlight, g.scaleFlight, (g.airlineFlight != "") ? g.airlineFlight : "NA"]
            } else {
                return [g.departureTime, g.returnTime, g.classFlight, g.scaleFlight, (g.airlineFlight != "") ? g.airlineFlight : "NA"]
            }
        } else {
            return []
        }
    };  */
  
    this.isDisambiguation = function (j) {
      /*  if (j.places && ((j.places.originText && !j.places.originValue) || (j.places.destinationText && !j.places.destinationValue))) {
            return true
        } else {
            if (j.multiple) {
                for (var g = 0, h; g < j.multiple.segments.length; g++) {
                    h = j.multiple.segments[g];
                    if ((h.originText && !h.originValue) || (h.destinationText && !h.destinationValue)) {
                        return true
                    }
                }
            }
        }
        return false */
    };
    this.disambiguate = function (j) {
     /*   var r = {
            roundTrip: 2,
            oneWay: 1,
            MultipleDestinations: 3
        };
        var s = {
            ItineraryType: r[j.triptypes.currentType],
            Adults: j.passengers.adults,
            Children: j.passengers.childs,
            Infants: j.passengers.infants,
            FlowVersion: 2
        };
        if (j.triptypes.currentType == "MultipleDestinations") {
            for (var k = 0, l, p = [], q = [], m = [], n = [], h = []; k < j.multiple.segments.length; k++) {
                l = j.multiple.segments[k];
                p.push(l.originValue);
                q.push(l.originText);
                m.push(l.destinationValue);
                n.push(l.destinationText);
                h.push(this.convertDate(l.dateIn, "-"))
            }
            s.Origins = p;
            s.OriginsNames = q;
            s.Destinations = m;
            s.DestinationsNames = n;
            s.DepartureDates = h;
            s.ReturnDate = ""
        } else {
            s.Origins = [j.places.originValue || ""];
            s.OriginsNames = [j.places.originText];
            s.Destinations = [j.places.destinationValue || ""];
            s.DestinationsNames = [j.places.destinationText];
            s.DepartureDates = [this.convertDate(j.dates.dateIn, "-")];
            if (j.triptypes.currentType == "roundTrip") {
                s.ReturnDate = this.convertDate(j.dates.dateOut, "-")
            }
        }
        var g = $('<form method="post" />');
        g.attr("action", this.getDisambiguationUrl());
        var o = $('<input type="hidden" name="data" />');
        o.val(JSON.stringify(s));
        g.append(o).appendTo("body").submit()  */
    };
    /* this.getDisambiguationUrl = function () {
        return "/search/Disambiguation/Disambiguation.aspx"
    } */
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox");
Nibbler.Searchbox.js.Searchbox.Module = function (a) {
    this.options = $.extend(true, this.options || {}, a);
    this.observer = null;
    this.setObserver = function (b) {
        this.observer = b
    };
    this.listen = function () {
        this.observer.listen.apply(this.observer, arguments)
    };
    this.notify = function () {
        this.observer.notify.apply(this.observer, arguments)
    };
    this.init = function () {
        this.setup();
        amplify.subscribe("module.validate.get.data", this, function (c, d, b) {
            if (this.options.id != d) {
                return true
            }
            if ($.type(b) == "array" && $.inArray(this.options.name, b) > -1) {
                return true
            }
            if (this.validate(c)) {
                if (this.options.name in c) {
                    c[this.options.name] = jQuery.extend(true, c[this.options.name], this.getData())
                } else {
                    c[this.options.name] = this.getData()
                }
            } else {
                c[this.options.name] = null
            }
        })
    };
    this.setup = function () {};
    this.validate = function () {};
    this.getData = function () {}
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox.Module");
Nibbler.Searchbox.js.Searchbox.Module.Places = function (a) {
    this.options = {
        disambiguation: false,
        checkBadCity: true,
        samePlaceSearch: false,
        activeCheckbox: false,
        returnOtherCity: false
    };
    Nibbler.Searchbox.js.Searchbox.Module.call(this, a);
    this.setup = function () {
        this.com = {};
        this.com.origin = this.options.context.find("div.origin input");
        this.com.destination = this.options.context.find("div.destination input");
        this.com.checkboxCity = this.options.context.find("input.places-checkbox-cars");
        this.com.autocomplete = {};
        this.com.autocomplete.origin = new Nibbler.Autocomplete.js.Autocomplete({
            type: this.options.autoCompleteType,
            cache: this.options.autoCompleteCache,
            url: this.options.autoCompleteUrl,
            element: this.com.origin,
            initial: {
                place: this.options.originText || null,
                code: this.options.originValue || null,
                facet: this.options.originFacet || "c"
            }
        });
        this.com.autocomplete.destination = new Nibbler.Autocomplete.js.Autocomplete({
            type: this.options.autoCompleteType,
            cache: this.options.autoCompleteCache,
            url: this.options.autoCompleteUrl,
            element: this.com.destination,
            initial: {
                place: this.options.destinationText || null,
                code: this.options.destinationValue || null,
               facet: this.options.destinationFacet || "c"
            }
        });
        if (this.options.activeCheckbox) {
            var b = this.options.context.find("div.com-city.destination");
            this.com.checkboxCity.on("click", function (d, c) {
                if (c || this.checked) {
                    b.show()
                } else {
                    b.hide()
                }
            });
            if (this.options.returnOtherCity) {
                this.com.checkboxCity.trigger("click", true)
            }
        }
        this.listen(this.options.product + "." + this.options.name + ".origin.update", this, function (c) {
            this.com.autocomplete.origin.fill(c)
        });
        this.listen(this.options.product + "." + this.options.name + ".destination.update", this, function (c) {
            this.com.autocomplete.destination.fill(c)
        })
    };
    this.validate = function () {
        var d = this;
        var b = this.com;
        var c = new Nibbler.Searchbox.js.Searchbox.Validator({
            "error.origin.empty": {
                validate: !! b.origin.length,
                element: b.origin,
                message: this.options.context.find("div.origin p.error-empty"),
                callback: function () {
                    return !this.isEmpty(b.origin.val()) && b.origin.attr("placeholder") != b.origin.val()
                }
            },
            "error.destination.empty": {
                validate: !this.options.activeCheckbox || (this.options.activeCheckbox && this.com.checkboxCity.is(":checked")),
                element: b.destination,
                message: this.options.context.find("div.destination p.error-empty"),
                callback: function () {
                    return !this.isEmpty(b.destination.val()) && b.destination.attr("placeholder") != b.destination.val()
                }
            },
            "error.origin.invalid": {
                validate: b.origin.length && this.options.checkBadCity && !this.options.disambiguation,
                depends: "error.origin.empty",
                element: b.origin,
                message: this.options.context.find("div.origin p.error-badcity"),
                callback: function () {
                    return !this.isEmpty(b.autocomplete.origin.getCode())
                }
            },
            "error.destination.invalid": {
                validate: this.options.checkBadCity && !this.options.disambiguation,
                depends: "error.destination.empty",
                element: b.destination,
                message: this.options.context.find("div.destination p.error-badcity"),
                callback: function () {
                    return !this.isEmpty(b.autocomplete.destination.getCode())
                }
            },
            "error.same.place": {
                validate: b.origin.length && !this.options.samePlaceSearch,
                depends: this.options.disambiguation ? ["error.origin.empty", "error.destination.empty"] : ["error.origin.invalid", "error.destination.invalid"],
                element: b.origin.add(b.destination),
                message: this.options.context.find("p.error.repeatedCity"),
                callback: function () {
                    var e = true;
                    if (d.options.disambiguation) {
                        e = b.origin.val() != b.destination.val()
                    }
                    if (this.isEmpty(b.autocomplete.origin.getCode())) {
                        return e
                    }
                    return e && b.autocomplete.origin.getCode() != b.autocomplete.destination.getCode()
                }
            },
            "error.venezuela.locale": {
                validate: this.options.country.toLowerCase() == "ve" && !! this.options.venezuelaCities,
                depends: ["error.origin.empty", "error.destination.empty"],
                element: b.origin.add(b.destination),
                message: this.options.context.find("p.error-ve-noLocal"),
                callback: function () {
                    var e = b.autocomplete.origin.getCode();
                    var f = b.autocomplete.destination.getCode();
                    if (this.isEmpty(e) || this.isEmpty(f)) {
                        return true
                    }
                    return -1 != $.inArray(e, d.options.venezuelaCities) || -1 != $.inArray(f, d.options.venezuelaCities)
                }
            }
        });
        return c.cleanOnFocus().validate()
    };
    this.getData = function () {
        var c = {};
        var b = this.com;
        if (b.origin.length) {
            c.originValue = b.autocomplete.origin.getCode();
            c.originText = b.autocomplete.origin.getPlace();
            c.originFacet = b.autocomplete.origin.getFacet()
        }
        if (this.options.activeCheckbox) {
            c.returnOtherCity = b.checkboxCity.is(":checked")
        }
        if (!this.options.activeCheckbox || c.returnOtherCity) {
            c.destinationValue = b.autocomplete.destination.getCode();
            c.destinationFacet = b.autocomplete.destination.getFacet();
            c.destinationText = b.autocomplete.destination.getPlace()
        }
        return c
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox.Module");
Nibbler.Searchbox.js.Searchbox.Module.Dates = function (l) {
    var k = "roundTrip";
    var u = "oneWay";
    var r = "MultipleDestinations";
    var s = "hidden";
    var e = "error";
    var c = $.extend({
        name: "DatesModule",
        id: null,
        context: null,
        currentDate: new Date,
        availableDays: null,
        maxDays: null,
        calendars: 2,
        position: "left",
        hasTime: false,
        focusBack: true,
        sameDate: true
    }, l);
    var n = k;
    var q = c.context.find("div.com-datein input");
    var j = c.context.find("div.com-dateout input");
    q.add(j).next().on("click", function () {
        $(this).prevAll("input").focus()
    }).end().blur(function () {
        var x = $(this).data("picker");
        if (x && !x.selecting) {
            x.onPressEnter(true)
        }
    });
    var w = function (x) {
        amplify.publish("module.dates.change", this.dateFormat(x), c.id)
    };
    var a = function () {
        if (n == k) {
            setTimeout(f, 200)
        }
    };
    var f = function () {
        j.focus()
    };
    var d = {
        reference: j,
        rangeStart: true,
        currentDate: c.currentDate,
        availableDays: c.availableDays,
        maxDays: c.maxDays,
        calendars: c.calendars,
        position: c.position,
        selected: c.dateIn || null,
        anticipationDays: "anticipationDays" in c ? c.anticipationDays : 1,
        locale: c.locale
    };
    if (c.focusBack) {
        d.onPick = a
    }
    q.datePicker(d);
    j.datePicker({
        reference: q,
        rangeEnd: true,
        currentDate: c.currentDate,
        availableDays: c.availableDays,
        maxDays: c.maxDays,
        calendars: c.calendars,
        position: c.position,
        onPick: w,
        selected: c.dateOut || null,
        anticipationDays: "anticipationDays" in c ? c.anticipationDays : 1,
        locale: c.locale
    });
    j.on("change", function () {
        if ($(this).val() == "") {
            amplify.publish("module.dates.change", false, c.id)
        }
    });
    q.add(j).on({
        keypress: function (x) {
            if (x.charCode) {
                return /[0-9]|\/|\-/.test(String.fromCharCode(x.charCode))
            }
        },
        keyup: function () {
            if (/\-/.test(this.value)) {
                this.value = this.value.replace(/\-/g, "/")
            }
        }
    });
    var v = q.data("picker"),
        t = j.data("picker");
    if (c.hasTime) {
        var m = c.context.find("select.sb-timein"),
            p = c.context.find("select.sb-timeout");
        if (c.timeIn) {
            m.val(c.timeIn)
        }
        if (c.timeOut) {
            p.val(c.timeOut)
        }
    }
    var b = function (x, y) {
        if (c.id != y) {
            return
        }
        if (x == k) {
            q.datePicker({
                rangeStart: true,
                reference: j
            });
            j.datePicker({
                rangeEnd: true,
                reference: q
            });
            amplify.publish("module.dates.change", $(j).val(), c.id)
        } else {
            if (x == u) {
                q.add(j).datePicker({
                    reset: true
                });
                amplify.publish("module.dates.change", false, c.id)
            }
        }
        n = x
    };
    var h = function () {
        var x = new Nibbler.Searchbox.js.Searchbox.Validator({
            "error.date.in.empty": {
                validate: true,
                depends: false,
                element: q,
                message: c.context.find("p.error-emptyIn"),
                callback: function () {
                    return !this.isEmpty(q.val()) && q.attr("placeholder") != q.val()
                }
            },
            "error.date.out.empty": {
                validate: n == k,
                element: j,
                message: c.context.find("p.error-emptyOut"),
                callback: function () {
                    return !this.isEmpty(j.val()) && j.attr("placeholder") != j.val()
                }
            },
            "error.date.in.invalid": {
                depends: "error.date.in.empty",
                element: q,
                message: c.context.find("p.error-dateIn"),
                callback: function () {
                    return this.isDate(q.val())
                }
            },
            "error.date.out.invalid": {
                validate: n == k,
                depends: "error.date.out.empty",
                element: j,
                message: c.context.find("p.error-dateOut"),
                callback: function () {
                    return this.isDate(j.val())
                }
            },
            "error.same.date": {
                validate: n == k && !c.sameDate,
                depends: ["error.date.in.invalid", "error.date.out.invalid"],
                element: q.add(j),
                message: c.context.find("p.error-sameDate"),
                callback: function () {
                    return this.dateDiff(q.val(), j.val()) > 0
                }
            },
            "error.date.range": {
                validate: n == k,
                depends: ["error.date.in.invalid", "error.date.out.invalid"],
                element: q.add(j),
                message: c.context.find("p.error-range"),
                callback: function () {
                    return this.dateDiff(q.val(), j.val()) >= 0
                }
            },
            "error.date.and.time.range": {
                validate: !! c.hasTime,
                depends: "error.date.range",
                element: q.add(j).add(m).add(p),
                message: c.context.find("p.error-range"),
                callback: function () {
                    var z = this.parseDate(q.val());
                    z.setHours(m.val());
                    var y = this.parseDate(j.val());
                    y.setHours(p.val());
                    return this.dateDiff(z, y) > 0
                }
            },
            "error.date.and.time.start.hours": {
                validate: !! c.hasTime,
                depends: "error.date.and.time.range",
                element: q.add(m),
                message: c.context.find("p.error-start-hours"),
                callback: function () {
                    var y = this.parseDate(q.val());
                    y.setHours(m.val());
                    if (this.dateDiff(c.currentDate, y) >= (4 / 24)) {
                        return true
                    }
                    return false
                }
            },
            "error.date.and.time.min.hours": {
                validate: !! c.hasTime,
                depends: "error.date.and.time.start.hours",
                element: q.add(j).add(m).add(p),
                message: c.context.find("p.error-minHours"),
                callback: function () {
                    var z = this.parseDate(q.val());
                    z.setHours(m.val());
                    var y = this.parseDate(j.val());
                    y.setHours(p.val());
                    if (this.dateDiff(z, y) >= (4 / 24)) {
                        return true
                    }
                    return false
                }
            },
            "error.date.and.time.valid": {
                validate: !! c.hasTime,
                depends: "error.date.and.time.range",
                element: q.add(m),
                message: c.context.find("p.error-validHours"),
                callback: function () {
                    var z = this.parseDate(q.val());
                    z.setHours(m.val());
                    var y = this.parseDate((new Date).getDate() + "/" + ((new Date).getMonth() + 1) + "/" + (new Date).getFullYear());
                    y.setHours((new Date).getHours());
                    if (z > y) {
                        return true
                    }
                    return false
                }
            },
            "error.date.max.days": {
                validate: !! c.maxDays,
                depends: "error.date.range",
                element: q.add(j),
                message: c.context.find("p.error-maxDays"),
                callback: function () {
                    return this.dateDiff(q.val(), j.val()) < c.maxDays
                }
            },
            "error.date.in.stay": {
                validate: n == k,
                depends: c.maxDays ? "error.date.max.days" : "error.date.range",
                element: q,
                message: c.context.find("p.error-stayIn"),
                callback: function () {
                    return this.dateDiff(v.dateStart, q.val()) >= 0 && this.dateDiff(q.val(), v.dateLimit) > 0
                }
            },
            "error.date.out.stay": {
                validate: n == k,
                depends: c.maxDays ? "error.date.max.days" : "error.date.range",
                element: j,
                message: c.context.find("p.error-stayOut"),
                callback: function () {
                    return this.dateDiff(t.dateStart, j.val()) >= 0 && this.dateDiff(j.val(), t.dateLimit) > 0
                }
            }
        });
        return x.cleanOnFocus().validate()
    };
    var g = function () {
        var x = {
            dateIn: v.getSelected()
        };
        if (n == k) {
            x.dateOut = t.getSelected()
        }
        if (c.hasTime) {
            x.timeIn = m.val();
            x.timeOut = p.val()
        }
        return x
    };
    var o = function (y, z, x) {
        if (z == c.id && -1 == $.inArray(c.name, x) && !c.disabled) {
            if (h()) {
                y[c.name] = g();
                y._expires = v.getSelected("u")
            } else {
                y[c.name] = null
            }
        }
    };
    var p = function (pp) {
    	c.disabled = pp;
    };
    amplify.subscribe("module.triptypes.change", b);
    amplify.subscribe("validateAndGetData", o);
    amplify.subscribe("module.dates.nodates.change", p);
    if ($.browser.webkit) {
        c.context.css("display", "inline")
    }
};
registerNameSpace("Nibbler.Searchbox.js.Searchbox.Module");
Nibbler.Searchbox.js.Searchbox.Module.Search = function (b) {
    var c = "a.ctn-searchbutton";
    var d = $.extend({
        name: "SearchModule",
        id: null,
        context: null
    }, b);
    var a = function () {
        amplify.publish("module.search.now", d.id);
        return false
    };
    d.context.find(c).on("click", a)
};
registerNameSpace("Despegar.Common.Searchbox");
Despegar.Common.Searchbox.SearchBox = Nibbler.Searchbox.js.Searchbox;
registerNameSpace("Despegar.Common.Searchbox.Validator");
Despegar.Common.Searchbox.Validator.Validator = Nibbler.Searchbox.js.Searchbox.Validator;
registerNameSpace("Despegar.Common.Searchbox.Products");
Despegar.Common.Searchbox.Products.Box = Nibbler.Searchbox.js.Searchbox.Box;
Despegar.Common.Searchbox.Products.HotelsBox = Nibbler.Searchbox.js.Searchbox.Box.Hotels;
registerNameSpace("Despegar.Common.Searchbox.Products.Searcher");
Despegar.Common.Searchbox.Products.Searcher.Searcher = Nibbler.Searchbox.js.Searchbox.Searcher;
Despegar.Common.Searchbox.Products.Searcher.SearcherFormatter = Nibbler.Searchbox.js.Searchbox.Searcher;
Despegar.Common.Searchbox.Products.Searcher.HotelsSearcher = Nibbler.Searchbox.js.Searchbox.Searcher.Hotels;
registerNameSpace("Despegar.Common.Searchbox.Products.Modules.Common");
Despegar.Common.Searchbox.Products.Modules.Common.TabsModule = Nibbler.Searchbox.js.Searchbox.Module.Tabs;
Despegar.Common.Searchbox.Products.Modules.Common.DatesModule = Nibbler.Searchbox.js.Searchbox.Module.Dates;
Despegar.Common.Searchbox.Products.Modules.Common.PlacesModule = Nibbler.Searchbox.js.Searchbox.Module.Places;
Despegar.Common.Searchbox.Products.Modules.Common.RoomsDropdown = Nibbler.Searchbox.js.Searchbox.Module.RoomsDropdown;
Despegar.Common.Searchbox.Products.Modules.Common.HostDropdown = Nibbler.Searchbox.js.Searchbox.Module.HostDropdown;
Despegar.Common.Searchbox.Products.Modules.Common.SearchModule = Nibbler.Searchbox.js.Searchbox.Module.Search;
