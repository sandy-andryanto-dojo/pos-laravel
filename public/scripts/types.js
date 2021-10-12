$(document).ready(function() {

    let routeName = "types";
    let tableName = "types";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Type');
    let dataTableColumns = [
        { name: 'types.name', data: 'types_name' },
        { 
            name: 'types.description', 
            data: 'types_description',
            render: function(data, type, row, meta) {
                var notif = data.split(".");
                return notif[0];
            }
        },
        { name: 'types.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

});