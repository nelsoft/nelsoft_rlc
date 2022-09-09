<script language="javascript" type="text/javascript">
    // P.U.L Table
    var myjstbl_pul;
    var tab_pul = document.createElement('table');
    tab_pul.id="tableid_pul";
    tab_pul.className = "table table-bordered";

    var colarray_pul = [];
	
	var id_pul = document.createElement('span');
    colarray_pul['id_pul'] = { 
        header_title: "id",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid",
        headertd_class : "tdclick tdid"
    };
	
	var ref_id = document.createElement('span');
	var txtref_id = document.createElement('input');
    colarray_pul['ref_id'] = { 
        header_title: "Reference ID",
        edit: [ref_id],
        disp: [ref_id],
        td_class: "tablerow tdref_id",
        headertd_class : "tdclick tdref_id"
    };
	
	var mem_id = document.createElement('span');
	var txtmembership = document.createElement('input');
	txtmembership.id = 'membershiptxt';
    txtmembership.className = 'membershiptxt';
    colarray_pul['mem_id'] = { 
        header_title: "Membership ID",
        edit: [txtmembership],
        disp: [mem_id],
        td_class: "tablerow tdmem_id",
        headertd_class : "tdclick tdmem_id"
    };
	
    var datetime_pul = document.createElement('span');
	var txtdatetime_pul = document.createElement('input');
	txtdatetime_pul.type = "text";
    txtdatetime_pul.id = 'datetime_pul';
    txtdatetime_pul.className = 'datetime_pul';
    colarray_pul['datetime_pul'] = { 
        header_title: "Date Time",
        edit: [txtdatetime_pul],
        disp: [datetime_pul],
        td_class: "tablerow tddatetime_pul",
		headertd_class : "hddatetime_pul tdclick"
    };
	
	var type_pul = document.createElement('span');
	var typetxt = document.createElement('select');
	var option  = "<select><option value='1'>Load Point</option>"
					//+"<option value='2'>Membership Charge</option>"
					//+"<option value='3'>System Update</option>"
					//+"<option value='4'>Hamachi Costing</option>"
					//+"<option value='5'>Dropbox Costing</option>"
					//+"<option value='6'>Dev Special Service</option>"
					//+"<option value='7'>Tech Special Service</option></select>";
	typetxt.innerHTML=option;
	type_pul = typetxt.cloneNode(true);
	type_pul.disabled = "disabled";
	typetxt.id = 'typeselect';
	typetxt.className = 'typeselect';
	typetxt.disabled = "disabled";
    colarray_pul['type_pul'] = { 
        header_title: "Type",
        edit: [typetxt],
        disp: [type_pul],
        td_class: "tablerow tdtype_pul",
        headertd_class : "hdtype_pul tdclick"
    };
	
	var ref_pul = document.createElement('span');
	var reftxt = document.createElement('select');
    reftxt.id = 'reftxt';
    reftxt.className = 'reftxt';
    reftxt.disabled = "disabled";
	// var option  = "<select><option value=''></option>";
	// reftxt.innerHTML=option;
    colarray_pul['ref_pul'] = { 
        header_title: "Reference",
        edit: [reftxt],
        disp: [ref_pul],
        td_class: "tablerow tdref_pul",
        headertd_class : "hdref_pul tdclick"
    };
    
    var spnmemo_pul = document.createElement('span');
	var txtmemo_pul = document.createElement('input');
	txtmemo_pul.type = "text";
    txtmemo_pul.id = 'memo_pul';
    txtmemo_pul.className = 'memo_pul';
    colarray_pul['memo_pul'] = { 
        header_title: "Memo",
        edit: [txtmemo_pul],
        disp: [spnmemo_pul],
        td_class: "tablerow tdmemo_pul",
		headertd_class : "hdmemo_pul tdclick"
    };
	
	var amount_pul = document.createElement('span');
	var txtamount_pul = document.createElement('input');
	txtamount_pul.setAttribute("onkeypress", "return(isNumberKey(event))");
	txtamount_pul.disabled = "disabled";
	txtamount_pul.id = 'amounttxt';
    txtamount_pul.className = 'amounttxt';
    colarray_pul['amount_pul'] = { 
        header_title: "Amount",
        edit: [txtamount_pul],
        disp: [amount_pul],
        td_class: "tablerow tdamount_pul",
        headertd_class : "hdamount_pul tdclick"
    };
	
	var imgUpdate = document.createElement('img');
        imgUpdate.src = "assets/images/iconupdate.png";
        imgUpdate.setAttribute("onclick","pul_update_fnc(this)");
        imgUpdate.style.cursor = "pointer";
    var imgEdit = document.createElement('img');
        imgEdit.src = "assets/images/iconedit.png";
        imgEdit.setAttribute("onclick"," reload_data_fnc(this); NT_editSelectedRow(myjstbl_pul, this);");
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
		company_info();
        // P.U.L
        myjstbl_pul = new my_table(tab_pul, colarray_pul, {ispaging : true,
                                                iscursorchange_when_hover : true});

        var root_pul = document.getElementById("tbl_pul");
        root_pul.appendChild(myjstbl_pul.tab);
        root_pul.appendChild(myjstbl_pul.mypage.pagingtable);
		pul_refresh_table();
		
        $('#datetime_pul').datepicker({dateFormat: 'yy-mm-dd'});   
        $('#datefrom_pul').datepicker({dateFormat: 'yy-mm-dd'});   
        $('#dateto_pul').datepicker({dateFormat: 'yy-mm-dd'});  

        $('#clientselect').chosen();
		
		$('.datetime_pul').live("focusin",function() {			// So that only specific textbox will update date value not the first element
			$('#datetime_pul').removeAttr('id');		//remove all ids date
			$(this).attr("id","datetime_pul");		//give an id for the specific textbox only
			$('#datetime_pul').datepicker({dateFormat: 'yy-mm-dd'});		
		});
		
        $('#btnsearch_pul').click(function() {
            pul_refresh_table();
		});
		
		// Refresh P.U.L Table when combo box change -----
        $("#clientselect").change(function() {
            pul_refresh_table();
			var clientid_val = $('#clientselect').val();
			//alert(clientid_val);
			company_info();
        });
		
        $(".typeselect").live("change",function(){
			var row_index_pul = $(this).parent().parent().index();
			selection($(this).val(), row_index_pul);
			// document.getElementById("amounttxt").disabled=true;
		});
		
		$(".reftxt").live("change",function(){
			var row_index_pul = $(this).parent().parent().index();
			var values_arr = myjstbl_pul.get_row_values(row_index_pul);
			var type_id = values_arr[colarray_pul["type_pul"].td_class][0];
			ref_selection($(this).val(), row_index_pul, type_id);
		});
		// alert(membershipdata);
		// document.getElementById("imgexp").style.visibility="hidden";
		//auto date range from and to
		/*
		now = new Date();
        var currentmonth = now.getMonth()+1;
        
        if(currentmonth < 10){
            now = now.getFullYear() +"-0"+ (now.getMonth() + 1) +"-01";
            document.getElementById("datefrom_pul").value = now;
        }
        else{
            now = now.getFullYear() +"-"+ (now.getMonth() + 1) +"-01";
            document.getElementById("datefrom_pul").value = now;
        }
        
        var lastdayofthemonth = new Date();
        lastdayofthemonth = new Date(lastdayofthemonth.getFullYear(), lastdayofthemonth.getMonth() + 1, 0);      
        var currentmonth = lastdayofthemonth.getMonth()+1;
        
        if(currentmonth < 10){
            lastdayofthemonth = lastdayofthemonth.getFullYear() +"-0"+ (lastdayofthemonth.getMonth() + 1) +"-"+lastdayofthemonth.getDate();
            document.getElementById("dateto_pul").value = lastdayofthemonth;
        }
        else{
            lastdayofthemonth = lastdayofthemonth.getFullYear() +"-"+ (lastdayofthemonth.getMonth() + 1) +"-"+lastdayofthemonth.getDate();
            document.getElementById("dateto_pul").value = lastdayofthemonth;
        }      */  
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
			if( $(":input[id^=datetime_pul]").length > 1)
				$(".edit_pul").removeAttr("onclick");
		});
	function company_info(){
		/*
		var clientid_val = $('#clientselect').val();
        $.getJSON("<?=base_url()?>pointusagelog/client_header",
            {  clientid: clientid_val },
            function(data) { 
               // document.getElementById("clientname").innerHTML = "Client Name: "+data[0];
                document.getElementById("clientrempoints").innerHTML = "Remaining Balance: "+data[0];
                //document.getElementById("clientdropexpdate").innerHTML = "Dropbox Expiration Date: "+data[2];
        });*/
    }
	
    function selection(type,row_index_pul) { 
		var clientid_val = $('#clientselect').val();
        var values_arr = myjstbl_pul.get_row_values(row_index_pul);
		var type_id = values_arr[colarray_pul["type_pul"].td_class][0];
		var ref_id_val = values_arr[colarray_pul["ref_id"].td_class][0];
		var index_pul = row_index_pul + 1;
		// var membershipdata = 0;
		$("#amounttxt").val("");
		document.getElementById("amounttxt").disabled=true;
		   if(type==1 ){
				document.getElementById("amounttxt").disabled=false;
				 $.get("<?=base_url()?>pointusagelog/loadpoint_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
					//$("#reftxt").html(data);
					if(data!="error")
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
					else
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
					// alert(ref);
				});
			 }else if(type==2){
				//document.getElementById("amounttxt").disabled=true;
				$.ajax({
						dataType: "json",
						url: "<?=base_url()?>pointusagelog/memcharge_control",
						data: {id: clientid_val, refid: ref_id_val},
						async: false,
						cache: false,
						success: function(data) {
							if(data != 'error') {
								ref_id_global=data.refid;
								membershipdata_global=data.mem;
						
								 for(var x=0;x<ref_id_global.length;x++){
									arr[x] = [ref_id_global[x],data.mem[x]];
								 }
								 for (var i=0; i<membershipdata_global.length;i++){
									var memid_val = membershipdata_global[i];
									//alert(memid_val);
									if(memid_val==1){
										// alert(memid_val+"e");
										$("#amounttxt").val(-2500);
										$("#membershiptxt").val(memid_val);
									}else if(memid_val==2){
										$("#amounttxt").val(-5000);
										$("#membershiptxt").val(memid_val);
									}else if(memid_val==3){
										$("#amounttxt").val(-10000);
										$("#membershiptxt").val(memid_val);
									}else{
										$("#amounttxt").val(-20000);
										$("#membershiptxt").val(memid_val);
									}
								}
								$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data.option);
							}else{
								$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
							}
								// alert (arr[0][0]);
						},
					});
			 }else if(type==3){
				document.getElementById("amounttxt").disabled=true;
					$.get("<?=base_url()?>pointusagelog/sysupdate_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
					//$("#reftxt").html(data);
					if(data!="error")
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
					else
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
					$("#amounttxt").val(-1000);
					});
			 }else if(type==4){
				document.getElementById("amounttxt").disabled=true;
					$.get("<?=base_url()?>pointusagelog/hamachi_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
					//$("#reftxt").html(data);
					if(data!="error")
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
					else
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
					$("#amounttxt").val(-15);
					});
			 }else if(type==5){
				document.getElementById("amounttxt").disabled=true;
					$.get("<?=base_url()?>pointusagelog/dropbox_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
					//$("#reftxt").html(data);
					if(data!="error")
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
					else
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
					$("#amounttxt").val(-750);
					});
			 }else if(type==6){
					document.getElementById("amounttxt").disabled=false;
					$.get("<?=base_url()?>pointusagelog/dev_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
					//$("#reftxt").html(data);
					if(data!="error")
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
					else
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
					});
			 }else if(type==7){
					document.getElementById("amounttxt").disabled=false;
					$.get("<?=base_url()?>pointusagelog/tech_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
					//$("#reftxt").html(data);
					if(data!="error")
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
					else
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
					});
			 }
			 // alert(membershipdata);
	} 
	
	function ref_selection(ref,row_index_ref, type_id){
	// alert(ref);
	// alert(row_index_ref);
	// alert(type_id);
		if(type_id==2){
			for(var x=0;x<arr.length;x++){
				// alert(arr[x][0]);
				if(arr[x][0] == ref){
					//alert(arr[x][1]);
					var memid_val=arr[x][1];
					// alert(memid_val);
					if(memid_val==1){
						$("#amounttxt").val(-2500);
						$("#membershiptxt").val(memid_val);
					}else if(memid_val==2){
						$("#amounttxt").val(-5000);
						$("#membershiptxt").val(memid_val);
					}else if(memid_val==3){
						$("#amounttxt").val(-10000);
						$("#membershiptxt").val(memid_val);
					}else{
						$("#amounttxt").val(-20000);
						$("#membershiptxt").val(memid_val);
					}
				}
			}
		}else if(type_id==3)
			$("#amounttxt").val(-1000);
		else if(type_id==4)
			$("#amounttxt").val(-15);
		else if(type_id==5)
			$("#amounttxt").val(-750);
		else
			$("#amounttxt").val("");
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
        var id_val = myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
        var datetime_val = values_arr[colarray_pul["datetime_pul"].td_class][0];
        var type_val = values_arr[colarray_pul["type_pul"].td_class][0];
        var ref_val = values_arr[colarray_pul["ref_pul"].td_class][0];
        var memo_val = values_arr[colarray_pul["memo_pul"].td_class][0];
        var amount_val = values_arr[colarray_pul["amount_pul"].td_class][0];
		var mem_id_val = values_arr[colarray_pul["mem_id"].td_class][0];
		var clientid_val = $('#clientselect').val();
		
		if (!ifEmpty(amount_val, "Amount")) return;
		if (!ifEmpty(datetime_val, "Date Time")) return;
	
		// var hr = datetime_val.substr(11, 2);
		// var mn = datetime_val.substr(14, 2);
		// var sec = datetime_val.substr(17, 7);
		// var timeval=hr+":"+mn+":"+sec;
		var currentTime = new Date();
		var h = currentTime.getHours();
		var m = currentTime.getMinutes();
		var s = currentTime.getSeconds();
		  if(s<=9) s="0"+s;
		  if(m<=9) m="0"+m;
		  if(h<=9) h="0"+h;
		var time_val=h+":"+m+":"+s;
		var datetime_val=datetime_val+" "+time_val;
		document.getElementById("clientrempoints").style.color="black";	
		if(datetime_val.length>19){
			datetime_val=datetime_val.slice(0,-9);
			// alert(datetime_val);
		}
		if(type_val==2){
				if(mem_id_val==1 && amount_val==-2500){
					//alert(mem_id_val+" inside");
					var fnc_pul = "<?=base_url()?>pointusagelog/update_control";
				}else if(mem_id_val==2 && amount_val==-5000){
				//alert(mem_id_val+" inside");
					var fnc_pul = "<?=base_url()?>pointusagelog/update_control";
				}else if(mem_id_val==3 && amount_val==-10000){
				//alert(mem_id_val+" inside");
					var fnc_pul = "<?=base_url()?>pointusagelog/update_control";
				}else if(mem_id_val==4 && amount_val==-20000){
				//alert(mem_id_val+" inside");
					var fnc_pul = "<?=base_url()?>pointusagelog/update_control";
				}else{
					$('#lblStatus').css('visibility', 'visible');
					$('#lblStatus').text("Invalid Amount Value!");
					//$("#alerterror").fadeOut( 4000, "linear");
					// return;
				}
			}else if(type_val == 6 || type_val == 7 ){
				if(amount_val<0){
					var fnc_pul = "<?=base_url()?>pointusagelog/update_control";
				}else{
					$('#lblStatus').css('visibility', 'visible');
					$('#lblStatus').text("Invalid Amount Value!");
					//$("#alerterror").fadeOut( 8000, "linear");
					// return;
				}
			}else
				var fnc_pul = "<?=base_url()?>pointusagelog/update_control";
		
		if(id_val==""){
			// alert(mem_id_val);
			// alert(ref_val);
			if(ref_val != ""){
				if(type_val==2){
					if(mem_id_val==1 && amount_val==-2500){
						var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
					}else if(mem_id_val==2 && amount_val==-5000){
						var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
					}else if(mem_id_val==3 && amount_val==-10000){
						var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
					}else if(mem_id_val==4 && amount_val==-20000){
						var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
					}else{
						$('#lblStatus').css('visibility', 'visible');
						$('#lblStatus').text("Invalid Amount Value!");
						//$("#alerterror").fadeOut( 8000, "linear");
						// return;
					}
				}else if(type_val == 4 || type_val == 6 || type_val == 7 ){
						if(amount_val<0){
							var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
						}else{
							$('#lblStatus').css('visibility', 'visible');
							$('#lblStatus').text("Invalid Amount Value!");
							//$("#alerterror").fadeOut( 8000, "linear");
							return;
						}
				}else
					var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
				// if(type_val==1 || type_val==2 || type_val==6 || type_val==7)
					// var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
				// else if(type_val==3 && amount_val==1000)
					 // var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
				// else if(type_val==4 && amount_val==15)
					 // var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
				// else if(type_val==5 && amount_val==750)
					// var fnc_pul = "<?=base_url()?>pointusagelog/create_control";
			}else{
				$('#lblStatus').css('visibility', 'visible');
				$('#lblStatus').text("No Reference!");
				//$("#alerterror").fadeOut( 8000, "linear");
			}
		}
		$.getJSON(fnc_pul,
			{
			id:id_val,
			clientid: clientid_val,
			datetime: datetime_val,
			typeid: type_val,
			refid: ref_val,
			memo: memo_val,
			amount: amount_val
			},
	  
			function(data) {
				if(data.errordisplay=="error"){
					$('#lblStatus').css('visibility', 'visible'); 
					$('#lblStatus').text("Insufficient Balance!");
					//$("#alerterror").fadeOut( 8000, "linear");
					document.getElementById("clientrempoints").style.color="red";
				}else if(data=="error_amount_loadpoint"){
					$('#lblStatus').css('visibility', 'visible');
					$('#lblStatus').text("Minimum Amount for Load Point is 1000!");
					//$("#alerterror").fadeOut( 4000, "linear");
				}else if(data=="error_reference"){
					$('#lblStatus').css('visibility', 'visible');
					$('#lblStatus').text("No Reference!");
					//$("#alerterror").fadeOut( 4000, "linear");
				}else{
					
					if(id_val=="")
						myjstbl_pul.add_new_row();
					myjstbl_pul.update_row_with_value(row_index,data);
					$('#datetime_pul').last().datepicker({dateFormat: 'yy-mm-dd'});
					
					// One edit at a time, you cannot edit another row while another data is not yet been updated
					if( $(":input[id^=datetime_pul]").length > 1) {
						$(".edit_pul").removeAttr("onclick");
					}
					else {
						$(".edit_pul").attr("onclick","reload_data_fnc(this); NT_editSelectedRow(myjstbl_pul, this);");
					}
					default_selection_reference();
				}
				company_info();
			});	
			
	}
	//Delete Function For PUL Table
	$('.imgdel').live('click',function() {
	   $('#lblStatus').css('visibility', 'hidden');
	   var cnt = myjstbl_pul.get_row_count() - 1;
       var row_index = $(this).parent().parent().index();
	   var id_val=  myjstbl_pul.getvalue_by_rowindex_tdclass(row_index, colarray_pul['id_pul'].td_class)[0];
		// alert(id_val);
		if(row_index==1) {
			$('#lblStatus').css('visibility', 'visible');
			$('#lblStatus').text("Default Log cannot be deleted!");
			//$("#alerterror").fadeOut( 4000, "linear");
           return;
        }else{
			if(id_val==""){
				$('#lblStatus').css('visibility', 'visible');
				$('#lblStatus').text("No value to be deleted!");
				//$("#alerterror").fadeOut( 4000, "linear");
				return;
		   }else{
				var answer = confirm("Are you sure you want to delete the data?");
				if(answer==true){
					myjstbl_pul.delete_row(row_index);
					$.get("<?=base_url()?>pointusagelog/delete_control",
					{id: id_val},
					function(data){
						$('#lblStatus').css('visibility', 'visible'); 
						$('#lblStatus').text("Removed!");
						//$("#alertsuccess").fadeOut( 4000, "linear");
						company_info();
					});
				}
			}
		}
	});
	
	function pul_refresh_table() {
	  myjstbl_pul.clean_table();
      var clientid_val = $('#clientselect').val();
	  var datefrom_val = $('#datefrom_pul').val();
	  var dateto_val = $('#dateto_pul').val();
	  var type=$("#typeselect").val();
	  $('#lblStatus').css('visibility', 'hidden');
		if ((Date.parse(datefrom_val) >= Date.parse(dateto_val))) {
			document.getElementById("lblStatus").innerHTML = "End date should be greater than Start date!";
			return;
		}
        $.getJSON("<?=base_url()?>pointusagelog/pul_refresh",
            { 
                clientid: clientid_val,
				datefrom : datefrom_val,
                dateto : dateto_val
            },
            function(data) { 
				// alert(data[2][0]);
				myjstbl_pul.add_new_row();
                myjstbl_pul.insert_multiplerow_with_value(1,data);	
				$('#datetime_pul').last().datepicker({dateFormat: 'yy-mm-dd'});
				//alert(data);
				default_selection_reference();
				// alert(data);
			});
    }
	function reload_data_fnc(row){
		$('#lblStatus').css('visibility', 'hidden');
        var row_index = $(row).parent().parent().index();
        var row_index_val = row_index;
        var values_arr = myjstbl_pul.get_row_values(row_index);
		var clientid_val = $('#clientselect').val();
		var type_id = values_arr[colarray_pul["type_pul"].td_class][0];
		var ref_id_val = values_arr[colarray_pul["ref_id"].td_class][0];
		var mem_id = values_arr[colarray_pul["mem_id"].td_class][0];
		// alert(ref_id_val);
		var index_pul = row_index + 1;
		
		if(type_id == 1){
			$.get("<?=base_url()?>pointusagelog/loadpoint_control",{id: clientid_val, refid: ref_id_val} ,function (data) {	
				$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
				document.getElementById("amounttxt").disabled=false;
			});
		}else if(type_id == 2){
			// document.getElementById("amounttxt").disabled=true;
			$.ajax({
					dataType: "json",
					url: "<?=base_url()?>pointusagelog/memcharge_control",
					data: {id: clientid_val, refid: ref_id_val},
					// async: false,
					cache: false,
					success: function(data) {
						if(data != 'error') {
							ref_id_global=data.refid;
							membershipdata_global=data.mem;
							 for(var x=0;x<ref_id_global.length;x++){
								arr[x] = [ref_id_global[x],data.mem[x]];
							 }
							 for (var i=0; i<membershipdata_global.length;i++){
								var memid_val = membershipdata_global[i];
							}
						$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data.option);
						}else{
							$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html("");
						}
					},
				});
			
		}else if(type_id == 3){
			$.get("<?=base_url()?>pointusagelog/sysupdate_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
			$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
			});
		}else if(type_id == 4){
			$.get("<?=base_url()?>pointusagelog/hamachi_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
			$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
			});
		}else if(type_id == 5){
			$.get("<?=base_url()?>pointusagelog/dropbox_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
			$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
			});
		}else if(type_id == 6){
			// document.getElementById("amounttxt").disabled=false;
			$.get("<?=base_url()?>pointusagelog/dev_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
			$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
			document.getElementById("amounttxt").disabled=false;
			});
		}else if(type_id == 7){
			$.get("<?=base_url()?>pointusagelog/tech_control",{id: clientid_val, refid: ref_id_val} ,function (data) {
			$('#tableid_pul tr:nth-child('+index_pul+') #reftxt').html(data);
			document.getElementById("amounttxt").disabled=false;
			});
		}
		// alert(ref_id_val);
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
	function default_selection_reference(){
		// var row_index_pul = $(this).parent().parent().index();
		// alert(row_index_pul);
		var clientid_val = $('#clientselect').val();
		var cnt = myjstbl_pul.get_row_count() - 1;
		//alert(cnt);
		for(x=1;x<=cnt;x++){
			var values_arr = myjstbl_pul.get_row_values(x);
			var type_val = values_arr[colarray_pul["type_pul"].td_class][0];
			var ref_id_val = values_arr[colarray_pul["ref_id"].td_class][0];
			//alert(type_val);
		}
		if(type_val==1){
				document.getElementById("amounttxt").disabled=false;
				 $.get("<?=base_url()?>pointusagelog/loadpoint_control",{id: clientid_val, refid: ref_id_val } ,function (data) {
					$("#reftxt").last().html(data);
					//$('#tableid_pul tr:nth-child('+cnt+') #reftxt').html(data);
				});
		}
	}
</script>