/**
 * Users widget.  Sets up dropdowns, modals, etc for a table of users.
 */


$("#myUserTable").ufTable({
    dataUrl: site.uri.public + "/api/dash/offices/o/{office_name}"
});

// $('#widget-users').ufTable({
//     dataUrl: site.uri.public + '/api/users',
//     columnTemplates: {
//         name: function (params) {
//             return "<td>" + params.row.full_name + "</td>";
//         },
//         last_activity: '#user-table-column-last-activity'
//     }
// });

