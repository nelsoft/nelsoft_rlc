

<script language="javascript" type="text/javascript">
    var managementPosition = $("#label-status-password").val();

$(function(){
    window.onbeforeunload = function (e) {
        tab=null;       myjstbl=null; txtname=null;
        spnwid=null;    chkselect=null; txtcode=null; spncode=null;  
        spnname=null;   imgUpdate=null; imgEdit=null; imgDelete=null;
    }

    $("#password-generator.modal-backdrop, #password-generator.fade, #password-generator.in").click(function(event)
    {
        var id = event.target.id;
        if (id == "password-generator" || id == "close-modal") {
            $("#label-checker-password").text("NO DATA FOUND");
            $("#encrypted-text-checker").val("");
            $("#password-generator-tabs li a:first").click();
            $("#date-text-generator").val($.datepicker.formatDate('yy-mm-dd', new Date()));
        } else {
            return;
        }
    });
});

// function NT_EnterUpdate(e, x){
    // if(e.keyCode == 13) NT_updateSelectedRow(x);
// }

// function NT_Load_Popup( popup_sel, popup_site, data_sent_array ){
    // alert(popup_sel);
    // alert(popup_site);
    // alert(data_sent_array);
    // $(popup_sel).load(popup_site,data_sent_array);
// }

// function Base_FillLastCode( myTable = myjstbl ){
    // var command = _pageName+"/fillLastCode_control";
    // var cnt = myTable.get_row_count();
    // $.post(command,{},
        // function(reply) {
            // myTable.setvalue_to_rowindex_tdclass([reply], cnt-1, colarray[_colArrayCode].td_class);
            // if (_isTestMode == 1) MT.NT_LogPrint("Fill_Last_Code = " + (myTable.get_row_count()-1));
            // runMTrecursiveTest();
        // });
// }

// function NT_Click(Control, FuncCall){
    // $(Control).click(function(e){   FuncCall();  }
// )}

function NT_editSelectedRow( myTable, rowObj){

    var rowindex = $(rowObj).parent().parent().index();
    myTable.edit_row(rowindex);
    // document.getElementById(_lblStatus).innerHTML = "<br\>";
}

// function NT_FocusLastRow( myTable, tag = ".txtname" ){
   // myTable.mypage.go_to_last_page(); 
   // $(tag).last().focus();
// }

// function NT_btnOrderToggled(){
    // var btn = $(_btnToggle) ;
    // if (btn.val() == "ASC") btn.val("DESC");
    // else    btn.val("ASC");
// }

/**
 * display modal for generating password
 */
function generatePasswordModal()
{
    $("#password-generator").modal("show");

    $("#date-text-generator").datepicker({dateFormat: 'yy-mm-dd'});
    $("#date-text-generator").val($.datepicker.formatDate('yy-mm-dd', new Date()));
    generatePassword();
}

$(".ul-tabs").find("li").die("click").live("click", function()
{
    $(this).parent().find("li").each(function()
    {
        $(this).removeAttr("class");
    });

    $(this).attr("class", "active");
});

$("#tab-generator").live("click", function()
{
    $(".tabs-generator-content").show();
    $(".tabs-checker-content").hide();
});

$("#tab-checker").live("click", function()
{
    $(".tabs-generator-content").hide();
    $(".tabs-checker-content").show();
});

/**
 * generate new password for the given user and date
 */
function generatePassword()
{
    var inputDate = $("#date-text-generator").val();

    if (! isValidDate(inputDate) || managementPosition == 7) {
        $('#label-generated-password').text("Incorrect date format");
        return;
    }

    $.ajax(
    {
        url: "<?=base_url()?>controlpanel/generatePasswordDetails",
        type: "POST",
        data: {
            date: inputDate
        },
        success: function(data)
        {
            $('#label-generated-password').text(data);
        }
    });
}

/**
 * check the equivalent decypted password for the input text
 */
function checkPassword()
{
    var encryptedPassword = $("#encrypted-text-checker").val();

    if (encryptedPassword == "") {
        $('#label-checker-password').text("Please input encrypted password");
        return;
    }

    $.ajax(
    {
        url: "<?=base_url()?>controlpanel/checkPasswordDetails",
        type: "POST",
        data: {
            encryptedPassword: encryptedPassword
        },
        success: function(data)
        {
            if (data == "") {
                $("#label-checker-password").text("NO DATA FOUND");
            } else {
                $('#label-checker-password').text(data);
            }
        }
    });
}
</script>