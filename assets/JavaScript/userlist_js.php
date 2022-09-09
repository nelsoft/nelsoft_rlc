<script language="javascript" type="text/javascript">
    var myjstbl;
    var tab = document.createElement('table');
    tab.id="tableid";
    tab.className = "table table-bordered tbl-design";

    var colarray = [];
    
    var spnid = document.createElement('span');
    colarray['row'] = { 
        header_title: "",
        edit: [spnid],
        disp: [spnid],
        td_class: "tablerow tdid tdclick",
        headertd_class : "tdid"
    };

    var spnid = document.createElement('span');
    colarray['id'] = { 
        header_title: "ID",
        edit: [spnid],
        disp: [spnid],
        td_class: "hidden",
        headertd_class : "hidden"
    };

    var spnclientgroup = document.createElement('span');
    colarray['clientgroup'] = { 
        header_title: "User Name",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "tablerow tdclientgroup tdclick",
        headertd_class : "hdclientgroup"
    };

    var spnfull_name = document.createElement('span');
    colarray['full_name'] = { 
        header_title: "Full Name",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "tablerow tdclientgroup tdclick",
        headertd_class : "hdclientgroup"
    };

    var spnposition = document.createElement('span');
    colarray['position'] = { 
        header_title: "Position",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "tablerow tdclientgroup tdclick",
        headertd_class : "hdclientgroup"
    };

    var spnposition_id = document.createElement('span');
    colarray['position_id'] = { 
        header_title: "",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "hidden",
        headertd_class : "hidden"
    };

    var spnstatus = document.createElement('span');
    colarray['status'] = { 
        header_title: "Status",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "tablerow tdclientgroup tdclick",
        headertd_class : "hdclientgroup"
    };
    
    //delete
    var imgDelete = document.createElement('img');
    imgDelete.src = "assets/images/icondelete.png";
    imgDelete.setAttribute("class","imgdel");
    imgDelete.setAttribute("id","imgDelete");
    colarray['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };

    var arr = [];
    var headid = "";
    $(function() {
        myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow",
                                                iscursorchange_when_hover : true});

        var root = document.getElementById("tbl_list");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);

        $('#txt_date_from').datepicker({dateFormat: 'yy-mm-dd'}).datepicker("setDate", new Date());
        $('#txt_date_to').datepicker({dateFormat: 'yy-mm-dd'}).datepicker("setDate", new Date());
        $("#sel_client_group").chosen({
            no_results_text: "Not found",
            add_item_enable: false});

        $("#btn_search").click(function(){
            refresh_tbl();
        });

        refresh_tbl();


    });

    function refresh_tbl() {
        myjstbl.clean_table();
    
        var username_filter = $.trim($('#user_filter').val());
        var status_filter = $('#status_filter').val();

        $('#lbl_status').css('visibility', 'hidden');
        $("#tbl_list").hide();
        $.getJSON("<?=base_url()?>userlist/get_data",
            { 
                username : username_filter,
                status : status_filter
            },
            function(data) {
                console.log(data);
                if(data.list_data.length <= 0) {
                    $('#lbl_status').css('visibility', 'visible'); 
                    $('#lbl_status').text("No Data Found");
                }
                else {
                    $("#tbl_list").show();
                    myjstbl.insert_multiplerow_with_value(1,data.list_data);
                    refresh_td_click_event();   
                }
            });
    }

    function refresh_td_click_event(){
        $(".tdclick").click(function(){
            var row_index = $(this).parent().index();
            var userid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
            window.location = "<?=base_url()?>user?userid="+userid;
            $.getJSON("<?=base_url()?>user/view",
                {id: userid},
                function(data){                    
                    $("#full_name").val(data.full_name);
                    $("#username").val(data.username);
                    $("#status").val(data.status);
                    $("#userid").val(data.userid);
                    $("#position").val(data.position);


            });
        });

        $(".imgdel").click(function(){
            var row_index = $(this).parent().parent().index();
            var userid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
            var position_id = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['position_id'].td_class)[0];
            if (position_id != 1){
                var answer = confirm("Are you sure you want to delete?");
                if(answer==true){
                    myjstbl.delete_row(row_index);
                    $.get("<?=base_url()?>userlist/delete",
                        {id: userid},
                        function(data){
                            alert("Deleted!");
                            location.reload();
                        });
                }
            }else{
                alert("Can't delete admin");
            }
            
        });
    }

</script>