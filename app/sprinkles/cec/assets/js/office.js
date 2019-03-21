/**
 * Page-specific Javascript file.  Should generally be included as a separate asset bundle in your page template.
 * example: {{ assets.js('js/pages/sign-in-or-register') | raw }}
 *
 *
 * Target page: /offices/o/{office_name}
 */

$menu = $('#hours-menu');
$('#hours').click(function (e) {
    e.stopPropagation();
    $($menu).slideToggle();
});
$('body').click(function () {
    if ($($menu).is(":visible")) {
        $($menu).slideUp();
    }
});

