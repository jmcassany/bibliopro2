var CookieManager = {
    TextLleiCookies_ca: '<div class="medium-18 medium-centered columns text-center"><p>Utilitzem cookies pròpies i de tercers per millorar els nostres serveis mitjançant l\'anàlisi dels seus hàbits de navegació.<br/>Si continua navegant, considerem que accepta el seu ús. <a class="noaccept" href="/politica-de-cookies.html/">Més informació</a></p><p><a class="button small radius acceptar" href="javascript:void(0);">D\'acord</a></p></div>',
    TextLleiCookies_es: '<div class="medium-18 columns"><p>Utilizamos cookies propias y de terceros para mejorar nuestros servicios mediante el análisis de sus hábitos de navegación.<br/>Si continúa navegando, consideramos que acepta su uso. <a class="noaccept" href="/es_politica-de-cookies.html">Más información</a></p><p><a class="button small success radius acceptar" href="javascript:void(0);">De acuerdo</a> </p></div>',
    TextLleiCookies_en: '<div class="medium-18 columns"><p>We use our own and third-party cookies to improve our services by analysing your browsing habits.<br/>We will take your continued browsing to mean that you accept their use. <a class="noaccept" href="/en_politica-de-cookies.html">More information</a></p><p><a class="button small success radius acceptar" href="javascript:void(0);">Accept</a></p></div>',
    TextLleiCookies_fr: '<div class="medium-18 columns"><p>Nous utilisons nos propres cookies et ceux de tiers pour améliorer nos services à travers l’analyse de vos habitudes de navigation.<br/>Si vous poursuivez la navigation, vous êtes censé accepter l’usage de ces cookies. <a class="button small radius noaccept" href="/en_politica-de-cookies.html">Plus d\'information</a></p><p><a class="acceptar" href="javascript:void(0);">Accepter</a> </p></div>',

    cookieSetter: null,
    cookieGetter: null,
    cookie: function () {
        var cookie = {
            nombre: '',
            valor: ''
        };
        return cookie;
    },
    addCookie: function (s) {
        var indexOfSeparator = s.indexOf("=");
        var key = s.substr(0, indexOfSeparator);
        var value = s.substring(indexOfSeparator + 1);
        var galeta = new this.cookie();
        galeta.nombre = key;
        galeta.valor = value;
        this.deletedCookies.push(galeta);
    },
    deletedCookies: new Array(),
    restoreAllCookies: function () {
        var tam = this.deletedCookies.length;
        for (var i = 0; i < tam; i++) {
            document.cookie = this.deletedCookies[i].nombre + "=" + this.deletedCookies[i].valor;
        }
    },
    deleteAllCookies: function () {
        var cookies = document.cookie.split(";");
        var parts = document.domain.split('.');
        var subdomain = parts.shift();
        var upperleveldomain = parts.join('.');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            if (name != 'PHPSESSID' && name != 'lang') {
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                document.cookie = name + '=;domain=' + document.domain + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                document.cookie = name + '=;path=/;domain=' + document.domain + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                if (upperleveldomain != document.domain) {
                    document.cookie = name + '=;domain=' + upperleveldomain + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                    document.cookie = name + '=;path=/;domain=' + upperleveldomain + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                }
            }
        }
    },
    interval: 0,
    fakeCookieFunctions: function () {
        var timeInterval = 50;
        if (!document.__defineGetter__) {
            this.interval = setInterval("CookieManager.deleteAllCookies()", timeInterval);
        } else {
            CookieManager.cookieGetter = document.__lookupGetter__('cookie');
            CookieManager.cookieSetter = document.__lookupSetter__('cookie');
            if (!CookieManager.cookieGetter) {
                this.interval = setInterval("CookieManager.deleteAllCookies()", timeInterval);
            } else {
                document.__defineGetter__("cookie", function () {
                    return '';
                });
                document.__defineSetter__('cookie', function (s) {
                    CookieManager.addCookie(s);
                });
            }
        }
    },
    restoreCookieFunctions: function () {
        if (!document.__defineGetter__) {
            clearInterval(this.interval);
            this.setCookie('cookies', 'true', 365 * 100);
             $('body').append('<iframe id="marcoaux" style="display:none;" src="' + document.location + '"></iframe>');
        } else {
            if (!this.cookieGetter) {
                clearInterval(this.interval);
                this.setCookie('cookies', 'true', 365 * 100);
                 $('body').append('<iframe id="marcoaux" style="display:none;" src="' + document.location + '"></iframe>');
            } else {
                document.__defineGetter__("cookie", this.cookieGetter);
                document.__defineSetter__("cookie", this.cookieSetter);
            }
        }
    },
    getCookie: function (c_name) {
        var c_value = document.cookie;
        var c_start = c_value.indexOf(" " + c_name + "=");
        if (c_start == -1) {
            c_start = c_value.indexOf(c_name + "=");
        }
        if (c_start == -1) {
            c_value = null;
        } else {
            c_start = c_value.indexOf("=", c_start) + 1;
            var c_end = c_value.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = c_value.length;
            }
            c_value = unescape(c_value.substring(c_start, c_end));
        }
        return c_value;
    },
    setCookie: function (c_name, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays === null) ? "" : "; expires=" + exdate.toUTCString());
        document.cookie = c_name + "=" + c_value + "; path=/";
    },
    noCookies: function () {
        var cookie = this.getCookie('cookies');
        return cookie === undefined || cookie === null || cookie === '';
    },
    noCookiesNav: function () {
        var cookieNav = this.getCookie('cookiesNav');
        return cookieNav === undefined || cookieNav === null || cookieNav === '';
    },
    firstTime: true,
    activateCookies: function (showMessage) {
        if (this.firstTime) {
            this.restoreCookieFunctions();
            this.restoreAllCookies();
            this.setCookie('cookies', 'true', 365 * 100);
            this.firstTime = false;
        }
        if(showMessage === false){
            $("#cookies").remove();
            this.setCookie('cookiesNav', 'true', 365 * 100);
        }
    },
    deactivateCookies: function (selector,deleteCookies) {
        var lleiCookiesText = this.TextLleiCookies_es;
        if (typeof idioma != 'undefined' && idioma == 'ca') lleiCookiesText = this.TextLleiCookies_ca;
        if (typeof idioma != 'undefined' && idioma == 'en') lleiCookiesText = this.TextLleiCookies_en;
        if (typeof idioma != 'undefined' && idioma == 'fr') lleiCookiesText = this.TextLleiCookies_fr;
        codiLleiCookies = '<div id="cookies" class="cookies hide-for-print"><div class="row">'+lleiCookiesText+'</div></div>',
        $(selector).prepend(codiLleiCookies);
        if(deleteCookies){
            this.deleteAllCookies();
            this.fakeCookieFunctions();
        }
    },
    init: function (selector) {
        var noCookies = this.noCookies();
        var noCookiesNav = this.noCookiesNav();
        if (noCookies || noCookiesNav) {
            this.deactivateCookies(selector,noCookies);
            $('a').click(function () {
                if ($(this).hasClass('acceptar')){
                    CookieManager.activateCookies(false);
                }else if (!$(this).hasClass('noaccept')) {
                    CookieManager.activateCookies(true);
                }
            });
            $(window).scroll(function () {
                CookieManager.activateCookies(true);
            });
        }
    },

    initAllDeactivate: function (selector) {
        var noCookies = this.noCookies();
        var noCookiesNav = this.noCookiesNav();
        if (noCookies || noCookiesNav) {
            this.deleteAllCookies();
            this.fakeCookieFunctions();
        }
    }


};
$(function () {
    if(navigator.cookieEnabled){
/*        if ($('body#nocookies').length == 0) {
            CookieManager.init('body');
        }*/
        if ($('body#nocookies').length == 1) {
            CookieManager.initAllDeactivate('body');
        } else {
            CookieManager.init('body');
        }
    }
});
