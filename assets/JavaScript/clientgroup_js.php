<script language="javascript" type="text/javascript">
    <?php
        $isManagementPosition = $_SESSION["position_id"] == 7;
    ?>

    var notesImages = ["without_notes.png", "notes.ico"];

    // P.U.L Table
    var myjstbl_pul;
    var tab_pul = document.createElement('table');
    tab_pul.id="tableid_pul";
    tab_pul.className = "table table-bordered";

    var isFirstLoad = true;

    var colarray_pul = [];
	
	var id_pul = document.createElement('span');
    id_pul.className="spnclientgroupid";
    colarray_pul['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid",
        headertd_class : "tdclick tdid"
    };

    var otherDetail = document.createElement('span');
    otherDetail.className = "other-detail";
    colarray_pul['other_detail'] = {
        header_title: "other hidden detail",
        edit: [otherDetail, otherDetail, otherDetail, otherDetail],
        disp: [otherDetail, otherDetail, otherDetail, otherDetail],
        td_class: "tablerow td-other-detail",
        headertd_class : "td-other-detail"
    };

    var warningimg = document.createElement('span');
    warningimg.className = 'warningimg';
    colarray_pul['warningimg'] = { 
        header_title: "",
        edit: [warningimg],
        disp: [warningimg],
        td_class: "tablerow tdwarningimg tdpopuphover",
        headertd_class : "tdclick tdwarningimg"
    };
	
    var name_pul = document.createElement('span');
	var txtname_pul = document.createElement('input');
	txtname_pul.type = "text";
    txtname_pul.id = 'name_pul';
    txtname_pul.className = 'name_pul';
    colarray_pul['name_pul'] = { 
        header_title: "Name",
        edit: [txtname_pul],
        disp: [name_pul],
        td_class: "tablerow tdname_pul",
		headertd_class : "hdname_pul tdclick"
    };
	/*
	var mantisname_pul = document.createElement('span');
	var txtmantisname_pul = document.createElement('input');
	txtmantisname_pul.type = "text";
    txtmantisname_pul.id = 'idmantisname_pul';
    txtmantisname_pul.className = 'mantisname_pul';
    colarray_pul['mantisname_pul'] = { 
        header_title: "Mantis Name",
        edit: [txtmantisname_pul],
        disp: [mantisname_pul],
        td_class: "tablerow tdmantisname_pul",
		headertd_class : "hdmantisname_pul tdclick"
    };
	*/
	var customerwid_id = document.createElement('span');
    customerwid_id.className = 'customerwid_id';
    colarray_pul['customerwid_id'] = { 
        header_title: "id",
        edit: [customerwid_id],
        disp: [customerwid_id],
        td_class: "tablerow tdcustomerwid_id",
        headertd_class : "tdclick tdcustomerwid_id"
    };

	var customerwid_pul = document.createElement('span');
	var txtcustomerwid_pul = document.createElement('input');
	txtcustomerwid_pul.type = "text";
    txtcustomerwid_pul.id = 'customerwid_pul';
    txtcustomerwid_pul.className = 'customerwid_pul';	
    colarray_pul['customerwid_pul'] = { 
        header_title: "Customer Business Name",
        edit: [txtcustomerwid_pul],
        disp: [customerwid_pul],
        td_class: "tablerow tdcustomerwid_pul",
		headertd_class : "hdcustomerwid_pul tdclick"
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
	
	var selhelpdesk = document.createElement('select');
    selhelpdesk.className = "selhelpdesk";
    /*selhelpdesk.innerHTML = '<?php //echo fill_select_options("SELECT `id`, `name` FROM `members` WHERE `type` = 2 ORDER BY `name`", "id", "name",0,false); ?>';*/
    selhelpdesk.innerHTML = '<?php echo fill_select_options("SELECT `id`, `username` FROM login WHERE `position_id` = 4 AND `status`=1", "id", "username",0,false); ?>';
    var selhelpdesk_disp = selhelpdesk.cloneNode(true);
    selhelpdesk_disp.disabled = "disabled";
    colarray_pul['helpdesk'] = { 
        header_title: "Help Desk", 
        edit: [selhelpdesk], 
        disp: [selhelpdesk_disp], 
        td_class: "tablerow tdhelpdesk",
        headertd_class: "tdhelpdesk"
    };
	
	var memo1 = document.createElement('span');
	var txtmemo1 = document.createElement('input');
	txtmemo1.type = "text";
	txtmemo1.id = 'memo1';
	txtmemo1.className = 'memo1';
	colarray_pul['memo1'] = { 
		header_title: "Memo1",
		edit: [txtmemo1],
		disp: [memo1],
		td_class: "tablerow tdmemo1",
		headertd_class : "tdmemo1 tdclick"
	};
	
	var memo2 = document.createElement('span');
	var txtmemo2 = document.createElement('input');
	txtmemo2.type = "text";
	txtmemo2.id = 'memo2';
	txtmemo2.className = 'memo2';
	colarray_pul['memo2'] = { 
		header_title: "Memo2",
		edit: [txtmemo2],
		disp: [memo2],
		td_class: "tablerow tdmemo2",
		headertd_class : "tdmemo2 tdclick"
	};
	
    var network_cnt = document.createElement('a');
    network_cnt.setAttribute("href","javascript:;");
    //network_cnt.setAttribute("target","_blank");
    network_cnt.className = 'spnnetwork_cnt';
    network_cnt.setAttribute("onclick","tohead_fnc(this)");
    colarray_pul['network_cnt'] = { 
        header_title: "N",
        edit: [network_cnt],
        disp: [network_cnt],
        td_class: "tablerow tdnetwork_cnt",
        headertd_class : "tdclick tdnetwork_cnt"
    };

    var branch_cnt = document.createElement('a');
    branch_cnt.setAttribute("href","javascript:;");
    //branch_cnt.setAttribute("target","_blank");
    branch_cnt.className = 'spnbranch_cnt';
    colarray_pul['branch_cnt'] = { 
        header_title: "B",
        edit: [branch_cnt],
        disp: [branch_cnt],
        td_class: "tablerow tdbranch_cnt",
        headertd_class : "tdclick tdbranch_cnt"
    };

    var hamachi_cnt = document.createElement('a');
    hamachi_cnt.setAttribute("href","javascript:;");
    //hamachi_cnt.setAttribute("target","_blank");
    hamachi_cnt.className = 'spnhamachi_cnt';
    colarray_pul['hamachi_cnt'] = { 
        header_title: "H",
        edit: [hamachi_cnt],
        disp: [hamachi_cnt],
        td_class: "tablerow tdhamachi_cnt",
        headertd_class : "tdclick tdhamachi_cnt"
    };

    var user_cnt = document.createElement('a');
    user_cnt.setAttribute("href","javascript:;");
    //user_cnt.setAttribute("target","_blank");
    user_cnt.className = 'spnuser_cnt';
    colarray_pul['user_cnt'] = { 
        header_title: "U",
        edit: [user_cnt],
        disp: [user_cnt],
        td_class: "tablerow tduser_cnt",
        headertd_class : "tdclick tduser_cnt"
    };

    var monthly_charge = document.createElement('span');
	monthly_charge.style = "display:none";
    colarray_pul['monthly_charge'] = { 
        header_title: "",
        edit: [monthly_charge],
        disp: [monthly_charge],
        td_class: "tablerow tdmonthly_charge",
        headertd_class : "tdclick tdmonthly_charge"
    };

    var balance = document.createElement('a');
    balance.setAttribute("href","javascript:;");
    balance.setAttribute("target","_blank");
	//balance.style = "display:none";
    balance.className = 'spnbalance';
    colarray_pul['balance'] = { 
        header_title: "",
        edit: [balance],
        disp: [balance],
        td_class: "tablerow tdbalance",
        headertd_class : "tdclick tdbalance"
		
    };

    var month_left = document.createElement('span');
	month_left.style = "display:none";
    colarray_pul['month_left'] = { 
        header_title: "",
        edit: [month_left],
        disp: [month_left],
        td_class: "tablerow tdmonth_left",
        headertd_class : "tdclick tdmonth_left"
    };

    var pdfimg = document.createElement('img');
    pdfimg.className = "pdfimg thumbnail";
    pdfimg.src = "assets/images/pdf.png";
    colarray_pul['pdfimg'] = {
        header_title: "",
        edit: [pdfimg],
        disp: [pdfimg],
        td_class: "tablerow tdall tdpdfimg",
        headertd_class : "thpdfimg"
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
        headertd_class: "tddelete"
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

	var arr = [];
    $(function() {
        // P.U.L
        myjstbl_pul = new my_table(tab_pul, colarray_pul, {ispaging : true,
                                                tdpopup_when_hover : "tdpopuphover",
                                                iscursorchange_when_hover : true});

        var root_pul = document.getElementById("tbl_pul");
        root_pul.appendChild(myjstbl_pul.tab);
        root_pul.appendChild(myjstbl_pul.mypage.pagingtable);
		// pul_refresh_table();

        showInitialPageLoadDisplay(myjstbl_pul);

		$("#txtsearch").keypress( 
		function(e){
			if(e.keyCode == 13)
			{
				pul_refresh_table();
			}
		});

        $("#createnew").click(function(){
            if (isFirstLoad) {
                alert("Unable to add new row. Please load the data first.");
            } else {
                myjstbl_pul.mypage.go_to_last_page();
                $(".name_pul").last().focus();
            }
        });

        $("#button-search").click(function(){
            pul_refresh_table();
        });

        $(".spnbalance").live("mouseover",function(){
            var clientgroupid = $(this).parent().parent().find(".spnclientgroupid").html();
            $(this).attr("href","client_points_info?clientgroupid="+clientgroupid);
        });

        $(".tdid").live("mousemove", function(e){
            var rowIndex = $(this).parent().index();
            var otherDetails = myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['other_detail'].td_class);

            $("#created-by").html(otherDetails[0]);
            $("#created-by-on").html(otherDetails[1]);
            $("#last-modified-by").html(otherDetails[2]);
            $("#last-modified-by-on").html(otherDetails[3]);
            // created-by-on

            // last-modified-by
            // last-modified-by-on

            var browserWidth = $(window).width();
            var cursorX = e.pageX + 10;
            var popUpWidth = $(document).find("#user-edit-popup").width();
            if (cursorX + popUpWidth + 20 >= browserWidth) {
                cursorX = cursorX - popUpWidth - 20;
            }
            $(document).find("#user-edit-popup").css({
                display : "block",
                left: cursorX,
                top: e.pageY + 10
            });
        });

        $(".tdid").live("mouseleave", function(e){
            $(document).find("#user-edit-popup").css({
                display : "none"
            });
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
        var clientGroupId = myjstbl_pul.getvalue_by_rowindex_tdclass(
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
                url: "<?=base_url()?>clientgroup/deleteClientNotes",
                data: {
                    id: idValue,
                    hiddenId: idHiddenValue,
                    clientId: clientGroupId,
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

        $(".pdfimg").live("click",function(){
            // alert('haha');
            var row_index = $(this).parent().parent().index();
            // row_index_val = row_index;
            var id = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
            window.open("client_points_info/generatePdf?clientgroupid=" + id 
                            + "&datefrom=<?= date('Y-m-01', strtotime(date('Y-m')." -1 month")) ?>"
                            + "&dateto=<?= date("Y-m-d")?>"
                            + "&statedate=<?= date("Y-m-d") ?>");
        });

        $(".spnhamachi_cnt").live("click",function(){
            // alert('haha');
            var row_index = $(this).parent().parent().index();
            // row_index_val = row_index;
            var id = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
            window.open("hamachisubscriptions?clientgroupid=" + id);
        });

        
        $(".spnuser_cnt").live("click",function(){
            // alert('haha');
            var row_index = $(this).parent().parent().index();
            // row_index_val = row_index;
            var id = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
            window.open("enrolleduser?clientgroupid=" + id);
        });
		
        
        $(".spnbranch_cnt").live("click",function(){
            // alert('haha');
            var row_index = $(this).parent().parent().index();
            // row_index_val = row_index;
            var id = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
            window.open("clientdetails?clientgroupid=" + id);
        });

        $("#btnToggle").live("click",function(){
            
            var button = $(this) ;
        
            if (!button.hasClass('pressed')) {
                button.addClass('pressed');
                button.val("DESC");
            }
            else {
                button.removeClass('pressed');
                button.val("ASC");
            }
        });
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
            url: "<?=base_url()?>clientgroup/displayClientNotes",
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
        var clientGroupId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray_pul['id_pul'].td_class
        )[0];

        if (myjstbl_pul.getvalue_by_rowindex_tdclass(rowIndex, colarray_pul['id_pul'].td_class)[0] == "") {
            alert("Please save row first before you can change notes");
            return;
        }

        $("#row-index-notes").val(rowIndex);
        $("#client-notes").modal("show");
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
        var clientGroupId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index-notes").val(),
            colarray_pul['id_pul'].td_class
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
            url: "<?=base_url()?>clientgroup/saveClientNotes",
            data: {
                hiddenId: idHiddenValue,
                id: idValue,
                clientId: clientGroupId,
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
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+notesImages[1]+"' style='height: 20px; width: 20px;'>"],
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

    function tohead_fnc(rowObj) { 

        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
       
        window.open("clienthead?clientgroupid=" + id_val);
            
    }

    function editSelectedRow( myTable, rowObj){
        var rowindex = $(rowObj).parent().parent().index();
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');
        set_tbl_element_events();

        if (myTable == 'myJsTableNotes') {
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
    }

	function set_tbl_element_events() {
        /*
		my_autocomplete_add(".mantisname_pul", "<?=base_url()?>clientgroup/ac_mantisname", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){               
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl_pul.setvalue_to_rowindex_tdclass([""],row_index,colarray_pul['mantisname_pul'].td_class);
                }
                else {
                    myjstbl_pul.setvalue_to_rowindex_tdclass([value],row_index,colarray_pul['mantisname_pul'].td_class);	
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0], 
                    { width : ["120px"] });
            }
            });  
        */
       
        myjstbl_pul.setvalue_to_rowindex_tdclass(
            ["<img src='assets/images/"+notesImages[0]+"' style='height: 20px; width: 20px;'>"],
            myjstbl_pul.get_row_count() - 1,
            colarray_pul['columnImageNotes'].td_class
        );

		my_autocomplete_add(".customerwid_pul", "<?=base_url()?>clientgroup/ac_customerwid", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl_pul.setvalue_to_rowindex_tdclass(["0"],row_index,colarray_pul['customerwid_id'].td_class);
                    myjstbl_pul.setvalue_to_rowindex_tdclass([""],row_index,colarray_pul['customerwid_pul'].td_class);
                }
                else {
                    myjstbl_pul.setvalue_to_rowindex_tdclass([value],row_index,colarray_pul['customerwid_id'].td_class);
                    myjstbl_pul.setvalue_to_rowindex_tdclass([label],row_index,colarray_pul['customerwid_pul'].td_class);	
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                    { width : ["120px","200px"] });
            }
            });  
	}
	
	//UPDATE and INSERT new row on PUL TABLE
	function pul_update_fnc(rowObj) { 
		//alert(m);
		// alert (arr[0][0]);
		$('#lblStatus').css('visibility', 'hidden');
		var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
		// alert(row_index_val+"up");
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
        var name_val = values_arr[colarray_pul["name_pul"].td_class][0];
        //var mantisname_val = values_arr[colarray_pul["mantisname_pul"].td_class][0];
        var customerwid_id_val = values_arr[colarray_pul["customerwid_id"].td_class][0];
		var selhelpdesk_val = values_arr[colarray_pul['helpdesk'].td_class][0];
		var memo1_val = values_arr[colarray_pul["memo1"].td_class][0];
		var memo2_val = values_arr[colarray_pul["memo2"].td_class][0];
        var warningContentValue = values_arr["tablerow tdpopuphover"][0];

        var numberOfNetwork = values_arr["tablerow tdnetwork_cnt"];
        var numberOfBranches = values_arr["tablerow tdbranch_cnt"];
        var numberOfHamachi = values_arr["tablerow tdhamachi_cnt"];
        var numberOfUser = values_arr["tablerow tduser_cnt"];

		var fnc_pul = "<?=base_url()?>clientgroup/update_control";
        if (id_val == "")
        	fnc_pul = "<?=base_url()?>clientgroup/insert_control";

		$.getJSON(fnc_pul,
			{
			id_g:id_val,
			name_g: name_val,
			//mantisname_g: mantisname_val,
			customerwid_id_g: customerwid_id_val,
			selhelpdesk_g : selhelpdesk_val,
			memo1_g: memo1_val,
            memo2_g: memo2_val,
            warning_content_value : warningContentValue,
            number_of_network : numberOfNetwork,
            number_of_branches : numberOfBranches,
            number_of_hamachi : numberOfHamachi,
            number_of_user : numberOfUser
			},
			function(data) {
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
				}
            updateLogScreen();
			});	
			
	}
	//Delete Function For PUL Table
	$('.imgdel').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
       var hasNetworkRemaining = false;

        $.ajax(
        {
            url: "<?=base_url()?>clientgroup/countNetwork",
            dataType: "json",
            type: "POST",
            data: {
                id: id_val
            },
            async: false,
            success: function(data)
            {
                hasNetworkRemaining = data[0] > 0;
            }
        });

        if (hasNetworkRemaining) {
            alert("Group can only be deleted if no network exists");
            return;
        }

		var answer = confirm("Are you sure you want to delete?");
		if(answer==true){
			$.get("<?=base_url()?>clientgroup/delete_control",
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
	
	function pul_refresh_table() {
	  myjstbl_pul.clean_table();
      var search_val = $.trim($('#txtsearch').val());
      var selOrderBy_val = $("#selOrderBy").val();
      var btnToggle_val = $("#btnToggle").val();
      var selhelpdesk_filter_val = $("#selhelpdesk_filter").val();
	  $('#lblStatus').css('visibility', 'hidden');
        $.getJSON("<?=base_url()?>clientgroup/pul_refresh",
            { 
                search: search_val,
                selOrderBy : selOrderBy_val,
                btnToggle : btnToggle_val,
                selhelpdesk_filter : selhelpdesk_filter_val
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
			});
    }

	function ifEmpty(x, y) {
        if(!$.trim(x)){
			$('#lblStatus').css('visibility', 'visible');
			$('#lblStatus').text("Pls. Fill up All Fields!");
			//$("#alerterror").fadeOut( 4000, "linear");
            return false;
        }else 
            return true;
    }
	function isNumberKey(evt) { 						// Prevents other keys except numbers
		evt = (evt) ? evt : event;
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45 && charCode != 46 && charCode != 58)
		return false;
		return true;
	}
</script>