<script language="javascript" type="text/javascript">
    // T.S.L Table
    var myjstbl_tsl;
    var tab_tsl = document.createElement('table');
    tab_tsl.id="tableid_tsl";
    tab_tsl.className = "table table-bordered";
    var clientTerminalTable;
    var colarray_tsl = [];

    var datetime_tsl = document.createElement('span');
    colarray_tsl['datetime_tsl'] = { 
        header_title: "Date Time Reported",
        edit: [datetime_tsl],
        disp: [datetime_tsl],
        td_class: "tablerow tddatetime_tsl",
        headertd_class : "hddatetime_tsl"
    };

    var reportedby_tsl = document.createElement('span');
    colarray_tsl['reportedby_tsl'] = { 
        header_title: "Reported By",
        edit: [reportedby_tsl],
        disp: [reportedby_tsl],
        td_class: "tablerow tdreportedby_tsl",
        headertd_class : "hdreportedby_tsl"
    };

    var assignedto_tsl = document.createElement('span');
    colarray_tsl['assignedto_tsl'] = { 
        header_title: "Assigned to",
        edit: [assignedto_tsl],
        disp: [assignedto_tsl],
        td_class: "tablerow tdreportedby_tsl",
        headertd_class : "hdreportedby_tsl"
    };
    
    var desc_tsl = document.createElement('span');
    colarray_tsl['desc_tsl'] = { 
        header_title: "Summary",
        edit: [desc_tsl],
        disp: [desc_tsl],
        td_class: "tablerow tddesc_tsl",
        headertd_class : "hddesc_tsl"
    };

    var status_tsl = document.createElement('span');
    colarray_tsl['status_tsl'] = { 
        header_title: "Status",
        edit: [status_tsl],
        disp: [status_tsl],
        td_class: "tablerow tdstatus_tsl",
        headertd_class : "hdstatus_tsl"
    };

    $(function() {
    
        company_info();

        // T.S.L
        myjstbl_tsl = new my_table(tab_tsl, colarray_tsl, {ispaging : true,
                                                iscursorchange_when_hover : false});

        var root_tsl = document.getElementById("tbl_tsl");
        root_tsl.appendChild(myjstbl_tsl.tab);
        root_tsl.appendChild(myjstbl_tsl.mypage.pagingtable);

        clientTerminalTable = new optimizedTable("tableid_tsl", {
            rowStart: $("#tableid_tsl_txtpagenumber").val(),
            limit: $("#tableid_tsl_txtfilternumber").val(),
            rowCount: 0
        });

        tsl_refresh_table(0);

        $('#datefrom_tsl').datepicker({dateFormat: 'yy-mm-dd'});
        $('#dateto_tsl').datepicker({dateFormat: 'yy-mm-dd'});
        $('#button-search').click(function() {
            tsl_refresh_table(0);
        });

        $("#filterclientbranch").prop("disabled", true);

        $("#filterclientnetwork").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterclientbranch").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterprojecttype").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterassignedto").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterorderby").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterclientnetwork").change(function(){
            $("#filterclientbranch").prop("disabled", ! ($("#filterclientnetwork").val() > 0));
            refresh_clientdetail_ddl();
        });

        $("#button-toggle").live("click", function() {
            var button = $(this) ;

            if (! button.hasClass("pressed")) {
                button.addClass("pressed");
                button.val("DESC");
            } else {
                button.removeClass("pressed");
                button.val("ASC");
            }
        });
    });

    function refresh_clientdetail_ddl()
    {
        $.get("<?=base_url()?>client_points_info/refresh_clientdetail_ddl_control",
        {
            clientheadid : $("#filterclientnetwork").val(),
            clientgroupid : $("#filterclientgroup").val()
        }
        ,
        function(data){
            document.getElementById("filterclientbranch").innerHTML = data;
            $("#filterclientbranch").trigger("liszt:updated");
        });
    }
    
    function company_info(){
        //var clientid = getUrlVars()["clientid"];
        var clientgroupid_val = getUrlVars()["clientgroupid"];
        $.getJSON("<?=base_url()?>client_points_info/client_header",
            {  //clientid: clientid
			   clientgroupid: clientgroupid_val },
            function(data) { 
                document.getElementById("clientgroup").innerHTML = data[0];
                // document.getElementById("clientnetwork").innerHTML = data[1];
                // if(Number(data[1].toString().replace(/\,/gi,"")) <= 0){
                //     $("#clientrempoints").css('color','red');
                // }
                //document.getElementById("dropbox_type").innerHTML = data[3];
                //document.getElementById("clientdropexpdate").innerHTML = data[4];
                //document.getElementById("clientdropexpdate").innerHTML = "Dropbox Expiration Date: "+data[2];
        });
    }
    
  	function branch_refresh_table() {

        // var clientid = getUrlVars()["clientid"];
        var clientgroupid_val = getUrlVars()["clientgroupid"];
        
        $.getJSON("<?=base_url()?>client_points_info/branch_refresh",
            {  //clientid: clientid
			   clientgroupid: clientgroupid_val },
            function(data) { 
                myjstbl_branch.insert_multiplerow_with_value(1,data);	
                document.getElementById("n_of_branch").innerHTML = data.length;
        });
	}
	
    function enrolleduser_refresh_table() {
        myjstbl_euser.clean_table();
        //var clientid = getUrlVars()["clientid"];
        var clientgroupid_val = getUrlVars()["clientgroupid"];
        $.getJSON("<?=base_url()?>client_points_info/enrolleduser_refresh",
             {  //clientid: clientid
			   clientgroupid: clientgroupid_val },
            function(data) { 
                myjstbl_euser.insert_multiplerow_with_value(1,data);	
                document.getElementById("n_of_contact").innerHTML = data.length;
        });
	}

    function hamachi_refresh_table() {
        myjstbl_hamachi.clean_table();
        // var clientid = getUrlVars()["clientid"];
        var clientgroupid_val = getUrlVars()["clientgroupid"];
        $.getJSON("<?=base_url()?>client_points_info/hamachi_refresh",
           {  //clientid: clientid
               clientgroupid: clientgroupid_val },
            function(data) { 
                myjstbl_hamachi.insert_multiplerow_with_value(1,data);  
                document.getElementById("n_of_hamachi").innerHTML = data.length;
        });
    }
    
	function pul_refresh_table() {
        document.getElementById("lblStatus").innerHTML = "";
        myjstbl_pul.clean_table();

		var clientgroupid_val = getUrlVars()["clientgroupid"];
        var datefrom_val = $('#datefrom_pul').val();
        var dateto_val = $('#dateto_pul').val();
        if ((Date.parse(datefrom_val) >= Date.parse(dateto_val))) {
            document.getElementById("lblStatus").innerHTML = "End date should be greater than Start date!";
            return;
        }
        $.getJSON("<?=base_url()?>client_points_info/pul_refresh",
            { 
                clientgroupid: clientgroupid_val,
                datefrom : datefrom_val,
                dateto : dateto_val
            },
            function(data) { 
                myjstbl_pul.insert_multiplerow_with_value(1,data);
        });
	}

    function tsl_refresh_table(rowStart = 0, rowend = 0)
    {
        let selectedPageNumber = $("#tableid_tsl_txtpagenumber").val();
        let limit = clientTerminalTable.getLimitValue();

        if (rowStart) {
            myjstbl_tsl.clean_table();
        } else {
            myjstbl_tsl.clear_table();
            selectedPageNumber = 1;
        }

        let rowCount = 0;

        document.getElementById("lblStatus_tsl").innerHTML = "";
        myjstbl_tsl.clear_table();

        var clientgroupid_val = getUrlVars()["clientgroupid"];
        var clientheadid_val = $('#filterclientnetwork').val();
        var clientdetailsid_val = $('#filterclientbranch').val();
        var projecttype_val = $('#filterprojecttype').val();
        var assignedto_val = $('#filterassignedto').val();
        var datefrom_val = $('#datefrom_tsl').val();
        var dateto_val = $('#dateto_tsl').val();
        var orderby_val = $("#filterorderby").val();
        var toggle_val = $("#button-toggle").val();

        $.ajax({
            url: "<?=base_url()?>client_points_info/tsl_refresh",
            type: "POST",
            data: {
                clientgroupid: clientgroupid_val,
                clientheadid: clientheadid_val,
                clientdetailsid: clientdetailsid_val,
                projecttype: projecttype_val,
                assignedto: assignedto_val,
                datefrom: datefrom_val,
                dateto: dateto_val,
                orderby: orderby_val,
                toggle: toggle_val,
                filterreset: 1,
                rowstart: rowStart,
                rowend: 0,
                limit: limit
            },
            success: function(data)
            {
                myjstbl_tsl.clear_table();
                myjstbl_tsl.isRefreshFilterPage = false;
                myjstbl_tsl.insert_multiplerow_with_value(1,data.data);

                rowCount = data.rowcnt;

                $("#tableid_tsl_txtpagenumber").val(selectedPageNumber);
                clientTerminalTable.setPageCount(rowCount);
            },
            complete: function()
            {
                clientTerminalTable = new optimizedTable("tableid_tsl", {
                    searchTable: tsl_refresh_table,
                    rowStart: $("#tableid_tsl_txtpagenumber").val(),
                    limit: limit,
                    rowCount: rowCount
                });
            }
        });
    }
    
	function getUrlVars() { // Getting client id in url
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

</script>