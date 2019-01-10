$(document).ready(function () {
    $("#searchAll").ufForm({
        msgTarget: $("#alerts-page")
    }).on("submitSuccess.ufForm", function () {
        var keyword = $('.search').value();
        window.location.replace(site.uri.public + "/search?keyword=" + keyword);
    });

    console.log('test');
});
