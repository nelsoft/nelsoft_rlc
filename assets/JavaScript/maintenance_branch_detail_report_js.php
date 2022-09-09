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

    var spndr_number = document.createElement('span');
    colarray['dr_number'] = { 
        header_title: "DR#",
        edit: [spndr_number],
        disp: [spndr_number],
        td_class: "tablerow tddr_number tdclick",
        headertd_class : "hddr_number"
    }; 

    var spnquantity = document.createElement('span');
    colarray['quantity'] = { 
        header_title: "Months",
        edit: [spnquantity],
        disp: [spnquantity],
        td_class: "tablerow tdquantity tdclick",
        headertd_class : "hdquantity"
    }; 

    var spnprice = document.createElement('span');
    colarray['price'] = { 
        header_title: "Price",
        edit: [spnprice],
        disp: [spnprice],
        td_class: "tablerow tdprice tdclick",
        headertd_class : "hdprice"
    }; 

    var spnamount = document.createElement('span');
    colarray['amount'] = { 
        header_title: "Amount",
        edit: [spnamount],
        disp: [spnamount],
        td_class: "tablerow tdamount tdclick",
        headertd_class : "hdamount"
    }; 

    var spncollectionheadid = document.createElement('span');
    colarray['collectionheadid'] = { 
        header_title: "",
        edit: [spncollectionheadid],
        disp: [spncollectionheadid],
        td_class: "tablerow tdcollectionheadid",
        headertd_class : "hdcollectionheadid"
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

        $("#sel_client_branch").chosen({
            no_results_text: "Not found",
            add_item_enable: false});
        $("#sel_client_branch").val(<?php echo $client_branch; ?>);
        $("#sel_client_branch").trigger("liszt:updated");

        $("#btn_search").click(function(){
            refresh_tbl();
        });

        refresh_tbl();
    });

    function refresh_tbl() {
        myjstbl.clean_table();
        var client_branch_val = $('#sel_client_branch').val();

        $('#lbl_status').css('visibility', 'hidden');
        $('#tbl_list').hide();
        $.getJSON("<?=base_url()?>maintenance_branch_detail_report/get_data",
            { 
                client_branch : client_branch_val
            },
            function(data) {
                if(data.list_data.length <= 0) {
                    $('#lbl_status').css('visibility', 'visible'); 
                    $('#lbl_status').text("No Data Found");    
                }
                else {
                    $('#tbl_list').show();
                    myjstbl.insert_multiplerow_with_value(1,data.list_data);
                    refresh_td_click_event();   
                }
            });
    }

    function refresh_td_click_event(){
    	$(".tdclick").click(function(){
        	var row_index = $(this).parent().index();
	   		var headid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['collectionheadid'].td_class)[0];
        	window.open("<?=base_url()?>maintenance_collection?headid="+headid, "_blank");
        });
    }

</script>