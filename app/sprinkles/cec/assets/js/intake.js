// Collections
$('.repeat-div').click(function () {
    $(this).parent().prev().ufCollection('addRow');
});

$('#dentist-div').ufCollection({
    useDropdown: false,
    rowTemplate: $('#dentist-details-row').html()
});
$('#hygienist-div').ufCollection({
    useDropdown: false,
    rowTemplate: $('#hygienist-details-row').html()
});
$('#adult-div').ufCollection({
    useDropdown: false,
    rowTemplate: $('#adult-row').html()
});
$('#child-div').ufCollection({
    useDropdown: false,
    rowTemplate: $('#child-row').html()
});
