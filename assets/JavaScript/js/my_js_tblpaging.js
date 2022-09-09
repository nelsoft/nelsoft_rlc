// JavaScript Document

function my_js_tblpaging(table_id_var){
	
	this.isOldPaging = false;
	
	this.tableid = table_id_var;
	this.btnprevious_id = table_id_var + "_btnprevious";
	this.btnnext_id = table_id_var + "_btnnext";
	this.txtpagenumber_id = table_id_var + "_txtpagenumber";
	this.divlastpage_id = table_id_var + "_divlastpage";
	this.txtfilternumber_id = table_id_var + "_txtfilternumber";
	
    this.pagingtable = document.createElement('table');
    $(this.pagingtable).addClass("js-paging-table");
    var pagingtbody = document.createElement('tbody');

	var row1 = document.createElement('tr');
	var row2 = document.createElement('tr');
	pagingtbody.appendChild(row1);
	pagingtbody.appendChild(row2);
	
	var cell11 = document.createElement('td');
	var cell12 = document.createElement('td');
	var cell13 = document.createElement('td');
	var cell14 = document.createElement('td');
	var cell15 = document.createElement('td');
	row1.appendChild(cell11);
	row1.appendChild(cell12);
	row1.appendChild(cell13);
	row1.appendChild(cell14);
	row1.appendChild(cell15);
	
    var cell21 = document.createElement('td');
    cell21.style.textAlign = "center";
	cell21.setAttribute("colspan","5");
	row2.appendChild(cell21);
	
	var btnpreviouspage = document.createElement('input');
	btnpreviouspage.type = "button";
	btnpreviouspage.id = this.btnprevious_id;
    btnpreviouspage.value = "Previous";
    $(btnpreviouspage).addClass(table_id_var + "-js-table-input-page-control");
    $(btnpreviouspage).addClass("jst-table-button");
	cell11.appendChild(btnpreviouspage);
	
	var txtpagenumber = document.createElement('input');
	txtpagenumber.type = "text";
	txtpagenumber.id = this.txtpagenumber_id;
	txtpagenumber.value = "1";
    txtpagenumber.size = "3";
    $(txtpagenumber).addClass(table_id_var + "-js-table-input-page-control");
    $(txtpagenumber).addClass("jst-table-text");
	cell12.appendChild(txtpagenumber);
	
	cell13.innerHTML = " / ";
	
	var divlastpage = document.createElement('div');
	divlastpage.id = this.divlastpage_id;
	cell14.appendChild(divlastpage);
	
	var btnnextpage = document.createElement('input');
	btnnextpage.type = "button";
	btnnextpage.id = this.btnnext_id;
    btnnextpage.value = "Next";
    $(btnnextpage).addClass(table_id_var + "-js-table-input-page-control");
    $(btnnextpage).addClass("jst-table-button");
	cell15.appendChild(btnnextpage);
	
	var txtfilternumber = document.createElement('input');
	txtfilternumber.type = "text";
    txtfilternumber.id = this.txtfilternumber_id;
	txtfilternumber.value = "10";
	txtfilternumber.size = "5";
    txtfilternumber.style.textAlign = "center";
    $(txtfilternumber).addClass(table_id_var + "-js-table-input-page-control");
    $(txtfilternumber).addClass("jst-table-text");
    cell21.appendChild(document.createTextNode("Row per page: "));
    cell21.appendChild(txtfilternumber);
	
	this.pagingtable.appendChild(pagingtbody);
	
	this.temp_var_for_page = 1;
	this.base_mysql_interval = 100;
	this.mysql_interval = this.base_mysql_interval;
	this.rowcnt = 0;
	
	this.filter_number = 10;
	this.page_number = 1;
	this.total_pages = Math.ceil(($("#"+this.tableid).children().children().length-1)/this.filter_number);
	//for auto scoll
	this.scroll_val = 0;
	
	var this_var = this;
	
	this.assignScroll_val = assignScroll_val_fnc;
	this.useScroll_val = useScroll_val_fnc;
	this.checkTotalPage = checkTotalPage_fnc;
	this.filterPage = filterPage_fnc;
	this.hideRows = hideRows_fnc;
	this.go_to_last_page = go_to_last_page_fnc;
    this.goToFirstPage = goToFirstPageFunction;
	this.initFilterPage = initFilterPage_fnc;
	this.resetPageFilter = resetPageFilter_fnc;
	this.recheckandsetTotalPage = recheckandsetTotalPage_fnc;
	this.refreshfilterPage = refreshfilterPage_fnc;
	this.resetTotalPageNumber_increase = resetTotalPageNumber_increase_fnc;
	this.set_last_page = set_last_page_fnc;
	this.get_last_page = get_last_page_fnc;
	this.pass_refresh_filter_page = pass_refresh_filter_page_func;
	this.refresh_filter_page_caller;
	this.get_row_range = get_row_range_fnc;
	this.clean_table = clean_table_func;
	this.set_mysql_interval = set_mysql_interval_func;
	this.set_paging_row_cnt = set_paging_row_cnt_func;
	this.get_paging_row_cnt = get_paging_row_cnt_func;
	this.adding_new_row = adding_new_row_func;
	this.deleting_row = deleting_row_func;
	this.get_current_page = get_current_page_func;
	this.clear_event = clear_event_fnc;
	this.go_to_page = go_to_page_fnc;
    this.set_filter_number = setFilterNumberFunction;
    this.disable_buttons = disableButtonsFunction;
	
	$("#"+this.btnprevious_id).live("click",function() {
        if (
            (
                $(this).hasClass("disabled")
                && this_var.page_number != Number($("#"+this_var.txtpagenumber_id).val())
            ) || (
                $(btnnextpage).hasClass("disabled")
                && this_var.page_number != Number($("#"+this_var.txtpagenumber_id).val())
            )
        ) {
            Number($("#"+this_var.txtpagenumber_id).val(this_var.page_number));
        } else if ($(this).hasClass("disabled")) {
            return;
        }
		//$('#lastpage').html(this_var.checkTotalPage()); not sure if still needed
        if((this_var.page_number != 1
            && Number($("#"+this_var.txtpagenumber_id).val())-1) > 0 
            && Number($("#"+this_var.txtpagenumber_id).val()) <= Number( $("#"+this_var.divlastpage_id).html())){
			
            var thisVariable = this;
            var buttonY1 = findYPosition(thisVariable);
            var scrollX1 = (document.all ? document.scrollLeft : window.pageXOffset);
            var scrollY1 = (document.all ? document.scrollTop : window.pageYOffset);
            
            
            this_var.temp_var_for_page--;
			
			if((Number($("#"+this_var.txtpagenumber_id).val())-1)%(Math.ceil(this_var.mysql_interval/this_var.filter_number)) == 0){
				if(this_var.isOldPaging){
					var range = this_var.get_row_range(Number($("#"+this_var.txtpagenumber_id).val())-1);
					this_var.refresh_filter_page_caller(range[0],range[1]);
					this_var.page_number = (Math.ceil(this_var.mysql_interval/this_var.filter_number));
				}
				else{
					this_var.page_number--;	 // needed lang pra sa go to last page. 
				}
			}
			else{
				this_var.page_number--;	
			}
			this_var.assignScroll_val(); 
			this_var.hideRows();
			this_var.filterPage();
			this_var.useScroll_val();
			var temppage = Number($("#"+this_var.txtpagenumber_id).val()) - 1;
            if (temppage != this_var.page_number) {
                temppage = this_var.page_number;
            }
			$("#"+this_var.txtpagenumber_id).val(temppage);	
            
            var buttonY2 = findYPosition(thisVariable);
            var scrollYFinal = (buttonY2 + scrollY1 - buttonY1);
            window.scrollTo(scrollX1, scrollYFinal);

            this_var.disable_buttons();
		}
		else {
            if (Number(this_var.get_last_page()) <= Number($("#"+this_var.txtpagenumber_id).val())) {
                this_var.go_to_last_page();
            } else if (this_var.page_number == 2) {
                this_var.goToFirstPage();
            } else {
                alert("Invalid page number!");
            }
		}
	});

	$("#"+this.btnnext_id).live("click",function() {
        if (
            (
                $(this).hasClass("disabled")
                && this_var.page_number != Number($("#"+this_var.txtpagenumber_id).val())
            ) || (
                $(btnpreviouspage).hasClass("disabled")
                && this_var.page_number != Number($("#"+this_var.txtpagenumber_id).val())
            )
        ) {
            Number($("#"+this_var.txtpagenumber_id).val(this_var.page_number));
        } else if ($(this).hasClass("disabled")) {
            return;
        }
        if (
            Number($("#"+this_var.txtpagenumber_id).val()) > 0
            && Number($("#"+this_var.txtpagenumber_id).val()) < Number($("#"+this_var.divlastpage_id).html())
        ) {
            var thisVariable = this;
            var buttonY1 = findYPosition(thisVariable);
            var scrollX1 = (document.all ? document.scrollLeft : window.pageXOffset);
            var scrollY1 = (document.all ? document.scrollTop : window.pageYOffset);

            this_var.temp_var_for_page++;
            if(Number($("#"+this_var.txtpagenumber_id).val())%(Math.ceil(this_var.mysql_interval/this_var.filter_number)) == 0){
                if(this_var.isOldPaging){
                    var range = this_var.get_row_range(Number($("#"+this_var.txtpagenumber_id).val())+1);
                    this_var.refresh_filter_page_caller(range[0],range[1]);
                    this_var.page_number = 1;
                } else {
                    this_var.page_number++;
                }
            } else {
                this_var.page_number++;
            }
            this_var.assignScroll_val();
            this_var.hideRows();
            this_var.filterPage();
            this_var.useScroll_val();
            var temppage = Number($("#"+this_var.txtpagenumber_id).val()) + 1;
            if (temppage != this_var.page_number) {
                temppage = this_var.page_number;
            }
            $("#"+this_var.txtpagenumber_id).val(temppage);

            var buttonY2 = findYPosition(thisVariable);
            var scrollYFinal = (buttonY2 + scrollY1 - buttonY1);
            window.scrollTo(scrollX1, scrollYFinal);
            this_var.disable_buttons();
        } else {
            if (Number($("#"+this_var.txtpagenumber_id).val()) == 0) {
                this_var.goToFirstPage();
            } else if(this_var.page_number == (Number($("#"+this_var.divlastpage_id).html())-1) ){
                this_var.go_to_last_page();
            } else {
                alert("Invalid page number!");
            }
		}
	});

	$("#"+this.txtpagenumber_id).live("keypress",function(e){
        if (e.which == 8 || e.which == 13 || e.which > 47 && e.which < 58) {
            if(e.keyCode == 13) {
                var page = $.trim($("#"+this_var.txtpagenumber_id).val());
                var restrict = $.isNumeric(Number(page));
                if(page>(Number($("#"+this_var.divlastpage_id).html()))|| page<=0 || page == "" || !restrict ){
                    Number($("#"+this_var.txtpagenumber_id).val(this_var.page_number));
                    alert("Invalid page number!");
                } else {
                    //if in same range, don't refresh_page_filter
                    var currentRange = this_var.get_row_range(this_var.temp_var_for_page);
                    var checked_range = this_var.get_row_range(Number($("#"+this_var.txtpagenumber_id).val()));

                    if(currentRange[0] != checked_range[0] || currentRange[1] != checked_range[1]){
                        if(this_var.isOldPaging){
                           this_var.refresh_filter_page_caller(checked_range[0],checked_range[1]);
                        }
                    }

                    if(this_var.isOldPaging){
                        this_var.page_number = (page%Math.ceil(this_var.mysql_interval/this_var.filter_number) == 0)?
                            Math.ceil(this_var.mysql_interval/this_var.filter_number):
                            page%Math.ceil(this_var.mysql_interval/this_var.filter_number);
                    } else {
                        this_var.page_number = $(this).val();
                    }
                    this_var.assignScroll_val();
                    this_var.hideRows();
                    this_var.filterPage();
                    this_var.useScroll_val();
                    this_var.temp_var_for_page = Number($("#"+this_var.txtpagenumber_id).val());
                }
            }
            this_var.disable_buttons();
        } else {
            e.preventDefault();
            this_var.disable_buttons();
        }
	});

    $("#"+this.txtfilternumber_id).live("keypress",function(e) {
        if (e.which == 8 || e.which == 13 || e.which > 47 && e.which < 58) {
            if(e.keyCode == 13) {
                var page = $.trim($("#"+this_var.txtfilternumber_id).val());
                var restrict = $.isNumeric(Number(page));

                if(page <= 0) {
                    alert("Value must be greater than 0");	
                } else if (!restrict || page == "") {
                    alert("Value must be a number");
                } else {
                    this_var.filter_number = Number(page);
                    if (this_var.isOldPaging) {
                        this_var.mysql_interval = this_var.base_mysql_interval;
                        while (this_var.mysql_interval % page != 0) {
                            this_var.mysql_interval++;
                        }
                        this_var.refresh_filter_page_caller();
                    }
                    this_var.resetPageFilter();	
                }
            }
            this_var.disable_buttons();
        } else {
            e.preventDefault();
            this_var.disable_buttons();
        }
    });

}

