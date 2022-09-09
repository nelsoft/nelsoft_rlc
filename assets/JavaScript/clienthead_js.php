<script language="javascript" type="text/javascript">
    <?php 
        $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
        $isManagementPosition = $_SESSION["position_id"] == 7;
    ?>

    var notesImages = ["without_notes.png", "notes.ico"];
    var updaterecord_flag = 0;
    // P.U.L Table
    var myjstbl_pul;
    var tab_pul = document.createElement('table');
    tab_pul.id="tableid_pul";
    tab_pul.className = "table table-bordered tbl-design";

    var colarray_pul = [];
    
    var isFirstLoad = true;

	var id_pul = document.createElement('span');
    colarray_pul['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid tdpopuphover",
        headertd_class : "tdclick tdid"
    };

	
    var spnclientgroup_id = document.createElement('span');
    spnclientgroup_id.className = 'spnclientgroup_id';
    colarray_pul['clientgroup_id'] = { 
        header_title: "Client Group id",
        edit: [spnclientgroup_id],
        disp: [spnclientgroup_id],
        td_class: "tablerow tdclientgroup_id",
        headertd_class : "tdclick tdclientgroup_id"
    };

	
	var chkselect = document.createElement('input');
	chkselect.type = "radio";
	chkselect.name = "radio1";
	chkselect.style = "display:none";
	chkselect.value = "1";
	chkselect.className = "chkselect";
	colarray_pul['clientgroup_sel'] = { 
		header_title: "",
		edit: [chkselect],
		disp: [chkselect],
		td_class: "tablerow tdselect"
	};

    var selsoftware_type = document.createElement('select');
    selsoftware_type.className = "sel_software_type";
    selsoftware_type.innerHTML = '<option value="0" selected="selected">None</option><option value="1">Retail</option><option value="2">CIRMS</option><option value="3">Lettuce</option><option value="4">Hybrid (Retail & CIRMS)</option>';
    var selsoftware_type_disp = selsoftware_type.cloneNode(true);
    selsoftware_type_disp.disabled = "disabled";
    colarray_pul['colsoftwaretype'] = { 
        header_title: "Type", 
        edit: [selsoftware_type], 
        disp: [selsoftware_type_disp], 
        td_class: "tablerow tdsoftwaretype"
    };
	
    var spnclientgroup_name = document.createElement('span');
    var txtclientgroup_name = document.createElement('input');
    txtclientgroup_name.type = "text";
    txtclientgroup_name.id = 'idtxtclientgroup_name';
    txtclientgroup_name.className = 'txtclientgroup_name';
    colarray_pul['clientgroup_name'] = { 
        header_title: "Client Group",
        edit: [txtclientgroup_name],
        disp: [spnclientgroup_name],
        td_class: "tablerow tdclientgroup_name",
        headertd_class : "hdclientgroup_name tdclick"
    };

    var spnname = document.createElement('span');
	var txtname = document.createElement('input');
	txtname.type = "text";
    txtname.id = 'idtxtname';
    txtname.className = 'txtname';
    colarray_pul['name'] = { 
        header_title: "Name",
        edit: [txtname],
        disp: [spnname],
        td_class: "tablerow tdname",
		headertd_class : "hdname tdclick"
    };
	
     
    var spnBusinessName = document.createElement('span');
    var txtBusinessName = document.createElement('input');
    txtBusinessName.type = "text";
    txtBusinessName.id = 'idtxtBusinessName';
    txtBusinessName.className = 'BusinessName';
    colarray_pul['BusinessName'] = { 
        header_title: "Business / Registered Name",
        edit: [txtBusinessName],
        disp: [spnBusinessName],
        td_class: "tablerow tdBusinessName",
        headertd_class : "hdBusinessName tdclick"
    };

    var spnRegisteredName = document.createElement('span');
    spnRegisteredName.style = "display: none";
    var txtRegisteredName = document.createElement('input');
    txtRegisteredName.style = "display: none";
    txtRegisteredName.type = "text";
    txtRegisteredName.id = 'idtxtRegisteredName';
    txtRegisteredName.className = 'RegisteredName';
    colarray_pul['RegisteredName'] = { 
        header_title: "",
        edit: [txtRegisteredName],
        disp: [spnRegisteredName],
        td_class: "tablerow tdRegisteredName",
        headertd_class : "hdRegisteredName tdclick"
    };

    var seldevassigned = document.createElement('select');
    seldevassigned.className = "seldevassigned";
    seldevassigned.disabled = "disabled";
    seldevassigned.style = "display: none";
    seldevassigned.innerHTML = '<?php echo fill_select_options("SELECT `id`, `name` FROM `members` WHERE `type` = 0 ORDER BY `name`", "id", "name",0,false); ?>';
    var seldevassigned_disp = seldevassigned.cloneNode(true);
    seldevassigned_disp.disabled = "disabled";
    seldevassigned_disp.style = "display: none";
    colarray_pul['devassigned'] = { 
        header_title: "", 
        edit: [seldevassigned], 
        disp: [seldevassigned_disp], 
        td_class: "tablerow tddevassigned"
    };
