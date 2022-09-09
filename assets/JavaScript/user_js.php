<script language="javascript" type="text/javascript">

    $(function() {

        <?php if (isset($_GET['userid'])) { ?>
            var userId = <?php echo $_GET['userid']; ?>;

            if (userId != 200 && userId != 201){
                $("#tbl_view").find("input, button, textarea, select").attr("disabled", "disabled");
                $.getJSON("<?=base_url()?>user/view",
                {
                    id: userId
                },
                function(data)
                {
                    <?php
                        $isAdminPosition = $_SESSION['position_id'] == 8 ? 1:0;
                        $isSupervisor = $_SESSION['position_id'] == 9 ? 1:0;
                        $isRegularPosition =
                            ($_GET['userid'] != $_SESSION['id'])
                            && (
                                $_SESSION['position_id'] == 2
                                || $_SESSION['position_id'] == 3
                                || $_SESSION['position_id'] == 4
                                || $_SESSION['position_id'] == 5
                                || $_SESSION['position_id'] == 6
                            )
                            ? 1:0;
                    ?>
                    if ((data.position == 7 && <?php echo $isAdminPosition; ?>) || (data.position == 7 && <?php echo $isSupervisor; ?>) || (data.position == 8 && <?php echo $isSupervisor; ?>) || (<?php echo $isRegularPosition; ?>)) {
                        window.location = "login";
                        return;
                    }

                    $("#full_name").val(data.full_name);
                    $("#username").val(data.username);
                    $("#status").val(data.status);
                    $("#userid").val(data.userid);
                    $("#position").val(data.position);
                    if (data.position != 1) {
                        $("#tbl_view").find("input,button,textarea,select").removeAttr("disabled");
                        $("#position").find("option").eq(0).remove();
                    }
                });
            } else {
                alert('Unable to edit this user');
                window.location = "userlist";
                return;
            }
        <?php } ?>

        $("#save_btn").click(function(){
            var full_name_val = $('#full_name').val();
            var username_val = $('#username').val();
            var password_val = $('#password').val();
            var status_val = $('#status').val();
            var userid_val = $('#userid').val();
            var position_val = $('#position').val();

            if (username_val == '' || (userid_val == '' && password_val == '')){
                alert('Username/Password is empty.');
                return false;
            }

            if (! username_val.trim() || ! password_val.trim()) {
                alert("Whitespaces are not allowed, Please input valid value for username and password");
                return false;
            }
        
            $.getJSON("<?=base_url()?>user/save",
                {
                    full_name : full_name_val,
                    username: username_val,
                    password : password_val,
                    status : status_val,
                    userid : userid_val,
                    position : position_val 
                },
                function(data){
                    alert(data.message);
                    if (data.validate == 'true'){
                        window.location = "<?=base_url()?>userlist";
                    }
                });
            
        });


    });

    // function refresh_tbl() {
    //     myjstbl.clean_table();
    
    //     var username_filter = $.trim($('#user_filter').val());
    //     var status_filter = $('#status_filter').val();

    //     $('#lbl_status').css('visibility', 'hidden');
    //     $("#tbl_list").hide();
    //     $.getJSON("<?=base_url()?>user/get_data",
    //         { 
    //             username : username_filter,
    //             status : status_filter
    //         },
    //         function(data) {
    //             if(data.list_data.length <= 0) {
    //                 $('#lbl_status').css('visibility', 'visible'); 
    //                 $('#lbl_status').text("No Data Found");
    //             }
    //             else {
    //                 $("#tbl_list").show();
    //                 myjstbl.insert_multiplerow_with_value(1,data.list_data);
    //                 refresh_td_click_event();   
    //             }
    //         });
    // }

    function refresh_td_click_event(){
        // $(".tdclick").click(function(){
        //     var row_index = $(this).parent().index();
        //     var userid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
        //     $.getJSON("<?=base_url()?>user/view",
        //         {id: userid},
        //         function(data){
        //         console.log(data)
        //             $("#list").hide();
        //             $("#view").show();
        //             $("#full_name").val(data.full_name);
        //             $("#username").val(data.username);
        //             $("#status").val(data.status);
        //             $("#userid").val(data.userid);
        //             $("#position").val(data.position);


        //     });
        // });

        // $(".imgdel").click(function(){
        //     var row_index = $(this).parent().parent().index();
        //     var userid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
        //     var answer = confirm("Are you sure you want to delete?");
        //     if(answer==true){
        //         myjstbl.delete_row(row_index);
        //         $.get("<?=base_url()?>user/delete",
        //             {id: userid},
        //             function(data){
        //                 alert("Deleted!");
        //                 location.reload();
        //             });
        //     }
        // });

        
    }

</script>