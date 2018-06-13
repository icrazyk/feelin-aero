var WGLIBS = {
  server: 'www.windguru.cz',
  js: '/js/pak/forecasts-widget.min.js?v=20140601-114211',
  css: '/css/min/wgstyle-widget.min.css?v=20140407-093613'
};

var current_spot;

if (!WgWidget) var WgWidget = (function() {

  var WgWidget;
  if (!WgWidget) var WgWidget = function(m, g) {
    function n() {
      e = window.jQuery.noConflict(!1);
      p()
    }

    function q(h) {
      if (!r) {

        r = !0;

        var b = {},
          d = {
            m: 3,
            params: ["WINDSPD", "SMER", "TMPE", "CDC", "APCPs"],
            tabs: !1,
            wg_logo: !0,
            spotname: !0,
            first_row_minfo: !0,
            options_link: !1,
            link_archive: !1,
            link_tides: !1,
            link_link: !1,
            odh: 3,
            doh: 22,
            fhours: 72,
            wrap: 200,
            lng: "en",
            logo: !0,
            poweredby: !0,
            path_img: f + k + "/int/img/",
            path_lng: f + t + "/int/",
            fcst_maps: !1
          },
          c;
        
        for (c in h) d[c] = h[c];
        h = [];

        for (c = 0; c < d.params.length; c++) {
          var a = d.params[c];
          "WAVESMER" == a && (a =
            "DIRPW");
          h[c] = a
        }

        d.params = h;
        b.url = window.location.href;
        b.hostname = window.location.hostname;
        b.s = d.s;
        b.m = d.m;
        b.lng = d.lng;

        var l = b.s + "_" + b.m + "_" + b.lng;

        c = e("#" + g);
        c.hasClass("cleanslate") || c.addClass("cleanslate");
        c.hasClass("wgfcst") || c.addClass("wgfcst");
        "undefined" === typeof WgJsonCache && (WgJsonCache = {});
        
        // hack start
        current_spot = windguruData.find(i => i.fcst.id_spot = l);
        // d.lang = current_spot.lang;
        // WgFcst.showForecast(current_spot.fcst, d, g);
        // hack end

        WgJsonCache[l] ? (d.lang = WgJsonCache[l].lang, WgFcst.showForecast(WgJsonCache[l].fcst, d, g)) : (function(b) {
          // debugger;
          b.error ? b.fcst = b : (d.lang = b.lang, WgJsonCache[l] = b);
          WgFcst.showForecast(b.fcst, d, g)
        })(current_spot);
      }
    }

    function p() {
      e(document).ready(function(a) {
        window.WgWidget_started || (WgWidget_started = {});
        if (WgWidget_started[g]) return !0;
        WgWidget_started[g] = !0;
        e("<link>", {
          rel: "stylesheet",
          type: "text/css",
          href: f + k + u
        }).appendTo("head");
        "undefined" === typeof WgFcst ? (e.ajaxSetup({
          cache: !0
        }), e.getScript(f + k + v, function() {
          e.ajaxSetup({
            cache: !1
          });
          q(m)
        }), e.ajaxSetup({
          cache: !1
        })) : q(m)
      })
    }

    function s(a) {
      if (!window.jQuery) return !1;
      for (var b, d, c = window.jQuery.fn.jquery, e = c.split("."); a.length <
        e.length;) a.push(0);
      for (b = 0; b < a.length; b++) {
        d = parseInt(e[b]);
        if (d > a[b]) return !0;
        if (d < a[b]) return !1
      }
      return c === a.join(".")
    }
    var e, a = window.WGLIBS || {},
      k = a.server || "www.windguru.cz",
      u = a.css || "/css/min/wgstyle-widget.min.css",
      v = a.js || "/js/pak/forecasts-widget.min.js",
      t = "www.windguru.cz",
      r = !1,
      a = !1;
    "https:" == window.location.protocol && (a = !0);
    var f = "http://";
    a && (f = "https://");
    !s([1, 4, 0]) || s([1, 8, 4]) ? (a = document.createElement("script"), a.setAttribute("type", "text/javascript"), a.setAttribute("src", "https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"),
      a.onload = n, -1 != navigator.userAgent.indexOf("MSIE") && (a.onreadystatechange = function() {
        ("complete" == this.readyState || "loaded" == this.readyState) && n()
      }), (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(a)) : (e = window.jQuery, p())
  };
  return WgWidget;
})();
