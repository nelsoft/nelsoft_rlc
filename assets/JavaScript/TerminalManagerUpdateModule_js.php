<script type="text/javascript">
    var isAllowImageUpdate = true;
    var maxFileSize = 7000000;
    var maxLengthText = 999028;
    var fileSizeLimit = 10000000;
    var isEditFolder = false;
    var previous = [];
    var previous_id = "";
    var parent_id = "";
    var parent_id1 = "";
    var jsTreeRefresh = true;
    var ajaxRequest;

    var terminalIDs = [];
    var terminalOriginalIDs = [];
    var terminalSaves = [];
    var functionName = "";

    var myJsTableTerminalManager;
    var tableTerminalManager = document.createElement('table');
    tableTerminalManager.id = "table-terminal-id";
    tableTerminalManager.className = "table table-bordered";
    var columnTerminalManager = [];

    var hiddenId = document.createElement('span');
    hiddenId.type = "hidden";
    hiddenId.setAttribute("style", "display: none");
    columnTerminalManager['columnID'] = {
        header_title: "",
        edit: [hiddenId],
        disp: [hiddenId],
        td_class: "tablerow td-hidden-id",
        headertd_class: "tdclick td-hidden-id"
    };

    var spanUploadID = document.createElement('span');
    spanUploadID.className = "span-upload-id";
    spanUploadID.innerHTML = "";
    columnTerminalManager['columnUploadID'] = {
        header_title: "Upload ID",
        edit: [spanUploadID],
        disp: [spanUploadID],
        td_class: "tablerow tdall td-upload-id tdpopuphover",
        headertd_class: "tdclick td-upload-id"
    };

    var spanSoftware = document.createElement('span');
    spanSoftware.className = "span-software";
    spanSoftware.innerHTML = "";
    columnTerminalManager['columnSoftware'] = {
        header_title: "Software",
        edit: [spanSoftware],
        disp: [spanSoftware],
        td_class: "tablerow tdall td-software",
        headertd_class: "tdclick td-software"
    };

    var spanCtd_ID = document.createElement('span');
    spanCtd_ID.className = "span-Ctd";
    spanCtd_ID.innerHTML = "";
    columnTerminalManager['columnCtd'] = {
        header_title: "Client",
        edit: [spanCtd_ID],
        disp: [spanCtd_ID],
        td_class: "tablerow tdall td-ctd",
        headertd_class: "tdclick td-ctd"
    };

    var spanTerminal = document.createElement('span');
    spanTerminal.className = "span-terminal";
    spanTerminal.innerHTML = "";
    columnTerminalManager['columnTerminal'] = {
        header_title: "Terminal #",
        edit: [spanTerminal],
        disp: [spanTerminal],
        td_class: "tablerow tdall td-terminal",
        headertd_class: "tdclick td-terminal"
    };

    var spanOldVersion = document.createElement('span');
    spanOldVersion.className = "span-old-version";
    spanOldVersion.innerHTML = "";
    columnTerminalManager['columnOldVersion'] = {
        header_title: "Old Version",
        edit: [spanOldVersion],
        disp: [spanOldVersion],
        td_class: "tablerow tdall td-old-version",
        headertd_class: "tdclick td-old-version"
    };

    var spanUpdateVersion = document.createElement('span');
    spanUpdateVersion.className = "span-update-version";
    spanUpdateVersion.innerHTML = "";
    columnTerminalManager['columnUpdateVersion'] = {
        header_title: "Update Version",
        edit: [spanUpdateVersion],
        disp: [spanUpdateVersion],
        td_class: "tablerow tdall td-update-version",
        headertd_class: "tdclick td-update-version"
    };

    var spanInstalledOn = document.createElement('span');
    spanInstalledOn.className = "span-installed-on";
    spanInstalledOn.innerHTML = "";
    columnTerminalManager['columnInstalledOn'] = {
        header_title: "Installed On",
        edit: [spanInstalledOn],
        disp: [spanInstalledOn],
        td_class: "tablerow tdall td-installed-on",
        headertd_class: "tdclick td-installed-on"
    };

    var spanRemarks = document.createElement('span');
    spanRemarks.className = "span-remarks";
    spanRemarks.innerHTML = "";
    columnTerminalManager['columnRemarks'] = {
        header_title: "Remarks",
        edit: [spanRemarks],
        disp: [spanRemarks],
        td_class: "tablerow tdall td-remarks",
        headertd_class: "tdclick td-remarks"
    };

    var spanStatus = document.createElement('span');
    spanStatus.className = "span-status";
    spanStatus.innerHTML = "";
    columnTerminalManager['columnStatus'] = {
        header_title: "Status",
        edit: [spanStatus],
        disp: [spanStatus],
        td_class: "tablerow tdall td-status",
        headertd_class: "tdclick td-status"
    };

    //Actions
    var deleteTerminal = document.createElement('img');
    deleteTerminal.src = "assets/images/icondelete.png";
    deleteTerminal.setAttribute("onclick", "deleteTerminals(this)");
    deleteTerminal.style.cursor = "pointer";
    columnTerminalManager['columnDeleteTerminal'] = {
        header_title: "",
        edit: [deleteTerminal],
        disp: [deleteTerminal],
        td_class: "tablerow td-terminal-delete",
        headertd_class: "hddelete td-terminal-delete"
    };

    /**
     * Load folder list
     */
    function loadFolderList(isRefresh = false, val = 1000, type =1)
    {
        urllink = "TerminalManagerUpdateModule/getTopContent_control?value="+val+"&type="+type;

        $("#js-tree-content").jstree({
            core: {
                data: {
                    "url" : urllink,
                    "dataType" : "json", // needed only if you do not supply JSON headers
                    'multiple': false
                }
            },
            'checkbox': {
                three_state: false,
                two_state: false,
                'cascade': 'down',
                'multiple': false,
                "keep_selected_style" : false,
                "tie_selection" : false,
                'deselect_all': true
            },
            
            "plugins": ["themes", "json_data", "ui", "checkbox"]
        });

        $("#js-tree-content").on("check_node.jstree", function(event, data){
            var selectedNodes = $("#js-tree-content").jstree().get_checked();

            terminalIDs = [];
            terminalOriginalIDs = [];

            terminalIDs = selectedNodes;
            terminalOriginalIDs = selectedNodes;

            for ( var i = 0; i < selectedNodes.length; i++){ 
                if ( selectedNodes[i] === previous) { 
                    unset(data.node.id);
                }
            }

            let idvalue = data.node.id;
            let value = document.getElementById(data.node.id).getAttribute("value");
            let descriptionval = document.getElementById(data.node.id).getAttribute("description");


            let posName = data.node.text;

            $("#text-value").val(posName);
            $("#category-value").val(value);
            $("#id-value").val(idvalue);
            let idval = ('#' + idvalue);
            let parentsvalue = data.node.parents.toString();
            myArray = parentsvalue.split(",");

            if (value == "branch" || value == "terminal")  {
                //removing of parents or grand parents
                for (var i = 0; i < myArray.length; i++) {
                    var index = terminalIDs.indexOf(myArray[i]);
                    if (index > -1) {
                      terminalIDs.splice(index, 1);
                    }
                }

            } else if (value == "group"){
                //removing of all child not the terminals
                for (var i = 0; i < data.node.children.length; i++) {
                    var index2 = terminalIDs.indexOf(data.node.children[i]);
                    if (index2 > -1) {
                      terminalIDs.splice(index2, 1);
                    }
                }
            }

            //removing of selfs either group or branch not terminals
            if (value == "branch" || value == "group"){
                var index = terminalIDs.indexOf(idvalue);
                
                if (index > -1) {
                    terminalIDs.splice( $.inArray(idvalue,terminalIDs) ,1 );
                }
            }

            var pNode = data.node.parent;
            var children = data.instance.get_node(pNode).children;

            var countCheck = 0;
            if (children.length > 0) {
                for (var i = 0; i < children.length; i++) {
                    var result = $("#js-tree-content").jstree().is_checked(children[i]);
                    if (result) {
                        countCheck++;
                    }
                }

                if (countCheck == children.length){
                    $("#js-tree-content").jstree().check_node(pNode);
                }
            }

            if ((data.node.children.length == 0) && (value == "branch"||value == "group")) {
                $("#client-label").html("");
                refresh_empty_dropdown();
                $("#source").prop("disabled", true);
                $("#softwareversion").prop("disabled", true);
                $("#remarks-text").prop("disabled", true);
                $(".bttn-save").attr("disabled", true);
            } else {
                var selectedNodesAfter = $("#js-tree-content").jstree().get_checked();

                if (selectedNodesAfter.length == 0) {
                    $("#client-label").html("");
                    $("#source").prop("disabled", true);
                    $("#softwareversion").prop("disabled", true);
                    $("#remarks-text").prop("disabled", true);
                    $(".bttn-save").attr("disabled", true);
                } else {
                    //$("#client-label").html(descriptionval);
                    $("#source").prop("disabled", true); //change to true for not supported yet!
                    $("#remarks-text").prop("disabled", false);
                    $(".bttn-save").attr("disabled", false);

                    var getSource = $("#filterclienthead").val();

                    if (getSource == 1) {
                        $("#source2").prop("disabled", false);
                        refresh_version_dropdown_1();
                    } else if (getSource == 2) {
                        $("#source3").prop("disabled", false);
                        refresh_version_dropdown_2();
                    } else if (getSource == 3) {
                        refresh_version_dropdown_3();
                    }

                    var getCategory = $("#category-value").val();
                    var getSoftwareType = $("#filterclienthead").val();

                    var jsTreeRefresh = false;
                    
                    $('#table-terminal-id-loading-table-bar').show();
                    pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
                }
            }
        });
    
        $("#js-tree-content").on("uncheck_node.jstree", function(event, data){
            //ajaxRequest.abort();

            //
            let value = document.getElementById(data.node.id).getAttribute("value");

            if (value == "group"){
                terminalIDs = [];
                //terminalOriginalIDs = [];
            } else if (value == "branch") {
                for (var i = 0; i < data.node.children.length; i++) {
                    var index3 = terminalIDs.indexOf(data.node.children[i]);
                    if (index3 > -1) {
                      terminalIDs.splice(index3, 1);
                      //terminalOriginalIDs.splice(index3, 1);
                    }
                }
            } else if (value == "terminal"){
                var index4 = terminalIDs.indexOf(data.node.id);
                if (index4 > -1) {
                    terminalIDs.splice(index4, 1);
                    //terminalOriginalIDs.splice(index4, 1);
                }
            }

            var pNode = data.node.parent;
            var children = data.instance.get_node(pNode).children;

            var countUncheck = 0;
            if (children.length > 0) {
                for (var i = 0; i < children.length; i++) {
                    var result = $("#js-tree-content").jstree().is_checked(children[i]);
                    if (result) {
                        countUncheck++;
                    }
                }

                if (countUncheck == 0){
                    $("#js-tree-content").jstree().uncheck_node(pNode);
                }
            }

            //myJsTableTerminalManager.clean_table();

            var selectedNodes = $("#js-tree-content").jstree().get_checked();

            terminalIDs = [];
            terminalOriginalIDs = [];

            terminalIDs = selectedNodes;
            terminalOriginalIDs = selectedNodes;

            if (selectedNodes.length > 0) {
                var getCategory = $("#category-value").val();
                var getSoftwareType = $("#filterclienthead").val();
                var jsTreeRefresh = false;

                $('#table-terminal-id-loading-table-bar').hide();

                pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
            } else {
                $('#table-height span').hide();
                $('#table-terminal').css('position','');

                if ($(".scrollable").length > 0){ 
                    $(".scrollable").removeClass();
                }

                $("#client-label").html("");
                $("#category-value").val("");
                $("#id-value").val("");
                $("#client-id").val("");
                $("#client-secret").val("");
                $("#remarks-text").val("");
                $("#software-type").val("");
                $("#loading-label").hide();
                $("#remarks-text").prop("disabled", true);

                var getFilterHead = $("#filterclienthead").val();
                
                if (getFilterHead == 0 || getFilterHead == 1){
                    //$("#source").val(1);
                    $("#source").hide();
                    $("#source2").show();
                    $("#source2").prop("disabled", true);
                    $("#source3").hide();
                } else if (getFilterHead == 2) {
                    $("#source").hide();
                    $("#source2").hide();
                    $("#source3").prop("disabled", true);
                    $("#source3").show();
                } else {
                    $("#source").show();
                    $("#source2").hide();
                    $("#source3").hide();
                    $("#source").val(getFilterHead);
                }

                $("#source").prop("disabled", true);
                $("#source2").prop("disabled", true);
                $("#source3").prop("disabled", true);
                $("#softwareversion").prop("disabled", true);
                refresh_empty_dropdown();
                $(".bttn-save").attr("disabled", true);
                $('#table-terminal-id-loading-table-bar').hide();

                showInitialPageLoadDisplay(myJsTableTerminalManager, 'Select client details to load data');
            }

        });


        if (isRefresh) {
            $('#js-tree-content').jstree(true).settings.core.data.url = urllink;
            $("#js-tree-content").jstree().refresh();
            $("#js-tree-content").jstree().uncheck_all();
        }
    }

    /**
     * Adding effects for jstree
     * @param {int}  node_id        [get node_id of jstree]
     * @param {int}  type           [type for enable or disable]
     */
    function disable(node_id, type) {
        var node = $("#js-tree-content").jstree().get_node(node_id);

        if (type == 1) {
            $("#js-tree-content").jstree().disable_node(node);
        } else {
            $("#js-tree-content").jstree().enable_node(node);
        }

        node.children.forEach( function(child_id) {
          disable( child_id , type);
        })
    }

    /**
     * Allowing title and body fields
     * @param {bolean}  isAllow        [is disabled or abled fileds]
     * @param {bolean}  isClearFields  [is clear fields]
     */
    function allowFields(isAllow = false, isClearFields = true)
    {
        if (isClearFields) {
            $("#input-title").val("");
            $("#text-query").val("");
        }

        if (isAllow) {
            $("#input-title").removeAttr("disabled");
            $("#text-query").removeAttr("disabled");
            $(".div-left-content").css({"min-height": "619px"});
            $("#image-update").show();
            $("#image-edit").hide();
        } else {
            $("#input-title").attr("disabled", "disabled");
            $("#text-query").attr("disabled", "disabled");
            $(".div-left-content").removeAttr("style");
            $("#image-update").hide();
            $("#image-edit").show();
        }
    }

    /**
     * Allowing to load the data
     * @param {int}  id            [get id of terminal, branch, group]
     * @param {int}  category      [get category for terminal, branch, group]
     * @param {int}  softwareType  [to filter by what software type]
     **/
    function pul_refresh_table(id, category, softwareType)
    {
        $(".loading-icon").show();
        $(".scrollable").css('width','100%');
        $('#table-height span').hide();
        $('#table-terminal').css('position','');

        if ($(".scrollable").length > 0){ 
            $(".scrollable").removeClass();
        }

        myJsTableTerminalManager.clear_table();

        $('.customer-detail-modal').css('width','20%');
        $('#detailgroup').css('margin-top','250px');
        $('#detailgroup').modal("show");
        $("#loading-modal label").text(" Loading units");
        $("#loading-status-1").show();
        $(".loading-status-2").show();
        $(".loading-status-2").text("");

        ajaxRequest = $.ajax(
        {
            url: "<?=base_url()?>TerminalManagerUpdateModule/getTerminalDetails",
            type: "GET",
            data: {
                id: id,
                type: category,
                software: softwareType
            },
            dataType: 'json',
            success: function(data)
            {

                $(".loading-icon").hide();

                myJsTableTerminalManager.clean_table();

                var rowcnt = data.rowcnt;

                myJsTableTerminalManager.mypage.filter_number = rowcnt;

                myJsTableTerminalManager.insert_multiplerow_with_value(1,data.data);

                var countTable = myJsTableTerminalManager.get_row_count() - 1;

                if (countTable == 0){
                    //$("#table-terminal-id").wrap("<div class='scrollable'></div>");
                    $('#table-terminal').css('position','relative');
                    $('#table-height span').show();
                } else {
                    var countIndex = 1;
                    

                    for (var rowIndex = 0; rowIndex < countTable; rowIndex++) {

                        $(".loading-status-2").text((countIndex++)+" of " + (countTable));

                        var setDeleteFunction = data.data[rowIndex][10];
                        var setCancelled = data.data[rowIndex][9];

                        if ((setDeleteFunction == 2 || setDeleteFunction == 4 || setDeleteFunction == 5) || setCancelled == "CANCELLED"){

                            myJsTableTerminalManager.setvalue_to_rowindex_tdclass(
                                [""],
                                rowIndex + 1,
                                columnTerminalManager['columnDeleteTerminal'].td_class
                            );

                            var deleteFunction = myJsTableTerminalManager.getelem_by_rowindex_tdclass(
                                rowIndex + 1,
                                columnTerminalManager['columnDeleteTerminal'].td_class
                            );

                            $(deleteFunction).attr("src","");
                        }
                    }
                    
                    $("#table-terminal-id").wrap("<div class='scrollable'></div>");
                }
            },
            complete: function ()
            {
                $("#loading-status-1").hide();
                $(".loading-status-2").hide();
                $(".loading-status-2").text("");
                $("#detailgroup").modal("hide");

                var jsTreeRefresh = true;
            }
        });
    }

    /**
     * Initial Page Load
     */
    $(function()
    {
        myJsTableTerminalManager = new my_table(tableTerminalManager, columnTerminalManager, {
            ispaging : true,
            tdhighlight_when_hover : "tablerow",
            tdpopup_when_hover : "tdpopuphover",
            iscursorchange_when_hover: true
        });

        var rootTerminalManager = document.getElementById("table-terminal");
        rootTerminalManager.appendChild(myJsTableTerminalManager.tab);

        myJsTableTerminalManager.mypage.set_mysql_interval(10000);
        myJsTableTerminalManager.mypage.isOldPaging = true;
        myJsTableTerminalManager.mypage.pass_refresh_filter_page(pul_refresh_table);

        showInitialPageLoadDisplay(myJsTableTerminalManager, 'Select client details to load data');
    });

    $(function()
    {
        //var tmp = $('#js-tree-content').jstree(true);
        //if(tmp) { tmp.destroy(); }
        $("#filterclient").prop("disabled", true);
        $("#source").prop("disabled", true);
        $("#source2").prop("disabled", true);
        $("#source3").prop("disabled", true);
        $("#remarks-text").prop("disabled", true);
        $(".bttn-save").attr("disabled", true);
        $("#softwareversion").prop("disabled", true);
        $("#loading-label").hide();

        $("#filterclient").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});
        $("#softwareversion").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        $("#filterclienthead").change(function(){
            //alert($("#filterclienthead").val());
            //$("#filterclient").prop("disabled", ($("#filterclienthead").val() == 2));
            refreshModule(1);

            if ($("#filterclienthead").val() > 2) {
                $("#js-tree-content").text("Not yet supported!");
                $("#js-tree-content").css("text-align","center");
                $("#js-tree-content").css("color","red");
                $("#js-tree-content").css("padding-top","75px");

                $("#filterclient").prop("disabled",true);
            } else {
                if ($("#filterclienthead").val() == 1 || $("#filterclienthead").val() == 2) {
                    $("#filterclient").prop("disabled",false);
                } else {
                    $("#filterclient").prop("disabled",true);
                }

                $("#js-tree-content").css("text-align","");
                $("#js-tree-content").css("color","");
                $("#js-tree-content").css("padding-top","");
                
            }
        });

        $("#filterclient").change(function(){
            type = $("#filterclienthead").val();
            clientgroup = $("#filterclient").val();
            refreshModule(2); //dito
            loadFolderList(true,clientgroup,type);
        });

        $("#source").change(function(){
            $(".bttn-save").attr("disabled", true);
            refresh_empty_dropdown();
            $("#softwareversion").prop("disabled", true);
            $("#loading-label").show();
            if ($("#source").val() == 1) {
                refresh_version_dropdown_1();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            } else if ($("#source").val() == 2) {
                refresh_version_dropdown_2();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            } else {
                refresh_version_dropdown_3();
                $("#loading-label").hide();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            }

            $(".bttn-save").attr("disabled", false);
        });

        $("#source2").change(function(){
            $(".bttn-save").attr("disabled", true);
            refresh_empty_dropdown();
            $("#softwareversion").prop("disabled", true);
            $("#loading-label").show();
            if ($("#source2").val() == 1) {
                refresh_version_dropdown_1();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            } else if ($("#source2").val() == 2) {
                refresh_version_dropdown_4();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            }

            $(".bttn-save").attr("disabled", false);
        });

        $("#source3").change(function(){
            $(".bttn-save").attr("disabled", true);
            refresh_empty_dropdown();
            $("#softwareversion").prop("disabled", true);
            $("#loading-label").show();
            if ($("#source3").val() == 1) {
                refresh_version_dropdown_2();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            } else if ($("#source3").val() == 2) {
                refresh_version_dropdown_5();
                setTimeout(function(){
                    $("#loading-label").hide();
                }, 3000);
            }

            $(".bttn-save").attr("disabled", false);
        });

        if($('#filterclienthead').val() > 0) {
            refresh_clienthead_ddl();
        }
    });

    /**
     * Refresh Module textfields, buttons, etc.
     * @param {int}  type  [to check if need to refresh the client head]
     */
    function refreshModule(type)
    {
        terminalIDs = [];
        terminalOriginalIDs = [];
        refresh_empty_dropdown();
        $("#client-label").html("");
        $("#source").prop("disabled", true);
        $("#softwareversion").prop("disabled", true);
        $("#remarks-text").prop("disabled", true);
        $(".bttn-save").prop("disabled", true);

        $('#table-height span').hide();
        $("#remarks-text").val("");

        var getFilterHead = $("#filterclienthead").val();
            
        if (getFilterHead == 0 || getFilterHead == 1){
            $("#source").hide();
            $("#source2").show();
            $("#source3").hide();
            $("#source2").prop("disabled", true);
        } else if (getFilterHead == 2) {
            $("#source").hide();
            $("#source2").hide();
            $("#source3").show();
            $("#source3").prop("disabled", true);
        } else {
            $("#source").show();
            $("#source2").hide();
            $("#source3").hide();
            $("#source").val(getFilterHead);
        }

        myJsTableTerminalManager.clean_table();
        $('#table-terminal-id-loading-table-bar').hide();

        showInitialPageLoadDisplay(myJsTableTerminalManager, 'Select client details to load data');
        //$(".scrollable").css('width','100%');

        if (type == 1){
            refresh_clienthead_ddl();
            $('#js-tree-content').jstree("destroy").empty();
        }
    }

    /**
     * Refresh ddropdown for client group 
     */
    function refresh_clienthead_ddl()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/refresh_clienthead_ddl_control",
        {
            clientgrouptype : $("#filterclienthead").val()
        }
        ,
        function(data){
            document.getElementById("filterclient").innerHTML = data;
            $("#filterclient").trigger("liszt:updated");
        });
    }

    /**
     * Save details
     */
    function saveDetails()
    {
        if ($("#softwareversion").val() == "-" ) {
            alert("Version field cannot be empty");
            return;
        } else if ($("#softwareversion")[0].selectedIndex !== 0 ) {
            alert("Version field must be latest only");
            return;
        }

        var answer = confirm("Are you sure you want to save?");
        if (answer) {
            $('#detailgroup').modal("show");
            $("#loading-modal label").text(" Validating units");
            $("#loading-status-1").show();
            $(".loading-status-2").show();
            $(".loading-status-2").text("");

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "<?=base_url()?>TerminalManagerUpdateModule/check_details_control",
                data: {
                    idval : terminalOriginalIDs,
                    softwaretype : $("#software-type").val(),
                    category : $("#category-value").val(),
                    versiontype : $("#filterclienthead").val(),
                    softwareversion : $("#softwareversion").val(),
                    clientid : $("#client-id").val(),
                    clientsecret : $("#client-secret").val(),
                    remarkstxt : $("#remarks-text").val(),
                    referenceno : $("#text-value").val(),
                    clientGroup: $("#client-label").html()
                },
                success: function(data)
                {
                    //console.log(data);
                    terminalSaves = [];
                    if (data.count > 0) {

                        var getHigherUploadID = data.higher;
                        var getLowerUploadID = data.lower;
                        var getEqualUploadID = data.equal;

                        var getHigherID = data.higherID;
                        var getLowerID = data.lowerID;
                        var getEqualID = data.equalID;

                        var getLowerActualID = data.lowerActualID;
                        var getHigherActualID = data.higherActualID;
                        var getEqualActualID = data.equalActualID;

                        var totalCount = 1;
                        var countIssue = 0;

                        if (getHigherUploadID !== undefined || getHigherUploadID == 0) {
                            for (var i = 0; i < getHigherUploadID.length; i++) {
                                $(".loading-status-2").text((totalCount++)+" of " + data.count);

                                // alert("Cannot save version update as there is an existing version update for a higher version.\nClient: " + getHigherUploadID[i]);

                                var index = terminalIDs.indexOf(getHigherID[i].toString());
                                if (index > -1) {
                                    terminalIDs.splice(index, 1);
                                }

                                $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    url: "<?=base_url()?>TerminalManagerUpdateModule/versionUpdateLogs",
                                    data: {
                                        type: 1,
                                        actualID : getHigherActualID[i],
                                        updateID : getHigherID[i],
                                        client: getHigherUploadID[i]
                                    },
                                    success: function(data)
                                    { }
                                });

                                countIssue++;
                            }
                        }

                        //for update
                        if (getLowerUploadID !== undefined || getLowerUploadID == 0){
                            for (var i = 0; i < getLowerUploadID.length; i++) {
                                $(".loading-status-2").text((totalCount++)+" of " + data.count);

                                let text = "There is an existing version update, upon confirming this version update will overwrite the previous one.\n\nClient: " + getLowerUploadID[i];
                                if (confirm(text) == true) {
                                   terminalSaves.push(getLowerActualID[i]);

                                   $.ajax({
                                        type: "GET",
                                        dataType: "json",
                                        url: "<?=base_url()?>TerminalManagerUpdateModule/versionUpdateLogs",
                                        data: {
                                            type: 2,
                                            actualID : getLowerActualID[i],
                                            updateID : getLowerID[i],
                                            client: getLowerUploadID[i]
                                        },
                                        success: function(data)
                                        { }
                                    });
                                   //countIssue++;
                                } else {
                                    var index = terminalIDs.indexOf(getLowerID[i].toString());
                                    if (index > -1) {
                                        terminalIDs.splice(index, 1);
                                    }

                                    // $.ajax({
                                    //     type: "GET",
                                    //     dataType: "json",
                                    //     url: "<?=base_url()?>TerminalManagerUpdateModule/versionUpdateLogs",
                                    //     data: {
                                    //         type: 3,
                                    //         actualID : getLowerActualID[i],
                                    //         updateID : getLowerID[i],
                                    //         client: getLowerUploadID[i]
                                    //     },
                                    //     success: function(data)
                                    //     { }
                                    // });
                                    // countIssue++;
                                }
                            }
                        }

                        //if need to have an action for equal versions both DB and new
                        if (getEqualUploadID !== undefined || getEqualUploadID == 0){
                            for (var i = 0; i < getEqualUploadID.length; i++) {
                                $(".loading-status-2").text((totalCount++)+" of " + data.count);

                                //alert("There is an existing version update with the same new version.\nClient: " + getEqualUploadID[i]);

                                var index = terminalIDs.indexOf(getEqualID[i].toString());
                                if (index > -1) {
                                    terminalIDs.splice(index, 1);
                                }

                                $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    url: "<?=base_url()?>TerminalManagerUpdateModule/versionUpdateLogs",
                                    data: {
                                        type: 4,
                                        actualID : getEqualActualID[i],
                                        updateID : getEqualID[i],
                                        client: getEqualUploadID[i]
                                    },
                                    success: function(data)
                                    { }
                                });

                                countIssue++;
                            }
                        }

                        if (totalCount < data.count){
                            for (var i = totalCount; i <= data.count; i++) {
                                $(".loading-status-2").text((totalCount++)+" of " + data.count);
                            }
                        }

                        if (countIssue > 0) {
                            alert("There are some units with issues please see logs for details");
                        }

                        if (terminalIDs.length > 0) {
                            alert('Validation done. proceeding with the updates');

                            $.ajax({
                                type: "GET",
                                dataType: "json",
                                url: "<?=base_url()?>TerminalManagerUpdateModule/save_details_control",
                                data: {
                                    idval : terminalIDs,
                                    softwaretype : $("#software-type").val(),
                                    category : $("#category-value").val(),
                                    versiontype : $("#filterclienthead").val(),
                                    softwareversion : $("#softwareversion").val(),
                                    clientid : $("#client-id").val(),
                                    clientsecret : $("#client-secret").val(),
                                    remarkstxt : $("#remarks-text").val(),
                                    referenceno : $("#text-value").val(),
                                    clientGroup: $("#client-label").html(),
                                    forUpdates: terminalSaves
                                },
                                success: function(data)
                                {
                                    if (data){
                                        alert("Saved");

                                        var getCTDid = $("#id-value").val();
                                        var getCategory = $("#category-value").val();
                                        var getSoftwareType = $("#filterclienthead").val();

                                        pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
                                    }
                                }, complete: function(data)
                                {
                                    alert('Updates now ready for the units');
                                    $("#loading-status-1").hide();
                                    $(".loading-status-2").hide();
                                    $(".loading-status-2").text("");
                                    $('#detailgroup').modal("hide");
                                }
                            });
                        } else {
                            alert('Validation done. all updates are cancelled!');

                            $("#loading-status-1").hide();
                            $(".loading-status-2").hide();
                            $(".loading-status-2").text("");
                            $('#detailgroup').modal("hide");
                        }
                    }
                }, error: function(data){
                    console.log(data);
                }
            });

            terminalIDs = [];
            terminalIDs = terminalIDs.concat(terminalOriginalIDs);
        }
    }

    /**
     * Refresh data for dropdown for cirms pos version
     */
    function refresh_empty_dropdown()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/empty_dropdown",
        {
        }
        ,
        function(data){
            document.getElementById("softwareversion").innerHTML = data;
            $("#softwareversion").trigger("liszt:updated");
        });
    }

    /**
     * Refresh data for dropdown for cirms pos version
     */
    function refresh_version_dropdown_1()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/version_dropdown_1",
        {
            versiontype : 1
        }
        ,
        function(data){
            //$("#softwareversion").prop("disabled", false);
            $("#software-type").val("1");
            $("#client-id").val("6");
            $("#client-secret").val("qdY2bErLnmWLiFSYfW5cWx1cXmZav3vqlFEAgtF1");
            document.getElementById("softwareversion").innerHTML = data;
            $("#softwareversion").trigger("liszt:updated");
        });
    }

    /**
     * Refresh data for dropdown for retail pos version
     */
    function refresh_version_dropdown_2()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/version_dropdown_2",
        {
            versiontype : 2
        }
        ,
        function(data){
            //$("#softwareversion").prop("disabled", false);
            $("#software-type").val("2");
            $("#client-id").val("7");
            $("#client-secret").val("LxMCrAOuE4p5VnG9BjIoDbJETkgz35JsZU2TuM4Z");
            document.getElementById("softwareversion").innerHTML = data;
            $("#softwareversion").trigger("liszt:updated");
        });
    }

    /**
     * Refresh data for dropdown for lettuce pos version
     */
    function refresh_version_dropdown_3()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/version_dropdown_3",
        {
            versiontype : $("#source").val()
        }
        ,
        function(data){
            //$("#softwareversion").prop("disabled", false);
            $("#software-type").val("3");
            $("#client-id").val("27");
            $("#client-secret").val("DzWp8HBzInNCwXWLKviFyKEfNnXBwPH5gINjuVIH");
            document.getElementById("softwareversion").innerHTML = data;
            $("#softwareversion").trigger("liszt:updated");
        });
    }

    /**
     * Refresh data for dropdown for cirms staging
     */
    function refresh_version_dropdown_4()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/version_dropdown_4",
        {
            versiontype : 1
        }
        ,
        function(data){
            //$("#softwareversion").prop("disabled", false);
            $("#software-type").val("1");
            $("#client-id").val("36");
            $("#client-secret").val("Xm5cxGvcvtfVvB8aULaUzbjYzmuv99knUgoluHCD");
            document.getElementById("softwareversion").innerHTML = data;
            $("#softwareversion").trigger("liszt:updated");
        });
    }

    /**
     * Refresh data for dropdown for cirms staging
     */
    function refresh_version_dropdown_5()
    {
        $.get("<?=base_url()?>TerminalManagerUpdateModule/version_dropdown_5",
        {
            versiontype : 2
        }
        ,
        function(data){
            //$("#softwareversion").prop("disabled", false);
            $("#software-type").val("2");
            $("#client-id").val("37");
            $("#client-secret").val("6aPjbkvBbL7fRRLGuoRSyViBogp1vKXJd2uyDQPF");
            document.getElementById("softwareversion").innerHTML = data;
            $("#softwareversion").trigger("liszt:updated");
        });
    }

    /**
     * Deleting the terminals in terminal update manager
     * @param {int}  id  [id of terminal to delete]
     */
    function deleteTerminals(id)
    {
        var rowIndexTerminal = $(id).parents("tr").index();
        let tableBody = $(id).parent("tbody")
        let parentRow = $(id).parents("tr");

        var idValue = myJsTableTerminalManager.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnTerminalManager['columnID'].td_class
        )[0];

        var uploadValue = myJsTableTerminalManager.getvalue_by_rowindex_tdclass(
            rowIndexTerminal,
            columnTerminalManager['columnUploadID'].td_class
        )[0];

        var answer = confirm("Are you sure you want to delete?");
        if (answer) {

            $('#detailgroup').modal("show");
            $("#loading-modal label").text(" Validating units");
            $("#loading-status-1").show("show");
            $(".loading-status-2").show("show");

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>TerminalManagerUpdateModule/checkDeleteTerminal",
                data: {
                    id: idValue
                },
                success: function(data)
                {
                    var getStatus = data.status;

                    var getCTDid = $("#id-value").val();
                    var getCategory = $("#category-value").val();
                    var getSoftwareType = $("#filterclienthead").val();

                    if (getStatus == 2) {
                        alert("Cannot delete on going version update");

                        pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
                    } else if (getStatus == 4) {
                        alert("Cannot delete completed version update");

                        pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
                    } else if (getStatus == 5) {
                        alert("Cannot delete up-to date version update");

                        pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
                    } else {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?=base_url()?>TerminalManagerUpdateModule/deleteTerminal",
                            data: {
                                id: idValue,
                                upload: uploadValue
                            },
                            success: function(data)
                            {
                                if (data > 0) {
                                    alert("Successfully Removed");

                                    var getCTDid = $("#id-value").val();
                                    var getCategory = $("#category-value").val();
                                    var getSoftwareType = $("#filterclienthead").val();

                                    $(".loading-status-2").text("1 of 1");

                                    pul_refresh_table(terminalOriginalIDs, getCategory, getSoftwareType);
                                } else {

                                    alert("Unable to delete!");
                                    return;
                                }
                            },
                            complete: function(data)
                            {
                                $("#loading-status-1").hide();
                                $(".loading-status-2").hide();
                                $('#detailgroup').modal("hide");
                            }
                        });
                        
                    }
                }
            });
        }
        
    }

</script>
