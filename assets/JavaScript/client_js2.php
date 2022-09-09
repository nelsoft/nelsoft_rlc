    <script language="javascript" type="text/javascript">

    //TABLECLIENT
    var myjstbl;
    var tab = document.createElement('table');
    tab.id="tableid";
    var colarray = [];
    
    var spncount = document.createElement('span');
    colarray['count'] = { 
        header_title: " ",
        edit: [spncount],
        disp: [spncount],
		td_class: "tablerow tdsmall",
        headertd_class : "tdsmall"
    };
    
    var spnid = document.createElement('span');
    colarray['id'] = { 
        header_title: "ID",
        edit: [spnid],
        disp: [spnid],
		td_class: "tablerow tdall tdclick",
        headertd_class : "tdall"
    };
    
    var spnclient = document.createElement('span');
    colarray['Client'] = { 
        header_title: "Client",
        edit: [spnclient],
        disp: [spnclient],
        td_class: "tablerow tdlong tdclick",
        headertd_class : "tdlong"
    };

    var spnbranchid = document.createElement('span');
    colarray['branchid'] = { 
        header_title: "branch id",
        edit: [spnbranchid],
        disp: [spnbranchid], 
        td_class: "tablerow tdall tdclick",
        headertd_class : "tdall"
    };

    var spnbranchname = document.createElement('span');
    colarray['branchname'] = { 
        header_title: "branchname",
        edit: [spnbranchname],
        disp: [spnbranchname],
        td_class: "tablerow tdlong tdclick",
        headertd_class : "tdlong"
    };

    var spndevassigned = document.createElement('span');
    colarray['devassigned'] = { 
        header_title: "devassigned",
        edit: [spndevassigned],
        disp: [spndevassigned],
        td_class: "tablerow tdall tdclick",
        headertd_class : "tdall"
    };

    var spntechassigned = document.createElement('span');
    colarray['techassigned'] = { 
        header_title: "techassigned",
        edit: [spntechassigned],
        disp: [spntechassigned],
        td_class: "tablerow tdall tdclick",
        headertd_class : "tdall"
    };
    
    var database = document.createElement('span');
    var databaseimg = document.createElement('span');
    databaseimg.className = "imgdbst";
    //databaseimg.src = "<?=base_url()?>assets/images/updated.png";
    colarray['database'] = {
        header_title: "database",
        edit: [database, databaseimg],
        disp: [database, databaseimg],
        td_class: "tablerow tdall tddatabase tdclick",
        headertd_class : "tdall"
    };

    var websystem = document.createElement('span');
    var websystemimg = document.createElement('span');
    websystemimg.className = "imgdbst";
    //websystemimg.src = "<?=base_url()?>assets/images/updated.png";
    colarray['websystem'] = {
        header_title: "websystem",
        edit: [websystem, websystemimg],
        disp: [websystem, websystemimg],
        td_class: "tablerow tdall tdwebsystem tdclick",
        headertd_class : "tdall"
    };

    var autosync = document.createElement('span');
    var autosyncimg = document.createElement('span');
    autosyncimg.className = "imgdbst";
    autosyncimg.src = "<?=base_url()?>assets/images/updated.png";
    colarray['autosync'] = {
        header_title: "autosync",
        edit: [autosync, autosyncimg],
        disp: [autosync, autosyncimg],
        td_class: "tablerow tdall tdautosync tdclick",
        headertd_class : "tdall"
    };

    // var autoupdator = document.createElement('span');
    // var autoupdatorimg = document.createElement('span');
    // autoupdatorimg.className = "imgdbst";
    // autoupdatorimg.src = "<?=base_url()?>assets/images/updated.png";
    // colarray['autoupdator'] = {
        // header_title: "autoupdator",
        // edit: [autoupdator, autoupdatorimg],
        // disp: [autoupdator, autoupdatorimg],
        // td_class: "tablerow tdall tdautoupdator",
        // headertd_class : "tdall"
    // };

    // var autobackup = document.createElement('span');
    // var autobackupimg = document.createElement('span');
    // autobackupimg.className = "imgdbst";
    // autobackupimg.src = "<?=base_url()?>assets/images/updated.png";
    // colarray['autobackup'] = {
        // header_title: "autobackup",
        // edit: [autobackup, autobackupimg],
        // disp: [autobackup, autobackupimg],
        // td_class: "tablerow tdall tdautobackup",
        // headertd_class : "tdall"
    // };

    var contactperson = document.createElement('span');
    colarray['contactperson'] = {
        header_title: "contactperson",
        edit: [contactperson],
        disp: [contactperson],
        td_class: "tablerow tdall tdcontactperson tdclick",
        headertd_class : "tdall"
    };
    var contactnumber = document.createElement('span');
    colarray['contactnumber'] = {
        header_title: "contactnumber",
        edit: [contactnumber],
        disp: [contactnumber],
        td_class: "tablerow tdall tdcontactnumber tdclick",
        headertd_class : "tdall"
    };
    
    var lastuploaddate = document.createElement('span');
    var lastuploaddateimg = document.createElement('span');
    lastuploaddateimg.className = "imgdbst";
    lastuploaddate.src = "<?=base_url()?>assets/images/updated.png";
    colarray['lastuploaddate'] = {
        header_title: "last upload date",
        edit: [lastuploaddate, lastuploaddateimg],
        disp: [lastuploaddate, lastuploaddateimg],
        td_class: "tablerow tdlong tdlastuploaddate tdclick",
        headertd_class : "tdlong"
    };
    
    //var error = document.createElement('span');
    var errorimg = document.createElement('span');
    errorimg.className = "imgdbst";
    //errorimg.src = "<?=base_url()?>assets/images/updated.png";
    colarray['error'] = {
        header_title: "",
        edit: [errorimg],
        disp: [errorimg],
        td_class: "tablerow tdall tderror",
        headertd_class : "tdall"
    };

    var remainpoints = document.createElement('span');
    remainpoints.className = "remainpoints";
    //errorimg.src = "<?=base_url()?>assets/images/updated.png";
    colarray['remainpoints'] = {
        header_title: "",
        edit: [remainpoints],
        disp: [remainpoints],
        td_class: "tablerow tdall tdremainpoints",
        headertd_class : "thremainpoints"
    };
    
    var pdfimg = document.createElement('span');
    pdfimg.className = "pdfimg";
    //errorimg.src = "<?=base_url()?>assets/images/updated.png";
    colarray['pdfimg'] = {
        header_title: "",
        edit: [pdfimg],
        disp: [pdfimg],
        td_class: "tablerow tdall tdpdfimg",
        headertd_class : "thpdfimg"
    };

    //TABLEPOSBARCODE
    // var myjstblpos;
    // var tabpos = document.createElement('table');
    // tabpos.id="tableid";
    // var colarraypos = [];
    // var parameterspos = [];
    // var parametersposimg = [];
    // var colarrayparamspos=["id", "Client","branchid","terminalno","POS","barcode"];
    // for (var x=0; x<4; x++)
    // {
        // parameterspos[x] = document.createElement('span');
        // colarraypos[colarrayparamspos[x]] = {
            // header_title: colarrayparamspos[x],
            // edit: [parameterspos[x]],
            // disp: [parameterspos[x]],
            // td_class: "tablerow tdall",
            // headertd_class : "tdall"
        // };
    // }
    // for (var x=4; x<6; x++)
    // {
        // parameterspos[x] = document.createElement('span');
        // parametersposimg[x] = document.createElement('img');
        // parametersposimg[x].className = "imgdbst";
        // parametersposimg[x].src = "<?=base_url()?>assets/images/updated.png";
        // colarraypos[colarrayparamspos[x]] = {
        // header_title: colarrayparamspos[x],
        // edit: [parameterspos[x],parametersposimg[x]],
        // disp: [parameterspos[x],parametersposimg[x]],
        // td_class: "tablerow tdall "+"td"+colarrayparamspos[x],
        // headertd_class : "tdall"
        // };
    // }
    
    //TABLEMAX
    var myjstblmax;
    var tabmax = document.createElement('table');
    tabmax.id="tableid2";
    var colarraymax = [];
    var parametersmax = [];
    var colarrayparamsmax=["database","websystem",
            "autosync","autoupdator","autobackup","POS","barcode"];
    for (var x=0; x<7; x++)
    {
        parametersmax[x] = document.createElement('span');
        colarraymax[colarrayparamsmax[x]] = { 
            header_title: colarrayparamsmax[x],
            edit: [parametersmax[x]],
            disp: [parametersmax[x]],
            td_class: "tablerow tdall "+"td"+colarrayparamsmax[x],
            headertd_class : "tdall"
        };
    }
    
    //TABLEDEVBRANCHES
    var myjstbldevbranches;
    var tabdevbranches = document.createElement('table');
    tabdevbranches.id="tableid3";
    var colarraydevbranches = [];
    var parametersdevbranches = [];
    var colarrayparamsdevbranches=["Dev","Clientcnt","Totbranchcnt"];
    for (var x=0; x<3; x++)
    {
        parametersdevbranches[x] = document.createElement('span');
        colarraydevbranches[colarrayparamsdevbranches[x]] = { 
            header_title: colarrayparamsdevbranches[x],
            edit: [parametersdevbranches[x]],
            disp: [parametersdevbranches[x]],
            td_class: "tablerow tdall "+"td"+colarrayparamsdevbranches[x],
            headertd_class : "tdall"
        };
    }
    
    $(function(){
        get_csvfiles();
        
        $('#btnsearch').live('click',function()   {   search_table(); select_Dev_branches(); });
        
        $("#filterclient").chosen({allow_single_deselect:true, 
            no_results_text: "No",
            add_item_enable: false});
        $("#filterdev").chosen({allow_single_deselect:true, 
            no_results_text: "No",
            add_item_enable: false});
        $("#filtertech").chosen({allow_single_deselect:true, 
            no_results_text: "No",
            add_item_enable: false});
		
		$(".tdclick").live("click",function(){
			// alert('haha');
			var row_index = $(this).parent().index();
			// row_index_val = row_index;
			var id = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
			window.open("client_points_info?clientgroupid=" + id);
		});
        
        $(".tdpdfimg").live("click",function(){
            // alert('haha');
            var row_index = $(this).parent().index();
            // row_index_val = row_index;
            var id = myjstbl.getvalue_by_rowindex_tdclass(row_index, colarray['id'].td_class)[0];
            window.open("client_points_info/generatePdf?clientgroupid=" + id + "&datefrom=<?= date('Y-m-01', strtotime(date('Y-m')." -1 month")) ?>"+"&dateto=<?= date("Y-m-d")?>"+"&statedate=<?= date("Y-m-d") ?>");
        });
    });
    
    function get_csvfiles()
    {
        $.get("<?=base_url()?>client/Insert_or_Update_Version_control",
            {},
            function(data){
                //alert(data.toString());
                load_tables();
            });
    }

    function load_tables()
    {
        myjstbl = new my_table(tab, colarray, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow2",
                                                iscursorchange_when_hover : true});
        var root = document.getElementById("tbl");
        root.appendChild(myjstbl.tab);
        root.appendChild(myjstbl.mypage.pagingtable);
        
        
        myjstblmax = new my_table(tabmax, colarraymax, {ispaging : false,
                                                tdhighlight_when_hover : "tablerow",
                                                iscursorchange_when_hover : true});
        var rootmax = document.getElementById("tblmax");
        rootmax.appendChild(myjstblmax.tab);
        ////
        myjstbldevbranches = new my_table(tabdevbranches, colarraydevbranches, {ispaging : false,
                                                tdhighlight_when_hover : "tablerow3",
                                                iscursorchange_when_hover : true});
        var rootdevbranches = document.getElementById("tbldevbranches");
        rootdevbranches.appendChild(myjstbldevbranches.tab);
        // myjstblpos = new my_table(tabpos, colarraypos, {ispaging : true,
                                                // tdhighlight_when_hover : "tablerow3",
                                                // iscursorchange_when_hover : true});
        // var rootpos = document.getElementById("tblpos");
        // rootpos.appendChild(myjstblpos.tab);
        // rootpos.appendChild(myjstblpos.mypage.pagingtable);
        search_table();
        search_maxversions();
        select_Dev_branches();
    }
    
    function search_maxversions()
    {  
        myjstblmax.clean_table();
       
        $.getJSON("<?=base_url()?>client/search_maxversions_control",{},
            function(data){
                myjstblmax.insert_multiplerow_with_value(1,data);	
               
        });
    }
    
    function search_table()
    {  
        myjstbl.clean_table();
       
        $.getJSON("<?=base_url()?>client/search_control",
        {
            dev_mdl : $('#filterdev').val(),
            tech_mdl : $('#filtertech').val(),
            client_mdl : $('#filterclient').val(),
            errorflag_mdl : $('input:radio[name=filtererror]:checked').val(),
            outdatedflag_mdl : $('input:radio[name=filteroutdated]:checked').val()
        }
        ,
        function(data){
            myjstbl.insert_multiplerow_with_value(1,data);
            //search_table_pos();
        });  
    }
    
    function select_Dev_branches()
    {  
        myjstbldevbranches.clean_table();
       
        $.getJSON("<?=base_url()?>client/select_Dev_branches_control",
        {},
        function(data){
            myjstbldevbranches.insert_multiplerow_with_value(1,data);
        });  
    }
    // function search_table_pos()
    // {  
        // myjstblpos.clean_table();
       
        // $.getJSON("<?=base_url()?>client/search_control_pos",{},
            // function(data){
                //alert(data);
                // myjstblpos.insert_multiplerow_with_value(1,data);         
        // });
    // }
</script>

