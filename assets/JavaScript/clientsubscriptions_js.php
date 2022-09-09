<script language="javascript" type="text/javascript">
	
	//TABLE SUBSCRIPTIONS
    var myjstblsubscriptions;
    var tabsubscriptions = document.createElement('table');
    tabsubscriptions.id="tableid2";
    var colarraysubscriptions = [];
    var parameterssubscriptions = [];
	var txtparameterssubscriptions = [];
    var colarrayparamssubscriptions=["ID","Name", "Warranty Months", "Costing Per Year"];
    for (var x=0; x<4; x++)
    {
        parameterssubscriptions[x] = document.createElement('span');
		txtparameterssubscriptions[x] = document.createElement('input');
		var edit_mode;
		edit_mode = parameterssubscriptions[x];
		if (x > 0)
			edit_mode = txtparameterssubscriptions[x];
        colarraysubscriptions[colarrayparamssubscriptions[x]] = { 
            header_title: colarrayparamssubscriptions[x],
            edit: [edit_mode],
            disp: [parameterssubscriptions[x]],
            td_class: "tablerow tdall "+"td"+colarrayparamssubscriptions[x],
            headertd_class : "tdall"
        };
    }
	
	// TERMS TABLE
	var myjstbl;
    var tab = document.createElement('table');
    tab.id = "tableid";
    tab.className = "table";
	
	var colarray = [];
	
	var mainid = document.createElement('span');
    mainid.className = "spnmainid";
    colarray['mainid'] = { 
        header_title: "ID",
        edit: [mainid],
        disp: [mainid],
        td_class: "tablerow tdmainid",
        headertd_class : "tdclick tdmainid"
    };
	
	var subscriptionid = document.createElement('span');
    subscriptionid.className =  "spnsubscriptionid";
    colarray['subscriptionid'] = { 
        header_title: "Subscription ID",
        edit: [subscriptionid],
        disp: [subscriptionid],
        td_class: "tablerow tdsubscriptionid",
        headertd_class : "tdclick tdsubscriptionid"
    };
	
	var txtname = document.createElement('input');
    txtname.className = "txtsubname";
    txtname.type = "text";
    txtname.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var subscriptionname = document.createElement('span');
    subscriptionname.className =  "spnsubscriptionname";
    colarray['subscriptionname'] = { 
        header_title: "Subscription",
        edit: [txtname],
        disp: [subscriptionname],
        td_class: "tablerow tdsubname",
        headertd_class : "tdclick tdsubname"
    };
	
	var txtmainname = document.createElement('input');
    txtmainname.className = "txttermsname";
    txtmainname.type = "text";
    txtmainname.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var mainname = document.createElement('span');
	mainname.className = "spnmainname";
	colarray['mainname'] = {
		header_title: "Name",
		edit: [txtmainname],
		disp: [mainname],
		td_class: "tablerow tdtermsname",
		headertd_class : "tdclick tdtermsname"
	};
	
	var typeid = document.createElement('span');
	typeid.className = "spntypeid";
	colarray['typeid'] = {
		header_title: "TypeID",
		edit: [typeid],
		disp: [typeid],
		td_class: "tablerow tdtypeid",
		headertd_class : "tdclick tdtypeid"
	};
	
	var connecttype = document.createElement('span');
	connecttype.className = "spnconnecttype";
	colarray['connecttype'] = {
		header_title: "Type",
		edit: [connecttype],
		disp: [connecttype],
		td_class: "tablerow tdconnecttype",
		headertd_class : "tdclick tdconnecttype"
	};
	
	
	// SUBSCRIPTION TYPE TABLE
	var myjstbl4;
    var tab4 = document.createElement('table');
    tab4.id = "tableid6";
    tab4.className = "table";

    var colarray4 = [];
	
	var mainid4 = document.createElement('span');
    mainid4.className = "spnmainid";
	mainid4.style = "display:none";
    colarray4['mainid'] = { 
        header_title: "",
        edit: [mainid4],
        disp: [mainid4],
        td_class: "tablerow tdmainid4",
        headertd_class : "tdclick tdmainid4"
    };
	
	var clientBranch = document.createElement('select');
    clientBranch.className = "clientBranch";
    clientBranch.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    clientBranch.innerHTML = '<?php
        fill_select_options_multi(
            "SELECT
                D.`id`,
                D.`clientid`,
                D.`branchname`,
                H.`Name`
            FROM `clientdetails` AS D
            LEFT JOIN `clienthead` AS H ON D.`clientid` = H.`id`
            WHERE D.`show` = 1
            ORDER BY H.`Name` ASC",
            "id",
            "Name",
            "branchname",
            0,
            false);
    ?>';
																	
    var clientBranch_disp = clientBranch.cloneNode(true);
    clientBranch_disp.disabled = "disabled";
    colarray4['clientBranch'] = { 
        header_title: "Branch Maintenance", 
        edit: [clientBranch], 
        disp: [clientBranch_disp], 
        td_class: "tablerow tdclientBranch"
    };
	
	
	var posType = document.createElement('select');
    posType.className = "posType";
    posType.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    posType.innerHTML = '<?php fill_select_options("SELECT T.id, T.name FROM nelsoft_clients.clientterminaldetails AS T 
		WHERE T.name != '' 
		ORDER BY T.name ASC", "id", "name",0,false); ?>';
																	
    var posType_disp = posType.cloneNode(true);
    posType.disabled = "disabled";
    colarray4['posType'] = { 
        header_title: "Type", 
        edit: [posType_disp], 
        disp: [posType], 
        td_class: "tablerow tdposType"
    };
	

	
//	var posType = document.createElement('input');
//    posType.className = "posType";
//    posType.type = "text";
//    posType.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
//	posType.setAttribute("onFocus", "POS_Select(this);");
//	var spnposType = document.createElement('span');
//    spnposType.className =  "spnposType";
//    colarray4['posType'] = { 
//        header_title: "POS Type",
//        edit: [posType],
//        disp: [spnposType],
//        td_class: "tablerow tdposType",
//        headertd_class : "tdclick tdposType"
//    };
	
	var subType = document.createElement('select');
    subType.className = "subType";
    subType.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    subType.innerHTML = '<?php echo fill_select_options("SELECT `id`, `name`
																FROM `nelsoft_clients`.`subscriptions` WHERE name != 'Customizations'
																ORDER BY `name`", "id", "name",0,false); ?>';
																	
    var subType_disp = subType.cloneNode(true);
    subType_disp.disabled = "disabled";
    colarray4['subType'] = { 
        header_title: "Subscription Type", 
        edit: [subType], 
        disp: [subType_disp], 
        td_class: "tablerow tdsubType"
    };
	
	
	var subDropbox = document.createElement('input');
    subDropbox.className = "subDropbox";
    subDropbox.type = "text";
    subDropbox.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var spnsubDropbox = document.createElement('span');
    spnsubDropbox.className =  "spnsubDropbox";
    colarray4['subDropbox'] = { 
        header_title: "Dropbox",
        edit: [subDropbox],
        disp: [spnsubDropbox],
        td_class: "tablerow tdsubDropbox",
        headertd_class : "tdclick tdsubDropbox"
    };
	

	var subFrom = document.createElement('input');
	subFrom.type = "text";
    subFrom.className = 'subFrom';
    subFrom.id = 'subFrom';
	var spnsubFrom = document.createElement('span');
	spnsubFrom.className = "spnsubFrom";
	colarray4['subFrom'] = {
		header_title: "Date From",
		edit: [subFrom],
		disp: [spnsubFrom],
		td_class: "tablerow tdsubFrom",
		headertd_class : "tdclick tdsubFrom"
	};
	
	
	var subTo = document.createElement('input');
    subTo.className = "subTo";
    subTo.id = "subTo";
    subTo.type = "text";
    var spnsubTo = document.createElement('span');
    spnsubTo.className =  "spnsubTo";
    colarray4['subTo'] = { 
        header_title: "Date To",
        edit: [subTo],
        disp: [spnsubTo],
        td_class: "tablerow tdsubTo",
        headertd_class : "tdclick tdsubTo"
    };
	
	var subAmount = document.createElement('input');
    subAmount.className = "subAmount";
    subAmount.type = "text";
    subAmount.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var spnsubAmount = document.createElement('span');
    spnsubAmount.className =  "spnsubAmount";
    colarray4['subAmount'] = { 
        header_title: "Amount",
        edit: [subAmount],
        disp: [spnsubAmount],
        td_class: "tablerow tdsubAmount",
        headertd_class : "tdclick tdsubAmount"
    };
	
	var subRemarks = document.createElement('input');
    subRemarks.className = "subRemarks";
    subRemarks.type = "text";
    subRemarks.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var spnsubRemarks = document.createElement('span');
    spnsubRemarks.className =  "spnsubRemarks";
    colarray4['subRemarks'] = { 
        header_title: "Remarks",
        edit: [subRemarks],
        disp: [spnsubRemarks],
        td_class: "tablerow tdsubRemarks",
        headertd_class : "tdclick tdsubRemarks"
    };
	
	var DRNo = document.createElement('input');
    DRNo.className = "DRNo";
    DRNo.type = "text";
    DRNo.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var spnDRNo = document.createElement('span');
    spnDRNo.className =  "spnDRNo";
    colarray4['DRNo'] = { 
        header_title: "DR No",
        edit: [DRNo],
        disp: [spnDRNo],
        td_class: "tablerow tdDRNo",
        headertd_class : "tdclick tdDRNo"
    };
	
	
	var subStatus = document.createElement('input');
	subStatus.type = 'checkbox';
	subStatus.className = "subStatus";
	var subStatus_disp = subStatus.cloneNode(true);
    subStatus_disp.disabled = "disabled";
	colarray4['subStatus'] = { 
		header_title: "Send Notification?",
		edit: [subStatus],
		disp: [subStatus_disp],
		td_class: "tablerow tdsubStatus",
		headertd_class : "tdclick tdsubStatus"
	};
	
	
	
	var imgUpdate6 = document.createElement('img');
        imgUpdate6.src = "assets/images/iconupdate.png";
        imgUpdate6.setAttribute("onclick","update_fnc2(this)");
        imgUpdate6.style.cursor = "pointer";
		imgUpdate6.className = "update6";
    var imgEdit6 = document.createElement('img');
        imgEdit6.src = "assets/images/iconedit.png";
        imgEdit6.setAttribute("onclick"," editSelectedRow(myjstbl4, this);");
		//imgEdit6.setAttribute("onclick"," refresh_postype_ddl(this);");
		imgEdit6.className = "edit6";
		imgEdit6.style.cursor = "pointer";
        imgEdit6.style.display = "none";
        imgEdit6.style.display = "block";
        
    colarray4['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate6],
        disp: [imgEdit6],
        td_class: "tablerow tdupdate",
		headertd_class : "hdupdate"
    };
	
