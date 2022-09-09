    <script language="javascript" type="text/javascript">

<?php 
        $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
        $clientheadid = isset($_GET['clientheadid'])?$_GET['clientheadid']:"";
    ?>

    var myjstbl;
    var tab = document.createElement('table');
    tab.id="tableid_pul";
    tab.className = "table table-bordered";

    var colarray = [];
    
    var id_pul = document.createElement('span');
    colarray['id_pul'] = { 
        header_title: "ID",
        edit: [id_pul],
        disp: [id_pul],
        td_class: "tablerow tdid",
        headertd_class : "tdclick tdid"
    };

    var selclientinfo = document.createElement('select');
    selclientinfo.className = "selclientinfo";
    selclientinfo.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selclientinfo.innerHTML = '<?php echo fill_select_options("SELECT CD.`id`, CONCAT(CH.`name`, ' ', COALESCE(CD.`branchid`,''), '-', COALESCE(CD.`branchname`,'')) as  `branchname` FROM clienthead as CH LEFT JOIN clientdetails as CD ON CH.`id`= CD.`clientid` WHERE CD.`show` = 1 ORDER BY CH.`name`, CD.`branchid`", "id", "branchname",0,false); ?>';
    var selclientinfo_disp = selclientinfo.cloneNode(true);
    selclientinfo_disp.disabled = "disabled";
    colarray['colclientinfo'] = { 
        header_title: "Client_Information", 
        edit: [selclientinfo], 
        disp: [selclientinfo_disp], 
        td_class: "tablerow tdclientinfo"
    };

    var spnname = document.createElement('span');
    var txtname = document.createElement('input');
    txtname.type = "text";
    txtname.id = 'idtxtname';
    txtname.className = 'txtname';
    colarray['name'] = { 
        header_title: "name",
        edit: [txtname],
        disp: [spnname],
        td_class: "tablerow tdname",
        headertd_class : "hdname tdclick"
    };

    var spndescription = document.createElement('span');
    var txtdescription = document.createElement('input');
    txtdescription.type = "text";
    txtdescription.id = 'idtxtdescription';
    txtdescription.className = 'txtdescription';
    colarray['description'] = { 
        header_title: "description",
        edit: [txtdescription],
        disp: [spndescription],
        td_class: "tablerow tddescription",
        headertd_class : "hddescription tdclick"
    };

    var spndate_start = document.createElement('span');
    var txtdate_start = document.createElement('input');
    txtdate_start.type = "text";
    txtdate_start.id = 'idtxtdate_start';
    txtdate_start.className = 'txtdate_start';
    colarray['date_start'] = { 
        header_title: "date_start",
        edit: [txtdate_start],
        disp: [spndate_start],
        td_class: "tablerow tddate_start",
        headertd_class : "hddate_start tdclick"
    };
	
	var spndate_setup = document.createElement('span');
    var txtdate_setup = document.createElement('input');
    txtdate_setup.type = "text";
    txtdate_setup.id = 'idtxtdate_setup';
    txtdate_setup.className = 'txtdate_setup';
    colarray['date_setup'] = { 
        header_title: "date_setup",
        edit: [txtdate_setup],
        disp: [spndate_setup],
        td_class: "tablerow tddate_setup",
        headertd_class : "hddate_setup tdclick"
    };
	
	var selmember = document.createElement('select');
    selmember.className = "selmember";
    selmember.setAttribute("onkeypress","return js_fire_tab_when_entered(event, this);");
    selmember.innerHTML = '<?php echo fill_select_options("SELECT M.`id`, M.`name`
																FROM `members` AS M WHERE `id` > 0
																ORDER BY `name`", "id", "name",0,false); ?>';
																	
    var selmember_disp = selmember.cloneNode(true);
    selmember_disp.disabled = "disabled";
    colarray['colmember'] = { 
        header_title: "Member", 
        edit: [selmember], 
        disp: [selmember_disp], 
        td_class: "tablerow tdselmember"
    };
	
	var spninvoice = document.createElement('span');
    var txtinvoice = document.createElement('input');
    txtinvoice.type = "text";
    txtinvoice.id = 'idtxtinvoice';
    txtinvoice.className = 'txtinvoice';
    colarray['invoice'] = { 
        header_title: "Invoice",
        edit: [txtinvoice],
        disp: [spninvoice],
        td_class: "tablerow tdinvoice",
        headertd_class : "hdinvoice tdclick"
    };

    var imgUpdate = document.createElement('img');
        imgUpdate.src = "assets/images/iconupdate.png";
        imgUpdate.setAttribute("onclick","update_fnc(this)");
        imgUpdate.style.cursor = "pointer";
    var imgEdit = document.createElement('img');
        imgEdit.src = "assets/images/iconedit.png";
        imgEdit.setAttribute("onclick"," edit_fnc(this);");
        imgEdit.id = "edit_pul";
        imgEdit.className = "edit_pul";
        imgEdit.style.cursor = "pointer";
        imgEdit.style.display = "none";
        imgEdit.style.display = "block";
    colarray['colupdate'] = { 
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
    colarray['coldelete'] = { 
        header_title: "",
        edit: [imgDelete],
        disp: [imgDelete],
        td_class: "tablerow tddelete",
        headertd_class: "hddelete"
    };
        
    $(function()
    {
        
      
        myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow"});
        var root = document.getElementById("tbl");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);


        myjstbl.mypage.set_mysql_interval(100);
        myjstbl.mypage.isOldPaging = true;
        myjstbl.mypage.pass_refresh_filter_page(search_table);



        $("#txtsearch").keypress( 
        function(e){
            if(e.keyCode == 13)
            {
                search_table();
            }
        });

        $("#createnew").click(function(){
			myjstbl.add_new_row();
            myjstbl.mypage.go_to_last_page(); 
            $(".txtname").last().focus();
        });
        
        $("#filterclientgroup").val(<?=$clientgroupid?>);
        $("#filterclienthead").val(<?=$clientheadid?>);

        $("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclienthead").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterclientgroup").change(function(){
            refresh_clienthead_ddl();
            $("#filterclienthead").val(0);
            search_table();
        });
        $("#filterclienthead").change(function(){
            search_table();
        });

        if($('#filterclienthead').val() > 0)
        {
            
        }
        else if($('#filterclientgroup').val() > 0)
        {
            refresh_clienthead_ddl();
        }

        //Delete Function For PUL Table
        $('.imgdel').live('click',function() {
           var cnt = myjstbl.get_row_count() - 1;
           var row_index = $(this).parent().parent().index();
           var id_val=  myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id_pul'].td_class)[0];
            var answer = confirm("Are you sure you want to delete?");
            if(answer==true){
                myjstbl.delete_row(row_index);
                $.get("<?=base_url()?>hamachisubscriptions/delete_control",
                {id: id_val},
                function(data){
                    myjstbl.delete_row(row_index);
                    myjstbl.add_new_row();
                    $(".txtdate_start").last().datepicker();
                    $(".txtdate_start").last().datepicker("option","dateFormat", "yy-mm-dd" );
                });
            }
        });

        search_table();
    });

    function pad(n) 
    {
       if(n < 10 && n > 0 )
       {
        return "0" + n;
       }
       return n;
    }

    function refresh_clienthead_ddl()
    {
        $.get("<?=base_url()?>hamachisubscriptions/refresh_clienthead_ddl_control",
        {
            clientgroupid : $("#filterclientgroup").val()
        }
        ,
        function(data){
            document.getElementById("filterclienthead").innerHTML = data;
            $("#filterclienthead").trigger("liszt:updated");
        });
    }
    
    function search_table(rowstart, rowend)
    {  
        myjstbl.clean_table();
        var search_val = $.trim($('#txtsearch').val());

        var row_start_val = (typeof rowstart === 'undefined' || rowstart < 0)?0:rowstart;
        var row_end_val = (typeof rowend === 'undefined')?(myjstbl.mypage.mysql_interval-1):rowend;

        $.ajax(
        {
            url: "<?=base_url()?>hamachisubscriptions/search_control",
            type: "POST",
            data: {
                search: search_val,
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val(),
                rowstart: row_start_val,
                rowend: row_end_val
                    },
            async: true,
            success: function(data)
            {
                myjstbl.add_new_row();
                myjstbl.insert_multiplerow_with_value(1, data.data); 
                bind_datepicker_to_row(myjstbl.get_row_count() - 1, true);

                if((typeof rowstart === 'undefined') && (typeof rowend === 'undefined'))
                {
                   myjstbl.clear_table();
                }
                else
                {
                    myjstbl.clean_table();
                }

                var rowcnt = data.rowcnt;
                if(rowcnt == 0 )
                {
                    myjstbl.mypage.set_last_page(0);
                }
                else
                {
                    myjstbl.mypage.set_last_page( Math.ceil(Number(rowcnt) / Number(myjstbl.mypage.filter_number)));
                }

                var pages_per_query = Number(myjstbl.mypage.mysql_interval) / Number(myjstbl.mypage.filter_number);
                var firstPageOfLastQuery = ( Math.floor(Number(myjstbl.mypage.get_last_page()) / pages_per_query) )*(pages_per_query);
                var current_page = $("#tableid_pul_txtpagenumber").val();
               
                myjstbl.insert_multiplerow_with_value(1,data.data);  

                if(current_page => firstPageOfLastQuery) 
                {
                     myjstbl.add_new_row();
                     $(".txtname").last().focus();
                }
            }
        });        


        /*$.getJSON("<?=base_url()?>hamachisubscriptions/search_control",
            { 
                search: search_val,
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val()
            },
            function(data) { 
                myjstbl.add_new_row();
                //$(".txtdate_start").last().datepicker();
                //$(".txtdate_start").last().datepicker("option","dateFormat", "yy-mm-dd" );
                myjstbl.insert_multiplerow_with_value(1,data); 
				bind_datepicker_to_row(myjstbl.get_row_count() - 1, true);
            });*/
    }
    


    function edit_fnc(x)
    {
        var row_index = $(x).parent().parent().index();
        myjstbl.edit_row(row_index);
		bind_datepicker_to_row(row_index, false);
    }
    
    function update_fnc(x)
    {
        var cnt = myjstbl.get_row_count() - 1;
        var row_index = $(x).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl.get_row_values(row_index);
        var id_val = values_arr[colarray['id_pul'].td_class][0];
        var colclientinfo_val= values_arr[colarray['colclientinfo'].td_class][0];
        var name_val= values_arr[colarray['name'].td_class][0];
        var description_val= values_arr[colarray['description'].td_class][0];
        var date_start_val= values_arr[colarray['date_start'].td_class][0];
		var date_setup_val = values_arr[colarray['date_setup'].td_class][0];
		var memberid_val = values_arr[colarray['colmember'].td_class][0];
		var invoice_val = values_arr[colarray['invoice'].td_class][0];

        if(name_val.length < 1)
        {
             alert("Please input name");
            return; 
        }

        if(date_start_val.length > 0){
            if ( Number(date_start_val.split('-')[2]) > 1 ) {
                alert("date should always be the first day of next month");
                return;
            } 
        }

        if(date_start_val.length < 1)
        {
            var d = new Date();
            date_start_val = d.getFullYear() + "-" + ( pad(d.getMonth() + 1)) + "-" + pad(d.getDate());
        }

        var fnc_pul = "<?=base_url()?>hamachisubscriptions/update_control";
        if (id_val == "")
            fnc_pul = "<?=base_url()?>hamachisubscriptions/insert_control";

        $.getJSON(fnc_pul,
            {
            id:id_val,
            clientbranchid: colclientinfo_val,
            name: name_val,
            description: description_val,
            date_start: date_start_val,
			date_setup: date_setup_val,
			memberid: memberid_val,
			invoice: invoice_val
            },
            function(data) {
                if(data == "error"){
                    alert("error");
                }
                else{
                    if(id_val=="") {
						myjstbl.update_row_with_value(row_index,data);
                        myjstbl.add_new_row();
                        //$(".txtdate_start").last().datepicker();
                        //$(".txtdate_start").last().datepicker("option","dateFormat", "yy-mm-dd" );
						//alert(myjstbl.get_row_count() - 1);
						bind_datepicker_to_row(myjstbl.get_row_count() - 1, true);
                    }
					else
                        myjstbl.update_row_with_value(row_index,data);
                }
            }); 
    }
	
	function bind_datepicker_to_row(row_index, is_last_row){
	
		var date_element1 = myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['date_start'].td_class);
		var date_element2 = myjstbl.getelem_by_rowindex_tdclass(row_index, colarray['date_setup'].td_class);
		
		var identifier;
		if(is_last_row)
			identifier = "last";
		else
			identifier = row_index.toString();
			
		$(date_element1).attr("id","date_start" + identifier);
		$("#" + "date_start" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
		$(date_element2).attr("id","date_setup" + identifier);
		$("#" + "date_setup" + identifier).datepicker({dateFormat: 'yy-mm-dd'});
		
	}
</script>