function findYPosition(object)
{
    var currentTop = 0;
    if (object.offsetParent) {
        do {
            currentTop += object.offsetTop;
        } while (object = object.offsetParent);
    }
    return currentTop;
}

function setFilterNumberFunction(value)
{
    this.filter_number = value;
    $("#"+this.txtfilternumber_id).val(value);
    this.disable_buttons();
}

function set_mysql_interval_func(val){
	this.base_mysql_interval = val;
	this.mysql_interval = val;
}
function clean_table_func(){
	this.assignScroll_val();
	this.hideRows();
	this.filterPage();	
	this.useScroll_val();
}
function get_row_range_fnc(start){
	
	var page =  start*this.filter_number;
	var interval = this.mysql_interval;
	if(Number(this.filter_number)>this.mysql_interval){
		this.mysql_interval = this.filter_number;
		interval = this.filter_number;
	}
	if(page%interval == 0 ){//if not included, value for temp_page and page can be 100 to 100 or 200 to 200
		page -= 1; 
	}
	var temp_page = page;
	
	while(page%interval != 0){ //get the upper limit of the interval
		page++;
	}
	while(temp_page%interval != 0){ //lower limit
		temp_page--;
	}
	//alert(temp_page+" and "+(page-1));
	//values will be like 0 - 99 instead of 1-100 since sql needs to start from 0
	return [temp_page,page-1];
}
function set_last_page_fnc(val){
	$("#"+this.divlastpage_id).html(val);
}
function set_paging_row_cnt_func(val){
	this.rowcnt = val;
}
function get_paging_row_cnt_func(){
	return this.rowcnt;
}
function adding_new_row_func(true_row_cnt){
	// myjstbl.rowcnt - 2 is also needed since the blank row shows up at the last 
	// page where data is available.(after refreshed / new loaded page) 
	this.rowcnt++;
	
	if((Number(true_row_cnt) - 1)%this.filter_number == 0 ||
	   (Number(true_row_cnt) - 2)%this.filter_number == 0 ){
		 
		 //Math.ceil((this.get_paging_row_cnt()+1)/this.filter_number )){  
	   if((Number(this.get_last_page()) + 1)<=
				Math.ceil((this.get_paging_row_cnt())/this.filter_number )){
			var temppage =Number(this.get_last_page()) + 1;
			this.set_last_page(temppage);
	   }
	   
	}
}
function deleting_row_func(true_row_cnt){
	this.rowcnt--;
	if((Number(true_row_cnt) - 1)%this.filter_number == 0){
		var temppage =Number(this.get_last_page()) - 1;
		this.set_last_page(temppage);
		
		//if current page > last page after deleting, go to last page.
		if(this.get_current_page() > this.get_last_page()){
			this.go_to_last_page();
		}
	}
}
function get_current_page_func(){
	return $("#"+this.txtpagenumber_id).val();
}
function get_last_page_fnc(){
	return $("#"+this.divlastpage_id).html();
}
function pass_refresh_filter_page_func(fnc){
    this.refresh_filter_page_caller = fnc;
}
function assignScroll_val_fnc(){
	this.scroll_val = $(window).scrollTop();
}
function useScroll_val_fnc(){
	window.scroll(0,this.scroll_val); 
}
function checkTotalPage_fnc(){//working
		//check total pages again so that it's updated if there was an insert before. 
		this.total_pages = Math.ceil(($("#"+this.tableid).children().children().length-1)/this.filter_number);
		return this.total_pages;
}
function filterPage_fnc(){//working
	var start = (this.page_number - 1)*this.filter_number + 1;
	var increment_val = this.filter_number;
	var total_row_number = $("#"+this.tableid).children().children().length;
    var table = document.getElementById(this.tableid);
	var ctr = start;
	while(ctr<=start+increment_val-1 && ctr<total_row_number){
		rows = table.rows[ctr];
		rows.style.display = "table-row";
		ctr++;	
    }

	if(ctr < total_row_number){
		rows = table.rows[ctr];
        rows.style.display = "none";
    }

    if (ctr >= 1 && total_row_number == 1) {
        var tableIdStr = this.tableid;
        $("#" + tableIdStr).hide();
        var loadingTableBarId = tableIdStr + "-loading-table-bar";
        $("#" + tableIdStr + "-initial-table-bar").remove();
        if ($("#" + loadingTableBarId).length < 1) {
            $("." + tableIdStr + "-js-table-input-page-control").prop("disabled", true);
            var loadingTableBar = "";
            loadingTableBar += "<div id='"+ loadingTableBarId +"' class='js-table-loading-data'>";
            loadingTableBar += "    <img src='assets/images/loading.gif'>";
            loadingTableBar += "</div>";
            $("#" + tableIdStr).after(loadingTableBar);
        }
    }
    this.disable_buttons();
}
function hideRows_fnc(){//working
	//$("#"+this.tableid).find(".table-row").css("display","none");
	$("#"+this.tableid).children().children().css("display","none");
	$("#"+this.tableid).children().children().eq(0).show();
	/*
	for(var ctr =1; ctr<=$("#"+this.tableid).children().children().length;ctr++){
		$("#"+this.tableid).children().children().eq(ctr).hide();
	}*/
}

