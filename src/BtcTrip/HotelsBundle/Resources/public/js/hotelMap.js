this.selectedLabel = this.selectedMarker = this.map = this.pointsOfInterestFacet = this.availabilitiesJSON = null;
this.mapRendered = !1;
this.labels = [];
this.markers = [];
this.defaultZoom = 13;
this.markerCluster = null;
this.pointOfInterestMarkers = [];
var lastMapCenter, lastMapZoom;
var resourcesPath='/';
function showHotelsMap(a, c, f) {
    this.defaultZoom = 0 < f ? 16 : 13;
    initialize(a, c);
    // showAllMarkers(map, f);
}

function showHotelMap(a, c) {
    this.defaultZoom = 15;
    initialize(a, c);
    showHotelMarker(map, a, c)
    $("#mapModal").attr('class','modal');
    
}

function initialize(a, c) {
    var f = new google.maps.LatLng(parseFloat(a.replace(",", ".")), parseFloat(c.replace(",", "."))),
        f = {
            zoom: this.defaultZoom,
            center: f,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
   
    null == map && (map = new google.maps.Map(document.getElementById("map_canvas"), f))
    
    
}

function getZoomByBounds(a, c) {
    for (var f = a.getProjection().fromLatLngToPoint(c.getNorthEast()), b = a.getProjection().fromLatLngToPoint(c.getSouthWest()), d = Math.abs(f.x - b.x), f = Math.abs(f.y - b.y), b = 13; 0 <= b; --b)
        if (d * (1 << b) + 80 < $(a.getDiv()).width() && f * (1 << b) + 80 < $(a.getDiv()).height()) return b;
    return 0
}

function removeAllMarkers() {
    null != this.markerCluster && (this.markerCluster.removeMarkers(this.markers), this.markerCluster.resetViewport());
    for (var a = 0; a < markers.length; a++) null != markers[a] && markers[a].setMap(null);
    for (a = 0; a < labels.length; a++)
        if (null != labels[a]) labels[a].onRemove();
    this.markers = [];
    this.labels = [];
    this.selectedLabel = this.selectedMarker = null
}

function showAllMarkers(a, c) {
    var f = new google.maps.InfoWindow,
        b, d;
    if (this.mapRendered) {
        for (b = 0; b < availabilitiesJSON.availability.length; b++) {
            d = availabilitiesJSON.availability[b].hotel.geoLocation;
            var g = availabilitiesJSON.availability[b].hotel;
            g.id == c ? (selectedLabel = e, labels[b].span_.className = "mainSprite hotel-marker-selected", selectedMarker = markers[b]) : labels[b].span_.className = "mainSprite hotel-marker"
        }
        0 > c && (a.setCenter(lastMapCenter), a.setZoom(lastMapZoom));
        for (b = 0; b < availabilitiesJSON.availability.length; b++) {
            e =
                this.labels[b];
            g = "";
            for (pos in availabilitiesJSON.availability[b].priceWithDiscount)
                if (price = availabilitiesJSON.availability[b].priceWithDiscount[pos], price.currencyId == $("#currencyCode").val()) {
                    g = price.total;
                    break
                }
            e.set("text", price.currencySymbol + " " + roundNumber(g, 0))
        }
    } else {
        addPointOfInterestMarkers();
        this.mapRendered = !0;
        var i = new google.maps.LatLngBounds;
        for (b = 0; b < availabilitiesJSON.availability.length; b++) {
            d = availabilitiesJSON.availability[b].hotel.geoLocation;
            var g = availabilitiesJSON.availability[b].hotel,
                e;
            e = new google.maps.MarkerImage(resourcesPath + "bundles/btctriphotels/images/transparentMarker.png", null, null, null, new google.maps.Size(60, 30));
            d = new google.maps.Marker({
                position: new google.maps.LatLng(d.latitude, d.longitude),
                map: a,
                icon: e
            });
            i.extend(d.getPosition());
            markers.push(d);
            d.set("id", b);
            g.id == c ? (e = new CustomLabel({
                map: a
            }, "mainSprite hotel-marker-selected"), e.set("zIndex", 1234), selectedMarker = d, selectedLabel = e) : (e = new CustomLabel({
                map: a
            }, "mainSprite hotel-marker"), e.set("zIndex", b));
            e.bindTo("position", d, "position");
            g = "";
            for (pos in availabilitiesJSON.availability[b].priceWithDiscount)
                if (price = availabilitiesJSON.availability[b].priceWithDiscount[pos], price.currencyId == $("#currencyCode").val()) {
                    g = price.total;
                    break
                }
            e.set("text", price.currencySymbol + " " + roundNumber(g, 0));
            this.labels[b] = e;
            google.maps.event.addListener(d, "click", function (b, c) {
                return function () {
                    var d = availabilitiesJSON.availability[c].hotel.description,
                        e = availabilitiesJSON.availability[c].hotel,
                        g = "goToHotelDetail" + e.id + "3";
                    100 < d.length && (d = d.substring(0,
                        100), d += "...");
                    var i = $("#SeeDetail").val() ? $("#SeeDetail").val() : "See Details",
                        h;
                    h = "<div class='hotel-marker-bubble'>" + ("<div class='hotel-marker-pic'><img src='http://media.staticontent.com/media/pictures/" + availabilitiesJSON.availability[c].hotel.pictureName + "/160x130'/></div>");
                    h = h + "<div class='hotel-marker-info'>" + ("<div class='hotel-marker-title'><a onclick=document.getElementById('" + g + "').click();>" + e.name + "</a><span class='mainSprite stars-rating-" + e.starRating + "'></span></div>");
                    h += "<div class='hotel-marker-description'>" +
                        d + " <a onclick=document.getElementById('" + g + "').click();>" + i + " \u00bb</a></div>";
                    h += "</div>";
                    h += "</div>";
                    f.setContent(h);
                    f.open(a, b)
                }
            }(d, b))
        }
        this.markerCluster = new MarkerClusterer(a, markers, this.labels, {
            maxZoom: 15,
            styles: [{
                height: 34,
                url: resourcesPath + "bundles/btctriphotels/images/markerCluster.png",
                width: 34
            }]
        });
        a.setCenter(i.getCenter());
        var j = google.maps.event.addListener(a, "idle", function () {
            google.maps.event.trigger(a, "resize");
            lastMapCenter = i.getCenter();
            lastMapZoom = getZoomByBounds(a, i);
            10 > c && (a.setCenter(i.getCenter()),
                a.setZoom(lastMapZoom));
            google.maps.event.removeListener(j)
        })
    }
    0 < c && (a.setCenter(selectedMarker.getPosition()), a.setZoom(this.defaultZoom))
}

function addPointOfInterestMarkers() {
    if (null != pointsOfInterestFacet)
        for (var a = 0; a < pointsOfInterestFacet.length; a++) {
            var c;
            c = pointsOfInterestFacet[a].description;
            void 0 != pointsOfInterestFacet[a].distance && (c += " a " + pointsOfInterestFacet[a].distance + " km");
            c = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(pointsOfInterestFacet[a].latitude), parseFloat(pointsOfInterestFacet[a].longitude)),
                map: map,
                title: c,
                icon: resourcesPath + "bundles/btctriphotels/images/pointMarker.png"
            });
            pointOfInterestMarkers.push(c)
        }
}

function showHotelMarker(a, c, f) {
    addPointOfInterestMarkers();
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(parseFloat(c.replace(",", ".")), parseFloat(f.replace(",", "."))),
        map: a,
        icon: resourcesPath + "bundles/btctriphotels/images/hotelMarker.png"
    });
    var b = google.maps.event.addListener(a, "idle", function () {
        google.maps.event.trigger(a, "resize");
        a.setCenter(marker.getPosition());
        google.maps.event.removeListener(b)
    })
   
}

function initializeAvailabilities(a) {
    availabilitiesJSON = a;
    pointsOfInterestFacet = getFacet("pointsofinterest", a.facets).values;
    this.mapRendered = !1;
    removeAllMarkers()
}

function setPointsOfInterest(a) {
    pointsOfInterestFacet = a
};