<script language="javascript" type="text/javascript">
    var myjstbl;
    var tab = document.createElement('table');
    tab.id="tableid";
    tab.className = "table table-bordered tbl-design";

    var colarray = [];
	
	var spnid = document.createElement('span');
    colarray['id'] = { 
        header_title: "ID",
        edit: [spnid],
        disp: [spnid],
        td_class: "tablerow tdid tdclick",
        headertd_class : "tdid"
    };

    var spndate = document.createElement('span');
    colarray['date'] = { 
        header_title: "Date",
        edit: [spndate],
        disp: [spndate],
        td_class: "tablerow tddate tdclick",
		headertd_class : "hddate"
    };

    var spnclientgroup = document.createElement('span');
    colarray['clientgroup'] = { 
        header_title: "Client",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "tablerow tdclientgroup tdclick",
		headertd_class : "hdclientgroup"
    };

    var spndrnumber = document.createElement('span');
    colarray['drnumber'] = { 
        header_title: "DR#",
        edit: [spndrnumber],
        disp: [spndrnumber],
        td_class: "tablerow tddrnumber tdclick",
		headertd_class : "hddrnumber"
    };

    var spnamount = document.createElement('span');
    colarray['amount'] = { 
        header_title: "Amount",
        edit: [spnamount],
        disp: [spnamount],
        td_class: "tablerow tdamount tdclick",
		headertd_class : "hdamount"
    };

    var spnstatus = document.createElement('span');
    colarray['status'] = { 
        header_title: "Status",
        edit: [spnstatus],
        disp: [spnstatus],
        td_class: "tablerow tdstatus tdclick",
		headertd_class : "hdstatus"
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
        var date_from_val = $.trim($('#txt_date_from').val());
        var date_to_val = $.trim($('#txt_date_to').val());
        var dr_number_val = $.trim($('#txt_dr_number').val());
        var client_group_val = $('#sel_client_group').val();
        var status_val = $('#sel_status').val();

        $('#lbl_status').css('visibility', 'hidden');
        $("#tbl_list").hide();
        $.getJSON("<?=base_url()?>maintenance_collection_list/get_data",
            { 
                date_from : date_from_val,
                date_to : date_to_val,
                dr_number : dr_number_val,
                client_group : client_group_val,
                status : status_val
            },
            function(data) {
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
	   		var headid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
        	window.open("<?=base_url()?>maintenance_collection?headid="+headid, "_blank");
        });

        $(".imgdel").click(function(){
        	var row_index = $(this).parent().parent().index();
        	var headid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
        	var answer = confirm("Are you sure you want to delete?");
			if(answer==true){
				myjstbl.delete_row(row_index);
				$.get("<?=base_url()?>maintenance_collection_list/delete",
    				{id: headid},
    				function(data){
    					alert("Deleted!");
    				});
			}
        });
    }

</script>