function go_to_last_page_fnc(){
	if(!this.isOldPaging)
	{
		$("#"+this.divlastpage_id).html(this.checkTotalPage());
		$("#"+this.txtpagenumber_id).val(this.checkTotalPage());
		this.page_number = $("#"+this.divlastpage_id).html();
	}
	else{
		$("#"+this.txtpagenumber_id).val($("#"+this.divlastpage_id).html());
		this.go_to_page($("#"+this.divlastpage_id).html());
	}
	this.assignScroll_val();
	this.hideRows();
	this.filterPage();
    this.useScroll_val();
    this.disable_buttons();
}

/**
 * Go to first paging of JS Table
 */
function goToFirstPageFunction()
{

    $("#"+this.divlastpage_id).html(this.checkTotalPage());
    $("#"+this.txtpagenumber_id).val(1);
    this.page_number = 1;
    this.assignScroll_val();
    this.hideRows();
    this.filterPage();
    this.useScroll_val();
    this.disable_buttons();
}

function go_to_page_fnc(toPage){
	var currentRange = this.get_row_range(this.temp_var_for_page); 
	var checked_range = this.get_row_range(Number(toPage)); 
	//alert(cur_range+ " " +checked_range);
	if(currentRange[0] != checked_range[0] || currentRange[1] != checked_range[1]){
		if(this.isOldPaging){
			this.refresh_filter_page_caller(checked_range[0],checked_range[1]);
		}
	}
	this.page_number = (Number($("#"+this.divlastpage_id).html())%Math.ceil(this.mysql_interval/this.filter_number) == 0)?
					Math.ceil(this.mysql_interval/this.filter_number):
					Number($("#"+this.divlastpage_id).html())%Math.ceil(this.mysql_interval/this.filter_number);
	this.temp_var_for_page = Number($("#"+this.divlastpage_id).html());
    $("#" + this.tableid + "-loading-table-bar").remove();
    $("#" + this.tableid).show();
    $("." + this.tableid +"-js-table-input-page-control").prop("disabled", false);
    this.disable_buttons();
}

