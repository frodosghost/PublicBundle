/**
 * Analytics
 *
 * This file adds Analytics tracking to links used withing the public site
 */
if (typeof _gaq !== 'undefined') {

    /**
     * Adds Google Analytics tracking to Addthis links for share of media
     */
    if (typeof addthis !== 'undefined') {
        addthis.addEventListener('addthis.menu.share', function(event) {
            var data = event.data;

            if (typeof _gaq !== 'undefined') {
                _gaq.push(['_trackEvent', 'Social', 'Share', data.service]);
            }
        });
    };

    /**
     * Adds Google Analytics tracking to External links
     */
    var regExp = new RegExp("//" + location.host + "($|/)");

    $$('a').each(function(element) {
        var href = element.href;

        if ((href.substring(0,4) === "http") && (!regExp.test(href))) {
            element.addEvent('click', function(event) {
                if (element.hasClass('tracking')) {
                    // Adds Google Analytics tracking to all social media links
                    _gaq.push(['_trackEvent', 'Social', 'Follow', element.innerHTML]);
                } else if (element.hasClass('partner')) {
                    _gaq.push(['_trackEvent', 'External', 'Partner', href]);
                } else if (element.get('target') == '_document') {
                    _gaq.push(['_trackEvent', 'Document', 'Download', element.innerHTML]);
                } else {
                    // Adds Google Analytics tracking to External links
                    _gaq.push(['_trackEvent', 'External', 'Link', href]);
                }
            });
        };
    });

}
