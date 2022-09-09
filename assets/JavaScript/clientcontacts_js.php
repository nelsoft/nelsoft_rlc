    <script language="javascript" type="text/javascript">

<?php 
        $clientgroupid = isset($_GET['clientgroupid'])?$_GET['clientgroupid']:"";
        $clientheadid = isset($_GET['clientheadid'])?$_GET['clientheadid']:"";
        $clientdetailid= isset($_GET['clientdetailid'])?$_GET['clientdetailid']:"";
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
    selclientinfo.innerHTML = '<?php echo fill_select_options("SELECT CD.`id`, CONCAT(CH.`name`, ' ', COALESCE(CD.`branchid`,''), '-', COALESCE(CD.`branchname`,'')) as  `branchname` FROM clienthead as CH LEFT JOIN clientdetails as CD ON CH.`id`= CD.`clientid` ORDER BY CH.`name`, CD.`branchid`", "id", "branchname",0,false); ?>';
    var selclientinfo_disp = selclientinfo.cloneNode(true);
    selclientinfo_disp.disabled = "disabled";
    colarray['colclientinfo'] = { 
        header_title: "Client_Information", 
        edit: [selclientinfo], 
        disp: [selclientinfo_disp], 
        td_class: "tablerow tdclientinfo"
    };
/*
    var seltechassigned = document.createElement('select');
    seltechassigned.className = "seltechassigned";
    seltechassigned.innerHTML = '<?php echo fill_select_options("SELECT `id`, `name` FROM `members` WHERE `type` = 1 ORDER BY `name`", "id", "name",0,false); ?>';
    var seltechassigned_disp = seltechassigned.cloneNode(true);
    seltechassigned_disp.disabled = "disabled";
    colarray['techassigned'] = { 
        header_title: "Tech Assigned", 
        edit: [seltechassigned], 
        disp: [seltechassigned_disp], 
        td_class: "tablerow tdtechassigned"
    };
*/
    var spncontactperson_id = document.createElement('span');
    spncontactperson_id.className = 'spncontactperson_id';
    colarray['contactperson_id'] = { 
        header_title: "id",
        edit: [spncontactperson_id],
        disp: [spncontactperson_id],
        td_class: "tablerow tdcontactperson_id",
        headertd_class : "tdclick tdcontactperson_id"
    };

    var spncontactperson_name = document.createElement('span');
    var txtcontactperson_name = document.createElement('input');
    txtcontactperson_name.type = "text";
    txtcontactperson_name.id = 'idtxtcontactperson_name';
    txtcontactperson_name.className = 'txtcontactperson_name';
    colarray['contactperson_name'] = { 
        header_title: "Contact Person",
        edit: [txtcontactperson_name],
        disp: [spncontactperson_name],
        td_class: "tablerow tdcontactperson_name",
        headertd_class : "hdcontactperson_name tdclick"
    };
