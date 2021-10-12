$(document).ready(function() {

    let routeName = "users";
    let tableName = "users";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/User');
    let dataTableColumns = [
        { name: 'users.username', data: 'users_username' },
        { name: 'users.email', data: 'users_email' },
        {
            name: 'users.access',
            data: 'users_access',
            render: function(data, type, row, meta) {
                let role = JSON.parse(data);
                return role;
            }
        },
        { name: 'users.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

});