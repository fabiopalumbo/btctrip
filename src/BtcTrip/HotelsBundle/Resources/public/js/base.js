var FRWK_JS_PATH = "/js/";
var LIB_ROOT_PATHS = {
    FrameworkJS: "js",
    Hotels: "hotels/js",
    Cruises: "cruises/js",
    cruise: "cruises/shop/search/js",
    cruise_detail: "cruises/shop/detail/js",
    Flights: "flights/js",
    "flights-web": "shop/flights/js",
    "flights-ss-web": "selfservice/flights/js",
    Social: "Turismo/Content/js",
    Nibbler: "nibbler-js",
    Commercial: "commercial-web/js",
    LandingHotels: "landing-hotels-web/js",
    "landing-flights-web": "landing-flights-web/js",
    LandingPackages: "landing-packages-web/js",
    HomeMobile: "mobile-home-web/js",
    HotelsMobile: "mobile-hotels-web/js",
    FlightsMobile: "mobile-flights-web/js",
    CheckoutHotelsMobile: "mobile-checkout-hotels-web/js",
    CheckoutFlightsMobile: "mobile-checkout-flights-web/js",
    LibraryJSMobile: "mobile-js",
    SaleServices: "sale-services/js",
    Home: "home-web/js",
    GdsService: "gds-services-web/js",
    Benefit: "benefit-service/js",
    "checkout-flights": "book/flights/js",
    "checkout-hotels": "book/hotels/js",
    "checkout-cars": "cars-static/js",
    "search-cars": "cars-static/js",
    HomeHotels: "landing-hotels-web/js",
    CountryHotels: "landing-hotels-web/js",
    "cp-flights-web": "js/flights",
    "cp-hotels-web": "js/hotels",
    "cp-web": "js"
};

