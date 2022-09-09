    <script language="javascript" type="text/javascript">
    var notesImages = ["without_notes.png", "notes.ico"];
    var statusImages = ["red_status.png", "green_status.png"];
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
    
    var imageStatus = document.createElement('span');
    imageStatus.setAttribute("id", "image-status");
    imageStatus.setAttribute("onclick", "changeStatus(this)");
    imageStatus.style.cursor = "pointer";
    colarray['columnImageStatus'] = {
        header_title: "",
        edit: [imageStatus],
        disp: [imageStatus],
        td_class: "tablerow td-image-status"
    };

    var serverStatus = document.createElement('span');
    serverStatus.setAttribute("id", "server-status");
    serverStatus.setAttribute("onclick", "redirect(this)");
    serverStatus.style.cursor = "pointer";
    colarray['columnServerStatus'] = {
        header_title: "Server Status",
        edit: [serverStatus],
        disp: [serverStatus],
        td_class: "tablerow td-server-status"
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

    var txtclientid = document.createElement('input');
    txtclientid.className = "txtclientid";
    var txtclientid_disp = document.createElement('span');
    txtclientid_disp.disabled = "disabled";
    colarray['clientid'] = { 
        header_title: "ID",
        edit: [txtclientid_disp], 
        disp: [txtclientid_disp], 
        td_class: "tablerow tdtxtclientid tdpopuphover text-bold",
        headertd_class : "tdtxtclientid"
    };
    
    var txtclientinfo = document.createElement('input');
    txtclientinfo.className = "txtclientinfo";
    txtclientinfo.id = "txtclientinfo";
    txtclientinfo.type = "text";
    txtclientinfo.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    txtclientinfo.setAttribute("onFocus", "KeyDown(this);");
    var spnclientinfo = document.createElement('span');
    spnclientinfo.className = "spnclientinfo";
    colarray['colclientinfo'] = { 
        header_title: "Client Group / Client Head / Branch ID / Client Detail",
        edit: [txtclientinfo],
        disp: [spnclientinfo],
        td_class: "tablerow tdlong tdclick tdclientinfo"
    };

    var seltype = document.createElement('select');
    seltype.className = "seltype";
    seltype.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    seltype.innerHTML = '<option value="1">Server</option><option value="2">POS-Server</option><option value="3">POS</option><option value="4">Office Computer</option><option value="5" hidden>POS (Cirms)</option>';
    var seltype_disp = seltype.cloneNode(true);
    seltype_disp.disabled = "disabled";
    colarray['coltype'] = { 
        header_title: "Type", 
        edit: [seltype], 
        disp: [seltype_disp], 
        td_class: "tablerow tdlong tdtype"
    };
    
    var selcomp = document.createElement('select');
    selcomp.className = "selcomp";
    selcomp.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selcomp.innerHTML = '<?php echo fill_select_options("SELECT * FROM nelsoft_clients.company_accre", "id", "name",0,false); ?>';
    var selcomp_disp = selcomp.cloneNode(true);
    selcomp_disp.disabled = "disabled";
    colarray['colcomp'] = { 
        header_title: "Company", 
        edit: [selcomp], 
        disp: [selcomp_disp], 
        td_class: "tablerow tdlong tdcomp"
    };
    
    var selmall = document.createElement('select');
    selmall.className = "selmall";
    selmall.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selmall.innerHTML = '<?php echo fill_select_options("SELECT * FROM nelsoft_clients.mall_accre", "id", "name",0,false); ?>';
    var selmall_disp = selmall.cloneNode(true);
    selmall_disp.disabled = "disabled";
    colarray['colmall'] = { 
        header_title: "Mall", 
        edit: [selmall], 
        disp: [selmall_disp], 
        td_class: "tablerow tdlong tdmall"
    };
    
    var selpos = document.createElement('select');
    selpos.className = "selpos";
    selpos.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selpos.innerHTML = '<?php echo fill_select_options("SELECT * FROM nelsoft_clients.pos_type", "id", "type",0,false); ?>';
    var selpos_disp = selpos.cloneNode(true);
    selpos_disp.disabled = "disabled";
    colarray['colpos'] = { 
        header_title: "POS Type", 
        edit: [selpos], 
        disp: [selpos_disp], 
        td_class: "tablerow tdlong tdpos"
    };

    var txtreferenceno = document.createElement('input');
    txtreferenceno.className = "txtreferenceno";
    txtreferenceno.type = "text";
    txtreferenceno.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    var spnreferenceno = document.createElement('span');
    spnreferenceno.className = "spnreferenceno";
    spnreferenceno.setAttribute("style", "text-decoration: underline; color: #036c9c;");
    spnreferenceno.setAttribute("onclick", "showServerPosSetting(this);");
    colarray['colReferenceno'] = { 
        header_title: "Ref/ Trm #",
        edit: [txtreferenceno],
        disp: [spnreferenceno],
        td_class: "tablerow tdall tdReferenceno"
    };

    var imageVersion = document.createElement('span');
    imageVersion.setAttribute("id", "image-notes");
    imageVersion.setAttribute("onclick", "showTerminalVersion(this)");
    imageVersion.innerHTML = "\
        <center>\
            <img src='assets/images/terminal-version-default.png' style='height: 20px; width: 20px;'>\
        </center>\
    ";
    imageVersion.style.cursor = "pointer";
    colarray['columnImageVersion'] = {
        header_title: "Sys/Au/DB Ver.",
        edit: [imageVersion],
        disp: [imageVersion],
        td_class: "tablerow td-image-version td-hover"
    };

    var imageAutoSyncStatus = document.createElement('span');
    imageAutoSyncStatus.setAttribute("class", "image-autosync-status");
    imageAutoSyncStatus.setAttribute("onclick", "showAutoSyncSetting(this)");
    var editImageAutoSyncStatus = document.createElement('span');
    editImageAutoSyncStatus.setAttribute("class", "image-autosync-status");
    editImageAutoSyncStatus.setAttribute("onclick", "showAutoSyncSetting(this)");
    editImageAutoSyncStatus.innerHTML = "\
        <center>\
            <img src='assets/images/gray_status.png' style='height: 20px; width: 20px;' status='No Data'>\
        </center>\
    ";
    colarray['columnAutoSyncStatus'] = {
        header_title: "AutoSync Status",
        edit: [editImageAutoSyncStatus],
        disp: [imageAutoSyncStatus],
        td_class: "tablerow td-autosync-status"
    };
    

    
    var txtpermitno = document.createElement('input');
    txtpermitno.className = "txtpermitno";
    txtpermitno.type = "text";
    txtpermitno.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    var spnVersionNo = document.createElement('span');
    spnVersionNo.className = "spnVersionNo";
    colarray['permitno'] = { 
        header_title: "Permit No.",
        edit: [txtpermitno],
        disp: [spnVersionNo],
        td_class: "tablerow tdlong tdpermitno td-hide",
        headertd_class: "td-hide"
    };  
    
    
    var txtmachineno = document.createElement('input');
    txtmachineno.className = "txtmachineno";
    txtmachineno.type = "text";
    txtmachineno.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    var spnmachineno = document.createElement('span');
    spnmachineno.className = "spnmachineno";
    colarray['machineno'] = { 
        header_title: "Machine No.",
        edit: [txtmachineno],
        disp: [spnmachineno],
        td_class: "tablerow tdlong tdmachineno td-hide",
        headertd_class: "td-hide"
    };  
    
    var txtserialno = document.createElement('input');
    txtserialno.className = "txtserialno";
    txtserialno.type = "text";
    txtserialno.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    var spnserialno = document.createElement('span');
    spnserialno.className = "spnserialno";
    colarray['serialno'] = { 
        header_title: "Serial No.",
        edit: [txtserialno],
        disp: [spnserialno],
        td_class: "tablerow tdlong tdserialno td-hide",
        headertd_class: "td-hide"
    };  

    var ptuDetails = document.createElement('span');
    ptuDetails.setAttribute("id", "image-notes");
    ptuDetails.setAttribute("onclick", "showPtuDetails(this)");
    ptuDetails.innerHTML = "\
        <center>\
            <img src='assets/images/terminal-version-default.png' tooltip-value='~u~~u~' style='height: 20px; width: 20px;'>\
        </center>\
    ";
    ptuDetails.style.cursor = "pointer";
    colarray['columnPtuDetails'] = {
        header_title: "PTU Details",
        edit: [ptuDetails],
        disp: [ptuDetails],
        td_class: "tablerow td-ptu-details"
    };

    var terminalManager = document.createElement('span');
    terminalManager.setAttribute("id", "image-notes");
    terminalManager.setAttribute("onclick", "showTerminalManagerDialogs(this)");
    terminalManager.innerHTML = "\
        <center>\
            <img src='assets/images/terminal-version-default.png' tooltip-value='~u~~u~' style='height: 20px; width: 20px;'>\
        </center>\
    ";
    terminalManager.style.cursor = "pointer";
    colarray['columnTerminalManager'] = {
        header_title: "T.M. PTU Report",
        edit: [terminalManager],
        disp: [terminalManager],
        td_class: "tablerow td-terminal-manager td-terminal-manager-hover"
    };
    
    var selectAccreditation = document.createElement('select');
    selectAccreditation.className = "select-accreditation";
    selectAccreditation.setAttribute("onkeypress", "return js_fire_tab_when_entered(event, this);");
    selectAccreditation.innerHTML
        = '<?php echo fill_select_options("SELECT id, accreditation FROM accreditation_list", "id", "accreditation", 0, false); ?>';
    var dipslaySelectAccreditation = selectAccreditation.cloneNode(true);
    dipslaySelectAccreditation.disabled = "disabled";
    colarray['accreditation'] = {
        header_title: "Accreditation",
        edit: [selectAccreditation],
        disp: [dipslaySelectAccreditation],
        td_class: "tablerow tdlong td-accreditation td-hide",
        headertd_class: "td-hide"
    };

    var txtDateOfApp = document.createElement('input');
    txtDateOfApp.className = "txtDateOfApp";
    txtDateOfApp.type = "text";
    //txtDateOfApp.setAttribute("onkeypress","enter_update(event, this);");
    var spnDateOfApp = document.createElement('span');
    spnDateOfApp.className = "spnDateOfApp";
    colarray['colDateOfApp'] = { 
        header_title: "Date of Application",
        edit: [txtDateOfApp],
        disp: [spnDateOfApp],
        td_class: "tablerow tdlong tdDateOfApp td-hide",
        headertd_class: "td-hide"
    };
    
    var txtDateIssued = document.createElement('input');
    txtDateIssued.className = "txtDateIssued";
    txtDateIssued.type = "text";
    //txtDateIssued.setAttribute("onkeypress","enter_update(event, this);");
    var spnDateIssued = document.createElement('span');
    spnDateIssued.className = "spnDateIssued";
    colarray['colDateIssued'] = { 
        header_title: "Date Issued",
        edit: [txtDateIssued],
        disp: [spnDateIssued],
        td_class: "tablerow tdlong tdDateIssued td-hide",
        headertd_class: "td-hide"
    };
    
    var selposstatus = document.createElement('select');
    selposstatus.className = "selposstatus";
    selposstatus.innerHTML = '<?php echo fill_select_options("SELECT `id`, `name` FROM `posstatus` ORDER BY `name`", "id", "name",0,false); ?>';
    var selposstatus_disp = selposstatus.cloneNode(true);
    selposstatus_disp.disabled = "disabled";
    selposstatus_disp.style = "display:none";
    colarray['posstatus'] = { 
        header_title: "", 
        edit: [selposstatus_disp], 
        disp: [selposstatus_disp], 
        td_class: "tablerow tdposstatus",
        headertd_class : "tdposstatus"
    };
    
    var txtUuid = document.createElement('span');
    txtUuid.className = "txtUuid";
    txtUuid.type = "text";
    txtUuid.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    var spnUuid = document.createElement('span');
    spnUuid.className = "spnUuid";
    colarray['colUuid'] = { 
        header_title: "UUID",
        edit: [txtUuid],
        disp: [spnUuid],
        td_class: "tablerow tdUuid"       
    };
    
    var txtTeamViewerid = document.createElement('input');
    txtTeamViewerid.className = "txtTeamViewerid";
    txtTeamViewerid.type = "text";
    txtTeamViewerid.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    var spnTeamViewerid = document.createElement('span');
    spnTeamViewerid.className = "spnTeamViewerid";
    colarray['colTeamViewerid'] = { 
        header_title: "TeamViewerid",
        edit: [txtTeamViewerid],
        disp: [spnTeamViewerid],
        td_class: "tablerow tdlong tdTeamViewerid"       
    };
    
    var imageNotes = document.createElement('span');
    imageNotes.setAttribute("id", "image-notes");
    imageNotes.setAttribute("onclick", "addClientNotes(this)");
    imageNotes.style.cursor = "pointer";
    colarray['columnImageNotes'] = {
        header_title: "Notes",
        edit: [imageNotes],
        disp: [imageNotes],
        td_class: "tablerow td-image-notes"
    };

    var txtTeamViewerpw = document.createElement('input');
    txtTeamViewerpw.className = "txtTeamViewerpw";
    txtTeamViewerpw.type = "text";
    txtTeamViewerpw.style = "display:none";
    txtTeamViewerpw.setAttribute("onkeypress","enter_update(event, this);");
    var spnTeamViewerpw = document.createElement('span');
    spnTeamViewerpw.style = "display:none";
    spnTeamViewerpw.className = "spnTeamViewerpw";
    colarray['colTeamViewerpw'] = { 
        header_title: "",
        edit: [txtTeamViewerpw],
        disp: [spnTeamViewerpw],
        td_class: "tablerow tdlong tdTeamViewerpw"       
    };
    
    var imgUpdate = document.createElement('img');
    imgUpdate.src = "assets/images/iconupdate.png";
    imgUpdate.setAttribute("onclick","update_fnc(this)");
    imgUpdate.style.cursor = "pointer";
    var imgEdit = document.createElement('img');
    imgEdit.src = "assets/images/iconedit.png";
    imgEdit.className = "edit";
    imgEdit.setAttribute("onclick","edit_fnc(this)");
    imgEdit.setAttribute("onclick"," editSelectedRow(myjstbl, this);");
    imgEdit.style.cursor = "pointer";
    imgEdit.style.display = "block";
    
    colarray['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate],
        disp: [imgEdit],
        td_class: "tablerow tdupdate"
    };

    var imgDelete = document.createElement('img');
    imgDelete.src = "assets/images/icondelete.png";
    imgDelete.setAttribute("onclick","delete_fnc(this)");
    imgDelete.style.cursor = "pointer";
    <?php if ($isManagementPosition) { ?>
        imgDelete.style.display = "block";
    <?php } else { ?>
        imgDelete.style.display = "none";
    <?php } ?>
    colarray['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete"
    };

    var myJsTableNotes;
    var tableNotes = document.createElement('table');
    tableNotes.id = "table-notes-id";
    tableNotes.className = "table table-bordered";

    var columnArrayNotes = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnArrayNotes['columnHiddenId'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow"
    };

    var idNotes = document.createElement('span');
    columnArrayNotes['columnId'] = {
        header_title: "ID",
        edit: [idNotes],
        disp: [idNotes],
        td_class: "tablerow td-id",
        headertd_class : "tdclick td-id"
    };

    var textReference = document.createElement('input');
    textReference.className = "text-reference";
    textReference.setAttribute("maxlength", "1000");
    var spanReference = document.createElement('span');
    spanReference.className = "span-reference";
    columnArrayNotes['columnReference'] = {
        header_title: "Reference",
        edit: [textReference],
        disp: [spanReference],
        td_class: "tablerow td-reference",
        headertd_class: "tdclick td-reference"
    };

    var textNotes = document.createElement('textarea');
    textNotes.className = "text-notes";
    textNotes.setAttribute("maxlength", "2000");
    var textDisplayNotes = document.createElement('textarea');
    textDisplayNotes.className = "text-display-notes";
    textDisplayNotes.setAttribute("disabled", "disabled");
    columnArrayNotes['columnNotes'] = {
        header_title: "Notes",
        edit: [textNotes],
        disp: [textDisplayNotes],
        td_class: "tablerow td-notes",
        headertd_class: "tdclick td-notes"
    };

    var charactersLeft = document.createElement('span');
    columnArrayNotes['columnCharactersLeft'] = {
        header_title: "",
        edit: [charactersLeft],
        disp: [charactersLeft],
        td_class: "tablerow td-characters",
        headertd_class : "tdclick td-characterss"
    };

    var updateNotes = document.createElement('img');
        updateNotes.src = "assets/images/iconupdate.png";
        updateNotes.setAttribute("onclick", "saveClientNotes(this)");
        updateNotes.style.cursor = "pointer";
    var editNotes = document.createElement('img');
        editNotes.src = "assets/images/iconedit.png";
        editNotes.setAttribute("onclick", "editSelectedRow(myJsTableNotes, this);");
        editNotes.id = "edit-notes";
        editNotes.className = "edit-notes";
        editNotes.style.cursor = "pointer";
        editNotes.style.display = "none";
        editNotes.style.display = "block";
    columnArrayNotes['columnUpdateNotes'] = {
        header_title: "",
        edit: [updateNotes],
        disp: [editNotes],
        td_class: " tablerow td-update",
        headertd_class : "hdupdate3 td-update"
    };

    var deleteNotes = document.createElement('img');
    deleteNotes.src = "assets/images/icondelete.png";
    deleteNotes.setAttribute("id", "delete-notes");
    deleteNotes.style.cursor = "pointer";
    columnArrayNotes['columnDeleteNotes'] = {
        header_title: "",
        edit: [deleteNotes],
        disp: [deleteNotes],
        td_class: "tablerow td-delete",
        headertd_class: "hddelete2 td-delete"
    };

    $(function()
    {
        myJsTableNotes = new my_table(tableNotes, columnArrayNotes, {
            ispaging: true,
            iscursorchange_when_hover: false,
            isRefreshFilterPage: false
        });

        var rootNotes = document.getElementById("table-notes");
        rootNotes.appendChild(myJsTableNotes.tab);
        rootNotes.appendChild(myJsTableNotes.mypage.pagingtable);

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

    var myJsTableTerminalVersion;
    var tableVersion = document.createElement('table');
    tableVersion.id = "table-version-id";
    tableVersion.className = "table table-bordered";
    var columnTerminalVersion = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnTerminalVersion['columnTerminalVersionId'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow"
    };

    var spanTerminalVersionId = document.createElement('span');
    spanTerminalVersionId.className = "span-terminal-id";
    spanTerminalVersionId.innerHTML = "";
    columnTerminalVersion['columnTerminalCounter'] = {
        header_title: "ID",
        edit: [spanTerminalVersionId],
        disp: [spanTerminalVersionId],
        td_class: "tablerow tdall td-terminal-id"
    };

    var inputSystemVersion = document.createElement('input');
    inputSystemVersion.type = "text";
    inputSystemVersion.style = "width: 90%;";
    inputSystemVersion.setAttribute("class", "span-system-version text-enter-event")
    var spanSystemVersion = document.createElement('span');
    spanSystemVersion.className = "span-system-version";
    spanSystemVersion.innerHTML = "";
    columnTerminalVersion['columnSystemVersion'] = {
        header_title: "System Ver.",
        edit: [inputSystemVersion],
        disp: [spanSystemVersion],
        td_class: "tablerow tdall td-system-version"
    };

    var inputAutoSyncVersion = document.createElement('input');
    inputAutoSyncVersion.type = "text";
    inputAutoSyncVersion.style = "width: 90%;";
    inputAutoSyncVersion.setAttribute("class", "span-auto-sync-version text-enter-event")
    var spanAutoSyncVersion = document.createElement('span');
    spanAutoSyncVersion.className = "span-auto-sync-version";
    spanAutoSyncVersion.innerHTML = "";
    columnTerminalVersion['columnAutoSyncVersion'] = {
        header_title: "AutoSync Ver.",
        edit: [inputAutoSyncVersion],
        disp: [spanAutoSyncVersion],
        td_class: "tablerow tdall td-auto-sync-version"
    };

    var inputDatabaseVersion = document.createElement('input');
    inputDatabaseVersion.type = "text";
    inputDatabaseVersion.style = "width: 90%;";
    inputDatabaseVersion.setAttribute("class", "span-database-version text-enter-event")
    var spanDatabaseVersion = document.createElement('span');
    spanDatabaseVersion.className = "span-database-version";
    spanDatabaseVersion.innerHTML = "";
    columnTerminalVersion['columnDatabaseVersion'] = {
        header_title: "Database Ver.",
        edit: [inputDatabaseVersion],
        disp: [spanDatabaseVersion],
        td_class: "tablerow tdall td-database-version"
    };

    var updateVersion = document.createElement('img');
        updateVersion.src = "assets/images/iconupdate.png";
        updateVersion.setAttribute("onclick", "saveTerminalVersion(this)");
        updateVersion.className = "edit-version";
        updateVersion.style.cursor = "pointer";
    var editVersion = document.createElement('img');
        editVersion.src = "assets/images/iconedit.png";
        editVersion.setAttribute("onclick", "editTerminalVersionRow(myJsTableTerminalVersion, this);");
        editVersion.id = "edit-version";
        editVersion.className = "edit-version";
        editVersion.style.cursor = "pointer";
        editVersion.style.display = "none";
        editVersion.style.display = "block";
    columnTerminalVersion['columnUpdateVersion'] = {
        header_title: "",
        edit: [updateVersion],
        disp: [editVersion],
        td_class: " tablerow td-update",
        headertd_class : "hdupdate3 td-update"
    };

    var deleteVersion = document.createElement('img');
    deleteVersion.src = "assets/images/icondelete.png";
    deleteVersion.setAttribute("id", "delete-version");
    deleteVersion.setAttribute("onclick", "deleteTerminalVersion(this)");
    deleteVersion.style.cursor = "pointer";
    columnTerminalVersion['columnDeleteVersion'] = {
        header_title: "",
        edit: [deleteVersion],
        disp: [deleteVersion],
        td_class: "tablerow td-delete",
        headertd_class: "hddelete2 td-delete"
    };

    var myJsTableTerminalManager;
    var tableTerminalManager = document.createElement('table');
    tableTerminalManager.id = "table-terminal-manager-id";
    tableTerminalManager.className = "table table-bordered";
    var columnTerminalManager = [];

    var spanClientTerminalId = document.createElement('span');
    columnTerminalManager["columnClientTerminalId"] = {
        header_title: "Client Terminal ID",
        edit: [spanClientTerminalId],
        disp: [spanClientTerminalId],
        td_class: "tablerow tdall td-client-id",
    }

    var spanTerminalNumber = document.createElement('span');
    columnTerminalManager["columnTerminalNo"] = {
        header_title: "TRM#",
        edit: [spanTerminalNumber],
        disp: [spanTerminalNumber],
        td_class: "tablerow tdall td-terminal-no",
    }

    var spanBranchId = document.createElement('span');
    columnTerminalManager["columnBranchId"] = {
        header_title: "Branch ID",
        edit: [spanBranchId],
        disp: [spanBranchId],
        td_class: "tablerow tdall td-branch-id",
    }

    var spanSqlPort = document.createElement('span');
    columnTerminalManager["columnSqlPort"] = {
        header_title: "SQL Port",
        edit: [spanSqlPort],
        disp: [spanSqlPort],
        td_class: "tablerow tdall td-sql-port",
    }

    var spanBusinessName = document.createElement('span');
    columnTerminalManager["columnBusinessName"] = {
        header_title: "Business Name",
        edit: [spanBusinessName],
        disp: [spanBusinessName],
        td_class: "tablerow tdall td-business-name",
    }

    var spanOwner = document.createElement('span');
    columnTerminalManager["columnOwner"] = {
        header_title: "Owner",
        edit: [spanOwner],
        disp: [spanOwner],
        td_class: "tablerow tdall td-owner",
    }

    var spanAddress = document.createElement('span');
    columnTerminalManager["columnAddress"] = {
        header_title: "Address",
        edit: [spanAddress],
        disp: [spanAddress],
        td_class: "tablerow tdall td-address",
    }

    var spanTin = document.createElement('span');
    columnTerminalManager["columnTin"] = {
        header_title: "Tin",
        edit: [spanTin],
        disp: [spanTin],
        td_class: "tablerow tdall td-tin",
    }

    var spanAccreditation = document.createElement('span');
    columnTerminalManager["columnAccreditation"] = {
        header_title: "Accreditation",
        edit: [spanAccreditation],
        disp: [spanAccreditation],
        td_class: "tablerow tdall td-accreditation",
    }

    var spanPermitNumber = document.createElement('span');
    columnTerminalManager["columnPermitNo"] = {
        header_title: "Permit No.",
        edit: [spanPermitNumber],
        disp: [spanPermitNumber],
        td_class: "tablerow tdall td-permit-no",
    }

    var spanSerialNo = document.createElement('span');
    columnTerminalManager["columnSerialNo"] = {
        header_title: "S/N",
        edit: [spanSerialNo],
        disp: [spanSerialNo],
        td_class: "tablerow tdall td-serial-no",
    }

    var spanMin = document.createElement('span');
    columnTerminalManager["columnMin"] = {
        header_title: "Min",
        edit: [spanMin],
        disp: [spanMin],
        td_class: "tablerow tdall td-min",
    }

    var spanVatStatus = document.createElement('span');
    columnTerminalManager["columnVatStatus"] = {
        header_title: "Vat Status",
        edit: [spanVatStatus],
        disp: [spanVatStatus],
        td_class: "tablerow tdall td-vat-status",
    }

    var spanApprovalDate = document.createElement('span');
    columnTerminalManager["columnApprovalDate"] = {
        header_title: "Approval Date",
        edit: [spanApprovalDate],
        disp: [spanApprovalDate],
        td_class: "tablerow tdall td-approval-date",
    }

    var spanDateModified = document.createElement('span');
    columnTerminalManager["columnDateModified"] = {
        header_title: "Date Modified",
        edit: [spanDateModified],
        disp: [spanDateModified],
        td_class: "tablerow tdall td-date-modified",
    }

    $(function()
    {
        myJsTableTerminalVersion = new my_table(tableVersion, columnTerminalVersion, {
            ispaging: true,
            iscursorchange_when_hover: false
        });

        var rootVersion = document.getElementById("table-version");
        rootVersion.appendChild(myJsTableTerminalVersion.tab);
        rootVersion.appendChild(myJsTableTerminalVersion.mypage.pagingtable);

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

    $("#table-version-id").find("tbody").find("tr:last").find("input").live("keyup", function(e)
    {
        let isShowDelete = false;

        $("#table-version-id").find("tbody").find("tr:last").find("input").each(function()
        {
            if ($(this).val()) {
                isShowDelete = true;
            }
        });

        showAddNewDeleteButton(isShowDelete);
    });

    function showAddNewDeleteButton(isShow = false)
    {
        if (isShow) {
            $("#table-version-id").find("tbody").find("tr:last").find("#delete-version").removeAttr("style");
        } else {
            $("#table-version-id").find("tbody").find("tr:last").find("#delete-version").css({"display": "none"});
        }
    }

    function editTerminalVersionRow(myTable, rowObject)
    {
        let row = $(rowObject).parent().parent().index();
        myTable.edit_row(row);
    }

    function saveTerminalVersion(rowObject)
    {
        let row = $(rowObject).parent().parent().index();
        let terminalVersionId = myJsTableTerminalVersion.getvalue_by_rowindex_tdclass(
            row,
            columnTerminalVersion['columnTerminalVersionId'].td_class
        )[0].trim();
        let systemVersion = myJsTableTerminalVersion.getvalue_by_rowindex_tdclass(
            row,
            columnTerminalVersion['columnSystemVersion'].td_class
        )[0].trim();
        let autoSyncVersion = myJsTableTerminalVersion.getvalue_by_rowindex_tdclass(
            row,
            columnTerminalVersion['columnAutoSyncVersion'].td_class
        )[0].trim();
        let databaseVersion = myJsTableTerminalVersion.getvalue_by_rowindex_tdclass(
            row,
            columnTerminalVersion['columnDatabaseVersion'].td_class
        )[0].trim();

        let id = (terminalVersionId) ? terminalVersionId : "new";
        let formdata = {
            id: id,
            clientTerminalId: $("#client-terminal-id").val(),
            systemVersion: systemVersion,
            autoSyncVersion: autoSyncVersion,
            databaseVersion: databaseVersion
        }

        if (! systemVersion && ! autoSyncVersion && ! databaseVersion) {
            alert("No data encoded.");
            return;
        }

        $.ajax(
        {
            url: "<?=base_url("clientterminaldetails/saveTerminalVersionList")?>",
            type: "POST",
            data: formdata,
            dataType: "json",
            success: function(response)
            {
                myJsTableTerminalVersion.setvalue_to_rowindex_tdclass(
                    [response.id],
                    row,
                    columnTerminalVersion['columnTerminalVersionId'].td_class
                );

                myJsTableTerminalVersion.setvalue_to_rowindex_tdclass(
                    [response.terminalCounter],
                    row,
                    columnTerminalVersion['columnTerminalCounter'].td_class
                );

                showVersionTerminalStatus(response, row, id);
                $(".span-system-version").focus();
            },
            complete: function()
            {
                updateLogScreen();
            }
        })
    }

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
            myJsTableTerminalVersion.update_row(row);
        } else {
            myJsTableTerminalVersion.delete_row(row);
        }

        if (id == "new") {
            myJsTableTerminalVersion.add_new_row();
        }
    }

    function deleteTerminalVersion(rowObject)
    {
        let row = $(rowObject).parent().parent().index();
        let id = myJsTableTerminalVersion.getvalue_by_rowindex_tdclass(
            row,
            columnTerminalVersion['columnTerminalVersionId'].td_class
        )[0].trim();

        if (! id) {
            myJsTableTerminalVersion.setvalue_to_rowindex_tdclass(
                [""],
                row,
                columnTerminalVersion['columnSystemVersion'].td_class
            );
            myJsTableTerminalVersion.setvalue_to_rowindex_tdclass(
                [""],
                row,
                columnTerminalVersion['columnAutoSyncVersion'].td_class
            );
            myJsTableTerminalVersion.setvalue_to_rowindex_tdclass(
                [""],
                row,
                columnTerminalVersion['columnDatabaseVersion'].td_class
            );

            showAddNewDeleteButton(false);
            return;
        }

        if (confirm("Are you sure, you want to delete?")) {
            $.ajax({
                url: "<?=base_url("clientterminaldetails/deleteTerminalVersion")?>",
                type: "POST",
                data: {
                    id: id,
                    clientTerminalId: $("#client-terminal-id").val()
                },
                dataType: "json",
                success: function(response)
                {
                    showVersionTerminalStatus(response, row, id, true);
                },
                complete: function(){
                    updateLogScreen();
                }
            })
        }
    }

    
    //TABLE POS
    var myjstblpos;
    var tabpos = document.createElement('table');
    tabpos.id="tableid2";
    var colarraypos = [];
    var parameterspos = [];
    var colarrayparamspos=["Version","Count"];
    for (var x=0; x<2; x++)
    {
        parameterspos[x] = document.createElement('span');
        colarraypos[colarrayparamspos[x]] = { 
            header_title: colarrayparamspos[x],
            edit: [parameterspos[x]],
            disp: [parameterspos[x]],
            td_class: "tablerow tdall "+"td"+colarrayparamspos[x],
            headertd_class : "tdall"
        };
    }
    
    //TABLE POS STATUS
    var myjstblposstatus;
    var tabposstatus = document.createElement('table');
    tabpos.id="tableid3";
    var colarrayposstatus = [];
    var parametersposstatus = [];
    var colarrayparamsposstatus=["ID","Status"];
    for (var x=0; x<2; x++)
    {
        parametersposstatus[x] = document.createElement('span');
        colarrayposstatus[colarrayparamsposstatus[x]] = { 
            header_title: colarrayparamsposstatus[x],
            edit: [parametersposstatus[x]],
            disp: [parametersposstatus[x]],
            td_class: "tablerow tdall "+"td"+colarrayparamsposstatus[x],
            headertd_class : "tdall"
        };
    }
    
      
        
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
            clientheadid : $("#filterclienthead").val(),
            clientgroupid : $("#filterclientgroup").val()
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
            url: "<?=base_url()?>clientterminaldetails/search_control",
            type: "POST",
            data: {
                clientgroup_mdl: $('#filterclientgroup').val(),
                clienthead_mdl: $('#filterclienthead').val(),
                client_mdl: $('#filterclient').val(),
                terminal_mdl: clientterminalsearch,
                type_mdl: $('#filtertype').val(),
                ver_mdl: $('#filterver').val(),
                clientStatus: $("#filter-client-status").val(),
                clientOrder: $("#filter-client-order").val(),
                buttonToggle: $("#button-toggle").val(),
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
    
    function search_table(rowstart, rowend)
    {  
        $(".tdpermitno").show();
        $(".tdmachineno").show();
        $(".tdserialno").show();
        $(".tdposstatus").show();
        
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
            url: "<?=base_url()?>clientterminaldetails/search_control",
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
                
                /**************** adding a "new entry row" to the last set of data ********************/
                
                var pages_per_query = Number(myjstbl.mypage.mysql_interval) / Number(myjstbl.mypage.filter_number);
                var firstPageOfLastQuery = ( Math.floor(Number(myjstbl.mypage.get_last_page()) / pages_per_query) )*(pages_per_query);
                var current_page = $("#tableid_txtpagenumber").val();
                
                 myjstbl.insert_multiplerow_with_value(1, data.data); 
                //alert(current_page+">"+firstPageOfLastQuery);
                terminalList = data.terminalId;

                if(current_page => firstPageOfLastQuery) 
                {
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
                }
                /**************************************************************************************/

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

        /*$.getJSON("<?=base_url()?>clientterminaldetails/search_control",
        {        
            dev_mdl : $('#filterdev').val(),
            tech_mdl : $('#filtertech').val(),
            clientgroup_mdl : $('#filterclientgroup').val(),
            clienthead_mdl : $('#filterclienthead').val(),
            client_mdl : $('#filterclient').val(),
            type_mdl : $('#filtertype').val(),
            ver_mdl : $('#filterver').val(),
            filterreset: filterreset_val,
            rowstart: row_start_val,
            rowend: row_end_val
            // errorflag_mdl : $('input:radio[name=filtererror]:checked').val(),
            // outdatedflag_mdl : $('input:radio[name=filteroutdated]:checked').val()
        }
        ,
        function(data){
        
            if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')){
                myjstbl.clear_table();
            }
            else{
                myjstbl.clean_table();
            }
            
            if(filterreset_val == 1){
            
                var rowcnt = data.rowcnt;
                if(rowcnt == 0 ){
                    myjstbl.mypage.set_last_page(0);
                }
                else{
                    myjstbl.mypage.set_last_page( Math.ceil(Number(rowcnt) / Number(myjstbl.mypage.filter_number)));
                }
            }
            
            //===================== adding a "new entry row" to the last set of data =====================
            
            var pages_per_query = Number(myjstbl.mypage.mysql_interval) / Number(myjstbl.mypage.filter_number);
            var firstPageOfLastQuery = ( Math.floor(Number(myjstbl.mypage.get_last_page()) / pages_per_query) )*(pages_per_query);
            var current_page = $("#tableid_txtpagenumber").val();
            
            if(current_page > firstPageOfLastQuery) {
                myjstbl.add_new_row();
            }
            
            //===================================================================
            
            myjstbl.insert_multiplerow_with_value(1,data.data); 
            
            
            if($("#showhide").val() == "Show Advance Details"){
                $(".tdpermitno").hide();
                $(".tdmachineno").hide();
                $(".tdserialno").hide();
                $(".tdposstatus").hide();
            }
        });*/
        
        //myjstbl.add_new_row();
        
        
    }
    
    function edit_fnc(x)
    {
        var row_index = $(x).parent().parent().index();
        myjstbl.edit_row(row_index);
    }
    
    var update_fnc_flag = 0;
    function update_fnc(x)
    {
        if(update_fnc_flag != 0) return;
        update_fnc_flag = 1;
          
        var row_index = $(x).parent().parent().index();
        var values_arr = myjstbl.get_row_values(row_index);
        var wid_val = values_arr[colarray["colwid"].td_class][0];
        var branchIdValue = values_arr[colarray["columnBranchId"].td_class][0];
        var clientinfo_val = values_arr[colarray["clientid"].td_class][0];
        var clientinfo_val2 = values_arr[colarray["colclientinfo"].td_class][0];
        var type_val = values_arr[colarray["coltype"].td_class][0];
        var Referenceno_val = values_arr[colarray["colReferenceno"].td_class][0];
        var permitno_val = values_arr[colarray["permitno"].td_class][0];
        var machineno_val = values_arr[colarray["machineno"].td_class][0];
        var serialno_val = values_arr[colarray["serialno"].td_class][0];
        var selposstatus_val = values_arr[colarray['posstatus'].td_class][0];
        var TeamViewerid_val = values_arr[colarray["colTeamViewerid"].td_class][0];
        var TeamViewerpw_val = values_arr[colarray["colTeamViewerpw"].td_class][0];
        var comp_val = values_arr[colarray["colcomp"].td_class][0];
        var mall_val = values_arr[colarray["colmall"].td_class][0];
        var postype_val = values_arr[colarray["colpos"].td_class][0];
        var dateissued_val = values_arr[colarray["colDateIssued"].td_class][0];
        var dateofapp_val = values_arr[colarray["colDateOfApp"].td_class][0];
        var accreditationValue = values_arr[colarray["accreditation"].td_class][0];
        var uuid_val = values_arr[colarray["colUuid"].td_class][0];

        var cur_txttype = myjstbl.getelem_by_rowindex_tdclass(row_index, colarray["colReferenceno"].td_class)[0];

        if(postype_val == 1){
            alert("Please select a valid POS Type");
            update_fnc_flag = 0;
            return;
        }

        if (Referenceno_val != "" && !$.isNumeric(Referenceno_val)) {
            alert("Reference/Terminal No. should be integers only!");
            update_fnc_flag = 0;
            return;
        }
        if (clientinfo_val2 == "") {
            alert("Select client details");
            update_fnc_flag = 0;
            return;
        }

        var data = {
            wid : wid_val,
            branchId: branchIdValue,
            clientID: clientinfo_val,
            clientinfo : clientinfo_val2,
            type : type_val,
            referenceno : Referenceno_val,
            permitno: permitno_val,
            machineno: machineno_val,
            serialno: serialno_val,
            selposstatus: selposstatus_val,
            TeamViewerid : TeamViewerid_val,
            compid : comp_val,
            mallid : mall_val,
            postypeid : postype_val,
            dateissued : dateissued_val,
            dateofapp : dateofapp_val,
            accreditation : accreditationValue,
            uuid : uuid_val,
            TeamViewerpw : TeamViewerpw_val 
        };

        uuid_val.trim();
        if(uuid_val.length > 0)
        {
            $.ajax({
                type: "POST",
                async: true,
                url: "<?=base_url()?>clientterminaldetails/isUuidExist",
                data: {
                    uuid : uuid_val,
                    id   : clientinfo_val
                },  
                success: function(reply) {

                    if(reply == true){
                       alert("UUID already exist") 
                    }
                    else{
                        saveData(data, row_index);
                    }
                }
            });
        }
        else{
            saveData(data, row_index);
        }

        update_fnc_flag = 0;               
    }

    function saveData(ajaxData, row_index)
    {
        var cnt = myjstbl.get_row_count() - 1;
        var fnc = ( ajaxData['wid'] == "0")?"insert_control":"update_control";
        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>clientterminaldetails/"+fnc,
            data: ajaxData,  
            success: function(reply) {
                var data = JSON.parse(reply);

                if (data.errorMessage == "") {
                    myjstbl.update_row(row_index);

                    let selectedIndex
                    if (fnc == "insert_control") {
                        myjstbl.setvalue_to_rowindex_tdclass([cnt], row_index, colarray["count"].td_class);
                        constructTerminalList(data.newClientId);
                        selectedIndex = terminalList.length;
                        isNewRowData = false;
                    } else {
                        selectedIndex = parseInt($.inArray(ajaxData['clientID'], terminalRow));
                    }

                    myjstbl.setvalue_to_rowindex_tdclass([data.newClientId], row_index, colarray["clientid"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([data.newId], row_index, colarray["colwid"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([data.hoverData], row_index, "tablerow tdpopuphover");
                    myjstbl.setvalue_to_rowindex_tdclass([data.uuid], row_index, colarray['colUuid'].td_class);

                    if (ajaxData['wid_val'] == "0") {
                        myjstbl.add_new_row();
                        myjstbl.getelem_by_rowindex_tdclass(
                            myjstbl.get_row_count() - 1,
                            colarray['coldelete'].td_class
                        )[0].style.display = "none";
                        $("." + txtclientinfo.className).last().focus();
                    }

                    terminalList[selectedIndex] = ajaxData['type'];
                } else {
                    alert(data.errorMessage);
                    $(cur_txttype).focus();
                }

                myjstbl.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl.get_row_count() - 1,
                    colarray['columnImageStatus'].td_class
                );
                myjstbl.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl.get_row_count() - 1,
                    colarray['columnImageNotes'].td_class
                );
                updateLogScreen();
            }
        });
    }
    
    function delete_fnc(x) {
        var cnt = myjstbl.get_row_count() - 1;
        var row_index = $(x).parent().parent().index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            row_index,
            colarray['clientid'].td_class
        )[0].trim();
        let selectedIndex = parseInt($.inArray(clientTerminalId, terminalRow));

        if (cnt == row_index && isNewRowData) {
            myjstbl.delete_row(row_index);
            myjstbl.mypage.deleting_row(myjstbl.get_row_count());
            //myjstbl.mypage.deleting_row(myjstbl.get_row_count());
            //myjstbl.insert_row(row_index);
            myjstbl.add_new_row();
            myjstbl.getelem_by_rowindex_tdclass(
                myjstbl.get_row_count() - 1,
                colarray['coldelete'].td_class
            )[0].style.display = "none";

            return;
        }
        
        var src = $(x).parent().parent().children(".tdupdate").children().attr("src");
        var patt = new RegExp("iconupdate");
        if ( patt.test(src) && row_index != cnt ){
            var wid_val = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray["colwid"].td_class);
            $.post("<?=base_url()?>clientterminaldetails/select_control",{   
                    wid : wid_val[0]
                    },
                function(reply) {
                    var datas = reply.split("<nssep>");
                    myjstbl.setvalue_to_rowindex_tdclass([datas[0]], row_index, colarray["colclientinfo"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([datas[1]], row_index, colarray["coltype"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([datas[2]], row_index, colarray["colReferenceno"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([datas[3]], row_index, colarray["colTeamViewerid"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([datas[4]], row_index, colarray["colTeamViewerpw"].td_class);
                    myjstbl.update_row(row_index);
                });
            return;
        }
        
        var wid_val = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray["clientid"].td_class);
        var ptuSrc =  myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray["columnPtuDetails"].td_class);
        var ptu = new RegExp("hasPtu");
        
        if(ptu.test(ptuSrc)){
            alert("Unable to delete, this terminal is already bound to a PTU. Unbind first to delete this data");
        }
        else{
            if (confirm("Are you sure you want to delete this?"))
            {
                $.post("<?=base_url()?>clientterminaldetails/delete_control", 
                    {   wid : wid_val[0]    },
                    function(reply) {
                        updateLogScreen();
                        constructTerminalList(wid_val[0], true);
                        delete terminalList[selectedIndex];
                        delete terminalRow[selectedIndex];
                        clientTerminalTable.deleteRow(parseInt($("#tableid_txtpagenumber").val()));
                    });
            }
        }
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

    var update_fnc_flag = 0;
    function saveDetails(){
        if(update_fnc_flag != 0) return;
        update_fnc_flag = 1;

        var dateOfApplicationValue = $("#dateOfApplication").val();
        var teamviewerIDValue = $("#teamviewerID").val();
        var installationTypeValue = $("#installationType").val();
        var clientTerminalDetailsIDValue = $("#clientTerminalDetailsID").val();
        var rowIndexValue = $("#rowIndex").val();

        if(teamviewerIDValue.length < 9){
            alert("Invalid Teamviewer ID");
            update_fnc_flag = 0;
            return;
        }

        var fnc = "saveDetails_control";       
        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>clientterminaldetails/"+fnc,
            data: {
                id : clientTerminalDetailsIDValue,
                dateOfApplication : dateOfApplicationValue,
                teamViewerID : teamviewerIDValue,
                installationType: installationTypeValue
            },  
            success: function(reply) {
                var data = JSON.parse(reply);
                if (data.errorMessage == "") {
                    $("#detailgroup").modal("hide");
                    myjstbl.setvalue_to_rowindex_tdclass([dateOfApplicationValue], rowIndexValue, colarray["colDateOfApp"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([teamviewerIDValue], rowIndexValue, colarray["colTeamViewerid"].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                        $("#row-index-status").val(),
                        colarray['columnImageStatus'].td_class
                    );
                    myjstbl.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                        $("#row-index-notes").val(),
                        colarray['columnImageNotes'].td_class
                    );
                    myjstbl.setvalue_to_rowindex_tdclass([data.hoverData], rowIndexValue, "tablerow tdpopuphover");
                } else {
                    alert(data.errorMessage);
                }
                update_fnc_flag = 0;
                updateLogScreen();
            }
        });


    }

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

    $('#delete-notes').live('click', function()
    {
        $('#label-status-notes').css('visibility', 'hidden');
        var rowIndexNotes = $(this).parent().parent().index();
        var idValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnId'].td_class
        )[0];
        var idHiddenValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnHiddenId'].td_class
        )[0];
        var clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            $("#row-index-notes").val(),
            colarray['clientid'].td_class
        )[0];
        var notesValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnNotes'].td_class
        )[0];

        if (idHiddenValue == "") {
            return;
        }
        var answer = confirm("Are you sure you want to delete?");
        if (answer) {
            $("#label-status-notes").css("visibility", "visible");

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientterminaldetails/deleteClientNotes",
                data: {
                    id: idValue,
                    hiddenId: idHiddenValue,
                    clientId: clientTerminalId,
                    notes: notesValue
                },
                success: function(data)
                {
                    myJsTableNotes.delete_row(rowIndexNotes);
                    $("#label-status-notes").text("Successfully Removed!");
                    myjstbl.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+notesImages[data]+"' style='height: 20px; width: 20px;'>"],
                        $("#row-index-notes").val(),
                        colarray['columnImageNotes'].td_class
                    );
                    $(".text-notes").focus();
                },
                complete: function()
                {
                    updateLogScreen();
                }
            });
        }
    });

    function clientNotesTable(rowstart, rowend)
    {
        if ((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')) {
            myJsTableNotes.clear_table();
        } else {
            myJsTableNotes.clean_table();
        }
        myJsTableNotes.add_new_row();

        $.ajax(
        {
            url: "<?=base_url()?>clientterminaldetails/displayClientNotes",
            type: "POST",
            data: {
                id: myjstbl.getvalue_by_rowindex_tdclass(
                    $("#row-index-notes").val(),
                    colarray['clientid'].td_class
                )[0]
            },
          success: function(data)
          {
            $("#label-status-notes").text("");
            if ((typeof rowstart === 'undefined') && (typeof rowend === 'undefined')) {
                myJsTableNotes.clear_table();
            } else {
                myJsTableNotes.clean_table();
            }
            myJsTableNotes.add_new_row();
            myJsTableNotes.insert_multiplerow_with_value(1, data.data);
            myJsTableNotes.setvalue_to_rowindex_tdclass(
                ["Char. left:2000"],
                myJsTableNotes.get_row_count() - 1,
                columnArrayNotes['columnCharactersLeft'].td_class
            );
            $("#table-notes-id").wrap("<div class='scrollable'></div>");
          }
        });
    }

    function loadClientVersionTerminal(clientTerminalId)
    {
        $.ajax({
            url: "<?=base_url("clientterminaldetails/getTerminalVersionDetails")?>",
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
            myJsTableTerminalVersion.clear_table();
        } else {
            myJsTableTerminalVersion.clean_table();
        }
        myJsTableTerminalVersion.add_new_row();

        $.ajax({
            url: "<?=base_url("clientterminaldetails/getTerminalVersionList")?>",
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
                    myJsTableTerminalVersion.clear_table();
                } else {
                    myJsTableTerminalVersion.clean_table();
                }

                myJsTableTerminalVersion.add_new_row();
                myJsTableTerminalVersion.insert_multiplerow_with_value(1, terminalList);

                showAddNewDeleteButton(false);
                $("#table-version-id").wrap("<div class='scrollable'></div>");
            }
        });
    }

    function showTerminalVersion(selectedObject)
    {
        let rowIndex = $(selectedObject).parents("tr").index();
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

        if (! myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray['count'].td_class)[0]) {
            alert("Please save row first before you can change Sys/Au/DB Ver.");
            return;
        }

        $('#client-version').modal("show");
        loadClientVersionTerminal(clientTerminalId);
    }

    function addClientNotes(notes)
    {
        var rowIndex = $(notes).parents("tr").index();
        var clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0];

        if (myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray['count'].td_class)[0] == "") {
            alert("Please save row first before you can change notes");
            return;
        }

        $("#row-index-notes").val(rowIndex);
        $('#client-notes').modal("show");
        clientNotesTable();
    }

    function saveClientNotes(notes)
    {
        var rowIndexNotes = $(notes).parents("tr").index();
        var idHiddenValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnHiddenId'].td_class
        )[0];
        var idValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnId'].td_class
        )[0];
        var notesValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnNotes'].td_class
        )[0];
        var referenceValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
            rowIndexNotes,
            columnArrayNotes['columnReference'].td_class
        )[0];
        var clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            $("#row-index-notes").val(),
            colarray['clientid'].td_class
        )[0];

        if (notesValue == "" || (notesValue == "" && referenceValue == "")) {
            alert("Notes field is required.");
            return;
        }

        if (notesValue.trim().length == 0) {
            alert("Notes cannot contain white spaces only.");
            return;
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url()?>clientterminaldetails/saveClientNotes",
            data: {
                hiddenId: idHiddenValue,
                id: idValue,
                clientId: clientTerminalId,
                notes: notesValue,
                reference: referenceValue
            },
            success: function(data)
            {
                if (idHiddenValue != "") {
                    $("#label-status-notes").text("Successfully Updated!");
                } else {
                    $("#label-status-notes").text("Successfully Added!");
                    myJsTableNotes.setvalue_to_rowindex_tdclass(
                        [data.rowCountId],
                        rowIndexNotes,
                        columnArrayNotes['columnId'].td_class
                    );
                    myJsTableNotes.add_new_row();
                }

                var pagesPerQuery =
                    Number(myJsTableNotes.mypage.mysql_interval) / Number(myJsTableNotes.mypage.filter_number);
                var firstPageOfLastQuery =
                    (Math.floor(Number(myJsTableNotes.mypage.get_last_page()) / pagesPerQuery) ) * (pagesPerQuery);
                var currentPage = $("#table-notes-id_txtpagenumber").val();
                if (currentPage >= firstPageOfLastQuery) {
                        myJsTableNotes.insert_multiplerow_with_value(1, data.data);
                }

                myJsTableNotes.mypage.go_to_last_page();
                myJsTableNotes.update_row(rowIndexNotes);
                myJsTableNotes.setvalue_to_rowindex_tdclass(
                    [data.rowId],
                    rowIndexNotes,
                    columnArrayNotes['columnHiddenId'].td_class
                );
                myJsTableNotes.setvalue_to_rowindex_tdclass(
                    [""],
                    rowIndexNotes,
                    columnArrayNotes['columnCharactersLeft'].td_class
                );
                myJsTableNotes.setvalue_to_rowindex_tdclass(
                    ["Char. left:2000"],
                    myJsTableNotes.get_row_count() - 1,
                    columnArrayNotes['columnCharactersLeft'].td_class
                );
                myjstbl.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[1]+"' style='height: 20px; width: 20px;'>"],
                    $("#row-index-notes").val(),
                    colarray['columnImageNotes'].td_class
                );
                $(".text-notes").focus();
            },
            complete: function()
            {
                updateLogScreen();
            }
        });
    }

    function changeStatus(status)
    {
        var status = $(status).children();
        var rowIndex = status.parents("tr").index();
        var imageFileName = status.prop("src").substring(status.prop("src").lastIndexOf('/') + 1);
        var value = statusImages.indexOf(imageFileName);

        if (myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray['count'].td_class)[0] == "") {
            alert("Please save row first before you can change the status");
            return;
        }

        $("#row-index-status").val(rowIndex);
        if (value) {
            $("#label-status").text('Do you want to change the status to "Inactive"?');
        } else {
            $("#label-status").text('Do you want to change the status to "Active"?');
        }
        $("#client-status").modal("show");
    }

    function redirect(status){
        var status = $(status).children();
        var rowIndex = status.parents("tr").index();
        $("#row-index-status").val(rowIndex);
        var clientDetailsId = myjstbl.getvalue_by_rowindex_tdclass(
            $("#row-index-status").val(),

            colarray['clientid'].td_class
        )[0];

        window.open("/unitstatusreport?terminalid=" + clientDetailsId);
    }

    function saveStatus()
    {
        var clientDetailsId = myjstbl.getvalue_by_rowindex_tdclass(
            $("#row-index-status").val(),
            colarray['clientid'].td_class
        )[0];
        var statusValue = myjstbl.getvalue_by_rowindex_tdclass(
            $("#row-index-status").val(),
            colarray['columnImageStatus'].td_class
        )[0];
        if (statusValue.indexOf('green_status.png') >= 0) {
            statusValue = 0;
        } else {
            statusValue = 1;
        }

        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>clientterminaldetails/saveStatus",
            data: {
                id: clientDetailsId,
                status: statusValue
            },
            success: function(data)
            {
                var imageFileName = statusImages[statusValue];

                myjstbl.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+imageFileName+"' style='height: 20px; width: 20px;'>"],
                    $("#row-index-status").val(),
                    colarray['columnImageStatus'].td_class
                );
                $("#client-status").modal("hide");

                updateLogScreen();
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

    function getPtuDetails()
    {
        $.ajax({
            url: "<?=base_url("clientterminaldetails/getPtuDetails")?>",
            type: "POST",
            data: {clientTerminalId: $("#ptu-details-terminal-id").val()},
            dataType: "json",
            success: function(data)
            {
                $("input[name='permit-number']").val(data.permit_number);
                $("input[name='min-number']").val(data.min_number);
                $("input[name='serial-number']").val(data.serial_number);
                $("input[name='effectivity-date']").val(data.effectivity_date);
                $("select[name='accreditation-number']").val(data.accreditation_number);
                $("#ptu-details-bind-terminal").val(data.bind_terminal);
                getAccreditationSetValue($("select[name='accreditation-number']"));
                $("#table-ptu-details").find("input, select").attr("disabled", "disabled");

                $position = (<?=$PositionId?>);
                if (($position == 7)||($position == 8)||($position == 9)) {
                } else {
                    $(".save-ptu-details").hide();
                }
                if (parseInt(data.bind_terminal)) {
                    $(".save-ptu-details").hide();
                }
            }
        });
    }

    function terminalManagerTable(rowstart, rowend)
    {
        $.ajax({
            url: "<?=base_url("clientterminaldetails/getTerminalManagerData")?>",
            type: "POST",
            data: {
                clientTerminalId: $("#terminal-manager-terminal-id").val()
            },
            dataType: "json",
            success: function(response)
            {
                let terminalList = response.list;
                $("#label-status-version").text("");
                $("#table-terminal-manager-id").wrap("<div style='overflow-x: auto'></div>");

                let defaultImage = (terminalList.length) ? "" : "-default";
                let isInRow = $.inArray($("#terminal-manager-terminal-id").val(), terminalRow);
                let rowIndex = ($.inArray($("#terminal-manager-terminal-id").val(), terminalRow)) + 1;
                let permitNumberValue = "";
                let serialNumberValue = "";
                let minValue = "";
                let terminalManagerTableList  = "\
                    <table width=\"100%\" border=\"1\" style=\"border-collapse: collapse;\">\
                ";
                let rowList = [
                    'Client Terminal ID',
                    'TRM#',
                    'Branch ID',
                    'SQL Port',
                    'Business Name',
                    'Owner',
                    'Address',
                    'Tin',
                    'Accreditation',
                    'Permit No.',
                    'S/N',
                    'Min',
                    'Vat Status',
                    'Approval Date',
                    'Date Modified'
                ];

                if (Object.keys(terminalList).length) {
                    let terminalManagerData = terminalList[0];
                    permitNumberValue = terminalManagerData[9];
                    serialNumberValue = terminalManagerData[10];
                    minValue = terminalManagerData[11];

                    let borderStyle = "padding-left: 10px; background-color: #026391; color: white;";
                    for (key in terminalManagerData) {
                        terminalManagerTableList += "\
                            <tr>\
                                <td style=\""+ borderStyle +"\" width=\"20%\">\
                                    <b>"+ rowList[key] +":</b>\
                                </td>\
                                <td>"+ terminalManagerData[key] +"</td>\
                            </tr>\
                        ";
                    }

                    if (rowIndex != 0) {
                        var permitNumberTableValue = myjstbl.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            colarray['permitno'].td_class
                        )[0];

                        var serialNumberTableValue = myjstbl.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            colarray['serialno'].td_class
                        )[0];

                        var minTableValue = myjstbl.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            colarray['machineno'].td_class
                        )[0];

                        if (
                            permitNumberValue != permitNumberTableValue
                            || serialNumberValue != serialNumberTableValue
                            || minValue != minTableValue
                        ) {
                            defaultImage = "-error";
                        }
                        for (key in terminalManagerData) {
                            let value = terminalManagerData[key][0];
                            if (! value) {
                                defaultImage = "-error";
                            }
                        }
                    }
                } else {
                    terminalManagerTableList += "\
                        <tr>\
                            <td style=\"text-align: center; font-size: 18px;\">\
                                <b>No Data</b>\
                            </td>\
                        </tr>\
                    ";
                }
                terminalManagerTableList += "</table>";
                $("#table-terminal-manager").html(terminalManagerTableList);

                if (rowIndex != 0) {
                    let toolTipValue = "tooltip-value=\""+minValue+"~u~"+serialNumberValue+"~u~"+permitNumberValue+"\"";
                    let imageVersion = "\
                        <center>\
                            <img src='assets/images/terminal-version"+defaultImage+".png' "+toolTipValue+" style='height: 20px; width: 20px;'>\
                        </center>\
                    ";

                    myjstbl.setvalue_to_rowindex_tdclass(
                        [imageVersion],
                        rowIndex,
                        colarray['columnTerminalManager'].td_class
                    );
                }
            }
        });
    }

    /**
     * Get accreditation set value
     * @param  {object}  select  [select element]
     */
    function getAccreditationSetValue(select)
    {
        let value = $(select).val();
        let setValue = $(select).find("[value='"+value+"']").attr("set-value").split("~u~");
        for (key in setValue) {
            $(".accreditation-isset-value")[key].innerHTML = setValue[key];
        }
    }

    /**
     * View PTU Details info by using Terminal ID.
     * @params  {object}  clientTerminalId  [Selected element object]
     */
    function loadPtuDetails(clientTerminalId)
    {
        $.ajax({
            url: "<?=base_url("clientterminaldetails/getTerminalVersionDetails")?>",
            type: "POST",
            data: {
                clientTerminalId: clientTerminalId,
                type: "ptu"
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                isSavePtuDetails = false;
                $("#ptu-details-terminal-id").val(clientTerminalId);
                $("#text-ptu-details-client-info").html(response.full_client_name);
                $("#text-ptu-details-client-terminal").html("Terminal No. "+ response.reference_number);

                let options = "";
                for ([key, data] of response.accreditation.entries()) {
                    options +="<option value=\""+data.value+"\" set-value=\""+data.setValue+"\">";
                    options += data.description;
                    options += "</option>";
                }
                $("select[name='accreditation-number']").html(options);
                $("select[name='accreditation-number']").unbind("change").change(function()
                {
                    getAccreditationSetValue(this);
                });

                $("input[name='effectivity-date']").datepicker({dateFormat: 'yy-mm-dd'});

                $(".save-ptu-details").show();
                $(".save-ptu-details").attr("src", "assets/images/iconedit.png");
                $(".save-ptu-details").unbind("click").click(function()
                {
                    if (isSavePtuDetails) {
                        return;
                    }

                    let image = $(this).attr("src");
                    if (image == "assets/images/iconedit.png") {
                        $(this).attr("src", "assets/images/iconupdate.png");
                        $("#table-ptu-details").find("input, select").removeAttr("disabled");
                    } else {
                        isSavePtuDetails = true;
                        let formdata = {
                            clientTerminalId: $("#ptu-details-terminal-id").val(),
                            permitNumber: $("input[name='permit-number']").val(),
                            minNumber: $("input[name='min-number']").val(),
                            serialNumber: $("input[name='serial-number']").val(),
                            effectivityDate: $("input[name='effectivity-date']").val(),
                            accreditation: $("select[name='accreditation-number']").val(),
                            accreditationDescription: $("select[name='accreditation-number']")
                                .find("option:selected")
                                .html()
                        };

                        $.ajax({
                            url: "<?=base_url("clientterminaldetails/savePtuDetails")?>",
                            type: "POST",
                            data: formdata,
                            success: function(response)
                            {
                                let rowIndex = ($.inArray($("#ptu-details-terminal-id").val(), terminalRow)) + 1;
                                alert(response);
                                isSavePtuDetails = false;

                                if (response == "Successfully saved") {
                                    $(".save-ptu-details").attr("src", "assets/images/iconedit.png");
                                    $("#table-ptu-details").find("input, select").attr("disabled", "disabled");

                                    let image = "src='assets/images/terminal-version-default.png'";
                                    if (
                                        $("input[name='permit-number']").val()
                                        || $("input[name='min-number']").val()
                                        || $("input[name='serial-number']").val()
                                        || $("input[name='effectivity-date']").val() != "0000-00-00"
                                        || parseInt($("select[name='accreditation-number']").val()) != 1
                                    ) {
                                        image = "src='assets/images/terminal-version.png'";
                                    }

                                    let tooltipValue = "tooltip-value=\"";
                                    tooltipValue += $("input[name='min-number']").val()+"~u~";
                                    tooltipValue += $("input[name='serial-number']").val()+"~u~";
                                    tooltipValue += $("input[name='permit-number']").val();
                                    tooltipValue +="\"";

                                    let imageElement = "\
                                        <center>\
                                            <img "+image+" "+tooltipValue+" style='height: 20px; width: 20px;'>\
                                        </center>\
                                    ";

                                    myjstbl.setvalue_to_rowindex_tdclass(
                                        [imageElement],
                                        rowIndex,
                                        colarray['columnPtuDetails'].td_class
                                    );
                                    myjstbl.setvalue_to_rowindex_tdclass(
                                        [$("input[name='permit-number']").val()],
                                        rowIndex,
                                        colarray['permitno'].td_class
                                    );
                                    myjstbl.setvalue_to_rowindex_tdclass(
                                        [$("input[name='min-number']").val()],
                                        rowIndex,
                                        colarray['machineno'].td_class
                                    );
                                    myjstbl.setvalue_to_rowindex_tdclass(
                                        [$("input[name='serial-number']").val()],
                                        rowIndex,
                                        colarray['serialno'].td_class
                                    );
                                }

                                updateLogScreen();
                            }
                        });
                    }
                });

                findPtuDetailsPreviousNextArrayIndex(clientTerminalId);
                getPtuDetails();
            }
        });
    }

    /**
     * View Terminal Manager info by using Terminal ID.
     * @params  {object}  clientTerminalId  [Selected element object]
     */
    function loadTerminalManagerData(clientTerminalId)
    {
        $.ajax({
            url: "<?=base_url("clientterminaldetails/getTerminalVersionDetails")?>",
            type: "POST",
            data: {
                clientTerminalId: clientTerminalId
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                $("#terminal-manager-terminal-id").val(clientTerminalId);
                $("#text-terminal-manager-client-info").html(response.full_client_name);
                $("#text-terminal-manager-client-terminal").html("Terminal No. "+ response.reference_number);

                findTerminalManagerPreviousNextArrayIndex(clientTerminalId);
                terminalManagerTable();
            }
        });
    }

    /**
     * Get Previous and Next PTU Details ID
     * @params  {string}  currentTerminalId  [Selected terminal id]
     */
    function findPtuDetailsPreviousNextArrayIndex(currentTerminalId)
    {
        $(".div-ptu-details-previous, .div-ptu-details-next, .left-arrow").show();
        $(".div-ptu-details-previous").removeAttr("style");

        let currentIndex = "";
        for (index in terminalList) {
            if (currentTerminalId == terminalList[index]) {
                let selectedIndex = parseInt(index) + 1;
                $("#ptu-details-row-index").val(selectedIndex);
                currentIndex = parseInt(index);
            }
        }

        if ((currentIndex - 1)  == -1) {
            if ((currentIndex + 1) != terminalList.length) {
                $(".left-arrow").hide();
                $(".div-ptu-details-previous").css({"min-width": "100px", "min-height": "100px"});
            } else {
                $(".div-ptu-details-previous").hide();
            }
        }

        if ((currentIndex + 1) == terminalList.length) {
            $(".div-ptu-details-next").hide();
        }
    }

    /**
     * Get Previous and Next Terminal ID
     * @params  {string}  currentTerminalId  [Selected terminal id]
     */
    function findTerminalManagerPreviousNextArrayIndex(currentTerminalId)
    {
        $(".div-terminal-manager-previous, .div-terminal-manager-next, .left-arrow").show();
        $(".div-terminal-manager-previous").removeAttr("style");

        let currentIndex = "";
        for (index in terminalList) {
            if (currentTerminalId == terminalList[index]) {
                let selectedIndex = parseInt(index) + 1;
                $("#terminal-manager-row-index").val(selectedIndex);
                currentIndex = parseInt(index);
            }
        }

        if ((currentIndex - 1)  == -1) {
            if ((currentIndex + 1) != terminalList.length) {
                $(".left-arrow").hide();
                $(".div-terminal-manager-previous").css({"min-width": "100px", "min-height": "100px"});
            } else {
                $(".div-terminal-manager-previous").hide();
            }
        }

        if ((currentIndex + 1) == terminalList.length) {
            $(".div-terminal-manager-next").hide();
        }
    }

    /**
     * Show PTU Details modal
     * @params  {object}  selectedObject  [Selected element object]
     */
    function showPtuDetails(selectedObject)
    {
        let rowIndex = $(selectedObject).parents("tr").index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();

        if (! myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray['count'].td_class)[0]) {
            alert("Please save row first before you can change PTU Details.");
            return;
        }

        $('#ptu-details-dialog').modal("show");
        loadPtuDetails(clientTerminalId);
    }

    /**
     * Show Terminal Manager modal
     * @params  {object}  selectedObject  [Selected element object]
     */
    function showTerminalManagerDialogs(selectedObject)
    {
        let rowIndex = $(selectedObject).parents("tr").index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();

        if (! myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray['count'].td_class)[0]) {
            alert("Please save row first before you can view Terminal Manager PTU Report.");
            return;
        }

        $('#terminal-manager-dialog').modal("show");
        loadTerminalManagerData(clientTerminalId);
    }

    $(".td-terminal-manager-hover, .td-ptu-details").live("mouseenter, mousemove", function(event)
    {
        let tooltipValue = $(this).find("img").attr("tooltip-value");
        [min, serialNumber, permitNumber] = tooltipValue.split("~u~");
        let tableContent = '\
            <table style="border-collapse: collapse; width: 100%;">\
                <thead>\
                    <tr class="tableheader">\
                        <td class="td-center" width="100px">Permit No.</td>\
                        <td class="td-center" width="100px">Min No.</td>\
                        <td class="td-center" width="100px">Serial No.</td>\
                    </tr>\
                </thead>\
                <tbody id="popup-tbody">\
                    <tr class="row-popup">\
                        <td class="td-center">'+ permitNumber +'</td>\
                        <td class="td-center">'+ min +'</td>\
                        <td class="td-center">'+ serialNumber +'</td>\
                    </tr>\
                </tbody>\
            </table>\
        ';
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
        let style = "left: "+nodeX+"px; top: "+nodeY+"px; display: block; width: auto;";
        if (min || serialNumber || permitNumber) {
            $("#popup-display").html(tableContent).attr("style", style);
        }

    }).live("mouseleave", function(event)
    {
        $("#popup-display").css("display", "none");
    });

    /**
     * Get Previous and Next Terminal ID
     * @params  {string}  currentTerminalId  [Selected terminal id]
     */
    function findAutoSyncSettingPreviousNextArrayIndex(currentTerminalId)
    {
        $(".div-autosync-status-previous, .div-autosync-status-next").show();

        let currentIndex = "";
        for (index in terminalList) {
            if (currentTerminalId == terminalList[index]) {
                let selectedIndex = parseInt(index) + 1;
                $("#autosync-status-row-index").val(selectedIndex);
                currentIndex = parseInt(index);
            }
        }

        if ((currentIndex - 1)  == -1) {
            $(".div-autosync-status-previous").hide();
        }

        if ((currentIndex + 1) == terminalList.length) {
            $(".div-autosync-status-next").hide();
        }
    }

    /**
     * load auto sync setting
     * @params  {string}  currentTerminalId  [Selected terminal id]
     */
    function loadAutoSyncSetting(clientTerminalId)
    {
        $.ajax({
            url: "<?=base_url("clientterminaldetails/getAutoSyncSettingData")?>",
            type: "POST",
            data: {
                clientTerminalId: clientTerminalId
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                $("#autosync-status-terminal-id").val(clientTerminalId);
                $("#text-autosync-status-client-info").html(response.header.full_client_name);
                $("#text-autosync-status-client-terminal").html("Terminal No. "+ response.header.reference_number);

                let setting = response.setting;
                autoSyncSettingTable = "<table width=\"100%\" border=\"1\" style=\"border-collapse: collapse;\">";

                let counter = 0;
                for (index in response.sortDisplay) {
                    let code = response.sortDisplay[index];
                    if (setting[code.key] != undefined) {
                        let borderStyle = "padding-left: 10px; background-color: #026391; color: white;";
                        autoSyncSettingTable += "\
                            <tr>\
                                <td style=\""+ borderStyle +"\" width=\"35%\">\
                                    <b>"+ code.description +":</b>\
                                </td>\
                                <td>"+ setting[code.key] +"</td>\
                            </tr>\
                        ";
                        counter++;
                    }
                }

                if (counter == 0) {
                    autoSyncSettingTable += "\
                        <tr>\
                            <td style=\"text-align: center; font-size: 18px;\">\
                                <b>No Data</b>\
                            </td>\
                        </tr>\
                    ";
                }
                autoSyncSettingTable += "</table>";

                $("#autosync-setting-content").html(autoSyncSettingTable);
                findAutoSyncSettingPreviousNextArrayIndex(clientTerminalId);
            }
        });

    }

    /**
     * show Auto Sync Setting
     * @params {object} selectedObject [selected element object]
     */
    function showAutoSyncSetting(selectedObject)
    {
        let rowIndex = $(selectedObject).parents("tr").index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();

        if (! myjstbl.getvalue_by_rowindex_tdclass(rowIndex, colarray['count'].td_class)[0]) {
            alert("Please save row first before you can view AutoSync Setting.");
            return;
        }

        $('#autosync-status-dialog').modal("show");
        loadAutoSyncSetting(clientTerminalId);
    }

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

    /**
     * Get Previous and Next Terminal ID
     * @params  {string}  currentTerminalId  [Selected terminal id]
     */
    function findServerPosSettingPreviousNextArrayIndex(currentTerminalId)
    {
        $(".div-server-pos-setting-previous, .div-server-pos-setting-next").show();

        let currentIndex = "";
        for (index in terminalList) {
            if (currentTerminalId == terminalList[index]) {
                let selectedIndex = parseInt(index) + 1;
                $("#server-pos-setting-row-index").val(selectedIndex);
                currentIndex = parseInt(index);
            }
        }

        if ((currentIndex - 1)  == -1) {
            $(".div-server-pos-setting-previous").hide();
        }

        if ((currentIndex + 1) == terminalList.length) {
            $(".div-server-pos-setting-next").hide();
        }
    }

    /**
     * load Server/POS Setting data
     * @params {object} selectedObject [selected element object]
     */
    function loadServerPosSettingData(action = 0, isLoadHeader = true)
    {
        let clientTerminalId = $("#server-pos-setting-terminal-id").val();
        let clientType = $("#server-pos-setting-terminal-type").val();
        let displayTo = $("#server-pos-setting-tabs").find(".tabs-content");

        if (isLoadHeader) {
            $("#text-server-pos-setting-client-info").html("");
            $("#text-server-pos-setting-client-terminal").html("");
        }

        $(".ul-tabs").find("li").removeAttr("class");
        action = (clientType == 3 && ! action) ? 1 : action;
        $(".ul-tabs").find("a[action='"+action+"']").parent().attr("class", "active");

        let loading = "\
            <img src='assets/images/loading.gif' alt='loading' style='display: block;' id='loadimgdetail'>\
        ";
        displayTo.html(loading);

        $.ajax({
            url: "<?=base_url("clientterminaldetails/getServerPosSettingData")?>",
            type: "POST",
            data: {
                clientTerminalId: clientTerminalId,
                action: action
            },
            dataType: "json",
            success: function(response)
            {
                if (isLoadHeader) {
                    let clientName = response.header.full_client_name;
                    let referenceNumber = response.header.reference_number;
                    $("#server-pos-setting-terminal-id").val(clientTerminalId);
                    $("#text-server-pos-setting-client-info").html(clientName);
                    $("#text-server-pos-setting-client-terminal").html("Terminal No. "+ referenceNumber);
                }

                let serverPosTable  = "<table width=\"100%\" border=\"1\" style=\"border-collapse: collapse;\">";
                response.setting = (clientType == 4) ? [] : response.setting;

                for (key in response.setting) {
                    info = response.setting[key];
                    let borderStyle = "padding-left: 10px; background-color: #026391; color: white;";

                    if (info.description == "~add row space~") {
                        serverPosTable += "\
                            <tr>\
                                <td colspan=\"2\">&nbsp;</td>\
                            </tr>\
                        ";
                    } else {
                        serverPosTable += "\
                            <tr>\
                                <td style=\""+ borderStyle +"\" width=\"20%\">\
                                    <b>"+ info.description +":</b>\
                                </td>\
                                <td>"+ info.value +"</td>\
                            </tr>\
                        ";
                    }
                }

                if (! response.setting.length) {
                    serverPosTable += "\
                        <tr>\
                            <td style=\"text-align: center; font-size: 18px;\">\
                                <b>No Data</b>\
                            </td>\
                        </tr>\
                    ";
                }
                serverPosTable += "</table>";
                displayTo.html(serverPosTable);
            }
        });

        findServerPosSettingPreviousNextArrayIndex(clientTerminalId);
    }

    /**
     * show Server/POS Setting
     * @params {object} selectedObject [selected element object]
     */
    function showServerPosSetting(selectedObject)
    {
        let row = $(selectedObject).parents("tr");
        let rowIndex = $(selectedObject).parents("tr").index();
        let clientTerminalId = myjstbl.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray['clientid'].td_class
        )[0].trim();
        let clientType = row.find(".seltype").val();
        let typeList = ["", "Server", "Server/POS", "POS", "Office Computer"];

        if (! typeList[clientType]) {
            return;
        }

        let titleSetting = typeList[clientType] +"/Database/Hardware Setting and Unit Specifications";
        $('#server-pos-setting-dialog').find(".modal-title").html("TM Report - "+ titleSetting);
        $("#server-pos-setting-tabs, #server-pos-setting-content").hide();
        $("#server-pos-setting-terminal-id").val(clientTerminalId);
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

        $('#server-pos-setting-dialog').modal("show");
        loadServerPosSettingData();
    }

    $(".tab-server, .tab-pos, .tab-database, .tab-hardware, .tab-unit").live("click", function(event)
    {
        let action = parseInt($(this).attr("action"));
        loadServerPosSettingData(action, false);

        event.preventDefault();
    });
</script>

