// Cloning Adult
var arecall_count = 2;
$('.repeat-adult').on('click', function () {
    var source = $('.adult-recall-section:first'), clone = source.clone();
    clone.find(':input').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + arecall_count;
    });

    clone.find('label').attr('for', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + arecall_count;
    });

    clone.find('h2').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + arecall_count;
    }).html("Adult Recall " + arecall_count + "<i class=\"fa fa-times pull-right remove-adult\"></i>");
    clone.insertBefore('.adult-button-row');
    arecall_count++;
    console.log("repeat: " + arecall_count);
});

// Removing Form Field
$('body').on('click', '.remove-adult', function () {
    $(this).closest('.adult-recall-section').remove();
    recountAdultRecall();
    return false;
});

function recountAdultRecall() {
    arecall_count--;
    console.log("recount: " + arecall_count);
    $(".adult-recall-section").each(function (i) {
        i = i + 1;
        if (i === 1) {
            $(this).find(':input').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('label').attr('for', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('h2').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            }).html("Adult Recall " + i);

        } else {
            $(this).find(':input').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('label').attr('for', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('h2').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            }).html("Adult Recall " + i + "<i class=\"fa fa-times pull-right remove-adult\"></i>");
        }
    });
}






// Cloning Hygienist
var crecall_count = 2;
$('.repeat-child').on('click', function () {
    var source = $('.child-recall-section:first'), clone = source.clone();
    clone.find(':input').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + crecall_count;
    });

    clone.find('label').attr('for', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + crecall_count;
    });

    clone.find('h2').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + crecall_count;
    }).html("Child Recall " + crecall_count + "<i class=\"fa fa-times pull-right remove-child\"></i>");
    clone.insertBefore('.child-button-row');
    crecall_count++;
    console.log("repeat: " + crecall_count);
});

// Removing Form Field
$('body').on('click', '.remove-child', function () {
    $(this).closest('.child-recall-section').remove();
    recountChildRecall();
    return false;
});

function recountChildRecall() {
    crecall_count--;
    console.log("recount: " + crecall_count);
    $(".child-recall-section").each(function (i) {
        i = i + 1;
        if (i === 1) {
            $(this).find(':input').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('label').attr('for', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('h2').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            }).html("Child Recall " + i);

        } else {
            $(this).find(':input').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('label').attr('for', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            });

            $(this).find('h2').attr('id', function (j, val) {
                val = val.substr(0, val.lastIndexOf('-'));
                return val + "-" + i;
            }).html("Child Recall " + i + "<i class=\"fa fa-times pull-right remove-child\"></i>");
        }
    });
}
