// Cloning Dentist
var den_count = 2;
$('.repeat-dentist').on('click', function () {
    var source = $('.dentist-section:first'), clone = source.clone();
    clone.find(':input').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + den_count;
    });

    clone.find('label').attr('for', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + den_count;
    });

    clone.find('h2').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + den_count;
    }).html("Dentist " + den_count + " Details <i class=\"fa fa-times pull-right remove-dentist\"></i>");
    clone.insertBefore('.dentist-button-row');
    den_count++;
    console.log("repeat: " + den_count);
});

// Removing Form Field
$('body').on('click', '.remove-dentist', function () {
    $(this).closest('.dentist-section').remove();
    recountDentist();
    return false;
});

function recountDentist() {
    den_count--;
    console.log("recount: " + den_count);
    $(".dentist-section").each(function (i) {
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
            }).html("Dentist " + i + " Details");

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
            }).html("Dentist " + i + " Details <i class=\"fa fa-times pull-right remove-dentist\"></i>");
        }
    });
}






// Cloning Hygienist
var hyg_count = 2;
$('.repeat-hygienist').on('click', function () {
    var source = $('.hygienist-section:first'), clone = source.clone();
    clone.find(':input').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + hyg_count;
    });

    clone.find('label').attr('for', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + hyg_count;
    });

    clone.find('h2').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + hyg_count;
    }).html("Hygienist " + hyg_count + " Details <i class=\"fa fa-times pull-right remove-dentist\"></i>");
    clone.insertBefore('.hygienist-button-row');
    hyg_count++;
    console.log("repeat: " + hyg_count);
});

// Removing Form Field
$('body').on('click', '.remove-dentist', function () {
    $(this).closest('.hygienist-section').remove();
    recountHygienist();
    return false;
});

function recountHygienist() {
    hyg_count--;
    console.log("recount: " + hyg_count);
    $(".hygienist-section").each(function (i) {
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
            }).html("Hygienist " + i + " Details");

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
            }).html("Hygienist " + i + " Details <i class=\"fa fa-times pull-right remove-dentist\"></i>");
        }
    });
}
