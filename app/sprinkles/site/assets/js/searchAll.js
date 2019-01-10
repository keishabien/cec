$(document).ready(function () {
    $("#searchAll").ufForm({
        msgTarget: $("#alerts-page")
    }).on("submitSuccess.ufForm", function () {
        window.location.reload();
    });

    console.log('test');
});
