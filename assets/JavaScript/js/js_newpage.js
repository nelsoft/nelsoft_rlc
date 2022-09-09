// JavaScript Document

function my_page(table_id_var, btnprevious_id_var, btnnext_id_var,txtpagenumber_id_var,divlastpage_id_var,txtfilternumber_id_var){
	this.tableid = table_id_var;
	this.btnprevious_id = btnprevious_id_var;
	this.btnnext_id = btnnext_id_var;
	this.txtpagenumber_id = txtpagenumber_id_var;
	this.divlastpage_id = divlastpage_id_var;
	this.txtfilternumber_id = txtfilternumber_id_var;
	
	this.filter_start=1;
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
	this.initFilterPage = initFilterPage_fnc;
	this.resetPageFilter = resetPageFilter_fnc;
	this.recheckandsetTotalPage = recheckandsetTotalPage_fnc;
	this.refreshfilterPage = refreshfilterPage_fnc;
	
	
	
	$("#"+this.btnprevious_id).live("click",function() {
		//$('#lastpage').html(this_var.checkTotalPage()); not sure if still needed
		if((this_var.page_number-1) > 0){
			this_var.filter_start -= this_var.filter_number;
			this_var.assignScroll_val(); 
			this_var.hideRows();
			this_var.filterPage(this_var.filter_start,this_var.filter_number);
			this_var.useScroll_val();
			this_var.page_number--;
			$("#"+this_var.txtpagenumber_id).val(this_var.page_number);
		}
	});
	
	$("#"+this.btnnext_id).live("click",function() {
		if((this_var.page_number) < Number(this_var.total_pages)){
			this_var.filter_start = this_var.filter_start + this_var.filter_number;
			this_var.assignScroll_val(); 
			this_var.hideRows();
			this_var.filterPage(this_var.filter_start,this_var.filter_number);
			this_var.useScroll_val();
			this_var.page_number++;
			$("#"+this_var.txtpagenumber_id).val(this_var.page_number);			
		}
	});
	
	$("#"+this.txtpagenumber_id).keypress(function(e){
		if(e.keyCode == 13){
			var page = $("#"+this_var.txtpagenumber_id).val();
			var re = $.isNumeric(Number(page));
			
			if(page>this_var.checkTotalPage()|| page<=0 || !re ){
				alert("wrong input");
			}
			else{
				this_var.checkTotalPage();
				this_var.filter_start = (page*this_var.filter_number)-(this_var.filter_number-1);
				this_var.assignScroll_val(); 
				this_var.hideRows();
				this_var.page_number = page;
				this_var.filterPage(this_var.filter_start,this_var.filter_number);
				this_var.useScroll_val();
			}
			
		}
	});

	$("#"+this.txtfilternumber_id).keypress(function(e){
		if(e.keyCode == 13){
			var page = $("#"+this_var.txtfilternumber_id).val();
			var re = $.isNumeric(Number(page));
			
			if(page<0 || !re ){
				if(page<0){
					alert("Value must be greater than 0");	
				}
				if(!re){
					alert("Value must be a number");
				}
			}
			else{
				
				if(page<=Math.ceil($("#"+this_var.tableid).children().children().length-1)){
					this_var.filter_number = Number(page);
				}
				else{
					this_var.filter_number = Math.ceil($("#"+this_var.tableid).children().children().length-1);
				}
				this_var.resetPageFilter();	
				
			}
			
		}
	});
	
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
function filterPage_fnc(start,increment_val){//working
	var total_row_number = $("#"+this.tableid).children().children().length;
	var table = document.getElementById(this.tableid);
	var ctr = start;
	while(ctr<=start+increment_val-1 && ctr<total_row_number){
		rows = table.rows[ctr];
		rows.style.display = "table-row";
		ctr++;	
	}
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
	
	$("#"+this.divlastpage_id).html(this.checkTotalPage());
	$("#"+this.txtpagenumber_id).val(this.checkTotalPage());
	this.page_number = $("#"+this.divlastpage_id).html();
	this.filter_start = ($("#"+this.tableid).children().children().length-1) - (($("#"+this.tableid).children().children().length-1)%this.filter_number) + 1;
	
	if((($("#"+this.tableid).children().children().length-1)%this.filter_number) == 0){
		this.filter_start -= this.filter_number;//needed because of the excess 1 row in the beginning for the header. 
	};
	this.assignScroll_val();
	this.hideRows();
	this.filterPage(this.filter_start,this.filter_number);	
	this.useScroll_val();				
}
function initFilterPage_fnc(){//working
	//initial filtering of page
	this.hideRows();
	this.filterPage(this.filter_start,this.filter_number);
	//set total number of pages
	$("#"+this.divlastpage_id).html(this.checkTotalPage());
}
function resetPageFilter_fnc(){//working
	//reset values of filtering 
	this.page_number = 1;
	this.filter_start = 1;
	$("#"+this.txtpagenumber_id).val(1);
	this.assignScroll_val();
	this.hideRows();
	this.filterPage(this.filter_start,this.filter_number);	
	this.useScroll_val();			
	//get new value for total_pages since items per page is changed
	$("#"+this.divlastpage_id).html(this.checkTotalPage());
}
function recheckandsetTotalPage_fnc(){
	var current_displayed_total_pages = Number($("#"+this.divlastpage_id).html());
	if(current_displayed_total_pages != this.checkTotalPage()){
		if(this.page_number > this.checkTotalPage())
		{
			this.page_number = this.checkTotalPage();
			this.filter_start = (this.page_number*this.filter_number)-(this.filter_number-1);
			$("#"+this.txtpagenumber_id).val(this.page_number);
		}
		this.filterPage(this.filter_start,this.filter_number);
		$("#"+this.divlastpage_id).html(this.checkTotalPage());
	}
}
function refreshfilterPage_fnc(){
		
	if(this.page_number > this.checkTotalPage())
	{
		this.page_number = this.checkTotalPage();
		$("#"+this.txtpagenumber_id).val(this.page_number);
		this.filter_start = (this.page_number*this.filter_number)-(this.filter_number-1);
	}
	$("#"+this.divlastpage_id).html(this.checkTotalPage());
	
	this.assignScroll_val();
	this.filterPage(this.filter_start,this.filter_number);
	this.useScroll_val();
	
}