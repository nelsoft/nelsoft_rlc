<script language="javascript" type="text/javascript"> 

<?php 
    $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
    $clientheadid = isset($_GET['clientheadid'])?$_GET['clientheadid']:"";
    $clientdetailid= isset($_GET['clientdetailid'])?$_GET['clientdetailid']:"0";
    $clientSetup = isset($_GET['setup']) ? $_GET['setup'] : "";
    $clientStatus = isset($_GET['status']) ? $_GET['status'] : "";
    $isManagementPosition = $_SESSION["position_id"] == 7;
    $isAccountingPosition = $_SESSION["position_id"] == 3;
?>

    var fileSizeLimit = 7000000;
    var updaterecord_flag = 0;
    var ptuIdValue = 0;
    var edit_flag = 0;

    var globalFunction;
    var globalRowIndex;
    var globalId;
    var globalClientInfo;
    var globalBranchId;
    var globalBranchName;
    var globalBranchCode;
    var globalAddress;
    var globalTin;
    var globalTinCode4;
    var globalVatStatus;
    var globalLocationId;
    var globalSelectTechAssigned;
    var globalDateStart;
    var globalDateStop;
    var globalisChinese;
    var globalFreepoint;
    var globalCollectionType;
    var globalMonthlyCharge;
    var globalIsOutlet;
    var globalIsStillUsed;
    var globalHeadId;
    var globalNetworkId;
    var globalDuplicatePTUHead;
    var globalDuplicatePTUDetails;
    var globalExpiredStillUsed;
    var fileList = [];
    var tempDeletefileID = [];
    var setupImages = ["automatic.png", "dual_pos.png", "posd.png"];
    var notesImages = ["without_notes.png", "notes.ico"];
    var statusImages = ["red_status.png", "green_status.png"];
    var messagePtuUpload = "";
    var selectExistingTerminal = [];
    var selectOtherBranchTerminal = [];
    var globalTerminalNumber = [];
    var globalMinNumber = [];
    var globalSerialNumber = [];

    // P.U.L Table
    var myjstbl_pul;
    var tab_pul = document.createElement('table');
    tab_pul.id="tableid_pul";
    tab_pul.className = "table table-bordered";
    var isFirstLoad = true;
    var colarray_pul = [];

    var imageStatus = document.createElement('span');
    imageStatus.setAttribute("id", "image-status");
    imageStatus.setAttribute("onclick", "changeStatus(this)");
    imageStatus.style.cursor = "pointer";
    colarray_pul['columnImageStatus'] = {
        header_title: "",
        edit: [imageStatus],
        disp: [imageStatus],
        td_class: "tablerow td-image-status"
    };

    var id_pul = document.createElement('a');
    id_pul.setAttribute("href","javascript:;");
    id_pul.className = 'spnid_cnt';
    id_pul.setAttribute("target","_blank");
    id_pul.setAttribute("onclick","todetails_fnc(this)");
    colarray_pul['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid2 tdpopuphover",
        headertd_class : "tdclick tdid"
    };

    var spanClientId = document.createElement("span");
    colarray_pul['columnClientId'] = {
        header_title: "",
        edit: [spanClientId],
        disp: [spanClientId],
        td_class: "tablerow td-client-id",
        headertd_class : "td-client-id"
    };

    var spanNetworkID = document.createElement("span");
    colarray_pul['columnNetworkId'] = {
        header_title: "Network ID",
        edit: [spanNetworkID],
        disp: [spanNetworkID],
        td_class: "tablerow tdid",
        headertd_class : "tdid"
    };

    var spanClient = document.createElement("span");
    var textClient = document.createElement("input");
    textClient.type = "text";
    textClient.className = "text-client";
    colarray_pul['columnClient'] = {
        header_title: "Network",
        edit: [textClient],
        disp: [spanClient],
        td_class: "tablerow tdclientinfo",
        headertd_class : "tdclientinfo"
    };

    var spnbranchid = document.createElement('span');
    var txtbranchid = document.createElement('input');
    txtbranchid.type = "text";
    txtbranchid.id = 'idtxtbranchid';
    txtbranchid.className = 'txtbranchid';
    colarray_pul['branchid'] = { 
        header_title: "B. ID",
        edit: [txtbranchid],
        disp: [spnbranchid],
        td_class: "tablerow tdbranchid",
        headertd_class : "hdbranchid tdclick"
    };

    var spnbranchname = document.createElement('span');
    var txtbranchname = document.createElement('input');
    txtbranchname.type = "text";
    txtbranchname.id = 'idtxtbranchname';
    txtbranchname.className = 'txtbranchname';
    colarray_pul['branchname'] = { 
        header_title: "Branchname",
        edit: [txtbranchname],
        disp: [spnbranchname],
        td_class: "tablerow tdbranchname",
        headertd_class : "hdbranchname tdclick tdbranchname"
    };
    
    var spnbranchcode = document.createElement('span');
    var txtbranchcode = document.createElement('input');
    txtbranchcode.type = "text";
    txtbranchcode.id = 'idtxtbranchcode';
    txtbranchcode.className = 'txtbranchcode';
    colarray_pul['branchcode'] = { 
        header_title: "Branch Code",
        edit: [txtbranchcode],
        disp: [spnbranchcode],
        td_class: "tablerow tdbranchcode",
        headertd_class : "hdbranchcode tdclick tdbranchcode"
    };

    var imageSetup = document.createElement('span');
    imageSetup.setAttribute("id", "image-setup");
    imageSetup.setAttribute("onclick", "changeSetup(this)");
    imageSetup.style.cursor = "pointer";
    colarray_pul['columnImageSetup'] = {
        header_title: "Setup",
        edit: [imageSetup],
        disp: [imageSetup],
        td_class: "tablerow"
    };

    var corDocumentView = document.createElement('img');
    corDocumentView.src = "assets/images/iconview.png";
    corDocumentView.className = "cor-document-view";
    corDocumentView.style.cursor = "pointer";
    corDocumentView.setAttribute("onclick"," displayCorTable(this);");
    var corAvailable = document.createElement('span');
    corAvailable.className = "cor-available";
    colarray_pul['corDocument'] = {
        header_title : "COR & PTU",
        edit : [corDocumentView, corAvailable],
        disp : [corDocumentView, corAvailable],
        td_class : "tablerow td-cor-document",
        headertd_class : "td-cor-document"
    };

    var imageNotes = document.createElement('span');
    imageNotes.setAttribute("id", "image-notes");
    imageNotes.setAttribute("onclick", "addClientNotes(this)");
    imageNotes.style.cursor = "pointer";
    colarray_pul['columnImageNotes'] = {
        header_title: "Notes",
        edit: [imageNotes],
        disp: [imageNotes],
        td_class: "tablerow td-image-notes"
    };

    var spnlocation_id = document.createElement('span');
    spnlocation_id.className = 'spnlocation_id';
    colarray_pul['location_id'] = { 
        header_title: "Location ID",
        edit: [spnlocation_id],
        disp: [spnlocation_id],
        td_class: "tablerow tdlocation_id",
        headertd_class : "tdclick tdlocation_id"
    };

    var spnlocation_name = document.createElement('span');
    var txtlocation_name = document.createElement('input');
    txtlocation_name.type = "text";
    txtlocation_name.id = 'idlocation_name';
    txtlocation_name.className = 'txtlocation_name';
    colarray_pul['location_name'] = { 
        header_title: "Location Name",
        edit: [txtlocation_name],
        disp: [spnlocation_name],
        td_class: "tablerow tdlocation_name",
        headertd_class : "hdlocation_name tdclick tdlocation_name"
    };

    var seltechassigned = document.createElement('select');
    seltechassigned.className = "seltechassigned";
    seltechassigned.style = "display:none";
    seltechassigned.innerHTML = '<?php echo fill_select_options("SELECT `id`, `name` FROM `members` WHERE `type` = 1 ORDER BY `name`", "id", "name",0,false); ?>';
    var seltechassigned_disp = seltechassigned.cloneNode(true);
    seltechassigned_disp.disabled = "disabled";
    colarray_pul['techassigned'] = { 
        header_title: "", 
        edit: [seltechassigned], 
        disp: [seltechassigned_disp], 
        td_class: "tablerow tdtechassigned"
    };

    var spndate_start = document.createElement('span');
    var txtdate_start = document.createElement('input');
    txtdate_start.type = "text";
    txtdate_start.id = 'idtxtdate_start';
    txtdate_start.className = 'txtdate_start';
    colarray_pul['date_start'] = { 
        header_title: "Date Start",
        edit: [txtdate_start],
        disp: [spndate_start],
        td_class: "tablerow tddate_start",
        headertd_class : "hddate_start tdclick tddate_start"
    };
    
    var spndate_stop = document.createElement('span');
    var txtdate_stop = document.createElement('input');
    txtdate_stop.type = "text";
    txtdate_stop.id = 'idtxtdate_stop';
    txtdate_stop.className = 'txtdate_stop';
    colarray_pul['date_stop'] = { 
        header_title: "Date Stop",
        edit: [txtdate_stop],
        disp: [spndate_stop],
        td_class: "tablerow tddate_stop",
        headertd_class : "hddate_stop tdclick tddate_stop"
    };
    
    var marketEdit = document.createElement('select');
    marketEdit.className = "market";
    var marketOptions = "<option value='0'>Not Set</option>";
    marketOptions += "<option value='1'>Chinese</option>";
    marketOptions += "<option value='2'>Filipino</option>";
    marketEdit.innerHTML = marketOptions;
    var marketView = marketEdit.cloneNode(true);
    marketView.disabled = "disabled";
    colarray_pul['colselect'] = { 
        header_title: "Market",
        edit: [marketEdit],
        disp: [marketView],
        td_class: "tablerow tdselect market",
        headertd_class : "market"
    };

    var chkOutlet_disp = document.createElement('input');
    chkOutlet_disp.type = "checkbox";
    chkOutlet_disp.className = "chkOutlet";
    chkOutlet_disp.disabled = "disabled";
    var chkOutlet = document.createElement('input');
    chkOutlet.type = "checkbox";
    chkOutlet.className = "chkOutlet";
    colarray_pul['colOutlet'] = { 
        header_title: "Outlet",
        edit: [chkOutlet],
        disp: [chkOutlet_disp],
        td_class: "tablerow tdselectOutlet"
    };

    var gid_pul = document.createElement('span');
    colarray_pul['gid_pul'] = { 
        header_title: "",
        edit: [gid_pul],
        disp: [gid_pul],
        td_class: "tablerow tddelete gwid",
        headertd_class: "hddelete"
    };

    var netid_pul = document.createElement('span');
    colarray_pul['netid_pul'] = { 
        header_title: "",
        edit: [netid_pul],
        disp: [netid_pul],
        td_class: "tablerow tddelete netwid",
        headertd_class: "hddelete"
    };

    var imgPages = document.createElement('img')
    imgPages.src = "assets/images/imgpgrestrict.png";
    imgPages.setAttribute("class","btn btn-info btn-lg");
    imgPages.setAttribute("id","imgPages");
    imgPages.style.height = '20px';
    imgPages.style.width = '20px';
    imgPages.style.cursor = "pointer";
    imgPages.setAttribute("onclick","set_pages(this)");
    imgPages.setAttribute("data-target","#myModal");
    imgPages.setAttribute("data-toggle","modal");
    imgPages.setAttribute("style", "display: none");
    colarray_pul['colpages'] = { 
        header_title: "",
        edit: [imgPages],
        disp: [imgPages],
        td_class: "tablerow tdpages",
        headertd_class: "hdpages"
    };
    
    
    var imgMaintenance = document.createElement('img')
    imgMaintenance.src = "assets/images/imgmaintenance.png";
    imgMaintenance.className = "maintenanceSched";
    imgMaintenance.setAttribute("id","imgMaintenance");
    imgMaintenance.setAttribute("onclick","maintenance_fnc(this)");
    imgMaintenance.style.height = '20px';
    imgMaintenance.style.width = '20px';
    imgMaintenance.style.cursor = "pointer";
    colarray_pul['colmaintain'] = { 
        header_title: "",
        edit: [imgMaintenance],
        disp: [imgMaintenance],
        td_class: "tablerow tdpages",
        headertd_class: "hdpages"
    };

    var selcollectiontype = document.createElement('select');
    selcollectiontype.className = "sel_collection_type";
    selcollectiontype.innerHTML = '<option value="1">Charge</option><option value="0">Free</option>';
    var selcollectiontype_disp = selcollectiontype.cloneNode(true);
    selcollectiontype_disp.disabled = "disabled";
    colarray_pul['colcollectiontype'] = { 
        header_title: "Monthly", 
        edit: [selcollectiontype], 
        disp: [selcollectiontype_disp], 
        td_class: "tablerow tdcollectiontype"
    };

    var spnmonthlycharge = document.createElement('span');
    var txtmonthlycharge = document.createElement('input');
    txtmonthlycharge.type = "text";
    txtmonthlycharge.id = 'idtxtmonthly_charge';
    txtmonthlycharge.className = 'txtmonthly_charge';
    colarray_pul['colmonthlycharge'] = { 
        header_title: "Charge",
        edit: [txtmonthlycharge],
        disp: [spnmonthlycharge],
        td_class: "tablerow tdmonthly_charge",
        headertd_class : "hdmonthly_charge tdclick"
    };

    var chkStillUsed_disp = document.createElement('input');
    chkStillUsed_disp.type = "checkbox";
    chkStillUsed_disp.className = "chkStillUsed";
    chkStillUsed_disp.disabled = "disabled";
    //chkStillUsed_disp.style = "display:none";
    var chkStillUsed = document.createElement('input');
    chkStillUsed.type = "checkbox";
    //chkStillUsed.style = "display:none";
    chkStillUsed.className = "chkStillUsed";
    colarray_pul['colStillUsed'] = {
        header_title: "Still Used?",
        edit: [chkStillUsed],
        disp: [chkStillUsed_disp],
        td_class: "tablerow tdselectStillUsed"
    };

    var chkfreepoint = document.createElement('input');
    chkfreepoint.type = "checkbox";
    chkfreepoint.style = "display:none";
    chkfreepoint.className = "chkfreepoint";
    var chkfreepoint_disp = chkfreepoint.cloneNode(true);
    chkfreepoint_disp.disabled = "disabled";
    colarray_pul['colfreepoint'] = { 
        header_title: "", 
        edit: [chkfreepoint], 
        disp: [chkfreepoint_disp], 
        td_class: "tablerow tdfreepoint"
    };
    
    var imgtoterminaldetail = document.createElement('img');
    imgtoterminaldetail.className = "imgtoterminaldetail";
    imgtoterminaldetail.src = "assets/images/imgtohead.png";
    imgtoterminaldetail.style.height = '20px';
    imgtoterminaldetail.style.width = '20px';
    imgtoterminaldetail.style.cursor = "pointer";
    imgtoterminaldetail.setAttribute("onclick","toterminal_fnc(this)");
    colarray_pul['imgtoterminaldetail'] = {
        header_title: "",
        edit: [imgtoterminaldetail],
        disp: [imgtoterminaldetail],
        td_class: "tablerow tdimgtoterminaldetail",
        headertd_class : "hdimgtoterminaldetail"
    };

    var imgUpdate = document.createElement('img');
        imgUpdate.src = "assets/images/iconupdate.png";
        imgUpdate.setAttribute("onclick","pul_update_fnc(this)");
        imgUpdate.style.cursor = "pointer";
    var imgEdit = document.createElement('img');
        imgEdit.src = "assets/images/iconedit.png";
        imgEdit.setAttribute("onclick"," editSelectedRow(myjstbl_pul, this);");
        imgEdit.id = "edit_pul";
        imgEdit.className = "edit_pul";
        imgEdit.style.cursor = "pointer";
        imgEdit.style.display = "none";
        imgEdit.style.display = "block";
        colarray_pul['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate],
        disp: [imgEdit],
        td_class: " tablerow tdupdate",
        headertd_class : "hdupdate"
    };
    

    var imgDelete = document.createElement('img');
    imgDelete.src = "assets/images/icondelete.png";
    imgDelete.setAttribute("class","imgdel");
    imgDelete.setAttribute("id","imgDelete");
    imgDelete.style.cursor = "pointer";
    <?php if (! $isManagementPosition) { ?>
        imgDelete.style.display = "none";
    <?php } ?>
    colarray_pul['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete td-delete-branch",
        headertd_class: "hddelete td-delete-branch"
    };

    
