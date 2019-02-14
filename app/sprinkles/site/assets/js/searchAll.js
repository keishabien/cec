/**
 * Page-specific Javascript file.  Should generally be included as a separate asset bundle in your page template.
 * example: {{ assets.js('js/pages/sign-in-or-register') | raw }}
 *
 * This script depends on validation rules specified in pages/partials/page.js.twig.
 *
 * Target page: all - search function
 */
$(document).ready(function () {
    /**
     * If there is a redirect parameter in the query string, redirect to that page.
     * Otherwise, if there is a UF-Redirect header, redirect to that page.
     * Otherwise, redirect to the home page.
     */
    function redirectOnSearch(keyword) {
        var components = URI.parse(window.location.href);

        if (keyword) {
            console.log(keyword);
            // Strip leading slashes from redirect strings
            var redirectString = site.uri.public + '/offices?keyword=' + keyword;

            // Strip excess trailing slashes for clean URLs. e.g. if redirect=%2F
            // redirectString = redirectString.replace(/\/+$/, "/");

            // Redirect
            window.location.replace(redirectString);
            // }
            // else if (jqXHR.getResponseHeader('UF-Redirect')) {
            //     window.location.replace(jqXHR.getResponseHeader('UF-Redirect'));
        } else {
            // window.location.replace(site.uri.public);
            console.log('no keyword');
        }
    }

    //submit search form
    $("#searchAll").ufForm({
        msgTarget: $("#alerts-page")
    }).on("submitSuccess.ufForm", function (event, data, textStatus, jqXHR) {
        var keyword = $('input[name="keyword"]').val();
        redirectOnSearch(keyword);
    }).on("submitError.ufForm", function (event, data, textStatus, jqXHR) {
        console.log(textStatus);
    });

});

