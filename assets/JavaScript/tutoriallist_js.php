<script language="javascript" type="text/javascript">
    
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas();
                                    jQuery('.nicEdit-main').attr('contenteditable','false');
                                    jQuery('.nicEdit-panel').hide(); });
    var cur_cat_id = 0;
      
    $(function(){

        $('#jstree').jstree({
            'core' : {
                'data' : {
                    "url" : "tutoriallist/getTopContent_control",
                    "dataType" : "json" // needed only if you do not supply JSON headers
                }
            }
        });


        $("#ddltopic").chosen({allow_single_deselect:true, no_results_text: "data not found"});
        
        $("#ddltopic").change(function(){
            getdata();
        });
        
        $("#btncreate").on('click',function(){
            if($('#jstree').jstree('get_selected').length <= 0){
                alert("please select a category to add on");
                return;
            } 

            //window.open("tutorialform","_blank");
            $("#btndelete").attr("disabled","disabled");
            $("#ddltopic").val(0);
            $("#ddltopic").trigger("liszt:updated");
            $("#txtproblem").val("");
            $('#divcontent').find('.nicEdit-main').html("");

            jQuery('.nicEdit-main').attr('contenteditable','true');
            jQuery('.nicEdit-panel').show();
            $("#img_edit").hide();
            $("#img_update").show();
            $("#divtxtproblem").show();
        });
        
        $("#img_edit").on('click',function(){
            var topicid_val = $("#ddltopic").val();
            if (topicid_val <= 0) {
                alert("Please select a topic to edit.");
                return;
            }

            jQuery('.nicEdit-main').attr('contenteditable','true');
            jQuery('.nicEdit-panel').show();
            $("#img_edit").hide();
            $("#img_update").show();
            $("#divtxtproblem").show();

        });

        $("#img_update").on('click',function(){
            var topicid_val = $("#ddltopic").val();
            var categoryid_val = $('#jstree').jstree('get_selected')[0];
            var problem_val = $.trim(document.getElementById("txtproblem").value);
            var solution_val = $('#divcontent').find('.nicEdit-main').html();

            if( problem_val.length <= 0){
                alert("cannot save empty topic");
                return;
            }

            if(topicid_val == 0) { 
                var fnc_val = "insert_data_control";
            } else { 
                var fnc_val = "update_data_control";
                var r=confirm("Are you sure you want to Update ?");
                if (r==false)
                {
                    return;
                }
            } 
            
            $.post("tutoriallist/"+fnc_val,
                { 
                    topicid: topicid_val,
                    categoryid: categoryid_val,
                    problem: problem_val,
                    solution: solution_val
                },
                function(reply){
                    //var patt1 = new RegExp("Saved");
                    //if (patt1.test(reply))
                    if(reply > 0)
                    {
                        alert("saved");
                        jQuery('.nicEdit-main').attr('contenteditable','false');
                        jQuery('.nicEdit-panel').hide();
                        $("#img_update").hide();
                        $("#img_edit").show();
                        $("#divtxtproblem").hide();

                        cur_cat_id=0;
                        refreshcontent(reply);
                    }
                });

        });
        
        $("#btndelete").on('click',function(){
            var topicid_val = $("#ddltopic").val();
            if (topicid_val <= 0) {
                alert("Please select a topic to delete.");
                return;
            }
            var r=confirm("Are you sure you want to delete ?");
            if (r==true)
            {
                $.post("tutoriallist/delete_tutorial_control",
                    {   topicid : topicid_val },
                    function(reply) {
                        $("#ddltopic").val(0);
                        $("#ddltopic").trigger("liszt:updated");
                        $("#txtproblem").val("");
                        $('#divcontent').find('.nicEdit-main').html("");

                        cur_cat_id=0;
                        refreshcontent();
                    });
            }
            else {
                return;
            }
        });
    
        
        $( "#jstree" ).click(function() {
            //var a = $("#jstree").height();
            //console.log(a);
            //$("#divtutorialcontent, #txtareacontent, #divcontent div + div").css("height", a);
            refreshcontent();
        });
    });

    
    function refreshcontent(selected_id) {
        var selected_id_val = (typeof selected_id !== 'undefined')?selected_id:0;

        if($('#jstree').jstree('get_selected').length <= 0) return;
        var categoryid_val = $('#jstree').jstree('get_selected')[0];
        if(categoryid_val == cur_cat_id) return;
        cur_cat_id = categoryid_val;
        $.get("tutoriallist/refresh_ddltopic_control",
            {   categoryid : categoryid_val },
            function(reply){
                document.getElementById("ddltopic").innerHTML = reply;
                if(selected_id_val>0)$("#ddltopic").val(selected_id_val);
                $("#ddltopic").trigger("liszt:updated");
                getdata();
        });
    }
    
    
    function getdata() {
        var topicid_val = $('#ddltopic').val();
        if(topicid_val == '' || topicid_val == 0){
            $("#txtproblem").val("");
            $('#divcontent').find('.nicEdit-main').html("");
            return;
        } 
        $.getJSON("tutoriallist/get_data_control", 
            {   topicid : topicid_val },
            function(data) {
                $("#btndelete").removeAttr("disabled");
                $("#txtproblem").val($("#ddltopic_chzn .chzn-single span").html());
                $('#divcontent').find('.nicEdit-main').html(data.content);
        });
    }
    
	
</script>