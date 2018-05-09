/*
FRAMEWORK_VERSION:1.46.0
*/
(function (V) {
    var E = V.fn.domManip,
        S = "_tmplitem",
        F = /^[^<]*(<[\w\W]+>)[^>]*$|\{\{\! /,
        U = {}, Q = {}, R, G = {
            key: 0,
            data: {}
        }, O = 0,
        T = 0,
        K = [];

    function P(h, k, f, b) {
        var l = {
            data: b || (k ? k.data : {}),
            _wrap: k ? k._wrap : null,
            tmpl: null,
            parent: k || null,
            nodes: [],
            calls: B,
            nest: z,
            wrap: y,
            html: A,
            update: C
        };
        h && V.extend(l, h, {
            nodes: [],
            parent: k
        });
        if (f) {
            l.tmpl = f;
            l._ctnt = l._ctnt || l.tmpl(V, l);
            l.key = ++O;
            (K.length ? Q : U)[O] = l
        }
        return l
    }
    V.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (b, c) {
        V.fn[b] = function (s) {
            var r = [],
                p = V(s),
                f, q, d, e, o = this.length === 1 && this[0].parentNode;
            R = U || {};
            if (o && o.nodeType === 11 && o.childNodes.length === 1 && p.length === 1) {
                p[c](this[0]);
                r = this
            } else {
                for (q = 0, d = p.length; q < d; q++) {
                    T = q;
                    f = (q > 0 ? this.clone(true) : this).get();
                    V.fn[c].apply(V(p[q]), f);
                    r = r.concat(f)
                }
                T = 0;
                r = this.pushStack(r, b, p.selector)
            }
            e = R;
            R = null;
            V.tmpl.complete(e);
            return r
        }
    });
    V.fn.extend({
        tmpl: function (f, g, e) {
            return V.tmpl(this[0], f, g, e)
        },
        tmplItem: function () {
            return V.tmplItem(this[0])
        },
        template: function (c) {
            return V.template(c, this[0])
        },
        domManip: function (o, b, c) {
            if (o[0] && o[0].nodeType) {
                var n = V.makeArray(arguments),
                    m = o.length,
                    e = 0,
                    k;
                while (e < m && !(k = V.data(o[e++], "tmplItem"))) {}
                if (m > 1) {
                    n[0] = [V.makeArray(o)]
                }
                if (k && T) {
                    n[2] = function (d) {
                        V.tmpl.afterManip(this, d, c)
                    }
                }
                E.apply(this, n)
            } else {
                E.apply(this, arguments)
            }
            T = 0;
            !R && V.tmpl.complete(U);
            return this
        }
    });
    V.extend({
        tmpl: function (l, g, i, m) {
            var f, b = !m;
            if (b) {
                m = G;
                l = V.template[l] || V.template(null, l);
                Q = {}
            } else {
                if (!l) {
                    l = m.tmpl;
                    U[m.key] = m;
                    m.nodes = [];
                    m.wrapped && I(m, m.wrapped);
                    return V(N(m, null, m.tmpl(V, m)))
                }
            } if (!l) {
                return []
            }
            if (typeof g === "function") {
                g = g.call(m || {})
            }
            i && i.wrapped && I(i, i.wrapped);
            f = V.isArray(g) ? V.map(g, function (c) {
                return c ? P(i, m, l, c) : null
            }) : [P(i, m, l, g)];
            return b ? V(N(m, null, f)) : f
        },
        tmplItem: function (d) {
            var e;
            if (d instanceof V) {
                d = d[0]
            }
            while (d && d.nodeType === 1 && !(e = V.data(d, "tmplItem")) && (d = d.parentNode)) {}
            return e || G
        },
        template: function (e, d) {
            if (d) {
                if (typeof d === "string") {
                    d = H(d)
                } else {
                    if (d instanceof V) {
                        d = d[0] || {}
                    }
                } if (d.nodeType) {
                    d = V.data(d, "tmpl") || V.data(d, "tmpl", H(d.innerHTML))
                }
                return typeof e === "string" ? (V.template[e] = d) : d
            }
            return e ? typeof e !== "string" ? V.template(null, e) : V.template[e] || V.template(null, F.test(e) ? e : V(e)) : null
        },
        encode: function (b) {
            return ("" + b).split("<").join("&lt;").split(">").join("&gt;").split('"').join("&#34;").split("'").join("&#39;")
        }
    });
    V.extend(V.tmpl, {
        tag: {
            tmpl: {
                _default: {
                    $2: "null"
                },
                open: "if($notnull_1){_=_.concat($item.nest($1,$2));}"
            },
            wrap: {
                _default: {
                    $2: "null"
                },
                open: "$item.calls(_,$1,$2);_=[];",
                close: "call=$item.calls();_=call._.concat($item.wrap(call,_));"
            },
            each: {
                _default: {
                    $2: "$index, $value"
                },
                open: "if($notnull_1){$.each($1a,function($2){with(this){",
                close: "}});}"
            },
            "if": {
                open: "if(($notnull_1) && $1a){",
                close: "}"
            },
            "else": {
                _default: {
                    $1: "true"
                },
                open: "}else if(($notnull_1) && $1a){"
            },
            html: {
                open: "if($notnull_1){_.push($1a);}"
            },
            "=": {
                _default: {
                    $1: "$data"
                },
                open: "if($notnull_1){_.push($.encode($1a));}"
            },
            "!": {
                open: ""
            }
        },
        complete: function () {
            U = {}
        },
        afterManip: function (g, c, i) {
            var h = c.nodeType === 11 ? V.makeArray(c.childNodes) : c.nodeType === 1 ? [c] : [];
            i.call(g, c);
            J(h);
            T++
        }
    });

    function N(k, h, i) {
        var d, l = i ? V.map(i, function (b) {
                return typeof b === "string" ? k.key ? b.replace(/(<\w+)(?=[\s>])(?![^>]*_tmplitem)([^>]*)/g, "$1 " + S + '="' + k.key + '" $2') : b : N(b, k, b._ctnt)
            }) : k;
        if (h) {
            return l
        }
        l = l.join("");
        l.replace(/^\s*([^<\s][^<]*)?(<[\w\W]+>)([^>]*[^>\s])?\s*$/, function (b, n, g, m) {
            d = V(g).get();
            J(d);
            if (n) {
                d = M(n).concat(d)
            }
            if (m) {
                d = d.concat(M(m))
            }
        });
        return d ? d : M(l)
    }

    function M(e) {
        var d = document.createElement("div");
        d.innerHTML = e;
        return V.makeArray(d.childNodes)
    }

    function H(c) {
        return new Function("jQuery", "$item", "var $=jQuery,call,_=[],$data=$item.data;with($data){_.push('" + V.trim(c).replace(/([\\'])/g, "\\$1").replace(/[\r\t\n]/g, " ").replace(/\$\{([^\}]*)\}/g, "{{= $1}}").replace(/\{\{(\/?)(\w+|.)(?:\(((?:[^\}]|\}(?!\}))*?)?\))?(?:\s+(.*?)?)?(\(((?:[^\}]|\}(?!\}))*?)\))?\s*\}\}/g, function (k, n, o, u, w, v, t) {
            var p = V.tmpl.tag[o],
                q, s, r;
            if (!p) {
                throw "Template command not found: " + o
            }
            q = p._default || [];
            if (v && !/\w$/.test(w)) {
                w += v;
                v = ""
            }
            if (w) {
                w = L(w);
                t = t ? "," + L(t) + ")" : v ? ")" : "";
                s = v ? w.indexOf(".") > -1 ? w + v : "(" + w + ").call($item" + t : w;
                r = v ? s : "(typeof(" + w + ")==='function'?(" + w + ").call($item):(" + w + "))"
            } else {
                r = s = q.$1 || "null"
            }
            u = L(u);
            return "');" + p[n ? "close" : "open"].split("$notnull_1").join(w ? "typeof(" + w + ")!=='undefined' && (" + w + ")!=null" : "true").split("$1a").join(r).split("$1").join(s).split("$2").join(u ? u.replace(/\s*([^\(]+)\s*(\((.*?)\))?/g, function (g, h, e, f) {
                f = f ? "," + f + ")" : e ? ")" : "";
                return f ? "(" + h + ").call($item" + f : g
            }) : q.$2 || "") + "_.push('"
        }) + "');}return _;")
    }

    function I(e, d) {
        e._wrap = N(e, true, V.isArray(d) ? d : [F.test(d) ? d : V(d).html()]).join("")
    }

    function L(b) {
        return b ? b.replace(/\\'/g, "'").replace(/\\\\/g, "\\") : null
    }

    function D(c) {
        var d = document.createElement("div");
        d.appendChild(c.cloneNode(true));
        return d.innerHTML
    }

    function J(c) {
        var d = "_" + T,
            h, q, g = {}, s, b, r;
        for (s = 0, b = c.length; s < b; s++) {
            if ((h = c[s]).nodeType !== 1) {
                continue
            }
            q = h.getElementsByTagName("*");
            for (r = q.length - 1; r >= 0; r--) {
                f(q[r])
            }
            f(h)
        }

        function f(t) {
            var w, u = t,
                n, v, l;
            if (l = t.getAttribute(S)) {
                while (u.parentNode && (u = u.parentNode).nodeType === 1 && !(w = u.getAttribute(S))) {}
                if (w !== l) {
                    u = u.parentNode ? u.nodeType === 11 ? 0 : u.getAttribute(S) || 0 : 0;
                    if (!(v = U[l])) {
                        v = Q[l];
                        v = P(v, U[u] || Q[u], null, true);
                        v.key = ++O;
                        U[O] = v
                    }
                    T && x(l)
                }
                t.removeAttribute(S)
            } else {
                if (T && (v = V.data(t, "tmplItem"))) {
                    x(v.key);
                    U[v.key] = v;
                    u = V.data(t.parentNode, "tmplItem");
                    u = u ? u.key : 0
                }
            } if (v) {
                n = v;
                while (n && n.key != u) {
                    n.nodes.push(t);
                    n = n.parent
                }
                delete v._ctnt;
                delete v._wrap;
                V.data(t, "tmplItem", v)
            }

            function x(e) {
                e = e + d;
                v = g[e] = g[e] || P(v, U[v.parent.key + d] || v.parent, null, true)
            }
        }
    }

    function B(f, g, h, e) {
        if (!f) {
            return K.pop()
        }
        K.push({
            _: f,
            tmpl: g,
            item: this,
            data: h,
            options: e
        })
    }

    function z(f, g, e) {
        return V.tmpl(V.template(f), g, e, this)
    }

    function y(e, f) {
        var g = e.options || {};
        g.wrapped = f;
        return V.tmpl(V.template(e.tmpl), e.data, g, e.item)
    }

    function A(f, g) {
        var e = this._wrap;
        return V.map(V(V.isArray(e) ? e.join("") : e).filter(f || "*"), function (b) {
            return g ? b.innerText || b.textContent : b.outerHTML || D(b)
        })
    }

    function C() {
        var c = this.nodes;
        V.tmpl(null, null, null, this).insertBefore(c[0]);
        V(c).remove()
    }
})(jQuery);
registerNameSpace("Despegar");
Despegar.Date = function (b) {
    this.day;
    this.month;
    this.year;
    this.monthText;
    this.dayOfWeek;
    this.serverURL = "ajaxTimeStamp.asp";
    this.test = "aaaa";
    this.language = b || "es"
};
Despegar.Date.prototype.getDaysName = function (b) {
    if (typeof this.daysName != "object") {
        this.daysName = new Array();
        this.daysName[0] = !b ? "Sunday".substr(0, 2) : "Sunday".substr(0, b);
        this.daysName[1] = !b ? "Monday".substr(0, 2) : "Monday".substr(0, b);
        this.daysName[2] = !b ? "Tuesday".substr(0, 2) : "Tuesday".substr(0, b);
        this.daysName[3] = !b ? "Wednesday".substr(0, 2) : "Wednesday".substr(0, b);
        this.daysName[4] = !b ? "Thursday".substr(0, 2) : "Thursday".substr(0, b);
        this.daysName[5] = !b ? "Friday".substr(0, 2) : "Friday".substr(0, b);
        this.daysName[6] = !b ? "Saturday".substr(0, 2) : "Saturday".substr(0, b)
        this.daysName[7] = this.daysName[0]
    }
    return this.daysName
};
Despegar.Date.prototype.getMonthsName = function (b) {
    if (typeof this.monthsName != "object") {
        this.monthsName = new Array();
        this.monthsName[1] = !b ? "January" : "January".substr(0, b);
        this.monthsName[2] = !b ? "February" : "February".substr(0, b);
        this.monthsName[3] = !b ? "March" : "March".substr(0, b);
        this.monthsName[4] = !b ? "April" : "April".substr(0, b);
        this.monthsName[5] = !b ? "May" : "May".substr(0, b);
        this.monthsName[6] = !b ? "June" : "June".substr(0, b);
        this.monthsName[7] = !b ? "July" : "July".substr(0, b);
        this.monthsName[8] = !b ? "August" : "August".substr(0, b);
        this.monthsName[9] = !b ? "September" : "September".substr(0, b);
        this.monthsName[10] = !b ? "October" : "October".substr(0, b);
        this.monthsName[11] = !b ? "November" : "November".substr(0, b);
        this.monthsName[12] = !b ? "December" : "December".substr(0, b)
    }
    return this.monthsName
};
Despegar.Date.prototype.setEmpty = function () {
    this.day = undefined;
    this.month = undefined;
    this.year = undefined
};
Despegar.Date.prototype.isEmpty = function () {
    if (this.day == undefined || this.month == undefined || this.year == undefined) {
        return true
    } else {
        return false
    }
};
Despegar.Date.prototype.addDaysJSDate = function (b) {
    jDate = this.getJSDate();
    jDate.setDate(jDate.getDate() + b);
    this.day = jDate.getDate();
    this.month = jDate.getMonth() + 1;
    this.year = jDate.getFullYear()
};
Despegar.Date.prototype.addDays = function (c) {
    for (var b = 1; b <= c; b++) {
        switch (this.month) {
        case 4:
        case 6:
        case 9:
        case 11:
            if (this.day >= 30) {
                this.day = 1;
                this.month++
            } else {
                this.day++
            }
            break;
        case 2:
            if ((this.day == 28 && !this.isLeapYear()) || (this.day >= 29 && this.isLeapYear())) {
                this.day = 1;
                this.month++
            } else {
                this.day++
            }
            break;
        default:
            if (this.day >= 31) {
                this.day = 1;
                this.month++
            } else {
                this.day++
            }
        }
        if (this.month > 12) {
            this.month = 1;
            this.year++
        }
    }
};
Despegar.Date.prototype.addMonths = function (c) {
    var b = this.month + c;
    this.year = this.year + Math.floor(b / 12);
    if (!(b % 12)) {
        this.year--;
        this.month = 12
    } else {
        this.month = b % 12
    }
};
Despegar.Date.prototype.setddmmaaaa = function (b, c) {
    if (c != undefined) {
        var d = b.split(c);
        this.day = parseInt(d[0], 10);
        this.month = parseInt(d[1], 10);
        this.year = parseInt(d[2], 10)
    } else {
        this.day = parseInt(b.substr(0, 2), 10);
        this.month = parseInt(b.substr(2, 2), 10);
        this.year = parseInt(b.substr(4, 4), 10)
    }
};
Despegar.Date.prototype.setFullDate = function (c, d, b) {
    this.day = parseInt(b, 10);
    this.month = parseInt(d, 10);
    this.year = parseInt(c, 10)
};
Despegar.Date.prototype.setDateFromJSDate = function (b) {
    this.day = b.getDate();
    this.month = b.getMonth() + 1;
    this.year = b.getFullYear()
};
Despegar.Date.prototype.getDate = function () {
    return Common.Utils.Mask("00", this.day.toString())
};
Despegar.Date.prototype.getMonth = function () {
    return Common.Utils.Mask("00", this.month.toString())
};
Despegar.Date.prototype.getYear = function () {
    return Common.Utils.Mask("2000", this.year.toString())
};
Despegar.Date.prototype.getddmmaaaa = function () {
    return Common.Utils.Mask("00", this.day.toString()) + "/" + Common.Utils.Mask("00", this.month.toString()) + "/" + Common.Utils.Mask("2000", this.year.toString())
};
Despegar.Date.prototype.getddmm = function () {
    return Common.Utils.Mask("00", this.day.toString()) + "/" + Common.Utils.Mask("00", this.month.toString())
};
Despegar.Date.prototype.getaaaamm = function () {
    return Common.Utils.Mask("2000", this.year.toString()) + Common.Utils.Mask("00", this.month.toString())
};
Despegar.Date.prototype.getmmaaaa = function () {
    return Common.Utils.Mask("00", this.month.toString()) + "/" + Common.Utils.Mask("2000", this.year.toString())
};
Despegar.Date.prototype.getiso = function () {
    return Common.Utils.Mask("2000", this.year.toString()) + Common.Utils.Mask("00", this.month.toString()) + Common.Utils.Mask("00", this.day.toString())
};
Despegar.Date.prototype.setiso = function (b) {
    this.year = parseInt(b.substr(0, 4), 10);
    this.month = parseInt(b.toString().substr(4, 2), 10);
    this.day = parseInt(b.toString().substr(6, 2), 10)
};
Despegar.Date.prototype.getServerDate = function (boolAsync, URLServer, callBackFunction) {
    if (URLServer + "X" != "X") {
        this.serverURL = URLServer
    }
    oDate = this;
    var JSON = $.ajax({
        url: this.serverURL,
        async: boolAsync,
        success: function (data) {
            sJSON = data;
            var oJson = eval("(" + sJSON + ")");
            this.parentObj.year = oJson.year;
            this.parentObj.month = oJson.month;
            this.parentObj.day = oJson.day;
            this.callBack()
        },
        parentObj: oDate,
        callBack: callBackFunction
    })
};
Despegar.Date.prototype.compareTo = function (b) {
    var c = this.getiso();
    if (c < b) {
        return -1
    } else {
        if (c == b) {
            return 0
        } else {
            return 1
        }
    }
};
Despegar.Date.prototype.compareToJSDate = function (c) {
    var b = new Despegar.Date();
    b.setDateFromJSDate(c);
    return this.compareTo(b.getiso())
};
Despegar.Date.prototype.compareMonthAndYearTo = function (c) {
    var b = this.getaaaamm();
    if (b < c) {
        return -1
    } else {
        if (b == c) {
            return 0
        } else {
            return 1
        }
    }
};
Despegar.Date.prototype.compareMonthAndYearToJSDate = function (c) {
    var b = new Despegar.Date();
    b.setDateFromJSDate(c);
    return this.compareMonthAndYearTo(b.getaaaamm())
};
Despegar.Date.prototype.getota = function () {
    return Common.Utils.Mask("2000", this.year.toString()) + "-" + Common.Utils.Mask("00", this.month.toString()) + "-" + Common.Utils.Mask("00", this.day.toString())
};
Despegar.Date.prototype.getJSDate = function () {
    return new Date(this.year, this.month - 1, this.day)
};
Despegar.Date.prototype.getFirstDayOfMonthInWeek = function () {
    var c = this.day;
    this.day = 1;
    var b = this.getJSDate();
    var d = b.getDay() + 6;
    d = d % 7;
    this.day = c;
    return d
};
Despegar.Date.prototype.createJSonDate = function (b) {
    var c = Date.UTC(b.getUTCFullYear(), b.getUTCMonth(), b.getUTCDate(), b.getUTCHours(), b.getUTCMinutes(), b.getUTCSeconds(), b.getUTCMilliseconds());
    return "/Date(" + c + ")/"
};
Despegar.Date.prototype.getAmericandDate = function (b) {
    var c = b.split(new RegExp("/", "gi"));
    return c[1] + "/" + c[0] + "/" + c[2]
};
Despegar.Date.prototype.isLeapYear = function () {
    return (this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0
};
Despegar.Date.prototype.isValidDate = function () {
    var b;
    switch (this.month) {
    case 1:
    case 3:
    case 5:
    case 7:
    case 8:
    case 10:
    case 12:
        b = 31;
        break;
    case 4:
    case 6:
    case 9:
    case 11:
        b = 30;
        break;
    case 2:
        if (this.isLeapYear()) {
            b = 29
        } else {
            b = 28
        }
        break;
    default:
        return false
    }
    if (this.day > b || this.day == 0) {
        return false
    }
    return true
};
Despegar.Date.prototype.convertDateToString = function (b) {
    return this.getDaysName(3)[b.getUTCDay()] + " " + b.getUTCDate().toString() + " " + this.getMonthsName(3)[b.getUTCMonth() + 1] + " " + b.getUTCFullYear().toString().substr(2, 2)
};
Despegar.Date.prototype.convertDateToddMMmmaaaa = function (b) {
    return b.getUTCDate().toString() + " " + this.getMonthsName(3)[b.getUTCMonth() + 1] + " " + b.getUTCFullYear()
};
jQuery.fn.indexOf = function (c) {
    for (var b = 0; b < this.length; b++) {
        if (this[b] == c) {
            return b
        }
    }
    return -1
};
(function (c) {
    var b = function (n, u) {
        this.calendars = [];
        this.selected = null;
        this.reference = null;
        this.selecting = false;
        this.element = c(n);
        this.wrapper = c('            <div class="popUpNew hidden">                <div class="opaqueDiv"></div>                <div class="popUpContainer">                    <div class="commonSprite closePopUp closeBlueIcon"></div>                    <span class="topIndicator"></span>                    <div class="popUpContent">                        <div class="datepicker">                            <div class="container" />                            </div>                        </div>                    </div>                </div>');
        this.options = c.extend({
            reference: null,
            locale: "es",
            labels: {
                days: new Despegar.Date(u ? (u.locale || null) : null).getDaysName(2).slice(1),
                months: new Despegar.Date(u ? (u.locale || null) : null).getMonthsName().slice(-12),
                monthsMin: new Despegar.Date(u ? (u.locale || null) : null).getMonthsName(3).slice(-12)
            },
            calendars: 2,
            dateFormat: "d/m/Y",
            currentDate: new Date,
            availableDays: 365,
            anticipationDays: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
            rangeStart: false,
            rangeEnd: false,
            maxDays: false,
            animation: false,
            position: "left",
            paddingTop: 10,
            disableSelection: true,
            disableMonths: true,
            onShow: c.noop,
            onHide: c.noop,
            onPick: c.noop,
            pickerSelector: "div.datepicker",
            calendarSelector: "div.calendar",
            prevArrowSelector: "div.prev",
            nextArrowSelector: "div.next",
            monthAndYearSelector: "span.current",
            viewsSelector: "div.views",
            viewSelector: "div.view",
            viewDaysSelector: "div.view.days",
            viewMonthsSelector: "div.view.months",
            dayPickerSelector: "div.days td.in span",
            monthPickerSelector: "div.months td span"
        }, u);
        var g = function (w) {
            if (w instanceof Date) {
                return w
            }
            var z = w.split(/\D+/g),
                y = s.options.dateFormat.split(/\W+/g),
                B, v, A;
            for (var x = 0; x < z.length; x++) {
                switch (y[x]) {
                case "d":
                    B = parseInt(z[x], 10);
                    break;
                case "m":
                    v = parseInt(z[x], 10) - 1;
                    break;
                case "Y":
                    if (z[x].toString().length == 2) {
                        z[x] = 20 + "" + z[x]
                    }
                    A = parseInt(z[x], 10);
                    break
                }
            }
            var w = new Date(A, v, B, 12);
            if (w.getFullYear() == A && w.getMonth() == v && w.getDate() == B) {
                return w
            }
            return false
        };
        var e = function () {
            var w = c(window);
            var x = s.element.position();
            var v = x.top + s.element.outerHeight();
            var i = x.left;
            if (s.options.position == "right") {
                i -= s.wrapper.outerWidth() - s.element.outerWidth()
            }
            s.wrapper.css({
                top: v + s.options.paddingTop,
                left: i
            })
        };
        var l = function () {
            if (!s.options.reference) {
                return
            }
            var v = s.calendars;
            var i = c(s.options.reference).data("picker");
            if (i && i.selected) {
                if (s.reference != i.selected) {
                    s.reference = i.selected;
                    i.every(function (x, w) {
                        v[w].year = x.year;
                        v[w].month = x.month;
                        v[w].render()
                    })
                }
            }
        };
        var o = function () {
            c(document).one("mousedown", function (i) {
                var v = c(i.target);
                if (!v.is(s.element) && !v.is(s.wrapper) && v.parents(s.options.pickerSelector).length == 0) {
                    s.hide()
                } else {
                    o()
                }
            })
        };
        this.onPressEnter = function (z) {
            var B = s.element.val();
            if (!c.trim(B)) {
                if (this.options.reference) {
                    var w = this.options.reference.data("picker");
                    w.reference = null;
                    w.render()
                }
                this.selected = null;
                this.render()
            }
            var A = s.options.dateFormat.replace(/[a-z]/ig, function (C) {
                switch (C) {
                case "d":
                    return "(0?[1-9]|[12][0-9]|3[01])";
                case "m":
                    return "(0?[1-9]|1[012])";
                case "Y":
                    return "((20)?\\d\\d)"
                }
            });
            if (!(new RegExp("^" + A + "$").test(B))) {
                return
            }
            var i = g(B);
            if (!i) {
                return
            }
            var y = true;
            var x = 0;
            var v = null;
            s.every(function (E, C) {
                if (E.year == i.getFullYear() && E.month == i.getMonth()) {
                    return y = false
                }
                var D = Math.abs(i.getTime() - new Date(E.year, E.month).getTime());
                if (C == 0 || v > D) {
                    v = D;
                    if (C != 0) {
                        x = C
                    }
                }
            });
            if (!s.pick(i, y, z)) {
                s.element.val(s.dateFormat(i)).trigger("change");
                return
            }
            if (y) {
                s.select(s.calendars[x], i.getMonth(), i.getFullYear())
            }
            s.every(function (C) {
                if (C.isMonthsView() && C.year == i.getFullYear() && C.month == i.getMonth()) {
                    C.showDaysView(true)
                }
            });
            s.hide()
        };
        var t = function t() {
            if (t.initialized) {
                return
            }
            s.render();
            t.initialized = true
        };
        this.dateFormat = function (w, z) {
            if (!w) {
                return false
            }
            var v = function (i) {
                return i < 10 ? "0" + i : i
            };
            var y = (z || this.options.dateFormat).split("");
            for (var x = 0; x < y.length; x++) {
                switch (y[x]) {
                case "d":
                    y[x] = v(w.getDate());
                    break;
                case "m":
                    y[x] = v(w.getMonth() + 1);
                    break;
                case "Y":
                    y[x] = w.getFullYear();
                    break;
                case "u":
                    y[x] = w.getTime();
                    break
                }
            }
            return y.join("")
        };
        this.every = function (w) {
            for (var v = 0; v < this.calendars.length; v++) {
                if (false === w.call(this, this.calendars[v], v)) {
                    break
                }
            }
        };
        this.render = function () {
            this.every(function (i) {
                i.render()
            })
        };
        this.show = function () {
            t();
            e();
            l();
            if (this.wrapper.is(":visible")) {
                return
            }
            this.wrapper.stop(true, true).fadeIn(c.browser.msie ? 1 : this.options.animation, function () {
                s.options.onShow.call(s)
            });
            o()
        };
        this.hide = function () {
            this.wrapper.stop(true, true).fadeOut(c.browser.msie ? 1 : this.options.animation, function () {
                if (s.element.val() != s.dateFormat(s.selected)) {
                    s.selected = null;
                    s.render()
                }
                s.options.onHide.call(s)
            })
        };
        this.prev = function () {
            this.every(function (i) {
                i.prev()
            })
        };
        this.next = function () {
            this.every(function (i) {
                i.next()
            })
        };
        this.pick = function (i, v, w) {
            this.selected = null;
            if (!this.validateRange(i)) {
                return false
            }
            if (!w && this.options.onPick.call(this, i) == false) {
                return false
            }
            this.wrapper.find(this.options.dayPickerSelector + ".selected").removeClass("selected");
            this.selected = i;
            this.element.val(this.dateFormat(i)).trigger("change");
            if (!v) {
                this.render()
            }
            return true
        };
        this.select = function (x, w, i) {
            var v = false;
            if (i) {
                i = parseInt(i, 10)
            }
            this.every(function (z, y) {
                if (z === x) {
                    v = y;
                    i = i || z.year
                }
            });
            this.every(function (B, A) {
                var y = w - v + A;
                var C = new Date(B.year, B.month).getTime();
                if (y >= 0) {
                    B.month = y > 11 ? y % 12 : y;
                    B.year = y > 11 ? i + 1 : i
                } else {
                    B.month = 12 + y;
                    B.year = -1 + i
                }
                var z = new Date(B.year, B.month).getTime();
                if (C != z) {
                    B.render(C > z ? "prev" : "next")
                }
            })
        };
        this.update = function (i) {
            if (i.reset) {
                this.options.rangeStart = false;
                this.options.rangeEnd = false;
                this.options.reference = null;
                this.reference = null;
                this.render()
            } else {
                this.options = c.extend(this.options, i)
            }
        };
        this.validateRange = function (i) {
            if (this.reference && this.options.rangeEnd) {
                if (i.getTime() < this.reference.getTime() || (this.options.maxDays && i.getTime() >= (this.reference.getTime() + this.options.maxDays * k))) {
                    return false
                }
            }
            return i.getTime() >= this.dateStart.getTime() && i.getTime() < this.dateLimit.getTime()
        };
        this.getSelected = function (i) {
            if (!this.selected) {
                return false
            }
            return this.dateFormat(this.selected, i)
        };
        this.parseDate = g;
        var s = this;
        var h = g(this.options.currentDate);
        if (!h) {
            return alert(this.options.currentDate + " no es una fecha valida")
        }
        var k = 1000 * 60 * 60 * 24;
        this.currentDate = new Date(h.getFullYear(), h.getMonth(), h.getDate(), 12);
        if (typeof this.options.anticipationDays == "string") {
            this.options.anticipationDays = this.options.anticipationDays.replace(/[-]/g, "/")
        }
        this.dateStart = new Date(this.options.anticipationDays);
        this.dateLimit = new Date(this.dateStart.getTime() + this.options.availableDays * k);
        var r = this.currentDate.getFullYear();
        var q = this.currentDate.getMonth();
        var f = this.wrapper.find("div.container");
        for (var m = 0; m < this.options.calendars; m++) {
            this.calendars[m] = new d(this, r, q);
            this.calendars[m].wrapper.appendTo(f);
            r += q == 11 ? 1 : 0;
            q += q == 11 ? -11 : 1
        }
        f.find("> div:first").addClass("first").end().find("> div:last").addClass("last");
        if (this.options.selected) {
            var p = g(this.options.selected);
            if (this.pick(p, false, true)) {
                this.select(this.calendars[0], p.getMonth(), p.getFullYear())
            }
        }
        this.element.on("focus", function () {
            s.show()
        }).on("keydown", function (i) {
            if (13 == i.keyCode) {
                s.onPressEnter()
            }
        });
        c(window).on("resize", function () {
            e()
        });
        c(document).on("keydown", function (i) {
            if (9 == i.keyCode || 27 == i.keyCode) {
                s.hide()
            }
        });
        if (this.options.disableSelection) {
            this.wrapper.attr("unselectable", "on").css({
                "user-select": "none",
                "-moz-user-select": "none",
                "-webkit-user-select": "none",
                "-ms-user-select": "none"
            }).each(function () {
                this.onselectstart = function () {
                    return false
                }
            })
        }
        this.wrapper.attr("id", this.element.attr("id") + "-datepicker").on("mousedown", function () {
            s.selecting = true
        }).on("mouseup", function () {
            s.selecting = false
        }).insertAfter(this.element)
    };
    var d = function (g, m, i) {
        var q = "days";
        var p = "months";
        this.picker = g;
        this.year = m;
        this.month = i;
        this.view = q;
        this.wrapper = c('<div class="calendar" />');
        this.template = '<div class="prev{{if !prev}} disabled{{/if}}">    <span class="prevArrow"></span></div><div class="ctn-dates"><div class="head">    <span class="current month-${month} year-${year}">${year} ${monthName}</span></div><div class="views">    <div class="view days">        <table>            <thead>                <tr>                {{each labels.days}}                    <th>${$value}</th>                {{/each}}                </tr>            </thead>            <tbody class="month-${month}">                <tr class="first">            {{each(x, day) days}}                {{if x != 0 && x % 7 == 0}}                </tr>                <tr>                {{/if}}                    <td class="${day.own}"><span class="${day.own} day-${num}{{if day.ext}} ${day.ext}{{/if}}">${day.num}</span></td>            {{/each}}                </tr>            </tbody>        </table>    </div>    <div class="view months">        <table>            <tbody>                <tr>            {{each(x, name) labels.months}}                {{if x != 0 && x % 4 == 0}}                </tr>                <tr>                {{/if}}                    <td><span class="month-${x}{{if x == month }} selected{{/if}}">${name}</span></td>            {{/each}}                </tr>            </tbody>        </table>    </div></div></div><div class="next{{if !next}} disabled{{/if}}">    <span class="nextArrow"></span></div>';
        var e = function (t, u) {
            return 32 - new Date(t, u, 32, 12).getDate()
        };
        var k = function (t) {
            var v = [];
            var u = new Date(l.year, l.month, t, 12);
            if (u.getDay() == 0 || u.getDay() == 6) {
                v.push("weekend")
            }
            if (l.picker.currentDate.getTime() == u.getTime()) {
                v.push("today")
            }
            if (l.picker.selected && l.picker.selected.getTime() == u.getTime()) {
                v.push("selected")
            }
            if (l.picker.reference && l.picker.reference.getTime() == u.getTime()) {
                v.push("referenced")
            }
            if (l.picker.reference && l.picker.selected) {
                if ((l.picker.options.rangeStart && u.getTime() <= l.picker.reference.getTime() && u.getTime() >= l.picker.selected.getTime()) || (l.picker.options.rangeEnd && u.getTime() >= l.picker.reference.getTime() && u.getTime() <= l.picker.selected.getTime())) {
                    v.push("in-range")
                }
            }
            if (!l.picker.validateRange(u)) {
                v.push("disabled")
            }
            return v
        };
        var r = function () {
            var w = e(l.month == 11 ? l.year - 1 : l.year, l.month == 0 ? 11 : l.month - 1);
            var t = e(l.year, l.month);
            var v = new Date(l.year, l.month, 1, 12).getDay() || 7;
            v = v == 1 ? 8 : v;
            for (var A = 1, z = 1, y = 1, B = [], x, C, u; B.length < 42; u = null) {
                if (A < v) {
                    x = w - v + (++A);
                    C = "not-in"
                } else {
                    if (z > t) {
                        x = y++;
                        C = "not-in"
                    } else {
                        C = "in";
                        u = k(x = z++)
                    }
                }
                B.push({
                    num: x,
                    own: C,
                    ext: (u || []).join(" ")
                })
            }
            return B
        };
        var o = function () {
            return jQuery.tmpl(l.template, {
                year: l.year,
                month: l.month,
                monthName: l.picker.options.labels.months[l.month],
                days: r(),
                labels: {
                    days: l.picker.options.labels.days,
                    months: l.picker.options.labels.monthsMin
                },
                prev: !l.picker.options.disableMonths || h(l.month - 1),
                next: !l.picker.options.disableMonths || h(l.month + 1)
            })
        };
        var h = function (t) {
            return l.picker.validateRange(new Date(l.year, t, 1, 12)) || l.picker.validateRange(new Date(l.year, t, e(l.year, t), 12))
        };
        var f = function (t) {
            return function () {
                if (!c(this).hasClass("disabled")) {
                    t.call(this)
                }
                return false
            }
        };
        var n = function (t) {
            return parseInt(c(t).attr("class").replace(/\D+/g, ""), 10)
        };
        this.prev = function () {
            this.year -= this.month == 0 ? 1 : 0;
            this.month -= this.month == 0 ? -11 : 1;
            this.render("prev")
        };
        this.next = function () {
            this.year += this.month == 11 ? 1 : 0;
            this.month += this.month == 11 ? -11 : 1;
            this.render("next")
        };
        this.render = function (u) {
            var w = o();
            var z = true;
            this.picker.every(function (B) {
                return z = B.isMonthsView()
            });
            if (this.wrapper.children().length == 0 || !u || !this.picker.options.animation || z) {
                this.wrapper.empty().append(w);
                this.showCurrentView()
            } else {
                var y = w.find(l.picker.options.viewDaysSelector).find("table");
                var t = this.wrapper.find(l.picker.options.viewsSelector);
                var v = t.width();
                var A = t.find(l.picker.options.viewDaysSelector);
                var x = function () {
                    l.wrapper.empty().append(w.find(l.picker.options.viewDaysSelector).append(y).end());
                    l.showCurrentView()
                };
                if (u == "prev") {
                    if (l.isDaysView()) {
                        t.find(l.picker.options.viewMonthsSelector).css({
                            left: v
                        })
                    }
                    A.prepend(y).parent().scrollLeft(v).animate({
                        scrollLeft: 0
                    }, l.picker.options.animation, x)
                } else {
                    A.append(y).parent().animate({
                        scrollLeft: v
                    }, l.picker.options.animation, x)
                }
            }
        };
        this.showView = function (t, u) {
            if (!u) {
                this.wrapper.find(l.picker.options.viewSelector).hide().end().find(l.picker.options.viewSelector + "." + t).show()
            } else {
                this.wrapper.find(l.picker.options.viewSelector + "." + this.view).fadeOut(u).end().find(l.picker.options.viewSelector + "." + t).fadeIn(u)
            }
            this.view = t
        };
        this.toggleView = function () {
            this.showView(this.isDaysView() ? p : q, this.picker.options.animation)
        };
        this.isDaysView = function () {
            return this.view == q
        };
        this.showDaysView = function (t) {
            this.showView(q, t ? this.picker.options.animation : false)
        };
        this.isMonthsView = function () {
            return this.view == p
        };
        this.showMonthsView = function (t) {
            this.showView(p, t ? this.picker.options.animation : false)
        };
        this.showCurrentView = function () {
            this[this.isMonthsView() ? "showMonthsView" : "showDaysView"]()
        };
        var l = this;
        var s = this.picker.options;
        this.wrapper.on("click", s.prevArrowSelector, f(function () {
            l.picker.prev()
        })).on("click", s.nextArrowSelector, f(function () {
            l.picker.next()
        })).on("click", s.monthAndYearSelector, f(function () {
            l.toggleView()
        })).on("click", s.monthPickerSelector, f(function () {
            l.toggleView();
            l.wrapper.find(s.monthPickerSelector + ".month-" + l.month).removeClass("selected");
            l.picker.select(l, n(c(this).addClass("selected")))
        })).on("click", s.dayPickerSelector + ":not(.disabled)", f(function () {
            if (l.picker.pick(new Date(l.year, l.month, n(this), 12))) {
                l.picker.hide()
            }
        }))
    };
    jQuery.fn.datePicker = function (e) {
        return this.each(function () {
            var f = c(this).data("picker");
            if (f) {
                f.update(e)
            } else {
                c(this).data("picker", new b(this, e))
            }
        })
    }
})(jQuery);
registerNameSpace("FrameworkJS.Common");
FrameworkJS.Common.AutocompleteGlobalCache = function (b) {
    this.options = b || {};
    this.options.matchStartOnly = this.options.matchStartOnly || true;
    this.options.type = this.options.type || "general";
    this.options.splitBy = this.options.splitBy || ", -();:.";
    this.cache = new Array();
    this.cache[this.options.type] = {
        data: {},
        preCache: {}
    }
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.addType = function (b) {
    if (!FrameworkJS.Common.AutocompleteGlobalCache.cache[b]) {
        FrameworkJS.Common.AutocompleteGlobalCache.cache[b] = {
            data: {},
            preCache: {}
        }
    }
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.loadFromCache = function (k, i, d, h, l) {
    if (l == undefined) {
        l = FrameworkJS.Common.AutocompleteGlobalCache.options.type
    }
    if (!k) {
        return null
    }
    if (FrameworkJS.Common.AutocompleteGlobalCache.cache[l].data[k]) {
        return FrameworkJS.Common.AutocompleteGlobalCache.cache[l].data[k]
    }
    if (h) {
        var m = false;
        var g = k.substr(0, i);
        var e = FrameworkJS.Common.AutocompleteGlobalCache.cache[l].data[g];
        if (!e && FrameworkJS.Common.AutocompleteGlobalCache.cache[l].preCache.length > 0) {
            e = FrameworkJS.Common.AutocompleteGlobalCache.cache[l].preCache;
            m = true
        }
        if (e) {
            var b = [];
            b.cachedBefore = m;
            var c = FrameworkJS.Common.AutocompleteGlobalCache.splitString(k, this.options.splitBy);
            for (var f = 0; f < e.length; f++) {
                var n = e[f];
                if (FrameworkJS.Common.AutocompleteGlobalCache.matchSubset(n.m + ", " + n.n + ", " + n.a, c, d)) {
                    b[b.length] = n
                }
            }
            return b.length > 0 || !b.cachedBefore ? b : null
        }
    }
    return null
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.addToCache = function (d, c, b) {
    if (b == undefined) {
        b = FrameworkJS.Common.AutocompleteGlobalCache.options.type
    }
    if (!c || !d) {
        return
    }
    FrameworkJS.Common.AutocompleteGlobalCache.cache[b].data[d] = c
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.accentInsentiveRegex = function (b) {
    var d = "";
    for (var c = 0; c < b.length; c++) {
        switch (b.charAt(c)) {
        case "a":
        case "á":
        case "A":
        case "Á":
        case "ã":
        case "Ã":
        case "â":
        case "Â":
            d += "[aáãâ]";
            break;
        case "e":
        case "é":
        case "E":
        case "É":
        case "ê":
        case "Ê":
            d += "[eéê]";
            break;
        case "i":
        case "í":
        case "I":
        case "Í":
            d += "[ií]";
            break;
        case "o":
        case "ó":
        case "O":
        case "Ó":
        case "õ":
        case "Õ":
        case "ô":
        case "Ô":
            d += "[oóõô]";
            break;
        case "u":
        case "ú":
        case "U":
        case "Ú":
            d += "[uú]";
            break;
        default:
            d += b.charAt(c);
            break
        }
    }
    return d
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.splitString = function (b, h) {
    var d = new RegExp("[" + h + "]", "ig");
    var b = b.replace(d, "|");
    var g = b.split("|");
    var f = new Array();
    var c = 0;
    for (var e = 0; e < g.length; e++) {
        if (jQuery.trim(g[e]) != "") {
            f[c] = g[e];
            c++
        }
    }
    return f
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.matchSubset = function (d, g, h, f) {
    var e = false;
    for (j = 0; j < g.length; j++) {
        var b = new RegExp(FrameworkJS.Common.AutocompleteGlobalCache.accentInsentiveRegex(g[j]));
        if (!h) {
            d = d.toLowerCase()
        }
        var c = d.search(b);
        if (c == -1) {
            e = false
        }
        if (c > -1) {
            e = true
        }
        if (e && FrameworkJS.Common.AutocompleteGlobalCache.options.matchStartOnly) {
            b = new RegExp(FrameworkJS.Common.AutocompleteGlobalCache.accentInsentiveRegex("(^" + g[j] + ")|([" + this.options.splitBy + "]" + g[j] + ")"));
            c = d.search(b);
            if (c == -1) {
                e = false
            }
        }
        if (!e) {
            break
        }
    }
    return e
};
FrameworkJS.Common.AutocompleteGlobalCache.prototype.preCache = function (b, c) {
    if (c == undefined) {
        c = this.options.type
    }
    FrameworkJS.Common.AutocompleteGlobalCache.cache[c].preCache = b
};
registerNameSpace("FrameworkJS.Common");
FrameworkJS.Common.Autocomplete = function (l, g) {
    this.options = window._options || {};
    this.options.splitBy = this.options.splitBy || ", ();:.";
    var r = g.minChars;
    var u;
    var c = true;
    var q;
    var v = 0;
    var n;
    this.liData = [];
    setTimer = function (x) {
        if (g.timeOut != 0) {
            if (u != undefined) {
                clearTimeout(u)
            }
            u = setTimeout(function () {
                x()
            }, g.timeOut)
        }
    };
    $.fn.autocomplete.initialValue = function (x, y) {
        w.initialValue(x, y)
    };
    this.initialValue = function (A, C, x, z, B) {
        var y = A;
        if (g.showValue && C != "" && C != undefined && !z) {
            y = y + " (" + C + ")"
        }
        $(l).val(y);
        $(l).data("dataValue", C);
        $(l).data("dataReference", C);
        $(l).data("dataType", x);
        $(l).data("typeSelected", B)
    };
    this.hideResultsNow = function () {
        if (k) {
            clearTimeout(k)
        }
        if (f.is(":visible")) {
            f.html("");
            f.hide();
            if (m) {
                m.hide()
            }
        }
    };
    this.trim = function (z) {
        if (g.respMinChars) {
            var z = z.replace(/^\s\s*/, ""),
                x = /\s/,
                y = z.length;
            while (x.test(z.charAt(--y))) {}
            return z.slice(0, y + 1)
        } else {
            return z
        }
    };
    this.onChange = function () {
        timerReady = false;
        g.minChars = r;
        if (s == 46 || (s > 8 && s < 32)) {
            if (m) {
                m.hide()
            }
            return f.hide()
        }
        if (s > 45 && s < 112) {
            d.data("dataValue", "");
            d.data("dataType", g.initialType)
        }
        var B = w.trim(d.val());
        if (B == o) {
            return
        }
        o = B;
        if (B.length >= g.minChars) {
            var z = this;
            var A = B;
            z.requestData(A)
        } else {
            f.hide();
            if (m) {
                m.hide()
            }
            if (g.minCharsLeyend) {
                f.html("");
                var y = document.createElement("ul");
                var x = document.createElement("li");
                x.innerHTML = w.labels[g.languaje]["minCharsText1"] + g.minChars + w.labels[g.languaje]["minCharsText2"];
                y.appendChild(x);
                $(x).addClass("minCharsLeyend");
                f.append(y);
                this.showResults()
            }
        }
        d.removeClass("default")
    };
    this.moveSelect = function (y) {
        var x = $("li:visible", f);
        if (!x) {
            return
        }
        h += y;
        if (h < 0) {
            h = 0
        } else {
            if (h >= x.length) {
                h = x.length - 1
            }
        }
        x.removeClass(g.liOverClass);
        $(x[h]).addClass(g.liOverClass);
        if (h > g.maxItemsToShow - 1 || (this.scrollNum != 0)) {
            if ((this.scrollNum >= -1 && y > 0)) {
                x[h].scrollIntoView(false)
            }
            if (y == -1 && this.scrollNum > 0) {
                this.scrollNum = 0
            }
            if (this.scrollNum > ((-1) * (g.maxItemsToShow)) || y == 1) {
                this.scrollNum = this.scrollNum + y
            }
            if (this.scrollNum <= ((-1) * (g.maxItemsToShow))) {
                x[h].scrollIntoView(true)
            }
        }
    };
    this.selectCurrent = function () {
        var y = false;
        var A = false;
        var x = $("li." + g.liOverClass, f)[0];
        if (!x) {
            A = true;
            var z;
            if (g.selectOnly) {
                z = $("li", f);
                if (z.length == 1) {
                    x = z[0]
                }
            } else {
                if (g.selectFirst) {
                    z = $("li:first", f);
                    x = z[0]
                }
            }
        }
        if (x) {
            if ($(x).hasClass("additionalOptions")) {
                if (!A) {
                    $(x).click()
                }
                y = false
            } else {
                if ($(x).hasClass("moreOptions")) {
                    y = true
                } else {
                    if ($(x).hasClass("minCharsLeyend")) {
                        y = false
                    } else {
                        this.selectItem(x);
                        y = false
                    }
                }
            }
            return y
        } else {
            return false
        }
    };
    this.selectItem = function (y) {
        c = true;
        var x;
        var A;
        var z;
        if (!y) {
            x = "";
            A = "";
            z = g.initialType
        } else {
            if ($(y).hasClass("noSelectable")) {
                if (c) {
                    i($(y).find("a"));
                    c = false
                }
            } else {
                x = this.liData[y.id][0];
                A = this.liData[y.id][1];
                z = this.liData[y.id][2];
                a = this.liData[y.id][3]
            }
        } if (c) {
            d.data("lastSelected", x);
            if (g.faceted) {
                d.data("typeSelected", $(y).parent().attr("class").split("Lista")[1].substr(0, 1))
            }
            o = x;
            d.val(x);
            if (g.showValue) {
                d.val(d.val() + " (" + A + ")")
            }
            d.data("dataValue", A);
            d.data("dataType", z);
            d.data("dataReference", a);
            if (A.length == 3 && g.callBackFunction) {
                g.callBackFunction()
            }
        }
    };
    this.createSelection = function (A, y) {
        var z = d.get(0);
        if (z.createTextRange) {
            var x = z.createTextRange();
            x.collapse(true);
            x.moveStart("character", A);
            x.moveEnd("character", y);
            x.select()
        } else {
            if (z.setSelectionRange) {
                z.setSelectionRange(A, y)
            } else {
                if (z.selectionStart) {
                    z.selectionStart = A;
                    z.selectionEnd = y
                }
            }
        }
        z.focus()
    };
    this.autoFill = function (x) {
        if (s != 8) {
            d.val(d.val() + x.substr(o.length));
            this.createSelection(o.length, x.length)
        }
    };
    this.showResults = function () {
        var z = this.findPos(l);
        var y = parseInt(d.width() + 4) + "px";
        f.css({
            width: y
        }).children().css({
            width: 100 + "%"
        });
        f.css({
            top: (z.y + l.offsetHeight) + "px",
            left: z.x + "px"
        });
        f.show();
        if (m) {
            var y = $("ul", f).width() - 10 + "px";
            var x = $("ul", f).height() + "px";
            m.css({
                width: y,
                height: x,
                top: (z.y + l.offsetHeight) + "px",
                left: z.x + "px",
                zIndex: "500",
                position: "absolute"
            }).show()
        }
    };
    this.hideResults = function () {
        if (k) {
            clearTimeout(k)
        }
        k = setTimeout(this.hideResultsNow, 0)
    };
    this.receiveData = function (E, A) {
        if ((!e && (!A.cachedBefore || !g.showMoreResults)) || (A == null && g.additionalOptions.length == 0)) {
            return this.hideResultsNow()
        }
        if (A.getingCache) {
            A.cachedBefore = false;
            A.getingCache = false
        }
        var x = "";
        f.html("");
        if (g.faceted) {
            var y = [];
            $.each(A, function (H, J) {
                if (x != J.c) {
                    if (x != "" && H != 0) {
                        var G = document.createElement("ul");
                        f.append(G);
                        $(G).addClass("Lista" + A[H - 1].c).addClass("facetedList");
                        if (($(".ac_results ul").length / 2) != parseInt($(".ac_results ul").length / 2)) {
                            $(G).addClass("evenList")
                        }
                        var I = q.type[g.languaje][A[H - 1].c];
                        w.dataToDom(y, E, G, I)
                    }
                    x = J.c;
                    y = []
                }
                y.push(J);
                if (J.s != undefined) {
                    $.each(J.s, function (K, L) {
                        L.r = true;
                        y.push(L)
                    })
                }
            });
            var D = document.createElement("ul");
            f.append(D);
            var F;
            $.each(y, function (G, H) {
                if (H.c != "s") {
                    F = q.type[g.languaje][H.c];
                    $(D).addClass("Lista" + H.c);
                    if (($(".ac_results ul").length / 2) != parseInt($(".ac_results ul").length / 2)) {
                        $(D).addClass("evenList");
                        if (!$(D).hasClass("facetedList")) {
                            $(D).addClass("facetedList")
                        }
                    }
                }
            });
            w.dataToDom(y, E, D, F)
        } else {
            var D = document.createElement("ul");
            f.append(D);
            w.dataToDom(A, E, D)
        } if (g.autoFill && (d.val().toLowerCase() == E.toLowerCase())) {
            this.autoFill(A[0].n)
        }
        this.showResults();
        if (A != null) {
            if (A.length > g.maxItemsToShow) {
                $li = f.children("ul").children("li:eq(0)");
                var C = $li.outerHeight();
                for (var B = 1; B < g.maxItemsToShow; B++) {
                    $li = $li.next();
                    C = C + $li.outerHeight()
                }
                var z = f.children("ul").height(C).css("overflow-y", "auto").css("overflow-x", "hidden");
                if (g.faceted) {
                    z.css("overflow-y", "hidden")
                }
                if (m) {
                    m.height(C + 2)
                }
            }
            if (A.length == 0) {
                w.showNoResultsError()
            }
        } else {
            w.showNoResultsError()
        }
        $(".typeItem:first").addClass("itemFirst");
        $(".typeItem:last").addClass("itemLast");
        $(".evenList:first").addClass("evenFirst");
        if ($(".evenList:last") == $(".ac_results ul:last")) {
            $(".evenList:last").addClass("evenLast")
        }
        $(".ac_results li:visible:first").addClass("liFirst");
        $(".ac_results li:visible:last").addClass("liLast")
    };
    this.dataToDom = function (B, H, G, I) {
        if (B) {
            I = I || "";
            if (g.faceted) {
                $(G).append('<div class="typeItem"><span>' + I + "</span></div>")
            }
            if (g.respMinChars) {
                H = H.replace(/-/gi, " ")
            }
            var C = B.length;
            var F = 0;
            var y = FrameworkJS.Common.AutocompleteGlobalCache.splitString(H, this.options.splitBy);
            var E = "";
            for (j = 0; j < y.length; j++) {
                E += "(" + FrameworkJS.Common.AutocompleteGlobalCache.accentInsentiveRegex(y[j]) + ")";
                if (j < y.length - 1) {
                    E += "|"
                }
            }
            var D = H.length;
            var L = new RegExp(E, "ig");
            var z = "";
            var M = "";
            var J = 0;
            for (var A = v; A < (v + C); A++) {
                J++;
                var N = B[A - v];
                if (!N) {
                    continue
                }
                if (N.r != undefined) {
                    z = ("<li id='" + l.id + A + "' class = 'subitem item" + M + "' style='display:none;'>")
                } else {
                    M = A;
                    if (N.s != undefined) {
                        z = ("<li id='" + l.id + A + "' class='noSelectable'><a class='more clossed'></a>")
                    } else {
                        z = ("<li id='" + l.id + A + "'>")
                    }
                }
                var x = "";
                for (j = 1; j <= y.length; j++) {
                    x += "$" + j
                }
                z += "<span>" + N.n.replace(L, "<b>" + x + "</b>");
                if (g.showValue) {
                    z += " (" + N.m.toUpperCase() + ")"
                }
                z += "</span>";
                z += "</li>";
                $(G).append(z);
                this.liData[l.id + A] = new Array(3);
                this.liData[(l.id + A)][0] = N.n;
                this.liData[(l.id + A)][1] = N.m;
                this.liData[(l.id + A)][2] = N.t;
                this.liData[(l.id + A)][3] = N.a
            }
            v += J;
            $(G).children("li").hover(function () {
                $("li." + g.liOverClass, G).removeClass(g.liOverClass);
                $(this).addClass(g.liOverClass)
            }, function () {
                $(this).removeClass(g.liOverClass)
            })
        }
        if (g.additionalOptions.length > 0) {
            for (var A = 0; A < g.additionalOptions.length; A++) {
                var K = document.createElement("li");
                K.innerHTML = g.additionalOptions[A].text;
                G.appendChild(K);
                $(K).addClass("additionalOptions").hover(function () {
                    $("li", G).removeClass(g.liOverClass);
                    $(this).addClass(g.liOverClass);
                    h = $("li", G).indexOf($(this).get(0))
                }, function () {
                    $(this).removeClass(g.liOverClass)
                }).bind("click", g.additionalOptions[A].callbackFunction)
            }
        }
        if (B.cachedBefore && g.showMoreResults) {
            var K = document.createElement("li");
            K.innerHTML = w.labels[g.languaje]["seeMoreResultsText"];
            G.appendChild(K);
            $(K).addClass("moreOptions").hover(function () {
                $("li", G).removeClass(g.liOverClass);
                $(this).addClass(g.liOverClass);
                h = $("li", G).indexOf($(this).get(0))
            }, function () {
                $(this).removeClass(g.liOverClass)
            })
        }
    };
    this.showMoreResults = function () {
        this.searchResults(d.val())
    };
    this.requestData = function (y) {
        if (!g.matchCase) {
            y = y.toLowerCase()
        }
        if (g.respMinChars) {
            g.minChars = $(l).val().length
        }
        var x = (g.noCache) ? null : FrameworkJS.Common.AutocompleteGlobalCache.loadFromCache(y, g.minChars, g.matchCase, g.matchSubset, g.type);
        if (x) {
            w.receiveData(y, x)
        } else {
            if ((typeof g.url == "string") && (g.url.length > 0)) {
                if (g.timeOut != 0) {
                    setTimer(function () {
                        w.searchResults(y)
                    })
                } else {
                    w.searchResults(y)
                }
            }
        }
    };
    this.convertXMLtoJSON = function (x) {
        oJSON = new Array();
        $("option", x).each(function (y) {
            oJSON.push({
                a: $(this).attr("a"),
                m: $(this).attr("m"),
                n: $(this).attr("n"),
                t: $(this).attr("t")
            })
        });
        return oJSON
    };
    this.searchResults = function (y) {
        y = w.trim(y);
        if (g.noStrangeCharacters) {
            y = y.toLowerCase().replace(/[á|à|ä|â|ã]/gi, "a").replace(/[é|è|ë|ê]/gi, "e").replace(/[í|ì|ï|î]/gi, "i").replace(/[ó|ò|ö|ô|õ]/gi, "o").replace(/[ú|ù|ü|û]/gi, "u").replace(/[ñ]/gi, "n").replace(/[^\w\s]/gi, "").replace(/ç/gi, "c").replace(/&/gi, "y")
        }
        if (!g.respMinChars) {
            var x = this.makeUrl(y.substr(0, r).replace(/ /gi, "-"))
        } else {
            var x = this.makeUrl(y.replace(/ /gi, "-"))
        } if (y.length >= r) {
            $.ajax({
                type: "GET",
                dataType: g.serviceType.toLowerCase(),
                url: x,
                success: function (z) {
                    if (g.serviceType == "XML") {
                        z = w.convertXMLtoJSON(z)
                    } else {
                        if (g.serviceType == "JSON") {
                            if (z.data) {
                                z = z.data
                            }
                        }
                    }
                    FrameworkJS.Common.AutocompleteGlobalCache.addToCache(y.substr(0, g.minChars), z, g.type);
                    if (y.length > g.minChars && !g.respMinChars) {
                        z = FrameworkJS.Common.AutocompleteGlobalCache.loadFromCache(y, g.minChars, g.matchCase, g.matchSubset, g.type)
                    }
                    z.cachedBefore = true;
                    z.getingCache = true;
                    w.receiveData(y, z)
                },
                error: function (z, B, A) {
                    $(l).data("dataValue", "");
                    w.showNoResultsError();
                    if (window.console) {
                        console.error("Hubo un error en el servicio de AutoComplete ", z, B, A)
                    }
                }
            })
        }
    };
    this.showNoResultsError = function () {
        f.hide();
        if (m) {
            m.hide()
        }
        if (g.noResultsError) {
            f.html("");
            var y = document.createElement("ul");
            var x = document.createElement("li");
            x.innerHTML = g.noResultsError + $(l).val();
            y.appendChild(x);
            $(x).addClass("minCharsLeyend");
            f.append(y);
            w.showResults()
        }
    };
    this.getExtraParamValue = function (x) {
        if (typeof x != "function") {
            return x
        } else {
            return x()
        }
    };
    this.makeUrl = function (A) {
        var y = g.url;
        if (!g.useQueryString) {
            for (var z in g.extraParamsValue) {
                var x = this.getExtraParamValue(g.extraParamsValue[z]);
                if (g.faceted) {
                    if (z == 0) {
                        if (g.prodCode != "") {
                            y += g.prodCode + "/"
                        }
                        y += encodeURI(x)
                    } else {
                        if (x === "es" || x === "pt") {
                            y += "/" + encodeURI(x)
                        } else {
                            y += g.separatorFacetedParams + encodeURI(x)
                        }
                    }
                } else {
                    y += "/" + encodeURI(x)
                }
            }
            y += "/" + encodeURI(A);
            y += g.showNoPublished != undefined ? "/" + g.showNoPublished : ""
        } else {
            y = y + "?";
            for (var z in g.extraParamsValue) {
                var x = this.getExtraParamValue(g.extraParamsValue[z]);
                var B = g.extraParamsName[z] ? g.extraParamsName[z] : "param" + [z];
                y += B + "=" + encodeURI(x) + "&"
            }
            y += g.extraParamSearchPatternName + "=" + encodeURI(A)
        }
        return y
    };
    this.findPos = function (y) {
        var z = y.offsetLeft || 0;
        var x = y.offsetTop || 0;
        while (y = y.offsetParent) {
            z += y.offsetLeft;
            x += y.offsetTop
        }
        return {
            x: z,
            y: x
        }
    };
    this.labels = {
        es: {
            seeMoreResultsText: "See more resutls...",
            noResultsError: "Cities not found matching with: ",
            minCharsText1: "At least, input the first ",
            minCharsText2: " leters and wait the results"
        },
        pt: {
            seeMoreResultsText: "Ver mais resultados...",
            noResultsError: "Não foram encontradas cidades que contenham ",
            minCharsText1: "Por favor insira as primeiras ",
            minCharsText2: " letras  e aguarde para ver os resultados"
        }
    };
    g = g || {};
    g.languaje = g.languaje || "es";
    g.url = g.url || "";
    g.useQueryString = g.useQueryString || false;
    g.extraParams = g.extraParams || [];
    g.extraParamsName = g.extraParamsName || [];
    g.extraParamsValue = g.extraParamsValue || g.extraParams;
    g.extraParamSearchPatternName = g.extraParamSearchPatternName || "pattern";
    g.inputClass = g.inputClass || "ac_input";
    g.initialText = g.initialText || "";
    g.initialValue = g.initialValue || "";
    g.initialType = g.initialType || "1";
    g.initialTypeSelected = g.initialTypeSelected || "";
    g.noResultsError = g.noResultsError || this.labels[g.languaje]["noResultsError"];
    g.autoFill = g.autoFill || false;
    g.resultsClass = g.resultsClass || "ac_results";
    g.liOverClass = g.liOverClass || "ac_over";
    g.minChars = g.minChars || 3;
    g.minCharsLeyend = g.minCharsLeyend || false;
    g.delay = g.delay || 100;
    g.matchCase = g.matchCase || 0;
    g.matchSubset = g.matchSubset || 1;
    g.selectFirst = g.selectFirst || true;
    g.selectOnly = g.selectOnly || false;
    g.maxItemsToShow = g.maxItemsToShow || 10;
    g.classListWidth = g.classListWidth || false;
    g.additionalOptions = g.additionalOptions || [];
    g.showValue = g.showValue || false;
    g.preCacheData = g.preCacheData || {};
    g.showMoreResults = g.showMoreResults || false;
    g.type = g.type || "general";
    g.serviceType = g.serviceType || "JSON";
    g.callBackFunction = g.callBackFunction || false;
    g.respMinChars = g.respMinChars || false;
    g.timeOut = g.timeOut || 0;
    g.faceted = g.faceted || false;
    g.configUrl = g.configUrl || "";
    g.noStrangeCharacters = g.noStrangeCharacters || false;
    g.cityMaxRows = g.cityMaxRows || 0;
    g.administrativeDivisionMaxRows = g.administrativeDivisionMaxRows || 0;
    g.countryMaxRows = g.countryMaxRows || 0;
    g.interestPointMaxRows = g.interestPointMaxRows || 0;
    g.airportMaxRows = g.airportMaxRows || 0;
    g.hotelMaxRows = g.hotelMaxRows || 0;
    g.portMaxRows = g.portMaxRows || 0;
    g.pierMaxRows = g.pierMaxRows || 0;
    g.paramsInUrl = g.paramsInUrl || false;
    g.separatorFacetedParams = g.separatorFacetedParams || "-";
    g.prodCode = g.prodCode || "";
    g.noCache = g.noCache || false;
    if (g.configUrl != "") {
        $.ajax({
            url: g.configUrl,
            dataType: "json",
            async: "false",
            type: "GET",
            contentType: "application/json",
            success: function (x) {
                q = x
            }
        })
    } else {
        if (g.faceted) {
            q = {
                type: {
                    es: {
                        c: "Cities",
                        d: "State/Province",
                        p: "Countries",
                        h: "Hotels",
                        i: "Point of interest",
                        a: "Airport"
                    },
                    pt: {
                        c: "Cidades",
                        d: "Estado/Província",
                        p: "Países",
                        h: "Hotéis",
                        i: "Pontos de Interesse",
                        a: "Aeroporto"
                    }
                }
            }
        }
    } if (g.faceted && !g.paramsInUrl) {
        if (g.extraParamsValue.length == 1) {
            var t = g.extraParamsValue.shift();
            g.extraParamsValue.push(g.cityMaxRows, g.administrativeDivisionMaxRows, g.countryMaxRows, g.interestPointMaxRows, g.airportMaxRows, g.hotelMaxRows, g.portMaxRows, g.pierMaxRows, t)
        } else {
            g.extraParamsValue.push(g.cityMaxRows, g.administrativeDivisionMaxRows, g.countryMaxRows, g.interestPointMaxRows, g.airportMaxRows, g.hotelMaxRows, g.portMaxRows, g.pierMaxRows)
        }
    }
    var w = this;
    if (typeof FrameworkJS.Common.AutocompleteGlobalCache != "object") {
        FrameworkJS.Common.AutocompleteGlobalCache = new FrameworkJS.Common.AutocompleteGlobalCache({
            type: g.type
        })
    } else {
        FrameworkJS.Common.AutocompleteGlobalCache.addType(g.type)
    } if (g.preCacheData.length > 0) {
        FrameworkJS.Common.AutocompleteGlobalCache.preCache(g.preCacheData, g.type)
    }
    var d = $(l);
    if (g.inputClass) {
        d.addClass(g.inputClass)
    }
    var m = null;
    if (($.browser.msie) && (parseInt($.browser.version) < 7)) {
        m = $("<iframe></iframe>").appendTo($("body"))
    }
    var p = document.createElement("div");
    p.id = "results-" + d.attr("id");
    var f = $(p);
    f.hide().addClass(g.resultsClass).css({
        position: "absolute",
        "z-index": 1002
    });
    if (m) {
        m.hide()
    }
    f.children("ul:last").children("li").live("click", function (x) {
        x.preventDefault();
        x.stopPropagation();
        w.selectItem(this)
    });

    function i(x) {
        if (c) {
            x.parent().removeClass("liLast");
            c = false;
            if (x.hasClass("clossed")) {
                x.removeClass("clossed").addClass("opened");
                $(".item" + x.parent().attr("id")).show()
            } else {
                x.removeClass("opened").addClass("clossed");
                $(".ac_results li:visible:last").addClass("liLast");
                $(".item" + x.parent().attr("id")).hide()
            }
        }
    }
    $(".more").live("click", function () {
        i($(this))
    });
    $("body").append(f);
    l.autocompleter = w;
    var k = null;
    var o = "";
    var h = -1;
    var e = false;
    var s = null;
    this.initialValue(g.initialText, g.initialValue, g.initialType, false, g.initialTypeSelected);
    this.scrollNum = 0;
    this.liData = [];
    d.keydown(function (x) {
        s = x.keyCode;
        switch (x.keyCode) {
        case 38:
            x.preventDefault();
            w.moveSelect(-1);
            break;
        case 40:
            x.preventDefault();
            w.moveSelect(1);
            break;
        case 13:
            b();
            x.preventDefault();
            break;
        case 9:
            b();
            break;
        default:
            h = -1;
            if (k) {
                clearTimeout(k)
            }
            k = setTimeout(function () {
                w.onChange()
            }, g.delay);
            break
        }
    }).focus(function () {
        if (!$(this).attr("autocomplete") || $(this).attr("autocomplete") != "off") {
            $(this).attr("autocomplete", "off")
        }
        var x = g.initialText;
        if (g.initialValue != "") {
            x += " (" + g.initialValue + ")"
        }
        if (!e && w.trim($(l).val()) == x) {
            $(this).val("")
        } else {
            this.select()
        }
        e = true
    }).blur(function (y) {
        if ($(this).attr("autocomplete") && $(this).attr("autocomplete") == "off") {
            $(this).removeAttr("autocomplete")
        }
        var x = w.trim($(l).val());
        if (x == "") {
            w.initialValue(g.initialText, g.initialValue, g.initialType, false, g.initialTypeSelected)
        }
    });
    var b = function () {
        if (w.selectCurrent()) {
            w.showMoreResults()
        } else {
            w.hideResults()
        }
    };
    f.find("ul li").live("click", function () {
        b()
    });
    $(document).bind("click", function (y) {
        var x = $(y.target);
        if (f.is(":visible") && !x.is(f) && x.parents(f.attr("id")).length == 0) {
            w.hideResults()
        }
    });
    this.hideResultsNow();
    if (g.initialValue == "") {
        d.addClass("default")
    }
    $(window).resize(function () {
        $("#results-" + d.attr("id")).css("left", $("#" + d.attr("id")).offset().left + "px")
    })
};
jQuery.fn.autocomplete = function (b) {
    this.each(function (d, e) {
        var c = this;
        e.obj = new FrameworkJS.Common.Autocomplete(c, b)
    });
    return this
};
