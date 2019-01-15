/**
 * Page-specific Javascript file.  Should generally be included as a separate asset bundle in your page template.
 * example: {{ assets.js('js/pages/sign-in-or-register') | raw }}
 *
 * This script depends on uf-table.js, moment.js, handlebars-helpers.js
 *
 * Target page: /offices/o/{office_name}
 */

$(document).ready(function() {
    // Control buttons
    bindUserButtons($("#view-office"));

    // Table of activities
    $("#widget-user-activities").ufTable({
        dataUrl: site.uri.public + '/api/office/o/' + office[0].page_title + '/activities',
        useLoadingTransition: site.uf_table.use_loading_transition
    });

    // Table of permissions
    $("#widget-permissions").ufTable({
        dataUrl: site.uri.public + '/api/offices/o/' + office[0].page_title + '/permissions',
        useLoadingTransition: site.uf_table.use_loading_transition
    });
});
