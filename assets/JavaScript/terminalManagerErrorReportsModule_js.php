<script language="javascript" type="text/javascript">
var terminalList = [];
var rowCount = [];

<?php
$clientgroupid = isset($_GET['clientgroupid']) ? $_GET['clientgroupid'] : "";

?>

// P.U.L Table
var myjstbl_pul;
var tab_pul = document.createElement('table');
tab_pul.id = "tableid_pul";
tab_pul.className = "table table-bordered";
var clientTerminalTable;
var isFirstLoad = true;

var colarray_pul = [];

var id_pul = document.createElement('span');
colarray_pul['id_pul'] = {
    header_title: "ID",
    edit: [id_pul],
    disp: [id_pul],
    td_class: "tablerow tdid",
    headertd_class : "hdid tdclick"
};

var spanDate = document.createElement('span');
var textDate = document.createElement('input');
textDate.type = "text";
textDate.id = 'idtextDate';
textDate.className = 'textDate';
colarray_pul['columnDate'] = {
    header_title: "Date",
    edit: [textDate],
    disp: [spanDate],
    td_class: "tablerow tdDate",
    headertd_class : "hdDate tdclick"
};

var spanCode = document.createElement('span');
var textCode = document.createElement('input');
textCode.type = "text";
textCode.id = 'idtextCode';
textCode.className = 'textCode';
spanCode.style.cursor = "pointer";
colarray_pul['columnCode'] = {
    header_title: "Code",
    edit: [textCode],
    disp: [spanCode],
    td_class: "tablerow tdCode",
    headertd_class : "hdCode tdclick"
};

var spanDetails = document.createElement('span');
var textDetails = document.createElement('input');
textDetails.type = "text";
textDetails.id = 'idtextDetails';
textDetails.className = 'textDetails';
colarray_pul['columnDetails'] = {
    header_title: "Details",
    edit: [textDetails],
    disp: [spanDetails],
    td_class: "tablerow tdDetails",
    headertd_class : "hdDetails tdclick"
};

var spanClientTerminalID = document.createElement('a');
var textClientTerminalID = document.createElement('input');
textClientTerminalID.type = "text";
textClientTerminalID.id = 'idtextClientTerminalID';
textClientTerminalID.className = 'textClientTerminalID';
spanClientTerminalID.setAttribute("target","_blank");
spanClientTerminalID.setAttribute("onclick","todetails_fnc(this)");
spanClientTerminalID.setAttribute("href","javascript:;");
colarray_pul['columnClientTerminalID'] = {
    header_title: "Client Terminal ID",
    edit: [textClientTerminalID],
    disp: [spanClientTerminalID],
    td_class: "tablerow tdClientTerminalID",
    headertd_class : "hdClientTerminalID tdclick"
};

var spanClientName = document.createElement('span');
colarray_pul['columnClientName'] = {
    header_title: "",
    edit: [spanClientName],
    disp: [spanClientName],
    td_class: "tablerow tdClientName",
    headertd_class : "hdClientName tdclick"
};

var spanClientIDs = document.createElement('span');
colarray_pul['columnClientIDs'] = {
    header_title: "",
    edit: [spanClientIDs],
    disp: [spanClientIDs],
    td_class: "tablerow tdClientIDs",
    headertd_class : "hdClientIDs tdclick"
};

var arr = [];
$(function()
{
    // P.U.L
    myjstbl_pul = new my_table(tab_pul, colarray_pul, {
        ispaging : true, 
        iscursorchange_when_hover : true,
        tdhighlight_when_hover : "tablerow"});

    var root_pul = document.getElementById("tbl_pul");
    root_pul.appendChild(myjstbl_pul.tab);
    root_pul.appendChild(myjstbl_pul.mypage.pagingtable);

    clientTerminalTable = new optimizedTable("tableid_pul", {
        rowStart: $("#tableid_pul_txtpagenumber").val(),
        limit: $("#tableid_pul_txtfilternumber").val(),
        rowCount: 0
    });

    $("#button-search").live("click", function(e) {
        if ($("#txtdatefrom").val() == "" || $("#txtdateto").val() == "") {
            alert('Please complete the date range');
        } else {
            pul_refresh_table(0);
        }
    });

    $("#filterclienthead").prop("disabled", true);
    $("#filterclient").prop("disabled", true);

    $("#filterclientgroup").chosen({
        allow_single_deselect: true,
        no_results_text: "Not found",
        add_item_enable: false 
    });

    $("#filterclienthead").chosen({
        allow_single_deselect:true,
        no_results_text: "Not found",
        add_item_enable: false
    });

    $("#filterclient").chosen({
        allow_single_deselect:true,
        no_results_text: "Not found",
        add_item_enable: false
    });

    $("#filter-client-order").chosen({
        allow_single_deselect: true,
        no_results_text: "Not found",
        add_item_enable: false
    });

    $("#filterclientgroup").change(function(){
        $("#filterclienthead").prop("disabled", ! ($("#filterclientgroup").val() > 0));;
        refresh_clienthead_ddl();
    });

    $("#filterclienthead").change(function(){
        $("#filterclient").prop("disabled", ! ($("#filterclienthead").val() > 0));
        refresh_clientdetail_ddl();
    });

    if ($('#filterclient').val() > 0) {
        refresh_client();
    } else if ($('#filterclienthead').val() > 0) {
        refresh_clientdetail_ddl();
    } else if ($('#filterclientgroup').val() > 0) {
        refresh_clienthead_ddl();
    }

    $('#txtdatefrom').datepicker({dateFormat: 'yy-mm-dd 00:00'});
    $('#txtdateto').datepicker({dateFormat: 'yy-mm-dd 23:59'});

    $("#button-toggle").live("click", function(){
        var button = $(this);
        if (! button.hasClass("pressed")) {
            button.addClass("pressed");
            button.val("DESC");
        } else {
            button.removeClass("pressed");
            button.val("ASC");
        }
    });

    showInitialPageLoadDisplay(myjstbl_pul);
});

