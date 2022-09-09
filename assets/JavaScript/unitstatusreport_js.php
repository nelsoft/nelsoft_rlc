<script language="javascript" type="text/javascript">
    var statusImages = ["red_status.png", "green_status.png"];

    <?php 
        $terminalid = isset($_GET['terminalid']) ? $_GET['terminalid'] : 0;
    ?>

    var myjstbl;
    var tab = document.createElement('table');
    tab.id="tableid";
    var colarray = [];

    var isFirstLoad = true;
    
    var spncount = document.createElement('span');
    colarray['count'] = { 
        header_title: " ",
        edit: [spncount],
        disp: [spncount],
        td_class: "tablerow tdsmall td-hide",
        headertd_class : "tdsmall td-hide"
    };

    var imageStatus = document.createElement('span');
    imageStatus.setAttribute("id", "image-status");
    imageStatus.style.cursor = "pointer";
    colarray['columnImageStatus'] = {
        header_title: "",
        edit: [imageStatus],
        disp: [imageStatus],
        td_class: "tablerow td-image-status"
    };

    var spnwid = document.createElement('span');
    spnwid.className = "spnwid";
    spnwid.innerHTML = "0";
    colarray['colwid'] = { 
        header_title: "ID",
        edit: [spnwid],
        disp: [spnwid],
        td_class: "tablerow tdwid text-bold",
        headertd_class : "tdwid text-bold"
    };

    var spanClientBranchId = document.createElement('span');
    colarray['columnBranchId'] = {
        header_title: "Client Head / Branch ID / Client Detail",
        edit: [spanClientBranchId],
        disp: [spanClientBranchId],
        td_class: "tablerow td-branch-id",
        headertd_class : "td-branch-id"
    };

    var spnreferenceno = document.createElement('span');
    spnreferenceno.className = "spnreferenceno";
    spnreferenceno.setAttribute("style", "text-decoration: underline;");
    colarray['colReferenceno'] = { 
        header_title: "Reference #",
        edit: [spnreferenceno],
        disp: [spnreferenceno],
        td_class: "tablerow tdall tdReferenceno"
    };

    var spnaveramusage = document.createElement('span');
    spnaveramusage.className = "spnaveramusage";
    colarray['colAveRamUsage'] = { 
        header_title: "Average Ram Usage (%)",
        edit: [spnaveramusage],
        disp: [spnaveramusage],
        td_class: "tablerow tdall tdAveRamUsage"
    };

    var spnavecpuusage = document.createElement('span');
    spnavecpuusage.className = "spnavecpuusage";
    colarray['colAveCpuUsage'] = { 
        header_title: "Average CPU Usage (%)",
        edit: [spnavecpuusage],
        disp: [spnavecpuusage],
        td_class: "tablerow tdall tdAveCpuUsage"
    };

    var spntotalspace = document.createElement('span');
    spntotalspace.className = "spntotalspace";
    colarray['colTotalSpace'] = { 
        header_title: "Total Space",
        edit: [spntotalspace],
        disp: [spntotalspace],
        td_class: "tablerow tdall tdTotalSpace"
    };

    var spnfreespace = document.createElement('span');
    spnfreespace.className = "spnfreespace";
    colarray['colFreeSpace'] = { 
        header_title: "Free Space",
        edit: [spnfreespace],
        disp: [spnfreespace],
        td_class: "tablerow tdall tdFreeSpace"
    };

    var spnusedspace = document.createElement('span');
    spnusedspace.className = "spnusedspace";
    colarray['colUsedSpace'] = { 
        header_title: "Used Space",
        edit: [spnusedspace],
        disp: [spnusedspace],
        td_class: "tablerow tdall tdUsedSpace"
    };
        
    $(function(){
   
        myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow",
                                                tdpopup_when_hover : "tdpopuphover",
                                                iscursorchange_when_hover : true});
        var root = document.getElementById("tbl");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);
        
        clientTerminalTable = new optimizedTable("tableid", {
            rowStart: $("#tableid_txtpagenumber").val(),
            limit: $("#tableid_txtfilternumber").val(),
            rowCount: 0
        });
        
        $('#btnsearch').live('click', function()
        {
            refreshTable(0);
        });

        var terminalsearch = (<?=$terminalid?>);

        if (terminalsearch > 0){
            search_table_tid(terminalsearch);
        }
                
        $("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclienthead").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclient").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterterminal").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filtertype").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterver").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filter-client-status").chosen({
            allow_single_deselect: true,
            no_results_text: "Not found",
            add_item_enable: false
        });
        $("#filter-client-order").chosen({
            allow_single_deselect: true,
            no_results_text: "Not found",
            add_item_enable: false
        });

        $("#filterclientgroup").change(function(){
            $("#filterclienthead").prop("disabled", ! ($("#filterclientgroup").val() > 0));
            refresh_clienthead_ddl();
            refresh_clientdetail_ddl();
            refresh_terminal_ddl();
            $("#filterclient").prop("disabled", ! ($("#filterclientgroup").val() > 0));
        });
        $("#filterclienthead").change(function(){
            $("#filterclient").prop("disabled", ! ($("#filterclienthead").val() > 0));
            refresh_clientdetail_ddl();
            refresh_terminal_ddl();
        });
        $('#filterclient').change(function(){
            refresh_terminal_ddl();
        });
        $('#filtertype').change(function(){
            refresh_terminal_ddl();
        });
        $('#detailgroup').modal("hide");

        if($('#filterclient').val() > 0)
        {
            refresh_client();
        }
        else if($('#filterclienthead').val() > 0)
        {
            refresh_clientdetail_ddl();
        }
        else if($('#filterclientgroup').val() > 0)
        {
            refresh_clienthead_ddl();
        }

        showInitialPageLoadDisplay(myjstbl);

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


    function set_tbl_element_events()
    {        
        my_autocomplete_add(".txtclientinfo", "<?=base_url()?>unitstatusreport/ac_clientinfo", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                var clientid_val = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray["clientid"].td_class);
                var cliendIdCopy = myjstbl.getvalue_by_rowindex_tdclass(
                    row_index,
                    colarray["columnClientIdCopy"].td_class
                );
                if(error.length > 0){
                    if(clientid_val == ''){
                        
                        myjstbl.setvalue_to_rowindex_tdclass(["0"],row_index,colarray['clientid'].td_class);
                        myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['colclientinfo'].td_class);
                        myjstbl.setvalue_to_rowindex_tdclass([""], row_index, colarray['columnBranchId'].td_class);
                }
                } else {
                    if (cliendIdCopy == "") {
                        myjstbl.setvalue_to_rowindex_tdclass([value], row_index, colarray['clientid'].td_class);
                    } else {
                        myjstbl.setvalue_to_rowindex_tdclass([clientid_val], row_index, colarray['clientid'].td_class);
                    }
                    myjstbl.setvalue_to_rowindex_tdclass([label],row_index,colarray['colclientinfo'].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass(
                        [ret_datas[2]],
                        row_index,
                        colarray['columnBranchId'].td_class
                    );
                        return;
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [ 1], 
                    { width : ["400px"] });
            }
        });
    }   
    
    function refresh_clienthead_ddl()
    {
        $.get("<?=base_url()?>unitstatusreport/refresh_clienthead_ddl_control",
        {
            clientgroupid : $("#filterclientgroup").val()
        }
        ,
        function(data){
            document.getElementById("filterclienthead").innerHTML = data;
            $("#filterclienthead").trigger("liszt:updated");
        });
    }
    
    function refresh_clientdetail_ddl()
    {
        $.get("<?=base_url()?>unitstatusreport/refresh_clientdetail_ddl_control",
        {
            clientheadid : $("#filterclienthead").val()
        }
        ,
        function(data){
            document.getElementById("filterclient").innerHTML = data;
            $("#filterclient").trigger("liszt:updated");
        });
    }

    function refresh_terminal_ddl()
    {
        $.get("<?=base_url()?>unitstatusreport/refresh_terminalno_control",
        {
            clientgroupid : $("#filterclientgroup").val(),
            clientheadid  : $("#filterclienthead").val(),
            clientbranch  : $("#filterclient").val(),
            postype       : $('#filtertype').val()
        }
        ,
        function(data){
            document.getElementById("filterterminal").innerHTML = data;
            $("#filterterminal").trigger("liszt:updated");
        });
    }

    function refreshTable(rowStart = 0, isNewData = false)
    {
        let selectedPageNumber = $("#tableid_txtpagenumber").val();
        let limit = clientTerminalTable.getLimitValue();

        if (rowStart) {
            myjstbl.clean_table();
        } else {
            myjstbl.clear_table();
            selectedPageNumber = 1;
        }

        let filterreset_val = 1;
        let rowCount = 0;
        $.ajax({
            url: "<?=base_url()?>unitstatusreport/search_control",
            type: "POST",
            data: {
                clientgroup_mdl: $('#filterclientgroup').val(),
                clienthead_mdl:  $('#filterclienthead').val(),
                client_mdl:      $('#filterclient').val(),
                type_mdl:        $('#filtertype').val(),
                terminal_mdl:    $('#filterterminal').val(),
                status:          $("#filter-client-status").val(),
                order:           $("#filter-client-order").val(),
                buttonToggle:    $("#button-toggle").val(),
                filterreset:     1,
                rowstart:        rowStart,
                rowend:          0,
                limit:           limit
            },
            success: function(data)
            {
                set_tbl_element_events();
                myjstbl.clear_table();
                myjstbl.isRefreshFilterPage = false;
                myjstbl.insert_multiplerow_with_value(1, data.data);

                rowCount = data.rowcnt;

                $("#tableid_txtpagenumber").val(selectedPageNumber);
                clientTerminalTable.setPageCount(rowCount);
                isFirstLoad = false;
            },
            complete: function()
            {
                $("#spanloading").remove();
                clientTerminalTable = new optimizedTable("tableid", {
                    searchTable: refreshTable,
                    rowStart: $("#tableid_txtpagenumber").val(),
                    limit: limit,
                    rowCount: rowCount
                });
            }
        });
    }

    function search_table_tid(tid)
    {
        if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')){
            myjstbl.clear_table();
        }
        else
        {
            myjstbl.clean_table();
        }
        
        var filterreset_val = (typeof rowstart === 'undefined')?1:0;
        var row_start_val = (typeof rowstart === 'undefined' || rowstart < 0)?0:rowstart;
        var row_end_val = (typeof rowend === 'undefined')?(myjstbl.mypage.mysql_interval-1):rowend;        
       
        $.ajax(
        {
            url: "<?=base_url()?>unitstatusreport/search_by_tid",
            type: "POST",
            data: { 
                    terminalid : tid
                },
            async: true,

            success: function(data)
            {
                set_tbl_element_events();
                myjstbl.clean_table();
                
                if(filterreset_val == 1)
                {        
                    var rowcnt = data.rowcnt;
                    if(rowcnt == 0 ){
                        myjstbl.mypage.set_last_page(0);
                    }
                    else{
                        myjstbl.mypage.set_last_page( Math.ceil(Number(rowcnt) / Number(myjstbl.mypage.filter_number)));
                    }
                }

                myjstbl.insert_multiplerow_with_value(1, data.data); 
                isFirstLoad = false;
            },
            complete: function()
            {
                $("#spanloading").remove();
                clientTerminalTable = new optimizedTable("tableid", {
                    rowStart: 1,
                    limit: 1,
                });
            }
        });
    }
    
    function search_table(rowstart, rowend)
    {          
        if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')){
            myjstbl.clear_table();
        }
        else
        {
            myjstbl.clean_table();
        }
        
        var filterreset_val = (typeof rowstart === 'undefined')?1:0;
        var row_start_val = (typeof rowstart === 'undefined' || rowstart < 0)?0:rowstart;
        var row_end_val = (typeof rowend === 'undefined')?(myjstbl.mypage.mysql_interval-1):rowend;        
       
        $.ajax(
        {
            url: "<?=base_url()?>unitstatusreport/search_control",
            type: "POST",
            data: { 
                    clientgroup_mdl : $('#filterclientgroup').val(),
                    clienthead_mdl : $('#filterclienthead').val(),
                    client_mdl : $('#filterclient').val(),
                    type_mdl : $('#filtertype').val(),
                    ver_mdl : $('#filterver').val(),
                    clientStatus: $("#filter-client-status").val(),
                    clientOrder: $("#filter-client-order").val(),
                    buttonToggle: $("#button-toggle").val(),
                    filterreset: filterreset_val,
                    rowstart: row_start_val,
                    rowend: row_end_val
                },
            async: true,

            success: function(data)
            {
                set_tbl_element_events();
                if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined'))
                {
                    myjstbl.clear_table();
                }
                else
                {
                    myjstbl.clean_table();
                }
                
                if(filterreset_val == 1)
                {        
                    var rowcnt = data.rowcnt;
                    if(rowcnt == 0 ){
                        myjstbl.mypage.set_last_page(0);
                    }
                    else{
                        myjstbl.mypage.set_last_page( Math.ceil(Number(rowcnt) / Number(myjstbl.mypage.filter_number)));
                    }
                }
                
                if($("#showhide").val() == "Show Advance Details")
                {
                    $(".tdpermitno").hide();
                    $(".tdmachineno").hide();
                    $(".tdserialno").hide();
                    $(".tdposstatus").hide();
                }
                isFirstLoad = false;
            },
            complete: function()
            {
                $("#spanloading").remove();
                clientTerminalTable = new optimizedTable("tableid", {});
            }            
        });
    }

</script>

