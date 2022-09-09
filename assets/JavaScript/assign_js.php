    <script language="javascript" type="text/javascript">
    
    var myjstbl;
    var tab = document.createElement('table');
    tab.id="tableid";
    var colarray = [];

    var spnrow = document.createElement('span');
    colarray['row'] = { 
        header_title: "",
        edit: [spnrow],
        disp: [spnrow],
		td_class: "tablerow tdall tdrow",
        headertd_class : "tdall"
    };
    
    var spnclient = document.createElement('span');
    colarray['clientid'] = { 
        header_title: "Client",
        edit: [spnclient],
        disp: [spnclient],
        td_class: "tablerow tdall tdclient",
        headertd_class : "tdall"
    };
    
    var spnbranchcount = document.createElement('span');
    colarray['branchcount'] = { 
        header_title: "branch",
        edit: [spnbranchcount],
        disp: [spnbranchcount],
        td_class: "tablerow tdall",
        headertd_class : "tdall"
    };
    
    var spndevassigned = document.createElement('span');
    colarray['devassigned'] = { 
        header_title: "devassigned",
        edit: [spndevassigned],
        disp: [spndevassigned],
        td_class: "tablerow tdall",
        headertd_class : "tdall"
    };

    var txttechassigned = document.createElement('input');
    txttechassigned.className = "techassignedclass";
    txttechassigned.setAttribute("onkeypress", "enter_update(event, this)");
    var spntechassigned = document.createElement('span');
    spntechassigned.className = "techassignedclass";
    colarray['techassigned'] = { 
        header_title: "techassigned",
        edit: [txttechassigned],
        disp: [spntechassigned],
        td_class: "tablerow tdall tdtech",
        headertd_class : "tdall"
    };
    
    var imgUpdate = document.createElement('img');
    imgUpdate.src = "assets/images/iconupdate.png";
    imgUpdate.setAttribute("onclick","update_fnc(this)");
    imgUpdate.style.cursor = "pointer";
    var imgEdit = document.createElement('img');
    imgEdit.src = "assets/images/iconedit.png";
    imgEdit.setAttribute("onclick","NT_editSelectedRow(myjstbl, this)");
    imgEdit.style.cursor = "pointer";
    
    colarray['colupdate'] = { 
        header_title: "",
        edit: [imgUpdate],
        disp: [imgEdit],
        td_class: "tablerow tdupdate"
    };
    
    $(function(){
         load_tables();
         
        // $("#filtername").chosen({allow_single_deselect:true, 
        // no_results_text: "No",
        // add_item_enable: false});
         my_autocomplete_add(".techassignedclass", "<?=base_url()?>assign/autocompletetech_control", {
            enable_add : false,
            fnc_callback : function(x, label, value, ret_datas, error){  
            }
        });
    });

    function enter_update(e, x)
    {
        if(e.keyCode == 13)
        {
            update_fnc(x);
            e.preventDefault();
        }
        
    }
        
    function load_tables()
    {   
         myjstbl = new my_table(tab, colarray, {ispaging : true,
                            tdhighlight_when_hover : "tablerow",
                            iscursorchange_when_hover : true});
        var root = document.getElementById("tbl");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);
        
        refresh_table();
    }
    
    function refresh_table()
    {  
        myjstbl.clean_table();
        $.getJSON("<?=base_url()?>assign/search_control",{},
            function(data){
                myjstbl.insert_multiplerow_with_value(1,data);	
        });
    }
    
    function update_fnc(x){
        var cnt = myjstbl.get_row_count() - 1;
        var row_index_val = $(x).parent().parent().index();
        var values_arr = myjstbl.get_row_values(row_index_val);
        var clientid_val = values_arr[colarray["row"].td_class][0];
        var techassigned_val = values_arr[colarray["techassigned"].td_class][0];
        var fnc_val = "<?=base_url()?>assign/assign_devs_techs_control";
        
        if(techassigned_val == "")
        {
            document.getElementById("lblStatus").innerHTML = "Please fill up all fields!";
            return;
        }
        $.getJSON(fnc_val,
            { 	row_index_mdl :row_index_val,
                clientid_mdl : clientid_val,
                techassign_mdl : techassigned_val
            },
        function(data){
                refresh_table();
                //myjstbl.update_row_with_value(row_index_val, data);
         });	  
    }
</script>

