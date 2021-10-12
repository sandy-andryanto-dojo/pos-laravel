$(document).ready(function(){

    $("body").on("click", ".btn-report-show", function(e){
        e.preventDefault();
        let url = $(this).attr("data-href");
        $("#iframe-report").attr("src", url);
        $("#myModal").modal("show");
        return false;
    });

    $('.date-filter').datepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd'
    }).on('changeDate', function(ev){
        let url = $("#iframe-report").attr("src");
        let prefix = url.split('/').pop();
        let arr = prefix.split("_");
        let first_date = $("#first_date").val();
        let last_date = $("#last_date").val();
        let newPrefix = new Array();
        newPrefix.push(arr[0]);
        newPrefix.push(arr[1]);
        newPrefix.push(first_date);
        newPrefix.push(last_date);
        let params = newPrefix.join("_");
        let reportUrl = BASE_URL+"/reports/"+params;
        $("#iframe-report").attr("src", reportUrl);
    });

    $("#btn-print").click(function(e){
        e.preventDefault();
        document.getElementById('iframe-report').contentWindow.print();
        return false;
    });
    

});