/*
    var seltechassigned = document.createElement('select');
    seltechassigned.className = "seltechassigned";
    seltechassigned.innerHTML = '<?php echo fill_select_options("SELECT `id`, `name` FROM `members` WHERE `type` = 1 ORDER BY `name`", "id", "name",0,false); ?>';
    var seltechassigned_disp = seltechassigned.cloneNode(true);
    seltechassigned_disp.disabled = "disabled";
    colarray_pul['techassigned'] = { 
        header_title: "Tech Assigned", 
        edit: [seltechassigned], 
        disp: [seltechassigned_disp], 
        td_class: "tablerow tdtechassigned"
    };*/

    var spanOwner = document.createElement('span');
    var textOwner = document.createElement('input');
    textOwner.type = "text";
    textOwner.id = 'text-owner';
    textOwner.className = 'text-owner';
    colarray_pul['owner'] = { 
        header_title: "Owner",
        edit: [textOwner],
        disp: [spanOwner],
        td_class: "tablerow td-owner",
        headertd_class : "header-owner tdclick"
    };

    var spnemail = document.createElement('span');
    var txtemail = document.createElement('input');
    txtemail.type = "text";
    txtemail.id = 'idtxtemail';
    txtemail.className = 'txtemail';
    colarray_pul['email'] = { 
        header_title: "email",
        edit: [txtemail],
        disp: [spnemail],
        td_class: "tablerow tdemail",
        headertd_class : "hdemail tdclick"
    };

    var spnpassword = document.createElement('span');
    var txtpassword = document.createElement('input');
    txtpassword.type = "text";
    txtpassword.id = 'idtxtpassword';
    txtpassword.className = 'txtpassword';
    colarray_pul['password'] = { 
        header_title: "password",
        edit: [txtpassword],
        disp: [spnpassword],
        td_class: "tablerow tdpassword",
        headertd_class : "hdpassword tdclick"
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

    var spneacusername = document.createElement('span');
    var txteacusername = document.createElement('input');
    txteacusername.type = "text";
    txteacusername.id = 'txteacusername';
    txteacusername.className = 'txteacusername';
    colarray_pul['eacusername'] = { 
        header_title: "EAC Username",
        edit: [txteacusername],
        disp: [spneacusername],
        td_class: "tablerow tdeacusername",
        headertd_class : "hdeacusername tdclick"
    };
	
    var spneacpassword = document.createElement('span');
    var txteacpassword = document.createElement('input');
    txteacpassword.type = "text";
    txteacpassword.id = 'txteacpassword';
    txteacpassword.className = 'txteacpassword';
    colarray_pul['eacpassword'] = { 
        header_title: "EAC Password",
        edit: [txteacpassword],
        disp: [spneacpassword],
        td_class: "tablerow tdeacpassword",
        headertd_class : "hdeacpassword tdclick"
    };

	var imgUpload = document.createElement('img')
    imgUpload.src = "assets/images/SuppDocs.png";
    imgUpload.setAttribute("class","btn btn-info btn-lg");
    imgUpload.setAttribute("id","imgUpload");
	imgUpload.style.height = '20px';
	imgUpload.style.width = '20px';
	imgUpload.style.cursor = "pointer";
	imgUpload.setAttribute("onclick","upload_page(this)");
	imgUpload.setAttribute("data-target","#myModal2");
	imgUpload.setAttribute("data-toggle","modal");
    colarray_pul['colupload'] = { 
        header_title: "",
        edit: [imgUpload],
        disp: [imgUpload],
        td_class: "tablerow tdpages",
        headertd_class: "hdpages"
    };
	
	var imgPages = document.createElement('img')
    imgPages.src = "assets/images/imgproductlist.png";
    imgPages.setAttribute("class","btn btn-info btn-lg");
	imgPages.style = "display:none";
    imgPages.setAttribute("id","imgPages");
	//imgPages.style.height = '20px';
	//imgPages.style.width = '20px';			
	imgPages.style.cursor = "pointer";
	imgPages.setAttribute("onclick","set_pages(this)");
	imgPages.setAttribute("data-target","#myModal");
	imgPages.setAttribute("data-toggle","modal");
    colarray_pul['colpages'] = { 
        header_title: "",
        edit: [imgPages],
        disp: [imgPages],
        td_class: "tablerow tdpages",
        headertd_class: "hdpages"
    };
	
	var imgtodetail = document.createElement('img');
    imgtodetail.className = "imgtodetail";
	imgtodetail.style.height = '20px';
	imgtodetail.style.width = '20px';
    imgtodetail.src = "assets/images/imgtohead.png";
    imgtodetail.style.cursor = "pointer";
    imgtodetail.setAttribute("onclick","todetail_fnc(this)");
    colarray_pul['imgtodetail'] = {
        header_title: "",
        edit: [imgtodetail],
        disp: [imgtodetail],
        td_class: "tablerow tdimgtodetail",
        headertd_class : "hdimgtodetail"
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
    <?php if (! $isManagementPosition) { ?>
        imgDelete.style.display = "none";
    <?php } ?>
    colarray_pul['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };

	
	
	
/************Table 2 ***************/	
	
	
    var myjstbl_pul2;
    var tab_pul2 = document.createElement('table');
    tab_pul2.id="tableid_pul2";
    tab_pul2.className = "table table-bordered";

    var colarray_pul2 = [];
	
	var id_pul2 = document.createElement('span');
    colarray_pul2['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul2],
        disp: [id_pul2],
        td_class: "tablerow tdid",
        headertd_class : "tdclick tdid"
    };

//    var spnmodule = document.createElement('span');
//    spnmodule.className = 'spnmodule';
//    colarray_pul2['module'] = { 
//        header_title: "Module",
//        edit: [spnmodule],
//        disp: [spnmodule],
//        td_class: "tablerow tdmodule",
//        headertd_class : "tdclick tdmodule"
//    };
	
	var spnmodule = document.createElement('select');
    spnmodule.className = "spnmodule";
    //spnmodule.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    spnmodule.innerHTML = '<select class="custommodule"><option value="Data">Data</option><option value="Purchases">Purchases</option><option value="Sales">Sales</option><option value="Stock Transfer">Stock Transfer</option><option value="Reports">Reports</option><option value="Others">Others</option><option value="Web: Data Collector">Web: Data Collector</option><option value="Retail POS">Retail POS</option><option value="Resto POS">Resto POS</option><option value="Auto Sync">Auto Sync</option><option value="Barcode Printer">Barcode Printer</option><option value="New Web">New Web</option><option value="Printout">Printout</option></select>';
    var selmodule_disp = spnmodule.cloneNode(true);
    selmodule_disp.disabled = "disabled";
    selmodule_disp.innerHTML = '<select class="custommodule"><option value="Data">Data</option><option value="Purchases">Purchases</option><option value="Sales">Sales</option><option value="Stock Transfer">Stock Transfer</option><option value="Reports">Reports</option><option value="Others">Others</option><option value="Web: Data Collector">Web: Data Collector</option><option value="Retail POS">Retail POS</option><option value="Resto POS">Resto POS</option><option value="Auto Sync">Auto Sync</option><option value="Barcode Printer">Barcode Printer</option><option value="New Web">New Web</option><option value="Printout">Printout</option></select>';
    colarray_pul2['module'] = { 
        header_title: "Module", 
        edit: [spnmodule], 
        disp: [selmodule_disp], 
        td_class: "tablerow tdmodule"
    };

	
//    var spntype = document.createElement('span');
//    var txttype = document.createElement('input');
//    txttype.type = "text";
//    txttype.id = 'idtxttype';
//    txttype.className = 'txttype';
//    colarray_pul2['type'] = { 
//        header_title: "Type",
//        edit: [txttype],
//        disp: [spntype],
//        td_class: "tablerow tdtype",
//        headertd_class : "tdclick tdtype"
//    };
	
	var txttype = document.createElement('select');
    txttype.className = "txttype";
    //spnmodule.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    txttype.innerHTML = '<select class="customtype"><option value="New Feature">New Feature</option><option value="Feature Modification">Feature Modification</option><option value="Feature Removal">Feature Removal</option><option value="Hotfix">Hotfix</option></select>';
    var seltype_disp = txttype.cloneNode(true);
    seltype_disp.disabled = "disabled";
    seltype_disp.innerHTML = '<select class="customtype"><option value="New Feature">New Feature</option><option value="Feature Modification">Feature Modification</option><option value="Feature Removal">Feature Removal</option><option value="Hotfix">Hotfix</option></select>';
    colarray_pul2['type'] = { 
        header_title: "Type", 
        edit: [txttype], 
        disp: [seltype_disp], 
        td_class: "tablerow tdtype"
    };
	

    var spnmantis = document.createElement('span');
	var txtmantis = document.createElement('input');
	txtmantis.setAttribute("onkeypress","data_val_num(event);");
	txtmantis.type = "text";
    txtmantis.id = 'idtxtmantis';
    txtmantis.className = 'txtmantis';
    colarray_pul2['mantis'] = { 
        header_title: "Mantis ID",
        edit: [txtmantis],
        disp: [spnmantis],
        td_class: "tablerow tdmantis",
		headertd_class : "tdclick mantis"
    };
	
	
	var devassigned = document.createElement('select');
    devassigned.className = "devassigned";
    devassigned.innerHTML = '<?php echo fill_select_options("SELECT id, username FROM bugtracker.mantis_user_table  WHERE email NOT LIKE '%easyshop%' AND enabled = 1 AND type != 'TECH' AND username != 'nelsoftadministrator' ORDER BY username;", "id", "username",0,false); ?>';
    var devassigned_disp = devassigned.cloneNode(true);
    devassigned_disp.disabled = "disabled";
    colarray_pul2['devassigned'] = { 
        header_title: "Dev Assigned", 
        edit: [devassigned], 
        disp: [devassigned_disp], 
        td_class: "tablerow tddevassigned"
    };
	
	
	var spnparticulars = document.createElement('span');
	spnparticulars.className = "spnParticulars";
	var txtparticulars = document.createElement('textarea');
	txtparticulars.type = "text";
    txtparticulars.id = 'idtxtparticulars';
	txtparticulars.setAttribute('cols',25);
	txtparticulars.setAttribute('rows', 2);
    txtparticulars.className = 'txtparticulars';
    colarray_pul2['particulars'] = { 
        header_title: "Particulars",
        edit: [txtparticulars],
        disp: [spnparticulars],
        td_class: "tablerow tdparticulars",
		headertd_class : "tdclick particulars"
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
        td_class: " tablerow tdupdate2",
		headertd_class : "hdupdate2"
    };
	
//Table 3 Popup
    var myjstbl_pul3;
    var tab_pul3 = document.createElement('table');
    tab_pul3.id="tableid_pul3";
    tab_pul3.className = "table table-bordered";

    var colarray_pul3 = [];
	
	var id_pul3 = document.createElement('span');
    colarray_pul3['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul3],
        disp: [id_pul3],
        td_class: "tablerow tdid",
        headertd_class : "tdclick tdid"
    };

	
	var fileicon = document.createElement('img');
    fileicon.className = "fileicon";
    fileicon.src = "assets/images/SuppDocs.png";
    fileicon.setAttribute("class","btn btn-info btn-lg");
    fileicon.setAttribute("id","fileicon");
	fileicon.style.height = '30px';
	fileicon.style.width = '30px';
	fileicon.style.cursor = "pointer";
    fileicon.src = "assets/images/SuppDocs.png";
    fileicon.style.cursor = "pointer";
    fileicon.setAttribute("onclick","download_file(this)");
    colarray_pul3['fileicon'] = {
        header_title: "",
        edit: [fileicon],
        disp: [fileicon],
        td_class: "tablerow tdimgtodetail",
        headertd_class : "hdimgtodetail"
    };
	

	
    var spndisfilename = document.createElement('span');
    var txtdisfilename = document.createElement('input');
	txtdisfilename.setAttribute("onkeypress","enter_update(event, this);");
    txtdisfilename.type = "text";
    txtdisfilename.id = 'txtdisfilename';
    txtdisfilename.className = 'txtdisfilename';
    colarray_pul3['disfilename'] = { 
        header_title: "Filename",
        edit: [txtdisfilename],
        disp: [spndisfilename],
        td_class: "tablerow tddisfilename",
        headertd_class : "hddisfilename tdclick"
    };
	
	
    var dateupload = document.createElement('span');
    dateupload.className = 'dateupload';
    colarray_pul3['dateupload'] = { 
        header_title: "Date Uploaded",
        edit: [dateupload],
        disp: [dateupload],
        td_class: "tablerow tddateupload",
        headertd_class : "tdclick tddateupload"
    };

	
	var imgUpdate3 = document.createElement('img');
        imgUpdate3.src = "assets/images/iconupdate.png";
        imgUpdate3.setAttribute("onclick","pul_update_fnc3(this)");
        imgUpdate3.style.cursor = "pointer";
    var imgEdit3 = document.createElement('img');
        imgEdit3.src = "assets/images/iconedit.png";
        imgEdit3.setAttribute("onclick"," editSelectedRow(myjstbl_pul3, this);");
        imgEdit3.id = "edit_pul3";
		imgEdit3.className = "edit_pul3";
		imgEdit3.style.cursor = "pointer";
        imgEdit3.style.display = "none";
        imgEdit3.style.display = "block";
    colarray_pul3['colupdate3'] = { 
        header_title: "",
        edit: [imgUpdate3],
        disp: [imgEdit3],
        td_class: " tablerow tdupdate3",
		headertd_class : "hdupdate3"
    };
	

	
    var filename = document.createElement('span');
    filename.className = 'filename';
	filename.style = "display:none";
    colarray_pul3['filename'] = { 
        header_title: "",
        edit: [filename],
        disp: [filename],
        td_class: "tablerow tdfilename",
        headertd_class : "tdclick tdfilename"
    };
	
	//delete
	var imgDelete3 = document.createElement('img');
    imgDelete3.src = "assets/images/icondelete.png";
    imgDelete3.setAttribute("class","imgdel3");
    imgDelete3.setAttribute("id","imgDelete3");
    colarray_pul3['coldelete'] = { 
        header_title: "",
        edit: [imgDelete3],
        disp: [imgDelete3],
        td_class: "tablerow tddelete2",
        headertd_class: "hddelete2"
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
            iscursorchange_when_hover: false
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

	
	

	//Table 3
	var arr = [];
	var headid = "";
    $(function() {
        // P.U.L3
        myjstbl_pul3 = new my_table(tab_pul3, colarray_pul3, {ispaging : false,
                                                iscursorchange_when_hover : false});

        var root_pul3 = document.getElementById("tbl_pul3");
        root_pul3.appendChild(myjstbl_pul3.tab);

		
        
		$('#tbl_pul').on("click","#tableid_pul tr", function(){
			$(this).find('input:radio').prop('checked', true);
			var chkbox= $(this).find('input:radio').html();
			//alert(chkbox);
			radioButtonText = $('input[name=radio1].chkselect:checked');
			var label_value = radioButtonText.closest('tr').find('span').html();
			
			
			
		myjstbl_pul3.clean_table();
//	var headid_val= $("#headid").text();
//		//$('#lblStatus').css('visibility', 'hidden');
//		$.getJSON("<?=base_url()?>clienthead/pul_refresh3",
//        { 
//            clienthead : headid_val
//        },
//        function(data) { 
//		//alert(data);
//			
//            myjstbl_pul3.insert_multiplerow_with_value(1,data);	
//
//		});

			
		//alert(label_value);
			        
			//console.log("click test");
		});
		
        $(".txteacpassword").live("keydown", function(e) {
            if (e.keyCode == 13) {
                pul_update_fnc(this);
            }
        });

		$("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
		$("#message").empty();
		$('#loading').show();
		$.ajax({
			
		url: "clienthead/file_upload", // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
		
			var headid_val= $("#headid").text();
        	fnc_pul = "<?=base_url()?>clienthead/insert_control3";
			
			$.getJSON(fnc_pul,
			{
			headid: headid_val,
			fileext: data
			},
			function(data) {
			//alert(data);
			
				if(data == "error"){
					$('#lblStatus').css('visibility', 'visible'); 
					$('#lblStatus').text("Insufficient Balance!");
				}
				else{
					$('#file').val(''); 
					$('#previewing').hide();
					$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
		
				var cnt = myjstbl_pul3.get_row_count();
				myjstbl_pul3.add_new_row();
				myjstbl_pul3.update_row_with_value(cnt,data);
				}
                updateLogScreen();
			});			
		$('#loading').hide();
		$("#message").html(data);
		}
		});
		
//		myjstbl_pul3.clean_table();
		
//		var headid_val= $("#headid").text();
			//$('#lblStatus').css('visibility', 'hidden');
//			$.getJSON("<?=base_url()?>clienthead/pul_refresh3",
//		      { 
//		          clienthead : headid_val
//		      },
//		      function(data) { 
//			//alert(data);
//					
//		          myjstbl_pul3.insert_multiplerow_with_value(1,data);
//		
//			});
		
		
		}));
			

			// Function to preview image after validation
		$(function() {
		$("#file").change(function() {
			$('#previewing').show();
		$("#message").empty(); // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
		$('#previewing').attr('src','noimage.png');
		$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
		return false;
		}
		else
		{
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
		}
		});
		});
		function imageIsLoaded(e) {
		$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '150px');
		$('#previewing').attr('height', '130px');
		};

		
		
	});
	
	

	//Table 2
	var arr = [];
	var headid = "";
    $(function() {
        // P.U.L2
        myjstbl_pul2 = new my_table(tab_pul2, colarray_pul2, {ispaging : true,
                                                iscursorchange_when_hover : true});

        var root_pul2 = document.getElementById("tbl_pul2");
        root_pul2.appendChild(myjstbl_pul2.tab);
        root_pul2.appendChild(myjstbl_pul2.mypage.pagingtable);
		//pul_refresh_table2();
        
        $('#tbl_pul').on("click", "#tableid_pul tr", function() {
            $(this).find('input:radio').prop('checked', true);
            radioButtonText = $('input[name=radio1].chkselect:checked');
            var groupId = radioButtonText.closest('tr').find('span').html();
            var headName = radioButtonText.closest('tr').children('td.tdname').text();
            $('#currHead').text(headName);

            if (groupId.trim().length > 0) {
                myjstbl_pul2.clean_table();
                $.getJSON("<?=base_url()?>clienthead/pul_refresh2", {
                    clienthead : groupId
                },
                function(data) {
                    set_tbl_element_events();
                    myjstbl_pul2.insert_multiplerow_with_value(1, data);
                    myjstbl_pul2.add_new_row();
                });
            }
        });

  //    $("#createnew").click(function(){
  //        myjstbl_pul.mypage.go_to_last_page(); 
  //        $(".txtname").last().focus();
  //    });
	//	
	//	$("#ddlsubscription").chosen({allow_single_deselect:true, 
  //        no_results_text: "Not found",
  //        add_item_enable: false});
	//	$('.chzn-search').hide();
	//	
	//	$("#filterclientgroup").chosen({allow_single_deselect:true, 
	//		no_results_text: "Not found",
	//		add_item_enable: false});
	//	

	});
	
	
	
	/************Table 1 *********/
	var arr = [];
	var headid = "";
    $(function() {
        // P.U.L
        myjstbl_pul = new my_table(tab_pul, colarray_pul, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow",
                                                tdpopup_when_hover : "tdpopuphover",
                                                iscursorchange_when_hover : true});

        var root_pul = document.getElementById("tbl_pul");
        root_pul.appendChild(myjstbl_pul.tab);
        root_pul.appendChild(myjstbl_pul.mypage.pagingtable);
		
        $('#btnupload').live('click',function()   {   upload_file();  });
        $("#filterclientgroup").val(<?=$clientgroupid?>);

        <?php
            if (isset($_GET["clientgroupid"])) {
                echo "pul_refresh_table();";
            } else {
                echo "showInitialPageLoadDisplay(myjstbl_pul);";
            }
        ?>

		$("#txtsearch").keypress( 
		function(e){
			if(e.keyCode == 13)
			{
				pul_refresh_table();
			}
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

        $('#delete-notes').live('click', function()
        {
            $("#label-status-notes").css('visibility', 'hidden');
            var rowIndexNotes = $(this).parent().parent().index();
            var idValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
                rowIndexNotes,
                columnArrayNotes['columnId'].td_class
            )[0];
            var idHiddenValue = myJsTableNotes.getvalue_by_rowindex_tdclass(
                rowIndexNotes,
                columnArrayNotes['columnHiddenId'].td_class
            )[0];
            var clientHeadId = myjstbl_pul.getvalue_by_rowindex_tdclass(
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
                    url: "<?=base_url()?>clienthead/deleteClientNotes",
                    data: {
                        id: idValue,
                        hiddenId: idHiddenValue,
                        clientId: clientHeadId,
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


        $("#button-search").click(function(){
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
		
		$("#ddlsubscription").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
		$('.chzn-search').hide();
		
		$("#filterclientgroup").chosen({allow_single_deselect:true, 
			no_results_text: "Not found",
			add_item_enable: false});
		

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

					$(".basicwh").attr("checked","checked");
					break;

				case 1:

					$(".pos").removeAttr("checked");
					$(".basicwh").removeAttr("checked");
					$(".advanced").removeAttr("checked");
					$(".premium").removeAttr("checked");

					$(".basicst").attr("checked","checked");
					break;

				case 2:

					$(".basicwh").removeAttr("checked");
					$(".basicst").removeAttr("checked");
					$(".advanced").removeAttr("checked");
					$(".premium").removeAttr("checked");

					$(".pos").attr("checked","checked");
					break;

				case 3:

					$(".pos").removeAttr("checked");
					$(".basicwh").removeAttr("checked");
					$(".basicst").removeAttr("checked");
					$(".premium").removeAttr("checked");

					$(".advanced").attr("checked","checked");
					break;

				case 4:

					$(".pos").removeAttr("checked");
					$(".basicwh").removeAttr("checked");
					$(".basicst").removeAttr("checked");
					$(".advanced").removeAttr("checked");

					$(".premium").attr("checked","checked");
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
                    myjstbl_pul.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                        myjstbl_pul.get_row_count() - 1,
                        colarray_pul['columnImageNotes'].td_class
                    );
				}
			});
			
		});
		
		$('#tbl_pul').on("click","#tableid_pul tr", function(){
			$(this).find('input:radio').prop('checked', true);
			var chkbox= $(this).find('input:radio').html();
			//alert(chkbox);
			radioButtonText = $('input[name=radio1].chkselect:checked');
			var label_value = radioButtonText.closest('tr').find('span').html();
		//	alert(label_value);
			
			//console.log("click test");
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
		
		uncheck_all();
		
		/******************************** END ********************************/

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
			if (($('.edit_pul').attr("onClick") == undefined) && ( count !=2 )) {
                $('#lblStatus').css('visibility', 'visible');
                $('#lblStatus').text("Save the other data first!");
			}
		});

    function todetail_fnc(rowObj) { 

        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
        var clientgroup_id = values_arr[colarray_pul['clientgroup_id'].td_class][0];
       
        window.open("clientdetails?clientheadid=" + id_val + "&clientgroupid=" + clientgroup_id);
            
    }
	
	function enter_update(e, x)
    {
        if(e.keyCode == 13)
        {
           //update_fnc(x);
			pul_update_fnc3(x)
			//alert("test");
            e.preventDefault();
						
        }
        
    }
	
	function download_file(rowObj) { 

        var cnt = myjstbl_pul3.get_row_count();
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul3.get_row_values(row_index);
        var filename = values_arr[colarray_pul3['filename'].td_class][0];
       window.open('assets/upload/'+filename,'_blank');
        //window.open("assets/upload/"+filename+".jpg");
            
    }

    function editSelectedRow( myTable, rowObj){
        if (updaterecord_flag != 0) {
            return;
        }
        var rowindex = $(rowObj).parent().parent().index();
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');
        set_tbl_element_events();

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
	
	
    function upload_file( myTable, rowObj){
        var rowindex = $(rowObj).parent().parent().index();
		alert(rowindex)
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');
        set_tbl_element_events();
    }

	function set_tbl_element_events() {
		my_autocomplete_add(".txtclientgroup_name", "<?=base_url()?>clienthead/ac_clientgroupid", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl_pul.setvalue_to_rowindex_tdclass(["0"],row_index,colarray_pul['clientgroup_id'].td_class);
                    myjstbl_pul.setvalue_to_rowindex_tdclass([""],row_index,colarray_pul['clientgroup_name'].td_class);
                }
                else {
                    myjstbl_pul.setvalue_to_rowindex_tdclass([value],row_index,colarray_pul['clientgroup_id'].td_class);
                    myjstbl_pul.setvalue_to_rowindex_tdclass([label],row_index,colarray_pul['clientgroup_name'].td_class);	
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                    { width : ["120px","200px"] });
            }
            });  
	}
	
	//UPDATE and INSERT new row on PUL TABLE
    function pul_update_fnc(rowObj)
    {
		//alert(m);
		// alert (arr[0][0]);
        if(updaterecord_flag != 0) return;
        updaterecord_flag = 1;

		$('#lblStatus').css('visibility', 'hidden');
		var cnt                 = myjstbl_pul.get_row_count() - 1;
        var row_index           = $(rowObj).parent().parent().index();
        var row_index_val       = row_index;
        var values_arr          = myjstbl_pul.get_row_values(row_index);
        var id_val              = values_arr[colarray_pul['id_pul'].td_class][0];
        var clientgroupid_val   = values_arr[colarray_pul['clientgroup_id'].td_class][0];
        var name_val            = values_arr[colarray_pul['name'].td_class][0];
        var devassigned_val     = values_arr[colarray_pul['devassigned'].td_class][0];
        //var techassigned_val= values_arr[colarray_pul['techassigned'].td_class][0];
        var ownerValue          = values_arr[colarray_pul['owner'].td_class][0];
        var email_val           = values_arr[colarray_pul['email'].td_class][0];
        var password_val        = values_arr[colarray_pul['password'].td_class][0];
        // Dropboxdate_val= values_arr[colarray_pul['startdate'].td_class][0];
        var registeredname_val  = values_arr[colarray_pul['BusinessName'].td_class][0];
        var businessname_val    = values_arr[colarray_pul['BusinessName'].td_class][0];
        var eacusername_val     = values_arr[colarray_pul['eacusername'].td_class][0];
        var eacpassword_val     = values_arr[colarray_pul['eacpassword'].td_class][0];
        var colsoftwaretype_val = values_arr[colarray_pul['colsoftwaretype'].td_class][0];
	
      
   //     if(Dropboxdate_val.length > 0){
   //         if ( Number(Dropboxdate_val.split('-')[2]) > 1 ) {
   //             alert("date should always be the first day of next month");
   //             return;
   //         } 
   //     }

		var fnc_pul = "<?=base_url()?>clienthead/update_control";
        if (id_val == "")
        	fnc_pul = "<?=base_url()?>clienthead/insert_control";

		$.ajax({
            type: "POST",
            url: fnc_pul,
            async: true,
            dataType: 'json',
            data: {
                id: id_val,
                clientgroupid: clientgroupid_val,
                name: name_val,
                devassigned: devassigned_val,
                //techassigned: techassigned_val,
                owner: ownerValue,
                email: email_val,
                password: password_val,
                registeredname: registeredname_val,
                businessname: businessname_val,
                eacusername: eacusername_val,
                eacpassword: eacpassword_val,
                //Dropboxdate: Dropboxdate_val
                softwaretype : colsoftwaretype_val
            },
            success: function(data) {
                //alert(data);
                if (data.errorMessage != "") {
                    alert(data.errorMessage);
                    updaterecord_flag = 0;
                    return;
                }
                if(data == "error"){
                    $('#lblStatus').css('visibility', 'visible'); 
                    $('#lblStatus').text("Insufficient Balance!");
                }
                else{
                    if(id_val=="")
                        myjstbl_pul.add_new_row();
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['coldelete'].td_class
                        )[0].style.display = "none";
                        set_tbl_element_events();
                        myjstbl_pul.update_row_with_value(row_index,data);
                        myjstbl_pul.setvalue_to_rowindex_tdclass(
                            ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['columnImageNotes'].td_class
                        );
                        
                }
                updaterecord_flag = 0;
                updateLogScreen();
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
		var clienthead = radioButtonText.closest('tr').find('span').html();
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
		// alert(row_index_val+"up");
        var values_arr = myjstbl_pul2.get_row_values(row_index);
        var id_val = values_arr[colarray_pul2['id_pul'].td_class][0];
        var module_val= values_arr[colarray_pul2['module'].td_class][0];
        var type_val = values_arr[colarray_pul2['type'].td_class][0];
        var mantisid_val= values_arr[colarray_pul2['mantis'].td_class][0];
		var devassigned_val= values_arr[colarray_pul2['devassigned'].td_class][0];
        var particulars_val= values_arr[colarray_pul2['particulars'].td_class][0];
		
		if(mantisid_val==''){
			alert("Mantis ID is required");
            updaterecord_flag = 0;
            return;
		}

		var fnc_pul = "<?=base_url()?>clienthead/update_control2";
        if (id_val == "")
        	fnc_pul = "<?=base_url()?>clienthead/insert_control2";

		$.ajax({
            type: "POST",
            url: fnc_pul,
            async: true,
            dataType: 'json',
            data: {
    			id:id_val,
    			clienthead: clienthead,
    			module: module_val,
    			type: type_val,
    			mantisid: mantisid_val,
    			devassigned: devassigned_val,
                particulars: particulars_val
			},
			success: function(data) {
			//alert(data);
				if(data == "error"){
					$('#lblStatus').css('visibility', 'visible'); 
					$('#lblStatus').text("Insufficient Balance!");
				}
				else{

					if(id_val=="")
						myjstbl_pul2.add_new_row();
						set_tbl_element_events();
						myjstbl_pul2.update_row_with_value(row_index,data);
				}
                updaterecord_flag = 0;
                updateLogScreen();
            }
        });				
			//alert(clienthead);
	}	
	
	function data_val_num(e)
	{
			if (e.which != 9 && e.which != 8 && e.which != 46 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				e.preventDefault();
				return false;
		}	
	}
	
	//UPDATE and INSERT new row on PUL TABLE3
	function pul_update_fnc3(rowObj) { 
		//alert(m);
		// alert (arr[0][0]);
        if(updaterecord_flag != 0) return;
        updaterecord_flag = 1;

		$('#lblStatus').css('visibility', 'hidden');
		var cnt = myjstbl_pul3.get_row_count();

        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
		// alert(row_index_val+"up");
        var values_arr = myjstbl_pul3.get_row_values(row_index);
        var id_val = values_arr[colarray_pul3['id_pul'].td_class][0];
        var disfilename = values_arr[colarray_pul3['disfilename'].td_class][0];

		var fnc_pul = "<?=base_url()?>clienthead/update_control3";


		$.ajax({
            type: "POST",
            url: fnc_pul,
            async: true,
            dataType: 'json',
            data: {
    			id:id_val,
    			disfilename: disfilename,
			},
			success: function(data) {
			//alert(data);
				if(data == "error"){
					$('#lblStatus').css('visibility', 'visible'); 
					$('#lblStatus').text("Insufficient Balance!");
				}
				else{
			         myjstbl_pul3.update_row_with_value(row_index,data);		
				}
                updaterecord_flag = 0;
                updateLogScreen();
            }
        });				
			//alert(clienthead);
	}	
	
	
	
	
	
	
	//Delete Function For PUL Table
	$('.imgdel').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
       var hasBranchRemaining = false;

        $.ajax(
        {
            url: "<?=base_url()?>clienthead/countBranch",
            dataType: "json",
            type: "POST",
            data: {
                id: id_val
            },
            async: false,
            success: function(data)
            {
                hasBranchRemaining = data[0] > 0;
            }
        });

        if (hasBranchRemaining) {
            alert("Network can only be deleted if no branch exists");
            return;
        }
		
		var answer = confirm("Are you sure you want to delete?");
		if(answer==true){
			$.get("<?=base_url()?>clienthead/delete_control",
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

                updateLogScreen();
			});
		}
	});
	
	
	//Delete Function For PUL Table2
	$('.imgdel2').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul2.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul2.getvalue_by_rowindex_tdclass(row_index, colarray_pul2['id_pul'].td_class)[0];
		
		var answer = confirm("Are you sure you want to delete?");
		if(answer==true){
			myjstbl_pul2.delete_row(row_index);
			$.get("<?=base_url()?>clienthead/delete_control2",
			{id: id_val},
			function(data){
				$('#lblStatus').css('visibility', 'visible'); 
				myjstbl_pul2.delete_row(row_index);
				$('#lblStatus').text("Removed!");
                myjstbl_pul2.add_new_row();
			});
		}
	});
	
	
	
	//Delete Function For PUL Table3
	$('.imgdel3').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul3.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul3.getvalue_by_rowindex_tdclass(row_index, colarray_pul3['id_pul'].td_class)[0];
		
		var answer = confirm("Are you sure you want to delete?");
		if(answer==true){
			myjstbl_pul3.delete_row(row_index);
			$.get("<?=base_url()?>clienthead/delete_control3",
			{id: id_val},
			function(data){
				$('#lblStatus').css('visibility', 'visible'); 
				myjstbl_pul3.delete_row(row_index);
				$('#lblStatus').text("Removed!");
                myjstbl_pul3.add_new_row();
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
            url: "<?=base_url()?>clienthead/displayClientNotes",
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
            }
        });
    }

    function addClientNotes(notes)
    {
        var rowIndex = $(notes).parents("tr").index();
        var clientHeadId = myjstbl_pul.getvalue_by_rowindex_tdclass(
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
        var clientHeadId = myjstbl_pul.getvalue_by_rowindex_tdclass(
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
            url: "<?=base_url()?>clienthead/saveClientNotes",
            data: {
                hiddenId: idHiddenValue,
                id: idValue,
                clientId: clientHeadId,
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
                updaterecord_flag = 1;
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

	function pul_refresh_table() {
	  myjstbl_pul.clean_table();
      var search_val = $.trim($('#txtsearch').val());

	  $('#lblStatus').css('visibility', 'hidden');
        $.getJSON("<?=base_url()?>clienthead/pul_refresh",
            { 
                search: search_val,
                clientgroupid : $("#filterclientgroup").val()
            },
            function(data) { 
				myjstbl_pul.add_new_row();
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['coldelete'].td_class
                )[0].style.display = "none";
				set_tbl_element_events();
                myjstbl_pul.insert_multiplerow_with_value(1,data);
                isFirstLoad = false;
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageNotes'].td_class
                );
			});
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
	
	function set_pages(rowObj) {
	
		uncheck_all();
		
		var row_index = $(rowObj).parent().parent().index();
		headid = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
		
		var fnc = "<?=base_url()?>clienthead/get_settings";
		
		$.getJSON(fnc,
		{
			id: headid
		},
		function(data) {
		
			if(data == "error"){}
			else {
			
				$("#ddlsubscription").val(data.subscription);
				$("#ddlsubscription").trigger("liszt:updated");
				
				for(var i=0; i < data.pages.length; i++){
					$("input[name='"+data.pages[i]+"']").attr("checked","checked");
				}
			}
			
			refresh_main_checkbox();
		});
		
	}
	
	
	
	

	function upload_page(rowObj) {
		myjstbl_pul3.clean_table();
		$('#file').val('');
		$('#previewing').hide();
		var row_index = $(rowObj).parent().parent().index();
		headid = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
		$('#headid').text(headid);
		
		var headid_val= $("#headid").text();
			//$('#lblStatus').css('visibility', 'hidden');
			$.getJSON("<?=base_url()?>clienthead/pul_refresh3",
            { 
                clienthead : headid_val
            },
            function(data) { 
			//alert(data);
				
                myjstbl_pul3.insert_multiplerow_with_value(1,data);	

			});

	}
	

	
	function uncheck_all(){
		
		var cbox = document.getElementsByTagName('input');
		for(var i=0; i < cbox.length; i++){
			if(cbox[i].type == 'checkbox'){
				cbox[i].checked = false;
			}
		}
	}
	

	
</script>