function initFilterPage_fnc(){//working
	//initial filtering of page
	this.hideRows();
	this.filterPage();
	//set total number of pages
    $("#"+this.divlastpage_id).html(this.checkTotalPage());
    $("." + this.tableid + "-js-table-input-page-control").prop("disabled", true);
    this.disable_buttons();
}

function resetPageFilter_fnc(){//working
	//reset values of filtering 
	this.temp_var_for_page = 1;
	this.page_number = 1;
	$("#"+this.txtpagenumber_id).val(1);
	this.assignScroll_val();
	this.hideRows();
	this.filterPage();	
	this.useScroll_val();
	
	if(!this.isOldPaging)
	{
		$("#"+this.divlastpage_id).html(this.checkTotalPage());
	}	
    this.disable_buttons();
}

function resetTotalPageNumber_increase_fnc(){
	this.hideRows();
	this.filterPage();
	$("#"+this.divlastpage_id).html(this.checkTotalPage());
    this.disable_buttons();
}

function recheckandsetTotalPage_fnc(){
	var current_displayed_total_pages = Number($("#"+this.divlastpage_id).html());
	if(current_displayed_total_pages != this.checkTotalPage()){
		if(this.page_number > this.checkTotalPage())
		{
			this.page_number = this.checkTotalPage();
			$("#"+this.txtpagenumber_id).val(this.page_number);
		}
		this.filterPage();
		$("#"+this.divlastpage_id).html(this.checkTotalPage());
	}
    this.disable_buttons();
}

