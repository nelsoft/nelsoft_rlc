<script language="javascript" type="text/javascript">
	var interval = 5000;
	var pages = 1;
	var run = setInterval(reload_data , 100);
	var page_change;
	var total_pages = 0;
	//reload_data();

	function build_panel(datas)
	{
		var withs_1 = (datas[12][0] <= 1) ? "day" : "days";
		var withs_2 = (datas[14][0] <= 1) ? "day" : "days";

		var alertMsg = '';
		if (datas[11]==1) {
			alertMsg = '<i class="fa fa-exclamation-triangle fa-lg" style="color:#AF0303;"></i>';
		};
		var temp_1 = (datas[12][0]!= 0) ? datas[12][0]+" "+withs_1 : "";
		var temp_2 = (datas[14][0]!= 0) ? datas[14][0]+" "+withs_2 : "";

		var string = '<div class="each-panel-emp '+datas[6][0]+'">';
		string += '<div><img src="assets/images/'+datas[5][0]+'.jpg" class="img-employee"></div>';
		string += '<div class="each-panel-details">';
		string += '<div><span class="issue-number"><b>#'+datas[1][0]+'</b></span>'+alertMsg+'&nbsp;&nbsp;<span class="problem-type">'+datas[0][0]+'</span></div>';
		string += '<div><span class="reporter">['+datas[5][0].toUpperCase()+']</span></div>';
		string += '<div class="reported-by">'+datas[13][0]+'</div>';
		string += '</div>';
		string += '<div class="right-panel-details">';
		string += '<div class="days"></div>';
		string += '<div class="duration"><span class="day-status">'+temp_1+'</span>&nbsp;&nbsp;<span class="hour-status">'+datas[9][0]+'</span>:<span class="minutes-status">'+datas[10][0]+'</span></div>';
		if (datas[17][0]!='') {
			string += '<div class="resolved-duration"><span class="day-status">'+temp_2+'</span>&nbsp;&nbsp;<span class="hour-status">'+datas[15][0]+'</span>:<span class="minutes-status">'+datas[16][0]+'</span></div>';
		};
		string += '</div></div>';
		return string;
	}

	function build_structure(data)
	{
		var content = "";
		var counter = 0;
		var pageCounter = 0;

		for (var i=0; i < data.length; i++) {
			counter++;
			if (counter==1) {
				pageCounter++;
				content += (pageCounter==1) ? "<div class='page page"+pageCounter+"'>" : "<div class='page page"+pageCounter+"' style='display:none'>";
			}

			content += build_panel(data[i]);
			
			if (counter==16) {
				content += "</div>";
				counter = 0;
			}
		}

		return content;
	}

	function reload_data()
	{
		$.getJSON("bugtracker_dev/reload_data",
        {  
        	devs : '<?php echo isset($_GET["devs"])?$_GET["devs"]:"" ?>'
        },
        function(data) { 
        	clearInterval(page_change);
        	clearInterval(run);
        	pages = 1;
        	var content = build_structure(data.detail);
        	reload_today_data(data.totaltoday);
        	reload_displayed_data(data.totaldisplay);
            $(".main-divide").html(content);
			total_pages = $(".page").length;
            var temp_interval = interval * total_pages;
            if (total_pages!=1) {        	
            	page_change = setInterval(change_page ,5000);
            }
			$("#page-no").html("Page 1 of "+total_pages);
            run = setInterval(reload_data , temp_interval);
   		});
	}

	function change_page()
	{
		$(".page"+pages).css("display","none");
		pages++;
		$(".page"+pages).css("display","block");
		$("#page-no").html("Page "+pages+" of "+total_pages);
		if(pages==total_pages){
			clearInterval(page_change);
		}
	}

	function reload_today_data(datas)
	{	
		var content = "";
	
		for (var i = 0; i < datas.length; i++) {
			if ((i+1)==datas.length) {
				$("#todayTotal").html(datas[i][0]);
			}
			else
			{
				var color = "closed-color";

				switch(datas[i][0])
				{
					case "Class S":
						color = "new-color";
					break;

					case "Class A":
						color = "assigned-color";
					break;

					case "Class B":
						color = "resolved-color";
					break;
				}

				content += "<div class='status-contents "+color+"'><div class='status-label'># of "+datas[i][0]+":</div><div class='status-number'><span>"+datas[i][1]+"</span></div></div>";
			};
		}
		
		$("#content-category").html(content);
	}

	function reload_displayed_data(datas)
	{
		$("#displayedNew").text(datas[0][0]);
		$("#displayedAssigned").text(datas[1][0]);
		$("#displayedResolved").text(datas[2][0]);
		$("#displayedFeedback").text(datas[3][0]);
		$("#displayedTotal").text(datas[4][0]);
	}
</script>