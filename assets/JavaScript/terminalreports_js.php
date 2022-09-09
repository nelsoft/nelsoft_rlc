    <script language="javascript" type="text/javascript">
    var terminalList = [];
    var currentTerminalId = "";
    var clientTerminalTable;
    var terminalRow = [];
    var terminalType = [];
    var isNewRowData = false;
    var isSavePtuDetails = false;

    <?php 
        $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
        $clientheadid = isset($_GET['clientheadid'])?$_GET['clientheadid']:"";
        $clientdetailid= isset($_GET['clientdetailid'])?$_GET['clientdetailid']:"";
        $clientterminalid= isset($_GET['clientterminalid'])?$_GET['clientterminalid']:"0";
        $clientStatus = isset($_GET['status']) ? $_GET['status'] : "";
        $isManagementPosition = $_SESSION["position_id"] == 7;
        $clientOrder = isset($_GET['order']) ? $_GET['order'] : "";
        $toggle = isset($_GET['toggle']) ? $_GET['toggle'] : "";
        $PositionId = $_SESSION["position_id"];
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
        td_class: "tablerow tdsmall",
        headertd_class : "tdsmall"
    };

    var spnwid = document.createElement('span');
    spnwid.className = "spnwid";
    spnwid.innerHTML = "0";
    colarray['colwid'] = { 
        header_title: " ",
        edit: [spnwid],
        disp: [spnwid],
        td_class: "tablerow tdwid",
        headertd_class : "tdwid"
    };

    var spanClientBranchId = document.createElement('span');
    colarray['columnBranchId'] = {
        header_title: "",
        edit: [spanClientBranchId],
        disp: [spanClientBranchId],
        td_class: "tablerow td-branch-id td-hide",
        headertd_class : "td-branch-id td-hide"
    };

    var spanClientIdCopy = document.createElement('span');
    colarray['columnClientIdCopy'] = {
        header_title: "",
        edit: [spanClientIdCopy],
        disp: [spanClientIdCopy],
        td_class: "tablerow td-client-id-copy td-hide",
        headertd_class : "td-client-id-copy td-hide"
    };

    var imageAWSStatus = document.createElement('span');
    imageAWSStatus.setAttribute("class", "image-autosync-status");
    var editImageAWSStatus = document.createElement('span');
    editImageAWSStatus.setAttribute("class", "image-autosync-status");
    editImageAWSStatus.innerHTML = "\
        <center>\
            <img src='assets/images/warning.png' style='height: 20px; width: 20px;' status='No AWS backup'>\
        </center>\
    ";
    colarray['columnAWSStatus'] = {
        header_title: "",
        edit: [editImageAWSStatus],
        disp: [imageAWSStatus],
        td_class: "tablerow td-AWS-Status tdclickmain"
    };

    var txtclientid = document.createElement('input');
    txtclientid.className = "txtclientid";
    var txtclientid_disp = document.createElement('span');
    txtclientid_disp.disabled = "disabled";
    colarray['clientid'] = { 
        header_title: "ID",
        edit: [txtclientid_disp], 
        disp: [txtclientid_disp], 
        td_class: "tablerow tdtxtclientid text-bold",
        headertd_class : "td-client-id-copy td-hide"
    };

    var spnclientinfo = document.createElement('span');
    spnclientinfo.className = "spnclientinfo";
    colarray['colclientinfo'] = { 
        header_title: "Client Head / Branch ID / Client Detail",
        edit: [spnclientinfo],
        disp: [spnclientinfo],
        td_class: "tablerow tdlong tdclick tdclientinfo",
        headertd_class : "td-client-id-copy td-hide"
    };

    var spanClientGroup = document.createElement('span');
    var textClientGroup = document.createElement('input');
    textClientGroup.type = "text";
    textClientGroup.id = 'idClientGroup';
    textClientGroup.className = 'textClientGroup';
    colarray['columnClientGroup'] = {
        header_title: "Client Group",
        edit: [textClientGroup],
        disp: [spanClientGroup],
        td_class: "tablerow tdClientGroup td-center tdclickmain",
        headertd_class : "hdClientGroup"
    };

    var spanClientNetwork = document.createElement('span');
    var textClientNetwork = document.createElement('input');
    textClientNetwork.type = "text";
    textClientNetwork.id = 'idtextClientNetwork';
    textClientNetwork.className = 'textClientNetwork';
    spanClientNetwork.style.cursor = "pointer";
    colarray['columnClientNetwork'] = {
        header_title: "Client Network",
        edit: [textClientNetwork],
        disp: [spanClientNetwork],
        td_class: "tablerow tdClientNetwork tdclickmain",
        headertd_class : "hdClientNetwork"
    };

    var spanBranch = document.createElement('span');
    var textBranch = document.createElement('input');
    textBranch.type = "text";
    textBranch.id = 'idtextBranch';
    textBranch.className = 'textBranch';
    colarray['columnBranch'] = {
        header_title: "Branch",
        edit: [textBranch],
        disp: [spanBranch],
        td_class: "tablerow tdBranch tdclickmain",
        headertd_class : "hdBranch"
    };

    var spanPOSType = document.createElement('span');
    spanPOSType.type = "text";
    spanPOSType.id = 'idtextBranch';
    spanPOSType.className = 'textBranch';
    colarray['columnPOSType'] = {
        header_title: "POS Type",
        edit: [spanPOSType],
        disp: [spanPOSType],
        td_class: "tablerow tdBranch1 tdclickmain",
        headertd_class : "hdBranch tdclick"
    };

    var spanClientTerminalID = document.createElement('a');
    spanClientTerminalID.setAttribute("onclick","todetails_fnc(this)");
    spanClientTerminalID.setAttribute("style", "text-decoration: underline; color: #036c9c;");
    colarray['columnClientTerminalID'] = {
        header_title: "Terminal #",
        edit: [spanClientTerminalID],
        disp: [spanClientTerminalID],
        td_class: "tablerow tdClientTerminalID",
        headertd_class : "hdClientTerminalID"
    };

    var txtreferenceno = document.createElement('input');
    txtreferenceno.className = "txtreferenceno";
    txtreferenceno.type = "hidden";
    var spnreferenceno = document.createElement('span');
    spnreferenceno.type = "hidden";
    spnreferenceno.className = "spnreferenceno";
    colarray['colReferenceno'] = { 
        header_title: "",
        edit: [txtreferenceno],
        disp: [spnreferenceno],
        td_class: "tablerow tdall tdReferenceno",
        headertd_class : "tdwid"
    };

