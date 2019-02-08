$(document).ready(function () {
    $("#searchAll").ufForm({
        msgTarget: $("#alerts-page")
    })
        .on("submitSuccess.ufForm", function () {
        return true;
        })
        .on("submitError.ufForm", function () {
            console.log("fail");
        })
    ;

    console.log('test');
});
