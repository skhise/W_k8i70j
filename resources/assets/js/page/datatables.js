$("#tbclinet").dataTable({
    "columnDefs": [
        { "sortable": false, "targets": [6] },
        { "visible": false, "targets": [0] },
    ],
    order: [[0, 'desc']]
});


$('#tbclinet tbody').on('click', '.fa-trash', function () {
    var tb = $('#tbclinet').DataTable();
    var row = tb.row($(this).parents('tr'));
    var data = row.data();
    var clinetId = (data[Object.keys(data)[0]]);
    var ApiUrl = $("#hdnApiUrl").val();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: ApiUrl + 'api/Client/DeleteClient/',
        data: { cId: clinetId },
        success: function (data) {
            row.remove().draw();
        }
    });
});

$("#tbSitelocation").dataTable({
    "columnDefs": [
        { "sortable": false, "targets": [8] },
        { "visible": false, "targets": [0] },
    ],
    order: [[0, 'desc']]
});

$('#tbSitelocation tbody').on('click', '.fa-trash', function () {
    var tb = $('#tbSitelocation').DataTable();
    var row = tb.row($(this).parents('tr'));
    var data = row.data();
    var SiteLocatioId = (data[Object.keys(data)[0]]);
    var ApiUrl = $("#hdnApiUrl").val();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: ApiUrl + 'api/SiteLocation/DeleteSiteLocation/',
        data: { slId: SiteLocatioId },
        success: function (data) {
            row.remove().draw();
        }
    });
});

$("#tbPerson").dataTable({
    "columnDefs": [
        { "sortable": false, "targets": [6] },
        { "visible": false, "targets": [0] },
    ],
    order: [[0, 'desc']]
});

$('#tbPerson tbody').on('click', '.fa-trash', function () {
    var tb = $('#tbPerson').DataTable();
    var row = tb.row($(this).parents('tr'));
    var data = row.data();
    var PersonId = (data[Object.keys(data)[0]]);
    var ApiUrl = $("#hdnApiUrl").val();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: ApiUrl + 'api/Person/DeletePerson/',
        data: { pId: PersonId },
        success: function (data) {
            row.remove().draw();
        }
    });
});

$("#tbProject").dataTable({
    "columnDefs": [
        { "sortable": false, "targets": [9] },
        { "visible": false, "targets": [0] },
    ],
    order: [[0, 'desc']]
});

$('#tbProject tbody').on('click', '.fa-trash', function () {
    var tb = $('#tbProject').DataTable();
    var row = tb.row($(this).parents('tr'));
    var data = row.data();
    var ProjectId = (data[Object.keys(data)[0]]);
    var ApiUrl = $("#hdnApiUrl").val();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: ApiUrl + 'api/Project/DeleteProject/',
        data: { prId: ProjectId },
        success: function (data) {
            row.remove().draw();
        }
    });
});

$("#tbEmployee").dataTable({
    "columnDefs": [
        { "sortable": false, "targets": [4] },
        { "visible": false, "targets": [0] },
    ],
    order: [[0, 'desc']]
});

$('#tbEmployee tbody').on('click', '.fa-trash', function () {
    var tb = $('#tbEmployee').DataTable();
    var row = tb.row($(this).parents('tr'));
    var data = row.data();
    var EmployeeId = (data[Object.keys(data)[0]]);
    var ApiUrl = $("#hdnApiUrl").val();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: ApiUrl + 'api/Employee/DeleteEmployee/',
        data: { elId: EmployeeId },
        success: function (data) {
            row.remove().draw();
        }
    });
});