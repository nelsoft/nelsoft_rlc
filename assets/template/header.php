<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
    #submitForm {
        cursor: pointer;
    }

    #submitForm {
        color: #d81e7a;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<body>
<div id="wrap">
<div class="header">
    <div class="logo">
        <a>
            <img src = "<?= base_url(); ?>assets/images/logo.png" alt="" ></img>
        </a>
        <div id="version" style="float:left; margin-top:95px; font-weight:bold; color:#39F; margin-left:5px;" >
        </div> 
            <!-- <?php echo GET_VERSIONNO ?> -->
    </div>
    <div id="menu">
        <ul>                                                                       
            <li><a href="<?= base_url(); ?>login"><?php echo $this->lang->line('lbldisp_logout'); ?></a></li>
            <li><a href="<?= base_url(); ?>controlpanel"><?php echo $this->lang->line('lbldisp_controlpanel'); ?></a></li>
            <!-- <li><a href="<?= base_url(); ?>acctsettings"><?php echo $this->lang->line('lbldisp_formheaders_accountsettings'); ?></a></li>
            <li><a href="<?= base_url(); ?>contactus"><?php echo $this->lang->line('lbldisp_formheaders_contactus'); ?></a></li> -->
        </ul>
    </div>      
</div> 
<div class="center_content">
<div class="full_content">
<form id="jsform" target="_blank" method='post' action='<?= base_url(); ?>changelog'>
    <input type="hidden" name="logType" value="1">
</form>
<script type="text/javascript">
    /**
    * to submit the log type value
    */
    function submit()
    {
        document.getElementById('jsform').submit();
    }
</script>
<script type="text/javascript">
    $(function(){
        getLatestVersion();

        /**
        * to get the latest version on the change logs of Clientbase
        */
        function getLatestVersion()
        {
            $.ajax(
            {
                url: "changelog/getDetails",
                type: "GET",
                data: {
                    function : "getLatestVersion",
                    rowPerRequest : 0,
                    currentRow : 0,
                    getSystem: $("[name='logType']").val()
                },
                dataType: "json",
                success: function(result)
                {

                    row = "<a id='submitForm' onclick='submit()' target='_blank'><span>Version: ";
                    for (var i = 0; i < result.length; i++) {
                        if ((i+1) != result.length) {
                            row += result[i] + '.';
                        } else {
                            row += result[i];
                        }
                    }
                    row += "</span></a>";

                    $("#version").append(row);
                }
            });
        }
    });
</script>