/*********** Table 2 **************/

    // P.U.L Table
    var myjstbl_pul2;
    var tab_pul2 = document.createElement('table');
    tab_pul2.id="tableid_pul2";
    tab_pul2.className = "table table-bordered";

    var colarray_pul2 = [];
    var id_pul2 = document.createElement('span');
    colarray_pul2['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid",
        headertd_class : "tdclick tdid"
    };


    var spnbranchid2 = document.createElement('span');
    var txtbranchid2 = document.createElement('input');
    txtbranchid2.type = "text";
    txtbranchid2.id = 'idtxtbranchid';
    txtbranchid2.style = "display:none";
    spnbranchid2.style = "display:none";
    txtbranchid2.className = 'txtbranchid';
    colarray_pul2['branchid'] = { 
        header_title: "",
        edit: [txtbranchid2],
        disp: [spnbranchid2],
        td_class: "tablerow tdbranchid",
        headertd_class : "hdbranchid tdclick"
    };

    var maintenanceType = document.createElement('span');
    maintenanceType.type = "text";
    maintenanceType.id = 'type';
    maintenanceType.className = 'type';
    colarray_pul2['type'] = { 
        header_title: "Maintenance Type",
        edit: [maintenanceType],
        disp: [maintenanceType],
        td_class: "tablerow tdmaintenanceType",
        headertd_class : "hdlocation_name tdclick"
    };
    


    var ScheduledDate_spn = document.createElement('span');
    var ScheduledDate = document.createElement('input');
    ScheduledDate.type = "text";
    ScheduledDate.id = 'ScheduledDate';
    ScheduledDate.className = 'ScheduledDate';
    colarray_pul2['ScheduledDate'] = { 
        header_title: "Scheduled Date",
        edit: [ScheduledDate],
        disp: [ScheduledDate_spn],
        td_class: "tablerow tdScheduledDate",
        headertd_class : "hddescription tdclick"
    };
    
    var chkstatus_disp = document.createElement('input');
    chkstatus_disp.type = "checkbox";
    chkstatus_disp.className = "chkstatus";
    chkstatus_disp.disabled = "disabled";
    var chkstatus = document.createElement('input');
    chkstatus.type = "checkbox";
    chkstatus.className = "chkstatus";
    colarray_pul2['colstatus'] = { 
        header_title: "Status",
        edit: [chkstatus],
        disp: [chkstatus_disp],
        td_class: "tablerow tdselect"
    };
    

    var imgUpdate2 = document.createElement('img');
        imgUpdate2.src = "assets/images/iconupdate.png";
        imgUpdate2.setAttribute("onclick","pul_update_fnc2(this)");
        imgUpdate2.style.cursor = "pointer";
    var imgEdit2 = document.createElement('img');
        imgEdit2.src = "assets/images/iconedit.png";
        imgEdit2.setAttribute("onclick"," editSelectedRow(myjstbl_pul2, this);");
        imgEdit2.id = "edit_pul2";
        imgEdit2.className = "edit_pul2";
        imgEdit2.style.cursor = "pointer";
        imgEdit2.style.display = "none";
        imgEdit2.style.display = "block";
        colarray_pul2['colupdate2'] = { 
        header_title: "",
        edit: [imgUpdate2],
        disp: [imgEdit2],
        td_class: " tablerow tdupdate",
        headertd_class : "hdupdate"
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

    var myJsTableCor;
    var tableCor = document.createElement('table');
    tableCor.id = "table-cor-id";
    tableCor.className = "table table-bordered";
    var columnCor = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnCor['columnCorId'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow-cor td-cor-id",
        headertd_class: "td-cor-id"
    };

    var hiddenMultipleCor = document.createElement('span');
    hiddenMultipleCor.type = "hidden";
    hiddenMultipleCor.setAttribute("style", "display: none");
    columnCor['columnMultipleCor'] = {
        header_title: "",
        edit: [hiddenMultipleCor],
        disp: [hiddenMultipleCor],
        td_class: "tablerow-multiple-cor td-multiple-cor",
        headertd_class: "td-multiple-cor"
    };

    var imageBound = document.createElement('span');
    imageBound.setAttribute("class", "image-bound");
    imageBound.style.cursor = "pointer";
    columnCor['columnimageBound'] = {
        header_title: "",
        edit: [imageBound],
        disp: [imageBound],
        td_class: "tdclick image-bound"
    };

    var spanCorTin = document.createElement('span');
    spanCorTin.className = "span-cor-tin";
    spanCorTin.innerHTML = "";
    columnCor['columnCorTin'] = {
        header_title: "TIN",
        edit: [spanCorTin],
        disp: [spanCorTin],
        td_class: "tablerow-cor tdall td-cor-tin",
        headertd_class: "tdclick td-cor-tin"
    };

    var spanCorBusinessName = document.createElement('span');
    spanCorBusinessName.className = "span-cor-business-name";
    spanCorBusinessName.innerHTML = "";
    columnCor['columnCorBusinessName'] = {
        header_title: "Business Name",
        edit: [spanCorBusinessName],
        disp: [spanCorBusinessName],
        td_class: "tablerow-cor tdall td-cor-business-name",
        headertd_class: "tdclick td-cor-business-name"
    };

    var spanCorStatus = document.createElement('span');
    spanCorStatus.className = "span-cor-status";
    spanCorStatus.innerHTML = "";
    columnCor['columnCorUnits'] = {
        header_title: "Status",
        edit: [spanCorStatus],
        disp: [spanCorStatus],
        td_class: "tablerow-cor tdall td-cor-status",
        headertd_class: "tdclick td-cor-status"
    };

   var deleteCor = document.createElement('img');
    deleteCor.src = "assets/images/icondelete.png";
    deleteCor.setAttribute("id", "delete-cor");
    deleteCor.style.cursor = "pointer";
    columnCor['columnDeleteCor'] = {
        header_title: "",
        edit: [deleteCor],
        disp: [deleteCor],
        td_class: "tablerow-cor td-cor-delete",
        headertd_class: "hddelete2 td-cor-delete"
    }; 

    var myJsTablePtuUpload;
    var tablePtuUpload = document.createElement('table');
    tablePtuUpload.id = "table-ptu-id";
    tablePtuUpload.className = "table table-bordered";
    var columnPtuUpload = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnPtuUpload['columnPtuUploadId'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow-ptu"
    };

    var hiddenCorId = document.createElement('span');
    hiddenCorId.type = "hidden";
    hiddenCorId.setAttribute("style", "display: none");
    columnPtuUpload['columnPtuCorId'] = {
        header_title: "",
        edit: [hiddenCorId],
        disp: [hiddenCorId],
        td_class: "tablerow-ptu-id"
    };

    var spanPtuUploadDate = document.createElement('span');
    spanPtuUploadDate.className = "span-ptu-upload-date";
    spanPtuUploadDate.innerHTML = "";
    columnPtuUpload['columnPtuUploadDate'] = {
        header_title: "Mode",
        edit: [spanPtuUploadDate],
        disp: [spanPtuUploadDate],
        td_class: "tablerow-ptu tdall td-ptu-upload-date",
        headertd_class: "tdclick td-ptu-upload-date"
    };

    var spanPtuMode = document.createElement('span');
    spanPtuMode.className = "span-ptu-mode";
    spanPtuMode.innerHTML = "";
    columnPtuUpload['columnPtuMode'] = {
        header_title: "Date",
        edit: [spanPtuUploadDate],
        disp: [spanPtuUploadDate],
        td_class: "tablerow-ptu tdall td-ptu-mode",
        headertd_class: "tdclick td-ptu-mode"
    };

    var spanPtuUploadTransaction = document.createElement('span');
    spanPtuUploadTransaction.className = "span-ptu-upload-transaction";
    spanPtuUploadTransaction.innerHTML = "";
    columnPtuUpload['columnPtuUploadTransaction'] = {
        header_title: "Transaction #",
        edit: [spanPtuUploadTransaction],
        disp: [spanPtuUploadTransaction],
        td_class: "tablerow-ptu tdall td-ptu-upload-transaction",
        headertd_class: "tdclick td-ptu-upload-transaction"
    };

    var spanPtuUploadUnits = document.createElement('span');
    spanPtuUploadUnits.className = "span-ptu-upload-units";
    spanPtuUploadUnits.innerHTML = "";
    columnPtuUpload['columnPtuUploadUnits'] = {
        header_title: "# of Units",
        edit: [spanPtuUploadUnits],
        disp: [spanPtuUploadUnits],
        td_class: "tablerow-ptu tdall td-ptu-upload-units",
        headertd_class: "tdclick td-ptu-upload-units"
    };

    var deletePtuUpload = document.createElement('img');
    deletePtuUpload.src = "assets/images/icondelete.png";
    deletePtuUpload.setAttribute("id", "delete-ptu-upload");
    deletePtuUpload.style.cursor = "pointer";
    columnPtuUpload['columnDeletePtuUpload'] = {
        header_title: "",
        edit: [deletePtuUpload],
        disp: [deletePtuUpload],
        td_class: "tablerow-ptu td-ptu-delete",
        headertd_class: "hddelete2 td-ptu-delete"
    };

    var myJsTablePtuUnit;
    var tablePtuUnit = document.createElement('table');
    tablePtuUnit.id = "table-unit-id";
    tablePtuUnit.className = "table table-bordered";
    var columnPtuUnit = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnPtuUnit['columnPtuUnitId'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow"
    };

    var imageBindPtu = document.createElement('span');
    imageBindPtu.setAttribute("class", "image-bind-ptu");
    imageBindPtu.style.cursor = "pointer";
    columnPtuUnit['columnImageBindPtu'] = {
        header_title: "",
        edit: [imageBindPtu],
        disp: [imageBindPtu],
        td_class: "tablerow td-image-bind-ptu"
    };

    var spanPtuPermitNumber = document.createElement('span');
    spanPtuPermitNumber.className = "span-ptu-permit-number";
    spanPtuPermitNumber.innerHTML = "";
    columnPtuUnit['columnPtuPermitNumber'] = {
        header_title: "Permit #",
        edit: [spanPtuPermitNumber],
        disp: [spanPtuPermitNumber],
        td_class: "tablerow tdall td-ptu-permit-number",
        headertd_class: "tdclick td-ptu-permit-number"
    };

    var spanMinNumber = document.createElement('span');
    spanMinNumber.className = "span-ptu-min-number";
    spanMinNumber.innerHTML = "";
    columnPtuUnit['columnPtuUnitMinNumber'] = {
        header_title: "MIN #",
        edit: [spanMinNumber],
        disp: [spanMinNumber],
        td_class: "tablerow tdall td-ptu-min-number",
        headertd_class: "tdclick td-ptu-min-number"
    };

    var spanPtuSerialNumber = document.createElement('span');
    spanPtuSerialNumber.className = "span-ptu-serial-number";
    spanPtuSerialNumber.innerHTML = "";
    columnPtuUnit['columnPtuSerialNumber'] = {
        header_title: "Serial #",
        edit: [spanPtuSerialNumber],
        disp: [spanPtuSerialNumber],
        td_class: "tablerow tdall td-ptu-serial-number",
        headertd_class: "tdclick td-ptu-serial-number"
    };

    var selectPtuTerminalDropdown = document.createElement('select');
    selectPtuTerminalDropdown.className = "select-ptu-terminal";
    selectPtuTerminalDropdown.setAttribute("onchange", "getPTUTerminalDropdown(this)");
    selectPtuTerminalDropdown.setAttribute("multiple", "multiple");

    var displaySelectPtuTerminalDropdown = selectPtuTerminalDropdown.cloneNode(true);
    displaySelectPtuTerminalDropdown.disabled = "disabled";
    columnPtuUnit['columnPtuTerminal'] = {
        header_title: "Terminals",
        edit: [selectPtuTerminalDropdown],
        disp: [displaySelectPtuTerminalDropdown],
        td_class: "tablerow tdall td-ptu-terminal"
    };

    var updatePtuUnit = document.createElement('img');
        updatePtuUnit.src = "assets/images/iconupdate.png";
        updatePtuUnit.setAttribute("class", "save-ptu-terminal");
        updatePtuUnit.setAttribute("onclick", "savePtuTerminal(this)");
        updatePtuUnit.style.cursor = "pointer";
        updatePtuUnit.style.display = "none";
    var editPtuUnit = document.createElement('img');
        editPtuUnit.src = "assets/images/iconedit.png";
        editPtuUnit.setAttribute("onclick", "editSelectedTerminal(myJsTablePtuUnit, this);");
        editPtuUnit.class = "edit-ptu-unit";
        editPtuUnit.style.cursor = "pointer";
        updatePtuUnit.style.display = "block";
    columnPtuUnit['columnEditPtuUnit'] = {
        header_title: "",
        edit: [updatePtuUnit],
        disp: [editPtuUnit],
        td_class: " tablerow td-ptu-edit",
        headertd_class : "hdupdate td-ptu-edit"
    };

    var myJsTableManualPtuUnit;
    var tableManualPtuUnit = document.createElement('table');
    tableManualPtuUnit.id = "table-manual-unit-id";
    tableManualPtuUnit.className = "table table-bordered";
    var columnManualPtuUnit = [];

    var hiddenManualId = document.createElement('span');
    hiddenManualId.type = "hidden";
    hiddenManualId.setAttribute("style", "display: none");
    columnManualPtuUnit['columnManualPtuUnitId'] = {
        header_title: "",
        edit: [hiddenManualId],
        disp: [hiddenManualId],
        td_class: "tablerow"
    };

    var imageManualBindPtu = document.createElement('span');
    imageManualBindPtu.setAttribute("class", "manual-image-bind-ptu");
    imageManualBindPtu.style.cursor = "pointer";
    columnManualPtuUnit['columnManualImageBindPtu'] = {
        header_title: "",
        edit: [imageManualBindPtu],
        disp: [imageManualBindPtu],
        td_class: "tablerow td-image-bind-ptu"
    };

    var textManualPtuPermitNumber = document.createElement('input');
    textManualPtuPermitNumber.className = "text-manual-ptu-permit-number";
    var spanManualPtuPermitNumber = document.createElement('span');
    spanManualPtuPermitNumber.className = "span-manual-ptu-permit-number";
    spanManualPtuPermitNumber.innerHTML = "";
    columnManualPtuUnit['columnManualPtuPermitNumber'] = {
        header_title: "Permit #",
        edit: [textManualPtuPermitNumber],
        disp: [spanManualPtuPermitNumber],
        td_class: "tablerow tdall td-manual-ptu-permit-number",
        headertd_class: "tdclick hd-manual-ptu-permit-number"
    };

    var textManualMinNumber = document.createElement('input');
    textManualMinNumber.className = "text-manual-ptu-min-number";
    var spanManualMinNumber = document.createElement('span');
    spanManualMinNumber.className = "span-manual-ptu-min-number";
    spanManualMinNumber.innerHTML = "";
    columnManualPtuUnit['columnManualPtuUnitMinNumber'] = {
        header_title: "MIN #",
        edit: [textManualMinNumber],
        disp: [spanManualMinNumber],
        td_class: "tablerow tdall td-manual-ptu-min-number",
        headertd_class: "tdclick hd-manual-ptu-min-number"
    };

    var textManualPtuSerialNumber = document.createElement('input');
    textManualPtuSerialNumber.className = "text-manual-ptu-serial-number";
    var spanManualPtuSerialNumber = document.createElement('span');
    spanManualPtuSerialNumber.className = "span-manual-ptu-serial-number";
    spanManualPtuSerialNumber.innerHTML = "";
    columnManualPtuUnit['columnManualPtuSerialNumber'] = {
        header_title: "Serial #",
        edit: [textManualPtuSerialNumber],
        disp: [spanManualPtuSerialNumber],
        td_class: "tablerow tdall td-manual-ptu-serial-number",
        headertd_class: "tdclick hd-manual-ptu-serial-number"
    };

    var deleteManualPtuUnit = document.createElement('img');
        deleteManualPtuUnit.src = "assets/images/icondelete.png";
        deleteManualPtuUnit.setAttribute("class", "manual-delete-ptu-terminal");
        deleteManualPtuUnit.setAttribute("onclick", "deleteManualPtuTerminal(this)");
        deleteManualPtuUnit.style.cursor = "pointer";
    columnManualPtuUnit['columnManualDeletePtuUnit'] = {
        header_title: "",
        edit: [deleteManualPtuUnit],
        disp: [deleteManualPtuUnit],
        td_class: " tablerow td-ptu-edit",
        headertd_class : "hdupdate hd-manual-ptu-edit"
    };

    $(function()
    {
        myJsTableCor = new my_table(tableCor, columnCor, {
            iscursorchange_when_hover: true,
            tdhighlight_when_hover: "tablerow-cor",
        });

        var rootCor = document.getElementById("table-cor");
        rootCor.appendChild(myJsTableCor.tab);
    });

    $(function()
    {
        myJsTablePtuUpload = new my_table(tablePtuUpload, columnPtuUpload, {
            iscursorchange_when_hover: true,
            tdhighlight_when_hover : "tablerow-ptu",
        });

        var rootPtuUpload = document.getElementById("table-ptu");
        rootPtuUpload.appendChild(myJsTablePtuUpload.tab);
    });

    $(function()
    {
        myJsTablePtuUnit = new my_table(tablePtuUnit, columnPtuUnit, {
            iscursorchange_when_hover: false
        });

        var rootPtuUnit = document.getElementById("table-units");
        rootPtuUnit.appendChild(myJsTablePtuUnit.tab);
    });

    $(function()
    {
        myJsTableManualPtuUnit = new my_table(tableManualPtuUnit, columnManualPtuUnit, {
            iscursorchange_when_hover: false
        });

        var rootManualPtuUnit = document.getElementById("table-units-manual");
        rootManualPtuUnit.appendChild(myJsTableManualPtuUnit.tab);
    });

    $(function()
    {
        myJsTableNotes = new my_table(tableNotes, columnArrayNotes, {
            ispaging: true,
            iscursorchange_when_hover: false
        });

        var rootNotes = document.getElementById("table-notes");
        rootNotes.appendChild(myJsTableNotes.tab);
        rootNotes.appendChild(myJsTableNotes.mypage.pagingtable);

        $("#table-notes-id_txtpagenumber, #table-notes-id_txtfilternumber, .tin-1-edit, .tin-2-edit, .tin-3-edit, .tin-4-edit")
        .live("keypress", function(e)
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

    var arr = [];
    $(function() {

        // P.U.L
        myjstbl_pul = new my_table(tab_pul, colarray_pul, {
            ispaging : true,
            tdpopup_when_hover : "tdpopuphover",
            iscursorchange_when_hover : true
        });

        var root_pul = document.getElementById("tbl_pul");
        root_pul.appendChild(myjstbl_pul.tab);
        root_pul.appendChild(myjstbl_pul.mypage.pagingtable);


        myjstbl_pul.mypage.set_mysql_interval(10000);
        myjstbl_pul.mypage.isOldPaging = true;
        myjstbl_pul.mypage.pass_refresh_filter_page(pul_refresh_table);

        $("#filterclientgroup").val(<?=$clientgroupid?>);
        $("#filterclienthead").val(<?=$clientheadid?>);
        var clientdetailidsearch = (<?=$clientdetailid?>);
        $("#filter-client-setup").val(<?=$clientSetup?>);
        $("#filter-client-status").val(<?=$clientStatus?>);

        showInitialPageLoadDisplay(myjstbl_pul);

        if (clientdetailidsearch > 0){
            pul_refresh_table();
        }

        $("#txtsearch").keypress( 
        function(e)
        {
            if(e.keyCode == 13)
            {
                pul_refresh_table();
            }
        });

        $("#address").keypress( 
        function(e)
        {
            var len = $(this).val().length;

            if(len > 250)
                return false;
        });

        $("#button-search").click(function() {
            pul_refresh_table();
        });

        $("#createnew").click(function(){
            if (isFirstLoad) {
                alert("Unable to add new row. Please load the data first.");
            } else {
                myjstbl_pul.mypage.go_to_last_page(); 
                $(".txtname").last().focus();
            }
        });

        $(".select-ptu-terminal").chosen();
        $("#filterclientgroup").chosen({
            allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclienthead").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filter-client-setup").chosen({
            allow_single_deselect:true,
            no_results_text: "Not found",
            add_item_enable: false
        });
        $("#filter-client-status").chosen({
            allow_single_deselect: true,
            no_results_text: "Not found",
            add_item_enable: false
        });
        
        $("#filterclientgroup").change(function(){
            refresh_cleinthead_ddl();
        });


        $("#manualRegisteredName").on('input',function(e){
            $("#manualFirstName").val("");
            $("#manualMiddleName").val("");
            $("#manualLastName").val("");
            $("#manualExtentionName").val("");

            if (this.value.length > 0){
                $("#manualFirstName").attr("disabled", true);
                $("#manualMiddleName").attr("disabled", true);
                $("#manualLastName").attr("disabled", true);
                $("#manualExtentionName").attr("disabled", true);
            } else {
                $("#manualFirstName").attr("disabled", false);
                $("#manualMiddleName").attr("disabled", false);
                $("#manualLastName").attr("disabled", false);
                $("#manualExtentionName").attr("disabled", false);
            }
        });

        $("#manualFirstName").on('input',function(e){
            $("#manualRegisteredName").val("");

            var getFirstname = $("#manualFirstName").val();
            var getMiddlename = $("#manualMiddleName").val();
            var getLastname = $("#manualLastName").val();
            var getExtentionname = $("#manualExtentionName").val();

            if (getFirstname.length > 0 || getMiddlename.length > 0 || getLastname.length > 0 || getExtentionname.length > 0) {
                $("#manualRegisteredName").attr("disabled", true);

                $("#manualFirstName").attr("disabled", false);
                $("#manualMiddleName").attr("disabled", false);
                $("#manualLastName").attr("disabled", false);
                $("#manualExtentionName").attr("disabled", false);
            } else {
                $("#manualRegisteredName").attr("disabled", false);
            }
        });

        $("#manualMiddleName").on('input',function(e){
            $("#manualRegisteredName").val("");

            var getFirstname = $("#manualFirstName").val();
            var getMiddlename = $("#manualMiddleName").val();
            var getLastname = $("#manualLastName").val();
            var getExtentionname = $("#manualExtentionName").val();

            if (getFirstname.length > 0 || getMiddlename.length > 0 || getLastname.length > 0 || getExtentionname.length > 0) {
                $("#manualRegisteredName").attr("disabled", true);

                $("#manualFirstName").attr("disabled", false);
                $("#manualMiddleName").attr("disabled", false);
                $("#manualLastName").attr("disabled", false);
                $("#manualExtentionName").attr("disabled", false);
            } else {
                $("#manualRegisteredName").attr("disabled", false);
            }
        });

        $("#manualLastName").on('input',function(e){
            $("#manualRegisteredName").val("");

            var getFirstname = $("#manualFirstName").val();
            var getMiddlename = $("#manualMiddleName").val();
            var getLastname = $("#manualLastName").val();
            var getExtentionname = $("#manualExtentionName").val();

            if (getFirstname.length > 0 || getMiddlename.length > 0 || getLastname.length > 0 || getExtentionname.length > 0) {
                $("#manualRegisteredName").attr("disabled", true);

                $("#manualFirstName").attr("disabled", false);
                $("#manualMiddleName").attr("disabled", false);
                $("#manualLastName").attr("disabled", false);
                $("#manualExtentionName").attr("disabled", false);
            } else {
                $("#manualRegisteredName").attr("disabled", false);
            }
        });

        $("#manualExtentionName").on('input',function(e){
            $("#manualRegisteredName").val("");

            var getFirstname = $("#manualFirstName").val();
            var getMiddlename = $("#manualMiddleName").val();
            var getLastname = $("#manualLastName").val();
            var getExtentionname = $("#manualExtentionName").val();

            if (getFirstname.length > 0 || getMiddlename.length > 0 || getLastname.length > 0 || getExtentionname.length > 0) {
                $("#manualRegisteredName").attr("disabled", true);

                $("#manualFirstName").attr("disabled", false);
                $("#manualMiddleName").attr("disabled", false);
                $("#manualLastName").attr("disabled", false);
                $("#manualExtentionName").attr("disabled", false);
            } else {
                $("#manualRegisteredName").attr("disabled", false);
            }
        });

        
        /********************** PAGE RESTRICTIONS MODAL **********************/
        $(".header-panel").click(function(){
            var label = $(this).attr("id");
            var checked = $(this).is(":checked");
            if (checked) {
                $("."+label+"-section").attr("checked","checked");
            }
            else
            {
                $("."+label+"-section").removeAttr("checked");
            };

            refresh_main_checkbox();
        });

        $(".data-section, .po-section, .sales-section, .stocks-section, .collector-section, .others-section, .products-section, .financial-section, .cussup-section, .ranking-section, .warning-section, .summary-section, .otherreport-section").click(function(){
            var checked = $(this).is(":checked");
            var label = $(this).attr("class");
            var label = label.substr(0,label.indexOf("-section"));
            if (!checked) {
                $("#"+label).removeAttr("checked");

                if (label != "data" && label != "po" && label != "sales" && label != "stocks" && label != "others" && label != "collector") {
                    $("#reports-header").removeAttr("checked");
                };
            };

            refresh_main_checkbox();
        });     
        
        $("#reports-header").click(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $("#products").attr("checked","checked");
                $("#financial").attr("checked","checked");
                $("#cussup").attr("checked","checked");
                $("#ranking").attr("checked","checked");
                $("#warning").attr("checked","checked");
                $("#summary").attr("checked","checked");
                $("#otherreport").attr("checked","checked");

                $(".products-section").attr("checked","checked");
                $(".financial-section").attr("checked","checked");
                $(".cussup-section").attr("checked","checked");
                $(".ranking-section").attr("checked","checked");
                $(".warning-section").attr("checked","checked");
                $(".summary-section").attr("checked","checked");
                $(".otherreport-section").attr("checked","checked");
            }
            else
            {
                $("#products").removeAttr("checked");
                $("#financial").removeAttr("checked");
                $("#cussup").removeAttr("checked");
                $("#ranking").removeAttr("checked");
                $("#warning").removeAttr("checked");
                $("#summary").removeAttr("checked");
                $("#otherreport").removeAttr("checked");

                $(".products-section").removeAttr("checked");
                $(".financial-section").removeAttr("checked");
                $(".cussup-section").removeAttr("checked");
                $(".ranking-section").removeAttr("checked");
                $(".warning-section").removeAttr("checked");
                $(".summary-section").removeAttr("checked");
                $(".otherreport-section").removeAttr("checked");    
            }

            refresh_main_checkbox();
        });

        $("#ddlsubscription").change(function() {

            switch(Number($(this).val())) {

                case 0:

                    $(".pos").removeAttr("checked");
                    $(".basicst").removeAttr("checked");
                    $(".advanced").removeAttr("checked");
                    $(".premium").removeAttr("checked");
                    $(".bymodule").removeAttr("checked");
                    
                    $(".basicwh").attr("checked","checked");
                    break;

                case 1:

                    $(".pos").removeAttr("checked");
                    $(".basicwh").removeAttr("checked");
                    $(".advanced").removeAttr("checked");
                    $(".premium").removeAttr("checked");
                    $(".bymodule").removeAttr("checked");
                    
                    $(".basicst").attr("checked","checked");
                    break;

                case 2:

                    $(".basicwh").removeAttr("checked");
                    $(".basicst").removeAttr("checked");
                    $(".advanced").removeAttr("checked");
                    $(".premium").removeAttr("checked");
                    $(".bymodule").removeAttr("checked");
                    
                    $(".pos").attr("checked","checked");
                    break;

                case 3:

                    $(".pos").removeAttr("checked");
                    $(".basicwh").removeAttr("checked");
                    $(".basicst").removeAttr("checked");
                    $(".premium").removeAttr("checked");
                    $(".bymodule").removeAttr("checked");
                    
                    $(".advanced").attr("checked","checked");
                    break;

                case 4:

                    $(".pos").removeAttr("checked");
                    $(".basicwh").removeAttr("checked");
                    $(".basicst").removeAttr("checked");
                    $(".advanced").removeAttr("checked");
                    $(".bymodule").removeAttr("checked");
                    
                    $(".premium").attr("checked","checked");
                    break;
                    
                case 5:

                    $(".pos").removeAttr("checked");
                    $(".basicwh").removeAttr("checked");
                    $(".basicst").removeAttr("checked");
                    $(".advanced").removeAttr("checked");
                    $(".premium").removeAttr("checked");
                    
                    $(".bymodule").attr("checked","checked");                   
                    break;

                default:

                    $(".pos").attr("checked","checked");
                    $(".basicwh").attr("checked","checked");
                    $(".basicst").attr("checked","checked");
                    $(".advanced").attr("checked","checked");
                    $(".premium").attr("checked","checked");

                    break;
            }

            refresh_main_checkbox();

        }); 

        $("#save").click(function(){
        
            var pages_arr = [];

            $("input[type='checkbox']").each(function(){
                if ($(this).attr('class')!='header-panel' && $(this).attr('class')!='reports-header') {
                    var name = $(this).attr('name');
                    var checked = $(this).is(':checked')== false ? 0 : 1;
                    if(checked && typeof name !== 'undefined')
                        pages_arr.push(name);
                };
            });

            var subscription_val = $("#ddlsubscription").val();
            var fnc = "<?=base_url()?>clienthead/save_settings";

            $.getJSON(fnc,
            {
                id: headid,
                subscription: subscription_val,
                'pages[]': pages_arr
            },
            function(data) {
                if(data == "error"){}
                else{
                    alert("Saved!");
                }
            });
            
        });
    

        
        $("#generate").click(function(){
        
            var fnc = "<?=base_url()?>clienthead/generate_settings";

            $.getJSON(fnc,
            {
                id: headid
            },
            function(data) {
                if(data == "error"){}
                else{
                    window.open("assets/xml/pagerestrictionbase.xml");
                    
                    var fnc = "<?=base_url()?>clienthead/revert_settings";
                    $.getJSON(fnc, {'pages[]': data.pages},
                    function(data) {
                        if(data == "error"){}
                        else{}
                    });
                }
            });
            
        });

        $("#cancel-update-button").click(function(){
            $(".custom-alert-button-container input[type='button']").prop("disabled", true);

            for (var imageIndex = 0; imageIndex < 6; imageIndex++) {

                var getImageValue = $("#imgValue-"+(imageIndex+1)).val();

                if (getImageValue){
                    $(".image-thumbnail-" + (imageIndex+1)).attr("src", "assets/images/loading.gif");
                } else {
                    continue;
                }
            }
            $(".custom-alert").hide();
        });

        $("#select-file-button").click(function(){
            $("#file-upload").click();

        });

        
        $("#file-upload").change(function(e) {
            var countFilename = $("#totalImageCount").val();

            if ((+countFilename + +this.files.length) <= 6){
                var files = e.target.files;
                $.each(files, function (k, v) {
                   fileList.push(files[k]);
                });
            }

            uploadPreview(this, countFilename);
        });

        $("#cor-image-preview.modal-backdrop, #cor-image-preview.fade, #cor-image-preview.in").click(function(event)
        {
            var id = event.target.id;
            if (id == "cor-image-preview" || id == "close-image") {
                $("#cor-image-preview").modal("hide");
                $("#client-COR").modal("show");
            } else {
                return;
            }
        });

        $(".image-thumbnail-1").click(function() {
            $('#image-preview').attr('src', $('.image-thumbnail-1').attr('src'));
            $('#cor-image-preview').modal("show");
        });

        $(".image-thumbnail-2").click(function() {
            $('#image-preview').attr('src', $('.image-thumbnail-2').attr('src'));
            $('#cor-image-preview').modal("show");
        });

        $(".image-thumbnail-3").click(function() {
            $('#image-preview').attr('src', $('.image-thumbnail-3').attr('src'));
            $('#cor-image-preview').modal("show");
        });

        $(".image-thumbnail-4").click(function() {
            $('#image-preview').attr('src', $('.image-thumbnail-4').attr('src'));
            $('#cor-image-preview').modal("show");
        });

        $(".image-thumbnail-5").click(function() {
            $('#image-preview').attr('src', $('.image-thumbnail-5').attr('src'));
            $('#cor-image-preview').modal("show");
        });

        $(".image-thumbnail-6").click(function() {
            $('#image-preview').attr('src', $('.image-thumbnail-6').attr('src'));
            $('#cor-image-preview').modal("show");
        });

        $("#close-upload-file").click(function() {
            $(".cor-popup").hide();
        });

        $("#save-uploaded-file").click(function() {
            $("#upload-image-form").submit();
        });

        $("#upload-image-form").on("submit", function(event){
            event.preventDefault();

            var form = new FormData(this);
            form.append("head_id", globalHeadId);

            for (var i = 0; i < fileList.length; i++) {
                form.append('files[]', fileList[i]);
            }

            for (var i = 0; i < tempDeletefileID.length; i++) {
                form.append('tempDelete[]', tempDeletefileID[i]);
            }

            var businessName = document.querySelector('.business-name').value;
            var address =  document.querySelector('.address').value;
            var owner =  document.querySelector('.owner').value;
            var tinCode1 =  document.querySelector('.tin-1-edit').value;
            var tinCode2 =  document.querySelector('.tin-2-edit').value;
            var tinCode3 = document.querySelector('.tin-3-edit').value;
            var tinCode4 = document.querySelector('.tin-4-edit').value;
            var vatStatus = $(".vat-status").val();
            var corStatus = $(".cor-status").val();
            var registrationDate = document.querySelector('.registration-date').value;
            var existingCor = $("#existing-cor").val();
            var existingNetworkId = $("#row-index-network").val();
            form.append("existingCor", existingCor);
            form.append("networkId", existingNetworkId);

            if (
                businessName.trim() == ""
                || address.trim() == ""
                || owner.trim() == ""
                || tinCode1.trim() == ""
                || tinCode2.trim() == ""
                || tinCode3.trim() == ""
                || tinCode4.trim() == ""){
                alert("COR Fields cannot be empty");
                return;
            }

            var getNoValue=0;
            for (var imageIndex = 1; imageIndex <= 6; imageIndex++){
                var getImageValue = $("#imgValue-" + imageIndex).val();

                if(!getImageValue){
                    getNoValue++;
                }

                if (getNoValue == 6){
                    alert("COR Fields cannot be empty");
                    return;
                }
            }

            var getCount = fileList.length;
            var totalSize = 0;
            for (var getImageIndex = 0; getImageIndex < getCount; ++getImageIndex){

                var getImageName = fileList[getImageIndex].name.split(".");
                if ($.inArray(getImageName[getImageName.length - 1].toLowerCase(), ["jpeg", "jpg", "png"]) == -1) {                        alert("Image(s) file type in invalid only accepts 'jpeg', 'jpg', 'png' only");
                    return;
                }

                var getImageName = fileList[getImageIndex].size;
                totalSize = +totalSize + +getImageName;

                if (totalSize >= 8388608) {
                    alert("The total file size of all image(s) was reach the 8 mb uploading file size limit. Please reduce the image that you are uploading");
                    return;
                }
            }

            var tin = tinCode1 + "" + tinCode2 + "" + tinCode3 + "" + tinCode4;

            if (tin.length > 0 && ! tin.match(/^\d+$/)) {
                alert("Invalid TIN input");
                return;
            }

            if (! (tin.length == 12 || tin.length == 13 || tin.length == 14)) {
                alert("Invalid TIN input");
                return;
            }

            tin = tinCode1 + "" + tinCode2 + "" + tinCode3;

            if (parseInt(tin) == 0 &&  parseInt(tinCode4) > 0) {
                alert("Invalid TIN input");
                return;
            }

            for (var imageIndex = 0; imageIndex < 6; imageIndex++) {

                var getImageValue = $("#imgValue-"+(imageIndex+1)).val();

                if (getImageValue){
                    $(".image-thumbnail-" + (imageIndex+1)).attr("src", "assets/images/loading.gif");
                } else {
                    continue;
                }
            }

            $(".cor-popup input[type='button']").prop("disabled", true);

        $.ajax({
            url: "<?=base_url()?>clientdetails/checkVat",
            type: "POST",
            data: {
                id : globalHeadId,
                tin : tin,
                tin_branch : tinCode4,
                new_status : vatStatus,
                networkId: existingNetworkId,
                existingCor: existingCor,
                branchId: globalBranchId
            },
            dataType: 'json',
            success: function(data)
            {
            var continueUpdate = false;
                if (data.status_code == 100) {
                    if (data.branch_to_update_count > 0) {
                        $("#affected-branches-table tr").remove();
                        $("#affected-branches-table").append('<tr><td></td><td></td><td></td><td></td></tr>');
                        var tableRowData = "";
                        for (var i = 0; i < data.branch_to_update_count; i++) {
                            tableRowData = "<tr>";
                            tableRowData += "<td class='alert-group-name'>" + data.data.group_name[i] + "</td>";
                            tableRowData += "<td class='alert-branch-id'>" + data.data.branch_id[i] + "</td>";
                            tableRowData += "<td class='alert-branch-name'>" + data.data.branch_name[i] + "</td>";
                            tableRowData += "<td class='alert-branch-tin'>" + data.data.tin[i] + "</td>";
                            tableRowData += "</tr>";
                            $("#affected-branches-table tr:last").after(tableRowData);
                        }
                        $("#vat-status-action").text(data.change_message);
                        $(".custom-alert-button-container input[type='button']").prop("disabled", false);
                        $(".loading-icon-1").hide();
                        $(".loading-icon-2").hide();
                        $(".loading-icon-3").hide();
                        $(".loading-icon-4").hide();
                        $(".loading-icon-5").hide();
                        $(".loading-icon-6").hide();
                        $(".custom-alert").show();
                    } else {
                        continueUpdate = true;
                    }
                } else if (data.status_code == 200) {
                    continueUpdate = true;
                } else if (data.status_code == 201) {
                    alert("Inputted TIN already exists.");
                    updaterecord_flag = 0;
                }

            if (continueUpdate) {
            $.ajax({
                url: "<?=base_url()?>clientdetails/saveCORTable",
                type: "POST",
                data: {
                    head_id: globalHeadId,
                    existingCor: existingCor,
                    networkId: existingNetworkId,
                    businessname : businessName,
                    address : address,
                    owner: owner,
                    tin : tin,
                    vatstatus : vatStatus,
                    corStatus: corStatus,
                    registrationdate : registrationDate,
                    tin_branch : tinCode4
                },
                dataType: 'json',
                success: function(data)
                {
                    form.append("COR_id", data.CCL_id);
                    if (data.vatValidationMessage != "") {
                        alert(data.vatValidationMessage);
                        $(".vat-status").val(data.vat_status);
                        $(".cor-status").val(data.corStatus);
                        $.ajax({
                            url: "<?=base_url()?>clientdetails/uploadAttachment",
                            type: "POST",
                            data: form,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "json",
                            success: function(data)
                            {
                                if (data.response_code == 300) {
                                    alert('Image File deleting not complete');
                                }
                                $(".loading-icon-1").hide();
                                $(".loading-icon-2").hide();
                                $(".loading-icon-3").hide();
                                $(".loading-icon-4").hide();
                                $(".loading-icon-5").hide();
                                $(".loading-icon-6").hide();
                                displayCorDetails(globalHeadId);
                                $(".cor-popup input[type='button']").prop("disabled", false);
                                if (data.response_code == 100 || data.response_code == 200) {
                                    myjstbl_pul.setvalue_to_rowindex_tdclass(
                                    ["", ""],
                                    globalRowIndex,
                                    colarray_pul['corDocument'].td_class
                                    );

                                    if (data.existingCor > 1) {
                                        alert("This COR is shared with other branches therefore any changes that has made in this COR details will also reflect to other shared branches.");
                                    } else {
                                        alert("Saved");
                                    }
                                    clearCorDetails();
                                } else if (data.response_code == 400) {
                                    alert("Invalid file type.");
                                } else if (data.response_code == 500) {
                                    alert("Internal server error. Please try again.");
                                }

                                if (data.response_code == 100 || data.response_code == 200) {
                                    $("#tab-permit").show();
                                    $("#tin-number").val(tin+""+tinCode4);
                                }
                            }
                        });
                    } else if ($("#file-name-1").text() != "No file attached"
                                || $("#file-name-2").text() != "No file attached"
                                || $("#file-name-3").text() != "No file attached"
                                || $("#file-name-4").text() != "No file attached"
                                || $("#file-name-5").text() != "No file attached"
                                || $("#file-name-6").text() != "No file attached") {
                        $.ajax({
                            url: "<?=base_url()?>clientdetails/uploadAttachment",
                            type: "POST",
                            data: form,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "json",
                            success: function(data)
                            {
                                if (data.response_code == 300) {
                                    alert('Image File deleting not complete');
                                }
                                $(".loading-icon-1").hide();
                                $(".loading-icon-2").hide();
                                $(".loading-icon-3").hide();
                                $(".loading-icon-4").hide();
                                $(".loading-icon-5").hide();
                                $(".loading-icon-6").hide();
                                displayCorDetails(globalHeadId);
                                $(".cor-popup input[type='button']").prop("disabled", false);
                                if (data.response_code == 100 || data.response_code == 200) {
                                    if (data.existingCor > 1) {
                                        alert("This COR is shared with other branches therefore any changes that has made in this COR details will also reflect to other shared branches.");
                                    } else {
                                        alert("Saved");
                                    }
                                    clearCorDetails();
                                } else if (data.response_code == 400) {
                                    alert("Invalid file type.");
                                } else if (data.response_code == 500) {
                                    alert("Internal server error. Please try again.");
                                }
                            }
                        });
                    } else {
                        $(".loading-icon-1").hide();
                        $(".loading-icon-2").hide();
                        $(".loading-icon-3").hide();
                        $(".loading-icon-4").hide();
                        $(".loading-icon-5").hide();
                        $(".loading-icon-6").hide();
                        $(".cor-popup input[type='button']").prop("disabled", false);
                        displayCorDetails(globalHeadId);
                        alert("Saved");
                        clearCorDetails();
                    }
                updateLogScreen();

                }
            });

            }

        $("#continue-and-save-button").unbind("click").click(function(){
            $(".custom-alert-button-container input[type='button']").prop("disabled", true);
            for (var imageIndex = 0; imageIndex < 6; imageIndex++) {

                var getImageValue = $("#imgValue-"+(imageIndex+1)).val();

                if (getImageValue){
                    $(".image-thumbnail-" + (imageIndex+1)).attr("src", "assets/images/loading.gif");
                } else {
                    continue;
                }
            }
            $(".custom-alert").hide();
            continueUpdate = true;

            if (continueUpdate) {
            $.ajax({
                url: "<?=base_url()?>clientdetails/saveCORTable",
                type: "POST",
                data: {
                    head_id: globalHeadId,
                    existingCor: existingCor,
                    networkId: existingNetworkId,
                    businessname : businessName,
                    address : address,
                    owner: owner,
                    tin : tin,
                    vatstatus : vatStatus,
                    corStatus: corStatus,
                    registrationdate : registrationDate,
                    tin_branch : tinCode4
                },
                dataType: 'json',
                success: function(data)
                {
                    form.append("COR_id", data.CCL_id);
                    if (data.vatValidationMessage != "") {
                        alert(data.vatValidationMessage);
                        $(".vat-status").val(data.vat_status);
                        $(".cor-status").val(data.corStatus);
                        $.ajax({
                            url: "<?=base_url()?>clientdetails/uploadAttachment",
                            type: "POST",
                            data: form,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "json",
                            success: function(data)
                            {
                                $(".loading-icon-1").hide();
                                $(".loading-icon-2").hide();
                                $(".loading-icon-3").hide();
                                $(".loading-icon-4").hide();
                                $(".loading-icon-5").hide();
                                $(".loading-icon-6").hide();
                                displayCorDetails(globalHeadId);
                                $(".cor-popup input[type='button']").prop("disabled", false);
                                if (data.response_code == 100 || data.response_code == 200) {
                                    myjstbl_pul.setvalue_to_rowindex_tdclass(
                                    ["", ""],
                                    globalRowIndex,
                                    colarray_pul['corDocument'].td_class
                                    );

                                    if (data.existingCor > 1) {
                                        alert("This COR is shared with other branches therefore any changes that has made in this COR details will also reflect to other shared branches.");
                                    } else {
                                        alert("Saved");
                                    }
                                    clearCorDetails();
                                } else if (data.response_code == 400) {
                                    alert("Invalid file type.");
                                } else if (data.response_code == 500) {
                                    alert("Internal server error. Please try again.");
                                }
                            }
                        });
                    } else if ($("#file-name").text()!= "No file attached") {
                        $.ajax({
                            url: "<?=base_url()?>clientdetails/uploadAttachment",
                            type: "POST",
                            data: form,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "json",
                            success: function(data)
                            {
                                $(".loading-icon-1").hide();
                                $(".loading-icon-2").hide();
                                $(".loading-icon-3").hide();
                                $(".loading-icon-4").hide();
                                $(".loading-icon-5").hide();
                                $(".loading-icon-6").hide();
                                displayCorDetails(globalHeadId);
                                $(".cor-popup input[type='button']").prop("disabled", false);
                                if (data.response_code == 100 || data.response_code == 200) {
                                    if (data.existingCor > 1) {
                                        alert("This COR is shared with other branches therefore any changes that has made in this COR details will also reflect to other shared branches.");
                                    } else {
                                        alert("Saved");
                                    }
                                    clearCorDetails();
                                } else if (data.response_code == 400) {
                                    alert("Invalid file type.");
                                } else if (data.response_code == 500) {
                                    alert("Internal server error. Please try again.");
                                }
                            }
                        });
                    } else {
                        $(".loading-icon-1").hide();
                        $(".loading-icon-2").hide();
                        $(".loading-icon-3").hide();
                        $(".loading-icon-4").hide();
                        $(".loading-icon-5").hide();
                        $(".loading-icon-6").hide();
                        $(".cor-popup input[type='button']").prop("disabled", false);
                        displayCorDetails(globalHeadId);
                        alert("Saved");
                        clearCorDetails();
                    }
                updateLogScreen();
                }
            });

            }
        });
            }
        });


        });
        
        uncheck_all();


        if($('#filterclienthead').val() > 0)
        {
            pul_refresh_table();
        }
        else if($('#filterclientgroup').val() > 0)
        {
            refresh_cleinthead_ddl();
        }



        my_autocomplete_add(".txtlocation_name", "<?=base_url()?>clientdetails/ac_locationid", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl_pul.setvalue_to_rowindex_tdclass(["0"],row_index,colarray_pul['location_id'].td_class);
                    myjstbl_pul.setvalue_to_rowindex_tdclass([""],row_index,colarray_pul['location_name'].td_class);
                }
                else {
                    myjstbl_pul.setvalue_to_rowindex_tdclass([value],row_index,colarray_pul['location_id'].td_class);
                    myjstbl_pul.setvalue_to_rowindex_tdclass([label],row_index,colarray_pul['location_name'].td_class);  
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                    { width : ["40px","400px"] });
            }
            });  

    });
    
    var arr = [];
    $(function() {
        // P.U.L2

        myjstbl_pul2 = new my_table(tab_pul2, colarray_pul2, {ispaging : true,
                                                iscursorchange_when_hover : true});

        var root_pul2 = document.getElementById("tbl_pul2");
        root_pul2.appendChild(myjstbl_pul2.tab);
        //root_pul2.appendChild(myjstbl_pul2.mypage.pagingtable);


        myjstbl_pul2.mypage.set_mysql_interval(100000);
        myjstbl_pul2.mypage.isOldPaging = true;
        //myjstbl_pul2.mypage.pass_refresh_filter_page(pul_refresh_table2);

        
        //pul_refresh_table2();
        
        $("#txtsearch").keypress( 
        function(e)
        {
            if(e.keyCode == 13)
            {
                //pul_refresh_table2();
            }
        });

    });

    $( document ).ready(function() {
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/getAccredList",
            type: "POST",
            dataType: "json",
            success: function(data)
            {
                $.each(data, function (i, item) {
                    item = item.split("_");
                    var acc = item[0];
                    var provider = item[1];

                    $("#accredlist").append("<option value='"+ acc.replace("ACC: ","") +"' data-provider='"+ provider +"'>"+ acc +"</option>");
                    refreshAccList();
                });
            }
        });

        <?php if ($isManagementPosition || $isAccountingPosition) { ?>
        $('input[type=radio][name=corAttributes]').change(function() {
            if (this.value == '1') {
                $('#manualAddNew').hide();
                $('#manualAddRow').hide();
                $('#file-upload-ptu').attr("disabled", false);
                $('#upload-file-button').attr("disabled", false);
                $('#manualEditButton').hide();
                $('#manualUpdateButton').hide();
            } else {
                $('#manualAddNew').show();
                $('#file-upload-ptu').attr("disabled", true);
                $('#upload-file-button').attr("disabled", true);
            }

            $('#manualSaveButton').hide();
            $("#table-information").hide();
            $("#table-units").hide();
            $("#table-information-manual").hide();
            $("#table-units-manual").hide();
            clearManualPTUDetails();
        });

        $(".right-div :input").attr("disabled", true);
        $(".manualBtn :input").attr("disabled", true);

        $(".manual-registration-date").datepicker({dateFormat: 'yy-mm-dd'});

        <?php } ?>

        $("#accredlist").on("change", function(){
            refreshAccList();
        });
    });
    
    function deleteAttachedImage(getnum)
    {
        var getImageValue = $('#imgValue-'+ getnum).val();
        var getFilename = $('#file-name-'+ getnum).text();
        var getCORID = $("[name='cor-id']").val();

        if (getImageValue == '.' || getImageValue == null) {
            var confirmRemove = 
                confirm(
                    "Are you sure you want to remove the attachment?"
                );

            if (confirmRemove){

                $(".image-thumbnail-" + getnum).attr("src", "");
                $(".image-thumbnail-" + getnum).hide();
                $(".file-name-" + getnum).hide();
                $("#file-name-" + getnum).text("No file attached");
                $("#file-name-" + getnum).hide();
                $("#image-delete-" + getnum).hide();
                $("#imgValue-" + getnum).val("");

                var totalImageCount = $("#totalImageCount").val();
                totalImageCount -= 1;
                $("#totalImageCount").val(totalImageCount);

                for (var removeFileIndex = 0 ; removeFileIndex < fileList.length; removeFileIndex++) {
                    if (fileList[removeFileIndex].name == getFilename){
                        fileList.splice(removeFileIndex, 1);
                    }
                }
            }
        }

        if (getImageValue != "." && getCORID != ""){
            var confirmRemove = 
                confirm(
                    "Are you sure you want to remove the attachment permanently?"
                );
            if (confirmRemove){

                tempDeletefileID.push(getImageValue);

                $(".image-thumbnail-" + getnum).attr("src", "");
                $(".image-thumbnail-" + getnum).hide();
                $("#file-name-" + getnum).text("No file attached");
                $("#file-name-" + getnum).hide();
                $(".file-name-" + getnum).hide();
                $("#image-delete-" + getnum).hide();
                $("#imgValue-" + getnum).val("");

                var totalImageCount = $("#totalImageCount").val();
                totalImageCount -= 1;
                $("#totalImageCount").val(totalImageCount);
            }
        }

        var totalImageCount = $("#totalImageCount").val();

        if (totalImageCount < 6){
            $("#select-file-button[type='button']").prop("disabled", false);
        } else {
            $("#select-file-button[type='button']").prop("disabled", true);
        }
    }

    function refreshAccList(){
        var softwareName = $("#accredlist").find(':selected').data("provider");

        softwareName == "-" ? softwareName = "" : softwareName;

        $("#provider-name").html(softwareName);
    }

    function getAccredName(accreditationNumber)
    {
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/getAccredList",
            type: "POST",
            dataType: "json",
            success: function(data)
            {
                for (var i = 0; i < data.length; i++) {
                    var myArray = data[i].split("_");

                    var accrednumber = myArray[0];
                    var provider = myArray[1];

                    if (accreditationNumber == accrednumber) {
                        var accreditationNumberSplitted = accreditationNumber.split("ACC: ");
                        
                        if (accreditationNumber == "None") {
                            $(".span-spm-accreditation").text(accreditationNumber + " - " + provider);
                        } else {
                            $(".span-spm-accreditation").text(accreditationNumberSplitted[1] + " - " + provider);
                        }

                        break;
                    }
                }
            }
        });
    }

    $(".spnid_cnt").live("mouseover",function(){
        var clientdetailidsearch = $(this).parent().parent().find(".spnid_cnt").html();
        $(this).attr("href","clientdetails?clientdetailid=" + clientdetailidsearch);
    });

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

    // One edit at a time
    $('#edit_pul').live("click",function() {
            
            $('#lblStatus').css('visibility', 'hidden');
            $('#lblStatus').attr('class', 'alert alert-danger');
            var a = $(this).parent().parent().index();
            var count = myjstbl_pul.get_row_count() - 1;
            // $(".date").datepicker({dateFormat: 'yy-mm-dd'});
            if (($('.edit_pul').attr("onClick") == undefined) && ( count !=2 )) {
                $('#lblStatus').css('visibility', 'visible');
                $('#lblStatus').text("Save the other data first!");
            }
        });
        
        
    // One edit at a time
    $('#edit_pul2').live("click",function() {
            $('#lblStatus').css('visibility', 'hidden');
            $('#lblStatus').attr('class', 'alert alert-danger');
            var a = $(this).parent().parent().index();
            var count = myjstbl_pul2.get_row_count() - 1;
            // $(".date").datepicker({dateFormat: 'yy-mm-dd'});
            if (($('.edit_pul2').attr("onClick") == undefined) && ( count !=2 )) {
                $('#lblStatus').css('visibility', 'visible');
                $('#lblStatus').text("Save the other data first!");
            }
        });

    $(".tin-1-edit, .tin-2-edit, .tin-3-edit, .tin-4-edit").live("keyup", function(event){
        if (event.keyCode != 13) {
            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                if (this.value.length == this.maxLength && (this.value != "000" || this.value != "00000")) {
                    next_focus(this);
                }
            }
        }
    });

    $(".tin-1-edit, .tin-2-edit, .tin-3-edit, .tin-4-edit").live("focus", function(event){
        $(this).select();
    });

    $('#button-addnew').die("click").live('click', function()
    {
        if (
            $(".business-name").val() != ""
            || $(".address").val() != ""
            || $(".owner").val() != ""
            || $(".tin-1-edit").val() != ""
            || $(".tin-2-edit").val() != ""
            || $(".tin-3-edit").val() != ""
            || $(".tin-4-edit").val() != ""
            || $("#file-name-1").text() != "No file attached"
            || $(".registration-date").val() != "0000-00-00"
        ) {
            var answer =
                confirm("Are you sure you want to add new entry? This will clear out all values in the fields.");
            if (answer) {
                clearCorDetails();
                $(".business-name").focus();
                $("#table-ptu").hide();
                $("#table-information").hide();
                $("#table-units").hide();
                $(".upload-ptu").prop('disabled', true);
                $(".right-div :input").attr("disabled", true);
                $(".manualBtn :input").attr("disabled", true);
                $("#table-information-manual").hide();
                $("#table-units-manual").hide();

                $('#uploadImage img').hide();
                $("#totalImageCount").val(0);

                fileList = [];
                tempDeletefileID = [];

                $(".business-name").prop("disabled", false);
                $(".address").prop("disabled", false);
                $(".owner").prop("disabled", false);
                $(".tin-1-edit").prop("disabled", false);
                $(".tin-2-edit").prop("disabled", false);
                $(".tin-3-edit").prop("disabled", false);
                $(".tin-4-edit").prop("disabled", false);
                $(".vat-status").prop("disabled", false);
                $(".cor-status").prop("disabled", false);
                $(".registration-date").prop("disabled", false);
                $("#save-uploaded-file[type='button']").prop("disabled", false);
                $("#select-file-button[type='button']").prop("disabled", false);
            } else {
                return;
            }
        } else {
            $(".right-div :input").attr("disabled", true);
            $(".manualBtn :input").attr("disabled", true);
            return;
        }
    });

     $("#manualAddNew").die("click").live('click', function() {
         $("#table-information-manual").show();
         $("#table-information").hide();
         $("#table-units").hide();
         $("#table-units-manual").show();
         $('#manualAddRow').show();
         $('#manualSaveButton').show();
         $('#manualEditButton').hide();
         $('#manualUpdateButton').hide();
         $("#table-information-manual input[type='text']").show();
         $("#table-information-manual select").show();
         $("#table-information-manual span").hide();
         $(".manual-span-tin-branch-code").show();
         clearManualPTUDetails();
         myJsTableManualPtuUnit.clear_table();
         myJsTableManualPtuUnit.add_new_row();
         $("#trMachineSetup").show();
         $("#trOtherNames").show();
         $("#trOtherNames1").show();
         $("#trOtherNames2").show();
         $("#trOtherNames3").show();
         $("#trOtherNames4").show();
    });

    $("#manualAddRow").die("click").live('click', function() {
        myJsTableManualPtuUnit.add_new_row();
    });

    /**
     * Edit Manual PTU Head and Detail
     */
    function editManualPTUHeadandDetail()
    {
        $("#table-units-manual").show();
        $("#table-units").hide();

        var cnt = myJsTableManualPtuUnit.get_row_count();

        if (cnt == 1) {
            myJsTableManualPtuUnit.add_new_row();
        }

        $('#manualEditButton').hide();
        $('#manualUpdateButton').show();
        $('#manualAddRow').show();

        var spanManualTransaction = $("#spanManualTransaction").text();
        $("#updateManualTransaction").val(spanManualTransaction);
        var spanManualPermitType = $("#spanManualPermitType").text();
        var spanManualMachineSetup = $("#spanManualMachineSetup").text();
        var spanManualRDOCode = $("#spanManualRDOCode").text();
        var manualTIN = $("#manualTIN").text();
        var spanManualRegisteredName = $("#spanManualRegisteredName").text();

        var spanManualFirstName = $("#spanManualFirstName").text();
        var spanManualMiddleName = $("#spanManualMiddleName").text();
        var spanManualLastName = $("#spanManualLastName").text();
        var spanManualExtentionName = $("#spanManualExtentionName").text();

        var spanManualBusinessName = $("#spanManualBusinessName").text();
        var spanManualBusinessAddress = $("#spanManualBusinessAddress").text();
        var spanAccreditationNumber = $("#spanAccreditationNumber").text();
        var spanManualEffectiveDate = $("#spanManualEffectiveDate").text();

        $("#spanManualTransaction").hide();
        $("#spanManualPermitType").hide();
        $("#spanManualMachineSetup").hide();
        $("#spanManualRDOCode").hide();
        $("#spanManualRegisteredName").hide();
        $("#spanManualFirstName").hide();
        $("#spanManualMiddleName").hide();
        $("#spanManualLastName").hide();
        $("#spanManualExtentionName").hide();
        $("#spanManualBusinessName").hide();
        $("#spanManualBusinessAddress").hide();
        $("#spanAccreditationNumber").hide();
        $("#spanManualEffectiveDate").hide();

        $("#manualTransaction").show();
        $("#manualPermitType").show();
        $("#manualMachineSetup").show();
        $("#manualRDOCode").show();
        $("#manualRegisteredName").show();
        $("#manualFirstName").show();
        $("#manualMiddleName").show();
        $("#manualLastName").show();
        $("#manualExtentionName").show();
        $("#manualBusinessName").show();
        $("#manualBusinessAddress").show();

        $("#manualTransaction").val(spanManualTransaction);
        $("#manualPermitType").val(spanManualPermitType);
        $("#manualMachineSetup").val(spanManualMachineSetup);
        $("#manualRDOCode").val(spanManualRDOCode);
        $("#manualRegisteredName").val(spanManualRegisteredName);

        $("#manualFirstName").val(spanManualFirstName);
        $("#manualMiddleName").val(spanManualMiddleName);
        $("#manualLastName").val(spanManualLastName);
        $("#manualExtentionName").val(spanManualExtentionName);

        $("#manualBusinessName").val(spanManualBusinessName);
        $("#manualBusinessAddress").val(spanManualBusinessAddress);

        $("#trOtherNames").show();
        $("#trOtherNames1").show();
        $("#trOtherNames2").show();
        $("#trOtherNames3").show();
        $("#trOtherNames4").show();

        if (spanManualPermitType == "Special Purpose Machine Permit") {
            $("#trMachineSetup").hide();
        }

        if (spanManualRegisteredName != ""){
            $("#manualRegisteredName").attr("disabled", false);

            $("#manualFirstName").attr("disabled", true);
            $("#manualMiddleName").attr("disabled", true);
            $("#manualLastName").attr("disabled", true);
            $("#manualExtentionName").attr("disabled", true);
        } else {
            $("#manualFirstName").attr("disabled", false);
            $("#manualMiddleName").attr("disabled", false);
            $("#manualLastName").attr("disabled", false);
            $("#manualExtentionName").attr("disabled", false);

            $("#manualRegisteredName").attr("disabled", true);
        }

        $("#accreditationNumber option").filter(function() {
          return $(this).text() == spanAccreditationNumber;
        }).prop('selected', true);

        $("#manualEffectiveDate").val(spanManualEffectiveDate);
        $("#accreditationNumber").show();
        $("#manualEffectiveDate").show();

        var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
        var countBinded = 0;
        for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
            var manualImageBound = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualImageBindPtu'].td_class
            )[0];

            var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitId'].td_class
            )[0];

            var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
            )[0];

            var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
            )[0];

            var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
            )[0];

            globalTerminalNumber[rowIndex - 1] = manualPermitNumberValue;
            globalMinNumber[rowIndex - 1] = manualMinNumberValue;
            globalSerialNumber[rowIndex - 1] = manualSerialNumberValue;

            if(manualImageBound){
                myJsTableManualPtuUnit.edit_row(rowIndex);
            } else {
                countBinded++;
            }

        }

    }

    /*
     * Evaluating the Update of table manual entry
     */
    function updateManualPTUHeadandDetail()
    { 
        var headID = $("#row-index-ptu").val();
        var existingCor = $("#existing-cor").val();
        var manualTransaction = $("#manualTransaction").val();
        var updateManualTransaction = $("#updateManualTransaction").val();
        var manualPermitType = $("#manualPermitType").val();
        var manualMachineSetup = $("#manualMachineSetup").val();
        var manualRDOCode = $("#manualRDOCode").val();
        var manualTIN = $("#manualTIN").text();

        var manualRegisteredName = $("#manualRegisteredName").val();
        var manualFirstName = $("#manualFirstName").val();
        var manualMiddleName = $("#manualMiddleName").val();
        var manualLastName = $("#manualLastName").val();
        var manualExtentionName = $("#manualExtentionName").val();

        var manualBusinessName = $("#manualBusinessName").val();
        var manualBusinessAddress = $("#manualBusinessAddress").val();
        var accreditationNumber = $("#accreditationNumber").val();
        var manualEffectiveDate = $("#manualEffectiveDate").val();

        if (manualPermitType.trim() == "None"
                || manualTIN.trim() == ""
                || manualBusinessName.trim() == ""
                || manualEffectiveDate.trim() == "0000-00-00"
            ) {
            alert("Please fill up the required field/s ");
            return;
        }

        var saveType = 0;
        if (manualRegisteredName == ""){
            if (manualFirstName == "" || manualMiddleName == "" || manualLastName == ""){
                alert("Please fill up the required field/s");
                return;
            } else {
                saveType = 1;
            }
        } else if (manualRegisteredName != "" && (manualFirstName != "" || manualMiddleName != "" || manualLastName != "" || manualExtentionName != "")){
            alert("Both registered name and Names have value");
            return;
        }

        $.ajax({
            url: "<?=base_url("clientdetails/checkUpdateManualFilePtu")?>",
            type: "POST",
            data: {
                clientBranch: headID,
                existingCor: existingCor,
                transactionNumber: manualTransaction
            },
            success: function(response)
            {   
                if (response == 1 && updateManualTransaction == manualTransaction) {
                    updateCheckPTUDetail(headID, manualTransaction, saveType);
                } else if (response > 0) {
                    alert('Transaction # must be unique within this COR');
                    return;
                } else {
                    updateCheckPTUDetail(headID, manualTransaction, saveType);
                }
            }
        });

    }

    /*
     * Evaluating of PTU Head and Detail
     */
    function saveManualPTUHeadandDetail()
    {
        var headID = $("#row-index-ptu").val();
        var existingCor = $("#existing-cor").val();

        var manualTransaction = document.querySelector("#manualTransaction").value;
        var manualPermitType = document.querySelector("#manualPermitType").value;
        var manualMachineSetup = document.querySelector("#manualMachineSetup").value;
        var manualRDOCode = document.querySelector("#manualRDOCode").value;
        var manualTIN = $(".manual-span-tin-branch-code").text();
        var manualRegisteredName = document.querySelector("#manualRegisteredName").value;
        var manualFirstName = document.querySelector("#manualFirstName").value;
        var manualMiddleName = document.querySelector("#manualMiddleName").value;
        var manualLastName = document.querySelector("#manualLastName").value;
        var manualExtentionName = document.querySelector("#manualExtentionName").value;
        var manualBusinessName = document.querySelector("#manualBusinessName").value;
        var manualBusinessAddress = document.querySelector("#manualBusinessAddress").value;
        var accreditationNumber = document.querySelector("#accreditationNumber").value;
        var manualRegistrationDate = document.querySelector(".manual-registration-date").value;
        var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
        
        for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
            var manualImageBound = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualImageBindPtu'].td_class
            )[0];

            var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitId'].td_class
            )[0];

            var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
            )[0];

            var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
            )[0];

            var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
            )[0];

            globalTerminalNumber[rowIndex - 1] = manualPermitNumberValue;
            globalMinNumber[rowIndex - 1] = manualMinNumberValue;
            globalSerialNumber[rowIndex - 1] = manualSerialNumberValue;

        }

        if ( manualPermitType.trim() == "None"
                || manualTIN.trim() == ""
                || manualBusinessName.trim() == ""
                || manualRegistrationDate.trim() == "0000-00-00"
            ) {
            alert("Please fill up the required field/s ");
            return;
        }

        var saveType = 0;
        if (manualRegisteredName == ""){
            if (manualFirstName == "" || manualMiddleName == "" || manualLastName == ""){
                alert("Please fill up the required field/s");
                return;
            } else {
                saveType = 1;
            }
        } else if (manualRegisteredName != "" && (manualFirstName != "" || manualMiddleName != "" || manualLastName != "" || manualExtentionName != "")){
            alert("Both registered name and Names have value");
            return;
        }

        $(".loading-icon").show();
        $.ajax({
            url: "<?=base_url("clientdetails/checkUpdateManualFilePtu")?>",
            type: "POST",
            data: {
                clientBranch: headID,
                existingCor: existingCor,
                transactionNumber: manualTransaction
            },
            success: function(response)
            {
                var count = rowCount;
                if (response > 0) {
                     alert('Transaction # must be unique within this COR');
                     return;
                } else {
                    var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
                    var countAlert = 0;
                    var count = rowCount;

                    for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
                        var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            columnManualPtuUnit['columnManualPtuUnitId'].td_class
                        )[0];

                        var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
                        )[0];

                        var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
                        )[0];

                        var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                            rowIndex,
                            columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
                        )[0];

                        if (manualPermitNumberValue == "" ||
                            manualMinNumberValue == "" ||
                            manualSerialNumberValue == "") {
                            countAlert++;
                            continue;
                        }

                        var countDuplicateTerminal = 0;
                        var countDuplicateMin = 0;
                        var countDuplicateSerial = 0;

                        for (var index = 1; index <= rowCount; index++) {
                            if (manualPermitNumberValue == globalTerminalNumber[index - 1]){
                                countDuplicateTerminal++;
                            }

                            if (manualMinNumberValue == globalMinNumber[index - 1]){
                               countDuplicateMin++;
                            }

                            if (manualSerialNumberValue == globalSerialNumber[index - 1]) {
                                countDuplicateSerial++;
                            }

                        }

                        if (countDuplicateTerminal > 1 || countDuplicateMin > 1 || countDuplicateSerial > 1){
                            alert('Duplicate Entry!');
                            break;
                        } else if (countDuplicateTerminal == 1 || countDuplicateMin == 1 || countDuplicateSerial == 1){
                            count--;

                            if(count == 0 && rowCount == rowIndex){
                                saveManualPTIHeadandDetailFinal(saveType);
                            }

                        }
                    }

                    if (countAlert > 0) {
                        $(".text-manual-ptu-permit-number").last().focus();
                        alert('Please fill up the required field/s');
                        return;
                    }

                }

            }

        });

    }

    /*
     * checking the table manual entry before updating
     * @param {int}  headID  [Head Id of table]
     * @param {string}  manualTransaction  [Manual Transaction]
     * @param {int}  type  [saving type = 0: registeredName; type = 1: All names]
     */
    function updateCheckPTUDetail(headID, manualTransaction, type)
    {
        var getPTUID = $('#ptu-ids').val();
        var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
        var countAlert = 0;
        var count = rowCount;

        for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
            var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitId'].td_class
            )[0];

            var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
            )[0];

            var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
            )[0];

            var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
            )[0];

            if (manualPermitNumberValue == "" ||
                manualMinNumberValue == "" ||
                manualSerialNumberValue == "") {
                countAlert++;
                continue;
            }

            var countDuplicateTerminal = 0;
            var countDuplicateMin = 0;
            var countDuplicateSerial = 0;

            for (var index = 1; index <= rowCount; index++) {
                if (manualPermitNumberValue == globalTerminalNumber[index - 1]){
                    countDuplicateTerminal++;
                }

                if (manualMinNumberValue == globalMinNumber[index - 1]){
                   countDuplicateMin++;
                }

                if (manualSerialNumberValue == globalSerialNumber[index - 1]) {
                    countDuplicateSerial++;
                }

            }

            if (manualIdValue > 0 && (countDuplicateTerminal == 1 || countDuplicateMin == 1 || countDuplicateSerial == 1)){
                count--;
                checkDuplicateLocalTable(
                    rowIndex,
                    manualPermitNumberValue,
                    manualMinNumberValue,
                    manualSerialNumberValue);
            } else if ((manualIdValue == "" || manualIdValue == null) && (countDuplicateTerminal == 1 || countDuplicateMin == 1 || countDuplicateSerial == 1)){
                count++;
                alert('Duplicate New Entry');  
            } else {
                count--;
                checkDuplicateLocalTable(
                    rowIndex,
                    manualPermitNumberValue,
                    manualMinNumberValue,
                    manualSerialNumberValue);
            }

            if(count == 0 && rowCount == rowIndex){
                updateManualPTIHeadandDetailFinal(type);
            }

        }

        if (countAlert > 0) {
            $(".text-manual-ptu-permit-number").last().focus();
            alert('Please fill up the required field/s');
            return;
        }

    }

    /*
     * Updating the table manual entry
     * @param {int}  type  [saving type = 0: registeredName; type = 1: All names]
     */
    function updateManualPTIHeadandDetailFinal(type)
    {
        var headID = $("#row-index-ptu").val();
        var existingCor = $("#existing-cor").val();
        var getPTUID = $('#ptu-ids').val();
        var getCORID = $('#cor-ids').val();
        var manualTransaction = document.querySelector("#manualTransaction").value;
        $('#ptuTransaction').val(manualTransaction);
        var getTransaction = $('#ptuTransaction').val();
        var manualPermitType = document.querySelector("#manualPermitType").value;
        var manualMachineSetup = document.querySelector("#manualMachineSetup").value;
        var manualRDOCode = document.querySelector("#manualRDOCode").value;
        var manualTIN = $(".manual-span-tin-branch-code").text();

        var manualRegisteredName = document.querySelector("#manualRegisteredName").value;
        var manualFirstName = document.querySelector("#manualFirstName").value;
        var manualMiddleName = document.querySelector("#manualMiddleName").value;
        var manualLastName = document.querySelector("#manualLastName").value;
        var manualExtentionName = document.querySelector("#manualExtentionName").value;

        var manualBusinessName = document.querySelector("#manualBusinessName").value;
        var manualBusinessAddress = document.querySelector("#manualBusinessAddress").value;
        var accreditationNumber = document.querySelector("#accreditationNumber").value;
        var manualRegistrationDate = document.querySelector(".manual-registration-date").value;
        
        if (manualPermitType == "Special Purpose Machine Permit") {
            manualMachineSetup = "";
        }

        var showOtherName = "";
        if (!type){
           manualFirstName = "";
           manualMiddleName = "";
           manualLastName = "";
           manualExtentionName = "";

           showOtherName = "registered_name"; 
        } else {
           manualRegisteredName = "";

           showOtherName = "first_name~u~middle_name~u~last_name~u~extension_name";
        }

        $.ajax({
            url: "<?=base_url("clientdetails/updateManualPtuHeadFinal")?>",
            type: "POST",
            data: {
                updatePtuID: getPTUID,
                updateClientBranch: headID,
                updateExistingCor: existingCor,
                updateTransactionNumber: manualTransaction,
                updatePermitType: manualPermitType,
                updateMachineSetup: manualMachineSetup,
                updateRdoCode: manualRDOCode,
                updateTinBranchCode: manualTIN,
                updateRegisteredName: manualRegisteredName,
                updateManualFirstName: manualFirstName,
                updateManualMiddleName: manualMiddleName,
                updateManualLastName: manualLastName,
                updateManualExtentionName: manualExtentionName,
                updateShowOtherName: showOtherName,
                updateBusinessName: manualBusinessName,
                updateBusinessAddress: manualBusinessAddress
            },
            success: function(response)
            {   
                var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
                var count = 0;

                for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
                    var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuUnitId'].td_class
                    )[0];

                    var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
                    )[0];

                    var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
                    )[0];

                    var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
                    )[0];

                        $.ajax({
                            url: "<?=base_url("clientdetails/updateManualPtuDetailFinal")?>",
                            type: "POST",
                            data: {
                                updatePtuID: getPTUID,
                                clientBranch: headID,
                                ptuUnitsId: manualIdValue,
                                transactionNumber: manualTransaction,
                                permitNumber: manualPermitNumberValue,
                                minNumber: manualMinNumberValue,
                                serialNumber: manualSerialNumberValue,
                                accreditationNumber: accreditationNumber,
                                effectiveDate: manualRegistrationDate
                            },
                            success: function(data) {
                                $.ajax({
                                    url: "<?=base_url("clientdetails/updateManualPTUDetailsTransaction")?>",
                                    type: "POST",
                                    data: {
                                        updatePtuID: getPTUID,
                                        updateTransaction: manualTransaction
                                    },
                                    success: function(response){}
                                });
                            }
                        });
                    }

                alert('UPDATE SUCCESSFULLY!');
                clearManualPTUDetails();
                var getCORID = $("[name='cor-id']").val();
                getCorDetails(getCORID);
                $("#table-information-manual").hide();
                $("#table-units-manual").hide();
                $("#table-units").hide();
                $('#manualAddRow').hide();
                $('#manualSaveButton').hide();
                $('#manualEditButton').hide();
                $('#manualUpdateButton').hide();
            }

        });

    }

    /*
    * Saving the data into the database 
    * @param {int}  type  [saving type = 0: registeredName; type = 1: All names]
    */ 
    function saveManualPTIHeadandDetailFinal(type)
    {
        var headID = $("#row-index-ptu").val();
        var existingCor = $("#existing-cor").val();
        var getPTUID = $('#ptu-ids').val();
        var getCORID = $('#cor-ids').val();

        var manualTransaction = document.querySelector("#manualTransaction").value;
        var manualPermitType = document.querySelector("#manualPermitType").value;
        var manualMachineSetup = document.querySelector("#manualMachineSetup").value;
        var manualRDOCode = document.querySelector("#manualRDOCode").value;
        var manualTIN = $(".manual-span-tin-branch-code").text();
        var manualRegisteredName = document.querySelector("#manualRegisteredName").value;
        var manualFirstName = document.querySelector("#manualFirstName").value;
        var manualMiddleName = document.querySelector("#manualMiddleName").value;
        var manualLastName = document.querySelector("#manualLastName").value;
        var manualExtentionName = document.querySelector("#manualExtentionName").value;
        var manualBusinessName = document.querySelector("#manualBusinessName").value;
        var manualBusinessAddress = document.querySelector("#manualBusinessAddress").value;
        var accreditationNumber = document.querySelector("#accreditationNumber").value;
        var manualRegistrationDate = document.querySelector(".manual-registration-date").value;
        
        var showOtherName = ""
        if (!type){
           manualFirstName = "";
           manualMiddleName = "";
           manualLastName = "";
           manualExtentionName = "";

           showOtherName = "registered_name"; 
        } else {
           manualRegisteredName = "";

           showOtherName = "first_name~u~middle_name~u~last_name~u~extension_name";
        }

        $.ajax({
            url: "<?=base_url("clientdetails/saveManualPtuHeadFinal")?>",
            type: "POST",
            data: {
                clientBranch: headID,
                existingCor: existingCor,
                transactionNumber: manualTransaction,
                permitType: manualPermitType,
                machineSetup: manualMachineSetup,
                rdoCode: manualRDOCode,
                tinBranchCode: manualTIN,
                registeredName: manualRegisteredName,
                firstName: manualFirstName,
                middleName: manualMiddleName,
                lastName: manualLastName,
                extentionName: manualExtentionName,
                showOtherName: showOtherName,
                businessName: manualBusinessName,
                businessAddress: manualBusinessAddress,
                accreditationNumber: accreditationNumber,
                registrationDate: manualRegistrationDate
            },
            success: function(response)
            {
                var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
                var count = 0;
                for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
                    var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuUnitId'].td_class
                    )[0];

                    var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
                    )[0];

                    var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
                    )[0];

                    var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                        rowIndex,
                        columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
                    )[0];

                    $.ajax({
                        url: "<?=base_url("clientdetails/saveManualPtuDetailFinal")?>",
                        type: "POST",
                        data: {
                            clientBranch: headID,
                            ptuUnitsId: manualIdValue,
                            transactionNumber: manualTransaction,
                            permitNumber: manualPermitNumberValue,
                            minNumber: manualMinNumberValue,
                            serialNumber: manualSerialNumberValue,
                            accreditationNumber: accreditationNumber,
                            effectiveDate: manualRegistrationDate
                        },
                        success: function(data) { }
                    });
                }

                alert('SUCCESSFULLY SAVED!');
                clearManualPTUDetails();
                var getCORID = $("[name='cor-id']").val();
                getCorDetails(getCORID);
                $("#table-information-manual").hide();
                $("#table-units-manual").hide();
                $("#table-units").hide();
                $('#manualAddRow').hide();
                $('#manualSaveButton').hide();
                $("#trMachineSetup").show();
            }

        });

    }

    /*
     * Updating the table manual entry
     * @param {int}  rowIndex  [Row Index key of row]
     * @param {string}  permitNumber  [Permit Number entry]
     * @param {string}  minNumber  [Min Number entry]
     * @param {string}  serialNumber  [Serial Number entry]
     * @param {string}  terminalValue  [Terminal Value entry]
     */
    function updatePTUDetailTable(rowIndex, permitNumber, minNumber, serialNumber, terminalValue)
    {
        myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
            [permitNumber],
            rowIndex,
            columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
        );

        myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
            [minNumber],
             rowIndex,
             columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
        );

        myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
            [serialNumber],
             rowIndex,
             columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
        );

        myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
            [terminalValue],
             rowIndex,
             columnManualPtuUnit['columnManualPtuTerminal'].td_class
        );

        myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
            [""],
            rowIndex,
            columnManualPtuUnit['columnManualDeletePtuUnit'].td_class
        );

        myJsTableManualPtuUnit.update_row(rowIndex);
    }

    /*
     * Checking the New Entry Table for Duplicate Entry
     * @param {int}  rowIndexFinal  [Row Index key of row]
     * @param {string}  permitNumber  [Permit Number entry]
     * @param {string}  minNumber  [Min Number entry]
     * @param {string}  serialNumber  [Serial Number entry]
     * @param {string}  terminalValue  [Terminal Value entry]
     */
    function checkDuplicateLocalTable(rowIndexFinal, permitNumber, minNumber, serialNumber, terminalValue)
    {
        var rowCount = myJsTableManualPtuUnit.get_row_count() - 1;
        var countPermitNumber = 0;
        var countMinNumber = 0;
        var countSerialNumber = 0;

        for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
            if (rowIndexFinal == rowIndex){ break; }

            var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
            )[0];

            var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
            )[0];

            var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
            )[0];

            if (manualPermitNumberValue == permitNumber || 
                manualMinNumberValue == minNumber || 
                manualSerialNumberValue == serialNumber) {
                countPermitNumber++;
                alert("DUPLICATE ENTRY!\n" +
                "PERMIT NO: " + permitNumber + "\n" +
                "MIN NO: " + minNumber + "\n" +
                "SERIAL NO: " + serialNumber + "\n");
                break;
            }

        }

    }
    /*
     * Checking the Update Table for Duplicate Entry
     * @param {int}  rowIndexFinal  [Row Index key of row]
     * @param {string}  permitNumber  [Permit Number entry]
     * @param {string}  minNumber  [Min Number entry]
     * @param {string}  serialNumber  [Serial Number entry]
     * @param {string}  terminalValue  [Terminal Value entry]
     */
     function checkUpdateDuplicateLocalTable(rowIndexFinal, permitNumber, minNumber, serialNumber, terminalValue)
     {
        var rowCount = globalTerminalNumber.length;
        var countPermitNumber = 0;

        for (var rowIndex = 1; rowIndex <= rowCount; rowIndex++) {
            if (rowIndexFinal == rowIndex){ break; }

            var manualPermitNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
            )[0];

            var manualMinNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
            )[0];

            var manualSerialNumberValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
            )[0];

            if (manualPermitNumberValue == globalTerminalNumber[rowIndex - 1] ||
                manualMinNumberValue == globalMinNumber[rowIndex - 1] ||
                manualSerialNumberValue == globalSerialNumber[rowIndex] - 1) {
                countPermitNumber++;
                alert("DUPLICATE ENTRY!\n" +
                "PERMIT NO: " + globalTerminalNumber[rowIndex - 1] + "\n" +
                "MIN NO: " + globalMinNumber[rowIndex - 1] + "\n" +
                "SERIAL NO: " + globalSerialNumber[rowIndex - 1] + "\n");
                break;
            }

        }

        if (countPermitNumber == 0){
            updatePTUDetailTable(rowIndexFinal, permitNumber, minNumber, serialNumber);
        }

    }


    $('.td-cor-tin, .td-cor-business-name, .td-cor-status').die("click").live('click', function()
    {
        var rowIndex = $(this).parents("tr").index();
        var id = myJsTableCor.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnCor['columnCorId'].td_class
        )[0];

        var tin = myJsTableCor.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnCor['columnCorTin'].td_class
        )[0];

        tin = tin.replace(/[_\W]+/g, "");
        var countTin = tin.length;
        tin = tin.slice(0, 9)+"-"+tin.slice(9, countTin);
        $(".manual-span-tin-branch-code").text(tin);

        let currentRow = 0;
        $("#table-cor-id").find("tr").each(function()
        {
            if (currentRow > 0 && currentRow == rowIndex) {
                $(this).find("td").attr("style", "background-color: skyblue;");
            } 

            if (currentRow > 0 && currentRow != rowIndex) {
                 $(this).find("td").removeAttr("style");
            }
            currentRow++;
        }); 

        $("[name='cor-id']").val(id);

        getCorDetails(id);
        $("#table-ptu").hide();
        $("#table-information").hide();
        $("#table-units").hide();
        $(".right-div :input").attr("disabled", false);
        $(".manualBtn :input").attr("disabled", false);
        $("#table-information-manual").hide();
        $("#table-units-manual").hide();
        $("#trMachineSetup").show();

        $("#autoAttr").prop("checked", true);
        $("#manualAddNew").hide();

        <?php if ($isManagementPosition || $isAccountingPosition) { ?>
            var radioButtons = $("input[type=radio][name='corAttributes']:checked").val();
            if (radioButtons == '1') {
                $('#file-upload-ptu').attr("disabled", false);
                $('#upload-file-button').attr("disabled", false);
                
            } else {
                $('#file-upload-ptu').attr("disabled", true);
                $('#upload-file-button').attr("disabled", true);
            }

        <?php } ?>

        $('#manualSaveButton').hide();
        $('#manualEditButton').hide();
        $('#manualUpdateButton').hide();
        $('#manualAddRow').hide();
        // $('#uploadImage img').show();

        fileList = [];
        tempDeletefileID = [];
    });

    $('.td-ptu-upload-date, .td-ptu-mode, .td-ptu-upload-transaction, .td-ptu-upload-units').die("click").live('click', function()
    {
        $('#manualAddRow').hide();
        $('#manualEditButton').hide();
        $('#manualUpdateButton').hide();

        <?php if ($isManagementPosition || $isAccountingPosition) { ?>
            if ($("#autoAttr").prop("checked")) {

        <?php } ?>

        if ($(this).parent().attr("class") == "tableheader") {
            return;
        }

        $(this).parent().parent().find("tr").each(function()
        {
            if ($(this).attr("class") != "tableheader") {
                $(this).find("td").removeAttr("style");
            }
        });
        $(this).parent().find("td").attr("style", "background-color: skyblue");

        var rowIndex = $(this).parents("tr").index();
        var corId = myJsTablePtuUpload.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnPtuUpload['columnPtuCorId'].td_class
        )[0];
        var ptuId = myJsTablePtuUpload.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnPtuUpload['columnPtuUploadId'].td_class
        )[0];

        $("#table-information").show();
        ptuInformation(corId, ptuId);

        $("#table-units").show();
        ptuUnit(ptuId);

        ptuIdValue = ptuId;

        $("#table-information-manual").hide();
        $("#table-units-manual").hide();
        clearManualPTUDetails();

        $('#manualAddRow').hide();
        $('#manualSaveButton').hide();
        $('#manualUpdateButton').hide();

        <?php if ($isManagementPosition || $isAccountingPosition) { ?>

        } else {
            if ($(this).parent().attr("class") == "tableheader") {
                return;
            }

            $(this).parent().parent().find("tr").each(function()
            {
                if ($(this).attr("class") != "tableheader") {
                    $(this).find("td").removeAttr("style");
                }
            });

            $(this).parent().find("td").attr("style", "background-color: skyblue");

            var rowIndex = $(this).parents("tr").index();
            var corId = myJsTablePtuUpload.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnPtuUpload['columnPtuCorId'].td_class
            )[0];

            var ptuId = myJsTablePtuUpload.getvalue_by_rowindex_tdclass(
                rowIndex,
                columnPtuUpload['columnPtuUploadId'].td_class
            )[0];
            
            checkInputType(ptuId);
            $('#ptu-ids').val(ptuId);
            $('#cor-ids').val(corId);
            $("#table-information-manual").show();
            $("#table-information-manual input[type='text']").hide();
            $("#table-information-manual select").hide();
            $("#table-information-manual span").show();
            $("#table-information-manual ").show();

            $("#table-units-manual").hide();

            $("#table-units").show();

            ptuManualInformation(corId, ptuId);
            ptuUnit(ptuId);
            ptuManualUnit(ptuId);

            $("#table-information").hide();
            clearManualPTUDetails();
            
            $('#manualAddRow').hide();
            $('#manualSaveButton').hide();
            $('#manualUpdateButton').hide();
        }

        <?php } ?>

        $("#trMachineSetup").show();

    });

    $('#button-import').die("click").live('click', function()
    {
        var clientBranchIdValue = $("#row-index-ptu").val();
        var existingImportId = $("#existing-import-id").val();

        if ($(".import-cor-text").val() == "") {
            alert("Please input the Tin Number or Business Name.");
            $(".import-cor-text").val("");
            return;
        } else {
            $(".loading-status-import-cor").show();
            document.getElementById('button-addnew').setAttribute("style","width:50px");
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientdetails/importCorDetails",
                data: {
                    id: existingImportId,
                    clientBranchId: clientBranchIdValue
                },
                success: function(data)
                {
                    if (data.status == "Invalid") {
                        alert("Please input a valid Tin # or Business Name");
                    } else {
                        updateLogScreen();
                        displayCorDetails(clientBranchIdValue);
                        alert("Successfully Imported!");
                        $("#table-ptu").hide();
                        $("#table-information").hide();
                        $("#table-units").hide();

                        $("#table-information-manual").hide();
                        $("#table-units-manual").hide();
                    }
                    $("#existing-import-id").val(0);
                    $(".import-cor-text").val("");
                    $(".loading-status-import-cor").hide();
                    document.getElementById('button-addnew').setAttribute("style","width:70px");
                }
            });
        }

    });

    $('#unbindMultipleCOR').die("click").live('click', function()
    {
        let headId = $("#row-index-ptu").val();
        let tinNumber = $("#tin-number").val();
        let rowIdValue = $("#cor-row-id").val();
        let rowMultipleCor = $("#cor-multiple-id").val();
        let rowIndex = $("#cor-row-index").val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url()?>clientdetails/unbindCorDetails",
            data: {
                id: rowIdValue,
                clientBranchId: headId,
                multipleCorId: rowMultipleCor,
                tin: tinNumber
            },
            success: function(data)
            {
                if (data.hasExistingTerminal == 1) {
                    alert("Unable to delete COR, terminals under this branch already bound to PTU. Unbind terminals first to proceed");
                    return;
                }
                myJsTableCor.delete_row(rowIndex);
                clearCorDetails();
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["", data.corStatus],
                    globalRowIndex,
                    colarray_pul['corDocument'].td_class
                );
                $(".upload-ptu").prop('disabled', true);
                myJsTablePtuUnit.clear_table();
                myJsTablePtuUpload.clear_table();
                $("#table-information").hide();
                $("#table-units").hide();
                $("#table-ptu").hide();

                $("#table-information-manual").hide();
                $("#table-units-manual").hide();

                alert("Successfully Unbind!");
                updateLogScreen();
                $("#modal-delete-unbind").modal("hide");
            }
        });
    });

    $('#deleteMultipleCOR').die("click").live('click', function()
    {
        let headId = $("#row-index-ptu").val();
        let tinNumber = $("#tin-number").val();
        let rowIdValue = $("#cor-row-id").val();
        let rowMultipleCor = $("#cor-multiple-id").val();
        let rowIndex = $("#cor-row-index").val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url()?>clientdetails/deleteCorDetails",
            data: {
                id: rowIdValue,
                clientBranchId: headId,
                multipleCorId: rowMultipleCor,
                tin: tinNumber
            },
            success: function(data)
            {
                if (data.hasExistingTerminal == 1) {
                    alert("Unable to delete COR, terminals under this branch already bound to PTU. Unbind terminals first to proceed");
                    return;
                }
                myJsTableCor.delete_row(rowIndex);
                clearCorDetails();
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["", data.corStatus],
                    globalRowIndex,
                    colarray_pul['corDocument'].td_class
                );
                $(".upload-ptu").prop('disabled', true);
                myJsTablePtuUnit.clear_table();
                myJsTablePtuUpload.clear_table();
                $("#table-information").hide();
                $("#table-units").hide();
                $("#table-ptu").hide();

                $("#table-information-manual").hide();
                $("#table-units-manual").hide();

                alert("Successfully Removed!");
                updateLogScreen();
                $("#modal-delete-unbind").modal("hide");
            }
        });
    });

    $('#delete-cor').die("click").live('click', function()
    {
        let headId = $("#row-index-ptu").val();

        var rowIndex = $(this).parents("tr").index();
        var rowIdValue = myJsTableCor.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnCor['columnCorId'].td_class
        )[0];
        var rowMultipleCor = myJsTableCor.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnCor['columnMultipleCor'].td_class
        )[0];
        let tinNumber = $("#tin-number").val();

        $("#cor-row-id").val(rowIdValue);
        $("#cor-multiple-id").val(rowMultipleCor);
        $("#cor-row-index").val(rowIndex);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url()?>clientdetails/checkMultipleCOR",
            data: {
                id: rowIdValue
            },success: function(data)
            {
                if (data.row_count > 1){
                    var answer = confirm("Are you sure you want to unshare/unbind?");
                    if (answer) {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?=base_url()?>clientdetails/deleteCorDetails",
                            data: {
                                id: rowIdValue,
                                clientBranchId: headId,
                                multipleCorId: rowMultipleCor,
                                tin: tinNumber
                            },
                            success: function(data)
                            {
                                if (data.hasExistingTerminal == 1) {
                                    alert("Cannot unbind/unshare if there's a terminal belong to a branch bound to a PTU");
                                    return;
                                }
                                myJsTableCor.delete_row(rowIndex);
                                clearCorDetails();
                                myjstbl_pul.setvalue_to_rowindex_tdclass(
                                    ["", data.corStatus],
                                    globalRowIndex,
                                    colarray_pul['corDocument'].td_class
                                );
                                $(".upload-ptu").prop('disabled', true);
                                myJsTablePtuUnit.clear_table();
                                myJsTablePtuUpload.clear_table();
                                $("#table-information").hide();
                                $("#table-units").hide();
                                $("#table-ptu").hide();

                                $("#table-information-manual").hide();
                                $("#table-units-manual").hide();

                                alert("Successfully Removed!");
                                updateLogScreen();
                            }
                        });
                    }
                } else {
                    $('#modal-delete-unbind').modal("show");
                }
            }
        });
    });

    $('#delete-ptu-upload').die("click").live('click', function()
    {
        let headId = $("#row-index-ptu").val();
        let existingTerminalNumber = $(".span-transaction-number").text();
        var rowIndex = $(this).parents("tr").index();
        var rowIdValue = myJsTablePtuUpload.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnPtuUpload['columnPtuUploadId'].td_class
        )[0];
        var transactionNumber = myJsTablePtuUpload.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnPtuUpload['columnPtuUploadTransaction'].td_class
        )[0];

        var answer = confirm("Are you sure you want to delete?");
        if (answer) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientdetails/deletePtuUpload",
                data: {
                    id: rowIdValue,
                    transactionNumber: transactionNumber,
                    clientBranchId: headId
                },
                success: function(data)
                {
                    if (data != -1) {
                        myJsTablePtuUpload.delete_row(rowIndex);
                        alert("Successfully Removed");

                        if (data == 0) {
                            myJsTablePtuUnit.clear_table();
                            myJsTablePtuUpload.clear_table();
                            $("#table-information").hide();
                            $("#table-units").hide();
                            $("#table-ptu").hide();

                            myJsTableManualPtuUnit.clear_table();
                            $("#table-information-manual").hide();
                            $("#table-units-manual").hide();

                        } else if (transactionNumber == existingTerminalNumber) {
                            $("#table-information").hide();
                            $("#table-units").hide();

                            $("#table-information-manual").hide();
                            $("#table-units-manual").hide();
                        }

                        $("#manualAddRow").hide();
                        $("#manualSaveButton").hide();
                        $("#manualEditButton").hide();
                        $("#manualUpdateButton").hide();

                        let id = $("[name='cor-id']").val();
                        getCorDetails(id);
                    } else {
                        alert("Unable to delete. There is an existing unit bound to terminal.");
                        return;
                    }
                }
            });
        }
    });

    /*
     * Show PTU Uploaded File Table
     */
    function ptuUploadTable(corId)
    {
        myJsTablePtuUpload.clear_table();

        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/displayPtuUpload",
            type: "POST",
            data: {
                corId: corId
            },
            success: function(data)
            {
                myJsTablePtuUpload.insert_multiplerow_with_value(1, data.data);
            }
        });
    }

    /*
     * Show PTU Information Table
     * @param {string}  corId  [unique key in every treansaction]
     */
    function ptuInformation(corId, ptuId)
    {
        edit_flag = 0;
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/displayPtuInformation",
            type: "POST",
            dataType: "json",
            data: {
                corId: corId,
                ptuId: ptuId
            },
            success: function(data)
            {
                $(".span-transaction-number").text(data.transactionNumber);
                $(".span-permit-type").text(data.permitType);
                $(".span-machine-setup").text(data.machineSetup);
                $(".span-rdo-code").text(data.rdoCode);
                $(".span-tin-branch-code").text(data.tinBranchCode);

                $(".span-registered-name").parent().parent().hide();
                $(".span-first-name").parent().parent().hide();
                $(".span-middle-name").parent().parent().hide();
                $(".span-last-name").parent().parent().hide();
                $(".span-extension-name").parent().parent().hide();
                $(".span-registered-name").text(data.registeredName);
                $(".span-first-name").text(data.firstNameValue);
                $(".span-middle-name").text(data.middleNameValue);
                $(".span-last-name").text(data.lastNameValue);
                $(".span-extension-name").text(data.extensionNameValue);

                let nameList = {
                    "registered_name": ".span-registered-name",
                    "first_name": ".span-first-name",
                    "middle_name": ".span-middle-name",
                    "last_name": ".span-last-name",
                    "extension_name": ".span-extension-name"
                };

                for ([otherName, spanName] of Object.entries(nameList)) {
                    if (otherName !== undefined && $.inArray(otherName, data.showOtherName) != -1) {
                        $(spanName).parent().parent().show();
                    }
                }

                $(".span-business-name").text(data.businessName);
                $(".span-business-address").text(data.businessAddress);

                if (data.permitType != "Special Purpose Machine Permit") {
                    $(".span-spm-accreditation").parent().parent().hide();
                } else {
                    $(".span-spm-accreditation").parent().parent().show();
                    var accredNumber = "";

                    if(data.accreditation_number == "-"){
                        accredNumber = "None";
                    } else {
                        accredNumber = "ACC: " + data.accreditation_number;
                    }

                    getAccredName(accredNumber);
                }
            }
        });
    }

    function ptuManualInformation(corId, ptuId) {
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/displayManualPtuInformation",
            type: "POST",
            dataType: "json",
            data: {
                corId: corId,
                ptuId: ptuId
            },
            success: function(data)
            {
                $("#spanManualTransaction").text(data.transactionNumber);
                $("#spanManualPermitType").text(data.permitType);
                $("#spanManualMachineSetup").text(data.machineSetup);
                $("#spanManualRDOCode").text(data.rdoCode);
                
                $(".span-manual-register").parent().parent().hide();
                $(".span-manual-first").parent().parent().hide();
                $(".span-manual-middle").parent().parent().hide();
                $(".span-manual-last").parent().parent().hide();
                $(".span-manual-extension").parent().parent().hide();

                $("#spanManualRegisteredName").text(data.registeredName);
                $("#spanManualFirstName").text(data.firstNameValue);
                $("#spanManualMiddleName").text(data.middleNameValue);
                $("#spanManualLastName").text(data.lastNameValue);
                $("#spanManualExtentionName").text(data.extensionNameValue);

                let nameList = {
                    "registered_name": ".span-manual-register",
                    "first_name": ".span-manual-first",
                    "middle_name": ".span-manual-middle",
                    "last_name": ".span-manual-last",
                    "extension_name": ".span-manual-extension"
                };

                for ([otherName, spanName] of Object.entries(nameList)) {
                    if (otherName !== undefined && $.inArray(otherName, data.showOtherName) != -1) {
                        $(spanName).parent().parent().show();
                    }
                }

                $("#spanManualBusinessName").text(data.businessName);
                $("#spanManualBusinessAddress").text(data.businessAddress);
                var accredNumber = "";

                if(data.accreditation_number == "-"){
                    accredNumber = "None";
                } else {
                    accredNumber = "ACC: " + data.accreditation_number;
                }

                $("#spanAccreditationNumber").text(accredNumber);
                $("#spanManualEffectiveDate").text(data.date_issued);
            }

        });

    }


    var ptuSelect = [];
    function doPtuOption(isAllowChosen = true)
    {
        index = 0;
        $(".select-ptu-terminal").each(function()
        {
            if ($(this).parent().parent().find(".save-ptu-terminal").length) {
                return;
            }

            let spanPtuTerminal = "";
            let optionList = $(this).val();
            $(this).find("option").each(function()
            {
                value = $(this).attr("value");
                for ([selectIndex, existTerminal] of ptuSelect.entries()) {
                    let optionIndex = $.inArray(value, existTerminal);
                    if (optionIndex != -1 && value != 0 && selectIndex != index) {
                        $(this).hide();
                    }
                }
                if ($.inArray(value, optionList) != -1) {
                    spanPtuTerminal += (spanPtuTerminal) ? ", " : "";
                    spanPtuTerminal += $(this).html();
                }
            });
            if (! isAllowChosen) {
                $(this).hide();
                $(this).parent().find(".chzn-container").remove();
                spanPtuTerminal = (! spanPtuTerminal) ? "None" : spanPtuTerminal;
                $(this).parent().prepend("<span class='span-ptu-terminal' style='text-align: center'>"+spanPtuTerminal+"</span>"); 
            }
            index += 1;
        });

        if (isAllowChosen) {
            $(".select-ptu-terminal").chosen();
        }

        if (selectExistingTerminal.length != 0) {
            for ([key, rowIndex] of selectExistingTerminal.entries()) {
                $("#table-unit-id").find("tr:eq("+(rowIndex + 1)+")").find(".td-ptu-edit").find("img").hide();
                $("#table-unit-id").find("tr:eq("+(rowIndex + 1)+")").find(".td-ptu-terminal").find(".span-ptu-terminal").html(selectOtherBranchTerminal[key]);
                $("#table-unit-id").find("tr:eq("+(rowIndex + 1)+")").find(".td-ptu-terminal").find("select").hide();
            }
        }
    }

    function getPTUUnitTerminalCount(ptuId, getInputType)
    {   

        let headId = $("#row-index-ptu").val();

        if (getInputType == null || getInputType == 1){
           $('#manualEditButton').hide();
        } else {
            $.ajax(
            {
                url: "<?=base_url()?>clientdetails/getPtuUnitTerminalCount",
                type: "POST",
                dataType: "json",
                data: {
                    ptuId: ptuId,
                    clientBranchId: headId
                },
                success: function(data)
                {
                    var getTerminalCount = data.checkTerminal.length;
                    for (var i = 0; i < getTerminalCount; i++) {
                        if (data.checkTerminal[i] > 0 ){
                            $('#manualEditButton').hide();
                            break;
                        } else {
                            $('#manualEditButton').show();
                        }
                    }
                }
            });
        }
    }

    /*
     * Show PTU Unit Table
     * @param {string}  ptuId  [unique key in every treansaction]
     */
    function ptuUnit(ptuId)
    {
        myJsTablePtuUnit.clear_table();
        let headId = $("#row-index-ptu").val();
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/displayPtuUnit",
            type: "POST",
            dataType: "json",
            data: {
                ptuId: ptuId,
                clientBranchId: headId
            },
            success: function(data)
            {
                myJsTablePtuUnit.insert_multiplerow_with_value(1, data.data);
                let tableData = data.data;

                $.ajax(
                {
                    url: "<?=base_url()?>clientdetails/getTerminalDropdown",
                    type: "POST",
                    data: {
                        ptuId: ptuId,
                        clientBranchId: headId
                    },
                    async: false,
                    success: function(options)
                    { 
                        $(".select-ptu-terminal").html("<option value='0'>None</option>"+options);
                        let index = 0;
                        let existTerminal = [];
                        $(".select-ptu-terminal").each(function()
                        {
                            let terminalNumberValue = tableData[index][5][0].split(",");
                            $(this).val(terminalNumberValue);
                            existTerminal[index] = terminalNumberValue;
                            ptuSelect[index] = ($(this).val() !== null) ? $(this).val() : [];

                            index += 1; 
                        });

                        selectExistingTerminal = [];
                        selectOtherBranchTerminal = [];
                        if (data.existingTerminal.length != 0) {
                            selectExistingTerminal = data.existingTerminal;
                            selectOtherBranchTerminal = data.otherBranchTerminal;
                        }

                        doPtuOption(false);
                    }
                });

            }
        });

    }

    function ptuManualUnit(ptuId)
    {
        myJsTableManualPtuUnit.clear_table();
        let headId = $("#row-index-ptu").val();
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/displayPtuUnit",
            type: "POST",
            dataType: "json",
            data: {
                ptuId: ptuId,
                clientBranchId: headId
            },
            success: function(data)
            {
                myJsTableManualPtuUnit.insert_multiplerow_with_value(1, data.data);
                let tableData = data.data;
            }
        });
    }

    /*
     * Display PTU Dropdown Values
     * @param {string}  dropdownValue        [current value of the selected dropdown]
     */
    function getPTUTerminalDropdown(dropdownValue)
    {
        let selectedValue = [];
        let index = 0;
        $(".select-ptu-terminal").each(function()
        {
            selectedValue[index] = this.value;
            index += 1;
        });

        index = 0;
        $(".select-ptu-terminal").each(function()
        {
            $(this).find("option").each(function()
            {
                value = $(this).attr("value");
                optionIndex = $.inArray(value, selectedValue);
                if (optionIndex != -1 && value != 0 && optionIndex != index) {
                    $(this).hide();
                } else {
                    $(this).css("display","");
                }
            });
            index += 1;
        });
    }

    function clearManualPTUDetails()
    {
        $("#manualTransaction").val("");
        $("#manualPermitType").val(0);
        $("#manualMachineSetup").val("");
        $("#manualRDOCode").val("");

        $("#manualRegisteredName").val("");
        $("#manualFirstName").val("");
        $("#manualMiddleName").val("");
        $("#manualLastName").val("");
        $("#manualExtentionName").val("");

        $("#manualBusinessName").val("");
        $("#manualBusinessAddress").val("");

        $("#manualExtentionName").attr("disabled", false);
        $("#manualFirstName").attr("disabled", false);
        $("#manualMiddleName").attr("disabled", false);
        $("#manualLastName").attr("disabled", false);
        $("#manualExtentionName").attr("disabled", false);
        
        $("#accreditationNumber").val(0);
        $(".manual-registration-date").val("0000-00-00");
        $(".manual-registration-date" ).datepicker({dateFormat: 'yy-mm-dd'});
    }

    function checkInputType(ptuId){
        $.ajax({
            url: "<?=base_url("clientdetails/checkInputType")?>",
            type: "POST",
            data: {
                ptuID: ptuId
            },
            dataType: "json",
            success: function(data)
            {
                if (data == 2){
                    $('#manualEditButton').show();
                } else if (data == null || data == 1){
                    $('#manualEditButton').hide();
                }

                $("#input-type").val(data);
                getPTUUnitTerminalCount(ptuId, data);
            }
        });
    }

    function clearCorDetails()
    {
        $("#existing-cor").val(0);
        $(".import-cor-text").val("");
        $(".business-name").val("");
        $(".address").val("");
        $(".owner").val("");
        $(".tin-1-edit").val("");
        $(".tin-2-edit").val("");
        $(".tin-3-edit").val("");
        $(".tin-4-edit").val("");
        $(".vat-status").val(0);
        $(".cor-status").val(0);
        $(".registration-date").val("0000-00-00");
        $(".registration-date" ).datepicker({dateFormat: 'yy-mm-dd'});

        $(".business-name").prop("disabled", false);
        $(".address").prop("disabled", false);
        $(".owner").prop("disabled", false);
        $(".tin-1-edit").prop("disabled", false);
        $(".tin-2-edit").prop("disabled", false);
        $(".tin-3-edit").prop("disabled", false);
        $(".tin-4-edit").prop("disabled", false);
        $(".vat-status").prop("disabled", false);
        $(".cor-status").prop("disabled", false);
        $(".registration-date").prop("disabled", false);

        $(".image-thumbnail-1").attr("src", "");
        $(".image-thumbnail-2").show();
        $(".image-thumbnail-2").hide();
        $(".image-thumbnail-3").hide();
        $(".image-thumbnail-4").hide();
        $(".image-thumbnail-5").hide();
        $(".image-thumbnail-6").hide();

        $("#file-name-1").text("No file attached");
        $("#file-name-2").text("No file attached");
        $("#file-name-3").text("No file attached");
        $("#file-name-4").text("No file attached");
        $("#file-name-5").text("No file attached");
        $("#file-name-6").text("No file attached");

        $("#file-name-1").show();
        $("#file-name-2").hide();
        $("#file-name-3").hide();
        $("#file-name-4").hide();
        $("#file-name-5").hide();
        $("#file-name-6").hide();

        $(".file-name-1").show();
        $(".file-name-2").hide();
        $(".file-name-3").hide();
        $(".file-name-4").hide();
        $(".file-name-5").hide();
        $(".file-name-6").hide();

        $("#image-delete-1").hide();
        $("#image-delete-2").hide();
        $("#image-delete-3").hide();
        $("#image-delete-4").hide();
        $("#image-delete-5").hide();
        $("#image-delete-6").hide();

        $("#imgValue-1").val("");
        $("#imgValue-2").val("");
        $("#imgValue-3").val("");
        $("#imgValue-4").val("");
        $("#imgValue-5").val("");
        $("#imgValue-6").val("");
        $('#uploadImage img').hide();

        $("#save-uploaded-file[type='button']").prop("disabled", false);
        $("#select-file-button[type='button']").prop("disabled", false);

        $(".tin-1-edit").prop("disabled", false);
        $(".tin-2-edit").prop("disabled", false);
        $(".tin-3-edit").prop("disabled", false);
        $(".tin-4-edit").prop("disabled", false);
        let currentRow = 0;
        $("#table-cor-id").find("tr").each(function()
        {
            if (currentRow > 0) {
                 $(this).find("td").removeAttr("style");
            }
            currentRow++;
        });
    }
    /*
     * Show loading status
     * @param {bolean}  isShow             [is show loading]
     * @param {string}  caption            [loading caption]
     * @param {bolean}  isDisabledButtons  [is disabled buttons]
     * @param {bolean}  showLoadingImage   [is show loading image]
     */
    function showLoading(isShow = false, caption = "Loading..", isDisabledButtons = false)
    {
        if (! isShow) {
            $(".loading-status").hide();
        } else {
            $(".loading-status").show();

            let loading = "<img src='assets/images/loading.gif' width='15px' height='15px'>&nbsp;";
            $(".loading-status").html(loading+caption);
        }

        if (isDisabledButtons) {
            $("#upload-file-button").find("button").attr("disabled", "disabled");
            isUpdate = false;
            $('input[type=radio][name=corAttributes]').attr("disabled", false);
        } else {
            $("#upload-file-button").find("button").removeAttr("disabled");
            $('input[type=radio][name=corAttributes]').attr("disabled", true);
            isUpdate = true;
        }
    }

    function htmlReader(fileUpload, headId, existingTinNumber, i, existingCor)
    {
        if (i == fileUpload.files.length) {
            showLoading(false, "", false);
            alert(messagePtuUpload);
            $("input[name='file-upload-ptu']").val(null);
            return;
        }

        var isSpm = false;
        let ptuRegistrationValues = [];
        let ptuUnitValues = [];
        let textPtuSize = 0;
        textPtuSize = parseFloat(fileUpload.files[i].size) / 1024 / 1024;
        textPtuSize = fileUpload.files[i].size;

        if (textPtuSize > fileSizeLimit) {
            messagePtuUpload += "\"" + fileUpload.files[i].name + "\""  + " = File size exceed 7MB! \r\n";
            i += 1;
            htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
        }

        var fileExtension = fileUpload.files[i].name.substr(-4);
        if (fileExtension !== "html") {
            messagePtuUpload += "\"" + fileUpload.files[i].name + "\"" + " = Incorrect File Type \r\n";
            i += 1;
            htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
        }

        let fileNameValue = fileUpload.files[i].name;
        var reader = new FileReader();
        reader.onload = function(e) {
            var htmlText = reader.result;
            fileContent = $(reader.result);

            if (
                $(fileContent).find(".view_table").length == 0
                || $(fileContent).find(".DataTables_sort_wrapper").length == 0
            ) {
                messagePtuUpload += "\"" + fileUpload.files[i].name + "\"" + " = Unable to upload, invalid HTML file \r\n";
                i += 1;
                htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
                return;
            }

            var input = fileContent.find(".view_table").find("table:eq(1)").find(".input_label");
            input.each(function()
            {
                let parentRow = $(this).parent().parent();
                let key = $(this).html();
                let value = parentRow.find("td:eq(1)").find("label").html();
                if (value != undefined) {
                    ptuRegistrationValues[key.replace(" :", "")] = value;
                }
            });

            let isCompleteData = true;
            let transactionNumberValue = ptuRegistrationValues["Transaction Number"];
            let permitTypeValue = ptuRegistrationValues["Permit Type"];
            let machineSetupValue = ptuRegistrationValues["Machine Setup"];
            let rdoCodeValue = ptuRegistrationValues["RDO Code"];
            let tinBranchCodeValue = ptuRegistrationValues["TIN-Branch Code"];
            let registeredNameValue = ptuRegistrationValues["Registered Name"];
            let firstNameValue = ptuRegistrationValues["First Name"];
            let middleNameValue = ptuRegistrationValues["Middle Name"];
            let lastNameValue = ptuRegistrationValues["Last Name"];
            let extensionNameValue = ptuRegistrationValues["Extension Name"];
            let businessNameValue = ptuRegistrationValues["Business Name"];
            let businessAddressValue = ptuRegistrationValues["Business Address"];

            let nameList = {
                "registered_name": registeredNameValue,
                "first_name": firstNameValue,
                "middle_name": middleNameValue,
                "last_name": lastNameValue,
                "extension_name": extensionNameValue
            };

            let showOtherName = "";
            for ([otherName, nameValue] of Object.entries(nameList)) {
                if (nameValue !== undefined) {
                    showOtherName += (showOtherName) ? "~u~" : "";
                    showOtherName += otherName;
                }
            }

            if(permitTypeValue == "Special Purpose Machine Permit"){
                isSpm = true;
            }

            registeredNameValue = (registeredNameValue === undefined) ? "" : registeredNameValue;
            firstNameValue = (firstNameValue === undefined) ? "" : firstNameValue;
            middleNameValue = (middleNameValue === undefined) ? "" : middleNameValue;
            lastNameValue = (lastNameValue === undefined) ? "" : lastNameValue;
            extensionNameValue = (extensionNameValue === undefined) ? "" : extensionNameValue;
            machineSetupValue = (machineSetupValue === undefined) ? "" : machineSetupValue;

            if (
                ! transactionNumberValue
                || ! permitTypeValue
                || ! rdoCodeValue
                || ! tinBranchCodeValue
                || ! businessNameValue
                || ! businessAddressValue)
            {
                isCompleteData = false;
            }

            var headerKey = [];
            var tableHeaderKey = fileContent.find("#listOfMachines_wrapper").find(".DataTables_sort_wrapper");
            tableHeaderKey.each(function()
            {
                $(this).find(".DataTables_sort_icon").remove();
                headerKey.push($(this).html());
            });

            var row = 0;
            var tableHeaderValue = fileContent.find("#listOfMachines").find("tbody").find("tr");

            if(!isSpm){
                var requiredField = [
                    "Permit Number",
                    "MIN",
                    "Serial No",
                    "Accreditation Number",
                    "Effective Date of Permit",
                    "Software Name",
                    "Software Version"
                ];
            }
            else{
                var requiredField = [
                    "Permit Number",
                    "Serial Number",
                    "Effective Date of Permit",
                    "Brand",
                    "Model"
                ];
            }
            
            tableHeaderValue.each(function()
            {
                ptuUnitValues[row] = [];
                var index = 0;
                $(this).find("td").each(function()
                {
                    let tableValue = $(this).html().trim();

                    if (! tableValue && $.inArray(headerKey[index], requiredField) != -1) {
                        alert(headerKey[index])
                        isCompleteData = false;
                    }

                    ptuUnitValues[row][headerKey[index]] = tableValue;

                    if(isSpm){
                        ptuUnitValues[row]["Brand"] = "Take Order Machine";
                        ptuUnitValues[row]["Model"] = "-";

                        if(ptuUnitValues[row]["MIN"] == undefined)
                            ptuUnitValues[row]["MIN"] = "-";

                        if(ptuUnitValues[row]["Accreditation Number"] == undefined)
                            ptuUnitValues[row]["Accreditation Number"] = "-";
                    }
                    index += 1;
                });
                row += 1;
            });

            if (! isCompleteData) {
                messagePtuUpload +=
                    "\"" + fileUpload.files[i].name + "\"" + " = Unable to upload, file has incomplete values \r\n";
                i += 1;
                htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
                return;
            }

            let ptuNumberOfUnits = row;
            let fileAlreadyExist = 0;
            $.ajax({
                url: "<?=base_url("clientdetails/getExistingPtuUpload")?>",
                type: "POST",
                data: {
                    existingCor: existingCor,
                    transactionNumber: transactionNumberValue
                },
                dataType: "json",
                async: false,
                success: function(data)
                {
                    fileAlreadyExist = data;
                }
            });

            if (fileAlreadyExist > 0) {
                messagePtuUpload += "\"" + fileNameValue + "\"" + " = Cannot upload. File already uploaded. \r\n";
                i+= 1;
                htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
                return;
            }

            let tinNumber = tinBranchCodeValue.replace(/-/g, "");
            if (! (tinNumber == existingTinNumber)) {
                messagePtuUpload += "\"" + fileNameValue + "\"" + " = Failed to upload, TIN # value is not match to uploaded C.O.R - Tin # value. \r\n";
                i+= 1;
                htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
                return;
            }

            if (textPtuFileSize > 7000000) {
                temporaryHeadId = headId;
                temporaryFileName =  fileNameValue;
                temporaryExistingCor = existingCor;
                temporaryNumberOfUnits = ptuNumberOfUnits;
                temporaryPtuFile = htmlText;
                temporaryTransactionNumberValue = transactionNumberValue;
                temporaryPermitTypeValue = permitTypeValue;
                temporaryMachineSetupValue = machineSetupValue;
                temporaryRdoCodeValue = rdoCodeValue;
                temporaryTinBranchCodeValue = tinBranchCodeValue;
                temporaryRegisteredNameValue = registeredNameValue;
                temporaryFirstNameValue = firstNameValue;
                temporaryMiddleNameValue = middleNameValue;
                temporaryLastNameValue = lastNameValue;
                temporaryExtensionNameValue = extensionNameValue;
                temporaryShowOtherName = showOtherName;
                temporaryBusinessNameValue = businessNameValue,
                temporaryBusinessAddressValue = businessAddressValue,
                temporaryMessagePtuUpload = messagePtuUpload,
                temporaryFileUpload = fileUpload,
                temporaryExistingTinNumber = existingTinNumber,
                temporaryIndex = i,
                startStringIndex = 0;
                endStringIndex = 0;
                countPtuSize = 0;
                setTimeout(function()
                {
                    savePtuFile(1);
                }, 1);
                return;
            }

            let hasAcc = true;

            for (var x = 0; x < ptuNumberOfUnits; x++) {
                if(ptuUnitValues[x]["Accreditation Number"] == "-"){
                    hasAcc = false;
                }
            }

            if(!hasAcc){
                $("#ptu-id").val(headId);
                $("#cor-id").val(existingCor);

                $.ajax({
                    url: "<?=base_url("clientdetails/checkAccred")?>",
                    type: "POST",
                    data: {
                        corId: existingCor,
                        ptuId: headId
                    },
                    async: false,
                    success: function(data)
                    {
                        /* PTU Head */
                        $("#filename").val(fileNameValue);
                        $("#number-of-units").val(ptuNumberOfUnits);
                        $("#upload-file").val(htmlText);
                        $("#transaction-number").val(transactionNumberValue);
                        $("#permit-type").val(permitTypeValue);
                        $("#machine-setup").val(machineSetupValue);
                        $("#rdo-code").val(rdoCodeValue);
                        $("#tin-branch-code").val(tinBranchCodeValue);
                        $("#registered-name").val(registeredNameValue);
                        $("#first-name").val(firstNameValue);
                        $("#middle-name").val(middleNameValue);
                        $("#last-name").val(lastNameValue);
                        $("#extension-name").val(extensionNameValue);
                        $("#other-name").val(showOtherName);
                        $("#business-name").val(businessNameValue);
                        $("#business-address").val(businessAddressValue);
                        $("#index").val(i);
                        $("#existing-tin-number").val(i);

                        /* PTU Unit Detail*/
                        let permitNumberValue = [];
                        let minNumberValue = [];
                        let accreditationNumberValue = [];
                        let effectiveDateValue = [];
                        let serialNumberValue = [];
                        let softwareNameValue = [];
                        let softwareVersionValue = [];
                        for (var ptuIndex = 0; ptuIndex < ptuNumberOfUnits; ptuIndex++) {
                            permitNumberValue.push( ptuUnitValues[ptuIndex]["Permit Number"] );
                            minNumberValue.push( ptuUnitValues[ptuIndex]["MIN"] );
                            accreditationNumberValue.push( ptuUnitValues[ptuIndex]["Accreditation Number"] );
                            effectiveDateValue.push( ptuUnitValues[ptuIndex]["Effective Date of Permit"] );
                            serialNumberValue.push( ptuUnitValues[ptuIndex]["Serial Number"] );
                            softwareNameValue.push( ptuUnitValues[ptuIndex]["Brand"] );
                            softwareVersionValue.push( ptuUnitValues[ptuIndex]["Model"] );
                        }

                        $('#cor-id').val(existingCor);
                        $('#accredlist').val(data.replace("ACC: ",""));
                        $('#permit-number').val(permitNumberValue);
                        $('#min').val(minNumberValue);
                        $('#acc-number').val(accreditationNumberValue);
                        $('#date-of-permit').val(effectiveDateValue);
                        $('#serial-number').val(serialNumberValue);
                        $('#brand').val(softwareNameValue);
                        $('#model').val(softwareVersionValue);
                        $('#head-id').val(headId);
                        $('#transaction-number').val(transactionNumberValue);

                        refreshAccList();
                        $('#choose-accred').modal("show");
                    }
                });
            }
            else{
                $.ajax({
                    url: "<?=base_url("clientdetails/savePtuUpload")?>",
                    type: "POST",
                    data: {
                        id: 0,
                        clientBranch: headId,
                        existingCor: existingCor,
                        fileName: fileNameValue,
                        numberOfUnits: ptuNumberOfUnits,
                        ptuUploadFile: htmlText,
                        transactionNumber: transactionNumberValue,
                        permitType: permitTypeValue,
                        machineSetup: machineSetupValue,
                        rdoCode: rdoCodeValue,
                        tinBranchCode: tinBranchCodeValue,
                        registeredName: registeredNameValue,
                        firstNameValue: firstNameValue,
                        middleNameValue: middleNameValue,
                        lastNameValue: lastNameValue,
                        extensionNameValue: extensionNameValue,
                        showOtherName: showOtherName,
                        businessName: businessNameValue,
                        businessAddress: businessAddressValue,
                        accreditationNumbers: 1
                    },
                    dataType: "json",
                    success: function(response)
                    {
                        for (var ptuIndex = 0; ptuIndex < ptuNumberOfUnits; ptuIndex++) {

                            let permitNumberValue = ptuUnitValues[ptuIndex]["Permit Number"];
                            let minNumberValue = ptuUnitValues[ptuIndex]["MIN"];
                            let accreditationNumberValue = ptuUnitValues[ptuIndex]["Accreditation Number"];
                            let effectiveDateValue = ptuUnitValues[ptuIndex]["Effective Date of Permit"];
                            let serialNumberValue = ptuUnitValues[ptuIndex]["Serial No"];
                            let softwareNameValue = ptuUnitValues[ptuIndex]["Software Name"];
                            let softwareVersionValue = ptuUnitValues[ptuIndex]["Software Version"];
                            
                            $.ajax({
                                url: "<?=base_url("clientdetails/savePtuUnits")?>",
                                type: "POST",
                                data: {
                                    clientBranch: headId,
                                    transactionNumber: transactionNumberValue,
                                    permitNumber: permitNumberValue,
                                    minNumber: minNumberValue,
                                    serialNumber: serialNumberValue,
                                    accreditationNumber: accreditationNumberValue,
                                    effectiveDate: effectiveDateValue,
                                    softwareName: softwareNameValue,
                                    softwareVersion: softwareVersionValue
                                },
                                dataType: "json",
                                async: false,
                                success: function(data) {}
                            });
                        }

                        if (! response.isError) {
                            $("#table-ptu").show();
                            ptuUploadTable(existingCor);
                        }
                        messagePtuUpload += "\"" + fileNameValue + "\" = " + response.message + "\r\n";
                        i += 1;
                        $(".tin-1-edit").prop("disabled", true);
                        $(".tin-2-edit").prop("disabled", true);
                        $(".tin-3-edit").prop("disabled", true);
                        $(".tin-4-edit").prop("disabled", true);
                        htmlReader(fileUpload, headId, existingTinNumber, i, existingCor);
                    }
                });
            }
        }
        reader.readAsText(fileUpload.files[i]);
    }

    $("#upload-file-button").die("click").live("click", function(sourceObject)
    {
        $('input[type=radio][name=corAttributes]').attr("disabled", true);
        let fileUpload = $("#file-upload-ptu")[0];
        let headId = $("#row-index-ptu").val();
        let existingTinNumber = $("#tin-number").val();
        messagePtuUpload = "";

        if (fileUpload.files.length == 0) {
            alert("Please select a file to upload");
            return;
        }

        let ptuRegistrationValues = [];
        let ptuUnitValues = [];
        showLoading(true, " Loading...", true);
        let existingCor = $("#existing-cor").val();
        htmlReader(fileUpload, headId, existingTinNumber, 0, existingCor);
        $('input[type=radio][name=corAttributes]').attr("disabled", false);
    });


    var textPtuFileSize = 0;
    var countPtuFileSize = 0;
    var startStringIndex = 0;
    var endStringIndex = 0;
    var temporaryPtuFile = "";
    /**
     * Save ptu file
     * @param  {integer}  numberOfLoop  [number of loop]
     */
    function savePtuFile(numberOfLoop)
    {
        let ptuHtml = "";
        let isContinue = true;
        let totalCountSize = 0;
        let currentFileSize = 0;

        endStringIndex += 5000000;
        ptuHtml = temporaryPtuFile.substring(startStringIndex, endStringIndex);

        currentFileSize = parseInt(new Blob([ptuHtml]).size);
        totalCountSize = countPtuFileSize + currentFileSize;
        if (totalCountSize == textPtuFileSize || endStringIndex >= temporaryPtuFile.length) {
            isContinue = false;
        }

        $.ajax({
            url: "<?=base_url("clientdetails/saveBigFile")?>",
            type: "POST",
            data: {
                clientBranch: temporaryHeadId,
                fileName: fileName,
                existingCor: temporaryExistingCor,
                fileContent: temporaryPtuFile,
                numberOfUnits: temporaryNumberOfUnits,
                transactionNumber: temporaryTransactionNumberValue,
                permitType: temporaryPermitTypeValue,
                machineSetup: temporaryMachineSetupValue,
                rdoCode: temporaryRdoCodeValue,
                tinBranchCode: temporaryTinBranchCodeValue,
                registeredName: temporaryRegisteredNameValue,
                firstNameValue: temporaryFirstNameValue,
                middleNameValue: temporaryMiddleNameValue,
                lastNameValue: temporaryLastNameValue,
                extensionNameValue: temporaryExtensionNameValue,
                showOtherName: temporaryShowOtherName,
                businessName: temporaryBusinessNameValue,
                businessAddress: temporaryBusinessAddressValue
            },
            dataType: "json",
            success: function(response)
            {
                if (isContinue) {
                    startStringIndex = endStringIndex;
                    countPtuFileSize = totalCountSize;
                    numberOfLoop += 1;
                    savePtuFile(numberOfLoop);
                } else {
                    htmlReader(
                        temporaryFileUpload,
                        temporaryHeadId,
                        temporaryExistingTinNumber,
                        temporaryIndex,
                        temporaryExistingCor
                    );

                    if (! response.isError) {
                        ptuUploadTable(temporaryExistingCor);
                        $("#table-ptu").show();
                    }
                    temporaryMessagePtuUpload += "\"" + fileName + "\" = " + response.message + "\r\n";
                    temporaryIndex += 1;
                    htmlReader(
                        temporaryFileUpload,
                        temporaryHeadId,
                        temporaryExistingTinNumber,
                        temporaryIndex,
                        temporaryExistingCor
                    );
                }
            },
            error: function(xhr, status, error)
            {
                alert("Failed to saved.");
            }
        });
    }

    $(".image-bound").live("mouseenter, mousemove", function(event)
    {

        let nodeWidth = $("#popup-display-cor").width();
        let nodeHeight = $("#popup-display-cor").height();

        status = $(this).find("img").attr("status");

        if( status != 'undefined' ) {
        let toolTipText = "<b>"+ status +"</b";
        $("#popup-display-cor").offset({left: event.pageX + 10, top: event.pageY});
        $("#popup-display-cor").css("display", "block");
        $("#popup-display-cor").html(toolTipText);
        }

    }).live("mouseleave", function(event)
    {
        $("#popup-display-cor").css("display", "none");
    });

    $(".image-bind-ptu").live("mouseenter, mousemove", function(event)
    {
        let nodeWidth = $("#popup-display").width();
        let nodeHeight = $("#popup-display").height();

        status = $(this).find("img").attr("status");
        let toolTipText = "<b>"+ status +"</b";

        $("#popup-display").offset({left: event.pageX + 10, top: event.pageY});
        $("#popup-display").css("display", "block");
        $("#popup-display").html(toolTipText);

    }).live("mouseleave", function(event)
    {
        $("#popup-display").css("display", "none");
    });

    $(".manual-image-bind-ptu").live("mouseenter, mousemove", function(event)
    {
        let nodeWidth = $("#manual-popup-display").width();
        let nodeHeight = $("#manual-popup-display").height();
        status = $(this).find("img").attr("status");
        let toolTipText = "<b>"+ status +"</b";
        $("#manual-popup-display").offset({left: event.pageX + 10, top: event.pageY});
        $("#manual-popup-display").css("display", "block");
        $("#manual-popup-display").html(toolTipText);
    }).live("mouseleave", function(event)
    {
        $("#manual-popup-display").css("display", "none");
    });

    $("#manualPermitType").die("change").live("change", function()
    {
        var getPermitType = $(this).val();
        
        if (getPermitType == "Special Purpose Machine Permit"){
            $("#trMachineSetup").hide();
        } else {
            $("#trMachineSetup").show();
        }

    });

    $(".select-ptu-terminal").die("change").live("change", function()
    {
        let chosen = $(this).parent().find(".chzn-container");

        let value = ($(this).val() === null) ? [] : $(this).val();
        let isRemoveTerminal;

        var getSetupValue = $("#get-setup").val();
        if (getSetupValue != 0 && getSetupValue != 2) {
            isRemoveTerminal = ($.inArray("0", value) != -1) ? true : false;
        } else {
            isRemoveTerminal = (value == 0);
        }

        if (isRemoveTerminal) {
            $(this).val(["0"]);

            chosen.find(".chzn-choices").find(".search-choice").each(function()
            {
                if ($(this).find("span").html().trim() != "None") {
                    $(this).remove();
                }
            });

            chosen.find(".chzn-results").find(".result-selected").each(function()
            {
                if ($(this).html().trim() != "None") {
                    $(this).attr("class", "active-result");
                }
            });
        }
    });

    function deleteManualPtuTerminal(ptu)
    {
        var rowIndexTerminal = $(ptu).parents("tr").index();
        let tableBody = $(ptu).parent("tbody")
        let parentRow = $(ptu).parents("tr");
        let headId = $("#row-index-ptu").val();
        var getPTUID = $('#ptu-ids').val();

        var manualIdValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnManualPtuUnit['columnManualPtuUnitId'].td_class
        )[0];

        var manualTransactionValue = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
        )[0];

        var manualImageBound = myJsTableManualPtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnManualPtuUnit['columnManualImageBindPtu'].td_class
        )[0];

        var answer = confirm("Are you sure you want to delete?");
        if (answer) {
            if (manualIdValue == "" || manualIdValue == null){
                var cnt = myJsTableManualPtuUnit.get_row_count() - 1;
                if (cnt == 1) {
                    myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                        [""],
                        1,
                        columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
                    );
                    myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                        [""],
                         1,
                         columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
                    );
                    myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                        [""],
                         1,
                         columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
                    );
                    myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                        [""],
                        1,
                        columnManualPtuUnit['columnManualDeletePtuUnit'].td_class
                    );
                } else {
                    myJsTableManualPtuUnit.delete_row(rowIndexTerminal);
                }

                let id = $("[name='cor-id']").val();
                getCorDetails(id);
            } else if (manualImageBound == ""){
                alert('Unable to delete this PTU Unit, terminals under this unit is already bound to PTU. Unbind terminals first to proceed');
            } else {
                $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientdetails/deleteManualPtuUnit",
                data: {
                    id: manualIdValue,
                    transactionNumber: manualTransactionValue,
                    clientBranchId: headId
                },
                success: function(data)
                {
                    if (data != -1) {
                        var cnt = myJsTableManualPtuUnit.get_row_count() - 1;
                        if (cnt == 1) {
                            myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                                [""],
                                1,
                                columnManualPtuUnit['columnManualPtuUnitId'].td_class
                            );

                            myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                                [" "],
                                1,
                                columnManualPtuUnit['columnManualImageBindPtu'].td_class
                            );
                            myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                                [""],
                                1,
                                columnManualPtuUnit['columnManualPtuPermitNumber'].td_class
                            );
                            myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                                [""],
                                 1,
                                 columnManualPtuUnit['columnManualPtuUnitMinNumber'].td_class
                            );
                            myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                                [""],
                                 1,
                                 columnManualPtuUnit['columnManualPtuSerialNumber'].td_class
                            );
                            myJsTableManualPtuUnit.setvalue_to_rowindex_tdclass(
                                [""],
                                1,
                                columnManualPtuUnit['columnManualDeletePtuUnit'].td_class
                            );
                        } else {
                            myJsTableManualPtuUnit.delete_row(rowIndexTerminal);
                        }
                        alert("Successfully Removed");

                        let id = $("[name='cor-id']").val();
                        getCorDetails(id);

                    } else {
                        alert("Unable to delete. There is an existing unit bound to terminal.");
                        return;
                    }
                }
                });
            }
        }
    }

    /**
     * Save ptu terminal
     */
    function savePtuTerminal(ptu)
    {
        var rowIndexTerminal = $(ptu).parents("tr").index();
        let tableBody = $(ptu).parent("tbody")
        let parentRow = $(ptu).parents("tr");
        let headId = $("#row-index-ptu").val();
        var myId = parentRow.find(".select-ptu-terminal").attr('id');
        var optionValue = parentRow.find(".select-ptu-terminal").val();

        var idValue = myJsTablePtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnPtuUnit['columnPtuUnitId'].td_class
        )[0];
        var permitNumberValue = myJsTablePtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnPtuUnit['columnPtuPermitNumber'].td_class
        )[0];
        var minNumberValue = myJsTablePtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnPtuUnit['columnPtuUnitMinNumber'].td_class
        )[0];
        var serialNumberValue = myJsTablePtuUnit.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnPtuUnit['columnPtuSerialNumber'].td_class
        )[0];
        var answer = "";
        var errorFlag = 0;
        var continueUpdate = 0;

        myJsTablePtuUnit.setvalue_to_rowindex_tdclass(
            [""],
             rowIndexTerminal,
             columnPtuUnit['columnEditPtuUnit'].td_class
        );

      var loadingicon = myJsTablePtuUnit.getelem_by_rowindex_tdclass(rowIndexTerminal, columnPtuUnit['columnEditPtuUnit'].td_class);
        $(loadingicon).attr("src","assets/images/loading.gif");
        $(loadingicon).attr("height","16");
        $(loadingicon).attr("width","16");

        optionValue = (optionValue === null) ? ["0"] : optionValue;

        var getSetupValue = $("#get-setup").val();

        if (optionValue != 0) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientdetails/checkDuplicateTerminal",
                async: false,
                data: {
                    id: idValue,
                    clientBranchId: headId,
                    terminalNumber: optionValue,
                    setupID: getSetupValue
                },
                success: function(data)
                {
                    if (data.error.length != 0) {
                        errorFlag = 1;
                        alert("Some of your selected terminals  you are tyring to bind has already been bound.");
                        //ptuUnit(ptuIdValue);

                //var rowParent = $(rowObj).parent().parent();
                var options = parentRow.find(".select-ptu-terminal").html();
                var optionsValue = parentRow.find(".select-ptu-terminal").val();
                parentRow.find(".chzn-container").remove();
                parentRow.find(".select-ptu-terminal").parent().find("span").remove();
                myJsTablePtuUnit.edit_row(rowIndexTerminal);
                parentRow.find(".select-ptu-terminal").html(options);
                for (let ind = 0; ind < data.error.length; ind++) {
                    var terminalvalue = data.error[ind];
                  $(".select-ptu-terminal option[value=" + terminalvalue + "]").hide();
                }

                optionsValue = null;

                parentRow.find(".select-ptu-terminal").val(optionsValue);
                parentRow.find(".select-ptu-terminal").chosen();
                        return;
                    } else {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?=base_url()?>clientdetails/searchExistingTerminal",
                            async: false,
                            data: {
                                id: idValue,
                                clientBranchId: headId,
                                terminalNumber: optionValue,
                                setupID: getSetupValue
                            },
                            success: function(data)
                            {
                                if (data.different.length != 0 && data.same.length != 0) {
                                    answer = confirm("Some of your selected terminals with manually encoded PTU details from Client Terminal Details page doesn't match with the selected PTU detail. * Selected terminals with matched PTU details will bind automatically upon proceed. \r\n Terminal # "+ data.different +"\n Do you wish to overwrite?");
                                } else if (data.different.length != 0 && data.same.length == 0) {
                                    answer = confirm("The manually encoded PTU details with these terminals from Client Terminal Details page are not the same with the selected PTU detail that you wish to bind. \nDo you want to overwrite it?");
                                } else if (data.same.length != 0 && data.different.length == 0) {
                                    alert("The manually encoded PTU details with these terminals from Client Terminal Details page are the same with the selected PTU detail that you wish to bind. This will bind automatically.");
                                    continueUpdate = 1;
                                } else {
                                    continueUpdate = 1;
                                }
                            }
                        });
                    }
                }
            });
        }

        if (errorFlag == 1) {
        } else {

        if (!answer && continueUpdate == 0 && optionValue != 0) {
            continueUpdate = 0;
            var loadingicon = myJsTablePtuUnit.getelem_by_rowindex_tdclass(rowIndexTerminal, columnPtuUnit['columnEditPtuUnit'].td_class);
            $(loadingicon).attr("src","assets/images/iconupdate.png");
            $(loadingicon).attr("height","16");
            $(loadingicon).attr("width","16");
            return;
        }

        if ((optionValue != 0 && continueUpdate == 1)||(optionValue != 0 &&answer)) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientdetails/getPOSType",
                async: false,
                data: {
                    id: idValue,
                    clientBranchId: headId,
                    permitNumber: permitNumberValue,
                    minNumber: minNumberValue,
                    serialNumber: serialNumberValue,
                    terminalNumber: optionValue,
                    setupID: getSetupValue
                },
                success: function(data)
                {
                    if (data.error.length != 0) {
                        alert(data.message);
                        continueUpdate = 0;
                        var loadingicon = myJsTablePtuUnit.getelem_by_rowindex_tdclass(rowIndexTerminal, columnPtuUnit['columnEditPtuUnit'].td_class);
                        $(loadingicon).attr("src","assets/images/iconupdate.png");
                        $(loadingicon).attr("height","16");
                        $(loadingicon).attr("width","16");
                        return;
                    } else {
                        if (data.message.length != 0) {
                            alert(data.message);
                        }
                        continueUpdate = 1;
                    }
                }
            });
        }

        if (answer || continueUpdate == 1 || optionValue == 0) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>clientdetails/savePtuTerminal",
                data: {
                    id: idValue,
                    setupID: getSetupValue,
                    clientBranchId: headId,
                    permitNumber: permitNumberValue,
                    minNumber: minNumberValue,
                    serialNumber: serialNumberValue,
                    terminalNumber: optionValue
                },
                success: function(data)
                {
                    if (data.error.length != 0) {
                        alert(data.message);
                        continueUpdate = 0;
                        var loadingicon = myJsTablePtuUnit.getelem_by_rowindex_tdclass(rowIndexTerminal, columnPtuUnit['columnEditPtuUnit'].td_class);
                        $(loadingicon).attr("src","assets/images/iconupdate.png");
                        $(loadingicon).attr("height","16");
                        $(loadingicon).attr("width","16");
                        return;
                    } else {
                    alert("Successfully Saved!");
                    edit_flag = 0;
                    var options = parentRow.find(".select-ptu-terminal").html();
                    parentRow.find(".chzn-container").remove();
                    myJsTablePtuUnit.update_row(rowIndexTerminal);
                    parentRow.find(".select-ptu-terminal").html(options);
                    parentRow.find(".select-ptu-terminal").val(optionValue);
                    parentRow.find(".select-ptu-terminal").chosen();

                    let index = 0;
                    $(".select-ptu-terminal").each(function()
                    {
                        if ($(this).parent().parent().find(".save-ptu-terminal").length) {
                            return;
                        }

                        $(this).chosen("destroy");
                        ptuSelect[index] = ($(this).val() !== null) ? $(this).val() : [];
                        index += 1;
                        $(this).hide();
                        $(this).parent().find("span").remove();
                        $('.select-ptu-terminal').trigger("liszt:updated");
                    });
                    doPtuOption(false);

                    if (optionValue == 0) {
                        myJsTablePtuUnit.setvalue_to_rowindex_tdclass(
                            ["<img src='assets/images/imgwarning.png' style='height: 20px; width: 20px;' status='This terminal is not yet bound'>"],
                            rowIndexTerminal,
                            columnPtuUnit['columnImageBindPtu'].td_class
                        );
                    } else {
                        myJsTablePtuUnit.setvalue_to_rowindex_tdclass(
                            [""],
                            rowIndexTerminal,
                            columnPtuUnit['columnImageBindPtu'].td_class
                        );
                    }
                }

                var getCorID = $("[name='cor-id']").val();
                getCorDetails(getCorID);

                var ptuId = $('#ptu-ids').val();

                var getInputMode = $('input[type=radio][name=corAttributes]:checked').val();
                if (getInputMode == 2){
                    checkInputType(ptuId);
                    ptuManualUnit(ptuId);
                }

            }
            });
        }
    }
    }

    function displayCorTable(sourceObject)
    {
        selectPtuTerminalDropdown.setAttribute("multiple", "multiple");
        $('#uploadImage img').hide();
        $("#totalImageCount").val(0);

        var rowIndex = $(sourceObject).parent().parent().index();

        var getImage = myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['columnImageSetup'].td_class)[0];

        var regex = /<img.*?src="(.*?)"/;
        var src = regex.exec(getImage)[1];

        var imageFileName = src.substring(src.lastIndexOf('/') + 1);

        var value = setupImages.indexOf(imageFileName);

        $("#get-setup").val(value);

        if (value == 0 || value == 2) {
            selectPtuTerminalDropdown.removeAttribute('multiple');
        }

        globalRowIndex = rowIndex;
        var values = myjstbl_pul.get_row_values(rowIndex);
        globalHeadId = values[colarray_pul['id_pul'].td_class][0];
        var clientName = values[colarray_pul['columnClient'].td_class][0] 
            + " (" + values[colarray_pul['columnNetworkId'].td_class][0] + ")";
        var branchIdValue = values[colarray_pul['branchid'].td_class][0];
        var branchNameValue = values[colarray_pul['branchname'].td_class][0];
        globalNetworkId = values[colarray_pul['columnClientId'].td_class][0];
        globalBranchId = values[colarray_pul['branchid'].td_class][0];
        if (globalHeadId == "") {
            alert("Please save row first before you can input C.O.R. details");
            return;
        }

        my_autocomplete_add(".import-cor-text", "<?=base_url()?>clientdetails/autocompleteCorDetails?networkId="+globalNetworkId+"&branchId="+globalHeadId, {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error)
            {
                $("#existing-import-id").val(value);
            },
            fnc_render : function(ul, item) {
                return my_autocomplete_render_fnc(ul, item, "code_name", [0],
                    { width : ["400px"] });
            }
        });

        $("#text-client-info").html(clientName+" / "+branchIdValue+" / "+branchNameValue);
        myJsTableCor.clear_table();
        $("#table-ptu").hide();
        $('#client-COR').modal("show");
        $("#row-index").val(rowIndex);
        $(".upload-ptu").prop('disabled', true);

        $("#row-index-network").val(globalNetworkId);
        clearCorDetails();
        displayCorDetails(globalHeadId);

        $('#manualSaveButton').hide();
        $('#manualEditButton').hide();
        $('#manualUpdateButton').hide();
        $('#manualAddRow').hide();
        $('#manualAddNew').hide();
        $(".right-div :input").attr("disabled", true);
        $(".manualBtn :input").attr("disabled", true);
        
        $("#autoAttr").prop("checked", true);
    }

    function displayCorDetails(globalHeadId)
    {
        myJsTableCor.clear_table();
        $(".registration-date" ).datepicker({dateFormat: 'yy-mm-dd'});
        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/displayCorTable",
            type: "POST",
            data: {
                clientBranchId: globalHeadId
            },
            success: function(data)
            {
                myJsTableCor.insert_multiplerow_with_value(1, data.data);
                myJsTablePtuUpload.clear_table();
                myJsTablePtuUnit.clear_table();
                $("#table-information").hide();
                $("#table-units").hide();
                $("#row-index-ptu").val(globalHeadId);

                $("#table-information-manual").hide();
                $("#table-units-manual").hide();

                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["", data.corStatus],
                    globalRowIndex,
                    colarray_pul['corDocument'].td_class
                );
                $(".upload-ptu").prop('disabled', true);
            }
        });
    }

    function getCorDetails(id)
    {
        $(".image-thumbnail-1").attr("src", "");
        $(".image-thumbnail-2").attr("src", "");
        $(".image-thumbnail-3").attr("src", "");
        $(".image-thumbnail-4").attr("src", "");
        $(".image-thumbnail-5").attr("src", "");
        $(".image-thumbnail-6").attr("src", "");
        $("#file-name-1").text("Loading attachment...");
        $("#file-name-2").text("Loading attachment...");
        $("#file-name-3").text("Loading attachment...");
        $("#file-name-4").text("Loading attachment...");
        $("#file-name-5").text("Loading attachment...");
        $("#file-name-6").text("Loading attachment...");
        $(".loading-icon-1").show();
        $(".loading-icon-2").show();
        $(".loading-icon-3").show();
        $(".loading-icon-4").show();
        $(".loading-icon-5").show();
        $(".loading-icon-6").show();

        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/getCorDetails",
            type: "GET",
            data: {
                corId: id
            },
            async: true,
            dataType: 'json',
            success: function(data)
            {
                if (data.existingPtu > 0) {
                    $(".business-name").prop("disabled", true);
                    $(".address").prop("disabled", true);
                    $(".owner").prop("disabled", true);
                    $(".tin-1-edit").prop("disabled", true);
                    $(".tin-2-edit").prop("disabled", true);
                    $(".tin-3-edit").prop("disabled", true);
                    $(".tin-4-edit").prop("disabled", true);
                    $(".vat-status").prop("disabled", true);
                    $(".cor-status").prop("disabled", true);
                    $(".registration-date").prop("disabled", true);
                    $("#save-uploaded-file[type='button']").prop("disabled", true);
                    $("#select-file-button[type='button']").prop("disabled", true);
                } else {
                    $(".business-name").prop("disabled", false);
                    $(".address").prop("disabled", false);
                    $(".owner").prop("disabled", false);
                    $(".tin-1-edit").prop("disabled", false);
                    $(".tin-2-edit").prop("disabled", false);
                    $(".tin-3-edit").prop("disabled", false);
                    $(".tin-4-edit").prop("disabled", false);
                    $(".vat-status").prop("disabled", false);
                    $(".cor-status").prop("disabled", false);
                    $(".registration-date").prop("disabled", false);
                    $("#save-uploaded-file[type='button']").prop("disabled", false);
                    $("#select-file-button[type='button']").prop("disabled", false);
                }

                $("#table-ptu").show();
                ptuUploadTable(id);

                $("#tin-number").val(data.tin);
                $("#existing-cor").val(id);
                $(".loading-status").hide();

                var getFilename = Object.values(data.fileName);
                var getFileID = Object.values(data.attachementID);
                var displayName = Object.values(data.displayName);
 
                var countFilename = getFilename.length;

                if (countFilename >= 6){
                    countFilename = 6;
                }

                if (getFileID == null || getFileID == ""){
                    countFilename = 0;
                }

                if (countFilename < 6){
                    if (data.existingPtu > 0) { 
                        $("#select-file-button[type='button']").prop("disabled", true);
                    } else {
                        $("#select-file-button[type='button']").prop("disabled", false);
                    }
                } else {
                    $("#select-file-button[type='button']").prop("disabled", true);
                }

                $("#totalImageCount").val(countFilename);

                for (var i = 0; i < 6; i++) {
                    if (getFilename[i]) {
                        var source = "application/views/image_view.php?pathto=";
                        source += "<?php echo rawurlencode(CLIENT_DETAILS_ATTACHMENTS_LOCATION); ?>&filename=";
                        source += encodeURI(getFilename[i]);
                        $(".image-thumbnail-"+(i+1)).attr("src", source);
                        var length = displayName[i].length;
                        
                        if (length > 15) {
                            var string1 = displayName[i].substring(0, 15);
                            $("#file-name-"+(i+1)).text(string1+"...");
                        } else {
                            $("#file-name-"+(i+1)).text(displayName[i]);
                        }

                        $(".image-thumbnail-"+(i+1)).show();
                        $("#file-name-"+(i+1)).show();
                        $(".file-name-"+(i+1)).show();
                        $("#image-delete-"+(i+1)).show();
                        $("#imgValue-"+(i+1)).val(getFileID[i]);
                    } else {
                        $(".image-thumbnail-"+(i+1)).hide();
                        $("#file-name-"+(i+1)).hide();
                        $(".file-name-"+(i+1)).hide();
                        $("#image-delete-"+(i+1)).hide();
                        $("#imgValue-"+(i+1)).val("");
                    }
                }
                
                $(".business-name").val(data.businessName);
                $(".address").val(data.address);
                $(".owner").val(data.owner);
                $(".tin-1-edit").val(data.tin1);
                $(".tin-2-edit").val(data.tin2);
                $(".tin-3-edit").val(data.tin3);
                $(".tin-4-edit").val(data.tin4);
                $(".vat-status").val(data.vatStatus);
                $(".cor-status").val(data.status);
                $(".registration-date").val(data.registrationDate);
                $(".loading-icon-1").hide();
                $(".loading-icon-2").hide();
                $(".loading-icon-3").hide();
                $(".loading-icon-4").hide();
                $(".loading-icon-5").hide();
                $(".loading-icon-6").hide();
                $(".cor-popup input[type='button']").prop("disabled", false);
                $(".registration-date" ).datepicker({dateFormat: 'yy-mm-dd'});

                if (data.existingPtu > 0) { 
                    $("#image-delete-1").hide();
                    $("#image-delete-2").hide();
                    $("#image-delete-3").hide();
                    $("#image-delete-4").hide();
                    $("#image-delete-5").hide();
                    $("#image-delete-6").hide();
                }
            }
        });
    }