//	var imgDelete6 = document.createElement('img');
//    imgDelete6.src = "assets/images/icondelete.png";
//    imgDelete6.setAttribute("class","imgdel4");
//	imgDelete6.style.cursor = "pointer";
//    colarray4['coldelete'] = { 
//        header_title: "",
//        edit: [imgDelete6],
//        disp: [imgDelete6],
//        td_class: "tablerow tddelete",
//        headertd_class: "hddelete"
//    };
	
	/***************************************************************/
	var selclientgroup0 = document.createElement('select');
    selclientgroup0.className = "selclientgroup0";
    selclientgroup0.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selclientgroup0.innerHTML = '<?php echo fill_select_options("SELECT CG.`id`, CG.`name`
																FROM `clientgroup` AS CG
																ORDER BY `name`", "id", "name",0,false); ?>';
																	
    var selclientgroup0_disp = selclientgroup0.cloneNode(true);
    selclientgroup0_disp.disabled = "disabled";
	/***************************************************************/
	var selclienthead1 = document.createElement('select');
    selclienthead1.className = "selclienthead1";
    selclienthead1.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selclienthead1.innerHTML = '<?php echo fill_select_options("SELECT CH.`id`, CH.`name`
																FROM `clienthead` AS CH
																ORDER BY `name`", "id", "name",0,false); ?>';
																	
    var selclienthead1_disp = selclienthead1.cloneNode(true);
    selclienthead1_disp.disabled = "disabled";
	/***************************************************************/
	var selclientdetail2 = document.createElement('select');
    selclientdetail2.className = "selclientdetail2";
    selclientdetail2.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selclientdetail2.innerHTML = '<?php echo fill_select_options("SELECT CD.`id`, CONCAT(CH.`name`, ' ', COALESCE(CD.`branchid`,''),
																	' - ', COALESCE(CD.`branchname`,'')) as  `branchname`
																	FROM clienthead as CH
																	LEFT JOIN clientdetails as CD ON CH.`id`= CD.`clientid`
																	ORDER BY CH.`name`, CD.`branchid`", "id", "branchname",0,false); ?>';
																	
    var selclientdetail2_disp = selclientdetail2.cloneNode(true);
	selclientdetail2_disp.disabled = "disabled";
	/***************************************************************/
	var selclientterminal3 = document.createElement('select');
    selclientterminal3.className = "selclientterminal3";
    selclientterminal3.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selclientterminal3.innerHTML = '<?php echo fill_select_options("SELECT TD.`id`, CONCAT(CH.`name`, ' ', COALESCE(CD.`branchid`,''),
																		' - ', COALESCE(CD.`branchname`,''), ' - ',
																		COALESCE(TD.`name`,'')) as  `terminalname`
																		FROM clienthead as CH
																		LEFT JOIN clientdetails as CD ON CH.`id`= CD.`clientid`
																		LEFT JOIN clientterminaldetails AS TD ON TD.`clientbranchid` = CD.`id`
																		ORDER BY CH.`name`, CD.`branchid`, TD.`name`", "id", "terminalname",0,false); ?>';
																	
    var selclientterminal3_disp = selclientterminal3.cloneNode(true);
	selclientterminal3_disp.disabled = "disabled";
	/***************************************************************/
    colarray['selection'] = { 
        header_title: "", 
        edit: [selclientgroup0,selclienthead1,selclientdetail2,selclientterminal3], 
        disp: [selclientgroup0_disp,selclienthead1_disp,selclientdetail2_disp,selclientterminal3_disp], 
        td_class: "tablerow tdclientselection",
		headertd_class : "tdclick tdclientselection"
    };
	
	var used = document.createElement('span');
	used.className = "spnused";
	colarray['used'] = {
		header_title: "used",
		edit: [used],
		disp: [used],
		td_class: "tablerow tdused",
		headertd_class : "tdclick tdused"
	};
	
	var imgUpdate2 = document.createElement('img');
        imgUpdate2.src = "assets/images/iconupdate.png";
        imgUpdate2.setAttribute("onclick","update_fnc(this)");
        imgUpdate2.style.cursor = "pointer";
		imgUpdate2.className = "update";
    var imgEdit2 = document.createElement('img');
        imgEdit2.src = "assets/images/iconedit.png";
        imgEdit2.setAttribute("onclick"," editSelectedRow(myjstbl, this);");
		imgEdit2.className = "edit";
		imgEdit2.style.cursor = "pointer";
        imgEdit2.style.display = "none";
        imgEdit2.style.display = "block";
        
    colarray['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate2],
        disp: [imgEdit2],
        td_class: "tablerow tdupdate",
		headertd_class : "hdupdate"
    };
	
	var imgDelete = document.createElement('img');
    imgDelete.src = "assets/images/icondelete.png";
    imgDelete.setAttribute("class","imgdel3");
	imgDelete.style.cursor = "pointer";
    colarray['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };
	
	// PAYMENTS TABLE
	var myjstbl2;
    var tab2 = document.createElement('table');
    tab2.id = "tableid3";
    tab2.className = "table";

    var colarray2 = [];
	
	var mainid2 = document.createElement('span');
    mainid2.className = "spnmainid";
    colarray2['mainid'] = { 
        header_title: "ID",
        edit: [mainid2],
        disp: [mainid2],
        td_class: "tablerow tdmainid",
        headertd_class : "tdclick tdmainid"
    };
	
	var csid = document.createElement('span');
    csid.className = "spncsid";
    colarray2['csid'] = { 
        header_title: "CSID",
        edit: [csid],
        disp: [csid],
        td_class: "tablerow tdcsid",
        headertd_class : "tdclick tdcsid"
    };
	
	var txtname = document.createElement('input');
    txtname.className = "txtname";
    txtname.type = "text";
    txtname.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var subscriptionname2 = document.createElement('span');
    subscriptionname2.className =  "spnsubscriptionname2";
    colarray2['subscriptionname'] = { 
        header_title: "Client - Subscription Name",
        edit: [txtname],
        disp: [subscriptionname2],
        td_class: "tablerow tdsubscriptionname2",
        headertd_class : "tdclick tdsubscriptionname2"
    };
	
	var warrantymonths = document.createElement('span');
    warrantymonths.className =  "spnwarrantymonths";
    colarray2['warrantymonths'] = { 
        header_title: "warrantymonths",
        edit: [warrantymonths],
        disp: [warrantymonths],
        td_class: "tablerow tdwarrantymonths",
        headertd_class : "tdclick tdwarrantymonths"
    };
	
	var txtcostperyear = document.createElement('input');
	txtcostperyear.type = "text";
    txtcostperyear.className = 'txtcostperyear';
	var costperyear = document.createElement('span');
	costperyear.className = "spncostperyear";
	colarray2['costperyear'] = {
		header_title: "Costing Per Year",
		edit: [txtcostperyear],
		disp: [costperyear],
		td_class: "tablerow tdcostperyear",
		headertd_class : "tdclick tdcostperyear"
	};
	
	var txtdatefrom2 = document.createElement('input');
	txtdatefrom2.type = "text";
    txtdatefrom2.className = 'txtdatefrom';
	var datefrom2 = document.createElement('span');
	datefrom2.className = "spndatefrom2";
	colarray2['datefrom'] = {
		header_title: "Date From",
		edit: [txtdatefrom2],
		disp: [datefrom2],
		td_class: "tablerow tddatefrom",
		headertd_class : "tdclick tddatefrom"
	};
	
	var txtdateto2 = document.createElement('input');
	txtdateto2.type = "text";
    txtdateto2.className = 'txtdateto';
	var dateto2 = document.createElement('span');
	dateto2.className = "spndateto";
	colarray2['dateto'] = {
		header_title: "Date To",
		edit: [txtdateto2],
		disp: [dateto2],
		td_class: "tablerow tddateto",
		headertd_class : "tdclick tddateto"
	};
	
	var txtcostpermonth2 = document.createElement('input');
    txtcostpermonth2.className = "txtcostpermonth";
    txtcostpermonth2.type = "text";
    txtcostpermonth2.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var costpermonth2 = document.createElement('span');
	costpermonth2.className = "spncostpermonth";
	colarray2['costpermonth'] = {
		header_title: "Costing",
		edit: [txtcostpermonth2],
		disp: [costpermonth2],
		td_class: "tablerow tdcostpermonth",
		headertd_class : "tdclick tdcostpermonth"
	};
	
	var spnpaid = document.createElement('span');
    spnpaid.className =  "spnpaid";
    colarray2['paid'] = { 
        header_title: "paid",
        edit: [spnpaid],
        disp: [spnpaid],
        td_class: "tablerow tdpaid",
        headertd_class : "tdclick tdpaid"
    };
	
	var txtinvoiceno = document.createElement('input');
    txtinvoiceno.className = "txtinvoiceno";
    txtinvoiceno.type = "text";
    txtinvoiceno.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var invoiceno = document.createElement('span');
	invoiceno.className = "spninvoiceno";
	colarray2['invoiceno'] = {
		header_title: "Invoice No.",
		edit: [txtinvoiceno],
		disp: [invoiceno],
		td_class: "tablerow tdinvoiceno",
		headertd_class : "tdclick tdinvoiceno"
	};
	
	var statusid = document.createElement('span');
    statusid.className = "spnstatusid";
    colarray2['statusid'] = { 
        header_title: "Status",
        edit: [statusid],
        disp: [statusid],
        td_class: "tablerow tdstatusid",
        headertd_class : "tdclick tdstatusid"
    };
	
	var next_button = document.createElement('input');
	next_button.type = 'button';
	next_button.value = 'Next';
	next_button.className = "next_button";
	colarray2['nextsubscription'] = { 
		header_title: "",
		edit: [next_button],
		disp: [next_button],
		td_class: "tablerow tdnextsubscription",
		headertd_class : "tdclick tdnextsubscription"
	};
	
	var end_check = document.createElement('input');
	end_check.type = 'checkbox';
	end_check.className = "end_check";
	colarray2['endsubscription'] = { 
		header_title: "End",
		edit: [end_check],
		disp: [end_check],
		td_class: "tablerow tdendsubscription",
		headertd_class : "tdclick tdendsubscription"
	};
	
	var imgUpdate3 = document.createElement('img');
        imgUpdate3.src = "assets/images/iconupdate.png";
        imgUpdate3.setAttribute("onclick","update_fnc(this)");
        imgUpdate3.style.cursor = "pointer";
		imgUpdate3.className = "update2";
    var imgEdit3 = document.createElement('img');
        imgEdit3.src = "assets/images/iconedit.png";
        imgEdit3.setAttribute("onclick"," editSelectedRow(myjstbl2, this);");
		imgEdit3.className = "edit2";
		imgEdit3.style.cursor = "pointer";
        imgEdit3.style.display = "none";
        imgEdit3.style.display = "block";
        
    colarray2['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate3],
        disp: [imgEdit3],
        td_class: "tablerow tdupdate",
		headertd_class : "hdupdate"
    };
	
	var imgDelete3 = document.createElement('img');
    imgDelete3.src = "assets/images/icondelete.png";
    imgDelete3.setAttribute("class","imgdel");
    imgDelete3.setAttribute("id","imgDelete3");
	imgDelete3.style.cursor = "pointer";
    colarray2['coldelete'] = { 
        header_title: "",
        edit: [imgDelete3],
        disp: [imgDelete3],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };
	

	//SPECIAL AGREEMENTS
    var myjstblspecial;
    var tabspecial = document.createElement('table');
    tabspecial.id="tableid7";
    var colarrayspecial = [];
    
	var agreementid = document.createElement('span');
    agreementid.className =  "spnagreementid";
    colarrayspecial['agreementid'] = { 
        header_title: "ID",
        edit: [agreementid],
        disp: [agreementid],
        td_class: "tablerow tdagreementid",
        headertd_class : "tdclick tdagreementid"
    };
	
	var selclientgroup = document.createElement('select');
    selclientgroup.className = "selclientgroup";
    selclientgroup.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selclientgroup.innerHTML = '<?php echo fill_select_options("SELECT CG.`id`, CG.`name`
																FROM `clientgroup` AS CG
																ORDER BY `name`", "id", "name",0,false); ?>';
																	
    var selclientgroup_disp = selclientgroup.cloneNode(true);
    selclientgroup_disp.disabled = "disabled";
    colarrayspecial['colclientgroup'] = { 
        header_title: "Clientgroup", 
        edit: [selclientgroup], 
        disp: [selclientgroup_disp], 
        td_class: "tablerow tdselclientgroup"
    };
	
	var datecreate = document.createElement('span');
	datecreate.className = "spndatecreate";
	colarrayspecial['datecreate'] = {
		header_title: "Date Created",
		edit: [datecreate],
		disp: [datecreate],
		td_class: "tablerow tddatecreate",
		headertd_class : "tdclick tddatecreate"
	};
	
	var seltype = document.createElement('select');
    seltype.className = "seltype";
    seltype.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    seltype.innerHTML = '<select style="width: 100px"><option value="0">Payment</option><option value="1">Special Agreement</option><option value="2">Nelsoft Memo</option></select>';
																	
    var seltype_disp = seltype.cloneNode(true);
    seltype_disp.disabled = "disabled";
    colarrayspecial['coltype'] = { 
        header_title: "Type", 
        edit: [seltype], 
        disp: [seltype_disp], 
        td_class: "tablerow tdseltype"
    };
	
	var txtagreement = document.createElement('input');
    txtagreement.className = "txtagreement";
    txtagreement.type = "text";
    txtagreement.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
	var agreement = document.createElement('span');
	agreement.className = "spnagreement";
	colarrayspecial['agreement'] = {
		header_title: "Memo",
		edit: [txtagreement],
		disp: [agreement],
		td_class: "tablerow tdagreement",
		headertd_class : "tdclick tdagreement"
	};
	
	var txtdatemod = document.createElement('input');
	txtdatemod.type = "text";
    txtdatemod.className = 'txtdatemod';
	var datemod = document.createElement('span');
	datemod.className = "spndatemod";
	colarrayspecial['datemod'] = {
		header_title: "Collection Date",
		edit: [txtdatemod],
		disp: [datemod],
		td_class: "tablerow tddatemod",
		headertd_class : "tdclick tddatemod"
	};
	
	var selmember = document.createElement('select');
    selmember.className = "selmember";
    selmember.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selmember.innerHTML = '<?php echo fill_select_options("SELECT M.`id`, M.`name`
																FROM `members` AS M WHERE `id` > 0
																ORDER BY `name`", "id", "name",0,false); ?>';
																	
    var selmember_disp = selmember.cloneNode(true);
    selmember_disp.disabled = "disabled";
    colarrayspecial['colmember'] = { 
        header_title: "Member", 
        edit: [selmember], 
        disp: [selmember_disp], 
        td_class: "tablerow tdselmember"
    };
	
	var settle_check = document.createElement('input');
	settle_check.type = 'checkbox';
	settle_check.className = "settle_check";
	var settle_check_disp = settle_check.cloneNode(true);
    settle_check_disp.disabled = "disabled";
	colarrayspecial['settle'] = { 
		header_title: "Settled",
		edit: [settle_check],
		disp: [settle_check_disp],
		td_class: "tablerow tdsettle",
		headertd_class : "tdclick tdsettle"
	};
	
	var imgUpdate5 = document.createElement('img');
        imgUpdate5.src = "assets/images/iconupdate.png";
        imgUpdate5.setAttribute("onclick","update_fnc(this)");
        imgUpdate5.style.cursor = "pointer";
		imgUpdate5.className = "update4";
    var imgEdit5 = document.createElement('img');
        imgEdit5.src = "assets/images/iconedit.png";
        imgEdit5.setAttribute("onclick"," editSelectedRow(myjstblspecial, this);");
		imgEdit5.className = "edit4";
		imgEdit5.style.cursor = "pointer";
        imgEdit5.style.display = "none";
        imgEdit5.style.display = "block";
        
    colarrayspecial['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate5],
        disp: [imgEdit5],
        td_class: "tablerow tdupdate",
		headertd_class : "hdupdate"
    };
	
	var imgDelete4 = document.createElement('img');
    imgDelete4.src = "assets/images/icondelete.png";
    imgDelete4.setAttribute("class","imgdel2");
	imgDelete4.style.cursor = "pointer";
    colarrayspecial['coldelete'] = { 
        header_title: "",
        edit: [imgDelete4],
        disp: [imgDelete4],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };
	
	//AGREEMENTS SUMMARY
    var myjstblagreements;
    var tabagreements = document.createElement('table');
    tabagreements.id="tableid8";
    var colarrayagreements = [];
    var parametersagreements = [];
	var headerclass = "";
    var colarrayparamsagreements=["Clientgroup", "CGID", "Payment Warnings", "Special Agreements", "Nelsoft Memos"];
    for (var x=0; x<5; x++)
    {
        parametersagreements[x] = document.createElement('span');
		headerclass = "tdall "+"td"+colarrayparamsagreements[x];
        colarrayagreements[colarrayparamsagreements[x]] = { 
            header_title: colarrayparamsagreements[x],
            edit: [parametersagreements[x]],
            disp: [parametersagreements[x]],
            td_class: "tablerow tdagreements tdall "+"td"+colarrayparamsagreements[x],
            headertd_class : headerclass
        };
    }
	
	//UNPAID TRANSACTIONS
    var myjstblunpaid;
    var tabunpaid = document.createElement('table');
    tabunpaid.id="tableid4";
    var colarrayunpaid = [];
    var parametersunpaid = [];
	var headerclass = "";
    var colarrayparamsunpaid=["SID", "Client - Subscription Name", "Unpaid Amount"];
    for (var x=0; x<3; x++)
    {
        parametersunpaid[x] = document.createElement('span');
		headerclass = "tdall "+"td"+colarrayparamsunpaid[x];
		if(x == 2)
			headerclass = "tdall";
        colarrayunpaid[colarrayparamsunpaid[x]] = { 
            header_title: colarrayparamsunpaid[x],
            edit: [parametersunpaid[x]],
            disp: [parametersunpaid[x]],
            td_class: "tablerow tdunpaid tdall "+"td"+colarrayparamsunpaid[x],
            headertd_class : headerclass
        };
    }
	
	$(function(){
        	
		myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow",
                                                iscursorchange_when_hover : true});
        var root = document.getElementById("tbl");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);
		
        myjstbl2 = new my_table(tab2, colarray2, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow2",
                                                iscursorchange_when_hover : true});
        var root2 = document.getElementById("tbl2");
        root2.appendChild(myjstbl2.tab);
        root2.appendChild(myjstbl2.mypage.pagingtable);
		
		// Client Subscription Table
        myjstbl4 = new my_table(tab4, colarray4, {ispaging : true});
        var root4 = document.getElementById("tbl4");
        root4.appendChild(myjstbl4.tab);
        root4.appendChild(myjstbl4.mypage.pagingtable);
		
		// Unpaid Transactions Table
		myjstblunpaid = new my_table(tabunpaid, colarrayunpaid, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow4",
                                                iscursorchange_when_hover : true});
        var rootunpaid = document.getElementById("tblunpaid");
        rootunpaid.appendChild(myjstblunpaid.tab);
		rootunpaid.appendChild(myjstblunpaid.mypage.pagingtable);
		
		// Subscriptions Table
		myjstblsubscriptions = new my_table(tabsubscriptions, colarraysubscriptions, {ispaging : true,
                                                iscursorchange_when_hover : true});
        var rootsubscriptions = document.getElementById("tblsubscriptions");
        rootsubscriptions.appendChild(myjstblsubscriptions.tab);
		rootsubscriptions.appendChild(myjstblsubscriptions.mypage.pagingtable);
		
		
		// Special Agreements Table
		myjstblspecial = new my_table(tabspecial, colarrayspecial, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow7",
                                                iscursorchange_when_hover : true});
        var rootspecial = document.getElementById("tblspecial");
        rootspecial.appendChild(myjstblspecial.tab);
		rootspecial.appendChild(myjstblspecial.mypage.pagingtable);
		
		// Agreements Summary Table
		myjstblagreements = new my_table(tabagreements, colarrayagreements, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow8",
                                                iscursorchange_when_hover : true});
        var rootagreements = document.getElementById("tblagreements");
        rootagreements.appendChild(myjstblagreements.tab);
		rootagreements.appendChild(myjstblagreements.mypage.pagingtable);
		
		
		$("#filterclientbranch").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
		$("#filtersubscription").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
		$("#filterstatus").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
		$("#filtertype").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
		$("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

			
		
		$('#generate').live('click',function() {
			generate_transactions();  
		});
		
		$('#search').live('click',function() {
			refresh_table();  
		});
		
		$('#txtsearch').keypress( 
		function(e){
			if(e.keyCode == 13)
			{
				refresh_table();
			}
		});
		
		
		
		
		$("input[name=tbl4Filter]:radio").change(function () {
			
			myjstbl4.clean_table();

			if (document.getElementById('details').checked) {
			$(".createnew").hide();
			$(".gen3").show();
			clientBranch.innerHTML = '<?php fill_select_options_multi("SELECT D.id, D.clientid, D.branchname, H.`Name`
					FROM nelsoft_clients.clientdetails AS D
					LEFT JOIN nelsoft_clients.clienthead AS H ON D.clientid = H.`id` ORDER BY H.Name ASC;", "id", "Name","branchname",0,false);  ?>';
			clientBranch_disp.innerHTML = '<?php fill_select_options_multi("SELECT D.id, D.clientid, D.branchname, H.`Name`
					FROM nelsoft_clients.clientdetails AS D
					LEFT JOIN nelsoft_clients.clienthead AS H ON D.clientid = H.`id` ORDER BY H.Name ASC;", "id", "Name","branchname",0,false);  ?>';
			posType.innerHTML = '<?php fill_select_options("SELECT T.id, T.name FROM nelsoft_clients.clientterminaldetails AS T 
					WHERE T.name != '' 
					ORDER BY T.name ASC", "id", "name",0,false); ?>';

			    $.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control2",
				{},
				function(data){
						//myjstbl4.add_new_row();
						
					myjstbl4.insert_multiplerow_with_value(1,data);
						set_tbl_element_events4();
				}); 
						var lastrow_index = myjstbl4.get_row_count() - 1;
						//bind_events_to_row2(lastrow_index, true);	
						//myjstbl4.add_new_row();
						subStatus.disabled = "disabled";
						subStatus_disp.disabled = "disabled";
						set_tbl_element_events_ac_filter();
			
			}else{
				
			$(".createnew").show();
			$(".gen3").hide();
			clientBranch.innerHTML = '<?php fill_select_options("SELECT id, name FROM nelsoft_clients.clienthead ORDER BY name ASC;", "id", "name",0,false);   ?>';
			clientBranch_disp.innerHTML = '<?php fill_select_options("SELECT id, name FROM nelsoft_clients.clienthead ORDER BY name ASC;", "id", "name",0,false);   ?>';
			posType.innerHTML = '<option value="0"  ></option>';
			posType_disp.innerHTML = '<option value="0"></option>';
			posType.disabled = "disabled";
			posType_disp.disabled = "disabled";
			myjstbl4.add_new_row();
	
				$.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control3",
				{},
				function(data){
						//myjstbl4.add_new_row();
						
					myjstbl4.insert_multiplerow_with_value(1,data);
						set_tbl_element_events4();
						var cnt = myjstbl4.get_row_count() -1 ;
						//alert(cnt);
						bind_datepicker_to_subrow(cnt);
				}); 
						var lastrow_index = myjstbl4.get_row_count() - 1;
						//bind_events_to_row2(lastrow_index, true);	
						//myjstbl4.add_new_row();
						set_tbl_element_events_ac_filter();
			
			
			}

		});
		
		
		$("#createnew").click(function(){
			
            myjstbl4.mypage.go_to_last_page(); 
			
			//process_new();
        });	
		
		$('#search3').live('click',function() {
			select_special();  
		});
		
		$('.next_button').live('click',function() {
			generate_next_transaction(this); 
		});
		
		$('.end_check').live('click',function() {
			end_transaction(this); 
		});

		$('#gen3').live('click',function() {
			var r = confirm("Add client branch");
			if (r == true) {
				insert_branch(); 
				
			} else {
				
			}
			 
		});
		
		
		
		$('#subFilter').live('click',function() {
			myjstbl4.clean_table();
		var filterid_val = $("#filtersubid").val();
		var filter_val = $("#filsub").val();
		//alert(filterid_val);

		
		if (document.getElementById('details').checked) {
			
			if(filter_val = ''){
					$.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control2",
					{
					},
					function(data){
							//myjstbl4.add_new_row();
							
						myjstbl4.insert_multiplerow_with_value(1,data);
							set_tbl_element_events4();
					}); 
			} else {
				
					$.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control2",
					{
						branchid : filterid_val
					},
					function(data){
							//myjstbl4.add_new_row();
							
						myjstbl4.insert_multiplerow_with_value(1,data);
							set_tbl_element_events4();
					}); 
			}
		} else {
			if(filter_val = ''){
				$.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control3",
				{
				},
				function(data){
						//myjstbl4.add_new_row();
						
					myjstbl4.insert_multiplerow_with_value(1,data);
						set_tbl_element_events4();
				}); 
			} else {
				$.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control3",
				{
					headid : filterid_val
				},
				function(data){
						//myjstbl4.add_new_row();
						
					myjstbl4.insert_multiplerow_with_value(1,data);
						//set_tbl_element_events4();
						myjstbl4.add_new_row();
						var cnt = myjstbl4.get_row_count() -1 ;
						//alert(cnt);
						bind_datepicker_to_subrow(cnt);
				});  
		}
		}	
			 
		});
		
		$('#add3').live('click',function() {
			insert_add_branch();  
		});
		
	//	$("#filterdatefrom").datepicker({dateFormat: 'yy-mm-dd'});
	//	$("#dateFrom").datepicker({dateFormat: 'yy-mm-dd'});
		
		$("#filterdateto").datepicker({dateFormat: 'yy-mm-dd'});
		set_tbl_element_events_ac();
		select_subscriptions();
	//	refresh_terms();
		refresh_table();
		refresh_table2();
		set_tbl_element_events_ac_filter();
	//	select_unpaid();
	//	select_special();
	//	select_agreements();
		

    });
	
	function set_tbl_element_events() {
		
		my_autocomplete_add(".txtsubname", "<?=base_url()?>clientsubscriptions/ac_subscription", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['subscriptionid'].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['subscriptionname'].td_class);
					myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['typeid'].td_class);
					myjstbl.setvalue_to_rowindex_tdclass([""],row_index, colarray['connecttype'].td_class);
					
					$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
                }
                else {
                    myjstbl.setvalue_to_rowindex_tdclass([ret_datas[0]],row_index,colarray['subscriptionid'].td_class);
					myjstbl.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray['subscriptionname'].td_class);
					myjstbl.setvalue_to_rowindex_tdclass([ret_datas[4]],row_index,colarray['typeid'].td_class);
					
					switch(ret_datas[4]) {
					
						case '0':
							myjstbl.setvalue_to_rowindex_tdclass(["Client Group"], row_index, colarray['connecttype'].td_class);
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).show();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
							break;
						case '1':
							myjstbl.setvalue_to_rowindex_tdclass(["Client Head"], row_index, colarray['connecttype'].td_class);
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).show();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
							break;
						case '2':
							myjstbl.setvalue_to_rowindex_tdclass(["Client Branch"], row_index, colarray['connecttype'].td_class);
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).show();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
							break;
						case '3':
							myjstbl.setvalue_to_rowindex_tdclass(["Client Terminal"], row_index, colarray['connecttype'].td_class);
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).show();
							break;
							
						default:
							myjstbl.setvalue_to_rowindex_tdclass([""], row_index, colarray['connecttype'].td_class);
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
						
					}
					
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                    { width : ["120px","200px"] });
            }
        });
		
	}



	function set_tbl_element_events_ac() {
		
		my_autocomplete_add(".form-control", "<?=base_url()?>clientsubscriptions/ac_clientinfo", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                $('#selsubbranch').val("");
					$('#selsubbranchid').val("");
                }
                else {
					//alert(value);
					$('#selsubbranch').val(label);
					$('#selsubbranchid').val(value);
					//alert($('#selsubbranchid').val())
						return;
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [ 1], 
                    { width : ["400px"] });
            }
        });

		
		
	}
	
	
	
	function set_tbl_element_events_ac_branch() {
		
		my_autocomplete_add(".form-control", "<?=base_url()?>clientsubscriptions/ac_clientinfo", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                $('#selsubbranch').val("");
					$('#selsubbranchid').val("");
                }
                else {
					//alert(value);
					$('#selsubbranch').val(label);
					$('#selsubbranchid').val(value);
					//alert($('#selsubbranchid').val())
						return;
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [ 1], 
                    { width : ["400px"] });
            }
        });

		
		
	}
	
	function set_tbl_element_events_ac_filter() {
		
		if (document.getElementById('details').checked) {
		
			my_autocomplete_add(".form-control2", "<?=base_url()?>clientsubscriptions/ac_clientinfo", {
				enable_add : false,
				fnc_callback : function(x, label, value, ret_datas, error){                
					var row_index = $(x).parent().parent().index();
					if(error.length > 0){
					$('#filsub').val("");
						$('#filtersubid').val("");
					}
					else {
						
						$('#filsub').val(label);
						$('#filtersubid').val(value);
							return;
					}
				},
				fnc_render : function(ul, item){
					return my_autocomplete_render_fnc(ul, item, "code_name", [ 1], 
						{ width : ["400px"] });
				}
			});
		} else {
			my_autocomplete_add(".form-control2", "<?=base_url()?>clientsubscriptions/ac_clientinfohead", {
				enable_add : false,
				fnc_callback : function(x, label, value, ret_datas, error){                
					var row_index = $(x).parent().parent().index();
					if(error.length > 0){
					$('#filsub').val("");
						$('#filtersubid').val("");
					}
					else {
						//alert(value);
						$('#filsub').val(label);
						$('#filtersubid').val(value);
						//alert($('#selsubbranchid').val())
							return;
					}
				},
				fnc_render : function(ul, item){
					return my_autocomplete_render_fnc(ul, item, "code_name", [ 1], 
						{ width : ["400px"] });
				}
			});

		}
		
		
	}
	
	function process_new() {
		
		var lastrow_index = myjstbl4.get_row_count()- 1;
		var rowObj	= myjstbl4.getelem_by_rowindex_tdclass(lastrow_index, colarray4['clientBranch'].td_class)[0];

		var row = $(rowObj).parent().parent();
		var rowindex = $(rowObj).parent().parent().index();

			$.get("<?=base_url()?>clientsubscriptions/refresh_branchHead_ddl_control",
			{

			}
			,
			function(data){
				row.find('.clientBranch').html(data);

				row.find('.clientBranch').trigger("liszt:updated");
			});
			
			$.get("<?=base_url()?>clientsubscriptions/refresh_Typedisable_ddl_control",
			{

			}
			,
			function(data){
				row.find('.posType').html(data);

				row.find('.posType').trigger("liszt:updated");
			});

			row.find('.posType').attr('disabled', true);
			bind_datepicker_to_subrow(rowindex);
		
	}	
	
	
    function refresh_postype_ddl(rowObj)
    {
		var row = $(rowObj).parent().parent();
		var rowindex = $(rowObj).parent().parent().index();
		var clientBranchID = myjstbl4.getvalue_by_rowindex_tdclass(rowindex, colarray4['clientBranch'].td_class)[0];
		//alert(clientBranchID);
        $.get("<?=base_url()?>clientsubscriptions/refresh_postype_ddl_control",
        {
            clientheadid : clientBranchID
        }
        ,
        function(data){
			row.find('.posType').html(data);
            //document.getElementById("posType").innerHTML = data;
            //$("#posType").trigger("liszt:updated");
			row.find('.posType').trigger("liszt:updated");
        });
		
		row.find('.posType').prop('disabled', 'disabled');
		console.log(row);
		
					row.find('.posType').attr('disabled', true);
			row.find('.posType').attr('disabled', 'disabled');
			row.find('.posType').prop('disabled', true);
			row.find('.posType').prop('disabled', 'disabled');
			console.log(row);
			console.log(row.find('.posType'));
	//		
		
		
		
		

    }
	
	
	
	    function getrow()
    {
		var cnt = myjstbl4.get_row_count()
		
//		var row = $(rowObj).parent().parent();
//		var rowindex = $(rowObj).parent().parent().index();
//		var clientBranchID = myjstbl4.getvalue_by_rowindex_tdclass(rowindex, colarray4['clientBranch'].td_class)[0];
//		//alert(clientBranchID);
//        $.get("<?=base_url()?>clientsubscriptions/refresh_postype_ddl_control",
//        {
//            clientheadid : clientBranchID
//        }
//        ,
//        function(data){
//			row.find('.posType').html(data);
//            //document.getElementById("posType").innerHTML = data;
//            //$("#posType").trigger("liszt:updated");
//			row.find('.posType').trigger("liszt:updated");
//        });
//		
//		row.find('.posType').prop('disabled', 'disabled');
//		console.log(row);
//		
//					row.find('.posType').attr('disabled', true);
//			row.find('.posType').attr('disabled', 'disabled');
//			row.find('.posType').prop('disabled', true);
//			row.find('.posType').prop('disabled', 'disabled');
//			console.log(row);
//			console.log(row.find('.posType'));
//	//		
		
		
		
		

    }
	
	
	
	
	


	function set_tbl_element_events2() {
		
		my_autocomplete_add(".txtname", "<?=base_url()?>clientsubscriptions/ac_termsname", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl2.setvalue_to_rowindex_tdclass(["0"],row_index,colarray2['csid'].td_class);
                    myjstbl2.setvalue_to_rowindex_tdclass([""],row_index,colarray2['subscriptionname'].td_class);
                }
                else {
                    myjstbl2.setvalue_to_rowindex_tdclass([value],row_index,colarray2['csid'].td_class);
                    myjstbl2.setvalue_to_rowindex_tdclass([label],row_index,colarray2['subscriptionname'].td_class);
					myjstbl2.setvalue_to_rowindex_tdclass([ret_datas[2]],row_index,colarray2['warrantymonths'].td_class);
					myjstbl2.setvalue_to_rowindex_tdclass([ret_datas[3]],row_index,colarray2['costperyear'].td_class);
					
					var datefrom_element = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['datefrom'].td_class);
					$(datefrom_element).focus();
					
					var datefrom_str = myjstbl2.getvalue_by_rowindex_tdclass(row_index, colarray2['datefrom'].td_class);
					var dateto_str = myjstbl2.getvalue_by_rowindex_tdclass(row_index, colarray2['dateto'].td_class);
					var costperyear = myjstbl2.getvalue_by_rowindex_tdclass(row_index, colarray2['costperyear'].td_class)[0];
					if((datefrom_str != '') && (dateto_str != '')) {
						var date_from = new Date(datefrom_str);
						var date_to = new Date(dateto_str);
						var months_duration = parseFloat((date_to.getMonth() - date_from.getMonth()) + (date_to.getFullYear() - date_from.getFullYear())*12 + 1);
						var costperyear_num = Number(costperyear.replace(/[^0-9\.]+/g,""));
						myjstbl2.setvalue_to_rowindex_tdclass([Math.floor(costperyear_num*(months_duration/12))], row_index, colarray2['costpermonth'].td_class);
						var invoice_element = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['invoiceno'].td_class);
						$(invoice_element).focus();
					}
					
					else
						return;
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                    { width : ["120px","200px"] });
            }
        });
	}

	function set_tbl_element_events4() {
	
 var cnt = myjstbl4.get_row_count();
 
 for(var i=1; i < cnt; i++){	
 var rowObj = myjstbl4.getelem_by_rowindex_tdclass(i, colarray4['clientBranch'].td_class);
 var posType_val = myjstbl4.getvalue_by_rowindex_tdclass(i, colarray4['posType'].td_class);
 var clientBranch_val = myjstbl4.getvalue_by_rowindex_tdclass(i, colarray4['clientBranch'].td_class);
		//alert(posType_val+" "+clientBranch_val);

 	if(posType_val == '' && clientBranch_val == ''){
	
 	var rowObj	= myjstbl4.getelem_by_rowindex_tdclass(i, colarray4['clientBranch'].td_class)[0];
 
 	var row = $(rowObj).parent().parent();
 		$.get("<?=base_url()?>clientsubscriptions/refresh_branchHead_ddl_control",
 		{
 
 		}
 		,
 		function(data){
 			row.find('.clientBranch').html(data);
 
 			row.find('.clientBranch').trigger("liszt:updated");
 		});
 		
 		$.get("<?=base_url()?>clientsubscriptions/refresh_Typedisable_ddl_control",
 		{
 
 		}
 		,
 		function(data){
 			row.find('.posType').html(data);
 			row.find('.posType').trigger("liszt:updated");
 		});
		console.log(row);
		console.log(rowObj);
		row.find('.posType').attr('disabled', true);
				
 	}
 
 	}
 
	//		my_autocomplete_add(".posType", "<?=base_url()?>clientsubscriptions/ac_postype", {
	//	
    //      enable_add : false,
    //      fnc_callback : function(x, label, value, ret_datas, error){                
    //          var row_index = $(x).parent().parent().index();
	//				
    //
    //            myjstbl4.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray4['posType'].td_class);
	//			//myjstbl4.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray4['posType'].td_class);
	//			
	//				return;  
    //      },
    //      fnc_render : function(ul, item){
    //          return my_autocomplete_render_fnc(ul, item, "code_name", [1], 
    //              { width : ["60px","100px"] });
    //      }
    //  });
	}

	function refresh_terms() {
	
		myjstbl.clean_table();
       
        $.getJSON("<?=base_url()?>clientsubscriptions/select_terms_control",
        {},
        function(data){
			myjstbl.add_new_row();
			set_tbl_element_events();
		
            myjstbl.insert_multiplerow_with_value(1,data);
			
			for(var i=1; i < myjstbl.get_row_count(); i++){				
				switch(myjstbl.getvalue_by_rowindex_tdclass(i, colarray['typeid'].td_class)[0]) {
				
					case '0': 
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[1]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[2]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[3]).hide();
						break;
					case '1':
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[0]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[2]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[3]).hide();
						break;
					case '2':
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[0]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[1]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[3]).hide();
						break;
					case '3':
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[0]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[1]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[2]).hide();
						break;
						
					default:
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[0]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[1]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[2]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(i, colarray['selection'].td_class)[3]).hide();						
				}		
			}
			
			var i;
			for(i = 1; i < myjstbl.get_row_count() - 1; i++) {
			
				if( Number(myjstbl.getvalue_by_rowindex_tdclass(i, colarray['used'].td_class)[0]) > 0 ) {
				
					var element1 = myjstbl.getelem_by_rowindex_tdclass(i, colarray['colupdate'].td_class);
					var element2 = myjstbl.getelem_by_rowindex_tdclass(i, colarray['coldelete'].td_class);
					$(element1).hide();
					$(element2).hide();
				}
			}
        }); 	
    }
	
	function refresh_table() {
	
		myjstbl2.clean_table();
       
        $.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control",
        {},
        function(data){
			myjstbl2.add_new_row();
			set_tbl_element_events2();
            myjstbl2.insert_multiplerow_with_value(1,data);
			
			var i;
			for(i = 1; i < myjstbl2.get_row_count(); i++) {
			
				if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 ) {
					var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['nextsubscription'].td_class);
					var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['endsubscription'].td_class);
					$(element1).hide();
					$(element2).hide();
				}
			
				if(( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '' ) ||
					( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 )) {
					
					var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['colupdate'].td_class);
					var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['coldelete'].td_class);
					
					//if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '')
							//$(element1).hide();
							
					$(element2).hide();
				}
			}
			
			var lastrow_index = myjstbl2.get_row_count() - 1;
			bind_events_to_row(lastrow_index, true);
			var element1 = myjstbl2.getelem_by_rowindex_tdclass(lastrow_index, colarray2['nextsubscription'].td_class);
			var element2 = myjstbl2.getelem_by_rowindex_tdclass(lastrow_index, colarray2['endsubscription'].td_class);
			$(element1).hide();
			$(element2).hide();
			
        }); 
    }
	
	function refresh_table2() {
		myjstbl4.clean_table();
       
        $.getJSON("<?=base_url()?>clientsubscriptions/refresh_table_control2",
        {},
        function(data){
			//myjstbl4.add_new_row();
			
            myjstbl4.insert_multiplerow_with_value(1,data);
			set_tbl_element_events4();
        }); 
			var lastrow_index = myjstbl4.get_row_count() - 1;
			$(".createnew").hide();
			//bind_events_to_row2(lastrow_index, true);	
			//myjstbl4.add_new_row();
    }
	
	$('.imgdel').live('click',function() {
		
		var row_index = $(this).parent().parent().index();
		var mainid_val =  myjstbl2.getvalue_by_rowindex_tdclass(row_index, colarray2['mainid'].td_class)[0];
		var termsid_val =  myjstbl2.getvalue_by_rowindex_tdclass(row_index, colarray2['csid'].td_class)[0];
		
		if(mainid_val=="") {
			myjstbl2.delete_row(row_index);
			myjstbl2.add_new_row();
			
			set_tbl_element_events2();
						
			var lastrow_index = myjstbl2.get_row_count() - 1;
			bind_events_to_row(lastrow_index, true);
			
			var element1 = myjstbl2.getelem_by_rowindex_tdclass(lastrow_index, colarray2['nextsubscription'].td_class);
			var element2 = myjstbl2.getelem_by_rowindex_tdclass(lastrow_index, colarray2['endsubscription'].td_class);
			$(element1).hide();
			$(element2).hide();
			
			return;
		}
		else{
			var answer = confirm("Are you sure you want to delete?");
			if(answer==true){
				
				var previd_val = 0;
				if(row_index > 1) {
					if(( myjstbl2.getvalue_by_rowindex_tdclass(row_index-1, colarray2['statusid'].td_class)[0] == 0) 
						&& ( termsid_val == myjstbl2.getvalue_by_rowindex_tdclass(row_index-1, colarray2['csid'].td_class)[0] )){
						
						previd_val = myjstbl2.getvalue_by_rowindex_tdclass(row_index-1, colarray2['mainid'].td_class)[0];
					}
				}
			
				myjstbl2.delete_row(row_index);
				var prev_index_val = row_index - 1;
					
				$.getJSON("<?=base_url()?>clientsubscriptions/delete_transaction_control",
				{
				mainid: mainid_val,
				previd: previd_val
				//, prev_index: prev_index_val
				},
				function(data){
				
					if(data == "error"){}
					else if(data == "deleted"){}
					
					else {
						myjstbl2.delete_row(prev_index_val);
						myjstbl2.insert_multiplerow_with_value(prev_index_val, data);
						
						for (var i = row_index - 1; i < myjstbl2.get_row_count() - 1; i++) {
							// myjstbl2.setvalue_to_rowindex_tdclass([i],i,colarray2['rowcnt'].td_class);
						
							if(( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '' ) ||
								( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 )) {
								
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['colupdate'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['coldelete'].td_class);
								
								//if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '')
										//$(element1).hide();
										
								$(element2).hide();
							}
						}
					}
				});
			}
		}
		
	});
	
	$('.imgdel2').live('click',function() {
		
		var row_index = $(this).parent().parent().index();
		var agreementid_val =  myjstblspecial.getvalue_by_rowindex_tdclass(row_index, colarrayspecial['agreementid'].td_class)[0];
		
		if(agreementid_val=="") {
		
			myjstblspecial.delete_row(row_index);
			myjstblspecial.add_new_row();
			bind_datepicker_to_specialrow(row_index);
			
			return;
		}
		else{
			
		
			var answer = confirm("Are you sure you want to delete?");
			if(answer==true){
			
				myjstblspecial.delete_row(row_index);
					
				$.getJSON("<?=base_url()?>clientsubscriptions/delete_special_control",
				{
				agreementid: agreementid_val,
				},
				function(data){

				});
			}
		}
	});
	

	$('.imgdel4').live('click',function() {
		
		var row_index = $(this).parent().parent().index();
		var mainid_val =  myjstbl4.getvalue_by_rowindex_tdclass(row_index, colarray4['mainid'].td_class)[0];
		
		if(mainid_val=="") {
		
			myjstbl4.delete_row(row_index);
			myjstbl4.add_new_row();
			bind_datepicker_to_subrow(row_index);
			
			return;
		}
		else{
		
			var answer = confirm("Are you sure you want to delete?");
			if(answer==true){
			
				myjstbl4.delete_row(row_index);
					
				$.getJSON("<?=base_url()?>clientsubscriptions/delete_sub_control",
				{
				mainid: mainid_val,
				},
				function(data){

				});
			}
		}
	});

	
	$('.imgdel3').live('click',function() {
		
		var row_index = $(this).parent().parent().index();
		var mainid_val =  myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['mainid'].td_class)[0];

		if(mainid_val=="") {
		
			myjstbl.delete_row(row_index);
			myjstbl.add_new_row();
			set_tbl_element_events();
			
			return;
		}
		else{
		
			var answer = confirm("Are you sure you want to delete?");
			if(answer==true){
			
				myjstbl.delete_row(row_index);
					
				$.getJSON("<?=base_url()?>clientsubscriptions/delete_terms_control",
				{
				mainid: mainid_val
				},
				function(data){
				});
			}
		}
	});

	
	//	function POS_Select(rowObj){
	//	
    //    var rowindex = $(rowObj).parent().parent().index();
	//	
	//	var clientBranchID = myjstbl4.getvalue_by_rowindex_tdclass(rowindex, colarray4['clientBranch'].td_class)[0];
	//	console.log(clientBranchID);
	//	
	//	
	//		my_autocomplete_add(".posType", "<?=base_url()?>clientsubscriptions/ac_postype?clientBranch="+clientBranchID, {
	//	
    //      enable_add : false,
    //      fnc_callback : function(x, label, value, ret_datas, error){                
    //          var row_index = $(x).parent().parent().index();
	//				
    //            myjstbl4.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray4['posType'].td_class);
	//			//myjstbl4.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray4['posType'].td_class);
	//			
	//				return;  
    //      },
    //      fnc_render : function(ul, item){
    //          return my_autocomplete_render_fnc(ul, item, "code_name", [1], 
    //              { width : ["60px","100px"] });
    //      }
    //  });
    //
	//	}

	
	function editSelectedRow( myTable, rowObj){
		

		var row = $(rowObj).parent().parent();
		//console.log($(row).find('.posType').html(""));

		var rowindex = $(rowObj).parent().parent().index();
			
		
		//alert(clientBranchID);
		
		
//my_autocomplete_add(".posType", "<?=base_url()?>clientsubscriptions/ac_postype?clientBranch="+clientBranchID, {
//	
//      enable_add : false,
//      fnc_callback : function(x, label, value, ret_datas, error){                
//          var row_index = $(x).parent().parent().index();
//				
//
//            myjstbl4.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray4['posType'].td_class);
//			//myjstbl4.setvalue_to_rowindex_tdclass([ret_datas[1]],row_index,colarray4['posType'].td_class);
//			
//				return;  
//      },
//      fnc_render : function(ul, item){
//          return my_autocomplete_render_fnc(ul, item, "code_name", [1], 
//              { width : ["60px","100px"] });
//      }
//  });

		if($(rowObj).hasClass("edit")) {
			myTable.edit_row(rowindex);
			
			switch(myjstbl.getvalue_by_rowindex_tdclass(rowindex, colarray['typeid'].td_class)[0]) {
			
				case '0':
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[1]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[2]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[3]).hide();
					break;
				case '1':
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[0]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[2]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[3]).hide();
					break;
				case '2':
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[0]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[1]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[3]).hide();
					break;
				case '3':
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[0]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[1]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[2]).hide();
					break;
					
				default:
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[0]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[1]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[2]).hide();
					$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[3]).hide();
				
			}
			
			return;
		}
		
		if($(rowObj).hasClass("edit2")) {

			var next_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['nextsubscription'].td_class);
			var end_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['endsubscription'].td_class);
			var delete_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['coldelete'].td_class);
			
			var next_hidden = $(next_element).is(':hidden');
			var end_hidden = $(end_element).is(':hidden');
			var delete_hidden = $(delete_element).is(':hidden');
			
			myTable.edit_row(rowindex);

			set_tbl_element_events2();
			bind_events_to_row(rowindex, false);
			
			var next_element2 = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['nextsubscription'].td_class);
			var end_element2 = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['endsubscription'].td_class);
			var delete_element2 = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['coldelete'].td_class);
			
			if(next_hidden)
				$(next_element2).hide();
			if(end_hidden)
				$(end_element2).hide();
			if(delete_hidden)
				$(delete_element2).hide();
			
			var costing_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['costpermonth'].td_class);
			var datefrom_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['datefrom'].td_class);
			var dateto_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['dateto'].td_class);
			var costperyear_element = myjstbl2.getelem_by_rowindex_tdclass(rowindex, colarray2['costperyear'].td_class);
			
			var status_val = myjstbl2.getvalue_by_rowindex_tdclass(rowindex, colarray2['statusid'].td_class)[0];
			if(status_val == 0) {
				$(datefrom_element).prop("disabled",true);
				$(dateto_element).prop("disabled",true);
			}
			else {
				$(datefrom_element).prop("disabled",true);
			}
			
			$(costing_element).prop("disabled",true);
			
			if (myjstbl2.getvalue_by_rowindex_tdclass(rowindex, colarray2['paid'].td_class)[0] == 1) {
				$(costperyear_element).prop("disabled",true);
				$(dateto_element).prop("disabled",true);
			}
			
			return;
		}
		
		if($(rowObj).hasClass("edit4")) {

			myTable.edit_row(rowindex);
			bind_datepicker_to_specialrow(rowindex);
			return;
		}
		
		if($(rowObj).hasClass("edit6")) {

			myTable.edit_row(rowindex);
			bind_datepicker_to_subrow(rowindex);
			
			if (document.getElementById('details').checked) {
				row.find('.subStatus').attr('disabled', true);
			}
			var clientBranchID = myjstbl4.getvalue_by_rowindex_tdclass(rowindex, colarray4['clientBranch'].td_class)[0];
			var clientposType = myjstbl4.getvalue_by_rowindex_tdclass(rowindex, colarray4['posType'].td_class)[0];

			row.find('.posType').attr('disabled', true);

			return;
		}	
		
		
	}

	
	function update_fnc(rowObj) { 
		
		var row_index = $(rowObj).parent().parent().index();
		
		if($(rowObj).hasClass("update")) {
			var values_arr = myjstbl.get_row_values(row_index);
			var mainid_val = values_arr[colarray['mainid'].td_class][0];
			var subscriptionid_val = values_arr[colarray['subscriptionid'].td_class][0];
			var mainname_val = values_arr[colarray['mainname'].td_class][0];
			var typeid_val = values_arr[colarray['typeid'].td_class][0];
			var connectid_val;
			
			switch(typeid_val) {
			
				case '0':
					connectid_val = values_arr[colarray['selection'].td_class][0];
					break;
				case '1':
					connectid_val = values_arr[colarray['selection'].td_class][1];
					break;
				case '2':
					connectid_val = values_arr[colarray['selection'].td_class][2];
					break;
				case '3':
					connectid_val = values_arr[colarray['selection'].td_class][3];
					break;
					
				default:
					connectid_val = "";
				
			}
			
			var fnc = "<?=base_url()?>clientsubscriptions/update_terms_control";
			if (mainid_val == "")
				fnc = "<?=base_url()?>clientsubscriptions/insert_terms_control";
			
			$.getJSON(fnc,
			{
			mainid: mainid_val,
			subscriptionid: subscriptionid_val,
			mainname: mainname_val,
			connectid: connectid_val
			},
			function(data) {
				if(data == "error"){
				}
				else if(data == "exist") {
					alert("Subscription already exists.");
				}
				else if(data == "nosub") {
					alert("Choose a subscription.");
				}
				else if(data == "noname") {
					alert("Please fill up name field.");
				}
				else{
					myjstbl.update_row_with_value(row_index,data);
					
					switch(myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['typeid'].td_class)[0]) {
					
						case '0':
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).show();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
							break;
						case '1':
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).show();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
							break;
						case '2':
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).show();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
							break;
						case '3':
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).show();
							break;
							
						default:
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[0]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[1]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[2]).hide();
							$(myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['selection'].td_class)[3]).hide();
						
					}
					
					if(mainid_val=="") {
					
						myjstbl.add_new_row();
						set_tbl_element_events();
						
						rowindex = myjstbl.get_row_count() - 1;
						$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[0]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[1]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[2]).hide();
						$(myjstbl.getelem_by_rowindex_tdclass(rowindex, colarray['selection'].td_class)[3]).hide();
					}
				}
			});
			
			return;
		}
		
		if($(rowObj).hasClass("update2")) {
			
			var row_index_val = row_index;
			var values_arr = myjstbl2.get_row_values(row_index);
			var mainid_val = values_arr[colarray2['mainid'].td_class][0];
			var termsid_val = values_arr[colarray2['csid'].td_class][0];
			var costperyear_val = values_arr[colarray2["costperyear"].td_class][0];
			var datefrom_val = values_arr[colarray2["datefrom"].td_class][0];
			var dateto_val = values_arr[colarray2["dateto"].td_class][0];
			var costing_val = values_arr[colarray2["costpermonth"].td_class][0];
			var invoiceno_val = values_arr[colarray2["invoiceno"].td_class][0];
			var invoiceno_val = invoiceno_val.trim();
			
			var paystatus = values_arr[colarray2["paid"].td_class][0];
			
			if ((paystatus == 1) && (invoiceno_val == "")) {
				alert("Transaction is already paid. Invoice number cannot be left blank.");
				return;
			}
			
			var fnc = "<?=base_url()?>clientsubscriptions/update_transaction_control";
			if (mainid_val == "")
				fnc = "<?=base_url()?>clientsubscriptions/insert_control";

			$.getJSON(fnc,
				{
				mainid: mainid_val,
				termsid: termsid_val,
				costperyear: costperyear_val,
				datefrom: datefrom_val,
				dateto: dateto_val,
				costing: costing_val,
				invoiceno: invoiceno_val
				},
				function(data) {
					if(data == "error"){
					
					}
					else if(data[0] == "invalid") {
						alert(data[1]);
					}
					else{
					
						myjstbl2.update_row_with_value(row_index,data);
						
						if(mainid_val=="") {
							myjstbl2.add_new_row();
							set_tbl_element_events2();
							
							var lastrow_index = myjstbl2.get_row_count() - 1;
							bind_events_to_row(lastrow_index, true);
							
							var element1 = myjstbl2.getelem_by_rowindex_tdclass(lastrow_index, colarray2['nextsubscription'].td_class);
							var element2 = myjstbl2.getelem_by_rowindex_tdclass(lastrow_index, colarray2['endsubscription'].td_class);
							$(element1).hide();
							$(element2).hide();
						}
						
						var i;
						for(i = 1; i < myjstbl2.get_row_count() - 1; i++) {
						
							if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 ) {
							
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['nextsubscription'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['endsubscription'].td_class);
								$(element1).hide();
								$(element2).hide();
							}
						
							if(( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '' ) ||
								( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 )) {
								
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['colupdate'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['coldelete'].td_class);
								
								//if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '')
										//$(element1).hide();
										
								$(element2).hide();
							}
						}
						
					}
				});	
			
			return;
		}
		
		if($(rowObj).hasClass("update4")) {
		
			var values_arr = myjstblspecial.get_row_values(row_index);
			var agreementid_val = values_arr[colarrayspecial['agreementid'].td_class][0];
			var cgid_val = values_arr[colarrayspecial['colclientgroup'].td_class][0];
			var agreement_val = values_arr[colarrayspecial['agreement'].td_class][0];
			var typeid_val = values_arr[colarrayspecial['coltype'].td_class][0];
			var datemod_val = values_arr[colarrayspecial['datemod'].td_class][0];
			var memberid_val = values_arr[colarrayspecial['colmember'].td_class][0];
			var settle_val = values_arr[colarrayspecial['settle'].td_class][0];
			
			if(agreement_val.trim() == ""){
				alert("Memo may not be left blank.");
				return;
			}
			
			if(settle_val == "true")
				settle_val = 1;
			else
				settle_val = 0;

			var fnc = "<?=base_url()?>clientsubscriptions/update_special_control";
			if (agreementid_val == "")
				fnc = "<?=base_url()?>clientsubscriptions/insert_special_control";
				
			$.getJSON(fnc,
			{
			agreementid: agreementid_val,
			cgid: cgid_val,
			agreement: agreement_val,
			typeid: typeid_val,
			datemod: datemod_val,
			// datecreate: datecreate_val,
			memberid: memberid_val,
			settle: settle_val
			},
			function(data) {
				if(data == "error"){
				}
				else{
					myjstblspecial.update_row_with_value(row_index,data);
					
					if(agreementid_val=="") {
						myjstblspecial.add_new_row();
						bind_datepicker_to_specialrow(myjstblspecial.get_row_count() - 1);
					}
				}
			});
			
			return;
		}
	}
	
	function update_fnc2(rowObj) { 
		
		var row_index = $(rowObj).parent().parent().index();
		
		if($(rowObj).hasClass("update6")) {
			var values_arr 			= myjstbl4.get_row_values(row_index);
			var mainid_val 			= values_arr[colarray4['mainid'].td_class][0];
			var clientBranch_val 	= values_arr[colarray4['clientBranch'].td_class][0];
			//var posType_val 		= values_arr[colarray4['posType'].td_class][0];
			var subType_val 		= values_arr[colarray4['subType'].td_class][0];
			var subDropbox_val 		= values_arr[colarray4['subDropbox'].td_class][0];
			var subFrom_val 		= values_arr[colarray4['subFrom'].td_class][0];
			var subTo_val 			= values_arr[colarray4['subTo'].td_class][0];
			var subAmount_val 		= values_arr[colarray4['subAmount'].td_class][0];
			var subRemarks_val 		= values_arr[colarray4['subRemarks'].td_class][0];
			var DRNo_val 			= values_arr[colarray4['DRNo'].td_class][0];
			var subStatus_val		= values_arr[colarray4['subStatus'].td_class][0];
			
			if(subFrom_val == '' || subTo_val == '' || subAmount_val == ''){
				alert('Select Date From and Date To, and provide Amount');
				return;
			}
			
			if(subFrom_val >= subTo_val){
				alert('Invalid Date Range');
			return;
			}
			
			if(subStatus_val == 'true'){
				subStatus_val = 1;
			} else {
				subStatus_val = 0;
			}	

			if (mainid_val == "") {
        	var fnc = "<?=base_url()?>clientsubscriptions/insert_head_subType_control";
			} else {
			var fnc = "<?=base_url()?>clientsubscriptions/update_subType_control";
			}

			$.getJSON(fnc,
			{

			 mainid 		: mainid_val,
			 clientBranch 	: clientBranch_val,
			 //posType 		: posType_val,
			 subType	 	: subType_val,
			 subDropbox	 	: subDropbox_val,
			 subFrom 		: subFrom_val,
			 subTo 			: subTo_val,
			 subAmount 		: subAmount_val,
			 subRemarks 	: subRemarks_val,
			 DRNo 			: DRNo_val,
			 subStatus 		: subStatus_val
			
			},
			function(data) {
				
				if(data == "Data already Exist"){
					alert("Branch with the same subscription already exist");
				}
				else{		
				var cnt = myjstbl4.get_row_count();
				//alert(cnt);
					myjstbl4.update_row_with_value(row_index,data);
					//myjstbl4.insert_multiplerow_with_value(cnt,data);									
					if(mainid_val=="") {
						myjstbl4.add_new_row();
						
						
						set_tbl_element_events4();
						var cnt = myjstbl4.get_row_count() -1 ;
						//alert(cnt);
						bind_datepicker_to_subrow(cnt);
						
						
						
						
					}				
				}
			});			
			return;
		}	
	}

	
	function insert_branch() { 

		var branchid_val = $("#selsubbranchid").val();
		if(branchid_val == ''){
			return;
		}
		fnc = "<?=base_url()?>clientsubscriptions/insert_subType_control";
			
			$.getJSON(fnc,
			{
			 branchid 		: branchid_val			
			},
			function(data) {
				
				if(data == "error"){
					
				}
				else{	
					if(data == ""){
						alert("No branch added");
					} else {
				var cnt = myjstbl4.get_row_count();
				//alert(cnt);
				
					myjstbl4.insert_multiplerow_with_value(cnt,data);	
					myjstbl4.mypage.go_to_last_page();
					alert("New branch added");
					$('#selsubbranch').val("");
					$('#selsubbranchid').val("");
					}
				}
			});			
			
			return;		
	}
	
	
	function insert_add_branch() { 
		var branchid_val = $("#selsubbranchid").val();
		if(branchid_val == ''){
			return;
		}
		fnc = "<?=base_url()?>clientsubscriptions/insert_subType2_control";
			
			$.getJSON(fnc,
			{
			 branchid 		: branchid_val			
			},
			function(data) {
				
				if(data == "error"){
					
				}
				else{	
					if(data == ""){
						alert("No branch added");
					} else {
				var cnt = myjstbl4.get_row_count();
				//alert(cnt);
				
					myjstbl4.insert_multiplerow_with_value(cnt,data);									
					alert("New branch added");
					$('#selsubbranch').val("");
					$('#selsubbranchid').val("");
					}
				}
			});			
			return;		
	}
	
	
	function generate_transactions() {
	
		var generate_year_val = $("#generatedate").val();
		var generate_date = new Date(generate_year_val + "-12-31");
		
		var data_array = [[]];
		data_array = myjstbl2.get_table_values();

		var mainid_arr = [];
		var termsid_arr = [];
		var rowindex_arr = [];
		var dateto_arr = [];
		var costperyear_arr = [];
		
		var i = 0;
		while(i < data_array.length) {

			row_status = data_array[i][colarray2["statusid"].td_class][0];
			dateto_str = data_array[i][colarray2["dateto"].td_class][0];

			row_dateto = new Date(dateto_str);

			if((row_status == 1) && (row_dateto < generate_date)) {

				mainid_arr.push(data_array[i][colarray2["mainid"].td_class][0]);
				termsid_arr.push(data_array[i][colarray2["csid"].td_class][0]);
				rowindex_arr.push(i+1);
				dateto_arr.push(data_array[i][colarray2["dateto"].td_class][0]);
				costperyear_arr.push(data_array[i][colarray2["costperyear"].td_class][0]);
			}

			i++;

		}
		
		if(mainid_arr.length > 0) {
		
			var fnc = "<?=base_url()?>clientsubscriptions/generate_transactions_control";
			$.getJSON(fnc,
				{
				generate_year : generate_year_val,
				subscription_cnt : mainid_arr.length,
				'mainid[]' : mainid_arr,
				'termsid[]' : termsid_arr,
				'dateto[]' : dateto_arr,
				'costperyear[]' : costperyear_arr
				},
				function(data) {
					if(data == "error"){
			
					}
					else{
						var additional_rows = 0;
						var start_index;

						for(var i = 0; i < mainid_arr.length; i++) {
							
							if(i == 0) {
								myjstbl2.delete_row(rowindex_arr[i]);
								myjstbl2.insert_multiplerow_with_value(rowindex_arr[i],data[1][i]);
								additional_rows = parseInt(data[0][i]);
								start_index = rowindex_arr[i];
							}
							else {
								myjstbl2.delete_row(parseInt(rowindex_arr[i]) + additional_rows);
								myjstbl2.insert_multiplerow_with_value(parseInt(rowindex_arr[i]) + additional_rows, data[1][i]);
								additional_rows = additional_rows + parseInt(data[0][i]);
							}
						}
						
						for (i = start_index; i < myjstbl2.get_row_count() - 1; i++) {
							//myjstbl2.setvalue_to_rowindex_tdclass([i],i,colarray2['rowcnt'].td_class);
							 
							if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 ) {
							
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['nextsubscription'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['endsubscription'].td_class);
								$(element1).hide();
								$(element2).hide();
							}
						
							if(( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '' ) ||
								( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 )) {
								
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['colupdate'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['coldelete'].td_class);
								
								//if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '')
										//$(element1).hide();
										
								$(element2).hide();
							}
						}
					}
				});
		}
		
		else
			return;
	}
	
	function generate_next_transaction(rowObj) {
	
		var row_index = $(rowObj).parent().parent().index();
		var row_index_val = row_index;
		var values_arr = myjstbl2.get_row_values(row_index);
		var mainid_val = values_arr[colarray2['mainid'].td_class][0];
		var termsid_val = values_arr[colarray2['csid'].td_class][0];
		var costperyear_val = values_arr[colarray2["costperyear"].td_class][0];
		var dateto_val = values_arr[colarray2["dateto"].td_class][0];
		
		var fnc = "<?=base_url()?>clientsubscriptions/next_transaction_control";
			
		$.getJSON(fnc,
			{
			// rowindex: row_index_val,
			mainid: mainid_val,
			termsid: termsid_val,
			costperyear: costperyear_val,
			dateto: dateto_val
			},
			function(data) {
				if(data == "error"){
					
				}
				else{
					myjstbl2.delete_row(row_index_val);
					myjstbl2.insert_multiplerow_with_value(row_index_val,data);
					
					for (var i = row_index_val; i < myjstbl2.get_row_count() - 1; i++) {
						// myjstbl2.setvalue_to_rowindex_tdclass([i],i,colarray2['rowcnt'].td_class);
						 
						if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 ) {
						
							var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['nextsubscription'].td_class);
							var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['endsubscription'].td_class);
							$(element1).hide();
							$(element2).hide();
						}
					
						if(( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '' ) ||
							( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 )) {
							
							var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['colupdate'].td_class);
							var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['coldelete'].td_class);
							
							//if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '')
									//$(element1).hide();
									
							$(element2).hide();
						}
					}
				}
			});	
		
		return;
	}
	
	function end_transaction(rowObj) {
	
		var row_index = $(rowObj).parent().parent().index();
		var row_index_val = row_index;
		var values_arr = myjstbl2.get_row_values(row_index);
		var mainid_val = values_arr[colarray2['mainid'].td_class][0];
		
		var answer = confirm("Are you sure you want to end subscription?");
		if(answer==true) {
		
			var fnc = "<?=base_url()?>clientsubscriptions/end_transaction_control";
				
			$.getJSON(fnc,
				{
				//rowindex: row_index_val,
				mainid: mainid_val
				},
				function(data) {
					if(data == "error"){
						
					}
					else{
						myjstbl2.delete_row(row_index_val);
						myjstbl2.insert_multiplerow_with_value(row_index_val,data);
						
						for (var i = row_index_val; i < myjstbl2.get_row_count() - 1; i++) {
							// myjstbl2.setvalue_to_rowindex_tdclass([i],i,colarray2['rowcnt'].td_class);
							 
							if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 ) {
							
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['nextsubscription'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['endsubscription'].td_class);
								$(element1).hide();
								$(element2).hide();
							}
						
							if(( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '' ) ||
								( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['statusid'].td_class)[0] == 0 )) {
								
								var element1 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['colupdate'].td_class);
								var element2 = myjstbl2.getelem_by_rowindex_tdclass(i, colarray2['coldelete'].td_class);
								
								//if( myjstbl2.getvalue_by_rowindex_tdclass(i, colarray2['invoiceno'].td_class)[0] != '')
									//$(element1).hide();
									
								$(element2).hide();
							}
						}
					}
				});
			
		}
		else {
			myjstbl2.setvalue_to_rowindex_tdclass([0],row_index,colarray2['endsubscription'].td_class);
		}
		
		return;
		
	}
	
	function select_subscriptions()
    {  
        myjstblsubscriptions.clean_table();
       
        $.getJSON("<?=base_url()?>clientsubscriptions/select_subscriptions_control",
        {},
        function(data){
            myjstblsubscriptions.insert_multiplerow_with_value(1,data);
        });  
    }
	
	function select_special() {
	
		myjstblspecial.clean_table();
		
		var filtertype_val = $("#filtertype").val();
		var filtergroup_val = $("#filterclientgroup").val();
		
		$.getJSON("<?=base_url()?>clientsubscriptions/select_special_control",
		{
		filtertype: filtertype_val,
		filtergroup: filtergroup_val
		},
		function(data){
		
			myjstblspecial.insert_multiplerow_with_value(1,data);
			myjstblspecial.add_new_row();
			bind_datepicker_to_specialrow(myjstblspecial.get_row_count() - 1);
			
			myjstblspecial.mypage.go_to_last_page();
			
		});  
	}
	
	function select_agreements() {
	
		myjstblagreements.clean_table();
				
		$.getJSON("<?=base_url()?>clientsubscriptions/select_agreements_control",
		{},
		function(data){
			myjstblagreements.insert_multiplerow_with_value(1,data);
			
			$('.tdagreements').live('click',function() {
				
				var row_index = $(this).parent().index();
				var cgid = myjstblagreements.getvalue_by_rowindex_tdclass(row_index, colarrayagreements['CGID'].td_class)[0];
				$("#filterclientgroup").val(cgid);
				$("#filterclientgroup").trigger("liszt:updated");
				
				select_special();
				
			});
		});  
	}
	
	function select_unpaid()
    {  
        myjstblunpaid.clean_table();
       
        $.getJSON("<?=base_url()?>clientsubscriptions/select_unpaid_control",
        {},
        function(data){
            myjstblunpaid.insert_multiplerow_with_value(1,data);
			/*
			$('.tdunpaid').live('click',function() {
		
				var row_index = $(this).parent().index();
				var sid = myjstblunpaid.getvalue_by_rowindex_tdclass(row_index, colarrayunpaid['SID'].td_class)[0];
				
				if(sid > 0) {
					
					$("#filterclientbranch").val(cdid);
					$("#filterclientbranch").trigger("liszt:updated");
					$("#filtersubscription").val(sid);
					$("#filtersubscription").trigger("liszt:updated");
					$("#filterstatus").val(-1);
					$("#filterstatus").trigger("liszt:updated");
					refresh_table();
					
				}
				
			});
			*/
			myjstblunpaid.mypage.go_to_last_page();
        });  
    }
	
	function bind_events_to_row(row_index, is_last_row){
	
		var date_element1 = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['datefrom'].td_class);
		var date_element2 = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['dateto'].td_class);
		
		
		var costing_element = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['costperyear'].td_class);
		
		var identifier;
		if(is_last_row)
			identifier = "last";
		else
			identifier = row_index.toString();
		
		$(date_element1).attr("id","datefrom" + identifier);
		$("#" + "datefrom" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
		$(date_element2).attr("id","dateto" + identifier);
		$("#" + "dateto" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
		
		$(costing_element).attr("id","costperyear" + identifier);
		
		$("#" + "datefrom" + identifier).live('change',function() {
			var id = $(this).attr("id");
			var index = id.substring(8,id.length);
			
			if(index == "last")
				index = myjstbl2.get_row_count() - 1;
			
			var datefrom_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['datefrom'].td_class);
			
			/********************************* set "date to" according to warrantymonths **************************************/
			var months_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['warrantymonths'].td_class);
			if ((months_str > 0) && (datefrom_str != '')) {
				var datefrom_object = new Date(datefrom_str);
				
				var total_months = datefrom_object.getMonth() + parseInt(months_str);
				var dateto_setMonths = total_months - 12*Math.floor(total_months/12);
				var dateto_setYear = datefrom_object.getFullYear() + Math.floor(total_months/12);
				
				var dateto_object = new Date(dateto_setYear, dateto_setMonths, 0);
				var setmonth = dateto_object.getMonth() + 1;
				if(setmonth <= 9)
					setmonth = "0" + setmonth;
				var set_dateto = dateto_object.getFullYear() + "-" + setmonth + "-" + dateto_object.getDate();		
				myjstbl2.setvalue_to_rowindex_tdclass([set_dateto], index, colarray2['dateto'].td_class);
			}
			/******************************************************************************************************************/
			
			var dateto_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['dateto'].td_class);
			var costperyear = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['costperyear'].td_class)[0];
			if((dateto_str != '') && (costperyear != '') && (datefrom_str != '')) {
				var date_from = new Date(datefrom_str);
				var date_to = new Date(dateto_str);
				var months_duration = parseFloat((date_to.getMonth() - date_from.getMonth()) + (date_to.getFullYear() - date_from.getFullYear())*12 + 1);
				var costperyear_num = Number(costperyear.replace(/[^0-9\.]+/g,""));
				myjstbl2.setvalue_to_rowindex_tdclass([Math.floor(costperyear_num*(months_duration/12))], index, colarray2['costpermonth'].td_class);
				var invoice_element = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['invoiceno'].td_class);
				$(invoice_element).focus();
			}
			else
				myjstbl2.setvalue_to_rowindex_tdclass([""], index, colarray2['costpermonth'].td_class);
		});
		
		$("#" + "dateto" + identifier).live('change',function() {
			var id = $(this).attr("id");
			var index = id.substring(6,id.length);
			
			if(index == "last")
				index = myjstbl2.get_row_count() - 1;
			
			var datefrom_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['datefrom'].td_class);
			var dateto_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['dateto'].td_class);
			var costperyear = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['costperyear'].td_class)[0];
			if((datefrom_str != '') && (costperyear != '') && (dateto_str != '')) {
				var date_from = new Date(datefrom_str);
				var date_to = new Date(dateto_str);
				var months_duration = parseFloat((date_to.getMonth() - date_from.getMonth()) + (date_to.getFullYear() - date_from.getFullYear())*12 + 1);
				var costperyear_num = Number(costperyear.replace(/[^0-9\.]+/g,""));
				myjstbl2.setvalue_to_rowindex_tdclass([Math.floor(costperyear_num*(months_duration/12))], index, colarray2['costpermonth'].td_class);
				var invoice_element = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['invoiceno'].td_class);
				$(invoice_element).focus();
			}
			else
				myjstbl2.setvalue_to_rowindex_tdclass([""], index, colarray2['costpermonth'].td_class);
		});
		
		$("#" + "costperyear" + identifier).live('change',function() {
			var id = $(this).attr("id");
			var index = id.substring(11,id.length);
			
			if(index == "last")
				index = myjstbl2.get_row_count() - 1;
			
			var datefrom_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['datefrom'].td_class);
			var dateto_str = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['dateto'].td_class);
			var costperyear = myjstbl2.getvalue_by_rowindex_tdclass(index, colarray2['costperyear'].td_class)[0];
			if((datefrom_str != '') && (dateto_str != '') && (costperyear != '')) {
				var date_from = new Date(datefrom_str);
				var date_to = new Date(dateto_str);
				var months_duration = parseFloat((date_to.getMonth() - date_from.getMonth()) + (date_to.getFullYear() - date_from.getFullYear())*12 + 1);
				var costperyear_num = Number(costperyear.replace(/[^0-9\.]+/g,""));
				myjstbl2.setvalue_to_rowindex_tdclass([Math.floor(costperyear_num*(months_duration/12))], index, colarray2['costpermonth'].td_class);
				var invoice_element = myjstbl2.getelem_by_rowindex_tdclass(row_index, colarray2['invoiceno'].td_class);
				$(invoice_element).focus();
			}
			else
				myjstbl2.setvalue_to_rowindex_tdclass([""], index, colarray2['costpermonth'].td_class);
		});
	}


	
	function bind_datepicker_to_specialrow(row_index){
	
		var date_element = myjstblspecial.getelem_by_rowindex_tdclass(row_index, colarrayspecial['datemod'].td_class);
		var identifier = row_index.toString();
		$(date_element).attr("id","datemod" + identifier);
		$("#" + "datemod" + identifier).datepicker({dateFormat: 'yy-mm-dd'});	
	}
	
	function bind_datepicker_to_subrow(row_index){
	
		var date_element1 = myjstbl4.getelem_by_rowindex_tdclass(row_index, colarray4['subFrom'].td_class);
		var date_element2 = myjstbl4.getelem_by_rowindex_tdclass(row_index, colarray4['subTo'].td_class);
		
		var identifier = row_index.toString();
		$(date_element1).attr("id","subFrom" + identifier);
		$("#" + "subFrom" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
		$(date_element2).attr("id","subTo" + identifier);
		$("#" + "subTo" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
		
	}

	

</script>