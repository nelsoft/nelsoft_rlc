    <script language="javascript" type="text/javascript">
    
    var myjstblerror;
    var taberror = document.createElement('table');
    taberror.id="tableid";
    var colarrayerror = [];
    var parameterserror = [];
    var colarrayerrorparams=["id", "datetime","filewitherror"];
    for (var x=0; x<3; x++)
    {
        parameterserror[x] = document.createElement('span');
        colarrayerror[colarrayerrorparams[x]] = {
        header_title: colarrayerrorparams[x],
        edit: [parameterserror[x]],
        disp: [parameterserror[x]],
        td_class: "tablerow tdall",
        headertd_class : "tdall"
        };
    }
    var iserrorimg = document.createElement('img');
    iserrorimg.src = "<?=base_url()?>assets/images/updated.png";
    iserrorimg.setAttribute("onclick","update_fnc(this)");
    colarrayerror["iserror"] = {
        header_title: "",
        edit: [iserrorimg],
        disp: [iserrorimg],
        td_class: "tablerow tdall tdiserror",
        headertd_class : "tdall"
    };
    
    $(function(){
         load_tables();
    });

    function load_tables()
    {   
         myjstblerror = new my_table(taberror, colarrayerror, {ispaging : true,
                                                tdhighlight_when_hover : "tablerow",
                                                iscursorchange_when_hover : true});
        var rooterror = document.getElementById("tblerror");
        rooterror.appendChild(myjstblerror.tab);
        rooterror.appendChild(myjstblerror.mypage.pagingtable);
        
        refresh_errors_table();
    }
    
    function refresh_errors_table()
    {  
        myjstblerror.clean_table();
        $.getJSON("<?=base_url()?>errors/refresh_errors_control",{},
            function(data){
                myjstblerror.insert_multiplerow_with_value(1,data);	
        });
    }

    function update_fnc(x)
    {
        var row_index = $(x).parent().parent().index();
        var id_val = myjstblerror.getvalue_by_rowindex_tdclass(row_index, colarrayerror["id"].td_class)[0];
        $.getJSON("<?=base_url()?>errors/errors_resolved_control",{ id : id_val },
            function(data){
                myjstblerror.delete_row(row_index);
                //refresh_errors_table();
        });
        
    }
</script>