function registerNameSpace(d) {
    var c = d.split(".");
    var a = window;
    for (var b = 0; b < c.length; b++) {
        if (typeof a[c[b]] == "undefined") {
            a[c[b]] = new Object()
        }
        a = a[c[b]]
    }
    return a
}
function loadJS(e) {
    var c = null;
    if (window.XMLHttpRequest) {
        c = new XMLHttpRequest()
    } else {
        if (window.ActiveXObject) {
            c = new ActiveXObject("Microsoft.XMLHTTP")
        }
    }
    var a = document.getElementsByTagName("head")[0];
    var d = document.createElement("script");
    d.setAttribute("type", "text/javascript");
    d.setAttribute("charset", "utf-8");
    if (c != null) {
        c.open("GET", e, false);
        c.send(null);
        var b = "//START of '" + e + "' file \n";
        b += c.responseText;
        b += "//END of '" + e + "' file \n";
        if (c.status == 200 || c.status == 0 || c.status == undefined) {
            d.text = b
        } else {
            d.text = "//ERROR al cargar archivo '" + e + "' (" + c.statusText + ")\n"
        }
    } else {
        d.text = "//ERROR al cargar archivo '" + e + "' (no se pudo instanciar XMLHttpRequest)\n"
    }
    a.appendChild(d)
}
function getJSClassPath(a) {
    var b = "";
    var d = a.split(".");
    for (var c = 0; c < d.length; c++) {
        if (c == 0) {
            b = LIB_ROOT_PATHS[d[c]] + "/"
        }
        b += d[c];
        if (c < d.length - 1) {
            b += "/"
        }
    }
    b += ".js";
    return "/" + b
}
function loadCustomJS(a) {
    loadJS(FRWK_JS_PATH + "custom/" + a)
}
function loadJSClass(a) {
    loadJS(getJSClassPath(a))
}
var errorHandler = clientSideLogger = function () {
    var g = "/loggerjs";
    var b = "default";
    var a = (Math.floor((900000000000) * Math.random()) + 100000000000);
    var i = {
        home: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/Belo-Horizonte|\/Brasilia|\/curitiba|\/fortaleza|\/porto-alegre|\/recife|\/Rio-de-Janeiro|\/Salvador|\/medellin|\/Chicago|\/Houston|\/Los-Angeles|\/Nueva-York|\/Orlando|\/San-Antonio|\/San-Francisco|\/Guadalajara|\/Monterrey|\/\?tab\=car|\/\?tab\=cru)?($|\/$)/i,
        homeFlights: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+\/(vuelos|passagens-aereas)($|\/$)/i,
        homeHotels: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+\/(hoteles|hoteis)($|\/$)/i,
        homePakages: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+\/(paquetes|pacotes)($|\/$)/i,
        flightsResult: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/search\/flights\/|\/shop\/flights\/search\/)/i,
        flightsDisambiguation: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/search\/Disambiguation\/)/i,
        flightsCheckout: /^https:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/Booking\/FlightCheckOut\/)/i,
        flightsCheckoutGui: /^https:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/book\/flights\/)/i,
        hotelsResult: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/search\/Hotel\/)[A-z0-9]{3}\//i,
        hotelsDetail: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/search\/Hotel\/Details\/)/i,
        hotelsCheckout: /^https:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/Booking\/HotelCheckout\/)/i,
        packagesResult: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/Search\/Packages\/)([A-z0-9]{3}\/){2}/i,
        packagesDetail: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/Search\/Packages\/Details\/)/i,
        packagesCheckout: /^https:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/Booking\/PackageCheckout\/)/i,
        landingFlights: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/(vuelos|passagens-aereas)\/)([A-z0-9]{3}\/){2}/i,
        landingHotels: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/(hoteles|hoteis)\/hl\/)[A-z0-9]{3}\//i,
        landingHotelsDetail: /^http:\/\/(www|ic|rc|bc)(\.us)*\.(despegar|decolar)\.[a-z.]+(\/(hoteles|hoteis)\/h-)[0-9]+\//i
    };
    var h = function () {
        var j = window.X_UOW ? "UOW-" + window.X_UOW : "RND_" + a;
        return j
    };
    var c = function () {
        var k = window.CURRENT_APPLICATION ? window.CURRENT_APPLICATION : b;
        var j = false;
        return {
            get: function () {
                k = window.CURRENT_APPLICATION ? window.CURRENT_APPLICATION : b;
                if (k === b) {
                    var l = window.location.href;
                    var n, m = 0;
                    for (var n in i) {
                        if (i[n].test(l)) {
                            k = n;
                            break
                        }
                    }
                    j = (k != b)
                }
                return k
            },
            toString: function () {
                var l = "Application=" + k;
                if (j) {
                    l += " (guessed)"
                }
                l += ";";
                return l
            },
            getLogUrl: function () {
                return g + "/" + k
            },
            isGuessed: function () {
                return j
            }
        }
    }();
    var f = function () {
        var j = "";
        if (navigator) {
            j = navigator.userAgent ? navigator.userAgent : "undefined"
        } else {
            j = "undefined"
        }
        return 'UserAgent="' + j + '";'
    };
    var e = function () {
        return {
            curMsg: "",
            curUrl: "",
            curLineNumber: "",
            currLocationHref: window.location.href,
            set: function (l, k, j) {
                this.curMsg = l;
                this.curUrl = k;
                this.curLineNumber = j
            },
            toString: function () {
                return 'Message="' + this.curMsg + '"; Url=' + this.curUrl + "; LineNumber=" + this.curLineNumber + "; LocationHref=" + this.currLocationHref + ";"
            }
        }
    }();
    var d = function (k, j) {
    };
    return {
        throwOverride: function (l, k, j) {
            return false
        },
        handler: function (l, k, j) {
            e.set(l, k, j);
            c.get();
            d(this.toString());
            return this.throwOverride(l, k, j)
        },
        toString: function () {
            var j = "";
            j += "[" + h() + "] ";
            j += c.toString() + " ";
            j += e.toString() + " ";
            j += f() + " ";
            return j
        },
        log: function (m, l, k, j) {
            e.set(m, k, j);
            c.get();
            d(this.toString(), l)
        },
        error: function (l, k, j) {
            this.log(l, "error", k, j)
        },
        warn: function (l, k, j) {
            this.log(l, "warn", k, j)
        },
        trace: function (l, k, j) {
            this.log(l, "trace", k, j)
        },
        info: function (l, k, j) {
            this.log(l, "info", k, j)
        },
        debug: function (l, k, j) {
            this.log(l, "debug", k, j)
        }
    }
}();
window.onerror = function (c, b, a) {
    return errorHandler.handler(c, b, a)
};