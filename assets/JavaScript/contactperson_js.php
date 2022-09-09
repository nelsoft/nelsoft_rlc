<script language="javascript" type="text/javascript">
    <?php 
        $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
    ?>

    // P.U.L Table
    var myjstbl_pul;
    var tab_pul = document.createElement('table');
    tab_pul.id="tableid_pul";
    tab_pul.className = "table table-bordered";

    var colarray_pul = [];
	
	var id_pul = document.createElement('span');
    colarray_pul['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid",
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
        header_title: "FullName",
        edit: [txtname],
        disp: [spnname],
        td_class: "tablerow tdname",
		headertd_class : "hdname tdclick"
    };

    var spncontactno = document.createElement('span');
    var txtcontactno = document.createElement('input');
    txtcontactno.type = "text";
    txtcontactno.id = 'idtxtcontactno';
    txtcontactno.className = 'txtcontactno';
    colarray_pul['contactno'] = { 
        header_title: "contactno",
        edit: [txtcontactno],
        disp: [spncontactno],
        td_class: "tablerow tdcontactno",
        headertd_class : "hdcontactno tdclick"
    };

    var spndescription = document.createElement('span');
    var txtdescription = document.createElement('input');
    txtdescription.type = "text";
    txtdescription.id = 'idtxtdescription';
    txtdescription.className = 'txtdescription';
    colarray_pul['description'] = { 
        header_title: "description",
        edit: [txtdescription],
        disp: [spndescription],
        td_class: "tablerow tddescription",
        headertd_class : "hddescription tdclick"
    };

    var sellanguage = document.createElement('select');
    sellanguage.className = "sellanguage";
    sellanguage.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    sellanguage.innerHTML = '<option value="0"></option><option value="1">Chinese</option><option value="2">Fil/Eng</option><option value="3">Chi/Fil/Eng</option>';
    var sellanguage_disp = sellanguage.cloneNode(true);
    sellanguage_disp.disabled = "disabled";
    colarray_pul['language'] = { 
        header_title: "language", 
        edit: [sellanguage], 
        disp: [sellanguage_disp], 
        td_class: "tablerow tdlanguage",
        headertd_class : "hdlanguage"
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
	
	//delete
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

	var arr = [];
    $(function() {
        // P.U.L
        myjstbl_pul = new my_table(tab_pul, colarray_pul, {ispaging : true,
                                                iscursorchange_when_hover : true});

        var root_pul = document.getElementById("tbl_pul");
        root_pul.appendChild(myjstbl_pul.tab);
        root_pul.appendChild(myjstbl_pul.mypage.pagingtable);
		
        
        $("#filterclientgroup").val(<?=$clientgroupid?>);
        pul_refresh_table();
		$("#txtsearch").keypress( 
		function(e){
			if(e.keyCode == 13)
			{
				pul_refresh_table();
			}
		});
        $("#filterclientgroup").change( 
        function(){
                pul_refresh_table();
        });

        $("#createnew").click(function(){
            myjstbl_pul.mypage.go_to_last_page(); 
            $(".txtname").last().focus();
        });


		
        $("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

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

    function editSelectedRow( myTable, rowObj){
        var rowindex = $(rowObj).parent().parent().index();
        myTable.edit_row(rowindex);
        $('#lblStatus').css('visibility', 'hidden');
        set_tbl_element_events();
    }

	function set_tbl_element_events() {
		my_autocomplete_add(".txtclientgroup_name", "<?=base_url()?>contactperson/ac_clientgroupid", {
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
        var clientgroupid_val= values_arr[colarray_pul['clientgroup_id'].td_class][0];
        var name_val = values_arr[colarray_pul['name'].td_class][0];
        var contactno_val= values_arr[colarray_pul['contactno'].td_class][0];
        var description_val= values_arr[colarray_pul['description'].td_class][0];
        var language_val= values_arr[colarray_pul['language'].td_class][0];

		var fnc_pul = "<?=base_url()?>contactperson/update_control";
        if (id_val == "")
        	fnc_pul = "<?=base_url()?>contactperson/insert_control";

		$.getJSON(fnc_pul,
			{
			id:id_val,
			clientgroupid: clientgroupid_val,
			name: name_val,
			contactno: contactno_val,
            description: description_val,
            languageid: language_val
			},
			function(data) {
				if(data == "error"){
					$('#lblStatus').css('visibility', 'visible'); 
					$('#lblStatus').text("Insufficient Balance!");
				}
				else{
					if(id_val=="")
						myjstbl_pul.add_new_row();
						set_tbl_element_events();
						myjstbl_pul.update_row_with_value(row_index,data);
				}
			});	
			
	}
	//Delete Function For PUL Table
	$('.imgdel').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
		
		var answer = confirm("Are you sure you want to delete?");
		if(answer==true){
			myjstbl_pul.delete_row(row_index);
			$.get("<?=base_url()?>contactperson/delete_control",
			{id: id_val},
			function(data){
				$('#lblStatus').css('visibility', 'visible'); 
				myjstbl_pul.delete_row(row_index);
				$('#lblStatus').text("Removed!");
                myjstbl_pul.add_new_row();
			});
		}
	});
	
	function pul_refresh_table() {
	  myjstbl_pul.clean_table();
      var search_val = $.trim($('#txtsearch').val());

	  $('#lblStatus').css('visibility', 'hidden');
        $.getJSON("<?=base_url()?>contactperson/pul_refresh",
            { 
                search: search_val,
                clientgroupid : $("#filterclientgroup").val()
            },
            function(data) { 
				myjstbl_pul.add_new_row();
				set_tbl_element_events();
                myjstbl_pul.insert_multiplerow_with_value(1,data);	
			});
    }
	
</script>