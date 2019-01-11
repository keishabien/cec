$(document).ready(function () {
    $("#searchAll").ufForm({
        msgTarget: $("#alerts-page")
    })
        .on("submitSuccess.ufForm", function () {
        window.location.reload();
        })
        .on("submitError.ufForm", function () {
            console.log("fail");
        })
    ;

    console.log('test');
});
