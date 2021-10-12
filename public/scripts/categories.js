$(document).ready(function() {

    let routeName = "categories";
    let tableName = "categories";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Category');
    let dataTableColumns = [
        { name: 'categories.name', data: 'categories_name' },
        { 
            name: 'categories.description', 
            data: 'categories_description',
            render: function(data, type, row, meta) {
                var notif = data.split(".");
                return notif[0];
            }
        },
        { name: 'categories.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

});