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

    var spnclient_name = document.createElement('span');
    spnclient_name.className = 'spnclient_name';
    colarray_pul['client_name'] = { 
        header_title: "Client",
        edit: [spnclient_name],
        disp: [spnclient_name],
        td_class: "tablerow tdclient_name"
    };

    var spnbranch = document.createElement('span');
    spnbranch.className = 'spnbranch';
    colarray_pul['branch'] = { 
        header_title: "Branch",
        edit: [spnbranch],
        disp: [spnbranch],
        td_class: "tablerow tdbranch"
    };

    var spndescription = document.createElement('span');
    spndescription.className = 'spndescription';
    colarray_pul['description'] = { 
        header_title: "Description",
        edit: [spndescription],
        disp: [spndescription],
        td_class: "tablerow tddescription"
    };

    var spnlocation = document.createElement('span');
    spnlocation.className = 'spnlocation';
    colarray_pul['location'] = { 
        header_title: "Location",
        edit: [spnlocation],
        disp: [spnlocation],
        td_class: "tablerow tdlocation"
    };

    var spncontact = document.createElement('span');
    spncontact.className = 'spncontact';
    colarray_pul['contact'] = { 
        header_title: "Contact",
        edit: [spncontact],
        disp: [spncontact],
        td_class: "tablerow tdcontact"
    };

    var spnterminal_cnt = document.createElement('span');
    spnterminal_cnt.className = 'spnterminal_cnt';
    colarray_pul['terminal_cnt'] = { 
        header_title: "# of POS",
        edit: [spnterminal_cnt],
        disp: [spnterminal_cnt],
        td_class: "tablerow tdterminal_cnt"
    };


	var arr = [];
    $(function() {
        // P.U.L
        myjstbl_pul = new my_table(tab_pul, colarray_pul, {ispaging : true,
                                                iscursorchange_when_hover : true});

        var root_pul = document.getElementById("tbl_pul");
        root_pul.appendChild(myjstbl_pul.tab);
        root_pul.appendChild(myjstbl_pul.mypage.pagingtable);
	   
        pul_refresh_table();
		$("#txtsearch").keypress( 
		function(e){
			if(e.keyCode == 13)
			{
				pul_refresh_table();
			}
		});
    });
	

	function pul_refresh_table() {
      var search_val = $.trim($('#txtsearch').val());

	  $('#lblStatus').css('visibility', 'hidden');
        $.getJSON("<?=base_url()?>clientbranch_info/pul_refresh",
            { 
                search: search_val
            },
            function(data) { 
                myjstbl_pul.clean_table();
                myjstbl_pul.insert_multiplerow_with_value(1,data);	

			});
    }
	
</script>