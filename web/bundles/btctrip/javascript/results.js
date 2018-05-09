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
    function s(e, t) {
        var n = $("#currency-style");
        n.length == 1 && n.remove(), $("<style type='text/css' id='currency-style'> ." + t + " ." + e + "{ display: block; } </style>").appendTo("head"), amplify.publish("changeCurrency", e)
    }
    function o(e) {
        e.each(function () {
            this.reset()
        })
    }
    function u(e, t) {
        var n;
        if (e.length == 10) return e.indexOf("/") != "-1" ? n = e.split("/") : n = e.split("-"), n[2] + t + n[1] + t + n[0];
        var r = [];
        return $.each(e.split(","), function (e, i) {
            i.indexOf("/") != "-1" ? n = i.split("/") : n = i.split("-"), r[e] = n[2] + t + n[1] + t + n[0]
        }), r.join(",")
    }
    function a(e) {
        var t = !0;
        if (e.data("validations").multiple) {
            var n = e.val().split(",");
            $.each(n, function (e, n) {
                t = f(n);
                if (!t) return !1
            })
        } else t = f(e.val());
        return t
    }
    function f(e) {
        var t = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return $.trim(e).match(t) !== null
    }
    function l(t) {
        switch (t) {
            case "NO_RESULTS":
                e.warn("[WARN] Don't exists results in the service.");
                break;
            case "VALIDATION_ERROR":
                e.warn("[WARN] The service return a validation error.");
                break;
            case "ERROR":
                e.warn("[ERROR] There was an error in the data service.");
                break;
            case "FATAL_ERROR":
                e.warn("[ERROR] There was a fatal error in the data service.");
                break;
            case "NULL_ITEM_PARAMETER":
                e.warn("[ERROR] Incorrect parameters sended to the service.");
                break;
            default:
                e.warn("[WARN] There was an unknow error in the data service.")
        }
    }
    function c(e) {
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
        showCurrency: s,
        resetForm: o,
        convertDate: u,
        validateEmail: a,
        logError: l,
        readCookie: c
    }
}), define("results/layout", ["jquery", "amplify", "core-flights/utils"], function (e, t, n) {
    function r() {
        t.subscribe("doSearch", function (e) {
            e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? l() : c(), i()
        }), t.subscribe("doRefine", function (e, t, n, r) {
            e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? l() : c(), a(), p()
        }), t.subscribe("doItem", function (e, t, n) {
            p()
        }), t.subscribe("resultsError", function () {
            i(), s()
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
    function s() {
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
    }), t.registerHelper("debug", function (e) {
        console.log("\nCurrent Context"), console.log("===================="), console.log(this), arguments.length > 1 && (console.log("Value"), console.log("===================="), console.log(e))
    }), t.registerHelper("get", function (t, n) {
        if (!t.hash) return n(t[n.hash.index]);
        if (t.hash.array) {
            var r = t.hash.array;
            return r = r.split(","), r[t.hash.index]
        }
        if (t.hash.object) {
            var i = t.hash.object;
            return i = e.parseJSON(i), i[t.hash.key]
        }
    }), t.registerHelper("compare", function (e, t, n) {
        if (arguments.length < 3) throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
        var r = n.hash.operator || "==";
        e = e === "null" ? null : e, t = t === "null" ? null : t;
        var i = {
            "==": function (e, t) {
                return e == t
            },
            "===": function (e, t) {
                return e === t
            },
            "!=": function (e, t) {
                return e != t
            },
            "<": function (e, t) {
                return e < t
            },
            ">": function (e, t) {
                return e > t
            },
            "<=": function (e, t) {
                return e <= t
            },
            ">=": function (e, t) {
                return e >= t
            },
            "typeof": function (e, t) {
                return typeof e == t
            }
        };
        if (!i[r]) throw new Error("Handlerbars Helper 'compare' doesn't know the operator " + r);
        var s = i[r](e, t);
        return s ? n.fn(this) : n.inverse(this)
    }), t.registerHelper("even_odd", function (e) {
        return e % 2 === 0 ? "even" : "odd"
    }), t.registerHelper("calcule", function (e, t, n) {
        if (arguments.length < 3) throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
        var r = n.hash.symbol || "+",
            i = {
                "+": function (e, t) {
                    return e + t
                },
                "-": function (e, t) {
                    return e - t
                },
                "*": function (e, t) {
                    return e * t
                },
                "%": function (e, t) {
                    return e % t
                }
            };
        if (!i[r]) throw new Error("Handlerbars Helper 'compare' doesn't know the symbol " + r);
        return i[r](e, t)
    })
}), define("core-flights/popup", ["core-flights/utils", "jquery", "amplify", "handlebars", "core-flights/tmpl-helpers"], function (e, t, n, r) {
    function s(e) {
        var t = new i(e);
        return t.showPopup(), t
    }
    function o(e) {
        var t = new i(e);
        return t.togglePopup(), t
    }
    var i = function (n) {
        function d() {
            var e = t(s.elementTrigger),
                n = {
                    left: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() / 2 - o.outerHeight() / 2,
                            left: e.offset().left - o.outerWidth() - 15
                        }), o.find(".popup-arrow-right").css("top", (o.outerHeight() - 20) / 2 - 10)
                    },
                    right: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() / 2 - o.outerHeight() / 2,
                            left: e.offset().left + e.outerWidth() + 15
                        }), o.find(".popup-arrow-left").css("top", (o.outerHeight() - 20) / 2 - 10)
                    },
                    top: function () {
                        o.css({
                            top: e.offset().top - o.outerHeight() - 15,
                            left: e.offset().left + e.outerWidth() / 2 - o.width() / 2
                        }), o.find(".popup-arrow-bottom").css("left", (o.outerWidth() - 20) / 2 - 10)
                    },
                    bottom: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() + 15,
                            left: e.offset().left + e.outerWidth() / 2 - o.width() / 2
                        }), o.find(".popup-arrow-top").css("left", (o.outerWidth() - 20) / 2 - 10)
                    },
                    center: function () {
                        o.css({
                            top: e.offset().top + e.outerHeight() + 10,
                            left: (t("body").width() - o.outerWidth()) / 2
                        }), o.find(".popup-arrow-top").css("left", (o.outerWidth() - 20) / 2 - 20)
                    },
                    fixed: function () {
                        var e = t(window).scrollTop() + (t(window).height() - o.outerHeight()) / 2;
                        e < 0 && (e = 0), o.css({
                            top: e,
                            left: (t("body").width() - o.outerWidth()) / 2
                        }), o.find(".popup-arrow-top").css("left", (o.outerWidth() - 20) / 2 - 10)
                    }
                };
            n[s.position]()
        }
        function m() {
            return o
        }
        var i = r.compile(t("#popup-template").html()),
            s = {
                $template: null,
                $data: null,
                $functions: null,
                dynamic: !0,
                $content: null,
                showModal: !1,
                hideCloseIcon: !1,
                dontClosePopup: !0,
                dinamicPosition: !1,
                popupContainer: t("body"),
                movePopup: !0
            };
        s = t.extend(s, n);
        var o = t("#" + s.id),
            u = function () {
                o.length === 0 ? (o = t(i(s)), o.hide(), o.appendTo(s.popupContainer), c(), a()) : o.is(":visible") ? o.stop(!0, !0).fadeOut(50, function () {
                    a()
                }) : a()
            }, a = function () {
                n.showModal && e.showModal(), h(), p(s.dontClosePopup)
            }, f = function () {
                o.data("trigger_left", null), o.data("trigger_top", null), p(!1)
            }, l = function () {
                var e = t(s.elementTrigger).offset().left,
                    n = t(s.elementTrigger).offset().top;
                o.length === 0 || o.data("trigger_left") != e || o.data("trigger_top") != n ? (u(), o.data("trigger_left", e), o.data("trigger_top", n)) : f()
            }, c = function () {
                t(".popup-close-button", o).click(function () {
                    f()
                }), t(document).keyup(function (e) {
                    e.keyCode == 27 && t(".popup-close-button", o).click()
                })
            }, h = function () {
                s.dynamic && t(".popup-content", o).empty();
                if (t(".popup-content", o).children().length === 0) if (s.$template) {
                        var e = r.compile(s.$template.html());
                        t(".popup-content", o).html(e(s.$data))
                    } else t(".popup-content", o).html(s.$content.show())
            }, p = function (t) {
                t ? (s.movePopup && v(s.elementTrigger, s.popupPosition, s.dinamicPosition), o.stop(!0, !0).fadeIn()) : (o.stop(!0, !0).fadeOut(), s.showModal && e.hideModal())
            }, v = function (e, n, r) {
                e !== undefined && (s.elementTrigger = e), n !== undefined && (s.position = n), r !== undefined && (s.dinamicPosition = r);
                var i = t(s.elementTrigger);
                d();
                if (s.dinamicPosition) {
                    var u = i.offset().left + i.outerWidth() / 2,
                        a = u + o.outerWidth() / 2;
                    if (t(window).width() < a) {
                        var f = a - t(window).width();
                        o.css({
                            left: i.offset().left + i.outerWidth() / 2 - o.outerWidth() / 2 - f - 13
                        });
                        var l = a - u + f - 13;
                        t(".popup-arrow", o).css("left", l)
                    }
                }
                t(".flights-popup").css("z-index", 5), o.css("z-index", 6)
            };
        this.showPopup = u, this.hidePopup = f, this.togglePopup = l, this.movePopup = v, this.getPopupElement = m
    };
    return {
        openPopup: s,
        togglePopup: o
    }
}), define("modules/filters/layout", ["jquery", "amplify", "handlebars", "core-flights/popup", "core-flights/tmpl-helpers"], function (e, t, n, r) {
    function a(r) {
        u = e("#filters"), o = r, t.subscribe("changeCurrency", function (t) {
            e("#currency-" + t).attr("checked", !0)
        }), t.subscribe("refineError", function (e) {
            s == "price" && f(o.resultsPriceError)
        }), u.on("click", ".price .apply", function (t) {
            var n = e(".price-min", u).val(),
                r = e(".price-max", u).val();
            (n !== "" || r !== "") && l(this, n, r)
        }), u.on("click", ".accordion-header", function () {
            c(e(this))
        }), e("#filters-error").on("click", ".remove-last-action", function (e) {
            e.preventDefault(), window.location.reload()
        }), n.registerHelper("filterName", function (e, t) {
            return r[e][t]
        }), n.registerHelper("filterCount", function (t) {
            var n = 0;
            return e.each(t, function (e, t) {
                n += t.count
            }), n
        })
    }
    function f(t) {
        var n = {
            error: t.toString()
        };
        r.openPopup({
            elementTrigger: e(".values .apply", u),
            id: "popup-filter-error",
            title: "",
            $template: e("#popup-filter-error-template"),
            $data: n,
            popupPosition: "right",
            indicator: !1,
            indicatorPosition: "left"
        })
    }
    function l(n, r, a) {
        s = "price";
        var l = e(".price .clean", u),
            c = e("#popup-filter-error"),
            h = "NA",
            p = "NA";
        isNaN(r) || (h = Number(r), h = parseInt(h, 10)), isNaN(a) || (p = Number(a), p = parseInt(p, 10));
        if (p === 0) f(o.priceMaxError);
        else if (h != "NA" && p != "NA" && h >= p) f(o.priceError);
        else {
            c.hide();
            var d = {
                minPrice: h,
                maxPrice: p
            }, v = {
                    id: i,
                    action: "price"
                };
            l.show(), t.publish("refine", "update", d, v)
        }
    }
    function c(e) {
        var t = e.parent().find(".accordion-content"),
            n = e;
        t.slideToggle("fast"), n.hasClass("accordion-header-open") ? n.removeClass("accordion-header-open").addClass("accordion-header-close") : n.removeClass("accordion-header-close").addClass("accordion-header-open")
    }
    var i = "filters",
        s = null,
        o = null,
        u = null;
    return {
        init: a
    }
}), define("modules/best-price-alert/best-price-alert", ["jquery", "amplify", "handlebars", "core-flights/logger", "core-flights/tmpl-helpers"], function (e, t, n, r) {
    function u() {
        s = e("#best-price-alert"), o = n.compile(e("#best-price-alert-template").html()), t.subscribe("doSearch", function (e) {
            r.info("Initializing Best Price Alert."), s.append(o(e.result)).show(), a()
        })
    }
    function a() {
        e(".secondary-message").click(function () {
            window.open(e(this).data("href"), "_blank")
        })
    }
    var i = "bestPriceAlert",
        s, o;
    return {
        init: u
    }
}), define("modules/order/order", ["jquery", "amplify", "core-flights/logger", "core-flights/utils"], function (e, t, n, r) {
    function u() {
        s = e("#order"), t.subscribe("doSearch", function (i) {
            n.info("Initializing Order."), s.show(), r.resetForm(e(".order-form", s)), s.on("change", ".currency select", function () {
                r.showCurrency(e(this).val(), "results"), t.publish("changeCurrencyByUser", e(this).val())
            })
        }), t.subscribe("changeCurrency", function (t) {
            e(".currency select", s).val(t);
            amplify.store("preferedCurrency", t);
        }), t.subscribe("doRefine", function (t, n, r, i) {
            s.show(), i.id == "history" && e("#orderby", s).val(r.orderCriteria + "_" + r.orderDirection), o === !1 && (o = !0, e(".orderby", s).show())
        }), t.subscribe("refineError", function (e) {
            e && s.hide()
        }), t.subscribe("doItem", function (t, n) {
            o = !1, e(".orderby", s).hide()
        }), s.on("change", "#orderby", function () {
            var n = e(this).val().split("_"),
                r = {
                    id: i,
                    action: "order"
                }, s = {
                    orderCriteria: n[0],
                    orderDirection: n[1]
                };
            t.publish("refine", "update", s, r)
        }) ;
    }
    var i = "order",
        s, o = !0;
    return {
        init: u
    }
}), define("modules/title/title", ["jquery", "amplify", "core-flights/logger", "core-flights/popup"], function (e, t, n, r) {
    function o() {
        n.info("Initializing Title."), s = e("#title"), t.subscribe("doSearch", function (t) {
            e(".amount", s).text(t.result.data.paginationSummary.itemCount)
        }), s.on("click", ".title .best-price", function (t) {
            t.preventDefault(), r.togglePopup({
                elementTrigger: this,
                id: "popup-best-price",
                title: null,
                $template: e("#popup-best-price-template"),
                $data: null,
                popupPosition: "bottom",
                indicator: !1,
                indicatorPosition: "top"
            })
        })
    }
    var i = "title",
        s;
    return {
        init: o
    }
}), define("modules/clusters/common", ["jquery", "amplify"], function (e, t) {
    function r() {
        return n
    }
    function i(e) {
        return e.data("clusterInfo").hash
    }
    function s(e) {
        return e.data("clusterInfo").index
    }
    function o(t) {
        var n = e("input", t).length == 1 ? "input" : "input:checked";
        return e(n, t).parents(".itinerary").data("itineraryInfo")
    }
    function u(t) {
        return e(".itinerary-required", t).length === 0
    }
    function a(t, n, r) {
        var i = e(".outbound", t),
            u = e(".inbound", t),
            a = n[s(t)];
        if (!l(t, r)) return null;
        switch (r) {
            case "ONEWAY":
                return a.itinerariesBox.matchingInfoMap["_" + o(i).itineraryIndex + "_-1"].id;
            case "ROUNDTRIP":
                return a.itinerariesBox.matchingInfoMap["_" + o(i).itineraryIndex + "_" + o(u).itineraryIndex].id;
            case "MULTIPLEDESTINATIONS":
                return a.itinerary.itineraryInfo.id;
            default:
                return null
        }
    }
    function f(e, t, n) {
        var r = t[s(e)];
        if (!l(e, n)) return null;
        switch (n) {
            case "ONEWAY":
                return r.itinerariesBox.category;
            case "ROUNDTRIP":
                return r.itinerariesBox.category;
            case "MULTIPLEDESTINATIONS":
                return r.itinerary.category;
            default:
                return null
        }
    }
    function l(t, n) {
        var r = e(".outbound", t),
            i = e(".inbound", t);
        if (u(r) && n === "ONEWAY") return !0;
        if (u(r) && u(i) && n === "ROUNDTRIP") return !0;
        if (n === "MULTIPLEDESTINATIONS") return !0
    }
    var n = null;
    return t.subscribe("changeCurrency", function (e) {
        n = e
    }), {
        getCurrencyCode: r,
        getClusterHash: i,
        getClusterIndex: s,
        getItineraryHash: a,
        getItineraryCategory: f,
        getSubClusterInfo: o,
        isNotRequired: u,
        isValid: l
    }
}), define("modules/clusters/itineraries", ["jquery", "amplify", "core-flights/logger", "core-flights/popup", "modules/clusters/common"], function (e, t, n, r, i) {
    function a(r, o, a, c) {
        n.info("Initializing Itineraries."), s = c, u = r.result.data.itemReviewsSummary, t.subscribe("validateCluster", function (t) {
            var n = e(".outbound", t),
                r = e(".inbound", t);
            i.isNotRequired(n) || l(n), i.isNotRequired(r) || l(r)
        }), h(r.result), e(".airport a", s).bind("mouseover mouseleave", function (t) {
            t.preventDefault();
            var n = e(this).data("locationInfo");
            t.handleObj.origType == "mouseover" ? p(this, r, n, o, !0) : p(this, r, n, o, !1)
        }), e(".stops a , .delays span", s).on("click", function (t) {
            t.preventDefault();
            var n = e(this).parents(".itinerary").data("itineraryInfo");
            e(this).parent("li").hasClass("stops") ? d(this, a.detailTitle, r, n, o) : f(this, a.delaysTitle, r, n, o)
        })
    }
    function f(t, n, i, s, o) {
        var u = {}, a = i.result.data.items[s.clusterIndex],
            f = null,
            l = null;
        o == "MULTIPLEDESTINATIONS" ? (f = a.itinerary.routes[s.routeIndex].delayInfos, l = a.itinerary.locations[s.routeIndex]) : (f = a.itinerariesBox[s.itineraryType + "Routes"][s.itineraryIndex].delayInfos, l = a.itinerariesBox[s.itineraryType + "Locations"]), u.arrivalCityCode = l.arrival.code, u.departureCityCode = l.departure.code, u.delays = f;
        if (u.delays.length) {
            r.togglePopup({
                elementTrigger: t,
                id: "popup-delays",
                $template: e("#popup-delays-template"),
                title: n,
                $data: u,
                popupPosition: "bottom",
                indicator: !1,
                indicatorPosition: "top"
            });
            var c = e("#popup-delays");
            c.find(".show-ANAC-info").unbind("click").on("click", function (e) {
                c.find(".information-ANAC").toggle()
            })
        }
    }
    function l(t) {
        e(".itinerary-required", t).addClass("itinerary-error"), e(".error-message", t).show(), e(".error", t).show()
    }
    function c(t) {
        e(".itinerary", t).removeClass("itinerary-required itinerary-error"), e(".error-message", t).hide(), e(".error", t).hide()
    }
    function h(t) {
        var n = e(".itinerary", s);
        e("input", n).change(function () {
            e(this).parents(".itinerary").hasClass("itinerary-required") && c(e(this).parents(".sub-cluster"));
            var n = e(this).closest(".cluster"),
                r = e(".outbound", n),
                i = e(".inbound", n),
                s = null,
                o = null,
                u = null,
                a = null;
            if (r.size() && i.size()) {
                var f = r.find("input:checked").size() > 0,
                    l = i.find("input:checked").size() > 0;
                if (f && l && (r.find("input").size() > 1 || i.find("input").size() > 1)) {
                    s = e(this).closest(".item").data("itineraryInfo").clusterIndex, u = r.find("input:checked").closest(".item").data("itineraryInfo").itineraryIndex;
                    var h = i.find("input:checked").closest(".item").data("itineraryInfo").itineraryIndex;
                    a = "_" + u + "_" + h, t.data.items[s].itinerariesBox.frequentFlyerInfo && (o = t.data.items[s].itinerariesBox.matchingInfoMap[a].frequentFlyerInfo.points, n.find(".distance").html(o))
                }
            } else r.size() && (s = e(this).closest(".item").data("itineraryInfo").clusterIndex, u = r.find("input:checked").closest(".item").data("itineraryInfo").itineraryIndex, a = "_" + u + "_-1", t.data.items[s].itinerariesBox.frequentFlyerInfo && (o = t.data.items[s].itinerariesBox.matchingInfoMap[a].frequentFlyerInfo.points, n.find(".distance").html(o)))
        })
    }
    function p(t, n, i, s, u) {
        if (u) {
            var a;
            s != "MULTIPLEDESTINATIONS" ? a = n.result.data.items[i.clusterIndex].itinerariesBox[i.itineraryType + "Locations"][i.locationType] : a = n.result.data.items[i.clusterIndex].itinerary.locations[i.routeIndex][i.locationType], o = {
                elementTrigger: t,
                id: "popup-airport",
                title: null,
                $template: e("#popup-airport-template"),
                $data: a,
                popupPosition: "bottom",
                indicator: !1,
                indicatorPosition: "top",
                hideCloseIcon: !0
            }, r.togglePopup(o)
        } else {
            var f = {};
            f = {
                dontClosePopup: !1
            }, f = e.extend(o, f), r.togglePopup(f)
        }
    }
    function d(t, n, i, s, o) {
        var u;
        o != "MULTIPLEDESTINATIONS" ? u = i.result.data.items[s.clusterIndex].itinerariesBox[s.itineraryType + "Routes"][s.itineraryIndex] : u = i.result.data.items[s.clusterIndex].itinerary.routes[s.routeIndex], r.togglePopup({
            elementTrigger: t,
            id: "popup-detail",
            title: n,
            $template: e("#popup-detail-template"),
            $data: u,
            popupPosition: "bottom",
            indicator: !1,
            indicatorPosition: "top"
        });
        var a = e("#popup-detail");
        a.on("click", ".show-rules", function (t) {
            t.preventDefault(), e(".show-rules", a).toggle(function () {
                e(".rules", a).show()
            }, function () {
                e(".rules", a).hide()
            }).trigger("click")
        }), v()
    }
    function v() {
        e("#popup-detail .review-description").on("click", function (n) {
            n.preventDefault();
            var r = e(this).data("reviewInfo").code;
            t.publish("doReview", this, r, "left", !1, "right")
        })
    }
    function m(t) {
        return e(".itinerary-required", t).length > 1
    }
    var s = null,
        o = {}, u = {};
    return {
        init: a,
        isRequired: m
    }
}), define("modules/clusters/fare", ["jquery", "amplify", "modules/clusters/common", "core-flights/logger", "core-flights/popup",], function (e, t, n, r, pu) {
    function u(u, f, l, c, h, p, d) {
        r.info("Initializing Fare."), i = u, s = h, o = d, e(".buy", l).on("click", function (r) {
            r.preventDefault();
            var s = e(this).parents(".cluster"),
                o = n.getClusterIndex(s),
                u = n.getItineraryHash(s, i.result.data.items, f),
                // l = p === !0 ? o : -1;
                l = o;
            t.publish("validateCluster", s);
            if (n.isValid(s, f)) {
                var h = n.getItineraryCategory(s, i.result.data.items, f);
                t.publish("buyItinerary", {
                    category: h
                }), a(c, u, o, l)
            }
        }), e(".fare-description a", l).on("click", function (t) {
        	var nn = e(this).parents(".flights-cluster").data("clusterInfo").index;
            t.preventDefault();
            pc(this, i, nn)
        })
    }
    function a(e, n, u, a) {
        t.publish("checkout", e, n, a);
        if (s === "true") {
            r.info("Redirecting to the checkout.");
            var l = o;
            l = l.replace("{hash}", e.hash), l = l.replace("{version}", e.version), l = l.replace("{itineraryId}", n), l = l.replace("{clusterIndexTraking}", a), window.location = l
        } else r.info("Trying to redirect to the checkout.")
    }
    function pc(t, i, nn) {
        var a;
        oo = {
            elementTrigger: t,
            id: "popup-price-details",
            title: "Price detail",
            $template: e("#popup-price-details-template"),
            $data: i.result.data.items[nn],
            popupPosition: "left",
            indicator: !1,
            indicatorPosition: "right",
            hideCloseIcon: !1
        }, pu.togglePopup(oo)
    }
    var i = {}, s = null,
        o = null;
    return {
        init: u
    }
}), define("modules/clusters/actions", ["jquery", "amplify", "modules/clusters/itineraries", "modules/clusters/common", "core-flights/utils", "core-flights/popup", "core-flights/logger"], function (e, t, n, r, i, s, o) {
    function d(n, i, s, c, h, d) {
        o.info("Initializing Actions."), u = h, a = n, f = d, l = i, p = s, t.subscribe("changeCurrency", function (e) {
            p = e
        }), e(".icon-print", u).on("click", function (t) {
            t.preventDefault();
            var n = r.getClusterHash(e(this).parents(".cluster")),
                i = e(this).attr("href");
            window.open(i + "/" + r.getCurrencyCode() + "/" + d.hash + "/" + d.version + "/" + n, "print", "location=0, status=0, scrollbars=1, width=740, height=550")
        })
    }
    function N(t, n) {
        e(".input", t).addClass("error"), e(".icon-error", t).show(), n == "empty" ? e(".empty-error-message", t).css("display", "block") : e(".invalid-error-message", t).css("display", "block")
    }
    function C(t) {
        e(".input", t).removeClass("error"), e(".empty-error-message", t).hide(), e(".invalid-error-message", t).hide(), e(".icon-error", t).hide()
    }
    var u, a = {}, f = {}, l = null,
        c = "",
        h = "",
        p = "";
    return {
        init: d
    }
}), define("modules/clusters/clusters", ["jquery", "amplify", "handlebars", "modules/clusters/itineraries", "modules/clusters/fare", "modules/clusters/actions", "core-flights/logger", "core-flights/tmpl-helpers"], function (e, t, n, r, i, s, o) {
    function b(r, i) {
        o.info("Initializing Clusters."), a = e("#clusters"), f = n.compile(e("#cluster-template").html()), l = i, c = r.searchType, h = r.initialCurrencyCode, m = r.redirectToCheckout, g = r.checkoutHandlerUrl, t.subscribe("doSearch", function (e) {
            p = e, v = p.result.data.metadata.ticket, y = !0, w(p)
        }), t.subscribe("doRefine", function (e, t, n, r) {
            p = e, y = !1, w(p)
        }), t.subscribe("doItem", function (e, t, n) {
            p = e, y = !1, w(p)
        }), t.subscribe("refineError", function (e) {
            e && a.hide()
        }), t.subscribe("refineParamsChanged", function (e) {
            d = e
        }), n.registerHelper("showPlusIcon", function (e) {
            return e.hash.index != e.hash.total - 1 ? e.fn(this) : e.inverse(this)
        }), n.registerHelper("levelContamination", function (e) {
            return parseFloat(e.hash.value) <= .25 ? i.ecological.ecologicalLow : parseFloat(e.hash.value) <= .75 ? i.ecological.ecologicalMedium : i.ecological.ecologicalHigh
        }), n.registerHelper("delayName", function (e) {
            return i.delays[e]
        }), n.registerHelper("showInstalments", function (e) {
            var t = e.hash.numberOfInstalments.length - 1,
                n = e.hash.numberOfInstalments[t];
            if (n > 1) return this._maxNumberOfInstalments = n, e.fn(this)
        }), n.registerHelper("showConnection", function (e) {
            if (this._data.index != this._data.total - 1) {
                var t = e.hash.segments[this._data.index + 1];
                return t.waitDuration !== "" ? (this._data.showWaitDuration = !0, this._data.locationDescription = t.departure.location.city.description, this._data.waitDuration = t.waitDuration) : this._data.cityDescription = t.departure.city.description, this.data.arrival.location.airport.code != t.departure.location.airport.code && (this._data.showAirportChange = !0), e.fn(this)
            }
            return e.inverse(this)
        }), n.registerHelper("segmentHasAirportChange", function (e, t, n) {
            var r = !1;
            if (t > 0) {
                var i = e[t - 1],
                    s = e[t];
                r = i.arrival.location.airport.code != s.departure.location.airport.code
            }
            return r ? n.fn(this) : n.inverse(this)
        })
    }
    function w(e) {
        var t = {};
        t.items = e.result.data.items, t.metadata = e.result.data.metadata, a.html(f(t)), r.init(e, c, l.itineraries, a), i.init(e, c, a, v, m, y, g), s.init(e, c, h, l.actions, a, v), a.show(), E()
    }
    function E() {
        e(".data", ".cluster").each(function (t, n) {
            e(n).width() > e(n).parent().width() && e(n).find(".city-arrival").hide()
        })
    }
    var u = "clusters",
        a = null,
        f = null,
        l = null,
        c = null,
        h = null,
        p = {}, d = null,
        v = {}, m = null,
        g = null,
        y = null;
    return {
        init: b
    }
}), define("modules/filters/filters", ["jquery", "amplify", "handlebars", "core-flights/logger", "core-flights/utils", "core-flights/tmpl-helpers"], function (e, t, n, r, i) {
    function p(s) {
        r.info("Initializing Filters."), o = e("#filters"), u = n.compile(e("#filters-template").html()), a = s, t.subscribe("doSearch", function (e) {
            f = e, o.append(u(e.result)).show(), d()
        }), t.subscribe("doRefine", function (e, t, n, i) {
            r.info("Applying search filter."), f = e, E(t), (i.id == "history" || i.id == "matrix") && k(n)
        }), o.on("keypress", ".values input", function (t) {
            t.which == 13 && e(".price .apply", o).trigger("click")
        }), o.on("change", ".currency-change", function () {
            i.showCurrency(e(this).val(), "results"), t.publish("changeCurrencyByUser", e(this).val())
        }), o.on("keyup", ".values input", function () {
            this.value = this.value.replace(/[^0-9]/g, "")
        }), o.on("click", ".clean a", function (e) {
            e.preventDefault(), C(!0)
        }), o.on("click", ".show-all a", function (t) {
            t.preventDefault();
            var n = e(this).parents(".items");
            e(this).toggle(function () {
                w(n, !0)
            }, function () {
                w(n, !1)
            }).trigger("click")
        })
    }
    function d() {
        o.on("click", "input[type=checkbox]", function () {
            var t = e(this).parents(".items"),
                n = e(".all", t);
            e(this).hasClass("all") ? b(t, n) : e(this).is(":checked") ? (n.is(":checked") && n.removeAttr("checked").removeAttr("disabled").parents("label").removeClass("selected disabled"), e(this).parents("label").addClass("selected")) : (e(this).removeAttr("checked").parents("label").removeClass("selected"), e(".enabled :checked", t).length || b(t, n)), v(e(this))
        })
    }
    function v(e) {
        var n = e.attr("name"),
            r = {
                id: s,
                action: n
            }, i = m(n, e);
        n == "unique-airport" || n == "unique-airline" ? l[i] = g(e) : l[i] = y(l[i], e, e.val()), t.publish("refine", "update", l, r)
    }
    function m(t, n) {
        var r = t.split("-");
        if (r.length > 1) {
            var i = r[1].charAt(0).toUpperCase();
            t = r[0] + i + r[1].substring(1)
        } else t = r[0];
        var s = t + "Info",
            o = "";
        return o = e(n).parents("ul").data(s).name, o
    }
    function g(e) {
        return e.is(":checked") ? e.val() : "NA"
    }
    function y(t, n, r) {
        var i = [];
        if (r != "NA") if (t == "NA") t = r;
            else if (n.is(":checked")) t = r + "," + t;
        else {
            i = t.split(",");
            if (e.inArray(r, i) != -1) {
                var s = e.inArray(r, i);
                i.splice(s, 1)
            }
            t = i
        } else t = r;
        return t.length === 0 && (t = "NA"), t.toString()
    }
    function b(t, n) {
        e(".selected", t).removeClass("selected").find("input").removeAttr("checked"), n.attr({
            checked: "checked",
            disabled: "disabled"
        }).parents("label").addClass("selected disabled")
    }
    function w(t, n) {
        n ? (e(".hidden", t).show(), e(".show-all a", t).html(a.showLess)) : (e(".hidden", t).hide(), e(".show-all a", t).html(a.showAll))
    }
    function E(t) {
        e.each(h, function (t, n) {
            var r = 0;
            e.each(f.result.data.refinementSummary[t], function (i, s) {
                var u;
                t == "airlines" || t == "outboundAirports" || t == "inboundAirports" ? u = e("." + n + "-" + s.value.code, o) : u = e("." + n + "-" + s.value, o), S(u, s.count, n), r += s.count
            }), e("." + n + "-all .total", o).html(r)
        })
    }
    function S(t, n, r) {
        e(".total", t).html(n);
        if (n === 0) {
            e("label", t).removeClass("enabled selected").addClass("disabled"), e("input", t).removeAttr("checked").attr("disabled", "disabled");
            if (t.legth > 0) {
                var i = m(r, t);
                l[i] = x(t, l[i])
            }
        } else e("label", t).removeClass("disabled").addClass("enabled"), e("input", t).removeAttr("disabled")
    }
    function x(t, n) {
        var r = t.find("input").val(),
            i = n.split(",");
        if (e.inArray(r, i) != -1) {
            var s = e.inArray(r, i);
            i.splice(s, 1)
        }
        return i = i.join(","), i
    }
    function T(t, n) {
        if (t.size() > 0) {
            var r = n.split(","),
                i;
            for (var s = 0; s < r.length; s++) i = e("input[value=" + r[s] + "]", t), i.attr("checked", "checked"), r[s] == "NA" ? b(t, i) : i.parents("label").addClass("selected"), i.parents("li").hasClass("hidden") && w($filter, !0)
        }
    }
    function N(t, n) {
        var r = e(".price .clean", o),
            i = !1;
        t != "NA" && (e(".price-min", o).val(t), i = !0), n != "NA" && (e(".price-max", o).val(n), i = !0), i && r.show()
    }
    function C(n) {
        e(".price .clean", o).hide(), e("#popup-filter-error").hide(), e(".price-min", o).val(""), e(".price-max", o).val("");
        if (n) {
            var r = {
                minPrice: "NA",
                maxPrice: "NA"
            }, i = {
                    id: s,
                    action: "price"
                };
            t.publish("refine", "update", r, i)
        }
    }
    function k(t) {
        var n = "NA",
            r = "NA";
        e("input[type=checkbox]:checked", o).removeAttr("checked").removeAttr("disabled").parents("label").removeClass("disabled selected"), C(!1), e.each(t, function (t, n) {
            T(e(c[t], o), n)
        }), t.minPrice && (n = t.minPrice), t.maxPrice && (r = t.maxPrice), N(n, r), e.each(t, function (e, t) {
            l[e] !== undefined && (l[e] = t)
        })
    }
    var s = "filters",
        o = null,
        u = null,
        a = null,
        f = null,
        l = {
            allowedOutboundTimeRanges: "NA",
            allowedInboundTimeRanges: "NA",
            allowedAirlines: "NA",
            allowedStopQuantities: "NA",
            allowedOutboundAirports: "NA",
            allowedInboundAirports: "NA",
            uniqueHomeAirport: "NA",
            uniqueAirline: "NA"
        }, c = {
            allowedOutboundTimeRanges: ".time-outbound .items",
            allowedInboundTimeRanges: ".time-inbound .items",
            allowedAirlines: ".airlines .items",
            allowedStopQuantities: ".stops .items",
            allowedOutboundAirports: ".airport-outbound .items",
            allowedInboundAirports: ".airport-inbound .items",
            uniqueHomeAirport: ".unique-airport .items",
            uniqueAirline: ".unique-airline .items"
        }, h = {
            airlines: "airlines",
            stops: "stops",
            timeOutbound: "time-outbound",
            timeInbound: "time-inbound",
            outboundAirports: "airport-outbound",
            inboundAirports: "airport-inbound"
        };
    return {
        init: p
    }
}), define("modules/pagination/pagination", ["jquery", "amplify", "handlebars", "core-flights/logger", "core-flights/tmpl-helpers"], function (e, t, n, r) {
    function f() {
        r.info("Initializing Pagination."), s = e("#pagination"), o = n.compile(e("#pagination-template").html()), t.subscribe("doSearch", function (e) {
            l(e.result.data.paginationSummary.pageCount, a)
        }), t.subscribe("doRefine", function (e, t, n, r) {
            r.id == "history" ? l(e.result.data.paginationSummary.pageCount, n.pageIndex) : r.id != i && l(e.result.data.paginationSummary.pageCount, 1)
        }), t.subscribe("doItem", function (e, t) {
            s.hide()
        }), t.subscribe("refineError", function (e) {
            e && s.hide()
        }), s.on("click", ".pagination .page, .pagination .pagination-button", function () {
            var t = parseInt(e(this).attr("data-page-number"), 10);
            c(t)
        })
    }
    function l(e, t) {
        u = e, u == 1 ? s.hide() : (h(u, t), s.show())
    }
    function c(e) {
        a = e, l(u, a);
        var n = {
            id: i,
            action: "pagination"
        }, r = {
                pageIndex: a
            };
        t.publish("refine", "update", r, n)
    }
    function h(t, n) {
        var r = {
            pages: new Array(t),
            currentPage: n,
            prevPage: n - 1,
            lastPages: t - 3
        };
        s.empty(), s.append(o(r));
        var i = e("li[data-page-number=" + n + "]", s);
        i.addClass("active"), i.addClass("current"), i.removeClass("page"), n == 1 && e(".prev", s).hide(), n == r.pages.length && e(".next", s).hide(), s.show()
    }
    var i = "pagination",
        s = null,
        o = null,
        u = 1,
        a = 1;
    return {
        init: f
    }
}), define("modules/reviews/reviews", ["jquery", "amplify", "core-flights/popup"], function (e, t, n) {
    function i() {
        t.subscribe("doSearch", function (e) {
            r = e.result.data.reviewsSummary
        }), t.subscribe("doReview", function (e, t, n, r, i) {
            s(e, t, n, r, i)
        })
    }
    function s(t, n, i, s, u) {
        e.each(r, function (e, a) {
            if (a.airline.code == n) {
                var f = r[a.airline.code];
                o(t, f, i, s, u)
            }
        })
    }
    function o(t, r, i, s, o) {
        n.togglePopup({
            elementTrigger: t,
            id: "popup-reviews",
            $template: e("#popup-reviews-template"),
            $data: r,
            popupPosition: i,
            indicator: !1,
            indicatorPosition: o,
            dinamicPosition: s
        })
    }
    var r = {};
    return {
        init: i
    }
}), define("modules/matrix/matrix", ["jquery", "amplify", "handlebars", "core-flights/logger", "core-flights/tmpl-helpers"], function (e, t, n, r) {
    function l() {
        function a(t, n) {
            var r = !0;
            return e.each(t, function (e, i) {
                if ("noScale" == n) {
                    if (t[e].oneScale || t[e].twoPlusScales) return r = !1, !1
                } else if ("oneScale" == n) {
                    if (t[e].twoPlusScales) return r = !1, !1
                } else r = !0
            }), r
        }
        s = e("#matrix"), o = n.compile(e("#matrix-template").html()), u = n.compile(e("#matrix-filter-template").html()), t.subscribe("doSearch", function (e) {
            r.info("Initializing Matrix."), s.append(o(e.result.data.pricesSummary.matrix)), e.result.data.pricesSummary.matrix.length > 5 ? d() : b(0, e.result.data.pricesSummary.matrix.length), s.show()
        }), t.subscribe("doRefine", function (e, t, n, r) {
            r.id == "filters" && (E(), w())
        }), t.subscribe("doItem", function (t, n, r) {
            if (r.id == "history") {
                var i = e("#" + n.itemHash, s);
                i.trigger("click")
            }
        }), t.subscribe("refineError", function (e) {
            w()
        }), s.on("mouseenter", ".matrix-airlines .head .airline-description", function () {
            v(e(this), "hover")
        }), s.on("mouseleave", ".matrix-airlines .head .airline-description", function () {
            v(e(this), "hover")
        }), s.on("click", ".matrix-airlines .head .airline-description", function () {
            h(e(this), "airline")
        }), s.on("mouseenter", ".matrix-scales .scale", function () {
            m(e(this), "hover")
        }), s.on("mouseleave", ".matrix-scales .scale", function () {
            m(e(this), "hover")
        }), s.on("click", ".matrix-scales .scale", function () {
            h(e(this), "scale")
        }), s.on("click", ".matrix-airlines .head .review-description", function (t) {
            t.preventDefault(), c(e(this))
        }), s.on("mouseenter", ".matrix-airlines .price", function () {
            y(e(this), "hover")
        }), s.on("mouseleave", ".matrix-airlines .price", function () {
            y(e(this), "hover")
        }), s.on("mouseenter", ".matrix-airlines .head .review-summary", function () {
            g(e(this), "hover")
        }), s.on("mouseleave", ".matrix-airlines .head .review-summary", function () {
            g(e(this), "hover")
        }), s.on("click", ".matrix-airlines .price", function () {
            h(e(this), "item")
        }), s.on("click", ".matrix-reset", function () {
            var e = {
                id: i,
                action: "reset"
            };
            E(), w(), t.publish("refine", "clear", null, e)
        }), n.registerHelper("hasScales", function (t) {
            var n = !1,
                r = this;
            e.each(r, function (e, i) {
                if (r[e][t.hash.type]) return n = !0, !1
            });
            if (n) return t.fn(this)
        }), n.registerHelper("lastScale", function (e) {
            var t = a(this, e.hash.type);
            if (t) return e.fn(this)
        }), n.registerHelper("visibleMatrixItem", function (t, n) {
            var r = !1;
            e.each(t, function (e, i) {
                t[e][n.hash.type] && (r = !0)
            });
            if (r) return n.fn(this)
        }), n.registerHelper("itemClass", function (e) {
            var t = ["priceItem"];
            return e.hash.data[e.hash.type] && (t.push("price"), e.hash.data[e.hash.type].bestPrice && t.push("price-best")), a(e.hash.matrixItems, e.hash.type) && t.push("last"), t.join(" ")
        }), n.registerHelper("matrixClass", function (e) {
            var t = {
                noScale: 0,
                oneScale: 0,
                twoPlusScales: 0
            };
            for (var n = 0; n < this.length; n++) this[n].noScale && (t.noScale = t.noScale + 1), this[n].oneScale && (t.oneScale = t.oneScale + 1), this[n].twoPlusScales && (t.twoPlusScales = t.twoPlusScales + 1);
            var r = 0;
            return t.noScale > 0 && r++, t.oneScale > 0 && r++, t.twoPlusScales > 0 && r++, e.hash.showEcologicsMatrix == "true" && r++, "matrix-" + r
        })
    }
    function c(e) {
        var n = e.data("reviewInfo").code;
        t.publish("doReview", e, n, "bottom", !0, "top")
    }
    function h(e, n) {
        var r = {
            id: i,
            action: n
        }, s = e.data(n + "Info").code,
            o = "";
        n == "item" ? o = e.data(n + "Info").validationCode : o = s, w();
        if (a[n] !== s || f === !0 || a.itemValidator !== o) {
            E(), a[n] = s, a.itemValidator = o;
            switch (n) {
                case "airline":
                    v(e, "click"), t.publish("refine", "new", {
                        allowedAirlines: s
                    }, r);
                    break;
                case "scale":
                    m(e, "click"), t.publish("refine", "new", {
                        filterStrategy: "POSTCLUSTER",
                        allowedStopQuantities: s
                    }, r);
                    break;
                case "item":
                    y(e, "click"), t.publish("item", s, r)
            }
            p(e, n)
        } else f = !0, t.publish("refine", "clear", null, r)
    }
    function p(t, n) {
        var r = {
            refineType: n
        };
        switch (n) {
            case "airline":
                r.airline = t.data("airline-info").name;
                break;
            case "scale":
                var i = t.data(n + "Info").code;
                r.scaleType = i;
                break;
            case "item":
                var o = e(".matrix-scales", s).find("[data-scale-index=" + t.data("scale-index") + "]"),
                    a = t.siblings(".head").find(".airline-description").data("airline-info");
                r.airline = a.name, r.scaleType = o.data("scale-info").code
        }
        e(".matrix-filter", s).html(u(r)), e(".matrix-filter", s).show()
    }
    function d() {
        var t = 0,
            n = 5,
            r = e(".matrix-airlines ul", s).length,
            i = e(".matrix-airlines ul", s).first().width();
        b(t, n), e(".matrix-airlines-container", s).width(r * i), s.on("click", ".matrix-next", function () {
            e(".matrix-prev", s).show(), t++, n++, b(t, n), n <= r && (e(".matrix-airlines-container", s).animate({
                left: "-=" + i
            }), n == r && e(".matrix-next", s).hide())
        }), s.on("click", ".matrix-prev", function () {
            e(".matrix-next", s).show(), t--, n--, b(t, n), t >= 0 && (e(".matrix-airlines-container", s).animate({
                left: "+=" + i
            }), t === 0 && e(".matrix-prev", s).hide())
        })
    }
    function v(t, n) {
        var r = t.parents("ul");
        r.toggleClass("column-" + n), r.hasClass("column-visible-first") === !0 ? e(".matrix-scales", s).toggleClass("column-" + n + "-left-first") : r.prev("ul").toggleClass("column-" + n + "-left")
    }
    function m(t, n) {
        var r = t.data("scaleInfo").index,
            i = null;
        n == "click" ? i = e(".matrix-airlines-container ul", s) : n == "hover" && (i = e(".matrix-airlines-container .column-visible", s)), t.toggleClass("row-" + n), t.prev().toggleClass("row-" + n + "-top"), i.each(function () {
            var t = e(this);
            e("li.priceItem[data-scale-index=" + r + "]", t).toggleClass("row-" + n), e("li.priceItem[data-scale-index=" + r + "]", t).prev().toggleClass("row-" + n + "-top")
        })
    }
    function g(t, n) {
        var r = t.parents("ul");
        r.toggleClass("column-review-" + n), r.hasClass("column-review-visible-first") === !0 ? e(".matrix-scales", s).toggleClass("column-review-" + n + "-left-first") : r.prev("ul").toggleClass("column-review-" + n + "-left"), r.hasClass("column-visible-first") === !0 && !r.hasClass("column-click") && e(".matrix-scales-review", s).toggleClass("cell-hover-left")
    }
    function y(e, t) {
        var n = e.index(),
            r = e.parent("ul");
        e.toggleClass("cell-" + t), e.prev().toggleClass("cell-" + t + "-top"), r.hasClass("column-visible-first") === !0 ? e.parents(".matrix").find(".matrix-scales li:eq(" + n + ")").toggleClass("cell-" + t + "-left-first") : r.prev().find("li:eq(" + n + ")").toggleClass("cell-" + t + "-left")
    }
    function b(t, n) {
        var r = e(".matrix-airlines-container ul", s);
        r.removeClass("column-visible column-visible-first column-visible-last"), r.each(function (r) {
            var i = e(this);
            if (r >= t && r <= n - 1) {
                i.addClass("column-visible"), r == t && i.addClass("column-visible-first");
                if (r == n - 1) return i.addClass("column-visible-last"), !1
            }
            i.hasClass("column-click") === !0 && (i.hasClass("column-visible-first") === !1 ? e(".matrix-scales", s).removeClass("column-click-left-first") : i.hasClass("column-visible-first") === !0 && e(".matrix-scales", s).addClass("column-click-left-first"))
        })
    }
    function w() {
        s = e("#matrix"), e("ul", s).removeClass("column-click column-click-left column-click-left-first"), e("li", s).removeClass("row-click row-click-top row-click-last cell-click cell-click-top cell-click-left cell-click-left-first"), e(".matrix-filter", s).hide()
    }
    function E() {
        a.airline = null, a.scale = null, a.item = null, a.itemValidator = null, f = !1
    }
    var i = "matrix",
        s = null,
        o = null,
        u = null,
        a = {
            airline: null,
            scale: null,
            item: null,
            itemValidator: null
        }, f = !1;
    return {
        init: l
    }
}),
function (e) {
    function O(e, t, n, r) {
        var i = n.lang();
        return i[e].call ? i[e](n, r) : i[e][t]
    }
    function M(e, t) {
        return function (n) {
            return B(e.call(this, n), t)
        }
    }
    function _(e) {
        return function (t) {
            var n = e.call(this, t);
            return n + this.lang().ordinal(n)
        }
    }
    function D(e, t, n) {
        this._d = e, this._isUTC = !! t, this._a = e._a || null, this._lang = n || !1
    }
    function P(e) {
        var t = this._data = {}, n = e.years || e.y || 0,
            r = e.months || e.M || 0,
            i = e.weeks || e.w || 0,
            s = e.days || e.d || 0,
            o = e.hours || e.h || 0,
            u = e.minutes || e.m || 0,
            a = e.seconds || e.s || 0,
            f = e.milliseconds || e.ms || 0;
        this._milliseconds = f + a * 1e3 + u * 6e4 + o * 36e5, this._days = s + i * 7, this._months = r + n * 12, t.milliseconds = f % 1e3, a += H(f / 1e3), t.seconds = a % 60, u += H(a / 60), t.minutes = u % 60, o += H(u / 60), t.hours = o % 24, s += H(o / 24), s += i * 7, t.days = s % 30, r += H(s / 30), t.months = r % 12, n += H(r / 12), t.years = n, this._lang = !1
    }
    function H(e) {
        return e < 0 ? Math.ceil(e) : Math.floor(e)
    }
    function B(e, t) {
        var n = e + "";
        while (n.length < t) n = "0" + n;
        return n
    }
    function j(e, t, n) {
        var r = t._milliseconds,
            i = t._days,
            s = t._months,
            o;
        r && e._d.setTime(+e + r * n), i && e.date(e.date() + i * n), s && (o = e.date(), e.date(1).month(e.month() + s * n).date(Math.min(o, e.daysInMonth())))
    }
    function F(e) {
        return Object.prototype.toString.call(e) === "[object Array]"
    }
    function I(e, t) {
        var n = Math.min(e.length, t.length),
            r = Math.abs(e.length - t.length),
            i = 0,
            s;
        for (s = 0; s < n; s++)~~ e[s] !== ~~t[s] && i++;
        return i + r
    }
    function q(e, t, n, r) {
        var i, s, o = [];
        for (i = 0; i < 7; i++) o[i] = e[i] = e[i] == null ? i === 2 ? 1 : 0 : e[i];
        return e[7] = o[7] = t, e[8] != null && (o[8] = e[8]), e[3] += n || 0, e[4] += r || 0, s = new Date(0), t ? (s.setUTCFullYear(e[0], e[1], e[2]), s.setUTCHours(e[3], e[4], e[5], e[6])) : (s.setFullYear(e[0], e[1], e[2]), s.setHours(e[3], e[4], e[5], e[6])), s._a = o, s
    }
    function R(e, n) {
        var r, i, o = [];
        !n && u && (n = require("./lang/" + e));
        for (r = 0; r < a.length; r++) n[a[r]] = n[a[r]] || s.en[a[r]];
        for (r = 0; r < 12; r++) i = t([2e3, r]), o[r] = new RegExp("^" + (n.months[r] || n.months(i, "")) + "|^" + (n.monthsShort[r] || n.monthsShort(i, "")).replace(".", ""), "i");
        return n.monthsParse = n.monthsParse || o, s[e] = n, n
    }
    function U(e) {
        var n = typeof e == "string" && e || e && e._lang || null;
        return n ? s[n] || R(n) : t
    }
    function z(e) {
        return e.match(/\[.*\]/) ? e.replace(/^\[|\]$/g, "") : e.replace(/\\/g, "")
    }
    function W(e) {
        var t = e.match(l),
            n, r;
        for (n = 0, r = t.length; n < r; n++) A[t[n]] ? t[n] = A[t[n]] : t[n] = z(t[n]);
        return function (i) {
            var s = "";
            for (n = 0; n < r; n++) s += typeof t[n].call == "function" ? t[n].call(i, e) : t[n];
            return s
        }
    }
    function X(e, t) {
        function r(t) {
            return e.lang().longDateFormat[t] || t
        }
        var n = 5;
        while (n-- && c.test(t)) t = t.replace(c, r);
        return C[t] || (C[t] = W(t)), C[t](e)
    }
    function V(e) {
        switch (e) {
            case "DDDD":
                return v;
            case "YYYY":
                return m;
            case "S":
            case "SS":
            case "SSS":
            case "DDD":
                return d;
            case "MMM":
            case "MMMM":
            case "dd":
            case "ddd":
            case "dddd":
            case "a":
            case "A":
                return g;
            case "Z":
            case "ZZ":
                return y;
            case "T":
                return b;
            case "MM":
            case "DD":
            case "YY":
            case "HH":
            case "hh":
            case "mm":
            case "ss":
            case "M":
            case "D":
            case "d":
            case "H":
            case "h":
            case "m":
            case "s":
                return p;
            default:
                return new RegExp(e.replace("\\", ""))
        }
    }
    function $(e, t, n, r) {
        var i, s;
        switch (e) {
            case "M":
            case "MM":
                n[1] = t == null ? 0 : ~~t - 1;
                break;
            case "MMM":
            case "MMMM":
                for (i = 0; i < 12; i++) if (U().monthsParse[i].test(t)) {
                        n[1] = i, s = !0;
                        break
                    }
                s || (n[8] = !1);
                break;
            case "D":
            case "DD":
            case "DDD":
            case "DDDD":
                t != null && (n[2] = ~~t);
                break;
            case "YY":
                n[0] = ~~t + (~~t > 70 ? 1900 : 2e3);
                break;
            case "YYYY":
                n[0] = ~~Math.abs(t);
                break;
            case "a":
            case "A":
                r.isPm = (t + "").toLowerCase() === "pm";
                break;
            case "H":
            case "HH":
            case "h":
            case "hh":
                n[3] = ~~t;
                break;
            case "m":
            case "mm":
                n[4] = ~~t;
                break;
            case "s":
            case "ss":
                n[5] = ~~t;
                break;
            case "S":
            case "SS":
            case "SSS":
                n[6] = ~~ (("0." + t) * 1e3);
                break;
            case "Z":
            case "ZZ":
                r.isUTC = !0, i = (t + "").match(x), i && i[1] && (r.tzh = ~~i[1]), i && i[2] && (r.tzm = ~~i[2]), i && i[0] === "+" && (r.tzh = -r.tzh, r.tzm = -r.tzm)
        }
        t == null && (n[8] = !1)
    }
    function J(e, t) {
        var n = [0, 0, 1, 0, 0, 0, 0],
            r = {
                tzh: 0,
                tzm: 0
            }, i = t.match(l),
            s, o;
        for (s = 0; s < i.length; s++) o = (V(i[s]).exec(e) || [])[0], o && (e = e.slice(e.indexOf(o) + o.length)), A[i[s]] && $(i[s], o, n, r);
        return r.isPm && n[3] < 12 && (n[3] += 12), r.isPm === !1 && n[3] === 12 && (n[3] = 0), q(n, r.isUTC, r.tzh, r.tzm)
    }
    function K(e, t) {
        var n, r = e.match(h) || [],
            i, s = 99,
            o, u, a;
        for (o = 0; o < t.length; o++) u = J(e, t[o]), i = X(new D(u), t[o]).match(h) || [], a = I(r, i), a < s && (s = a, n = u);
        return n
    }
    function Q(e) {
        var t = "YYYY-MM-DDT",
            n;
        if (w.exec(e)) {
            for (n = 0; n < 4; n++) if (S[n][1].exec(e)) {
                    t += S[n][0];
                    break
                }
            return y.exec(e) ? J(e, t + " Z") : J(e, t)
        }
        return new Date(e)
    }
    function G(e, t, n, r, i) {
        var s = i.relativeTime[e];
        return typeof s == "function" ? s(t || 1, !! n, e, r) : s.replace(/%d/i, t || 1)
    }
    function Y(e, t, n) {
        var i = r(Math.abs(e) / 1e3),
            s = r(i / 60),
            o = r(s / 60),
            u = r(o / 24),
            a = r(u / 365),
            f = i < 45 && ["s", i] || s === 1 && ["m"] || s < 45 && ["mm", s] || o === 1 && ["h"] || o < 22 && ["hh", o] || u === 1 && ["d"] || u <= 25 && ["dd", u] || u <= 45 && ["M"] || u < 345 && ["MM", r(u / 30)] || a === 1 && ["y"] || ["yy", a];
        return f[2] = t, f[3] = e > 0, f[4] = n, G.apply({}, f)
    }
    function Z(e, n) {
        t.fn[e] = function (e) {
            var t = this._isUTC ? "UTC" : "";
            return e != null ? (this._d["set" + t + n](e), this) : this._d["get" + t + n]()
        }
    }
    function et(e) {
        t.duration.fn[e] = function () {
            return this._data[e]
        }
    }
    function tt(e, n) {
        t.duration.fn["as" + e] = function () {
            return +this / n
        }
    }
    var t, n = "1.7.2",
        r = Math.round,
        i, s = {}, o = "en",
        u = typeof module != "undefined" && module.exports,
        a = "months|monthsShort|weekdays|weekdaysShort|weekdaysMin|longDateFormat|calendar|relativeTime|ordinal|meridiem".split("|"),
        f = /^\/?Date\((\-?\d+)/i,
        l = /(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|YYYY|YY|a|A|hh?|HH?|mm?|ss?|SS?S?|zz?|ZZ?|.)/g,
        c = /(\[[^\[]*\])|(\\)?(LT|LL?L?L?)/g,
        h = /([0-9a-zA-Z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)/gi,
        p = /\d\d?/,
        d = /\d{1,3}/,
        v = /\d{3}/,
        m = /\d{1,4}/,
        g = /[0-9a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+/i,
        y = /Z|[\+\-]\d\d:?\d\d/i,
        b = /T/i,
        w = /^\s*\d{4}-\d\d-\d\d(T(\d\d(:\d\d(:\d\d(\.\d\d?\d?)?)?)?)?([\+\-]\d\d:?\d\d)?)?/,
        E = "YYYY-MM-DDTHH:mm:ssZ",
        S = [
            ["HH:mm:ss.S", /T\d\d:\d\d:\d\d\.\d{1,3}/],
            ["HH:mm:ss", /T\d\d:\d\d:\d\d/],
            ["HH:mm", /T\d\d:\d\d/],
            ["HH", /T\d\d/]
        ],
        x = /([\+\-]|\d\d)/gi,
        T = "Month|Date|Hours|Minutes|Seconds|Milliseconds".split("|"),
        N = {
            Milliseconds: 1,
            Seconds: 1e3,
            Minutes: 6e4,
            Hours: 36e5,
            Days: 864e5,
            Months: 2592e6,
            Years: 31536e6
        }, C = {}, k = "DDD w M D d".split(" "),
        L = "M D H h m s w".split(" "),
        A = {
            M: function () {
                return this.month() + 1
            },
            MMM: function (e) {
                return O("monthsShort", this.month(), this, e)
            },
            MMMM: function (e) {
                return O("months", this.month(), this, e)
            },
            D: function () {
                return this.date()
            },
            DDD: function () {
                var e = new Date(this.year(), this.month(), this.date()),
                    t = new Date(this.year(), 0, 1);
                return~~ ((e - t) / 864e5 + 1.5)
            },
            d: function () {
                return this.day()
            },
            dd: function (e) {
                return O("weekdaysMin", this.day(), this, e)
            },
            ddd: function (e) {
                return O("weekdaysShort", this.day(), this, e)
            },
            dddd: function (e) {
                return O("weekdays", this.day(), this, e)
            },
            w: function () {
                var e = new Date(this.year(), this.month(), this.date() - this.day() + 5),
                    t = new Date(e.getFullYear(), 0, 4);
                return~~ ((e - t) / 864e5 / 7 + 1.5)
            },
            YY: function () {
                return B(this.year() % 100, 2)
            },
            YYYY: function () {
                return B(this.year(), 4)
            },
            a: function () {
                return this.lang().meridiem(this.hours(), this.minutes(), !0)
            },
            A: function () {
                return this.lang().meridiem(this.hours(), this.minutes(), !1)
            },
            H: function () {
                return this.hours()
            },
            h: function () {
                return this.hours() % 12 || 12
            },
            m: function () {
                return this.minutes()
            },
            s: function () {
                return this.seconds()
            },
            S: function () {
                return~~ (this.milliseconds() / 100)
            },
            SS: function () {
                return B(~~(this.milliseconds() / 10), 2)
            },
            SSS: function () {
                return B(this.milliseconds(), 3)
            },
            Z: function () {
                var e = -this.zone(),
                    t = "+";
                return e < 0 && (e = -e, t = "-"), t + B(~~(e / 60), 2) + ":" + B(~~e % 60, 2)
            },
            ZZ: function () {
                var e = -this.zone(),
                    t = "+";
                return e < 0 && (e = -e, t = "-"), t + B(~~(10 * e / 6), 4)
            }
        };
    while (k.length) i = k.pop(), A[i + "o"] = _(A[i]);
    while (L.length) i = L.pop(), A[i + i] = M(A[i], 2);
    A.DDDD = M(A.DDD, 3), t = function (n, r) {
        if (n === null || n === "") return null;
        var i, s;
        return t.isMoment(n) ? new D(new Date(+n._d), n._isUTC, n._lang) : (r ? F(r) ? i = K(n, r) : i = J(n, r) : (s = f.exec(n), i = n === e ? new Date : s ? new Date(+s[1]) : n instanceof Date ? n : F(n) ? q(n) : typeof n == "string" ? Q(n) : new Date(n)), new D(i))
    }, t.utc = function (e, n) {
        return F(e) ? new D(q(e, !0), !0) : (typeof e == "string" && !y.exec(e) && (e += " +0000", n && (n += " Z")), t(e, n).utc())
    }, t.unix = function (e) {
        return t(e * 1e3)
    }, t.duration = function (e, n) {
        var r = t.isDuration(e),
            i = typeof e == "number",
            s = r ? e._data : i ? {} : e,
            o;
        return i && (n ? s[n] = e : s.milliseconds = e), o = new P(s), r && (o._lang = e._lang), o
    }, t.humanizeDuration = function (e, n, r) {
        return t.duration(e, n === !0 ? null : n).humanize(n === !0 ? !0 : r)
    }, t.version = n, t.defaultFormat = E, t.lang = function (e, n) {
        var r;
        if (!e) return o;
        (n || !s[e]) && R(e, n);
        if (s[e]) {
            for (r = 0; r < a.length; r++) t[a[r]] = s[e][a[r]];
            t.monthsParse = s[e].monthsParse, o = e
        }
    }, t.langData = U, t.isMoment = function (e) {
        return e instanceof D
    }, t.isDuration = function (e) {
        return e instanceof P
    }, t.lang("en", {
        months: "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
        monthsShort: "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
        weekdays: "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
        weekdaysShort: "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
        weekdaysMin: "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
        longDateFormat: {
            LT: "h:mm A",
            L: "MM/DD/YYYY",
            LL: "MMMM D YYYY",
            LLL: "MMMM D YYYY LT",
            LLLL: "dddd, MMMM D YYYY LT"
        },
        meridiem: function (e, t, n) {
            return e > 11 ? n ? "pm" : "PM" : n ? "am" : "AM"
        },
        calendar: {
            sameDay: "[Today at] LT",
            nextDay: "[Tomorrow at] LT",
            nextWeek: "dddd [at] LT",
            lastDay: "[Yesterday at] LT",
            lastWeek: "[last] dddd [at] LT",
            sameElse: "L"
        },
        relativeTime: {
            future: "in %s",
            past: "%s ago",
            s: "a few seconds",
            m: "a minute",
            mm: "%d minutes",
            h: "an hour",
            hh: "%d hours",
            d: "a day",
            dd: "%d days",
            M: "a month",
            MM: "%d months",
            y: "a year",
            yy: "%d years"
        },
        ordinal: function (e) {
            var t = e % 10;
            return~~ (e % 100 / 10) === 1 ? "th" : t === 1 ? "st" : t === 2 ? "nd" : t === 3 ? "rd" : "th"
        }
    }), t.fn = D.prototype = {
        clone: function () {
            return t(this)
        },
        valueOf: function () {
            return +this._d
        },
        unix: function () {
            return Math.floor(+this._d / 1e3)
        },
        toString: function () {
            return this._d.toString()
        },
        toDate: function () {
            return this._d
        },
        toArray: function () {
            var e = this;
            return [e.year(), e.month(), e.date(), e.hours(), e.minutes(), e.seconds(), e.milliseconds(), !! this._isUTC]
        },
        isValid: function () {
            return this._a ? this._a[8] != null ? !! this._a[8] : !I(this._a, (this._a[7] ? t.utc(this._a) : t(this._a)).toArray()) : !isNaN(this._d.getTime())
        },
        utc: function () {
            return this._isUTC = !0, this
        },
        local: function () {
            return this._isUTC = !1, this
        },
        format: function (e) {
            return X(this, e ? e : t.defaultFormat)
        },
        add: function (e, n) {
            var r = n ? t.duration(+n, e) : t.duration(e);
            return j(this, r, 1), this
        },
        subtract: function (e, n) {
            var r = n ? t.duration(+n, e) : t.duration(e);
            return j(this, r, -1), this
        },
        diff: function (e, n, i) {
            var s = this._isUTC ? t(e).utc() : t(e).local(),
                o = (this.zone() - s.zone()) * 6e4,
                u = this._d - s._d - o,
                a = this.year() - s.year(),
                f = this.month() - s.month(),
                l = this.date() - s.date(),
                c;
            return n === "months" ? c = a * 12 + f + l / 30 : n === "years" ? c = a + (f + l / 30) / 12 : c = n === "seconds" ? u / 1e3 : n === "minutes" ? u / 6e4 : n === "hours" ? u / 36e5 : n === "days" ? u / 864e5 : n === "weeks" ? u / 6048e5 : u, i ? c : r(c)
        },
        from: function (e, n) {
            return t.duration(this.diff(e)).lang(this._lang).humanize(!n)
        },
        fromNow: function (e) {
            return this.from(t(), e)
        },
        calendar: function () {
            var e = this.diff(t().sod(), "days", !0),
                n = this.lang().calendar,
                r = n.sameElse,
                i = e < -6 ? r : e < -1 ? n.lastWeek : e < 0 ? n.lastDay : e < 1 ? n.sameDay : e < 2 ? n.nextDay : e < 7 ? n.nextWeek : r;
            return this.format(typeof i == "function" ? i.apply(this) : i)
        },
        isLeapYear: function () {
            var e = this.year();
            return e % 4 === 0 && e % 100 !== 0 || e % 400 === 0
        },
        isDST: function () {
            return this.zone() < t([this.year()]).zone() || this.zone() < t([this.year(), 5]).zone()
        },
        day: function (e) {
            var t = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
            return e == null ? t : this.add({
                d: e - t
            })
        },
        startOf: function (e) {
            switch (e.replace(/s$/, "")) {
                case "year":
                    this.month(0);
                case "month":
                    this.date(1);
                case "day":
                    this.hours(0);
                case "hour":
                    this.minutes(0);
                case "minute":
                    this.seconds(0);
                case "second":
                    this.milliseconds(0)
            }
            return this
        },
        endOf: function (e) {
            return this.startOf(e).add(e.replace(/s?$/, "s"), 1).subtract("ms", 1)
        },
        sod: function () {
            return this.clone().startOf("day")
        },
        eod: function () {
            return this.clone().endOf("day")
        },
        zone: function () {
            return this._isUTC ? 0 : this._d.getTimezoneOffset()
        },
        daysInMonth: function () {
            return t.utc([this.year(), this.month() + 1, 0]).date()
        },
        lang: function (t) {
            return t === e ? U(this) : (this._lang = t, this)
        }
    };
    for (i = 0; i < T.length; i++) Z(T[i].toLowerCase(), T[i]);
    Z("year", "FullYear"), t.duration.fn = P.prototype = {
        weeks: function () {
            return H(this.days() / 7)
        },
        valueOf: function () {
            return this._milliseconds + this._days * 864e5 + this._months * 2592e6
        },
        humanize: function (e) {
            var t = +this,
                n = this.lang().relativeTime,
                r = Y(t, !e, this.lang()),
                i = t <= 0 ? n.past : n.future;
            return e && (typeof i == "function" ? r = i(r) : r = i.replace(/%s/i, r)), r
        },
        lang: t.fn.lang
    };
    for (i in N) N.hasOwnProperty(i) && (tt(i, N[i]), et(i.toLowerCase()));
    tt("Weeks", 6048e5), u && (module.exports = t), typeof ender == "undefined" && (this.moment = t), typeof define == "function" && define.amd && define("moment", [], function () {
        return t
    })
}.call(this), define("core-flights/custom/moment", function () {}),
/*
define("core-flights/modules/flights-alerts/flights-alerts", ["jquery", "amplify", "handlebars", "core-flights/logger", "core-flights/popup", "nibbler.alerts", "core-flights/tmpl-helpers", "core-flights/custom/moment"], function (e, t, n, r, i, s) {
    function h(s) {
        r.info("Initializing Flights Alerts."), s.show === !0 && (o = e("#flights-alerts"), u = n.compile(e("#flights-alerts-template").html()), a = s, (a.bestPrice !== undefined || a.noBestPrice) && p(a.bestPrice), t.subscribe("nibbler.alerts.response", function (t, n, r) {
            e("#popup-flights-alerts").hide();
            var s;
            t === !0 && n.data == "OK" ? s = e("#popup-flights-alerts-success-template") : s = e("#popup-flights-alerts-error-template"), r.extra != undefined && (r.extra.destinationDescription = r.extra.destinationDescription.replace(/ *\([^\)]*\)/, "")), i.openPopup({
                elementTrigger: this,
                id: "popup-flights-alerts-message",
                $template: s,
                $data: r,
                popupPosition: "fixed",
                indicator: !1,
                showModal: !0
            })
        }), t.subscribe("changeCurrency", function (e) {
            l = e, v()
        }))
    }
    function p(e) {
        o.append(u(e)), o.show(), y(), d(e), b()
    }
    function d(e) {
        f = e, l === null && f != null && (l = f[0].formatted.code), v(), m(), g()
    }
    function v(e) {
        if (f != null) for (var t = 0; t < f.length; t++) {
                var e = f[t];
                if (e.formatted.code == l) {
                    var n = e.formatted.amount;
                    n = n.replace(".", ""), a.config.model.price = {
                        currencyCode: e.formatted.code,
                        amount: n
                    }
                }
        }
    }
    function m() {
        if (a.config.outboundDate !== undefined && a.config.inboundDate !== undefined) {
            var e = moment(a.config.outboundDate, "YYYY-MM-DD"),
                t = moment(a.config.inboundDate, "YYYY-MM-DD");
            duration = t.diff(e, "days") + 1, duration > 10 && duration <= 12 ? duration = 10 : duration > 12 && duration <= 22 ? duration = 14 : duration > 22 && (duration = 30), a.config.model.duration = duration
        }
    }
    function g() {
        var e = [];
        if (a.config.outboundDate !== undefined && a.config.inboundDate !== undefined) {
            var t = moment(a.config.outboundDate, "YYYY-MM-DD"),
                n = moment(a.config.inboundDate, "YYYY-MM-DD"),
                r = parseInt(n.diff(t, "months", !0));
            for (var i = 0; i <= r; i++) e.push(c[t.month()] + "-" + t.year()), t.add("months", 1)
        }
        a.config.model.months = e
    }
    function y() {
        o.on("mouseenter mouseleave", function (t) {
            t.handleObj.origType == "mouseenter" ? i.openPopup({
                elementTrigger: this,
                id: "popup-flights-alerts-description",
                $template: e("#popup-flights-alerts-template"),
                popupPosition: "bottom",
                indicator: !1,
                indicatorPosition: "top",
                hideCloseIcon: !0
            }) : e("#popup-flights-alerts-description").hide()
        })
    }
    function b() {
        o.on("click", function (t) {
            s.render(a.config), i.togglePopup({
                elementTrigger: this,
                id: "popup-flights-alerts",
                $content: e("#flights-alerts-popup").show(),
                popupPosition: "fixed",
                indicator: !1,
                showModal: !0
            }), s.init()
        })
    }
    var o = null,
        u = null,
        a, f = null,
        l = null,
        c = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
    return {
        init: h,
        showAlert: p
    }
}), */
function (e, t) {
    "$:nomunge";

    function N(e) {
        return typeof e == "string"
    }
    function C(e) {
        var t = r.call(arguments, 1);
        return function () {
            return e.apply(this, t.concat(r.call(arguments)))
        }
    }
    function k(e) {
        return e.replace(/^[^#]*#?(.*)$/, "$1")
    }
    function L(e) {
        return e.replace(/(?:^[^?#]*\?([^#]*).*$)?.*/, "$1")
    }
    function A(r, o, a, f, l) {
        var c, h, p, d, g;
        return f !== n ? (p = a.match(r ? /^([^#]*)\#?(.*)$/ : /^([^#?]*)\??([^#]*)(#?.*)/), g = p[3] || "", l === 2 && N(f) ? h = f.replace(r ? S : E, "") : (d = u(p[2]), f = N(f) ? u[r ? m : v](f) : f, h = l === 2 ? f : l === 1 ? e.extend({}, f, d) : e.extend({}, d, f), h = s(h), r && (h = h.replace(x, i))), c = p[1] + (r ? "#" : h || !p[1] ? "?" : "") + h + g) : c = o(a !== n ? a : t[y][b]), c
    }
    function O(e, t, r) {
        return t === n || typeof t == "boolean" ? (r = t, t = s[e ? m : v]()) : t = N(t) ? t.replace(e ? S : E, "") : t, u(t, r)
    }
    function M(t, r, i, o) {
        return !N(i) && typeof i != "object" && (o = i, i = r, r = n), this.each(function () {
            var n = e(this),
                u = r || h()[(this.nodeName || "").toLowerCase()] || "",
                a = u && n.attr(u) || "";
            n.attr(u, s[t](a, i, o))
        })
    }
    var n, r = Array.prototype.slice,
        i = decodeURIComponent,
        s = e.param,
        o, u, a, f = e.bbq = e.bbq || {}, l, c, h, p = e.event.special,
        d = "hashchange",
        v = "querystring",
        m = "fragment",
        g = "elemUrlAttr",
        y = "location",
        b = "href",
        w = "src",
        E = /^.*\?|#.*$/g,
        S = /^.*\#/,
        x, T = {};
    s[v] = C(A, 0, L), s[m] = o = C(A, 1, k), o.noEscape = function (t) {
        t = t || "";
        var n = e.map(t.split(""), encodeURIComponent);
        x = new RegExp(n.join("|"), "g")
    }, o.noEscape(",/"), e.deparam = u = function (t, r) {
        var s = {}, o = {
                "true": !0,
                "false": !1,
                "null": null
            };
        return e.each(t.replace(/\+/g, " ").split("&"), function (t, u) {
            var a = u.split("="),
                f = i(a[0]),
                l, c = s,
                h = 0,
                p = f.split("]["),
                d = p.length - 1;
            /\[/.test(p[0]) && /\]$/.test(p[d]) ? (p[d] = p[d].replace(/\]$/, ""), p = p.shift().split("[").concat(p), d = p.length - 1) : d = 0;
            if (a.length === 2) {
                l = i(a[1]), r && (l = l && !isNaN(l) ? +l : l === "undefined" ? n : o[l] !== n ? o[l] : l);
                if (d) for (; h <= d; h++) f = p[h] === "" ? c.length : p[h], c = c[f] = h < d ? c[f] || (p[h + 1] && isNaN(p[h + 1]) ? {} : []) : l;
                else e.isArray(s[f]) ? s[f].push(l) : s[f] !== n ? s[f] = [s[f], l] : s[f] = l
            } else f && (s[f] = r ? n : "")
        }), s
    }, u[v] = C(O, 0), u[m] = a = C(O, 1), e[g] || (e[g] = function (t) {
        return e.extend(T, t)
    })({
        a: b,
        base: b,
        iframe: w,
        img: w,
        input: w,
        form: "action",
        link: b,
        script: w
    }), h = e[g], e.fn[v] = C(M, v), e.fn[m] = C(M, m), f.pushState = l = function (e, r) {
        N(e) && /^#/.test(e) && r === n && (r = 2);
        var i = e !== n,
            s = o(t[y][b], i ? e : {}, i ? r : 2);
        t[y][b] = s + (/#/.test(s) ? "" : "#")
    }, f.getState = c = function (e, t) {
        return e === n || typeof e == "boolean" ? a(e) : a(t)[e]
    }, f.removeState = function (t) {
        var r = {};
        t !== n && (r = c(), e.each(e.isArray(t) ? t : arguments, function (e, t) {
            delete r[t]
        })), l(r, 2)
    }, p[d] = e.extend(p[d], {
        add: function (t) {
            function i(e) {
                var t = e[m] = o();
                e.getState = function (e, r) {
                    return e === n || typeof e == "boolean" ? u(t, e) : u(t, r)[e]
                }, r.apply(this, arguments)
            }
            var r;
            if (e.isFunction(t)) return r = t, i;
            r = t.handler, t.handler = i
        }
    })
}(jQuery, this), /*
function (e, t, n) {
    "$:nomunge";

    function h(e) {
        return e = e || t[s][u], e.replace(/^[^#]*#?(.*)$/, "$1")
    }
    var r, i = e.event.special,
        s = "location",
        o = "hashchange",
        u = "href",
        a = e.browser,
        f = document.documentMode,
        l = a.msie && (f === n || f < 8),
        c = "on" + o in t && !l;
    e[o + "Delay"] = 100, i[o] = e.extend(i[o], {
        setup: function () {
            if (c) return !1;
            e(r.start)
        },
        teardown: function () {
            if (c) return !1;
            e(r.stop)
        }
    }), r = function () {
        function c() {
            a = f = function (e) {
                return e
            }, l && (i = e('<iframe src="javascript:0"/>').hide().insertAfter("body")[0].contentWindow, f = function () {
                return h(i.document[s][u])
            }, a = function (e, t) {
                if (e !== t) {
                    var n = i.document;
                    n.open().close(), n[s].hash = "#" + e
                }
            }, a(h()))
        }
        var n = {}, r, i, a, f;
        return n.start = function () {
            if (r) return;
            var n = h();
            a || c(),
            function i() {
                var l = h(),
                    c = f(n);
                l !== n ? (a(n = l, c), e(t).trigger(o)) : c !== n && (t[s][u] = t[s][u].replace(/#.*  /, "") + "#" + c), r = setTimeout(i, e[o + "Delay"])
            }()
        }, n.stop = function () {
            i || (r && clearTimeout(r), r = 0)
        }, n
    }()
}(jQuery, this),*/ define("custom/bbq", function () {}), define("results/history", ["jquery", "amplify", "custom/bbq"], function (e, t) {
    function o() {
        t.subscribe("doSearch", function (n) {
            var r = e.deparam.fragment();
            if (!e.isEmptyObject(r)) {
                var i = {
                    id: "history",
                    action: "back"
                };
                s = !0, r.itemHash ? (e.bbq.removeState(["hash", "version", "itemHash"]), t.publish("item", r.itemHash, i)) : (e.bbq.pushState({}, 2), t.publish("refine", "update", r, i))
            }
        }), t.subscribe("doRefine", function (e, t, r, s) {
            n = "refine", i = r
        }), t.subscribe("doItem", function (e, t) {
            n = "item", r = t
        }), t.subscribe("checkout", function () {
            var t = {}, s = {};
            n == "item" ? s = r : s = i, e.isEmptyObject(s) || (e.each(s, function (e, n) {
                t[e] = n
            }), e.bbq.pushState(t))
        })
    }
    var n = null,
        r = {}, i = {}, s;
    return {
        init: o
    }
}), define("results/results", ["jquery", "amplify", "results/layout", "modules/filters/layout", "modules/order/order", "modules/title/title", "modules/clusters/clusters", "modules/filters/filters", "modules/pagination/pagination", "modules/reviews/reviews",  "results/history", "core-flights/utils", "core-flights/logger"], function (e, t, n, r,  s, o, u, a, f, l, p, d, v) {
    function N(m, g, b) {
        v.info("Initializing Results."), E = g.initialCurrency, S = g.orderCriteria, x = g.orderDirection, T = g.personalSortId, t.request.define("refine", "ajax", {
            url: m.refine,
            type: "GET"
        }), t.request.define("item", "ajax", {
            url: m.item,
            type: "GET"
        }), v.info("Getting data from search service."), e.ajax({
            url: m.search,
            type: "GET",
            dataType: "json",
            success: function (e, t) {
                C(e)
            },
            error: function (e, t) {
                k()
            }
        }), n.init(), s.init(), o.init(b.title), u.init(g.clusters, b.clusters), a.init(b.filters), r.init(b.filters), f.init(), l.init(),  p.init(), d.showCurrency(g.initialCurrency, "results"), t.subscribe("doSearch", function (t) {
            e("#cross-sell").show()/*,  h.showAlert(t.result.data.pricesSummary.bestPrice) */
        }), t.subscribe("refine", function (e, t, n) {
            n.id != "pagination" && _({
                pageIndex: y.pageIndex
            }), n.id != "matrix" && _({
                filterStrategy: y.filterStrategy
            }), _(t, e), L(e, n, b)
        }), t.subscribe("item", function (e, t) {
            A(e, t)
        }), t.subscribe("changeCurrency", function (e) {
            _({
                selectedCurrencyPrice: e
            })
        })
    }
    function C(e) {
        e.result.data.metadata.status.code == "SUCCEEDED" || e.result.data.metadata.status.code == "SUCCEEDED_RELAXED" ? (v.info("Success! Publishing search results!"), m = e.result.data.metadata.ticket, _({
            hash: m.hash,
            version: m.version,
            originalCurrencyPrice: e.result.data.metadata.currencyCode,
            selectedCurrencyPrice: E,
            orderCriteria: S,
            orderDirection: x
        }), t.publish("doSearch", e), O(e.result.data.items)) : (t.publish("resultsError"), D(e.result.data.metadata.status.code))
    }
    function k() {
        t.publish("resultsError"), D("FATAL_ERROR")
    }
    function L(e, n, r) {
        v.info("Getting filter data."), t.request({
            resourceId: "refine",
            data: g,
            success: function (r, i) {
                if (r.result.data.metadata.status.code == "SUCCEEDED" || r.result.data.metadata.status.code == "SUCCEEDED_RELAXED") v.info("Success! Publishing filter data!"), t.publish("doRefine", r, e, g, n), O(r.result.data.items);
                else {
                    var s = !0;
                    n.action == "price" && t.publish("refineError", !1), t.publish("refineError", s), D(r.result.data.metadata.status.code)
                }
            },
            error: function (e, n) {
                t.publish("refineError", !0), D("FATAL_ERROR")
            }
        })
    }
    function A(e, n) {
        v.info("Getting items data."), b = {
            hash: m.hash,
            version: m.version,
            itemHash: e
        }, t.request({
            resourceId: "item",
            data: b,
            success: function (e) {
                e.result.data.metadata.status.code == "SUCCEEDED" ? (v.info("Success! Publishing items!"), t.publish("doItem", e, b, n)) : (t.publish("refineError", !1), D("FATAL_ERROR"))
            },
            error: function () {
                D("FATAL_ERROR")
            }
        })
    }
    function O(e) {
        w.ticket = m, w.items = e
    }
    function M() {
        return w
    }
    function _(n, r) {
        switch (r) {
            case "clear":
                g = e.extend(g, y);
                break;
            case "new":
                g = e.extend(e.extend(g, y), n);
                break;
            default:
                g = e.extend(g, n)
        }
        g.orderCriteria == "PERSONAL" ? g.personalSortId = T : delete g.personalSortId, t.publish("refineParamsChanged", g)
    }
    function D(e) {
        switch (e) {
            case "NO_RESULTS":
                v.warn("[WARN] Don't exists results in the data service.");
                break;
            case "VALIDATION_ERROR":
                v.warn("[WARN] The service return a validation error.");
                break;
            case "ERROR":
                v.warn("[ERROR] There was an error in the data service.");
                break;
            case "FATAL_ERROR":
                v.warn("[ERROR] There was a fatal error in the data service.");
                break;
            case "NULL_ITEM_PARAMETER":
                v.warn("[ERROR] Incorrect parameters sended to the service.");
                break;
            default:
                v.warn("[WARN] There was an unknow error in the data service.")
        }
    }
    var m = {}, g = {
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
        }, y = {
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
        }, b = {}, w = {}, E, S, x, T;
    return {
        init: N,
        getDebug: M
    }
}), require(["services", "options", "messages", "searchbox", "results/results"], function (e, t, n, r, i) {
    $(function () {
//    	 if (amplify.store("preferedCurrency")) {
//    		 t.initialCurrency = amplify.store('preferedCurrency');
//    		 t.clusters.initialCurrencyCode = amplify.store('preferedCurrency');
//    		 // $(".currency select").val(amplify.store('preferedCurrency'));
//    		 amplify.publish("changeCurrency", amplify.store('preferedCurrency'));
//         }

    	 i.init(e, t, n), r.init()
    })
}), define("pkg/results", function () {})
