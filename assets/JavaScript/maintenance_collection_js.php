<script language="javascript" type="text/javascript">
    
    var myjstbl_detail;
    var tab_detail = document.createElement('table');
    tab_detail.id="tableid_detail";
    tab_detail.className = "table table-bordered tbl-design";

    var colarray_detail = [];
	
	var id_detail = document.createElement('span');
    colarray_detail['id_detail'] = { 
        header_title: "ID",
        edit: [id_detail],
        disp: [id_detail],
        td_class: "tablerow tdid",
        headertd_class : "tdid"
    };

    var selclientdetail = document.createElement('select');
    selclientdetail.className = "selclientdetail";
    selclientdetail.innerHTML = '<option value="0">none</option>';
    var selclientdetail_disp = selclientdetail.cloneNode(true);
    selclientdetail_disp.disabled = "disabled";
	selclientdetail_disp.style = "display:none";
    colarray_detail['clientdetail'] = { 
        header_title: "Branch", 
        edit: [selclientdetail], 
        disp: [selclientdetail], 
        td_class: "tablerow tdclientdetail"
    };


    var spndatestart = document.createElement('span');
    colarray_detail['datestart'] = { 
        header_title: "Date Start",
        edit: [spndatestart],
        disp: [spndatestart],
        td_class: "tablerow tddatestart",
        headertd_class : "hddatestart"
    };

    var spnmonthspaid = document.createElement('span');
    colarray_detail['monthspaid'] = { 
        header_title: "Paid",
        edit: [spnmonthspaid],
        disp: [spnmonthspaid],
        td_class: "tablerow tdmonthspaid",
        headertd_class : "hdmonthspaid"
    };

    var spnexpire_at = document.createElement('span');
    colarray_detail['expire_at'] = { 
        header_title: "Expired at",
        edit: [spnexpire_at],
        disp: [spnexpire_at],
        td_class: "tablerow tdexpire_at",
        headertd_class : "hdexpire_at"
    };

    var spnis_expire = document.createElement('span');
    colarray_detail['is_expire'] = { 
        header_title: "Expired?",
        edit: [spnis_expire],
        disp: [spnis_expire],
        td_class: "tablerow tdis_expire",
        headertd_class : "hdis_expire"
    };

    var spnquantity = document.createElement('span');
	var txtquantity = document.createElement('input');
	txtquantity.type = "text";
    txtquantity.id = 'idtxtquantity';
    txtquantity.className = 'txtquantity';
    colarray_detail['quantity'] = { 
        header_title: "Quantity",
        edit: [txtquantity],
        disp: [spnquantity],
        td_class: "tablerow tdquantity",
		headertd_class : "hdquantity"
    };

    var spnprice = document.createElement('span');
	var txtprice = document.createElement('input');
	txtprice.type = "text";
    txtprice.id = 'idtxtprice';
    txtprice.className = 'txtprice';
    colarray_detail['price'] = { 
        header_title: "price",
        edit: [txtprice],
        disp: [spnprice],
        td_class: "tablerow tdprice",
		headertd_class : "hdprice"
    };

    var spnamount = document.createElement('span');
    colarray_detail['amount'] = { 
        header_title: "Amount",
        edit: [spnamount],
        disp: [spnamount],
        td_class: "tablerow tdamount",
        headertd_class : "hdamount"
    };
	

	var imgUpdate = document.createElement('img');
        imgUpdate.src = "assets/images/iconupdate.png";
        imgUpdate.setAttribute("onclick","update_row(this)");
        imgUpdate.style.cursor = "pointer";
    var imgEdit = document.createElement('img');
        imgEdit.src = "assets/images/iconedit.png";
        imgEdit.setAttribute("onclick"," edit_row(myjstbl_detail, this);");
        imgEdit.id = "edit_detail";
		imgEdit.className = "edit_detail";
		imgEdit.style.cursor = "pointer";
        imgEdit.style.display = "none";
        imgEdit.style.display = "block";
    colarray_detail['colupdate'] = { 
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
    colarray_detail['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };

    var arr = [];
	var headid = "";
    $(function() {
        myjstbl_detail = new my_table(tab_detail, colarray_detail, {ispaging : false,
												tdhighlight_when_hover : "tablerow",
                                                iscursorchange_when_hover : true});

        var root_detail = document.getElementById("tbl_detail");
        root_detail.appendChild(myjstbl_detail.tab);

        $('#dt_date').datepicker({dateFormat: 'yy-mm-dd'}).datepicker("setDate", new Date());
        $("#sel_client_group").chosen({
            no_results_text: "Not found",
            add_item_enable: false});

        $("#sel_client_group").change(function(){
            refresh_branch_ddl();
        });
        var headDiscount = 0;
        var headAdjust = 0;
        var head_id_val = $("#head_id").val();
        if(head_id_val != '' && head_id_val > 0){
        	$.getJSON("<?=base_url()?>maintenance_collection/get_data",
            { 
                headid: head_id_val
            },
            function(data) { 
            	$("#dt_date").val(data.date);
		    	$("#sel_client_group").val(data.client_group_id);
		    	$("#sel_client_group").trigger("liszt:updated");
		    	$("#txt_dr_number").val(data.dr_number);
		    	$("#sel_status").val(data.status);
            	//alert(data.detail_data[0]);
            	selclientdetail.innerHTML = data.branch_ddl_options;
                myjstbl_detail.insert_multiplerow_with_value(1,data.detail_data);	
                myjstbl_detail.add_new_row();
                refresh_td_click_event();
                headDiscount = data.discount;
                headAdjust = data.adjust;
                refresh_total_amount(headDiscount, headAdjust);
			});
        }
        else {
        	myjstbl_detail.add_new_row();
            refresh_td_click_event();
        }

        $("#btn_save").click(function(){
        	save_all(0);
        });

        $("#btn_save_add_new").click(function(){
            save_all(1);
        });

        $("#btn_apply").click(function(){
            var pay_upto_year = $("#sel_pay_upto_year").val();
            var pay_upto_date = new Date(pay_upto_year + "-01-01");

            var cnt = myjstbl_detail.get_row_count();
            for(var ctr = 0; ctr < cnt-2; ctr ++) {
                myjstbl_detail.edit_row(ctr+1);

                var values_arr = myjstbl_detail.get_row_values(ctr+1);
                var expire_at = values_arr[colarray_detail['expire_at'].td_class][0];
                var date_expire_at = new Date(expire_at);

                var months;
                months = (pay_upto_date.getFullYear() - date_expire_at.getFullYear()) * 12;
                months -= date_expire_at.getMonth();
                months += pay_upto_date.getMonth();
                months = months <= 0 ? 0 : months;

                myjstbl_detail.setvalue_to_rowindex_tdclass([months],ctr+1,colarray_detail['quantity'].td_class);
            }

            refresh_td_click_event();
            refresh_total_amount(headDiscount, headAdjust);
        });
        
    });

    function refresh_branch_ddl() {
    	var selected_client_group_id = $("#sel_client_group").val();

        $.get("<?=base_url()?>maintenance_collection/refresh_cleintdetail_by_clientgroupid_ddl",
        {
            client_group_id : selected_client_group_id
        },
        function(data){
        	$(".selclientdetail").html(data);
        	selclientdetail.innerHTML = data;

            myjstbl_detail.clear_table();
            $.getJSON("<?=base_url()?>maintenance_collection/get_all_branch",
            {
                client_group_id : selected_client_group_id
            },
            function(data){
                selclientdetail.innerHTML = data.branch_ddl_options;
                myjstbl_detail.insert_multiplerow_with_value(1,data.detail_data); 

                var cnt = myjstbl_detail.get_row_count();
                for(var ctr = 0; ctr < cnt-1; ctr ++) {
                    myjstbl_detail.edit_row(ctr+1);
                }

                myjstbl_detail.add_new_row();
                refresh_td_click_event();
                refresh_total_amount(headDiscount, headAdjust);
            });

        });

        
    }

    function refresh_total_amount(discount, adjust) {
        var cnt = myjstbl_detail.get_row_count() - 1;
        var total_amount = 0;
        for(var ctr = 0; ctr < cnt-1; ctr ++) {
            var values_arr = myjstbl_detail.get_row_values(ctr+1);
            var qty = values_arr[colarray_detail['quantity'].td_class][0];
            var price = values_arr[colarray_detail['price'].td_class][0];
            total_amount += qty * price;
        }
        total_amount = total_amount * (1 - discount / 100) + parseFloat(adjust);
        $("#spn_total_amount").html(total_amount.formatMoney());
    }

    function update_row(update_elem) {
        var row_index = $(update_elem).parent().parent().index();
        var cnt = myjstbl_detail.get_row_count() - 1;

        var values_arr = myjstbl_detail.get_row_values(row_index);
        var qty = values_arr[colarray_detail['quantity'].td_class][0];
        var price = values_arr[colarray_detail['price'].td_class][0];
        var amount = qty * price;
        myjstbl_detail.setvalue_to_rowindex_tdclass([amount],row_index,colarray_detail['amount'].td_class);

        if(cnt == row_index) {
        	myjstbl_detail.add_new_row();
        }
		myjstbl_detail.update_row(row_index);
        refresh_td_click_event();
        refresh_total_amount(headDiscount, headAdjust);
    }

    function edit_row(mytbl, edit_elem) {
    	var row_index = $(edit_elem).parent().parent().index();
    	myjstbl_detail.edit_row(row_index)
        refresh_td_click_event();
    }

    function save_all(redirect_type) {

    	var head_id_val = 0;
    	if($("#head_id").val() > 0 && $("#head_id").val() != '') {
    		head_id_val = $("#head_id").val();
    	} 
    	var date_val = $("#dt_date").val();
    	var client_group_val = $("#sel_client_group").val();
    	var dr_number_val = $("#txt_dr_number").val();
    	var status_val = $("#sel_status").val();

    	var branch_id_detail_val = [];
    	var quantity_detail_val = [];
    	var price_detail_val = [];
    	var cnt = myjstbl_detail.get_row_count() - 1;
    	for(var ctr = 0; ctr < cnt-1; ctr ++) {
    		var values_arr = myjstbl_detail.get_row_values(ctr+1);
    		branch_id_detail_val[ctr] = values_arr[colarray_detail['clientdetail'].td_class][0];
	    	quantity_detail_val[ctr] = values_arr[colarray_detail['quantity'].td_class][0];
	    	price_detail_val[ctr] = values_arr[colarray_detail['price'].td_class][0];
    	}

    	var data_val = {
    		headid:head_id_val,
			date:date_val,
			clientgroupid: client_group_val,
			drnumber: dr_number_val,
			status: status_val,
            branchid_detail: branch_id_detail_val,
            quantity_detail: quantity_detail_val,
            price_detail: price_detail_val
		};

		var fnc = "<?=base_url()?>maintenance_collection/save_all";
		$.getJSON(fnc,{data : data_val},function(ret_data){
			if(ret_data['status'] != 1){
				//$('#lblStatus').css('visibility', 'visible'); 
				//$('#lblStatus').text("Unable to save.");
			}
			else{
				alert("Saved!");
                if(redirect_type == 1) {
                    window.location = "<?=base_url()?>maintenance_collection";
                }
                else {
                    window.location = "<?=base_url()?>maintenance_collection?headid=" + ret_data['headid'];
                }
				
			}
		});
    	/*
		var fnc_pul = "<?=base_url()?>clienthead/update_control";
        if (id_val == "")
        	fnc_pul = "<?=base_url()?>clienthead/insert_control";

		$.getJSON(fnc_pul,
			{
			id:id_val,
			clientgroupid: clientgroupid_val,
			name: name_val,
			devassigned: devassigned_val,
            techassigned: techassigned_val,
            email: email_val,
            password: password_val,
            memo: memo_val,
            Dropboxdate: Dropboxdate_val
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
			});	*/
    }

    function refresh_td_click_event(){
        $(".imgdel").unbind("click");
        $(".imgdel").click(function(){
            var row_index = $(this).parent().parent().index();
            var answer = confirm("Are you sure you want to delete?");
            if(answer==true){
                myjstbl_detail.delete_row(row_index);
                refresh_total_amount(headDiscount, headAdjust);
            }
        });
    }

</script>