/**
* proceed the link to the client terminal details module
* @param {int}  rowObj        [get id to the table]
*/
function todetails_fnc(rowObj)
{
    var cnt = myjstbl_pul.get_row_count() - 1;
    var row_index = $(rowObj).parent().parent().index();
    var row_index_val = row_index;
    var values_arr = myjstbl_pul.get_row_values(row_index);
    var id_val = values_arr[colarray_pul['columnClientIDs'].td_class][0];
    var arrayIDs = id_val.split("-");

    window.open("clientterminaldetails?clientgroupid=" + arrayIDs[0] + 
        "&clientheadid=" + arrayIDs[1] + 
        "&clientdetailid=" + arrayIDs[2] + 
        "&clientterminalid=" + arrayIDs[3]);
}

function refresh_clienthead_ddl()
{
    $.get("<?=base_url()?>terminalManagerErrorReportsModule/refresh_clienthead_ddl_control",
    {
        clientgroupid : $("#filterclientgroup").val()
    },
    function(data) {
        document.getElementById("filterclienthead").innerHTML = data;
        $("#filterclienthead").trigger("liszt:updated");
    });
}

function refresh_clientdetail_ddl()
{
    $.get("<?=base_url()?>terminalManagerErrorReportsModule/refresh_clientdetail_ddl_control",
    {
        clientheadid : $("#filterclienthead").val()
    },
    function(data) {
        document.getElementById("filterclient").innerHTML = data;
        $("#filterclient").trigger("liszt:updated");
    });
}

function refresh_client()
{

}

/**
* pul table refresher
* @param {int}  rowStart        [get starting row]
* @param {int}  rowend          [get ending row]
*/
function pul_refresh_table(rowStart = 0, rowend = 0)
{
    let selectedPageNumber = $("#tableid_pul_txtpagenumber").val();
    let limit = clientTerminalTable.getLimitValue();

    if (rowStart) {
        myjstbl_pul.clean_table();
    } else {
        myjstbl_pul.clear_table();
        selectedPageNumber = 1;
    }

    let filterreset_val = 1;
    let rowCount = 0;

    myjstbl_pul.clear_table();
    var tab_clientGroup = $("#filterclientgroup").val();
    var tab_clientHead = $("#filterclienthead").val();
    var tab_clientBranch = $("#filterclient").val();
    var tab_datefrom = $('#txtdatefrom').val();
    var tab_dateto = $('#txtdateto').val();
    var tab_selOrderBy = $('#filter-client-order').val();
    var tab_buttonToggle = $('#button-toggle').val();

    const regex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/;

    if (tab_datefrom.match(regex) === null) {
        alert("Incorrect Date and Time Format\n\nThe format must be: YYYY-MM-DD HH:MM");
        return;
    }

    if (tab_dateto.match(regex) === null) {
        alert("Incorrect Date and Time Format\n\nThe format must be: YYYY-MM-DD HH:MM");
        return;
    }

    $('#lblStatus').css('visibility', 'hidden');
    $.ajax({
        url: "<?=base_url()?>terminalManagerErrorReportsModule/pul_refresh",
        type: "POST",
        data: {
            clientgroupID : tab_clientGroup,
            clientheadID : tab_clientHead,
            clientbranchID : tab_clientBranch,
            datefrom : tab_datefrom,
            dateto : tab_dateto,
            selOrderBy : tab_selOrderBy,
            buttontoggle : tab_buttonToggle,
            filterreset: 1,
            rowstart: rowStart,
            rowend: 0,
            limit: limit
        },
        success:function(data)
        {
            myjstbl_pul.clear_table();
            myjstbl_pul.isRefreshFilterPage = false;
            myjstbl_pul.insert_multiplerow_with_value(1, data.data);

            rowCount = data.rowcnt;

            $("#tableid_pul_txtpagenumber").val(selectedPageNumber);
            clientTerminalTable.setPageCount(rowCount);
            isFirstLoad = false;
        },
        complete: function()
        {
            $("#spanloading").remove();

            clientTerminalTable = new optimizedTable("tableid_pul", {
                searchTable: pul_refresh_table,
                rowStart: $("#tableid_pul_txtpagenumber").val(),
                limit: limit,
                rowCount: rowCount
            });
        }
    });

}

</script>
