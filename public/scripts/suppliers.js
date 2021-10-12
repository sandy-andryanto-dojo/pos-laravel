$(document).ready(function() {

    let routeName = "suppliers";
    let tableName = "suppliers";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Supplier');
    let dataTableColumns = [
        { name: 'suppliers.name', data: 'suppliers_name' },
        { name: 'suppliers.phone', data: 'suppliers_phone' },
        { name: 'suppliers.email', data: 'suppliers_email' },
        { name: 'suppliers.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

});