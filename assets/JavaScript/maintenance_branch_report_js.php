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

    var spnclientgroupid = document.createElement('span');
    colarray['clientgroupid'] = { 
        header_title: "Group ID",
        edit: [spnclientgroupid],
        disp: [spnclientgroupid],
        td_class: "tablerow tdclientgroupid tdclick",
        headertd_class : "tdclientgroupid"
    };

    var spnclientgroup = document.createElement('span');
    colarray['clientgroup'] = { 
        header_title: "Group",
        edit: [spnclientgroup],
        disp: [spnclientgroup],
        td_class: "tablerow tdclientgroup tdclick",
		headertd_class : "hdclientgroup"
    }; 

    var spnclientnetwork = document.createElement('span');
    colarray['clientnetwork'] = { 
        header_title: "Network",
        edit: [spnclientnetwork],
        disp: [spnclientnetwork],
        td_class: "tablerow tdclientnetwork tdclick",
        headertd_class : "hdclientnetwork"
    };

    var spnclientbranchid = document.createElement('span');
    colarray['clientbranchid'] = { 
        header_title: "Branch ID",
        edit: [spnclientbranchid],
        disp: [spnclientbranchid],
        td_class: "tablerow tdclientbranchid tdclick",
        headertd_class : "hdclientbranchid"
    };

    var spnclientbranch = document.createElement('span');
    colarray['clientbranch'] = { 
        header_title: "Branch",
        edit: [spnclientbranch],
        disp: [spnclientbranch],
        td_class: "tablerow tdclientbranch tdclick",
        headertd_class : "hdclientbranch"
    };

    var market = document.createElement('span');
    market.className = "market";
    colarray['colmarket'] = {
        header_title : "Market",
        edit : [market],
        disp : [market],
        td_class : "tablerow td-market",
        headertd_class : "td-market"
    };

    var spndatestart = document.createElement('span');
    colarray['datestart'] = { 
        header_title: "Date Start",
        edit: [spndatestart],
        disp: [spndatestart],
        td_class: "tablerow tddatestart tdclick",
        headertd_class : "hddatestart"
    };

    var spndatestop = document.createElement('span');
    colarray['datestop'] = { 
        header_title: "Date Stop",
        edit: [spndatestop],
        disp: [spndatestop],
        td_class: "tablerow tddatestop tdclick",
        headertd_class : "hddatestop"
    };

    var spnpaid = document.createElement('span');
    colarray['paid'] = { 
        header_title: "Paid",
        edit: [spnpaid],
        disp: [spnpaid],
        td_class: "tablerow tdpaid tdclick",
        headertd_class : "hdpaid"
    };

    var spnexpiredate = document.createElement('span');
    colarray['expiredate'] = { 
        header_title: "Expired On",
        edit: [spnexpiredate],
        disp: [spnexpiredate],
        td_class: "tablerow tdexpiredate tdclick",
        headertd_class : "hdexpiredate"
    };

    var spnisexpire = document.createElement('span');
    colarray['isexpire'] = { 
        header_title: "Expired?",
        edit: [spnisexpire],
        disp: [spnisexpire],
        td_class: "tablerow tdisexpire tdclick",
        headertd_class : "hdisexpire"
    };

    var spnstillused = document.createElement('span');
    colarray['stillused'] = { 
        header_title: "Still Used",
        edit: [spnstillused],
        disp: [spnstillused],
        td_class: "tablerow tdisstillused tdclick",
        headertd_class : "hdstillused"
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

        $('#txt_expire_on_date').datepicker({dateFormat: 'yy-mm-dd'}).datepicker("setDate", new Date());
        $("#sel_client_group").chosen({
            no_results_text: "Not found",
            add_item_enable: false});

        $("#btn_search").click(function(){
            refresh_tbl();
        });

        $('#tbl_list').hide();
    });

    function refresh_tbl() {
        myjstbl.clean_table();
        var date_expire_on_val = $.trim($('#txt_expire_on_date').val());
        var client_group_val = $('#sel_client_group').val();
        var status_val = $('#sel_status').val();
        var marketValue = $('#market-select').val();

        $('#lbl_status').css('visibility', 'hidden');
        $('#tbl_list').hide();
        $.getJSON("<?=base_url()?>maintenance_branch_report/get_data",
            { 
                date_expire_on : date_expire_on_val,
                client_group : client_group_val,
                status : status_val,
                market : marketValue
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
	   		var detailid = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
        	window.open("<?=base_url()?>maintenance_branch_detail_report?client_branch="+detailid, "_blank");
        });
    }

</script>