/**
 * Users widget.  Sets up dropdowns, modals, etc for a table of users.
 */

/**
 * Set up the form in a modal after being successfully attached to the body.
 */
function attachUserForm() {
    $("body").on('renderSuccess.ufModal', function (data) {
        var modal = $(this).ufModal('getModal');
        var form = modal.find('.js-form');

        // Set up any widgets inside the modal
        form.find(".js-select2").select2({
            width: '100%'
        });

        // Set up the form for submission
        form.ufForm({
            validators: page.validators
        }).on("submitSuccess.ufForm", function() {
            // Reload page on success
            window.location.reload();
        });
    });
}

/**
 * Update user field(s)
 */
function updateUser(officeName, fieldName, fieldValue) {
    var data = {
        'value': fieldValue
    };

    data[site.csrf.keys.name] = site.csrf.name;
    data[site.csrf.keys.value] = site.csrf.value;

    var url = site.uri.public + '/api/offices/o/' + officeName + '/' + fieldName;
    var debugAjax = (typeof site !== "undefined") && site.debug.ajax;

    return $.ajax({
        type: "PUT",
        url: url,
        data: data,
        dataType: debugAjax ? 'html' : 'json',
        converters: {
            // Override jQuery's strict JSON parsing
            'text json': function(result) {
                try {
                    // First try to use native browser parsing
                    if (typeof JSON === 'object' && typeof JSON.parse === 'function') {
                        return JSON.parse(result);
                    } else {
                        return $.parseJSON(result);
                    }
                } catch (e) {
                    // statements to handle any exceptions
                    console.log("Warning: Could not parse expected JSON response.");
                    return {};
                }
            }
        }
    }).fail(function (jqXHR) {
        // Error messages
        if (debugAjax && jqXHR.responseText) {
            document.write(jqXHR.responseText);
            document.close();
        } else {
            console.log("Error (" + jqXHR.status + "): " + jqXHR.responseText );

            // Display errors on failure
            // TODO: ufAlerts widget should have a 'destroy' method
            if (!$("#alerts-page").data('ufAlerts')) {
                $("#alerts-page").ufAlerts();
            } else {
                $("#alerts-page").ufAlerts('clear');
            }

            $("#alerts-page").ufAlerts('fetch').ufAlerts('render');
        }

        return jqXHR;
    }).done(function (response) {
        window.location.reload();
    });
}

/**
 * Link user action buttons, for example in a table or on a specific user's page.
 */
function bindUserButtons(el) {

    /**
     * Buttons that launch a modal dialog
     */
    // Edit general user details button
    el.find('.js-user-edit').click(function() {
        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/offices/edit",
            ajaxParams: {
                // user_name: $(this).data('user_name')
                office_name: $(this).data('office_name')
            },
            msgTarget: $("#alerts-page")
        });

        attachUserForm();
    });

    // Manage user roles button
    el.find('.js-user-roles').click(function() {
        var userName = $(this).data('user_name');
        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/offices/roles",
            ajaxParams: {
                office_name: officeName
            },
            msgTarget: $("#alerts-page")
        });

        $("body").on('renderSuccess.ufModal', function (data) {
            var modal = $(this).ufModal('getModal');
            var form = modal.find('.js-form');

            // Set up collection widget
            var roleWidget = modal.find('.js-form-roles');
            roleWidget.ufCollection({
                dropdown : {
                    ajax: {
                        url     : site.uri.public + '/api/roles'
                    },
                    placeholder : "Select a role"
                },
                dropdownTemplate: modal.find('#user-roles-select-option').html(),
                rowTemplate     : modal.find('#user-roles-row').html()
            });

            // Get current roles and add to widget
            $.getJSON(site.uri.public + '/api/offices/o/' + officeName + '/roles')
                .done(function (data) {
                    $.each(data.rows, function (idx, role) {
                        role.text = role.name;
                        roleWidget.ufCollection('addRow', role);
                    });
                });

            // Set up form for submission
            form.ufForm({
            }).on("submitSuccess.ufForm", function() {
                // Reload page on success
                window.location.reload();
            });
        });
    });


    // Delete user button
    el.find('.js-user-delete').click(function() {
        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/offices/confirm-delete",
            ajaxParams: {
                office_name: $(this).data('office_name')
            },
            msgTarget: $("#alerts-page")
        });

        $("body").on('renderSuccess.ufModal', function (data) {
            var modal = $(this).ufModal('getModal');
            var form = modal.find('.js-form');

            form.ufForm()
                .on("submitSuccess.ufForm", function() {
                    // Reload page on success
                    window.location.reload();
                });
        });
    });

    /**
     * Direct action buttons
     */
    el.find('.js-user-activate').click(function() {
        var btn = $(this);
        updateUser(btn.data('user_name'), 'flag_verified', '1');
    });

    el.find('.js-user-enable').click(function () {
        var btn = $(this);
        updateUser(btn.data('user_name'), 'flag_enabled', '1');
    });

    el.find('.js-user-disable').click(function () {
        var btn = $(this);
        updateUser(btn.data('user_name'), 'flag_enabled', '0');
    });
}

function bindUserCreationButton(el) {
    // Link create button
    el.find('.js-user-create').click(function() {
        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/offices/create",
            msgTarget: $("#alerts-page")
        });

        attachUserForm();
    });
}


$("#myUserTable").ufTable({
    dataUrl: site.uri.public + "/api/dash/offices/o/{office_name}"
});

$('#widget-users').ufTable({
    dataUrl: site.uri.public + '/api/users',
    columnTemplates: {
        name: function (params) {
            return "<td>" + params.row.full_name + "</td>";
        },
        last_activity: '#user-table-column-last-activity'
    }
});

