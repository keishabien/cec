// Cloning Adult
var anpie_count = 2;
$('.repeat-adult').on('click', function () {
    var source = $('.adult-npie-section:first'), clone = source.clone();
    clone.find(':input').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + anpie_count;
    });

    clone.find('label').attr('for', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + anpie_count;
    });

    clone.find('h2').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + anpie_count;
    }).html("Adult NPIE " + anpie_count + "<i class=\"fa fa-times pull-right remove-adult\"></i>");
    clone.insertBefore('.adult-button-row');
    anpie_count++;
    console.log("repeat: " + anpie_count);
});

// Removing Form Field
$('body').on('click', '.remove-adult', function () {
    $(this).closest('.adult-npie-section').remove();
    recountAdult();
    return false;
});

function recountAdult() {
    anpie_count--;
    console.log("recount: " + anpie_count);
    $(".adult-npie-section").each(function (i) {
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
            }).html("Adult NPIE " + i);

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
            }).html("Adult NPIE " + i + "<i class=\"fa fa-times pull-right remove-adult\"></i>");
        }
    });
}






// Cloning Hygienist
var cnpie_count = 2;
$('.repeat-child').on('click', function () {
    var source = $('.child-npie-section:first'), clone = source.clone();
    clone.find(':input').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + cnpie_count;
    });

    clone.find('label').attr('for', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + cnpie_count;
    });

    clone.find('h2').attr('id', function (i, val) {
        val = val.substr(0, val.lastIndexOf('-'));
        return val + "-" + cnpie_count;
    }).html("Child NPIE " + cnpie_count + "<i class=\"fa fa-times pull-right remove-child\"></i>");
    clone.insertBefore('.child-button-row');
    cnpie_count++;
    console.log("repeat: " + cnpie_count);
});

// Removing Form Field
$('body').on('click', '.remove-child', function () {
    $(this).closest('.child-npie-section').remove();
    recountChild();
    return false;
});

function recountChild() {
    cnpie_count--;
    console.log("recount: " + cnpie_count);
    $(".child-npie-section").each(function (i) {
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
            }).html("Child NPIE " + i);

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
            }).html("Child NPIE " + i + "<i class=\"fa fa-times pull-right remove-child\"></i>");
        }
    });
}
