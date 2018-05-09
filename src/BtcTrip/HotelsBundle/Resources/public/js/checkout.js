/*!
FRAMEWORK_VERSION:8.3.5
*/
registerNameSpace("CheckoutHotels.Checkout");
CheckoutHotels.Checkout = (function (e, h) {
    var f;
    var d;

    function g(i) {
        logger.info("[INFO] Initializing Checkout.");
        b();
        f = i.countryCode;
        d = i.formattedAppVersion;
        window.X_UOW = i.uow;
        CheckoutHotels.Common.Modules.Detail.init(i.messages.detail);
        CheckoutHotels.Checkout.Modules.Form.init(i)
    }
    function a() {
        return f
    }
    function c() {
        return d
    }
    function b() {
        var m = e("#cookie-value");
        var l = document.cookie.split("; ");
        var j;
        for (var k in l) {
            j = l[k].split("=")[0];
            if (j == "X-Version-Override") {
                m.html(l[k]).show();
                return false
            }
        }
    }
    return {
        init: g,
        getCountryCode: a,
        getFormattedAppVersion: c
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Checkout.Modules.Form");
CheckoutHotels.Checkout.Modules.Form = (function (g, c) {
    var b;
    var k;
    var a;

    function o(q) {
        logger.info("[INFO] Initializing Form.");
        b = g("#form");
        k = q.optionsProviders;
        a = CheckoutHotels.Common.Validator;
        CheckoutHotels.Checkout.Modules.Form.Passengers.init(q.flowDependencies, a, q.fastCheckoutData);
        CheckoutHotels.Checkout.Modules.Form.Payment.init(b, a);
        CheckoutHotels.Checkout.Modules.Form.Invoice.init(a);
        CheckoutHotels.Checkout.Modules.Form.Contact.init(a, q.fastCheckoutData);
        CheckoutHotels.Checkout.Modules.Form.Agreement.init(q.messages.form.agreement, a);
        CheckoutHotels.Checkout.Modules.Form.Additionals.init(a);
        CheckoutHotels.Checkout.Modules.Form.Currency.init(a);
        CheckoutHotels.Checkout.Modules.Form.Buy.init(b, a);
        if (q.flowDependencies.isNewHotel) {
            CheckoutHotels.Checkout.Modules.NewHotel.NewHotel.init(q.sessionId, q.popUpDataUrl, q.clustersOptions, q.clustersMessages)
        } else {
            if (q.flowDependencies.showInitialTransition) {
                g("#popup-initial-transition").hide();
                CheckoutHotels.Common.Utils.hideModal()
            }
        } if (!CheckoutHotels.Common.Utils.supportPlaceHolders()) {
            CheckoutHotels.Common.Utils.placeHolders(g(".input[type=text]", b))
        }
        window.onbeforeunload = h;
        g(".item-warn", b).on("focus", ".input", function (r) {
            g(this).parents(".item").removeClass("item-warn")
        });
        b.on("blur", ".input[type=text]:visible", function (s) {
            if (!g("#popup-fast-checkout").is(":visible")) {
                var r = g(this).parents(".group");
                if ((r.length && !a.validateInput(g(this)).valid) || (r.length && a.validateInputs(r).valid)) {
                    a.validateGroup(r)
                }
                if (!g(this).hasClass("invalid") || (g(this).hasClass("invalid") && (!a.validateFilledInput(g(this))))) {
                    a.validateInput(g(this), true)
                }
            }
        });
        b.on("change", ".input[type=checkbox]:visible, select:visible", function (s) {
            var r = g(this).parents(".group");
            if ((r.length && a.validateInputs(r).valid) || (r.length && !a.validateInput(g(this)).valid)) {
                a.validateGroup(r)
            }
            if (!g(this).hasClass("invalid")) {
                a.validateInput(g(this), true)
            }
        });
        g(".select-group", b).on("blur", ".input[type=text]:visible", function (s) {
            var r = g(this).parents(".select-group");
            if (!g(this).hasClass("invalid")) {
                a.validateSelectGroup(r, true)
            }
        })
    }
    function m(p, q) {
        var s = g('input[name="' + p + '"], select[name="' + p + '"]');
        var r = function () {
            g.each(q.rules, function (t, u) {
                regexs = u.regexValidations;
                g.each(u.dependencies, function (w, v) {
                    var y = f(v.fieldName);
                    var x = false;
                    g.each(v.values, function (z, A) {
                        x = y == A;
                        if (x) {
                            return false
                        }
                    });
                    if (!x) {
                        regexs = null;
                        return false
                    }
                });
                if (regexs) {
                    return false
                }
            });
            if (regexs) {
                g.each(regexs, function (u, t) {
                    s.attr("data-regex-" + u + "-code", t.code);
                    s.attr("data-regex-" + u + "-pattern", t.regex)
                });
                s.attr("data-regex-size", regexs.length)
            }
        };
        g.each(q.events, function (t, u) {
            amplify.subscribe(u, r)
        })
    }
    function l(p, q) {
        var s = g('input[name="' + p + '"], select[name="' + p + '"]');
        var r = function () {
            g.each(q.rules, function (t, u) {
                data = u.data;
                g.each(u.dependencies, function (w, v) {
                    var y = f(v.fieldName);
                    var x = false;
                    g.each(v.values, function (z, A) {
                        x = y == A;
                        if (x) {
                            return false
                        }
                    });
                    if (!x) {
                        data = null;
                        return false
                    }
                });
                if (data) {
                    return false
                }
            });
            if (data) {
                g.each(data, function (t, u) {
                    s.attr(t, data[t])
                })
            }
        };
        g.each(q.events, function (t, u) {
            amplify.subscribe(u, r)
        })
    }
    function i(p, q) {
        var s = g('input[name="' + p + '"], select[name="' + p + '"]');
        var r = function () {
            g("option", s).filter(":not(.default)").remove();
            var v = null;
            g.each(q.rules, function (x, y) {
                v = y.providerName;
                g.each(y.dependencies, function (A, z) {
                    var C = f(z.fieldName);
                    var B = false;
                    g.each(z.values, function (D, E) {
                        B = C == E;
                        if (B) {
                            return false
                        }
                    });
                    if (!B) {
                        v = null;
                        return false
                    }
                });
                if (v != null) {
                    return false
                }
            });
            if (v == null) {
                v = q.defaultProvider
            }
            if (k[v] == null) {
                clientSideLogger.info("PROVIDER DOES NOT EXIST");
                return
            }
            var u = k[v].options;
            if (u) {
                var w;
                var t = null;
                g.each(u, function (x, y) {
                    if (p == "paymentDefinition.paymentMethod.value") {
                        clientSideLogger.info("ADDING OPTION " + y.description)
                    }
                    w = g('<option value="' + y.key + '">' + y.description + "</option>");
                    s.append(w)
                });
                if (k[v].defaultElement) {
                    t = k[v].defaultElement.key
                }
                amplify.publish("setDefaultOption", t)
            }
            if (p == "paymentDefinition.paymentMethod.value") {
                clientSideLogger.info("UPDATING EXCHANGE RATE");
                s.change()
            }
        };
        g.each(q.events, function (t, u) {
            amplify.subscribe(u, r)
        })
    }
    function d(q, r) {
        var p = g('[id="' + q + '"]');
        var s = function () {
            g.each(r.rules, function (u, v) {
                var t = true;
                g.each(v.dependencies, function (x, w) {
                    var z = f(w.fieldName);
                    var y = false;
                    g.each(w.values, function (A, B) {
                        y = z == B;
                        if (y) {
                            return false
                        }
                    });
                    if (!y) {
                        t = false;
                        return false
                    }
                });
                if (t) {
                    p.show();
                    return false
                } else {
                    p.hide()
                }
            })
        };
        g.each(r.events, function (t, u) {
            amplify.subscribe(u, s)
        })
    }
    function f(p) {
        var r = g('input[name="' + p + '"], select[name="' + p + '"]');
        var q;
        if (r.attr("type") == "checkbox") {
            q = r.is(":checked")
        } else {
            if (r.attr("type") == "radio") {
                q = r.filter(":checked").val()
            } else {
                q = r.val()
            }
        }
        return q
    }
    function h() {
        g(".group-error:not(.card-group)", b).each(function () {
            var r = g(this);
            var p = r.attr("id");
            var q = g(".group-message:visible", r).attr("id");
            clientSideLogger.info('"' + q + '" in group ' + p + ".")
        });
        g(".item-error:not(.card-number-container, .security-code-container)", b).each(function () {
            var q = g(this);
            var p = q.attr("id");
            var r = g(".error-message:visible", q).attr("id");
            var s = g(".input", q).val();
            if (r) {
                clientSideLogger.info('"' + r + '" in field ' + p + " with value " + s + ".")
            }
        });
        g(".names-length-error:visible", b).each(function () {
            var q = g(this);
            var s = q.parents(".passenger");
            var r = q.attr("id");
            var p = g(".input-passenger-first-name", s).val();
            var t = g(".input-passenger-last-name", s).val();
            clientSideLogger.info('"' + r + '" in passenger ' + (s.index() + 1) + " with name " + p + " and lastname " + t + ".")
        });
        return
    }
    function n(q) {
        e();
        var p = {
            id: "popup-fast-checkout",
            title: null,
            $popupTemplate: g("#popup-fast-checkout-template"),
            popupPosition: "bottom-left",
            indicator: true,
            indicatorPosition: "top",
            hideCloseIcon: true
        };
        var r = g.extend(p, q);
        CheckoutHotels.Common.Utils.openPopup(r)
    }
    function j() {
        g("#popup-fast-checkout").delay(200).fadeOut()
    }
    function e() {
        g("#popup-fast-checkout").remove()
    }
    return {
        init: o,
        registerDynamicContent: i,
        registerDynamicVisibility: d,
        registerDynamicExtraData: l,
        registerDynamicRegex: m,
        getValue: f,
        sendErrors: h,
        showFastCheckoutPopup: n,
        hideFastCheckoutPopup: j,
        removeFastCheckoutPopup: e
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Passengers");
CheckoutHotels.Checkout.Modules.Form.Passengers = (function (j, f) {
    var e;
    var p;
    var m;
    var c;
    var b;
    var i;

    function q(t, r, s) {
        logger.info("[INFO] Initializing Passengers.");
        e = j("#passengers");
        b = t;
        p = b.passengerNamesMaxLength;
        m = CheckoutHotels.Checkout.getCountryCode();
        c = r;
        i = s;
        j(".names", e).on("blur", ".input", function (v) {
            var u = j(this).parents(".passenger");
            h(u);
            if (b.validateEqualNames) {
                n()
            }
        });
        if (i) {
            j(".names .input", e).on({
                focus: function (v) {
                    var u = j(this);
                    u.attr("autocomplete", "off");
                    k(u);
                    j("body").off("click", "#popup-fast-checkout .item");
                    j("body").on("click", "#popup-fast-checkout .item", function (x) {
                        var w = {
                            fastCheckoutData: i,
                            passengerType: j(this).attr("data-passenger-type"),
                            passengerIndex: j(this).attr("data-passenger-index"),
                            selectedIndex: j(this).attr("data-index"),
                            autocomplete: "all"
                        };
                        amplify.publish("fillFastCheckoutData", w);
                        CheckoutHotels.Checkout.Modules.Form.removeFastCheckoutPopup()
                    })
                },
                blur: function (u) {
                    CheckoutHotels.Checkout.Modules.Form.hideFastCheckoutPopup()
                }
            })
        }
        if (b.showLastNameHelper) {
            j(".input-passenger-last-name", e).on({
                focus: function (v) {
                    var u = j(this).parents(".item");
                    g(u)
                },
                blur: function (u) {
                    d()
                }
            })
        }
        j(".birthday-group", e).on("change", "select", function (v) {
            var u = j(this).parents(".group");
            c.validateDates(u, true)
        });
        e.on("change", ".select-document-type", function (v) {
            var u = j(this).parents(".select-group");
            var w = j(".input-document-number", u);
            if (c.validateFilledInput(w)) {
                c.validateSelectGroup(u, true);
                l(w)
            }
        });
        j(".input-document-number", e).on({
            keyup: function (v) {
                var u = j(this).parents(".select-group");
                c.validateSelectGroup(u, false)
            },
            blur: function (u) {
                l(j(this));
                o()
            }
        });
        amplify.subscribe("fillFastCheckoutData", function (w) {
            if (w.autocomplete == "all") {
                var v = j(".passenger:eq(" + w.passengerIndex + ")", e);
                var u = w.fastCheckoutData[w.passengerType][w.selectedIndex];
                j(".input-passenger-first-name", v).val(u.name).addClass("filled-by-fast-checkout");
                j(".input-passenger-last-name", v).val(u.surname).addClass("filled-by-fast-checkout");
                if (b.validateEqualNames) {
                    n()
                }
                if (u.birthDate) {
                    j(".select-year", v).val(u.birthDate[0]);
                    j(".select-month", v).val(u.birthDate[1]);
                    j(".select-day", v).val(u.birthDate[2]);
                    c.validateDates(j(".select-year", v).parents(".group"), true)
                }
                if (u.document) {
                    var y = j(".input-document-number", v);
                    if (y.length) {
                        j(".select-document-type", v).val(u.document.type);
                        y.val(u.document.number);
                        c.validateSelectGroup(y.parents(".select-group"), true);
                        l(y)
                    }
                }
                var x = j(".filled-by-fast-checkout", e);
                x.each(function () {
                    c.validateInput(j(this), true);
                    j(this).removeClass("filled-by-fast-checkout")
                })
            }
        });
        amplify.subscribe("doValidation", function () {
            var u = c.validateInputs(e, true).valid;
            j(".passenger", e).each(function () {
                if (!h(j(this))) {
                    u = false
                }
            });
            j(".group", e).each(function () {
                c.validateGroup(j(this))
            });
            j(".select-group", e).each(function () {
                c.validateSelectGroup(j(this), true)
            });
            j(".birthday-group", e).each(function () {
                if (!c.validateDates(j(this), true)) {
                    u = false
                }
            });
            j(".input-document-number", e).each(function () {
                if (!l(j(this))) {
                    u = false
                }
            });
            if (!o()) {
                u = false
            }
            if (b.validateEqualNames && !n()) {
                u = false
            }
            amplify.publish("validationResult", u)
        })
    }
    function o() {
        var s = j(".input-document-number", e);
        var t = true;
        var v = true;
        var w;
        var r;
        var u;
        var y = [];
        var x;
        s.each(function () {
            v = true;
            w = j(this);
            r = c.validateFilledInput(w);
            if (r) {
                y = s.filter(function () {
                    return this.value == w.val()
                });
                if (y.length > 1) {
                    t = false;
                    v = false
                }
                y.each(function () {
                    if ((l(j(this), false) && c.validateInput(j(this)).valid)) {
                        c.handleErrors(j(this), v, "duplicated_document_numbers", true);
                        if (!v) {
                            j(this).addClass("invalid invalid-repeated")
                        } else {
                            j(this).removeClass("invalid-repeated");
                            if (l(j(this), false)) {
                                j(this).removeClass("invalid")
                            }
                            c.validateSelectGroup(j(this).parents(".select-group"), true)
                        }
                    } else {
                        if (c.validateSelectGroup(j(this).parents(".select-group"), true)) {
                            l(j(this), true)
                        }
                    }
                })
            }
        });
        return t
    }
    function l(w, x) {
        var r = true;
        var s = w.parents(".select-group").find(".select-document-type");
        var y = w.parents(".select-group");
        var z = c.validateInput(w);
        if (z.valid) {
            var t = w.parents(".document-group");
            var u = j(".select-document-type", t);
            var v;
            if (u.val().toLowerCase() == "local") {
                if (m == "cl") {
                    r = c.validateRUT(w)
                }
            }
            if (!r) {
                s.addClass("invalid");
                s.parents(".item").addClass("item-error");
                y.addClass("group-error");
                j(".error-invalid_custom_document_number-message", y).css("display", "block")
            } else {
                if (!w.hasClass("invalid-repeated") && x) {
                    s.removeClass("invalid");
                    s.parents(".item").removeClass("item-error");
                    y.removeClass("group-error");
                    j(".error-invalid_custom_document_number-message", y).hide()
                }
            }
            c.handleErrors(w, r, "invalid", false)
        }
        return r
    }
    function h(u) {
        var s = j(".input-passenger-first-name", u);
        var t = j(".input-passenger-last-name", u);
        var v = j(".names-length-error", u);
        var x = 0;
        var w = true;
        var r = c.validateInput(s, false);
        if (r.valid || r.status == "invalid_length") {
            s.parents(".item").find(".error-message").hide()
        }
        r = c.validateInput(t, false);
        if (r.valid || r.status == "invalid_length") {
            t.parents(".item").find(".error-message").hide()
        }
        if (s.length && t.length) {
            if (s.val().length && !s.hasClass("placeholder")) {
                x += s.val().length
            }
            if (t.val().length && !t.hasClass("placeholder")) {
                x += t.val().length
            }
            if (x > p) {
                v.show();
                w = false
            } else {
                v.hide();
                if (!s.hasClass("invalid-equal-names")) {}
            } if (c.validateInput(s).valid && !s.hasClass("invalid-equal-names")) {
                c.handleErrors(s, w, "invalid", false, "item-invalid-names-length-error")
            }
            if (c.validateInput(t).valid && !t.hasClass("invalid-equal-names")) {
                c.handleErrors(t, w, "invalid", false, "item-invalid-names-length-error")
            }
        }
        return w
    }
    function n() {
        var w;
        var s;
        var t;
        var v = true;
        var r = [];
        var u;
        j(".passenger", e).each(function () {
            w = j(".input-passenger-first-name", j(this));
            s = j(".input-passenger-last-name", j(this));
            t = w.val() + s.val();
            if (j(".passenger", e).filter(function () {
                return (j(".input-passenger-first-name", j(this)).val().toLowerCase() == w.val().toLowerCase()) && (j(".input-passenger-last-name", j(this)).val().toLowerCase() == s.val().toLowerCase() && j(".input-passenger-first-name", j(this)).val() != "" && j(".input-passenger-last-name", j(this)).val() != "")
            }).length > 1) {
                r.push(j(this));
                v = false
            } else {
                a(w, s, true);
                j(".equal-names-error", j(this)).hide()
            }
        });
        for (index in r) {
            u = r[index];
            a(j(".input-passenger-first-name", u), j(".input-passenger-last-name", u), false);
            j(".equal-names-error", u).css("display", "block")
        }
        return v
    }
    function a(r, s, t) {
        c.handleErrors(r, t, "invalid", false, "item-invalid-equal-names-error");
        c.handleErrors(s, t, "invalid", false, "item-invalid-equal-names-error")
    }
    function g(s) {
        var r = j("#popup-last-name-helper-template");
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: s,
            id: "popup-last-name-helper",
            $content: r,
            popupPosition: "top",
            indicator: true,
            indicatorPosition: "bottom"
        })
    }
    function d() {
        j("#popup-last-name-helper").hide()
    }
    function k(v) {
        CheckoutHotels.Checkout.Modules.Form.removeFastCheckoutPopup();
        var r = v.parents(".passenger").attr("data-type");
        var t = v.parents(".passenger").index();
        var s = "name";
        switch (r) {
            case "adult":
                r = "adults";
                break;
            case "child":
                r = "children";
                break;
            case "infant":
                r = "infants";
                break
        }
        if (v.hasClass("input-passenger-last-name")) {
            s = "surname"
        }
        if (i[r].length) {
            var u = {
                $elementTrigger: v,
                $data: i[r],
                highlight: s,
                passengerType: r,
                passengerIndex: t,
                dataType: "names"
            };
            CheckoutHotels.Checkout.Modules.Form.showFastCheckoutPopup(u)
        }
    }
    return {
        init: q
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Invoice");
CheckoutHotels.Checkout.Modules.Form.Invoice = (function (b, e) {
    var c;
    var a;

    function d(f) {
        logger.info("[INFO] Initializing Agreement.");
        c = b("#invoice");
        a = f;
        c.on("blur", ".input-email", function (h) {
            var g = b(this);
            if (a.validateInput(g, false).valid) {
                amplify.publish("autocompleteEmail", g.val())
            }
        });
        amplify.subscribe("autocompleteEmail", function (h) {
            var g = b("#invoice-email", c);
            if (!a.validateFilledInput(g)) {
                g.val(h)
            }
        });
        amplify.subscribe("doValidation", function () {
            var g = true;
            if (c.is(":visible")) {
                g = a.validateInputs(c, true).valid;
                b(".group", c).each(function () {
                    a.validateGroup(b(this))
                })
            }
            amplify.publish("validationResult", g)
        })
    }
    return {
        init: d
    }
}(jQuery));

registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Currency");
CheckoutHotels.Checkout.Modules.Form.Currency = (function (c) {

    function d(k) {
    	logger.info("[INFO] Initializing Currency.");
    	payment = c("#payment");

    	var clicks = new Array();
    	if (amplify.store("preferedCurrency")) {
    		clicks[0] = amplify.store("preferedCurrency");
    		
    		c("div.price-BTC").addClass('hidden');
        	c("div.price-" + amplify.store("preferedCurrency")).removeClass('hidden');
        	
        	c("input[type=radio][name=paymentOption]").filter('[value="' + amplify.store("preferedCurrency") + '"]').attr('checked', true);
    	} else {
    		clicks[0] = 'BTC';
    	}
    	
        payment.on("change", "input[type=radio][name=paymentOption]", function (i) {
        	clicks.push($(this).val()) 
        	c("div.price-" + clicks[clicks.length-2]).addClass('hidden');
        	c("div.price-" + $(this).val()).removeClass('hidden');
        });
        
    }
    
    return {
        init: d
    }
}(jQuery));

registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Contact");
CheckoutHotels.Checkout.Modules.Form.Contact = (function (k, f) {
    var e;
    var d = k("#contact-email");
    var i = k("#contact-email-repeat");
    var p;
    var c;
    var j;

    function o(q, r) {
        logger.info("[INFO] Initializing Contact.");
        e = k("#contact");
        p = k(".emails", e);
        c = q;
        j = r;
        p.on("blur", ".input[type=text]", function (s) {
            if (c.validateInputs(p, false).valid) {
                if (m()) {
                    amplify.publish("autocompleteEmail", k("#contact-email").val())
                }
            }
        });
        e.on("paste", "#contact-email-repeat", function (s) {
            s.preventDefault()
        });
        e.on("click", ".add-phone", function (s) {
            s.preventDefault();
            a()
        });
        e.on("click", ".remove-phone", function (t) {
            t.preventDefault();
            var s = k(this).parents(".phone").find(".input-phone-number");
            if (!CheckoutHotels.Common.Validator.validateFilledInput(s)) {
                n(k(this));
                h()
            } else {
                g(k(this))
            }
        });
        e.on("click", ".ticket", function (s) {
            s.preventDefault();
            b(k(this))
        });
        if (j) {
            k(".input", e).not(".input-email-repeat").not(".select-phone-type").on({
                focus: function (t) {
                    var s = k(this);
                    s.attr("autocomplete", "off");
                    l(s);
                    k("body").off("click", "#popup-fast-checkout .item");
                    k("body").on("click", "#popup-fast-checkout .item", function (v) {
                        var u = {
                            fastCheckoutData: j,
                            selectedIndex: k(this).attr("data-index"),
                            autocomplete: k(this).attr("data-type")
                        };
                        amplify.publish("fillFastCheckoutData", u);
                        CheckoutHotels.Checkout.Modules.Form.removeFastCheckoutPopup()
                    })
                },
                blur: function (s) {
                    CheckoutHotels.Checkout.Modules.Form.hideFastCheckoutPopup()
                }
            })
        }
        amplify.subscribe("autocompleteEmail", function (t) {
            var s = k("#contact-email", p);
            if (!c.validateFilledInput(s)) {
                s.val(t)
            }
        });
        amplify.subscribe("fillFastCheckoutData", function (v) {
            var u = v.fastCheckoutData.phones;
            var x = v.fastCheckoutData.emails;
            var t = 0;
            if (v.autocomplete == "phones" || v.autocomplete == "emails") {
                t = v.selectedIndex
            }
            if ((u.length == 1 && v.autocomplete == "all") || (v.autocomplete == "phones")) {
                k("#phone-type-0", e).val(u[t].type);
                k("#country-code-0", e).val(u[t].countryCode);
                k("#area-code-0", e).val(u[t].areaCode);
                k("#phone-number-0", e).val(u[t].number);
                var w = k("#country-code-0", e).parents(".group");
                c.validateInputs(w, true);
                c.validateGroup(w)
            }
            if ((x.length == 1 && v.autocomplete == "all") || (v.autocomplete == "emails")) {
                var s = k("#contact-email", e);
                s.val(x[t]);
                c.validateInput(s, true)
            }
        });
        amplify.subscribe("doValidation", function () {
            var t = CheckoutHotels.Common.Validator;
            var s = c.validateInputs(e, true).valid;
            if (c.validateInputs(p, true).valid) {
                if (!m()) {
                    s = false
                }
            }
            k(".group", e).each(function () {
                c.validateGroup(k(this))
            });
            amplify.publish("validationResult", s)
        })
    }
    function m() {
        var q = true;
        if (d.val().toLowerCase() != i.val().toLowerCase()) {
            q = false
        }
        c.handleErrors(i, q, "not-match");
        if (!q) {
            i.addClass("invalid")
        }
        return q
    }
    function b(q) {
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: q,
            id: "popup-ticket",
            $content: k("#popup-ticket-template"),
            popupPosition: "bottom",
            indicator: true,
            indicatorPosition: "top"
        })
    }
    function a() {
        if (k(".phone", e).length < 4) {
            var q = k(".phone:last", e).clone();
            k(".text", q).remove();
            q.appendTo(".phones", e);
            var r = q.index();
            var s = k(".phone-group", q);
            k(".remove-phone", q).removeClass("hidden");
            s.removeClass("group-field_empty group-error");
            k(".error-message", s).hide();
            k(".item", q).each(function () {
                var u = k(this);
                var z = k(".input", u);
                var t = k(".label", u);
                var y = s.attr("id").replace(r - 1, r);
                var x = z.attr("id").replace(r - 1, r);
                var w = z.attr("name").replace(r - 1, r);
                var v = u.attr("id").replace(r - 1, r);
                c.hideErrors(z, "invalid", true);
                if (!z.hasClass("select-phone-type")) {
                    z.removeClass("required")
                }
                if (z.hasClass("input-phone-number")) {
                    z.val("")
                }
                z.attr("name", w);
                s.attr("id", y);
                z.attr("id", x);
                t.attr("for", x);
                u.attr("id", v)
            });
            if (r == 3) {
                k(".add-phone", e).hide()
            }
        }
    }
    function n(q) {
        var r = q.parents(".phone");
        r.remove();
        if (k(".phone", e).length < 4) {
            k(".add-phone", e).show()
        }
    }
    function g(q) {
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: q,
            id: "popup-remove-phone-confirmation",
            $content: k("#popup-remove-phone-confirmation-template"),
            popupPosition: "right",
            indicator: true,
            indicatorPosition: "left"
        });
        var r = k("#popup-remove-phone-confirmation");
        r.on("click", ".popup-button", function (s) {
            s.preventDefault();
            if (k(this).hasClass("confirm")) {
                n(q)
            }
            h()
        })
    }
    function h() {
        k("#popup-remove-phone-confirmation").hide()
    }
    function l(s) {
        var r = "phones";
        if (s.hasClass("input-email")) {
            r = "emails"
        }
        CheckoutHotels.Checkout.Modules.Form.removeFastCheckoutPopup();
        if (j[r].length) {
            var q = {
                $elementTrigger: s,
                $data: j[r],
                dataType: r
            };
            CheckoutHotels.Checkout.Modules.Form.showFastCheckoutPopup(q)
        }
    }
    return {
        init: o
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Agreement");
CheckoutHotels.Checkout.Modules.Form.Agreement = (function (c, f) {
    var e;
    var b;

    function d(h, g) {
        logger.info("[INFO] Initializing Agreement.");
        _$agreement = c("#agreement");
        b = g;
        _$agreement.on("click", ".agreement-link", function (i) {
            i.preventDefault();
            a(c(this), h.agreementPopupTitle)
        });
        amplify.subscribe("doValidation", function () {
            var i = CheckoutHotels.Common.Validator.validateInputs(_$agreement, true).valid;
            amplify.publish("validationResult", i)
        })
    }
    function a(g, h) {
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: g,
            id: "popup-agreement",
            title: h,
            $content: c("#popup-agreement-template"),
            popupPosition: "center",
            indicator: false,
            showModal: true
        })
    }
    return {
        init: d
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Additionals");
CheckoutHotels.Checkout.Modules.Form.Additionals = (function (e, c) {
    var d;
    var a;

    function i(j) {
        logger.info("[INFO] Initializing Additionals.");
        d = e("#additionals");
        a = j;
        d.on("click", ".add-voucher", function (k) {
            k.preventDefault();
            f()
        });
        d.on("click", ".remove-voucher", function (l) {
            l.preventDefault();
            var k = e(this).parents(".code").find(".input-voucher-code");
            if (!CheckoutHotels.Common.Validator.validateFilledInput(k)) {
                h(e(this));
                b()
            } else {
                g(e(this))
            }
        });
        amplify.subscribe("CACManager", function (k) {
            var m = e(".check-comment-question", d);
            var l = e("#comment-reference-code", d);
            if (k) {
                m.attr("checked", "checked");
                if (l.val() == "") {
                    l.val("AG")
                }
            }
        })
    }
    function f() {
        $codes = e(".vouchers .codes", d);
        if (e(".voucher-code-container", $codes).length < 10) {
            var p = e(".code:last", $codes).clone();
            e(".input", p).val("").removeClass("required");
            p.appendTo($codes);
            e(".remove-voucher", p).removeClass("hidden");
            a.hideErrors(p);
            var q = e(".input", p);
            var j = e(".label", p);
            var o = e(".voucher-code-container", p);
            var k = p.index();
            var n = q.attr("id").replace(k - 1, k);
            var m = q.attr("name").replace(k - 1, k);
            var l = o.attr("id").replace(k - 1, k);
            q.attr("id", n);
            q.attr("name", m);
            o.attr("id", l);
            if (k == 9) {
                e(".add-voucher", d).hide()
            }
        }
    }
    function h(k) {
        $codes = e(".vouchers .codes", d);
        var j = k.parents(".code");
        j.remove();
        if (e(".code", $codes).length < 10) {
            e(".add-voucher", d).show()
        }
    }
    function g(j) {
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: j,
            id: "popup-remove-voucher-confirmation",
            $content: e("#popup-remove-voucher-confirmation-template"),
            popupPosition: "bottom",
            indicator: true,
            indicatorPosition: "top"
        });
        var k = e("#popup-remove-voucher-confirmation");
        k.on("click", ".popup-button", function (l) {
            l.preventDefault();
            if (e(this).hasClass("confirm")) {
                h(j)
            }
            b()
        })
    }
    function b() {
        e("#popup-remove-voucher-confirmation").hide()
    }
    return {
        init: i
    }
}(jQuery));

registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Payment");
CheckoutHotels.Checkout.Modules.Form.Payment = (function (f, h) {
	var e;
	
    function g(i) {
        logger.info("[INFO] Initializing Payment.");
        e = f("#payment");
        e.on("click", "#submit", function (j) {
        	//	alert('click en #payment');
            if (!f("#submit").hasClass('disabled')) {
            	f("#payment_notification").submit();            	
            }
        });
    }
    
    return {
        init: g
    }
}(jQuery));

registerNameSpace("CheckoutHotels.Checkout.Modules.Form.Buy");
CheckoutHotels.Checkout.Modules.Form.Buy = (function (f, h) {
    var e;
    var c = true;
    var d;
    var b;
    var a = false;
    var form;

    function g(i) {
        logger.info("[INFO] Initializing Buy.");
        e = f("#buy");
        e.on("click", function (j) {
                amplify.publish("doValidation");
                if (c && (!d || (d && b))) {
                    var j;
                    clientSideLogger.info("SELECTED OPTION: " + j + ", SELECTED RADIO: " + f(".radio:checked", f("#payment")).val());
                    
                    // submit del formulario con los datos de contacto y mostrar la bitpay invoice
                    form = f("#form");
                    $.post(
                    		form.attr('action'),
                    		form.serialize(),
                    		function(data) {
                    			if (data.success && (data.gateway == 'BitPay' || data.gateway == 'GoCoin')) {
                    				
                    				if (data.gateway == 'BitPay') {
                    					$("#invoice").attr('src', data.url);
                    					$("#invoice").attr('height', '160');
                    					$("#invoice").attr('width', '520');
                    					$("#payment .description").show();
                    				} else if (data.gateway == 'GoCoin') {
                    					$("#invoice").attr('src', data.url);
                    					$("#invoice").attr('height', '290');
                    					$("#invoice").attr('width', '560');
                    					$("#payment .description").hide();
                    				} 
                    				
                    				CheckoutHotels.Common.Utils.openPopup({
                                        id: "popup-checkout-transition",
                                        $content: f("#popup-checkout-transition-template"),
                                        popupPosition: "fixed",
                                        indicator: false,
                                        showModal: true,
                                        hideCloseIcon: false
                                    });
                    				
                                    f(window).unload(function () {
                                        $("#popup-checkout-transition").hide()
                                    });
                    			} else {
                    				f('#payment-msg').text('At this moment we can not generate the Bitpay invoice. Please try in some minutes.');
                    				f('#payment-msg').addClass('error');
                    			}
                    		});
                    
                } else {
                    CheckoutHotels.Checkout.Modules.Form.sendErrors();
                    c = true;
                    if (f(".item-error").length) {
                        f(window).scrollTop(f(".item-error:first").offset().top - 10)
                    }
                    j.preventDefault()
                }
        });
        amplify.subscribe("validationResult", function (j) {
            if (!j) {
                c = j
            }
        });
        amplify.subscribe("CACManager", function (k, j) {
            d = k;
            b = j
        })
    }
    return {
        init: g
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Common.Modules.Detail");
CheckoutHotels.Common.Modules.Detail = (function (c, e) {
    var b;

    function d(f) {
        logger.info("[INFO] Initializing Detail.");
        b = c("#detail");
        CheckoutHotels.Common.Modules.Detail.Prices.init();
        CheckoutHotels.Common.Modules.Detail.Itinerary.init(f.itinerary);
        b.on("click", ".best-price-link", function (g) {
            g.preventDefault();
            a(c(this), f.bestPrice.bestPricePopupTitle)
        })
    }
    function a(f, g) {
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: f,
            id: "popup-best-price",
            title: g,
            $content: c("#popup-best-price-content"),
            popupPosition: "bottom",
            indicator: true,
            indicatorPosition: "top"
        })
    }
    return {
        init: d
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Common.Modules.Detail.Prices");
CheckoutHotels.Common.Modules.Detail.Prices = (function (c, e) {
    var a;

    function d() {
        logger.info("[INFO] Initializing Prices.");
        a = c("#price-info");
        amplify.subscribe("changePrices", function (f) {
            b(f)
        })
    }
    function b(g) {
        var h = c(".interest", a);
        var f = c(".total", a);
        c(".amount", h).text(g.interest);
        c(".amount", f).text(g.total);
        if (g.interest != "0") {
            h.show()
        } else {
            h.hide()
        }
    }
    return {
        init: d
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Common.Modules.Detail.Itinerary");
CheckoutHotels.Common.Modules.Detail.Itinerary = (function (c, e) {
    var b;

    function d(f) {
        logger.info("[INFO] Initializing Itinerary.");
        b = c("#itinerary");
        c(".stops", b).on("click", ".number", function (g) {
            g.preventDefault();
            a(c(this), f.detailPopupTitle)
        })
    }
    function a(h, j) {
        var g = h.attr("data-index");
        var f = c(".route-" + g, c("#popup-detail-content"));
        CheckoutHotels.Common.Utils.openPopup({
            $elementTrigger: h,
            id: "popup-detail",
            title: j,
            $content: f,
            dynamic: true,
            popupPosition: "bottom-middle-left",
            indicator: true,
            indicatorPosition: "top",
            clone: true
        });
        var i = c("#popup-detail");
        i.on("click", ".show-rules", function (k) {
            k.preventDefault();
            c(".show-rules", i).toggle(function () {
                c(".rules", i).css("width", c(".bottom-box", i).outerWidth());
                c(".rules", i).show()
            }, function () {
                c(".rules", i).hide()
            }).trigger("click")
        })
    }
    return {
        init: d
    }
}(jQuery));
registerNameSpace("CheckoutHotels.Common.Validator");
CheckoutHotels.Common.Validator = (function (i, e) {
    var m = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    function n(u, v) {
        var t = true;
        var s = "field_empty";
        i(".input:visible", u).each(function () {
            var w = d(i(this), v);
            if (!w.valid) {
                t = false;
                if (w.status != "field_empty") {
                    s = "invalid"
                }
            }
        });
        var r = {
            valid: t,
            status: s
        };
        return r
    }
    function d(x, w) {
        var v;
        var u = x.attr("type");
        var s = "valid";
        var t = x.attr("data-regex-size");
        if (u == "checkbox") {
            if (!x.is(":checked") && CheckoutHotels.Common.Utils.isRequired(x)) {
                v = false;
                s = "field_empty"
            } else {
                v = true
            }
        } else {
            if (!c(x) && CheckoutHotels.Common.Utils.isRequired(x)) {
                v = false;
                s = "field_empty"
            } else {
                if ((t > 0) && !o(x).valid && c(x)) {
                    v = false;
                    s = o(x).status
                } else {
                    v = true
                }
            }
        } if (w) {
            k(x, v, s)
        }
        var r = {
            valid: v,
            status: s
        };
        return r
    }
    function o(y) {
        var w = true;
        var s = "valid";
        var x = y.val();
        var u = y.attr("data-regex-size");
        for (var t = 0; t < u; t++) {
            var v = new RegExp(y.attr("data-regex-" + t + "-pattern"));
            if (!v.test(x)) {
                w = false;
                s = y.attr("data-regex-" + t + "-code");
                break
            }
        }
        var r = {
            valid: w,
            status: s
        };
        return r
    }
    function h(s) {
        var r = true;
        i(".input:visible", s).each(function () {
            if (!c(i(this))) {
                r = false
            }
        });
        return r
    }
    function c(t) {
        var s = true;
        var r = t.attr("placeholder") || "";
        if (t.val() == r || t.val() == "") {
            s = false
        }
        return s
    }
    function g(s) {
        var t = true;
        var r = n(s, false);
        if (!r.valid) {
            s.addClass("group-error");
            i(".group-message", s).hide();
            i(".error-" + r.status + "-message", s).css("display", "block");
            t = false
        } else {
            if (!s.hasClass("group-invalid")) {
                s.removeClass("group-error");
                i(".group-message", s).hide()
            }
        }
        return t
    }
    function j(v, y) {
        var w = false;
        var t = false;
        var x = v.find("input");
        var u = v.find("select");
        var s = "valid";
        var r = d(x, y);
        if (r.valid) {
            w = true;
            t = true
        } else {
            if (c(x)) {
                w = false;
                t = false;
                var s = r.status
            } else {
                w = false;
                t = true;
                s = "field_empty"
            }
        } if (y || (!y && w)) {
            i(".group-message", v).hide();
            k(x, w, s, true);
            u.parents(".item").removeClass("item-warn");
            if (t) {
                u.removeClass("invalid");
                u.parents(".item").removeClass("item-error");
                v.removeClass("group-error")
            } else {
                u.addClass("invalid");
                u.parents(".item").addClass("item-error");
                v.addClass("group-error");
                i(".error-" + s + "-message", v).css("display", "block")
            }
        }
        return w
    }
    function l(D, C) {
        var r = true;
        var v = "valid";
        if (D.is(":visible")) {
            var w = new Date(D.attr("data-from"));
            var E = new Date(D.attr("data-to"));
            if (n(D, false).valid) {
                var y = i(".select-year", D);
                var x = i(".select-month", D);
                var t = i(".select-day", D);
                var A = y.val();
                var z = x.val() - 1;
                var B = t.val() || 1;
                var u = ((A % 4 == 0) && (A % 100 != 0)) || ((A % 100 == 0) && (A % 400 == 0));
                if (u) {
                    m[1] = 29
                } else {
                    m[1] = 28
                } if (B > m[z]) {
                    r = false;
                    v = "invalid_date"
                } else {
                    var s = new Date(A, z, B);
                    if (s > E) {
                        r = false;
                        v = "invalid_date_max"
                    } else {
                        if (s < w) {
                            r = false;
                            v = "invalid_date_min"
                        }
                    }
                } if (C) {
                    if (!r) {
                        D.addClass("group-error group-invalid");
                        t.addClass("invalid").parents(".item").addClass("item-error");
                        x.addClass("invalid").parents(".item").addClass("item-error");
                        i(".error-message", D).hide();
                        i(".error-" + v + "-message", D).css("display", "block")
                    } else {
                        D.removeClass("group-error group-invalid");
                        t.removeClass("invalid").parents(".item").removeClass("item-error");
                        x.removeClass("invalid").parents(".item").removeClass("item-error");
                        i(".error-message", D).hide()
                    }
                }
            }
        }
        return r
    }
    function b(w) {
        var v = true;
        var r = w.val().replace(/[^\d]/g, "");
        if (r.length != 11 || r == "00000000000" || r == "11111111111" || r == "22222222222" || r == "33333333333" || r == "44444444444" || r == "55555555555" || r == "66666666666" || r == "77777777777" || r == "88888888888" || r == "99999999999") {
            v = false
        } else {
            var t = 0;
            var s;
            for (var u = 2; u <= 10; u++) {
                t += u * parseInt(r.charAt(10 - u))
            }
            s = f(t);
            if (parseInt(r.charAt(9)) != s) {
                v = false
            } else {
                t = 0;
                for (u = 2; u <= 11; u++) {
                    t += u * parseInt(r.charAt(11 - u))
                }
                s = f(t);
                if (parseInt(r.charAt(10)) != s) {
                    v = false
                }
            }
        }
        return v
    }
    function f(s) {
        var r = 0;
        if ((s % 11) >= 2) {
            r = Math.abs((s % 11) - 11)
        }
        return r
    }
    function a(x) {
        var r = true;
        var s = x.val().replace(/[^\d,^k,^K]/g, "");
        var y = s.substring(0, s.length - 1);
        var v = s.charAt(s.length - 1);
        var z;
        var w = 0;
        var u = 2;
        for (var t = y.length - 1; t >= 0; t--) {
            w = w + (y.charAt(t) * u);
            if (u == 7) {
                u = 2
            } else {
                u++
            }
        }
        z = 11 - (w % 11);
        if (z == 11) {
            z = 0
        } else {
            if (z == 10) {
                z = "k"
            }
        } if (z != v.toLowerCase()) {
            r = false
        }
        return r
    }
    function k(v, t, r, s, u) {
        if (s == e) {
            s = true
        }
        if (!t) {
            q(v, r, s, u)
        } else {
            p(v, r, s, u)
        }
    }
    function q(w, r, u, v) {
        var t = w.attr("type");
        var s = w.parents(".item");
        var v = v || "";
        if (t == "checkbox") {
            s.removeClass("checkbox-warn");
            s.addClass("checkbox-error")
        } else {
            s.removeClass("item-warn item-error " + v);
            s.addClass("item-error " + v);
            if (u) {
                i(".error-message", s).hide();
                if (r == "" || r == "error") {
                    r = "invalid"
                }
                i(".error-" + r + "-message", s).css("display", "block")
            }
        }
    }
    function p(w, r, u, v) {
        var t = w.attr("type");
        var s = w.parents(".item");
        var v = v || "";
        w.removeClass("invalid");
        if (t == "checkbox") {
            s.removeClass("checkbox-error");
            s.removeClass("checkbox-warn")
        } else {
            s.removeClass("item-warn " + v);
            if (d(w).valid) {
                s.removeClass("item-error")
            }
            if (u) {
                i(".error-message", s).hide();
                if (r == "" || r == "error") {
                    r = "invalid"
                }
                i(".error-" + r + "-message", s).hide()
            }
        }
    }
    return {
        validateInput: d,
        validateInputs: n,
        validateFilledInput: c,
        validateFilledInputs: h,
        validateGroup: g,
        validateSelectGroup: j,
        validateRegexs: o,
        validateDates: l,
        handleErrors: k,
        showErrors: q,
        hideErrors: p,
        validateCPF: b,
        validateRUT: a
    }
}(jQuery));