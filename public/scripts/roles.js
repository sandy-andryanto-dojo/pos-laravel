$(document).ready(function() {

    let routeName = "roles";
    let tableName = "roles";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Role');
    let dataTableColumns = [
        { name: 'roles.name', data: 'roles_name' },
        {
            name: 'roles.id',
            data: 'actions',
            orderable: false,
            render: function(data, type, row, meta) {
                if (row.roles_name !== 'Admin') {
                    return data;
                } else {
                    var action = data.split("&nbsp;");
                    var btn = "";
                    action.forEach(function(row) {
                        let temp = $(row);
                        if (temp.hasClass("btn-show")) {
                            btn += row;
                        }
                    });
                    return btn;
                }
            }
        },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

    $("#checked-all").change(function(e) {
        e.preventDefault();
        $('input:checkbox').not(this).not(":disabled").prop('checked', this.checked);
        return false;
    });

    $(".action").change(function(e) {
        e.preventDefault();
        let id = $(this).attr("id");
        $('input:checkbox.' + id).not(this).prop('checked', this.checked).change();
        return false;
    });

});