function refreshfilterPage_fnc(){
	
	if((Number($("#"+this.divlastpage_id).html()) == 1) || (Number($("#"+this.divlastpage_id).html()) == 0)){
		this.page_number = 1;
		$("#"+this.txtpagenumber_id).val(1); 
	}
	
	if(Number($("#"+this.txtpagenumber_id).val()) > (Number($("#"+this.divlastpage_id).html())) 
								&& (Number($("#"+this.divlastpage_id).html())) > 0)
	{
		$("#"+this.txtpagenumber_id).val(Number($("#"+this.divlastpage_id).html()));
		this.page_number = this.mysql_interval;
	}
	this.assignScroll_val();
	this.hideRows();
	this.filterPage();
	this.useScroll_val();
	
	if(!this.isOldPaging)
	{
		$("#"+this.divlastpage_id).html(this.checkTotalPage());
	}
    this.disable_buttons();
}

function clear_event_fnc(){
	$("#"+this.btnprevious_id).unbind("click");
	$("#"+this.btnnext_id).unbind("click");
	$("#"+this.txtpagenumber_id).unbind("keypress");
	$("#"+this.txtfilternumber_id).unbind("keypress");
}

function disableButtonsFunction()
{
    var page = $.trim($("#"+this.txtpagenumber_id).val());
    var lastPage = $("#"+this.divlastpage_id).html();

    if (page == 1 && lastPage > 1) {
        $("#"+this.btnprevious_id).addClass("disabled");
        $("#"+this.btnnext_id).removeClass("disabled");
        $("#"+this.btnnext_id).removeAttr("disabled");
    }
    else if (page == 1 && lastPage == 1) {
        $("#"+this.btnprevious_id).addClass("disabled");
        $("#"+this.btnnext_id).addClass("disabled");
        $("#"+this.btnprevious_id).attr("disabled","disabled");
        $("#"+this.btnnext_id).attr("disabled","disabled");
    }
    else if (page == lastPage && page > 1) {
        $("#"+this.btnprevious_id).removeClass("disabled");
        $("#"+this.btnnext_id).addClass("disabled");
        $("#"+this.btnprevious_id).removeAttr("disabled");
    } else {
        $("#"+this.btnprevious_id).removeClass("disabled");
        $("#"+this.btnnext_id).removeClass("disabled");
        $("#"+this.btnprevious_id).removeAttr("disabled");
        $("#"+this.btnnext_id).removeAttr("disabled");
    }
}
