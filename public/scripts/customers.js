$(document).ready(function() {

    let routeName = "customers";
    let tableName = "customers";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Customer');
    let dataTableColumns = [
        { name: 'customers.name', data: 'customers_name' },
        { name: 'customers.phone', data: 'customers_phone' },
        { name: 'customers.email', data: 'customers_email' },
        { name: 'customers.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

});