function  breakString (str, limit) {
                           let brokenString = '';
                           for(let i = 0, count = 0; i < str.length; i++){
                              if(count >= limit && str[i] === ' '){
                                 count = 0;
                                 brokenString += '\n';
                              }else{
                                 count++;
                                 brokenString += str[i];
                              }
                           }
                           return brokenString;
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

    function toterminal_fnc(rowObj) { 

        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
        var gid_val = values_arr[colarray_pul['gid_pul'].td_class][0];
        var netid_val = values_arr[colarray_pul['netid_pul'].td_class][0];
       
        window.open("clientterminaldetails?clientdetailid=" + id_val + "&clientgroupid=" + gid_val + "&clientheadid=" + netid_val);
        
    }

    function todetails_fnc(rowObj) { 

        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;

        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];

        window.open("clientdetails?clientdetailid=" + id_val);

    }

    function set_pages(rowObj) {
    
        uncheck_all();
        
        var row_index = $(rowObj).parent().parent().index();
        headid = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['columnClientId'].td_class)[0];
        
        var fnc = "<?=base_url()?>clienthead/get_settings";
        
        $.getJSON(fnc,
        {
            id: headid
        },
        function(data) {
                        //alert(data);
            if(data == "error"){}
            else {
            
                $("#ddlsubscription").val(data.subscription);
                $("#ddlsubscription").trigger("liszt:updated");
                //alert(data);
                for(var i=0; i < data.pages.length; i++){
                    $("input[name='"+data.pages[i]+"']").attr("checked","checked");
                }
            }
            
            refresh_main_checkbox();
        });
        
    }   
    

    
    function uncheck_all(){
        
        var cbox = document.getElementsByTagName('input');
        for(var i=0; i < cbox.length; i++){
            if(cbox[i].type == 'checkbox'){
                if(cbox[i].className == "chkChinese"){
                    
                } else {
                cbox[i].checked = false;
                //alert(cbox[i].);
                }
            }
        }

    }

    function refresh_main_checkbox()
    {
        if ($(".data-section:checked").length == 9)
            $("#data").attr("checked","checked");
        else
            $("#data").removeAttr("checked");
        
        if ($(".po-section:checked").length == 7)
            $("#po").attr("checked","checked");
        else
            $("#po").removeAttr("checked");

        if ($(".sales-section:checked").length == 7)
            $("#sales").attr("checked","checked");
        else
            $("#sales").removeAttr("checked");

        if ($(".stocks-section:checked").length == 4)
            $("#stocks").attr("checked","checked");
        else
            $("#stocks").removeAttr("checked");

        if ($(".products-section:checked").length == 10)
            $("#products").attr("checked","checked");
        else
            $("#products").removeAttr("checked");
        
        if ($(".financial-section:checked").length == 12)
            $("#financial").attr("checked","checked");
        else
            $("#financial").removeAttr("checked");
        
        if ($(".cussup-section:checked").length == 6)
            $("#cussup").attr("checked","checked");
        else
            $("#cussup").removeAttr("checked");
        
        if ($(".ranking-section:checked").length == 5)
            $("#ranking").attr("checked","checked");
        else
            $("#ranking").removeAttr("checked");

        if ($(".warning-section:checked").length == 4)
            $("#warning").attr("checked","checked");
        else
            $("#warning").removeAttr("checked");
        
        if ($(".summary-section:checked").length == 4)
            $("#summary").attr("checked","checked");
        else
            $("#summary").removeAttr("checked");

        if ($(".otherreport-section:checked").length == 5)
            $("#otherreport").attr("checked","checked");
        else
            $("#otherreport").removeAttr("checked");

        if ($(".others-section:checked").length == 10)
            $("#others").attr("checked","checked");
        else
            $("#others").removeAttr("checked");
                
        if ($(".collector-section:checked").length == 2)
            $("#collector").attr("checked","checked");
        else
            $("#collector").removeAttr("checked");
        
        if ($("#products").is(':checked') && $("#financial").is(':checked') && $("#cussup").is(':checked') && $("#ranking").is(':checked') && $("#warning").is(':checked') && $("#summary").is(':checked') && $("#otherreport").is(':checked'))
            $("#reports-header").attr("checked","checked");
        else
            $("#reports-header").removeAttr("checked");
    }

    function editSelectedRow( myTable, rowObj){
        var rowindex = $(rowObj).parent().parent().index();
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');
        
            if($(rowObj).hasClass("edit_pul2")) {

            myTable.edit_row(rowindex);
            bind_datepicker_to_subrow(rowindex);
            return;
        }   
        
            if($(rowObj).hasClass("edit_pul")) {

            myTable.edit_row(rowindex);
            bind_datepicker_to_subrow2(rowindex);
            autoCompleteNetwork(
                myTable.getelem_by_rowindex_tdclass(rowindex, myTable.colarray['columnClient'].td_class)[0]
            );

            var getExpiredStillUsed = globalExpiredStillUsed[rowindex - 1][24][0];
            var splitted = getExpiredStillUsed.split("|");

            if (splitted[0] == 1) {
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    rowindex,
                    colarray_pul['colStillUsed'].td_class
                )[0].style.display = "block";

                if (splitted[1] == 0) {
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                    rowindex,
                    colarray_pul['colStillUsed'].td_class
                )[0].checked  = false;
                } else {
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                    rowindex,
                    colarray_pul['colStillUsed'].td_class
                )[0].checked  = true;
                }
            } else {
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    rowindex,
                    colarray_pul['colStillUsed'].td_class
                )[0].style.display = "none";
            }

            return;
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

    function editSelectedTerminal( myTable, rowObj) {
        var rowindex = $(rowObj).parent().parent().index();
        if (edit_flag == 1) {
            alert("Finalize binding row changes");
            return;
        }
        edit_flag = 0;
        var rowParent = $(rowObj).parent().parent();
        var options = rowParent.find(".select-ptu-terminal").html();
        var optionValue = rowParent.find(".select-ptu-terminal").val();
        rowParent.find(".chzn-container").remove();
        rowParent.find(".select-ptu-terminal").parent().find("span").remove();
        myTable.edit_row(rowindex);
        rowParent.find(".select-ptu-terminal").html(options);

        if (optionValue !== null && optionValue.length == 1 && optionValue[0] === "0") {
            optionValue = null;
        }

        rowParent.find(".select-ptu-terminal").val(optionValue);
        rowParent.find(".select-ptu-terminal").chosen();
    }

    //UPDATE and INSERT new row on PUL TABLE
    function pul_update_fnc(rowObj) { 
        //alert(m);
        // alert (arr[0][0]);
        if(updaterecord_flag != 0) return;
        updaterecord_flag = 1;

        $('#lblStatus').css('visibility', 'hidden');
        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
        var columnClientId = values_arr[colarray_pul['columnClientId'].td_class][0];
        var branchid_val = values_arr[colarray_pul['branchid'].td_class][0];
        var branchname_val= values_arr[colarray_pul['branchname'].td_class][0];
        var branchcode_val= values_arr[colarray_pul['branchcode'].td_class][0];
        var locationid_val = values_arr[colarray_pul['location_id'].td_class][0];
        var seltechassigned_val = values_arr[colarray_pul['techassigned'].td_class][0];
        var date_start_val= values_arr[colarray_pul['date_start'].td_class][0];
        var date_stop_val= values_arr[colarray_pul['date_stop'].td_class][0];
        var isChinese_val= values_arr[colarray_pul['colselect'].td_class][0];
        var isOutlet_val= values_arr[colarray_pul['colOutlet'].td_class][0];
        var freepoint_elem = myjstbl_pul.getelem_by_rowindex_tdclass(row_index,
                                    colarray_pul['colfreepoint'].td_class)[0];
        var colcollectiontype_val= values_arr[colarray_pul['colcollectiontype'].td_class][0];
        var monthlycharge_val = values_arr[colarray_pul['colmonthlycharge'].td_class][0];
        var isStillUsed_val = values_arr[colarray_pul['colStillUsed'].td_class][0];

        if(date_start_val.length > 0){
            if ( Number(date_start_val.split('-')[2]) > 1 ) {
                alert("date should always be the first day of next month");
                updaterecord_flag = 0;
                return;
            } 
        }

        if(isOutlet_val == 'true'){
            isOutlet_val = '1';
        } else {
            isOutlet_val = '0';
        }

        if(isStillUsed_val == 'true'){
            isStillUsed_val = '1';
        } else {
            isStillUsed_val = '0';
        }
    
        if(date_start_val.length < 1)
        {
            var d = new Date();
            var month = d.getMonth() + 2 == 13 ? 01 : d.getMonth() + 2;
            var year = d.getMonth() + 2 == 13 ? d.getFullYear() + 1 : d.getFullYear();
            date_start_val = year + "-" + ( pad(month)) + "-01";
        }

        if(date_stop_val.length < 1)
        {
            date_stop_val = "0000-00-00 00:00:00";
        }
        
        if(branchid_val.length < 1)
        {
            alert("Please input Branch ID");
            updaterecord_flag = 0;
            return;
        }

        if(branchname_val.length < 1)
        {
            alert("Please input Branch Name");
            updaterecord_flag = 0;
            return;
        }

        if(locationid_val.length < 1)
        {
            alert("Please input Location");
            updaterecord_flag = 0;
            return;
        }

        $.ajax({
            type: "POST",
            async: false,
            url: "<?=base_url()?>clientdetails/checkifBranchExistsOnNetwork",
            data: {
                branchId : branchid_val,
                columnClientId : columnClientId,
                id: id_val
            },
            dataType: 'json',
            success: function(data)
            {
                if(data.errorMessage != ""){
                    alert(data.errorMessage);
                    updaterecord_flag = 3;
                }
            }
        });

        if (updaterecord_flag == 3) {
            updaterecord_flag = 0;
            return;
        }

        if (columnClientId == "") {
            alert("Please input Network");
            updaterecord_flag = 0;
            return;
        }

        var freepoint_val = 0;
        if($(freepoint_elem).attr("checked") == "checked" ) {
            freepoint_val = 1;
        }

        var fnc_pul = "<?=base_url()?>clientdetails/update_control";
        if (id_val == "")
            fnc_pul = "<?=base_url()?>clientdetails/insert_control";

        globalFunction           = fnc_pul;
        globalRowIndex           = row_index;
        globalId                 = id_val;
        globalClientInfo         = columnClientId;
        globalBranchId           = branchid_val;
        globalBranchName         = branchname_val;
        globalBranchCode         = branchcode_val;
        globalLocationId         = locationid_val;
        globalSelectTechAssigned = seltechassigned_val;
        globalDateStart          = date_start_val;
        globalDateStop           = date_stop_val;
        globalisChinese          = isChinese_val;
        globalFreepoint          = freepoint_val;
        globalCollectionType     = colcollectiontype_val;
        globalMonthlyCharge      = monthlycharge_val;
        globalIsOutlet           = isOutlet_val;
        globalIsStillUsed        = isStillUsed_val;

        updateRow (
            fnc_pul,
            row_index,
            id_val,
            columnClientId,
            branchid_val,
            branchname_val,
            branchcode_val,
            locationid_val,
            seltechassigned_val,
            date_start_val,
            date_stop_val,
            isChinese_val,
            freepoint_val,
            colcollectiontype_val,
            monthlycharge_val,
            isOutlet_val,
            isStillUsed_val
        );
    }

    function updateRow(
        functionName,
        rowIndex,
        idVal,
        clientInfoVal,
        branchIdVal,
        branchNameVal,
        branchCodeVal,
        locationIdVal,
        seltechassignedVal,
        dateStartVal,
        dateStopVal,
        isChineseVal,
        freePointVal,
        collectionTypeVal,
        monthlyChargeVal,
        isOutletVal,
        isStillUsedVal
    ) {

        $.ajax({
            type     : "POST",
            url      : functionName,
            async    : true,
            dataType : 'json',
            data: {
                id                : idVal,
                colclientinfo     : clientInfoVal,
                branchid          : branchIdVal,
                branchname        : branchNameVal,
                branchcode        : branchCodeVal,
                locationid        : locationIdVal,
                seltechassigned   : seltechassignedVal,
                date_start        : dateStartVal,
                date_stop         : dateStopVal,
                isChinese         : isChineseVal,
                freepoint         : freePointVal,
                colcollectiontype : collectionTypeVal,
                monthlycharge     : monthlyChargeVal,
                isOutlet          : isOutletVal,
                isStillUsed       : isStillUsedVal
            },
            success: function(data) {
                if (data == "error") {
                    $('#lblStatus').css('visibility', 'visible'); 
                    $('#lblStatus').text("Insufficient Balance!");
                } else {
                    myjstbl_pul.update_row_with_value(rowIndex, data);

                    var getExpiredStillUsed = data[24][0];
                    var splitted = getExpiredStillUsed.split("|");

                    if (splitted[0] == 1) {
                            myjstbl_pul.getelem_by_rowindex_tdclass(
                            rowIndex,
                            colarray_pul['colStillUsed'].td_class
                            )[0].style.display = "block";

                        if (splitted[1] == 0) {
                            myjstbl_pul.getelem_by_rowindex_tdclass(
                            rowIndex,
                            colarray_pul['colStillUsed'].td_class
                            )[0].checked  = false;
                        } else {
                            myjstbl_pul.getelem_by_rowindex_tdclass(
                            rowIndex,
                            colarray_pul['colStillUsed'].td_class
                            )[0].checked  = true;
                        }
                    } else {
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                            rowIndex,
                            colarray_pul['colStillUsed'].td_class
                            )[0].style.display = "none";
                    }

                    if (idVal == "") {
                        myjstbl_pul.add_new_row();
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['coldelete'].td_class
                        )[0].style.display = "none";

                        myjstbl_pul.getelem_by_rowindex_tdclass(
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['colStillUsed'].td_class
                        )[0].style.display = "none";

                        autoCompleteNetwork(
                            myjstbl_pul.getelem_by_rowindex_tdclass(
                                myjstbl_pul.get_row_count() - 1,
                                colarray_pul['columnClient'].td_class
                            )[0]
                        );
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['columnImageStatus'].td_class
                        );
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            ["<img src='assets/images/"+setupImages[0]+"' style='height: 20px; width: 20px;'>"],
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['columnImageSetup'].td_class
                        );
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['columnImageNotes'].td_class
                        );
                        bind_datepicker_to_new_row();
                    }
                }
                $(".custom-alert-button-container input[type='button']").prop("disabled", false);
                $(".loading-icon-1").hide();
                $(".loading-icon-2").hide();
                $(".loading-icon-3").hide();
                $(".loading-icon-4").hide();
                $(".loading-icon-5").hide();
                $(".loading-icon-6").hide();
                $(".custom-alert").hide();
                updaterecord_flag = 0;
                if (data.requestToRefreshTable) {
                    pul_refresh_table();
                }
                updateLogScreen();
            }
        }); 
    }

    function resetRow(id, rowIndex)
    {
        if (id == "") {
            updaterecord_flag = 0;
            $(".custom-alert-button-container input[type='button']").prop("disabled", false);
            $(".loading-icon-1").hide();
            $(".loading-icon-2").hide();
            $(".loading-icon-3").hide();
            $(".loading-icon-4").hide();
            $(".loading-icon-5").hide();
            $(".loading-icon-6").hide();
            $(".custom-alert").hide();
            return;
        }

        for (var imageIndex = 0; imageIndex < 6; imageIndex++) {

                var getImageValue = $("#imgValue-"+(imageIndex+1)).val();

                if (getImageValue){
                    $(".image-thumbnail-" + (imageIndex+1)).attr("src", "assets/images/loading.gif");
                } else {
                    continue;
                }
            }
        $.ajax({
            url: "<?=base_url()?>clientdetails/getRowData",
            type: "POST",
            dataType: "json",
            data: {
                id: id
            },
            success: function(data) {
                myjstbl_pul.update_row_with_value(rowIndex, data);
                myjstbl_pul.add_new_row();
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['coldelete'].td_class
                )[0].style.display = "none";
                autoCompleteNetwork(
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                        myjstbl_pul.get_row_count() - 1,
                        colarray_pul['columnClient'].td_class
                    )[0]
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageStatus'].td_class
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+setupImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageSetup'].td_class
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageNotes'].td_class
                );
                updaterecord_flag = 0;
                updateLogScreen();
                $(".loading-icon-1").hide();
                $(".loading-icon-2").hide();
                $(".loading-icon-3").hide();
                $(".loading-icon-4").hide();
                $(".loading-icon-5").hide();
                $(".loading-icon-6").hide();
                $(".custom-alert").hide();
            }
        });
    }
    
    
    //UPDATE and INSERT new row on PUL TABLE2
    function pul_update_fnc2(rowObj) { 
        //alert(m);
        // alert (arr[0][0]);
        if(updaterecord_flag != 0) return;
        updaterecord_flag = 1;

        $('#lblStatus').css('visibility', 'hidden');
        var cnt = myjstbl_pul2.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul2.get_row_values(row_index);
        var id_val = values_arr[colarray_pul2['id_pul'].td_class][0];
        var type_val= values_arr[colarray_pul2['type'].td_class][0];
        var branchid_val= values_arr[colarray_pul2['branchid'].td_class][0];
        var schedule_val = values_arr[colarray_pul2['ScheduledDate'].td_class][0];
        var status_val= values_arr[colarray_pul2['colstatus'].td_class][0];
        
        if(status_val == 'true'){
            status_val = 'Done';
            
        } else {
            status_val = 'Resched';
        }
        
        fnc_pul = "<?=base_url()?>clientdetails/insert_control2";

        $.ajax({
            type: "POST",
            url: fnc_pul,
            async: true,
            dataType: 'json',
            data: {
                id:id_val,
                type: type_val,
                branchid: branchid_val,
                schedule: schedule_val,
                status: status_val
            },
            success: function(data) {
                if(data == "error"){
                    $('#lblStatus').css('visibility', 'visible'); 
                    $('#lblStatus').text("Insufficient Balance!");
                }
                else{
                    //myjstbl_pul2.add_new_row();
                    myjstbl_pul2.update_row_with_value(row_index,data);
                }
            },
            complete: function() {
                updaterecord_flag = 0;
                updateLogScreen();
            }
        });
    }

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
        var clientDetailsId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index-notes").val(),
            colarray_pul['id_pul'].td_class
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
                url: "<?=base_url()?>clientdetails/deleteClientNotes",
                data: {
                    id: idValue,
                    hiddenId: idHiddenValue,
                    clientId: clientDetailsId,
                    notes: notesValue
                },
                success: function(data)
                {
                    myJsTableNotes.delete_row(rowIndexNotes);
                    $("#label-status-notes").text("Successfully Removed!");
                    myjstbl_pul.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+notesImages[data]+"' style='height: 20px; width: 20px;'>"],
                        $("#row-index-notes").val(),
                        colarray_pul['columnImageNotes'].td_class
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

    //Delete Function For PUL Table
    $('.imgdel').live('click',function() {
       $('#lblStatus').css('visibility', 'hidden');
       var cnt = myjstbl_pul.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
       var id_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
       var hasTerminalRemaining = false;
       var hasMaintenanceCollectionRemaining = false;

        $.ajax(
        {
            url: "<?=base_url()?>clientdetails/countMaintenanceCollectionAndTerminal",
            dataType: "json",
            type: "POST",
            data: {
                id: id_val
            },
            async: false,
            success: function(data)
            {
                hasTerminalRemaining = data[0] > 0;
                hasMaintenanceCollectionRemaining = data[1] > 0;
            }
        });

        if (hasTerminalRemaining && hasMaintenanceCollectionRemaining) {
            alert("Branch can only be deleted if no terminal exists and no payment collected for maintenance");
            return;
        } else if (hasTerminalRemaining && ! hasMaintenanceCollectionRemaining) {
            alert("Branch can only be deleted if no terminal exists");
            return;
        } else if (! hasTerminalRemaining && hasMaintenanceCollectionRemaining) {
            alert("Branch can only be deleted if no payment collected for maintenance");
            return;
        }
        
        var answer = confirm("Are you sure you want to delete?");
        if(answer==true){
            $.get("<?=base_url()?>clientdetails/delete_control",
            {id: id_val},
            function(data){
                $('#lblStatus').css('visibility', 'visible'); 
                myjstbl_pul.delete_row(row_index);
                $('#lblStatus').text("Removed!");
                myjstbl_pul.add_new_row();
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['coldelete'].td_class
                )[0].style.display = "none";
                autoCompleteNetwork(
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                        myjstbl_pul.get_row_count() - 1,
                        colarray_pul['columnClient'].td_class
                    )[0]
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageStatus'].td_class
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+setupImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageSetup'].td_class
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageNotes'].td_class
                );
                bind_datepicker_to_new_row();
                updateLogScreen();
            });
        }
    });

    
    function pul_refresh_table(rowstart, rowend) 
    {
        if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined'))
        {
            myjstbl_pul.clear_table();
        }
        else
        {
            myjstbl_pul.clean_table();
        }
        
        var search_val = $.trim($('#txtsearch').val());
        var filterreset_val = (typeof rowstart === 'undefined')?1:0;
        var row_start_val = (typeof rowstart === 'undefined' || rowstart < 0)?0:rowstart;
        var row_end_val = (typeof rowend === 'undefined')?(myjstbl_pul.mypage.mysql_interval-1):rowend;
        var clientdetailsid_val = (<?=$clientdetailid?>);
        
        $('#lblStatus').css('visibility', 'hidden');

        //Hide table and create loading indicator

        $.ajax(
        {
          url: "<?=base_url()?>clientdetails/pul_refresh",
          type: "POST",
          data: { search: search_val,
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val(),
                clientSetup: $("#filter-client-setup").val(),
                clientStatus: $("#filter-client-status").val(),
                clientdetailsid: clientdetailsid_val,
                filterreset: filterreset_val,
                rowstart: row_start_val,
                rowend: row_end_val
                },
          async: true,
          success: function(data)
          {
            if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined'))
            {
               myjstbl_pul.clear_table();
            }
            else
            {
                myjstbl_pul.clean_table();
            }

            //=============================================

            if(filterreset_val == 1)
            {
                var rowcnt = data.rowcnt;

                if(rowcnt == 0 )
                {
                    myjstbl_pul.mypage.set_last_page(0);
                }
                else
                {
                    myjstbl_pul.mypage.set_last_page( Math.ceil(Number(rowcnt) / Number(myjstbl_pul.mypage.filter_number)));
                }
            }

            var pages_per_query = Number(myjstbl_pul.mypage.mysql_interval) / Number(myjstbl_pul.mypage.filter_number);
            var firstPageOfLastQuery = ( Math.floor(Number(myjstbl_pul.mypage.get_last_page()) / pages_per_query) )*(pages_per_query);
            var current_page = $("#tableid_pul_txtpagenumber").val();

            myjstbl_pul.insert_multiplerow_with_value(1,data.data);

            globalExpiredStillUsed = data.data;
            console.log(globalExpiredStillUsed);
            for (var index = 0; index < myjstbl_pul.get_row_count() - 1; index++) {

                var getExpiredStillUsed = data.data[index][24][0];
                var splitted = getExpiredStillUsed.split("|");

                if (splitted[0] == 1) {
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                        index + 1,
                        colarray_pul['colStillUsed'].td_class
                        )[0].style.display = "block";

                    if (splitted[1] == 0) {
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                        index + 1,
                        colarray_pul['colStillUsed'].td_class
                        )[0].checked  = false;
                    } else {
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                        index + 1,
                        colarray_pul['colStillUsed'].td_class
                        )[0].checked  = true;
                    }
                } else {
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                        index + 1,
                        colarray_pul['colStillUsed'].td_class
                        )[0].style.display = "none";
                }
            }

            if(current_page >= firstPageOfLastQuery) 
            {
                myjstbl_pul.add_new_row();
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['coldelete'].td_class
                )[0].style.display = "none";

                myjstbl_pul.getelem_by_rowindex_tdclass(
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['colStillUsed'].td_class
                )[0].style.display = "none";

                autoCompleteNetwork(
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                        myjstbl_pul.get_row_count() - 1,
                        colarray_pul['columnClient'].td_class
                    )[0]
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageStatus'].td_class
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+setupImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageSetup'].td_class
                );
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageNotes'].td_class
                );
                bind_datepicker_to_new_row();
            }
            isFirstLoad = false;
            $("#tableid_pul").wrap("<div class='scrollable'></div>");
            //===========================================
          }
        });        
    
        /*$.getJSON("<?=base_url()?>clientdetails/pul_refresh",
            { 
                search: search_val,
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val(),
                isfreepoint : $("#selfreepoint").val()
            },
            function(data) { 
                myjstbl_pul.add_new_row();
                myjstbl_pul.insert_multiplerow_with_value(1,data);  
            });*/
    }

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
            url: "<?=base_url()?>clientdetails/displayClientNotes",
            type: "POST",
            data: {
                id: myjstbl_pul.getvalue_by_rowindex_tdclass(
                        $("#row-index-notes").val(),
                        colarray_pul['id_pul'].td_class
                    )[0]
            },
            success: function(data)
            {
                $('#label-status-notes').text("");
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
            },
            complete: function()
            {
                  updaterecord_flag = 0;
                  updateLogScreen();
            }
        });
    }

    
    function bind_datepicker_to_subrow(row_index){
    
        var date_element1 = myjstbl_pul2.getelem_by_rowindex_tdclass(row_index, colarray_pul2['ScheduledDate'].td_class);

        var identifier = row_index.toString();
        $(date_element1).attr("id","ScheduledDate" + identifier);
        $("#" + "ScheduledDate" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
        
    }
    
    function bind_datepicker_to_subrow2(row_index){
    
        var date_element2 = myjstbl_pul.getelem_by_rowindex_tdclass(row_index, colarray_pul['date_start'].td_class);

        var identifier = row_index.toString();
        $(date_element2).attr("id","idtxtdate_start" + identifier);
        $("#" + "idtxtdate_start" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
        
    }
    
    function bind_datepicker_to_new_row(){
        var count = myjstbl_pul.get_row_count() - 1;
        var date_element2 = myjstbl_pul.getelem_by_rowindex_tdclass(count, colarray_pul['date_start'].td_class);

        var identifier = count.toString();
        $(date_element2).attr("id","idtxtdate_start" + identifier);
        $("#" + "idtxtdate_start" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
    }
    
    function maintenance_fnc(rowObj) { 

        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
       //alert(id_val);
       
              $.ajax(
        {
          url: "<?=base_url()?>clientdetails/pul_refresh2",
          type: "POST",
          data: { branchid: id_val
                },
          async: true,
          success: function(data)
          {                
          

          
            if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined'))
            {
               myjstbl_pul2.clear_table();
            }
            else
            {
                myjstbl_pul2.clean_table();
            }

            //=============================================


            var pages_per_query = Number(myjstbl_pul2.mypage.mysql_interval) / Number(myjstbl_pul2.mypage.filter_number);
            var firstPageOfLastQuery = ( Math.floor(Number(myjstbl_pul2.mypage.get_last_page()) / pages_per_query) )*(pages_per_query);
            var current_page = $("#tableid_pul2_txtpagenumber").val();
            myjstbl_pul2.insert_multiplerow_with_value(1,data.data);  


            //===========================================
          },         
          complete: function()
          {
            $("#tableid_pul2").show();
            $("#spanloading2").remove();
            $("#ScheduledDate" ).datepicker();
          }
        });     
       
        
    }

    function uploadPreview(input, totalImageCount)
    {
        var getTotalImageCount = 0;
        if (isNaN(totalImageCount) || (totalImageCount.length == 0)){
            getTotalImageCount = 0;
        } else {
            getTotalImageCount = totalImageCount;
        }

        var totalImageFiles = input.files.length - 1;

        if (input.files && (+totalImageCount + +input.files.length) <= 6) {
            var newTotalImageCount = +totalImageCount + +input.files.length;
            $("#totalImageCount").val(newTotalImageCount);

            if (newTotalImageCount == 6){
                $("#select-file-button[type='button']").prop("disabled", true);
            }

            var newImageIndex = 0;
            for (var imageIndex = 0; imageIndex < 6; imageIndex++) {

                var getImageValue = $("#imgValue-"+(imageIndex+1)).val();

                if (!getImageValue){
                    var length = input.files[newImageIndex].name.length;

                    if (length > 15) {
                        var string1 = input.files[newImageIndex].name.substring(0, 15);
                        $("#file-name-"+(imageIndex+1)).text(string1+"...");
                    } else {
                        $("#file-name-"+(imageIndex+1)).text(input.files[newImageIndex].name);
                    }

                    setupReader(input.files[newImageIndex], (imageIndex+1));

                    $(".image-thumbnail-"+(imageIndex+1)).show();
                    $("#file-name-"+(imageIndex+1)).show();
                    $(".file-name-"+(imageIndex+1)).show();
                    $("#image-delete-"+(imageIndex+1)).show();
                    $("#imgValue-"+(imageIndex+1)).val(".");

                    newImageIndex++;
                } else {
                    continue;
                }
            }
        } else { 
            alert("You have reached maximum number of attachments. You cannot add further.");
        }
    }

    function setupReader(files, imageIndex)
    {
        var reader = new FileReader();
        reader.onload = function(e) {  
            $(".image-thumbnail-" + imageIndex).attr("src", e.target.result);
        }
        reader.readAsDataURL(files);
    }

    function autoCompleteNetwork(selector)
    {
        my_autocomplete_add(
            selector,
            "<?=base_url()?>clientdetails/autoCompleteNetwork?groupFilter="+$("#filterclientgroup").val(),
            {
                enable_add: false,
                fnc_callback: function(x, label, value, ret_datas, error) {
                    var rowIndex = $(x).parent().parent().index();
                    if (error.length > 0) {
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            [""],
                            rowIndex,
                            colarray_pul['columnClientId'].td_class
                        );
                        myjstbl_pul.setvalue_to_rowindex_tdclass([""], rowIndex, colarray_pul['columnClient'].td_class);
                    } else {
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            [value],
                            rowIndex,
                            colarray_pul['columnClientId'].td_class
                        );
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            [label],
                            rowIndex,
                            colarray_pul['columnClient'].td_class
                        );
                    }
                },
                fnc_render: function(ul, item) {
                    return my_autocomplete_render_fnc(ul, item, "code_name", [0], { width : ["400px"] });
                }
            }
        );
    }

    /**
     * set to active branch column
     * {string}  selectedSetup  [selected setup value]
    */
    function setSelectedBranchSetup(selectedSetup)
    {
        $(".branch-setup-column")
            .removeAttr("class")
            .attr("class", "branch-setup-column");

        $("td[class='branch-setup-column'][setup='"+selectedSetup+"']")
            .attr("class", "branch-setup-column branch-setup-column-selected");
    }

    function changeSetup(setup) {
        $("#setup0").hide();
        $("#setup1").hide();
        $("#setup2").hide();
        $("#setupX0").hide();
        $("#setupX1").hide();
        $("#setupX2").hide();
        $('#saveSetupButton2').hide();

        var setup = $(setup).children();
        var rowIndex = setup.parents("tr").index();
        var imageFileName = setup.prop("src").substring(setup.prop("src").lastIndexOf('/') + 1);
        var value = setupImages.indexOf(imageFileName);

        if (myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['id_pul'].td_class)[0] == "") {
            alert("Please save row first before you can change setup");
            return;
        }

        $("#row-index").val(rowIndex);
        $("input[name=setup][value="+ value+"]").prop("checked", true);
        // $('#detailgroup').modal("show");

        setSelectedBranchSetup(value);
        $(".branch-setup-column").unbind("click").click(function()
        {
            let setup = $(this).attr("setup");
            setSelectedBranchSetup(setup);
            $("input[name=setup][value="+ setup+"]").prop("checked", true);
        });

        var getHeadID = myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['id_pul'].td_class)[0];

        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>clientdetails/checkSetupPTU",
            data: {
                id: getHeadID
            },  
            success: function(data) {
                var getBindedTerminals = data.totalCount;

                if (getBindedTerminals > 0) {
                    if (value == 0 || value == 2){
                        $('.customer-detail-modal-2').css('width','35%');
                        $('#detailgroup-2').modal("show");

                        $("#setupX0").show();
                        $("#setupX2").show();

                        $('#saveSetupButton2').show();
                    } else {
                        $('.customer-detail-modal-2').css('width','20%');
                        $('#detailgroup-2').modal("show");

                        $("#setupX1").show();

                        $('#saveSetupButton2').hide();
                    }
                } else {
                    $('#detailgroup').modal("show");

                    $("#setup0").show();
                    $("#setup1").show();
                    $("#setup2").show();
                }
            }
        });
    }

    function changeStatus(status)
    {
        var status = $(status).children();
        var rowIndex = status.parents("tr").index();
        var imageFileName = status.prop("src").substring(status.prop("src").lastIndexOf('/') + 1);
        var value = statusImages.indexOf(imageFileName);

        if (myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['id_pul'].td_class)[0] == "") {
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

    function saveStatus()
    {
        if (updaterecord_flag != 0) {
            return;
        }
        updaterecord_flag = 1;

        var clientDetailsId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index-status").val(),
            colarray_pul['id_pul'].td_class
        )[0];
        var statusValue = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index-status").val(),
            colarray_pul['columnImageStatus'].td_class
        )[0];
        if (statusValue.indexOf('green_status.png') >= 0) {
            statusValue = 0;
        } else {
            statusValue = 1;
        }

        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>clientdetails/saveStatus",
            data: {
                id: clientDetailsId,
                status: statusValue
            },
            success: function(data)
            {
                var imageFileName = statusImages[statusValue];

                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+imageFileName+"' style='height: 20px; width: 20px;'>"],
                    $("#row-index-status").val(),
                    colarray_pul['columnImageStatus'].td_class
                );
                $("#client-status").modal("hide");

                updaterecord_flag = 0;
                updateLogScreen();
            }
        });
    }

    function addClientNotes(notes)
    {
        var rowIndex = $(notes).parents("tr").index();
        var clientDetailsId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray_pul['id_pul'].td_class
        )[0];

        if (myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['id_pul'].td_class)[0] == "") {
            alert("Please save row first before you can change notes");
            return;
        }

        $("#row-index-notes").val(rowIndex);
        $('#client-notes').modal("show");
        clientNotesTable();
    }

    function saveClientNotes(notes)
    {
        if (updaterecord_flag != 0) {
            return;
        }
        updaterecord_flag = 1;

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
        var clientDetailsId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index-notes").val(),
            colarray_pul['id_pul'].td_class
        )[0];

        if (notesValue == "" || (notesValue == "" && referenceValue == "")) {
            alert("Notes field is required.");
            updaterecord_flag = 0;
            return;
        }

        if (notesValue.trim().length == 0) {
            alert("Notes cannot contain white spaces only.");
            return;
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url()?>clientdetails/saveClientNotes",
            data: {
                hiddenId: idHiddenValue,
                id: idValue,
                clientId: clientDetailsId,
                notes: notesValue,
                reference: referenceValue
            },
            success: function(data)
            {
                if (idHiddenValue != "") {
                    $('#label-status-notes').text("Successfully Updated!");
                } else {
                    $('#label-status-notes').text("Successfully Added!");
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
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[1]+"' style='height: 20px; width: 20px;'>"],
                    $("#row-index-notes").val(),
                    colarray_pul['columnImageNotes'].td_class
                );
                $(".text-notes").focus();
            },
            complete: function()
            {
                updaterecord_flag = 0;
                updateLogScreen();
            }
        });
    }

    function saveSetup() {
        if (updaterecord_flag != 0) {
            return;
        }
        updaterecord_flag = 1;

        var clientDetailsId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index").val(),
            colarray_pul['id_pul'].td_class
        )[0];
        var setupValue = $("input[name=setup]:checked").val();

        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>clientdetails/saveSetup",
            data: {
                id: clientDetailsId,
                setup: $("input[name=setup]:checked").val()
            },  
            success: function(data) {
                var imageFileName = setupImages[setupValue];

                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+imageFileName+"' style='height: 20px; width: 20px;'>"],
                    $("#row-index").val(),
                    colarray_pul['columnImageSetup'].td_class
                );
                $("#detailgroup").modal("hide");
                $("#detailgroup-2").modal("hide");

                updaterecord_flag = 0;
                updateLogScreen();
            }
        });
    }

    function saveAccred(){
        let fileUpload = $("#file-upload-ptu")[0];

        /* PTU Head*/
        let headId = $("#ptu-id").val();
        let existingCor = $('#cor-id').val();
        let fileNameValue = $('#filename').val();
        let ptuNumberOfUnits = $("#number-of-units").val();
        let htmlText = $("#upload-file").val();
        let transactionNumberValue = $("#transaction-number").val();
        let permitTypeValue = $("#permit-type").val();
        let machineSetupValue = $("#machine-setup").val();
        let rdoCodeValue = $("#rdo-code").val();
        let tinBranchCodeValue = $("#tin-branch-code").val();
        let registeredNameValue = $("#registered-name").val();
        let firstNameValue = $("#first-name").val();
        let middleNameValue = $("#middle-name").val();
        let lastNameValue = $("#last-name").val();
        let extensionNameValue = $("#extension-name").val();
        let showOtherName = $("#other-name").val();
        let businessNameValue = $("#business-name").val();
        let businessAddressValue = $("#business-address").val();
        let index = $("#index").val();
        let existingTinNumber = $("#existing-tin-number").val();

        /* PTU Detail */
        let accred_val = $('#accredlist').val();

        let accred_provider_val = $('#accredlist').val() + " - " + $("#provider-name").html();

        if(accred_val == "None")
            accred_val = "-";

        let permitNumbers = $('#permit-number').val().split(",");
        let minNumbers = $('#min').val().split(",");
        let accreditationNumbers = $('#acc-number').val().split(",");
        let effectiveDates = $('#date-of-permit').val().split(",");
        let serialNumbers = $('#serial-number').val().split(",");
        let softwareNames = $('#brand').val().split(",");
        let softwareVersions = $('#model').val().split(",");        

        $.ajax({
            url: "<?=base_url("clientdetails/savePtuUpload")?>",
            type: "POST",
            data: {
                id: 0,
                clientBranch: headId,
                existingCor: existingCor,
                fileName: fileNameValue,
                numberOfUnits: ptuNumberOfUnits,
                ptuUploadFile: htmlText,
                transactionNumber: transactionNumberValue,
                permitType: permitTypeValue,
                machineSetup: machineSetupValue,
                rdoCode: rdoCodeValue,
                tinBranchCode: tinBranchCodeValue,
                registeredName: registeredNameValue,
                firstNameValue: firstNameValue,
                middleNameValue: middleNameValue,
                lastNameValue: lastNameValue,
                extensionNameValue: extensionNameValue,
                showOtherName: showOtherName,
                businessName: businessNameValue,
                businessAddress: businessAddressValue,
                accreditationNumbers : accred_provider_val
            },
            dataType: "json",
            success: function(response)
            {
                for (var ptuIndex = 0; ptuIndex < ptuNumberOfUnits; ptuIndex++) {

                    let permitNumberValue = permitNumbers[ptuIndex];
                    let minNumberValue = minNumbers[ptuIndex];
                    let accreditationNumberValue = accreditationNumbers[ptuIndex];
                    let effectiveDateValue = effectiveDates[ptuIndex];
                    let serialNumberValue = serialNumbers[ptuIndex];
                    let softwareNameValue = softwareNames[ptuIndex];
                    let softwareVersionValue = softwareVersions[ptuIndex];

                    if(accreditationNumberValue == "-")
                        accreditationNumberValue = accred_val;
                    
                    $.ajax({
                        url: "<?=base_url("clientdetails/savePtuUnits")?>",
                        type: "POST",
                        data: {
                            clientBranch: headId,
                            transactionNumber: transactionNumberValue,
                            permitNumber: permitNumberValue,
                            minNumber: minNumberValue,
                            serialNumber: serialNumberValue,
                            accreditationNumber: accreditationNumberValue,
                            effectiveDate: effectiveDateValue,
                            softwareName: softwareNameValue,
                            softwareVersion: softwareVersionValue
                        },
                        dataType: "json",
                        async: false,
                        success: function(data) {}
                    });
                }

                if (! response.isError) {
                    $("#table-ptu").show();
                    ptuUploadTable(existingCor);
                }

                messagePtuUpload += "\"" + fileNameValue + "\" = " + "Successfully saved." + "\r\n";
                index += 1;
                $(".tin-1-edit").prop("disabled", true);
                $(".tin-2-edit").prop("disabled", true);
                $(".tin-3-edit").prop("disabled", true);
                $(".tin-4-edit").prop("disabled", true);
                htmlReader(fileUpload, headId, existingTinNumber, index, existingCor);

                showLoading(false, "", false);
                $('#choose-accred').modal("hide");

                ptuInformation(existingCor, response.ptuId);
                $("#table-information").show();
                ptuUnit(response.ptuId)
                $("#table-units").show();

                $("input[name='file-upload-ptu']").val(null);
            }
        });
    }

    function closeAccredDialog(){
        $('#choose-accred').modal("hide");
        $("input[name='file-upload-ptu']").val(null);
        messagePtuUpload +=
                    " No Accreditation was selected, file will not be save. \r\n";
        alert(messagePtuUpload);
        showLoading(false, "", false);
    }

</script>
