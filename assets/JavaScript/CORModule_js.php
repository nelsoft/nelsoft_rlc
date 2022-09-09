<script language="javascript" type="text/javascript">
    <?php 
        $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
        $isManagementPosition = $_SESSION["position_id"] == 7;
    ?>

    var notesImages = ["without_notes.png", "notes.ico"];
    var statusImages = ["red_status.png", "green_status.png"];
    var updaterecord_flag = 0;
    // P.U.L Table
    var myjstbl_pul;
    var tab_pul = document.createElement('table');
    tab_pul.id="tableid_pul";
    tab_pul.className = "table table-bordered tbl-design";

    var colarray_pul = [];
    const IMAGE_COUNT_LIMIT = 6;
    
    var isFirstLoad = true;

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

	var id_pul = document.createElement('span');
    colarray_pul['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid tdpopuphover",
        headertd_class : "tdclick tdid"
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


    var spnAddress = document.createElement('span');
    var txtAddress = document.createElement('input');
    txtAddress.type = "text";
    txtAddress.id = 'idtxtAddress';
    txtAddress.className = 'Address';
    colarray_pul['Address'] = { 
        header_title: "Address",
        edit: [txtAddress],
        disp: [spnAddress],
        td_class: "tablerow tdAddress",
        headertd_class : "hdAddress tdclick"
    };

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

    var tin1View = document.createElement('span');
    tin1View.className = "tin-1-view";
    var tin2View = document.createElement('span');
    tin2View.className = "tin-2-view";
    var tin3View = document.createElement('span');
    tin3View.className = "tin-3-view";
    var tin4View = document.createElement('span');
    tin4View.className = "tin-4-view";
    var tin1Edit = document.createElement('input');
    tin1Edit.type = 'text';
    tin1Edit.className = 'tin-1-edit';
    tin1Edit.setAttribute("maxLength", 3);
    tin1Edit.setAttribute("onkeypress","return isNumberKey(event);");
    var tin2Edit = document.createElement('input');
    tin2Edit.type = 'text';
    tin2Edit.className = 'tin-2-edit';
    tin2Edit.setAttribute("maxLength", 3);
    var tin3Edit = document.createElement('input');
    tin3Edit.type = 'text';
    tin3Edit.className = 'tin-3-edit';
    tin3Edit.setAttribute("maxLength", 3);
    var tin4Edit = document.createElement('input');
    tin4Edit.type = 'text';
    tin4Edit.className = 'tin-4-edit';
    tin4Edit.setAttribute("maxLength", 5);
    var tinSeparator = document.createElement('span');
    tinSeparator.className = "tin-separator";
    tinSeparator.value = "-";
    colarray_pul['column_tin'] = {
        header_title : "TIN",
        edit : [tin1Edit, tinSeparator, tin2Edit, tinSeparator, tin3Edit, tinSeparator, tin4Edit],
        disp : [tin1View, tinSeparator, tin2View, tinSeparator, tin3View, tinSeparator, tin4View],
        td_class : "tablerow td-tin",
        headertd_class : "td-tin"
    };

    var vatStatusEdit = document.createElement('select');
    vatStatusEdit.innerHTML = '<option value="0">Not Set</option><option value="1">VAT</option><option value="2">Non-VAT</option>';
    vatStatusEdit.className = "vat-status";
    var vatStatusView = vatStatusEdit.cloneNode(true);
    vatStatusView.disabled = "disabled";
    colarray_pul['column_vat_status'] = {
        header_title : "VAT Status",
        edit : [vatStatusEdit],
        disp : [vatStatusView],
        td_class : "tablerow td-vat-status",
        headertd_class : "td-vat-status"
    };

    var spanRegistrationDate = document.createElement('span');
    var textRegistrationDate = document.createElement('input');
    textRegistrationDate.type = "text";
    textRegistrationDate.id = 'textRegistrationDate';
    textRegistrationDate.className = 'textRegistrationDate';
    colarray_pul['RegistrationDate'] = { 
        header_title: "Registration Date",
        edit: [textRegistrationDate],
        disp: [spanRegistrationDate],
        td_class: "tablerow tdRegistrationDate",
        headertd_class : "hdRegistrationDate tdclick"
    };

    var btnfileupload = document.createElement('input');
    btnfileupload.type = "file";
    btnfileupload.id = 'iniimgupload';
    btnfileupload.accept = 'image/*';
	var imgUpload = document.createElement('img')
    imgUpload.src = "assets/images/SuppDocs.png";
    imgUpload.setAttribute("class","btn btn-info btn-lg");
    imgUpload.setAttribute("id","imgUpload");
	imgUpload.style.height = '20px';
	imgUpload.style.width = '20px';
	imgUpload.style.cursor = "pointer";
	imgUpload.setAttribute("onclick","show_imgs(this)");
	imgUpload.setAttribute("data-target","#myModal3");
	imgUpload.setAttribute("data-toggle","modal");
    colarray_pul['colupload'] = { 
        header_title: "Attachments",
        edit: [btnfileupload],
        disp: [imgUpload],
        td_class: "tablerow tdpages",
        headertd_class: "hdpages"
    };

    var spanIsAvailable = document.createElement('span');
    spanIsAvailable.type = "hidden";
    spanIsAvailable.setAttribute("style", "display: none");
    colarray_pul['colIsAvailable'] = {
        header_title: "",
        edit: [spanIsAvailable],
        disp: [spanIsAvailable],
        td_class: "tablerow"
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
        // imgEdit.style.display = "none";
        // imgEdit.style.display = "block";
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

    colarray_pul['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };

    /* Image Table */
    var myjstbl_pul_img;
    var tab_pul_img = document.createElement('table');
    tab_pul_img.id = "cor_table";
    tab_pul_img.className = "table table-bordered";

    var colarray_pul_img = [];

    var number_cor = document.createElement('span');
    colarray_pul_img['number_cor'] = { 
        header_title: "#",
        edit: [number_cor],
        disp: [number_cor],
        td_class: "tablerow tablerow_cor tdclick tdno",
        headertd_class : "hdclick tdno"
    };

    var spnimage_id = document.createElement('span');
    spnimage_id.className = 'spnimage_id';
    colarray_pul_img['spnimage_id'] = { 
        header_title: "Image ID",
        edit: [spnimage_id],
        disp: [spnimage_id],
        td_class: "tablerow tdimage_id",
        headertd_class : "hdclick tdimage_id"
    };

    var spncor_id = document.createElement('span');
    spncor_id.className = 'spncor_id';
    colarray_pul_img['spncor_id'] = { 
        header_title: "COR ID",
        edit: [spncor_id],
        disp: [spncor_id],
        td_class: "tablerow tdclick tdcor_id",
        headertd_class : "hdclick tdcor_id"
    };

    var spnimg_location = document.createElement('span');
    spnimg_location.className = 'spnimg_location';
    colarray_pul_img['spnimg_location'] = { 
        header_title: "",
        edit: [spnimg_location],
        disp: [spnimg_location],
        td_class: "tablerow tdimg_location",
        headertd_class : "hdclick tdimg_location"
    };
    
    var spnname_cor = document.createElement('span');
    var txtname_cor = document.createElement('input');
    txtname_cor.type = "text";
    txtname_cor.id = 'txtname_cor';
    txtname_cor.className = 'txtname_cor';
    colarray_pul_img['imagename_cor'] = { 
        header_title: "IMG",
        edit: [txtname_cor],
        disp: [spnname_cor],
        td_class: "tablerow tdclick tdname_cor",
        headertd_class : "hdclick tdname_cor"
    };
    
    var spnremarks_cor = document.createElement('span');
    var txtremarks_cor = document.createElement('input');
    txtremarks_cor.type = "text";
    txtremarks_cor.id = 'txtremarks_cor';
    txtremarks_cor.className = 'txtremarks_cor';
    colarray_pul_img['remarks_cor'] = { 
        header_title: "Remarks",
        edit: [txtremarks_cor],
        disp: [spnremarks_cor],
        td_class: "tablerow tdclick tdremarks_cor",
        headertd_class : "hdclick tdremarks_cor"
    };
    
    var imgUpdate_cor = document.createElement('img');
        imgUpdate_cor.src = "assets/images/iconupdate.png";
        imgUpdate_cor.setAttribute("onclick", "save_images_details(this)");
        imgUpdate_cor.style.cursor = "pointer";
    var imgEdit_cor = document.createElement('img');
        imgEdit_cor.src = "assets/images/iconedit.png";
        imgEdit_cor.setAttribute("onclick", "edit_images_details(myjstbl_pul_img, this)");
        imgEdit_cor.id = "edit_cor";
        imgEdit_cor.className = "edit_cor";
        imgEdit_cor.style.cursor = "pointer";
        // imgEdit_cor.style.display = "none";
        // imgEdit_cor.style.display = "block";
    colarray_pul_img['colupdate_cor'] = { 
        header_title: "",
        edit: [imgUpdate_cor],
        disp: [imgEdit_cor],
        td_class: "tablerow tdupdate_cor",
        headertd_class : "hdupdate_cor"
    };

    var imgCancel_cor = document.createElement('img');
    imgCancel_cor.src = "assets/images/icondelete.png";
    imgCancel_cor.setAttribute("class","imgCancel_cor");
    imgCancel_cor.setAttribute("onclick"," cancel_edit(myjstbl_pul_img, this);");
    var imgDelete_cor = document.createElement('img');
    imgDelete_cor.src = "assets/images/icondelete.png";
    imgDelete_cor.setAttribute("onclick"," delete_image(myjstbl_pul_img, this);");
    imgDelete_cor.setAttribute("class","imgdel_cor");
    colarray_pul_img['coldelete_cor'] = { 
        header_title: "",
        edit: [imgCancel_cor],
        disp: [imgDelete_cor],
        td_class: "tablerow tddelete_cor",
        headertd_class: "hddelete_cor"
    };

	//Table 3
	var arr = [];
	var headid = "";
    $(function() {
		$('#tbl_pul').on("click","#tableid_pul tr", function(){
			$(this).find('input:radio').prop('checked', true);
			var chkbox= $(this).find('input:radio').html();
		});
		
        $(".txteacpassword").live("keydown", function(e) {
            if (e.keyCode == 13) {
                pul_update_fnc(this);
            }
        });

        $(".tin-1-edit, .tin-2-edit, .tin-3-edit, .tin-4-edit").live("keyup", function(event){
            if (event.keyCode != 13) {
                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                    if (this.value.length == this.maxLength && (this.value != "000" || this.value != "00000")) {
                        next_focus(this);
                    }
                } else {
                    event.keyCode
                }
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
				}
                updateLogScreen();
			});			
		$('#loading').hide();
		$("#message").html(data);
		}
		});


		}));

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

        $("#button-search").click(function(){
            pul_refresh_table();
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

		$('#tbl_pul').on("click","#tableid_pul tr", function(){
			$(this).find('input:radio').prop('checked', true);
			var chkbox= $(this).find('input:radio').html();
		});

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

   function isNumberKey(evt)
   {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
         return false;

      return true;
   }

    function refresh_datepicker(row_index) {
        var elemdate = myjstbl_pul.getelem_by_rowindex_tdclass(row_index,
                        colarray_pul['RegistrationDate'].td_class)[0];
                        
        var date_val = $(elemdate).val();
        
        $(elemdate).datepicker();
        $(elemdate).datepicker("option","dateFormat", "yy-mm-dd" );
        $(elemdate).val(date_val);
    }

    function editSelectedRow( myTable, rowObj){
        if (updaterecord_flag != 0) {
            return;
        }
        var rowindex = $(rowObj).parent().parent().index();
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');
        //alert(rowindex);
        refresh_datepicker(rowindex);

        // hide_img_upload(rowindex);
        var values_arr = myjstbl_pul.get_row_values(rowindex);
        
        // hide upload button
        myjstbl_pul.getelem_by_rowindex_tdclass(rowindex,
                        colarray_pul['colupload'].td_class)[0].setAttribute("hidden", "hidden");

        // replace with document button
        var html = '<img src="assets/images/SuppDocs.png" class="btn btn-info btn-lg" id="imgUpload" onclick="show_imgs(this)" data-target="#myModal3" data-toggle="modal" style="height: 20px; width: 20px; cursor: pointer;">';
        myjstbl_pul.getelem_by_rowindex_tdclass(rowindex,
                        colarray_pul['colupload'].td_class)[0].parentElement.innerHTML = html;

    }

	//UPDATE and INSERT new row on PUL TABLE
    function pul_update_fnc(rowObj)
    {
        if(updaterecord_flag != 0) return;
        updaterecord_flag = 1;

        $('#lblStatus').css('visibility', 'hidden');
        var cnt = myjstbl_pul.get_row_count() - 1;
        var row_index = $(rowObj).parent().parent().index();
        var row_index_val = row_index;
        var values_arr = myjstbl_pul.get_row_values(row_index);
        var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
        var businessName_val= values_arr[colarray_pul['BusinessName'].td_class][0];
        var address_val = values_arr[colarray_pul['Address'].td_class][0];
        var owner_val= values_arr[colarray_pul['owner'].td_class][0];
        var tinCode1 = values_arr[colarray_pul['column_tin'].td_class][0];
        var tinCode2 = values_arr[colarray_pul['column_tin'].td_class][2];
        var tinCode3 = values_arr[colarray_pul['column_tin'].td_class][4];
        var tinCode4 = values_arr[colarray_pul['column_tin'].td_class][6];
        var vatStatus = values_arr[colarray_pul['column_vat_status'].td_class][0];
        var registrationDate = values_arr[colarray_pul['RegistrationDate'].td_class][0];

        var tin = tinCode1 + "" + tinCode2 + "" + tinCode3 + "" + tinCode4;
        if (tin.length > 0 && ! tin.match(/^\d+$/)) {
            alert("Invalid TIN input");
            updaterecord_flag = 0;
            return;
        }
        if (! (tin.length == 12 || tin.length == 13 || tin.length == 14)) {
            alert("Invalid TIN input");
            updaterecord_flag = 0;
            return;
        }

        tin = tinCode1 + "" + tinCode2 + "" + tinCode3 + "" + tinCode4;

        if (parseInt(tin) == 0 &&  parseInt(tinCode4) > 0) {
            alert("Invalid TIN input");
            updaterecord_flag = 0;
            return;
        }
        if ((tin == "")||(businessName_val == "")||(address_val == "")||(owner_val == "")||(registrationDate == "")) {
            alert("Please fill up all required fields");
            updaterecord_flag = 0;
            return;
        }

        if(id_val == ""){
            var image = $("#iniimgupload")[0].files;
            var img_len = image.length;
            if(img_len == 0){
                alert("Image upload cannot be empty");
                updaterecord_flag = 0;
                return;
            }

            var has_invalid = 0;
            for (var i = 0; i < img_len; i++) {
                var splitFileName = image[i].name.split(".");
                if ($.inArray(splitFileName[splitFileName.length - 1].toLowerCase(), ["jpeg", "jpg", "png"]) == -1) {
                    has_invalid = 1;
                }
            }

            if(has_invalid){
                alert("Image(s) file type in invalid only accepts 'jpeg', 'jpg', 'png' only");
                updaterecord_flag = 0;
                return;
            }

            var files = $('#iniimgupload')[0].files[0];
            var file_name = files['name'];
        }

		var fnc_pul = "<?=base_url()?>CORModule/update_control";
        if (id_val == "")
        	fnc_pul = "<?=base_url()?>CORModule/insert_control";

		$.ajax({
            type: "POST",
            url: fnc_pul,
            async: true,
            dataType: 'json',
            data: {
                id                : id_val,
                businessName      : businessName_val,
                address           : address_val,
                owner             : owner_val,
                tin               : tin,
                vat_status        : vatStatus,
                registrationDate  : registrationDate,
                attachment        : file_name
            },
            success: function(data) {
                updaterecord_flag = 0;
                var checker = data.validationMessage;

                if (checker == "unable") {
                    alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                    pul_refresh_table();
                } else {
                    
                    updateLogScreen();
                    
                    if(id_val==""){
                        myjstbl_pul.add_new_row();
                        myjstbl_pul.getelem_by_rowindex_tdclass(
                            myjstbl_pul.get_row_count() - 1,
                            colarray_pul['coldelete'].td_class
                        )[0].style.display = "none";

                        var formData = new FormData();
                        var files = $('#iniimgupload')[0].files[0];
                        formData.append("id", data[1]);
                        formData.append('file', files);
               
                        $.ajax({
                            url: "<?=base_url()?>CORModule/uploadImages",
                            type: 'post',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response){
                            },
                        });
                    }

                    $lastrow = myjstbl_pul.get_row_count() - 1
                    myjstbl_pul.update_row_with_value(row_index,data);
                    refresh_datepicker($lastrow);
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

    function checkStatus()
    {
        var clientDetailsId = myjstbl_pul.getvalue_by_rowindex_tdclass(
            $("#row-index-status").val(),
            colarray_pul['id_pul'].td_class
        )[0];

        $.ajax({
            type: "POST",
            async: true,
            url: "<?=base_url()?>CORModule/checkStatus",
            data: {
                id: clientDetailsId
            },
            success: function(data)
            {
                var obj = JSON.parse(data);

                if (obj.validationMessage == "unable") {
                    alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                    pul_refresh_table();
                    $("#client-status").modal('hide');
                } else {
                    $("#client-status").modal('hide');
                }
            }
        });
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
            url: "<?=base_url()?>CORModule/saveStatus",
            data: {
                id: clientDetailsId,
                status: statusValue
            },
            success: function(data)
            {
                var obj = JSON.parse(data);

                updaterecord_flag = 0;

                if (obj.validationMessage == "unable") {
                    alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                    pul_refresh_table();
                    $("#client-status").modal('hide');
                } else {
                   var imageFileName = statusImages[statusValue];

                    myjstbl_pul.setvalue_to_rowindex_tdclass(
                        ["<img src='assets/images/"+imageFileName+"' style='height: 20px; width: 20px;'>"],
                        $("#row-index-status").val(),
                        colarray_pul['columnImageStatus'].td_class
                    );
                    $("#client-status").modal("hide");
                    updateLogScreen();
                }
                
            }
        });
    }

	//Delete Function For PUL Table
	$('.imgdel').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
       var businessname_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['BusinessName'].td_class)[0];

		var answer = confirm("Are you sure you want to delete?");
		if(answer==true){
			$.get("<?=base_url()?>CORModule/delete_control",
			{
                id : id_val,
                businessname : businessname_val
             },
			function(data){
                const checker = JSON.parse(data);

                if (checker.validationMessage == "unable") {
                    alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                    pul_refresh_table();
                } else {
                    //$('#lblStatus').css('visibility', 'visible');
                    myjstbl_pul.delete_row(row_index);
                    //$('#lblStatus').text("Removed!");
                    //myjstbl_pul.add_new_row();
                    myjstbl_pul.getelem_by_rowindex_tdclass(
                        myjstbl_pul.get_row_count() - 1,
                        colarray_pul['coldelete'].td_class
                    )[0].style.display = "none";

                    updateLogScreen();
                }
			});
		}
	});

	function pul_refresh_table() {
	  myjstbl_pul.clean_table();
      var search_val = $.trim($('#txtsearch').val());

    $('#lblStatus').css('visibility', 'hidden');
        $.getJSON("<?=base_url()?>CORModule/pul_refresh",
            {
                filterStatus: $('#filter-status').val(),
                filterType: $("#filter-type").val(),
                orderBy: $("#filter-orderby").val(),
                buttonToggle: $("#button-toggle").val(),
                search: search_val,
                clientgroupid : $("#filterclientgroup").val()
            },
            function(data) {
                myjstbl_pul.insert_multiplerow_with_value(1,data);

                isFirstLoad = false;
                var countResult = Object.keys(data).length;

                for (var index = 1; index <= countResult; index++) {

                    var type_val = data[index-1][9];

                    if (type_val == 0) {
                        myjstbl_pul.getelem_by_rowindex_tdclass(index,
                        colarray_pul['columnImageStatus'].td_class)[0].removeAttribute("onclick");

                        myjstbl_pul.getelem_by_rowindex_tdclass(index,
                        colarray_pul['colupdate'].td_class)[0].setAttribute("hidden", "hidden");

                        myjstbl_pul.getelem_by_rowindex_tdclass(index,
                        colarray_pul['coldelete'].td_class)[0].setAttribute("hidden", "hidden");
                    }
                    
                }

                myjstbl_pul.add_new_row();
                myjstbl_pul.setvalue_to_rowindex_tdclass(
                    ["<img src='assets/images/"+statusImages[1]+"' style='height: 20px; width: 20px;'>"],
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['columnImageStatus'].td_class
                );
                myjstbl_pul.getelem_by_rowindex_tdclass(
                    myjstbl_pul.get_row_count() - 1,
                    colarray_pul['coldelete'].td_class
                )[0].style.display = "none";

                $(".textRegistrationDate").last().datepicker();
                $(".textRegistrationDate").last().datepicker("option","dateFormat", "yy-mm-dd" );



            });
    }

    function show_imgs(rowObj)
    {
        filelist_reset();

        if(rowObj !== 0){
            var row_index = $(rowObj).parent().parent().index();
            var row_index_val = row_index;
            var values_arr = myjstbl_pul.get_row_values(row_index);
            var id_val = values_arr[colarray_pul['id_pul'].td_class][0];
        }
        else{
            var id_val = $("#cor_id_val").val();
        }

        $("#cor_id_val").val(id_val);

        $('#imgPreview_tr').remove();

        $.getJSON("<?=base_url()?>CORModule/getCorImg",
        { 
            corid : id_val
        },
        function(data) {
            myjstbl_pul_img.clear_table();
            myjstbl_pul_img.isRefreshFilterPage = false;
            myjstbl_pul_img.insert_multiplerow_with_value(1,data.data);

            var countResult = data.count;
            var type_val_data = data.is_available;
            if (type_val_data == 0) {
                $('#upload-file-button').prop( "disabled", true );
                $("#file-upload-cor-mul").prop( "disabled", true );
            } else {
                monitor_img_count(data.count);
            }

            for (var index = 1; index <= countResult; index++) {

                if (type_val_data == 0) {
                    myjstbl_pul_img.getelem_by_rowindex_tdclass(index,
                    colarray_pul_img['colupdate_cor'].td_class)[0].setAttribute("hidden", "hidden");

                    myjstbl_pul_img.getelem_by_rowindex_tdclass(index,
                    colarray_pul_img['coldelete_cor'].td_class)[0].setAttribute("hidden", "hidden");
                }
            }
        });
    }

    function save_images_details(rowObj){
        var row_index = $(rowObj).parent().parent().index();
        var values_arr = myjstbl_pul_img.get_row_values(row_index);

        var imgId_cor = values_arr[colarray_pul_img['spnimage_id'].td_class][0];
        var imageName_cor = values_arr[colarray_pul_img['imagename_cor'].td_class][0];
        var remarks_cor = values_arr[colarray_pul_img['remarks_cor'].td_class][0];
        var headId_cor = values_arr[colarray_pul_img['spncor_id'].td_class][0];

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url()?>CORModule/saveImageDetailsCor",
            data: {
                imageId:   imgId_cor,
                imageName: imageName_cor,
                remarks:   remarks_cor,
                corId:     headId_cor
            },
            success: function(data)
            {
                var checker = data.validationMessage;

                if (checker == "unable") {
                    alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                    pul_refresh_table();
                    $("#myModal3").modal('hide');
                } else {
                    myjstbl_pul_img.clear_table();
                    myjstbl_pul_img.isRefreshFilterPage = false;
                    myjstbl_pul_img.insert_multiplerow_with_value(1,data.data);
                    monitor_img_count(data.count);
                }
            },
            complete: function()
            {
                updaterecord_flag = 0;
                updateLogScreen();
                clear_highlight(1);
            }
        });
    }

    function edit_images_details( myTable, rowObj){

        if (updaterecord_flag != 0) {
            return;
        }
        updaterecord_flag = 1;

        var rowindex = $(rowObj).parent().parent().index();
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');

        clear_highlight();
    }

    function update_cor_multiple(){ // multiple
        var id_val = $("#cor_id_val").val();

        var image = $("#file-upload-cor-mul")[0].files;
        var img_len = image.length;
        if(img_len == 0){
            alert("Image upload cannot be empty")
            return;
        }

        var has_invalid = 0;
        for (var i = 0; i < img_len; i++) {
            var splitFileName = image[i].name.split(".");
            if ($.inArray(splitFileName[splitFileName.length - 1].toLowerCase(), ["jpeg", "jpg", "png"]) == -1) {
                has_invalid = 1;
            }
        }

        if(has_invalid){
            alert("Image(s) file type in invalid only accepts 'jpeg', 'jpg', 'png' only");
            return;
        }
        else{
            var formData = new FormData();
            formData.append("id", id_val);

            for (var i = 0; i < img_len; i++) {
                file = $('#file-upload-cor-mul')[0].files[i];
                formData.append('file[]', file);
            }

            $.ajax({
                url: "<?=base_url()?>CORModule/uploadImages",
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    const checker = JSON.parse(response);

                    if (checker.validationMessage == "unable") {
                        alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                        pul_refresh_table();
                        $("#myModal3").modal('hide');
                    } else {
                        show_imgs(0);
                        filelist_reset();

                        updateLogScreen();
                    }
                }
            });
        }
    }

    function delete_image(myTable, rowObj){
        var rowIndex = $(rowObj).parents("tr").index();
        var imageId = myTable.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray_pul_img['spnimage_id'].td_class
        )[0];
        var imageno = myTable.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray_pul_img['number_cor'].td_class
        )[0];
        var headId = myTable.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray_pul_img['spncor_id'].td_class
        )[0];
        var name = myTable.getvalue_by_rowindex_tdclass(
            rowIndex,
            colarray_pul_img['imagename_cor'].td_class
        )[0];

        if($('.tablerow_cor').length == 1){
            alert("Deletion failed, there should be at least 1 image attachment per COR entry.");
        }
        else{
            var sure = confirm("Are you sure to delete \"" + name + "\"?")
            if(sure){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?=base_url()?>CORModule/deleteImage",
                    data: {
                        imageId : imageId,
                        headId  : headId,
                        name    : name
                    },
                    success: function(data)
                    {
                        var checker = data.validationMessage;

                        if (checker == "unable") {
                            alert("Unable to proceed action, this COR is already USED, the page will refresh automatically after this prompt.");
                            pul_refresh_table();
                            $("#myModal3").modal('hide');
                        } else {
                            myjstbl_pul_img.clean_table();
                            myjstbl_pul_img.insert_multiplerow_with_value(1,data.data);
                            monitor_img_count(data.count);
                        }
                    },
                    complete: function()
                    {
                        updateLogScreen();
                    }
                });
            }
        }
    }

    function cancel_edit(myTable, rowObj){
        clear_highlight();
        var row_index = $(rowObj).parent().parent().index();
        
        updaterecord_flag = 0;
        var imageId = myTable.getvalue_by_rowindex_tdclass(
            row_index,
            colarray_pul_img['spnimage_id'].td_class
        )[0];

        $('#imgPreview_tr').remove();

        $.getJSON("<?=base_url()?>CORModule/getCorImg",
        { 
            imageId : imageId
        },
        function(data) {
            myjstbl_pul_img.setvalue_to_rowindex_tdclass([data.data[0][4]], row_index, 
                                colarray_pul_img["imagename_cor"].td_class);
            myjstbl_pul_img.setvalue_to_rowindex_tdclass([data.data[0][5]], row_index, 
                                colarray_pul_img["remarks_cor"].td_class);
            myjstbl_pul_img.update_row(row_index);

            var type_val_data = data.is_available;
            if (type_val_data == 0) {
                $('#upload-file-button').prop( "disabled", true );
                $("#file-upload-cor-mul").prop( "disabled", true );
            } else {
                monitor_img_count(data.count);
            }
        });
    }

    function clear_highlight(mode = 0){
        $('#cor_table').find("tr:not(.tableheader)").each(function(){

            if(mode == 0){
                if($(this).find('input').length == 0){
                    $(this).removeClass('tr_highlight');
                    $(this).css("background-color", "#fff");
                }
            }
            if(mode == 1){
                if(!$(this).hasClass("tr_highlight")){
                    $(this).css("background-color", "#fff");
                }
            }
            /*else if(mode == 2){
                $(this).removeClass('tr_highlight');
                $(this).css("background-color", "#fff");
            }*/
        });
    }

    function monitor_img_count(img_count){
        $("#image_count").val(img_count);

        if(img_count >= IMAGE_COUNT_LIMIT){
            disable_upload();
        }
        else{
            enable_upload();
        }
    }

    function filelist_reset(){
        $("#file-upload-cor-mul").val("");

        var html = "<div><ul><li>No file chosen</li></ul></div>";
        $('#filname-list').html(html);
    }

    function disable_upload(){
        $('#upload-file-button').attr("disabled", true);
        $("#file-upload-cor-mul").attr("disabled", true);
    }

    function enable_upload(){
        $('#upload-file-button').removeAttr("disabled");
        $("#file-upload-cor-mul").removeAttr("disabled");
    }

    function hide_img_upload(row_index){

    }

    $( document ).ready(function() {
        myjstbl_pul_img = new my_table(tab_pul_img, colarray_pul_img, {ispaging : false,
                                                iscursorchange_when_hover : false});
        var root_pul_img = document.getElementById("tbl_pul_cor");
        root_pul_img.appendChild(myjstbl_pul_img.tab);
        myjstbl_pul_img.clean_table();

        $("#lbl_img_limit").html(IMAGE_COUNT_LIMIT);

        $('#tbl_pul_cor').on("click", "#cor_table tr td.tdclick", function() {

            $('#imgPreview_tr').remove();
            var insertAfterTr = $(this).parent();
            clear_highlight();

            var altVal = insertAfterTr.find("td.tdname_cor span").text();
            var imgLoc = insertAfterTr.find("td.tdimg_location span").text();
            var source = "application/views/image_view.php?pathto=";
            source += "<?php echo rawurlencode(CLIENT_DETAILS_ATTACHMENTS_LOCATION); ?>&filename=";
            source += encodeURI(imgLoc);

            var imgPreview = $("<tr id='imgPreview_tr'><td colspan='3'><img id='imgPreview' src='"+ source +"' alt='"+ altVal +"'></td><td colspan='2'><span class='ins'>*Mouse over to magnify the image</span></td></tr>");            

            // imgPreview.insertAfter(insertAfterTr);
            $('#cor_table').append(imgPreview);
            insertAfterTr.addClass('tr_highlight');
        });

        $('#upload-file-button').on('click', function(){
            update_cor_multiple();
        });

        $('#file-upload-cor-mul').on("change", function(e){
            var files = e.target.files;
            var img_count = parseInt($("#image_count").val());

            if((img_count + files.length) > 6){
                filelist_reset();
                alert("You have reached maximum number of attachments. You cannot add further.");
            }
            else{
                var html = "<div><ul>";
                if(files.length > 0){
                    for (var i = 0; i < files.length; i++) {
                        html += "<li>"+ files[i].name +"</li>";
                    }
                }
                else{
                    html = "<ul><li>No file chosen</li></ul>";
                }
                html += "</ul></div>";

                $('#filname-list').html(html);
            }
        });

        $('#myModal3').on('hidden.bs.modal', function () {
            filelist_reset();
            updaterecord_flag = 0;
        });
    });

</script>