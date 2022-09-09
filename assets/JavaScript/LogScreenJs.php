<script language="javascript" type="text/javascript">
    var moduleName = $("#log-screen-field").val();

    $(function() {
        updateLogScreen();
    });

    /**
     * Function to update the logs on the lower part of the module
     */
    function updateLogScreen()
    {
        $.ajax(
        {
            url: "<?=base_url()?>LogScreen/getLog",
            type: "GET",
            data: {
                moduleName : moduleName
            },
            async: true,
            dataType: 'html',
            success: function(data)
            {
                $("#log-screen").html(data);
            }
        });
    }
</script>
