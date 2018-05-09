// moment.js
// version : 1.7.2
// author : Tim Wood
// license : MIT
// momentjs.com
/*
 * jQuery BBQ: Back Button & Query Library - v1.2.1 - 2/17/2010
 * http://benalman.com/projects/jquery-bbq-plugin/
 *  
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
/*
 * jQuery hashchange event - v1.2 - 2/11/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
typeof jQuery == "undefined" ? define("jquery", ["libs.jquery"], function () {
    return jQuery
}) : define("jquery", [], function () {
    return jQuery
}), typeof amplify == "undefined" ? define("amplify", ["libs.amplify"], function () {
    return amplify
}) : define("amplify", [], function () {
    return amplify
}), define("core-flights/logger", [], function () {
    function e(e) {
        s("warn", e)
    }
    function t(e) {
        s("error", e)
    }
    function n(e) {
        s("log", e)
    }
    function r(e) {
        s("info", e)
    }
    function i(e) {
        s("dir", e)
    }
    function s(e, t) {
        window.console && (console[e] ? console[e](t) : console.log(t))
    }
    return {
        log: n,
        error: t,
        warn: e,
        info: r,
        dir: i
    }
}), define("core-flights/utils", ["core-flights/logger"], function (e) {
    function t() {
        var e = document.createElement("input");
        return "placeholder" in e
    }
    function n(e) {
        e.each(function () {
            var e = $(this),
                t = e.attr("placeholder");
            e.val(t)
        }), e.on({
            focus: function (e) {
                $(this).val() == $(this).attr("placeholder") && $(this).select()
            },
            blur: function (e) {
                $(this).val() === "" && $(this).val($(this).attr("placeholder"))
            },
            mouseup: function (e) {
                e.preventDefault()
            }
        })
    }
    function r() {
        $(".modal").length ? $(".modal").show() : $("body").append($("<div class='modal' />"))
    }
    function i() {
        $(".modal").hide()
    }
    function s() {
        var e = $("#cookie-value"),
            t = document.cookie.split("; "),
            n;
        for (var r in t) {
            n = t[r].split("=")[0];
            if (n == "X-Version-Override") return e.html(t[r]).show(), !1
        }
    }
    function o(e, t) {
        var n = $("#currency-style");
        n.length == 1 && n.remove(), $("<style type='text/css' id='currency-style'> ." + t + " ." + e + "{ display: block !important; } .price-currency { display: none;}</style>").appendTo("head"), amplify.publish("changeCurrency", e)
    }
    function u(e) {
        e.each(function () {
            this.reset()
        })
    }
    function a(e, t) {
        var n;
        if (e.length == 10) return e.indexOf("/") != "-1" ? n = e.split("/") : n = e.split("-"), n[2] + t + n[1] + t + n[0];
        var r = [];
        return $.each(e.split(","), function (e, i) {
            i.indexOf("/") != "-1" ? n = i.split("/") : n = i.split("-"), r[e] = n[2] + t + n[1] + t + n[0]
        }), r.join(",")
    }
    function f(e) {
        var t = !0;
        if (e.data("validations").multiple) {
            var n = e.val().split(",");
            $.each(n, function (e, n) {
                t = l(n);
                if (!t) return !1
            })
        } else t = l(e.val());
        return t
    }
    function l(e) {
        var t = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return $.trim(e).match(t) !== null
    }
    function c(t) {
        switch (t) {
        case "NO_RESULTS":
            e.warn("[WARN] No existen resultados en el servicio.");
            break;
        case "VALIDATION_ERROR":
            e.warn("[WARN] El servicio entregó un error de validación.");
            break;
        case "ERROR":
            e.warn("[ERROR] Hubo un error en el servicio de datos.");
            break;
        case "FATAL_ERROR":
            e.warn("[ERROR] Hubo un error fatal en el servicio de datos.");
            break;
        case "NULL_ITEM_PARAMETER":
            e.warn("[ERROR] Se enviaron parametros incorrectos al servicio.");
            break;
        default:
            e.warn("[WARN] Hubo un error desconocido en el servicio de datos.")
        }
    }
    function h(e) {
        var t = e + "=",
            n = document.cookie.split(";");
        for (var r = 0; r < n.length; r++) {
            var i = n[r];
            while (i.charAt(0) == " ") i = i.substring(1, i.length);
            if (i.indexOf(t) === 0) return i.substring(t.length, i.length)
        }
        return null
    }
    return {
        showModal: r,
        hideModal: i,
        supportPlaceHolders: t,
        placeHolders: n,
        showCurrency: o,
        resetForm: u,
        convertDate: a,
        validateEmail: f,
        logError: c,
        readCookie: h,
        showXVersionOverride: s
    }
}), define("results/layout", ["jquery", "amplify", "core-flights/utils"], function (e, t, n) {
    function r() {
        t.subscribe("doSearch", function (e) {
            n.showXVersionOverride(), e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? l() : c(), i()
        }), t.subscribe("doRefine", function (e, t, n, r) {
            e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? l() : c(), a(), p()
        }), t.subscribe("doItem", function (e, t, n) {
            p()
        }), t.subscribe("resultsError", function (e) {
            i(), s(e)
        }), t.subscribe("refineError", function (e) {
            e && u(), p()
        }), t.subscribe("refine", function (t, n, r) {
            r.id == "pagination" && e(window).scrollTop(0), h(), d()
        }), t.subscribe("item", function (e, t) {
            h(), d()
        })
    }
    function i() {
        e("#results-loader").hide()
    }
    function s(t) {
        e("#results-error").show()
    }
    function o() {
        e("#results-error").hide()
    }
    function u() {
        e("#filters-error").show()
    }
    function a() {
        e("#filters-error").hide()
    }
    function f(t, n) {
        var r = e("#results-messages");
        r.find(".message").html(t), r.find(".help").html(n), r.show()
    }
    function l() {
        e("#results-warning").show()
    }
    function c() {
        e(".results-messages").hide()
    }
    function h() {
        var t = e(".results-update"),
            r = e(window),
            i = r.scrollTop() + (r.height() - t.outerHeight()) / 2;
        i < 0 && (i = 0), t.css({
            top: i,
            left: (e("body").width() - t.outerWidth()) / 2
        }).show(), n.showModal()
    }
    function p() {
        n.hideModal(), e(".results-update").hide()
    }
    function d() {
        e(".popUpNew").hide()
    }
    return {
        init: r
    }
}), typeof Handlebars == "undefined" ? define("handlebars", ["libs.handlebars"], function () {
    return Handlebars
}) : define("handlebars", [], function () {
    return Handlebars
}), define("core-flights/tmpl-helpers", ["jquery", "handlebars"], function (e, t) {
    t.registerHelper("_each", function (t, n) {
        var r = "",
            i = t.length,
            s = 0,
            o = e.isEmptyObject(n.hash);
        for (var u = 0, a = i; u < a; u++) {
            var f = {};
            f.data = t[u], f.index = s, f.list = t, f._data = {}, f._data.index = s, f._data.total = i, o === !1 && (f._data.extra = n.hash), r += n(f), s++
        }
        return r
    }), t.registerHelper("key_value", function (e, t) {
        var n = "",
            r;
        for (r in e) e.hasOwnProperty(r) && (n += t({
                key: r,
                value: e[r]
            }));
        return n
    }), t.registerHelper("debug", function (e) {
        console.log("\nCurrent Context"), console.l...scribe("doItem", function (e, t) {
            n = "item", r = t
        }), t.subscribe("checkout", function () {
            var t = {}, s = {};
            n == "item" ? s = r : s = i, e.isEmptyObject(s) || (e.each(s, function (e, n) {
                t[e] = n
            }), e.bbq.pushState(t))
        })
    }
    var n = null, r = {}, i = {}, s;
    return {
        init: o
    }
    }), define("results/results", ["jquery", "amplify", "results/layout", "modules/best-price-alert/best-price-alert", "modules/order/order", "modules/title/title", "modules/clusters/clusters", "modules/filters/filters", "modules/pagination/pagination", "core-flights/modules/reviews/reviews", "modules/matrix/matrix", "core-flights/modules/flights-alerts/flights-alerts", "results/history", "core-flights/utils", "core-flights/logger"], function (e, t, n, r, i, s, o, u, a, f, l, c, h, p, d) {
    function T(v, m, y) {
        d.info("Inicializando Results."), w = m.initialCurrency, E = m.orderCriteria, S = m.orderDirection, x = m.personalSortId, t.request.define("refine", "ajax", {
            url: v.refine,
            type: "GET"
        }), t.request.define("item", "ajax", {
            url: v.item,
            type: "GET"
        }), d.info("Obteniendo datos del servicio de búsqueda."), e.ajax({
            url: v.search,
            type: "GET",
            dataType: "json",
            success: function (e, t) {
                N(e)
            },
            error: function (e, t) {
                C()
            }
        }), n.init(), r.init(), i.init(), s.init(y.title), o.init(m.clusters, y.clusters), u.init(y.filters), a.init(), l.init(), c.init(m.alerts), h.init(), p.showCurrency(m.initialCurrency, "results"), t.subscribe("doSearch", function (t) {
            e("#cross-sell").show();
            var n = c.getContainer();
            n != null && (n.html(t.result.htmlContent["flights-alerts"]).show(), c.showAlert(t.result.data.pricesSummary.bestPrice)), f.init(t.result.data.reviewsSummary)
        }), t.subscribe("refine", function (e, t, n) {
            n.id != "pagination" && M({
                pageIndex: g.pageIndex
            }), n.id != "matrix" && M({
                filterStrategy: g.filterStrategy
            }), M(t, e), k(e, n, y)
        }), t.subscribe("item", function (e, t) {
            L(e, t)
        }), t.subscribe("changeCurrency", function (e) {
            M({
                selectedCurrencyPrice: e
            })
        })
    }
    function N(e) {
        e.result.data.metadata.status.code == "SUCCEEDED" || e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? (d.info("Información obtenida correctamente. Publicando datos del servicio."), v = e.result.data.metadata.ticket, M({
            hash: v.hash,
            version: v.version,
            originalCurrencyPrice: e.result.data.metadata.currencyCode,
            selectedCurrencyPrice: w,
            orderCriteria: E,
            orderDirection: S
        }), A(e.result.data.items), t.publish("doSearch", e)) : (t.publish("resultsError", e), _(e.result.data.metadata.status.code))
    }
    function C() {
        t.publish("resultsError"), _("FATAL_ERROR")
    }
    function k(e, n, r) {
        d.info("Obteniendo datos del servicio de refinamiento."), t.request({
            resourceId: "refine",
            data: m,
            success: function (r, i) {
                if (r.result.data.metadata.status.code == "SUCCEEDED" || r.result.data.metadata.status.code == "SUCCEEDED_RELAXED") d.info("Información obtenida correctamente. Publicando datos del servicio de refinamiento."), t.publish("doRefine", r, e, m, n), A(r.result.data.items);
                else {
                    var s = !0;
                    n.action == "price" && t.publish("refineError", !1), t.publish("refineError", s), _(r.result.data.metadata.status.code)
                }
            },
            error: function (e, n) {
                t.publish("refineError", !0), _("FATAL_ERROR")
            }
        })
    }
    function L(e, n) {
        d.info("Obteniendo datos del servicio de items."), y = {
            hash: v.hash,
            version: v.version,
            itemHash: e
        }, t.request({
            resourceId: "item",
            data: y,
            success: function (e) {
                e.result.data.metadata.status.code == "SUCCEEDED" ? (d.info("Información obtenida correctamente. Publicando datos del servicio de items."), t.publish("doItem", e, y, n)) : (t.publish("refineError", !1), _("FATAL_ERROR"))
            },
            error: function () {
                _("FATAL_ERROR")
            }
        })
    }
    function A(e) {
        b.ticket = v, b.items = e
    }
    function O() {
        return b
    }
    function M(n, r) {
        switch (r) {
        case "clear":
            m = e.extend(m, g);
            break;
        case "new":
            m = e.extend(e.extend(m, g), n);
            break;
        default:
            m = e.extend(m, n)
        }
        m.orderCriteria == "PERSONAL" ? m.personalSortId = x : delete m.personalSortId, t.publish("refineParamsChanged", m)
    }
    function _(e) {
        switch (e) {
        case "NO_RESULTS":
            d.warn("No existen resultados en el servicio.");
            break;
        case "VALIDATION_ERROR":
            d.warn("El servicio entregó un error de validación.");
            break;
        case "ERROR":
            d.warn("Hubo un error en el servicio de datos.");
            break;
        case "FATAL_ERROR":
            d.warn("Hubo un error fatal en el servicio de datos.");
            break;
        case "NULL_ITEM_PARAMETER":
            d.warn("Se enviaron parametros incorrectos al servicio.");
            break;
        default:
            d.warn("Hubo un error desconocido en el servicio de datos.")
        }
    }
    var v = {}, m = {
            orderCriteria: "DEFAULT",
            orderDirection: "ASCENDING",
            hash: null,
            version: null,
            filterStrategy: "PRECLUSTER",
            pageIndex: 1,
            minPrice: "NA",
            maxPrice: "NA",
            originalCurrencyPrice: "NA",
            selectedCurrencyPrice: "NA",
            allowedOutboundTimeRanges: "NA",
            allowedInboundTimeRanges: "NA",
            allowedAirlines: "NA",
            allowedStopQuantities: "NA",
            allowedOutboundAirports: "NA",
            allowedInboundAirports: "NA",
            uniqueHomeAirport: "NA",
            uniqueAirline: "NA"
        }, g = {
            filterStrategy: "PRECLUSTER",
            pageIndex: 1,
            minPrice: "NA",
            maxPrice: "NA",
            allowedOutboundTimeRanges: "NA",
            allowedInboundTimeRanges: "NA",
            allowedAirlines: "NA",
            allowedStopQuantities: "NA",
            allowedOutboundAirports: "NA",
            allowedInboundAirports: "NA",
            uniqueHomeAirport: "NA",
            uniqueAirline: "NA"
        }, y = {}, b = {}, w, E, S, x;
    return {
        init: T,
        getDebug: O
    }
}), require(["services", "options", "messages", "searchbox", "results/results"], function (e, t, n, r, i) {
    $(function () {
        i.init(e, t, n), r.init()
    })
}), define("pkg/results", function () {})