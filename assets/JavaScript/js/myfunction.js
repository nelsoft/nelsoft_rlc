// JavaScript Document


function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}

function launchWindow(id,window_height,row_index,page,userid)
{
		resize(window_height);
		//transition effect     
		$('#mask').fadeIn(20);    
		$('#mask').fadeTo("fast",0.9);  
		//transition effect
		$("#dialog").fadeIn(10); 
		if(id!=0){
			$('#pagecontent').html("");
			//popup will be able //to retrieve this string and then be able to call the function that the string calls
			$('#pagecontent').load(page,{wid:id,userid:userid, fncreturn: 'get_data("update",'+row_index+',data_arr)' }); 
		}
		else{
			$('#pagecontent').html("");
			$('#pagecontent').load(page,{userid:userid,fncreturn: 'get_data("insert",'+row_index+',data_arr)'});
		}
}

function updatetablefnc(table,val)
{

var ctr = 0;
var ctr2 = 1; //rows must start with 1 

	while(ctr2 <= table.rows.length){
		
		if(table.rows[ctr2].cells[0].innerHTML == val[0]){
			table.rows[ctr2].cells[1].innerHTML = val[1];
			table.rows[ctr2].cells[2].innerHTML = val[2];
			table.rows[ctr2].cells[3].innerHTML = val[5];
			table.rows[ctr2].cells[4].innerHTML = val[4];
			if(val[3] == 1){
				var cell = table.rows[ctr2].cells[5];
				cell.childNodes[0].setAttribute("checked","checked");
			}
			else{
				var cell = table.rows[ctr2].cells[5];
				cell.childNodes[0].removeAttribute("checked");
			}
			break;
		}
		ctr2++;
	}

}

function atLastPage(elem1,elem2){
	if(elem1.value!=elem2.innerHTML){
		return 0;	
	}
	else{
		return 1;	
	}
}

function addRow(table,wid,fullname,usercode,status,contactnumber,position){
		var row = table.insertRow(table.rows.length);
		var letter = "A";
		var re = new RegExp('^[a-zA-Z0-9]');
		if(re.test(fullname[0].toUpperCase())){ //check if first letter of the first name is a letter
			row.setAttribute("class",fullname[0].toUpperCase()+" all_row all_row_with_value");
		}
		else{									//if it's not a letter, classify as an "other" class
			row.setAttribute("class","other all_row all_row_with_value");	
		}
		if(!atLastPage(document.getElementById("pagenumber"),document.getElementById("lastpage")) || $('#txtfilter').val() != ''){//if not at the last page, hide the row first
			row.setAttribute("style","display:none");		
		}
		var cell1 = row.insertCell(0);
		cell1.innerHTML = wid;
		cell1.setAttribute("style","display:none");
		cell1.setAttribute("class","wid tablerow");
		
	    var cell2 = row.insertCell(1);
		cell2.innerHTML = fullname;
		cell2.setAttribute("class","column_hover column_click tablerow");
		
		var cell3 = row.insertCell(2);
		cell3.innerHTML = usercode;
		cell3.setAttribute("class","column_hover column_click tablerow");
		
		var cell4 = row.insertCell(3);
		cell4.innerHTML = position;
		cell4.setAttribute("class","column_hover column_click tablerow");
		
		var cell5 = row.insertCell(4);
		cell5.innerHTML = contactnumber;
		cell5.setAttribute("class","column_hover column_click tablerow");
		
		var cell6 = row.insertCell(5);
		var checkbox = document.createElement('input');
		checkbox.type = "checkbox";
		checkbox.disabled = true;
		if(status == 1){
			checkbox.checked = "checked";
		}
		cell6.appendChild(checkbox);
		cell6.setAttribute("class","column_hover column_click tablerow");
		
		var cell7 = row.insertCell(6);
		cell7.innerHTML = "<img class=\"deletebutton\" style=\"display:none\" src=\"images/icondelete.png\"/>"
		cell7.setAttribute("class","column_hover tablerow");
}

function resize(window_height)
{
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(document).width();
	 
	     //Set height and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
				
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
			   
		//Set the popup window to center
		$("#dialog").css('top',  window_height+(winH-$("#dialog").height())/2);
		$("#dialog").css('left', winW/2-$("#dialog").width()/2);
}