/*
    var spnname = document.createElement('span');
    var txtname = document.createElement('input');
    txtname.type = "text";
    txtname.id = 'idtxtname';
    txtname.className = 'txtname';
    colarray['name'] = { 
        header_title: "Name",
        edit: [txtname],
        disp: [spnname],
        td_class: "tablerow tdname",
        headertd_class : "hdname tdclick"
    };

    var spncontactdetail = document.createElement('span');
    var txtcontactdetail = document.createElement('input');
    txtcontactdetail.type = "text";
    txtcontactdetail.id = 'idtxtcontactdetail';
    txtcontactdetail.className = 'txtcontactdetail';
    colarray['contactdetail'] = { 
        header_title: "Contact Details",
        edit: [txtcontactdetail],
        disp: [spncontactdetail],
        td_class: "tablerow tdcontactdetail",
        headertd_class : "hdcontactdetail tdclick"
    };

    var spndescription = document.createElement('span');
    var txtdescription = document.createElement('input');
    txtdescription.type = "text";
    txtdescription.id = 'idtxtdescription';
    txtdescription.className = 'txtdescription';
    colarray['description'] = { 
        header_title: "Description",
        edit: [txtdescription],
        disp: [spndescription],
        td_class: "tablerow tddescription",
        headertd_class : "hddescription tdclick"
    };
*/
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
        
    $(function(){
        
        myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow"});
        var root = document.getElementById("tbl");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);

        $("#createnew").click(function(){
            myjstbl.mypage.go_to_last_page(); 
            $(".txtname").last().focus();
        });
        
        $("#filterclientgroup").val(<?=$clientgroupid?>);
        $("#filterclienthead").val(<?=$clientheadid?>);
        $("#filterclient").val(<?=$clientdetailid?>);

        $("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclienthead").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#filterclient").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterclientgroup").change(function(){
            $("#filterclienthead").val(0);
            $("#filterclient").val(0);
            search_table();
            refresh_clienthead_ddl();
        });
        $("#filterclienthead").change(function(){
            $("#filterclient").val(0);
            search_table();
            refresh_clientdetail_ddl();
        });
        $("#filterclient").change(function(){
            search_table();
        });

        if($('#filterclient').val() > 0)
        {
        }
        else if($('#filterclienthead').val() > 0)
        {
            refresh_clientdetail_ddl();
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
                $.get("<?=base_url()?>clientcontacts/delete_control",
                {id: id_val},
                function(data){
                    myjstbl.delete_row(row_index);
                    myjstbl.add_new_row();
                });
            }
        });

        search_table();


        $(".selclientinfo").change(function(){
            var cur_row = $(this).parent().parent().index();
            var contactpersontextbox = myjstbl.getelem_by_rowindex_tdclass(cur_row, 
                                        colarray["contactperson_name"].td_class)[0];
            var clientbranchid = $(this).val();
            
            my_autocomplete_add_single(contactpersontextbox, 
                    "<?=base_url()?>clientcontacts/ac_contactperson?clientbranchid="+clientbranchid, {
                enable_add : false,
                fnc_callback : function(x, label, value, ret_datas, error){                
                    var row_index = $(x).parent().parent().index();
                    if(error.length > 0){
                        myjstbl.setvalue_to_rowindex_tdclass(["0"],row_index,colarray['contactperson_id'].td_class);
                        myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['contactperson_name'].td_class);
                    }
                    else {
                        myjstbl.setvalue_to_rowindex_tdclass([value],row_index,colarray['contactperson_id'].td_class);
                        myjstbl.setvalue_to_rowindex_tdclass([label],row_index,colarray['contactperson_name'].td_class);  
                    }
                },
                fnc_render : function(ul, item){
                    return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                        { width : ["50px","250px"] });
                }
            }); 

        });
        
        $(".txtcontactperson_name").live("focus",function(){
            
            var cur_row = $(this).parent().parent().index();
            var clientbranchid = myjstbl.getvalue_by_rowindex_tdclass(cur_row, 
                                        colarray["colclientinfo"].td_class)[0];

            my_autocomplete_add_single(this, "<?=base_url()?>clientcontacts/ac_contactperson?clientbranchid="+clientbranchid, {
                enable_add : false,
                fnc_callback : function(x, label, value, ret_datas, error){                
                    var row_index = $(x).parent().parent().index();
                    if(error.length > 0){
                        myjstbl.setvalue_to_rowindex_tdclass(["0"],row_index,colarray['contactperson_id'].td_class);
                        myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['contactperson_name'].td_class);
                    }
                    else {
                        myjstbl.setvalue_to_rowindex_tdclass([value],row_index,colarray['contactperson_id'].td_class);
                        myjstbl.setvalue_to_rowindex_tdclass([label],row_index,colarray['contactperson_name'].td_class);  
                    }
                },
                fnc_render : function(ul, item){
                    return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                        { width : ["50px","250px"] });
                }
            });
            
        });




    });

    function set_tbl_element_events() {
        my_autocomplete_add(".txtcontactperson_name", "<?=base_url()?>clientcontacts/ac_contactperson", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){                
                var row_index = $(x).parent().parent().index();
                if(error.length > 0){
                    myjstbl.setvalue_to_rowindex_tdclass(["0"],row_index,colarray['contactperson_id'].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([""],row_index,colarray['contactperson_name'].td_class);
                }
                else {
                    myjstbl.setvalue_to_rowindex_tdclass([value],row_index,colarray['contactperson_id'].td_class);
                    myjstbl.setvalue_to_rowindex_tdclass([label],row_index,colarray['contactperson_name'].td_class);  
                }
            },
            fnc_render : function(ul, item){
                return my_autocomplete_render_fnc(ul, item, "code_name", [0, 1], 
                    { width : ["50px","250px"] });
            }
            });  
    }

    function refresh_clienthead_ddl()
    {
        $.get("<?=base_url()?>clientcontacts/refresh_clienthead_ddl_control",
        {
            clientgroupid : $("#filterclientgroup").val()
        }
        ,
        function(data){
            document.getElementById("filterclienthead").innerHTML = data;
            $("#filterclienthead").trigger("liszt:updated");
        });

        if($("#filterclientgroup").val() > 0 || $("#filterclienthead").val() > 0)
        {
            $.get("<?=base_url()?>clientcontacts/refresh_table_clientdetail_ddl_control",
            {
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val()
            }
            ,
            function(data){
                $(".selclientinfo:last").html(data);
            });
        }
        

    }

    function refresh_clientdetail_ddl()
    {
        $.get("<?=base_url()?>clientcontacts/refresh_clientdetail_ddl_control",
        {
            clientheadid : $("#filterclienthead").val()
        }
        ,
        function(data){
            document.getElementById("filterclient").innerHTML = data;
            $("#filterclient").trigger("liszt:updated");
        });

        if($("#filterclientgroup").val() > 0 || $("#filterclienthead").val() > 0)
        {
            $.get("<?=base_url()?>clientcontacts/refresh_table_clientdetail_ddl_control",
            {
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val()
            }
            ,
            function(data){
                $(".selclientinfo:last").html(data);
            });
        }
    }
    
    function search_table()
    {  
        myjstbl.clean_table();
        $.getJSON("<?=base_url()?>clientcontacts/search_control",
            { 
                clientgroupid : $("#filterclientgroup").val(),
                clientheadid : $("#filterclienthead").val(),
                clientdetailid : $("#filterclient").val()
            },
            function(data) { 
                myjstbl.add_new_row();
                myjstbl.insert_multiplerow_with_value(1,data);  
                //set_tbl_element_events();
            });
    }
    
    function edit_fnc(x)
    {
        var row_index = $(x).parent().parent().index();
        myjstbl.edit_row(row_index);
        //set_tbl_element_events();
    }
    
    function update_fnc(x)
    {
        var cnt = myjstbl.get_row_count() - 1;
        var row_index = $(x).parent().parent().index();
        var row_index_val = row_index;
        // alert(row_index_val+"up");
        var values_arr = myjstbl.get_row_values(row_index);
        var id_val = values_arr[colarray['id_pul'].td_class][0];
        //var techassigned_val= values_arr[colarray['techassigned'].td_class][0];
        var techassigned_val= 0;
        var colclientinfo_val= values_arr[colarray['colclientinfo'].td_class][0];
        var contactperson_id_val= values_arr[colarray['contactperson_id'].td_class][0];
        
        var fnc_pul = "<?=base_url()?>clientcontacts/update_control";
        if (id_val == "")
            fnc_pul = "<?=base_url()?>clientcontacts/insert_control";

        $.getJSON(fnc_pul,
            {
            id:id_val,
            techassigned: techassigned_val,
            clientbranchid: colclientinfo_val,
            contactperson_id: contactperson_id_val
            },
            function(data) {
                if(data == "error"){
                    alert("error");
                }
                else{
                    if(id_val=="") 
                    {
                        myjstbl.add_new_row();
                        //set_tbl_element_events();
                    }
                       
                    myjstbl.update_row_with_value(row_index,data);
                }
            }); 
    }
</script>