// Terminal Backup Table//

    var myJsTableTerminalBackup;
    var tableTerminalBackup = document.createElement('table');
    tableTerminalBackup.id = "table-version-id";
    tableTerminalBackup.className = "table table-bordered";
    var columnTerminalBackup = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnTerminalBackup['columnTerminalBackupId'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow td-hide",
        headertd_class : "tablerow td-hide"
    };

    var spanTerminalBackupMainId = document.createElement('span');
    spanTerminalBackupMainId.className = "span-terminal-id";
    spanTerminalBackupMainId.innerHTML = "";
    columnTerminalBackup['columnTerminalBackupMainId'] = {
        header_title: "ID",
        edit: [spanTerminalBackupMainId],
        disp: [spanTerminalBackupMainId],
        td_class: "tablerow tdall td-terminal-id td-hide",
        headertd_class : "tablerow td-hide"
    };

    var spanTerminalBackupDate = document.createElement('span');
    spanTerminalBackupDate.className = "span-backup-date";
    spanTerminalBackupDate.innerHTML = "";
    columnTerminalBackup['columnTerminalBackupDate'] = {
        header_title: "Date",
        edit: [spanTerminalBackupDate],
        disp: [spanTerminalBackupDate],
        td_class: "tablerow tdall td-backup-date tdclicktype"
    };

    var spanTerminalBackupType = document.createElement('span');
    spanTerminalBackupType.className = "span-backup-type";
    spanTerminalBackupType.innerHTML = "";
    columnTerminalBackup['columnTerminalBackupType'] = {
        header_title: "Backup Type",
        edit: [spanTerminalBackupType],
        disp: [spanTerminalBackupType],
        td_class: "tablerow tdall td-backup-type tdclicktype"
    };

    var spanTerminalBackupData = document.createElement('span');
    spanTerminalBackupData.className = "span-backup-data";
    spanTerminalBackupData.innerHTML = "";
    columnTerminalBackup['columnTerminalBackupData'] = {
        header_title: "Backup Data",
        edit: [spanTerminalBackupData],
        disp: [spanTerminalBackupData],
        td_class: "tablerow tdall td-backup-data tdclicktype"
    };

