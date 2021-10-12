$(document).ready(function() {

    let routeName = "products";
    let tableName = "products";
    let dataTableConteiner = "#table-data";
    let modelData = btoa('/App/Models/Product');
    let dataTableColumns = [
        { name: 'products.sku', data: 'products_sku' },
        { name: 'products.name', data: 'products_name' },
        { name: 'products.stock', data: 'products_stock' },
        { name: 'products.id', data: 'actions', "orderable": false },
    ];

    dataTableRender({
        "routeName": routeName,
        "tableName": tableName,
        "dataTableConteiner": dataTableConteiner,
        "modelData": modelData,
        "dataTableColumns": dataTableColumns
    });

    var calcPriceSale = function(){
        let purchase = parseFloat($("#price_purchase").val());
        let profit =   parseFloat($("#price_profit").val());
        let prc = parseFloat(profit / 100);
        let cost = purchase * prc;
        let priceSale = purchase + cost;
        $("#price_sales").val(priceSale || purchase);
    }

    $('#price_purchase').keyup(function() {
        calcPriceSale();
    });

    $('#price_profit').keyup(function() {
        calcPriceSale();  
    });

});