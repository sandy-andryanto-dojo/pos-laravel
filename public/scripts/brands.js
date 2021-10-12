$(document).ready(function() {

    let routeName = "brands";
    let tableName = "brands";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Brand');
    let dataTableColumns = [
        { name: 'brands.name', data: 'brands_name' },
        { 
            name: 'brands.description', 
            data: 'brands_description',
            render: function(data, type, row, meta) {
                var notif = data.split(".");
                return notif[0];
            }
        },
        { name: 'brands.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

});