// Terminal Backup Details Table//

    var myJsTableTerminalBackupDetails;
    var tableTerminalBackupDetails = document.createElement('table');
    tableTerminalBackupDetails.id = "table-version-id1";
    tableTerminalBackupDetails.className = "table table-bordered";
    var columnTerminalBackupDetails = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnTerminalBackupDetails['columnTerminalVersionId1'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow td-hide",
        headertd_class : "tablerow td-hide "
    };

    var spanFilename = document.createElement('span');
    spanFilename.className = "span-file-name";
    spanFilename.innerHTML = "";
    columnTerminalBackupDetails['columnFilename'] = {
        header_title: "Filename",
        edit: [spanFilename],
        disp: [spanFilename],
        td_class: "tablerow tdall td-file-name tdclickfiledetails",
    };

    var spanType = document.createElement('span');
    spanType.className = "span-type";
    spanType.innerHTML = "";
    columnTerminalBackupDetails['columnType'] = {
        header_title: "Type",
        edit: [spanType],
        disp: [spanType],
        td_class: "tablerow tdall td-type tdclickfiledetails"
    };

    var spanSize = document.createElement('span');
    spanSize.className = "span-size";
    spanSize.innerHTML = "";
    columnTerminalBackupDetails['columnSize'] = {
        header_title: "Size",
        edit: [spanSize],
        disp: [spanSize],
        td_class: "tablerow tdall td-size tdclickfiledetails"
    };

    $(function()
    {
        myJsTableTerminalBackup = new my_table(tableTerminalBackup, columnTerminalBackup, {
            ispaging: true,
            iscursorchange_when_hover: false
        });

        var rootVersion = document.getElementById("table-version");
        rootVersion.appendChild(myJsTableTerminalBackup.tab);

        $('.text-enter-event').live('keydown', function(event)
        {
            var index = $(this).parent().parent().find('.text-enter-event').index($(this));
            var count = $(this).parent().parent().find('.text-enter-event').length;

            if (count == (index + 1)) {
                if (event.keyCode == 13) {
                    saveTerminalVersion($(this));
                    event.preventDefault();
                };
            };
        });

        $("#table-notes-id_txtpagenumber, #table-notes-id_txtfilternumber").live("keypress", function(e)
        {
            var keycode = event.which;
            if (! (
                    event.shiftKey == false
                    && (
                        keycode == 46
                        || keycode == 8
                        || keycode == 37
                        || keycode == 39
                        || (keycode >= 48
                        && keycode <= 57)
                    )
                )
            ) {
                event.preventDefault();
            }
        });
    });

    $(function()
    {
        myJsTableTerminalBackupDetails = new my_table(tableTerminalBackupDetails, columnTerminalBackupDetails, {
            iscursorchange_when_hover: false
        });

        var root = document.getElementById("table-version1");
        root.appendChild(myJsTableTerminalBackupDetails.tab);

        $('.tdclicktype').live('click',function(e){
            var rowIndex = $(this).parent().index();
            let currentRow = 0;
            $("#table-version-id").find("tr").each(function() {
                if (currentRow > 0 && currentRow == rowIndex) {
                    $(this).find("td").attr("style", "background-color: skyblue;");
                } 

                if (currentRow > 0 && currentRow != rowIndex) {
                     $(this).find("td").removeAttr("style");
                }
                currentRow++;
            });
            let filetype = myJsTableTerminalBackup.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnTerminalBackup['columnTerminalBackupType'].td_class
                )[0].trim();
            $("#table-version1").show();
            $("#table-version2").hide();
            myJsTableTerminalBackupDetails.clean_table();
            myJsTableTerminalBackupDetails.add_new_row();

            $.ajax({
                url: "<?=base_url("terminalreports/getFileDetails")?>",
                type: "POST",
                data: {
                    type :filetype,
                    clientTerminalId: $("#client-terminal-id").val()
                },
                dataType: "json",
                success: function(response)
                {
                    let terminalList = response.list;
                    $("#label-status-version").text("");
                    if ((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')) {
                        myJsTableTerminalBackupDetails.clear_table();
                    } else {
                        myJsTableTerminalBackupDetails.clean_table();
                    }

                    myJsTableTerminalBackupDetails.insert_multiplerow_with_value(1, terminalList);

                }
            });
        });

        $('.tdclickfiledetails').live('click',function(e){
            var rowIndex = $(this).parent().index();
            let backupReportId = myJsTableTerminalBackupDetails.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnTerminalBackupDetails['columnTerminalVersionId1'].td_class
            )[0].trim();
            let currentRow = 0;
            $("#table-version-id1").find("tr").each(function() {
                if (currentRow > 0 && currentRow == rowIndex) {
                    $(this).find("td").attr("style", "background-color: skyblue;");
                } 

                if (currentRow > 0 && currentRow != rowIndex) {
                     $(this).find("td").removeAttr("style");
                }
                currentRow++;
            }); 

            $.ajax({
                url: "<?=base_url("terminalreports/getFileDetailss3")?>",
                type: "POST",
                data: {
                    brId :backupReportId
                },
                dataType: "json",
                success: function(data)
                {

                    $("#owner").html(data.owner);
                    $("#awsregion").html(data.awsregion);
                    $("#lastmodifieddate").html(data.lastmodifieddate);
                    $("#fsize").html(data.filesize);
                    $("#ftype").html(data.filetype);
                    $("#fkey").html(data.key);
                    $("#s3uri").html(data.uri);
                    $("#arn").html(data.arn);
                    $("#etag").html(data.etag);
                    $("#url").html(data.url);
                    $("#table-version2").show();

                }
            });

        })
    });

    function showVersionTerminalStatus(response, row, id, isDelete = false)
    {
        let defaultImage = (response.hasData) ? "" : "-default";
        let imageVersion = "\
            <center>\
                <img src='assets/images/terminal-version"+defaultImage+".png' style='height: 20px; width: 20px;'>\
            </center>\
        ";

        if ($.inArray($("#client-terminal-id").val(), terminalRow) != -1) {
            let currentRow = parseInt($.inArray($("#client-terminal-id").val(), terminalRow)) + 1;
            $("#label-status-version").html(response.message);
            myjstbl.setvalue_to_rowindex_tdclass(
                [imageVersion],
                currentRow,
                colarray['columnImageVersion'].td_class
            );
        }

        if (! isDelete) {
            myJsTableTerminalBackup.update_row(row);
        } else {
            myJsTableTerminalBackup.delete_row(row);
        }

        if (id == "new") {
            myJsTableTerminalBackup.add_new_row();
        }
    }

    $('.tdclickmain').live('click',function(e){
        var rowIndex = $(this).parent().index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();
        let clientId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();
        let clientInformation = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['colclientinfo'].td_class
        )[0].trim();
        let referenceNumber = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['colReferenceno'].td_class
        )[0].trim();
        let uuid = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['columnClientIdCopy'].td_class
        )[0].trim();

        let currentRow = 0;
        gets3details(clientTerminalId);
    });
    
      
        
    $(function(){
   
        myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow",
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
        $("#filterclientgroup").val(<?=$clientgroupid?>);
        $("#filterclienthead").val(<?=$clientheadid?>);
        $("#filterclient").val(<?=$clientdetailid?>);
        var clientterminalsearch = (<?=$clientterminalid?>);
        $("#filter-client-status").val(<?=$clientStatus?>);
        $("#filter-client-order").val(<?=$clientOrder?>);
        $("#button-toggle").val(<?=$toggle?>);
        $("#filterclienthead").prop("disabled", true);
        $("#filterclient").prop("disabled", true);
        $("#createnew").click(function(){
            if (isFirstLoad) {
                alert("Unable to add new row. Please load the data first.");
            } else {
                clientTerminalTable.addNew();
                isNewRowData = true;
            }
        });

        if (clientterminalsearch > 0){
            refreshTable(0);
        }

        $("#teamviewerID").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $("#errorMessage").html("Digits Only").show().fadeOut("slow");
                       return false;
            }
        });     
                
        $("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclienthead").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclient").chosen({allow_single_deselect:true, 
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
            refresh_cleinthead_ddl();
            refresh_clientdetail_ddl();
            $("#filterclient").prop("disabled", ! ($("#filterclientgroup").val() > 0));
        });
        $("#filterclienthead").change(function(){
            $("#filterclient").prop("disabled", ! ($("#filterclienthead").val() > 0));
            refresh_clientdetail_ddl();
        });
        $('#detailgroup').modal("hide");
        
        $("#showhide").live("click",function(){
            if($(this).val() == "Show Advance Details"){
                $(this).val("Hide Advance Details");
                $(".tdpermitno").show();
                $(".tdmachineno").show();
                $(".tdserialno").show();
                $(".tdposstatus").show();
            }
            else{
                $(this).val("Show Advance Details");
                $(".tdpermitno").hide();
                $(".tdmachineno").hide();
                $(".tdserialno").hide();
                $(".tdposstatus").hide();
            }
        });
        $("#dateOfApplication").datepicker({dateFormat: 'yy-mm-dd'});

        $('.tdclick').live('click',function(e){
            if ($(e.srcElement).prop('nodeName').toLowerCase() == "input") {
                return;
            }
            var rowIndex = $(this).parent().index();
            var idVal = myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray["clientid"].td_class)[0];
            $('#clientTerminalDetailsID').val(idVal);
            $('#rowIndex').val(rowIndex);
            if(idVal == 0){
                return;
            }

            $.ajax(
            {
                url: "<?=base_url()?>clientterminaldetails/searchClientTerminalDetails_control",
                type: "POST",
                data: { 
                        clientTerminalDetailsID: idVal
                    },
                async: true,
                dataType: 'json',
            success: function(data)
            {
                $("#teamviewerID").val(data.teamViewerID);
                $("#dateOfApplication").val(data.applicationDate);
                $("#installationType").val(data.installationType);
            }
            
            });        

            $('#detailgroup').modal("show");

        })

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
            refresh_cleinthead_ddl();
        }

        $('#txtdatefrom').datepicker({dateFormat: 'yy-mm-dd'});
        $('#txtdateto').datepicker({dateFormat: 'yy-mm-dd'});
        $("#txtdateto").prop("disabled", true);

        $("#txtdatefrom").change(function(){
            $("#txtdateto").prop("disabled", ! ($("#txtdatefrom").val() != ""));
        });

        $("#txtdatefrom").keyup(function(e){
            if (e.keyCode == 46 || e.keyCode == 8) {
                $("#txtdatefrom").val("");
                $("#txtdateto").val("");
            }
        });

        $("#txtdateto").keyup(function(e){
            if (e.keyCode == 46 || e.keyCode == 8) {
                $("#txtdateto").val("");
            }
        });

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


    function set_tbl_element_events() {
        
        my_autocomplete_add(".txtclientinfo", "<?=base_url()?>clientterminaldetails/ac_clientinfo", {
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

    function data_val_num(e)
    {
        
            if ((e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 122) && e.which != 8 && e.which != 9 && e.which != 46 && e.which != 20 && e.which != 16 && e.which != 0) {
                e.preventDefault();
                return false;
        }   
    }
    
    function KeyDown(x)
    {
        var row_index = $(x).parent().parent().index();
        
        var e = jQuery.Event("keydown");
        e.which = 40; // # Some key code value
        var keydown = myjstbl.getelem_by_rowindex_tdclass(row_index,colarray["colclientinfo"].td_class);
        $(keydown).trigger(e);
        
    }
    
    function refresh_cleinthead_ddl()
    {
        $.get("<?=base_url()?>clientterminaldetails/refresh_cleinthead_ddl_control",
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
        $.get("<?=base_url()?>clientterminaldetails/refresh_cleintdetail_ddl_control",
        {
            clientheadid : $("#filterclienthead").val()
        }
        ,
        function(data){
            document.getElementById("filterclient").innerHTML = data;
            $("#filterclient").trigger("liszt:updated");
        });
    }

    function refresh_client()
    {
        // $.get("<?=base_url()?>clientterminaldetails/refresh_client",
        // {
        //     clientheadid : $("#filterclient").val()
        // }
        // ,
        // function(data){
        //     document.getElementById("filterclienthead").innerHTML = data;
        //     $("#filterclienthead").trigger("liszt:updated");
        // });
    }
    
    function bind_datepicker_to_subrow(row_index){
    
        var date_element1 = myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['colDateIssued'].td_class);
        var date_element2 = myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['colDateOfApp'].td_class);
        //var autocomplete1 = myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['colclientinfo'].td_class);

        
        var identifier = row_index.toString();
        $(date_element1).attr("id","txtDateIssued" + identifier);
        $("#" + "txtDateIssued" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
        $(date_element2).attr("id","txtDateOfApp" + identifier);
        $("#" + "txtDateOfApp" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
    //  $(autocomplete1).attr("id","txtclientinfo" + identifier);
    //  $("#" + "txtclientinfo" + identifier).datepicker({dateFormat: 'yy-mm-dd'});

    }
    
    function bind_datepicker_to_lastrow(){
    

        var cnt = myjstbl.get_row_count() - 1;
        var date_element3 = myjstbl.getelem_by_rowindex_tdclass(cnt, colarray['colDateIssued'].td_class);
        var date_element4 = myjstbl.getelem_by_rowindex_tdclass(cnt, colarray['colDateOfApp'].td_class);
        
        var identifier = cnt;
        
        $(date_element3).attr("id","txtDateIssued" + identifier);
        $("#" + "txtDateIssued" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
        $(date_element4).attr("id","txtDateOfApp" + identifier);
        $("#" + "txtDateOfApp" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
    }
    
    
    function enter_update(e, x)
    {
        if(e.keyCode == 13)
        {
            update_fnc(x);
            e.preventDefault();
                        
        }
        
    }

    function refreshTable(rowStart = 0, isNewData = false)
    {
        $(".tdpermitno").show();
        $(".tdmachineno").show();
        $(".tdserialno").show();
        $(".tdposstatus").show();
        var clientterminalsearch = (<?=$clientterminalid?>);

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
            url: "<?=base_url()?>terminalreports/search_control",
            type: "POST",
            data: {
                clientgroup_mdl: $('#filterclientgroup').val(),
                clienthead_mdl: $('#filterclienthead').val(),
                client_mdl: $('#filterclient').val(),
                terminal_mdl: clientterminalsearch,
                clientOrder: $("#filter-client-order").val(),
                buttonToggle: $("#button-toggle").val(),
                datefrom : $('#txtdatefrom').val(),
                dateto : $('#txtdateto').val(),
                status : $('#filter-client-status').val(),
                filterreset: 1,
                rowstart: rowStart,
                rowend: 0,
                limit: limit
            },
            success: function(data)
            {
                set_tbl_element_events();
                myjstbl.clear_table();
                myjstbl.isRefreshFilterPage = false;
                myjstbl.insert_multiplerow_with_value(1, data.data);

                rowCount = data.rowcnt;
                terminalList = data.terminalId;
                terminalRow = data.terminalRow;
                terminalType = data.typeList;

                $("#tableid_txtpagenumber").val(selectedPageNumber);
                if ($("#showhide").val() == "Show Advance Details") {
                    $(".tdpermitno").hide();
                    $(".tdmachineno").hide();
                    $(".tdserialno").hide();
                    $(".tdposstatus").hide();
                }

                if (isNewData) {
                    myjstbl.add_new_row();
                    myjstbl.getelem_by_rowindex_tdclass(
                        myjstbl.get_row_count() - 1,
                        colarray['coldelete'].td_class
                    )[0].style.display = "none";
                    bind_datepicker_to_lastrow();
                    myjstbl.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                        myjstbl.get_row_count() - 1,
                        colarray['columnImageStatus'].td_class
                    );
                    myjstbl.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                        myjstbl.get_row_count() -1,
                        colarray['columnImageNotes'].td_class
                    );
                    rowCount += 1;
                }

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

    function constructTerminalList(terminalId, isDelete = false)
    {
        let terminalListTemporary = [];
        let index;

        if (! isDelete) {
            for (index = 0; index < terminalList.length; index++) {
                terminalListTemporary[index] = terminalList[index];
            }
            terminalListTemporary[index] = terminalId;
        } else {
            let newIndex = 0;
            for (index = 0; index < terminalList.length; index++) {
                if (terminalId != terminalList[index]) {
                    terminalListTemporary[newIndex] = terminalList[index];
                    newIndex += 1;
                }
            }
        }

        terminalList = terminalListTemporary;
    }

    function editSelectedRow( myTable, rowObj){

        let rowindex = $(rowObj).parent().parent().index();
        
        if($(rowObj).hasClass("edit")) {

            let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(rowindex, colarray["clientid"].td_class);

            $.ajax({
                type: "POST",
                async: true,
                url: "<?=base_url()?>clientterminaldetails/getTerminalIsBound",
                data: {
                    terminalId : clientTerminalId
                },  
                success: function(reply) {
                    if(reply > 0){
                        alert("Unable to modify, this terminal is already bound to a PTU. Unbind first to modify this data.");
                    }
                    else{
                        myTable.edit_row(rowindex);
                        bind_datepicker_to_subrow(rowindex);
                        return;
                    }
                }
            });           
        }   

        if ($(rowObj).hasClass("edit-notes")) {
            myTable.edit_row(rowindex);
        }

        var stringLimit = 2000;
        var currentString = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowindex,
            columnArrayNotes['columnNotes'].td_class
        )[0];
        var stringLeft = stringLimit - currentString.length;

        myJsTableNotes.setvalue_to_rowindex_tdclass(
            ["Char. left:"+stringLeft],
            rowindex,
            columnArrayNotes['columnCharactersLeft'].td_class
        );
    }

    function todetails_fnc(rowObj)
    {
        var cnt = myjstbl.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        var values_arr = myjstbl.get_row_values(row_index);
        var id_val = values_arr[colarray['colReferenceno'].td_class][0];
        var arrayIDs = id_val.split("-");

        window.open("clientterminaldetails?clientgroupid=" + arrayIDs[0] + "&clientheadid=" + arrayIDs[1] + "&clientdetailid=" + arrayIDs[2] + "&clientterminalid=" + arrayIDs[3]);
    }

    var update_fnc_flag = 0;

    $(".text-notes").live("change keyup paste click", function(event)
    {
        var rowIndexNotes = $(this).parents("tr").index();
        var stringLimit = 2000;
        var currentString = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnNotes'].td_class
        )[0];
        var stringLeft = stringLimit - currentString.length;

        myJsTableNotes.setvalue_to_rowindex_tdclass(
            ["Char. left:"+stringLeft],
            rowIndexNotes,
            columnArrayNotes['columnCharactersLeft'].td_class
        );
    });

    function loadClientVersionTerminal(clientTerminalId)
    {
        $.ajax({
            url: "<?=base_url("terminalreports/getTerminalVersionDetails")?>",
            type: "POST",
            data: {
                clientTerminalId: clientTerminalId
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                $("#client-terminal-id").val(clientTerminalId);
                $("#text-client-info").html(response.full_client_name);
                $("#text-client-terminal").html("Terminal No. "+ response.reference_number);

                clientVersionTable();
                findPreviousNextArrayIndex(clientTerminalId)
            }
        });
    }

    function cancelAWSTransaction(){
        $('#client-popup').modal("hide");
    }

    function retryAWSTransaction(){
        $('#client-popup').modal("hide");
        gets3details($("#cdid-hidden").val());
    }

    function gets3details(clientTerminalId)
    {
        $('#loading-popup').modal("show");
        $.ajax({
            url: "<?=base_url("terminalreports/gets3details")?>",
            type: "POST",
            data: {
                clientTerminalId: clientTerminalId
            },
            dataType: "json",
            async: true,
            success: function(data)
            {
                $('#loading-popup').modal("hide");
                if (data.s3file == "The requested URL returned error: 406" ||
                    data.s3filedetails == "The requested URL returned error: 406") {
                    $('#client-popup').modal("show");
                    $("#cdid-hidden").val(clientTerminalId);
                } else {
                    $('#client-version').modal("show");
                }
                loadClientVersionTerminal(clientTerminalId);
            }
        });
    }

    function findPreviousNextArrayIndex(currentTerminalId)
    {
        $(".div-previous, .div-next").show();

        let currentIndex = "";
        for (index in terminalList) {
            if (currentTerminalId == terminalList[index]) {
                let selectedIndex = parseInt(index) + 1;
                $("#row-index-version").val(selectedIndex);
                currentIndex = parseInt(index);
            }
        }

        if ((currentIndex - 1) == -1) {
            $(".div-previous").hide();
        }

        if ((currentIndex + 1) == terminalList.length) {
            $(".div-next").hide();
        }
    }

    function clientVersionTable(rowstart, rowend)
    {
        if ((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')) {
            myJsTableTerminalBackup.clear_table();
        } else {
            myJsTableTerminalBackup.clean_table();
        }
        myJsTableTerminalBackup.add_new_row();

        $.ajax({
            url: "<?=base_url("terminalreports/getTerminalVersionList")?>",
            type: "POST",
            data: {
                clientTerminalId: $("#client-terminal-id").val()
            },
            dataType: "json",
            success: function(response)
            {
                let terminalList = response.list;
                $("#label-status-version").text("");
                if ((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')) {
                    myJsTableTerminalBackup.clear_table();
                } else {
                    myJsTableTerminalBackup.clean_table();
                }

                myJsTableTerminalBackup.insert_multiplerow_with_value(1, terminalList);

                $("#table-version-id").wrap("<div class='scrollable'></div>");
                $("#table-version-id1").wrap("<div class='scrollable'></div>");

                if (terminalList.length == 0) {
                    $("#table-versio").show();
                    $("#table-version-id").hide();
                } else {
                    $("#table-versio").hide();
                    $("#table-version-id").show();
                }

                $("#table-version1").hide();
                $("#table-version2").hide();
            }
        });
    }


    $(".td-hover").live("mouseenter, mousemove", function(event)
    {
        let nodeWidth = $("#popup-display").width();
        let nodeHeight = $("#popup-display").height();

        let nodeX =
            (event.pageX + nodeWidth < window.innerWidth + window.scrollX - 40)
            ? (event.pageX + 10)
            : (event.pageX - nodeWidth - 15);
        let nodeY =
            (event.pageY + nodeHeight < window.innerHeight + window.scrollY)
            ? (event.pageY - 25)
            : (event.pageY - nodeHeight - 5);

        let rowIndex = $(this).parent().index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();

        $.ajax({
            url: "<?=base_url("clientterminaldetails/getTerminalPopupVersion")?>",
            type: "POST",
            async: false,
            data: {
                clientTerminalId: clientTerminalId
            },
            dataType: "json",
            success: function(response)
            {
                let tableContent = '';

                for (key in response) {
                    tableContent += '\
                        <tr class="row-popup">\
                            <td class="td-center">'+response[key].system_version+'</td>\
                            <td class="td-center">'+response[key].auto_sync_version+'</td>\
                            <td class="td-center">'+response[key].database_version+'</td>\
                        </tr>\
                    ';
                }

                $("#popup-content").find("tbody").html("");
                $("#popup-content").find("tbody").append(tableContent);
                let toolTipText = $("#popup-content").html();
                if (tableContent) {
                    $("#popup-display").css("left", nodeX+"px");
                    $("#popup-display").css("top", nodeY+"px");
                    $("#popup-display").css("display", "block");
                    $("#popup-display").html(toolTipText);
                }
            }
        });


    }).live("mouseleave", function(event)
    {
        $("#popup-display").css("display", "none");
    });

    $(".div-next, .div-previous, .div-terminal-manager-previous, .div-terminal-manager-next, .div-autosync-status-previous, .div-autosync-status-next, .div-server-pos-setting-previous, .div-server-pos-setting-next, .div-ptu-details-previous, .div-ptu-details-next").live("click", function()
    {
        let action = $(this).attr("action");
        let className = $(this).attr("class");

        let index;
        if (className == "div-next" || className == "div-previous") {
            index = parseInt($("#row-index-version").val()) - 1;
        } else if (className == "div-terminal-manager-previous" || className == "div-terminal-manager-next") {
            index = parseInt($("#terminal-manager-row-index").val()) - 1;
        } else if (className == "div-autosync-status-previous" || className == "div-autosync-status-next") {
            index = parseInt($("#autosync-status-row-index").val()) - 1;
        } else if (className == "div-ptu-details-previous" || className == "div-ptu-details-next") {
            index = parseInt($("#ptu-details-row-index").val()) - 1;
        } else {
            index = parseInt($("#server-pos-setting-row-index").val()) - 1;
        }

        let selectedIndex = (action == "next") ? (index + 1) : (index - 1);

        if (className == "div-next" || className == "div-previous") {
            $('#client-version').modal("hide");
            gets3details(terminalList[selectedIndex]);
            loadClientVersionTerminal(terminalList[selectedIndex]);
        } else if (className == "div-terminal-manager-previous" || className == "div-terminal-manager-next") {
            loadTerminalManagerData(terminalList[selectedIndex]);
        } else if (className == "div-autosync-status-previous" || className == "div-autosync-status-next") {
            loadAutoSyncSetting(terminalList[selectedIndex]);
        } else if (className == "div-ptu-details-previous" || className == "div-ptu-details-next") {
            loadPtuDetails(terminalList[selectedIndex]);
        } else {
            let clientType = parseInt(terminalType[selectedIndex]);
            let typeList = ["", "Server", "Server/POS", "POS", "Office Computer"];

            let titleSetting = typeList[clientType] +"/Database/Hardware Setting and Unit Specifications";
            $('#server-pos-setting-dialog').find(".modal-title").html("TM Report - "+ titleSetting);
            $("#server-pos-setting-tabs, #server-pos-setting-content").hide();
            $("#server-pos-setting-terminal-id").val(terminalList[selectedIndex]);
            $("#server-pos-setting-terminal-type").val(clientType);

            let showContent = "#server-pos-setting-tabs";
            $(".tab-server").parent().show();
            $(".tab-pos").parent().show();
            if (clientType == 1 || clientType == 3 || clientType == 4) {
                let hideTab = (clientType == 3) ? ".tab-server" : ".tab-pos";
                $(hideTab).parent().hide();

                $(".tab-pos").parent().removeAttr("class");
                if (clientType == 3) {
                    $(".tab-pos").parent().attr("class", "active");
                }
            }
            $(showContent).show();


            $(".server-pos-setting-dialog-content").removeAttr("style");
            if (clientType == 2) {
                $(".server-pos-setting-dialog-content").css({"width": "700px"});
            }

            $(showContent).show();
            loadServerPosSettingData();
        }
    });


    $(".image-autosync-status").live("mouseenter, mousemove", function(event)
    {
        let nodeWidth = $("#popup-display").width();
        let nodeHeight = $("#popup-display").height();

        let nodeX =
            (event.pageX + nodeWidth < window.innerWidth + window.scrollX - 40)
            ? (event.pageX + 10)
            : (event.pageX - nodeWidth - 15);
        let nodeY =
            (event.pageY + nodeHeight < window.innerHeight + window.scrollY)
            ? (event.pageY - 25)
            : (event.pageY - nodeHeight - 5);
        status = $(this).find("img").attr("status");

        let toolTipText = "<b>"+ status +"</b";
        $("#popup-display").css("left", nodeX+"px");
        $("#popup-display").css("top", nodeY+"px");
        $("#popup-display").css("display", "block");
        $("#popup-display").html(toolTipText);

    }).live("mouseleave", function(event)
    {
        $("#popup-display").css("display", "none");
    });

    $(".tab-server, .tab-pos, .tab-database, .tab-hardware, .tab-unit").live("click", function(event)
    {
        let action = parseInt($(this).attr("action"));
        loadServerPosSettingData(action, false);

        event.preventDefault();
    });
</script>

