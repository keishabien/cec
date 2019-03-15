/**
 * Page-specific Javascript file.  Should generally be included as a separate asset bundle in your page template.
 * example: {{ assets.js('js/pages/sign-in-or-register') | raw }}
 *
 * This script depends on widgets/users.js, uf-table.js, moment.js, handlebars-helpers.js
 *
 * Target page: /users
 */

$(document).ready(function() {
    // Set up table of users
    $("#widget-offices").ufTable({
        dataUrl: site.uri.public + "/api/offices",
        useLoadingTransition: site.uf_table.use_loading_transition
    });

    // Bind creation button
    bindUserCreationButton($("#widget-offices"));

    // Bind table buttons
    $("#widget-offices").on("pagerComplete.ufTable", function () {
        bindUserButtons($(this));
    });
});
