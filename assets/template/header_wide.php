<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets\css\font-awesome-4.7.0\css\font-awesome.min.css" />
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
<div id="wrapwide">
<div class="headerwide">
    <div class="logo">
        <a href="controlpanel">
            <img src = "<?= base_url(); ?>assets/images/logo.png" alt="" ></img>
        </a>
        <div id="version" style="float:left; margin-top:95px; font-weight:bold; color:#39F; margin-left:5px;" >
        </div> 
        <!-- <div style="float:left; margin-top:95px; font-weight:bold; color:#39F; margin-left:5px;" >
            <?php echo GET_VERSIONNO; ?></div> -->
    </div>
    <div id="menuwide">
        <ul>                                                                       
            <li><a href="<?= base_url(); ?>login"><?php echo $this->lang->line('lbldisp_logout'); ?></a></li>
            <li><a href="<?= base_url(); ?>controlpanel"><?php echo $this->lang->line('lbldisp_controlpanel'); ?></a></li>
            <!-- <li><a href="<?= base_url(); ?>acctsettings"><?php echo $this->lang->line('lbldisp_formheaders_accountsettings'); ?></a></li>
            <li><a href="<?= base_url(); ?>contactus"><?php echo $this->lang->line('lbldisp_formheaders_contactus'); ?></a></li> -->
            <?php if($_SESSION['position_id'] == 4): ?>
            
            <div class="badge1 count_unclicked_notifs" data-badge="" ></div> 
             
            <li class="notif"><i class="fa fa-envelope show_notifs" style="color:#37728e;"></i> <i class="fa fa-caret-down dropbtn show_notifs"></i>
                <div id="dropdown-content" class="dropdown-content" style="display:none">
                    <ul></ul>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </div>      
</div> 
<div class="center_contentwide">
<div class="full_contentwide">
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


    $('.show_notifs').click(function () {
        $.ajax(
                {
                    type:"post",
                    url: "<?php echo base_url(); ?>clientgroup/select_notif",
                    success:function(datas)
                    {   if(document.getElementById('dropdown-content').style.display == 'none')
                        {
                            document.getElementById('dropdown-content').style.display = 'block';
                        }
                        else
                        {
                            document.getElementById('dropdown-content').style.display = 'none';
                        }
                        let result = JSON.parse(datas);
                        $.each(result, function(key, value){
                            if(value.comment_status == 0)
                            {
                                 $('div.dropdown-content ul').append('<li class="' + value.id + '" style="background-color: #c2dfff;">You have been assigned to support <b>' + value.name + '</b>.</li>');
                            }
                            else
                            {
                                 $('div.dropdown-content ul').append('<li class="' + value.id +'">You have been assigned to support <b>' + value.name + '</b>.</li>');
                            }


                        });
                    },
                    error: function() 
                    {
                        alert("Invalid!");
                    }
                    
                }
            );

        $('.dropdown-content ul').slideDown(function(){
            $('.dropdown-content ul').show();
        });     
    });
  
    $('.notif').click(function() {
        $('div.dropdown-content ul').empty();
        //$('.dropdown-content ul').hide();
    });

    $('div.dropdown-content ul').on('click', 'li', function(){
        let id = $(this).closest('li').attr('class');
        let li = $(this).closest('li');
        // console.log(id);
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>clientgroup/update_comment_status/" + id,
            success: function(result) {
                document.getElementById('dropdown-content').style.display = 'none';
                li.css({'background-color': 'white'});
                result = JSON.parse(result);
            },

            error: function() {
                alert('error!');
            }

        });
    });

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

    /*$(function count() {
        $.ajax(
                {
                    type:"post",
                    url: "<?php echo base_url(); ?>clientgroup/count_unclicked_notifs",
                    
                    success:function(query)
                    {
                        let result = JSON.parse(query);
                            if(result[0].count >= 0)
                            {   
                                var unread_count = result[0].count;
                                document.documentElement.style.setProperty(`--count`, `'${unread_count}'`); 
                            }
                    },
                    complete: function() 
                    {
                        setTimeout(count, 5000);
                    }
                }
            );
    });*/
</script>