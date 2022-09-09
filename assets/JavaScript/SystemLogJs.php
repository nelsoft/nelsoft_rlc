<script language="javascript" type="text/javascript">

    $(function() {

        $('#text-date-from').datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
        $('#text-date-to').datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
        $("#select-module").chosen({
            no_results_text: "No module such as",
            add_item_enable: false
        });

        $("#button-search").click(function() {
            refreshLogResult();
        });
    });

    /**
     * Function that will manage the displaying and sending parameters to the backend 
     * for refreshing the data displayed
     */
    function refreshLogResult()
    {
        var dateFromValue = $.trim($("#text-date-from").val());
        var dateToValue = $.trim($("#text-date-to").val());
        var moduleIdValue = $("#select-module").val();

        $("#loading-gif").css("display", "block");
        $("#label-module").css("visibility", "hidden");

        $.getJSON("<?=base_url()?>SystemLog/getData", {
            dateFrom : dateFromValue,
            dateTo : dateToValue,
            moduleName : moduleIdValue
        },
        function(data) {
            if (data.textLogs == "") {
                $("#label-module").css("visibility", "visible");
                $("#label-module").text("No Data Found");
                $("#text-log").html("");
            } else {
                $("#text-log").html(data.textLogs);
            }
            $("#loading-gif").css("display", "none");
        });
    }
</script>
