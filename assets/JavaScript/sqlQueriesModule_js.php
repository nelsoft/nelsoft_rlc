<script type="text/javascript">
    var isAllowImageUpdate = true;
    var maxFileSize = 7000000;
    var maxLengthText = 999028;
    var fileSizeLimit = 10000000;
    var isEditFolder = false;
    /**
     * Load folder list
     */
    function loadFolderList(isRefresh = false, project_code = 1)
    {
        urllink = "sqlQueriesModule/getAllFolderList?projectCode="+project_code;
        $("#js-tree-content").jstree({
            core: {
                data: {
                    "url": urllink,
                    "dataType": "json",
                    'multiple': false
                }
            }
        });

        if (isRefresh) {
            $('#js-tree-content').jstree(true).settings.core.data.url = urllink;
            $('#js-tree-content').jstree().deselect_all(true);
            $("#js-tree-content").jstree().refresh();

        }
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
            $("#image-update").removeAttr("disabled");
            $("#image-edit").removeAttr("disabled");
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

    /*
     * Show loading status
     * @param {bolean}  isShow             [is show loading]
     * @param {string}  caption            [loading caption]
     * @param {bolean}  isDisabledButtons  [is disabled buttons]
     * @param {bolean}  showLoadingImage   [is show loading image]
     */
    function showLoading(isShow = false, caption = "Loading..", isDisabledButtons = false, showLoadingImage = true)
    {
        if (! isShow) {
            $(".notification-status").show();
            $(".loading-status").hide();
        } else {
            $(".notification-status").hide();
            $(".loading-status").show();

            let loading = (showLoadingImage)
                ? "<img src='assets/images/loading.gif' width='15px' height='15px'>&nbsp;"
                : "";
            $(".loading-status").html(loading+caption);
        }

        if (isDisabledButtons) {
            $(".button-group").find("button").attr("disabled", "disabled");
            $("#advanced-sql-upload").css({"margin-top": "0"});
            isUpdate = false;
        } else {
            $(".button-group").find("button").removeAttr("disabled");
            $("#advanced-sql-upload").removeAttr("style");
            isUpdate = true;
        }
    }

    var countDeleted = 0;
    var folderFileList = [];
    var folderFileIndex = 0;
    var countFolder = 0;
    var countFiles = 0;
    var totalFolder = 0;
    var totalFiles = 0;
    /**
     * Process delete selected folder and file
     */
    function processDeleteSelected()
    {
        [id, parentId, type] = folderFileList[folderFileIndex].split("~");
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/deleteFolder")?>",
            type: "POST",
            data: {
                categoryId: id,
                type: type,
                projectCode: $("#selectProject").val() 
            }, 
            dataType: "json",
            success: function(response)
            {
                showDeleteStatus(id, type, response.isError, response.message.trim());
            },
            error: function(xhr, status, error)
            {
                showDeleteStatus(id, type, true);
            }
        });
    }

    /**
     * Show delete status
     * @param {string}  categoryId  [Category Id]
     * @param {bolean}  isError     [Is error response]
     * @param {string}  message     [alert message]
     */
    function showDeleteStatus(categoryId, type, isError, message)
    {
        if (! isError) {
            countFolder += (type != "file") ? 1 : 0;
            countFiles += (type == "file") ? 1 : 0;
        }

        let loadingCaption = "";
        loadingCaption += (totalFolder) ? "Folder: "+countFolder+"/"+totalFolder : "";
        loadingCaption += (totalFiles) ? ((loadingCaption) ? ", " : "")+"File: "+countFiles+"/"+totalFiles : "";
        showLoading(true, "Loading.. Deleting "+loadingCaption, true);


        folderFileIndex += 1;
        if (folderFileIndex < folderFileList.length) {
            processDeleteSelected();
        } else {
            isDelete = true;
            alert(message);
            loadFolderList(true, $("#selectProject").val());
            allowFields(false);

            if (countFolder == totalFolder && countFiles == totalFiles) {
                showLoading(false, "", true);
                $(".button-right").removeAttr("disabled");
                $("#advanced-sql-upload").removeAttr("style");
            } else {
                showLoading(true, "Delete "+loadingCaption, true, false);
            }
        }
    }

    var bigUploadedFileText = "";
    var bigUploadedFileName = "";
    var bigUploadedStartKey = 0;
    var bigUploadedEndKey = 0;
    var bigUploadedTemporaryId = 0;
    var bigUploadedCountSize = 0;
    var bigUploadedTotalSize = 0;
    /**
     * Save big uploade file
     * @param  {integer}  numberOfLoop  [number of loop]
     */
    function saveBigUploadedFile(numberOfLoop)
    {
        let queryText = "";
        let isContinue = true;
        let totalCountSize = 0;
        let currentFileSize = 0;

        bigUploadedEndKey += maxLengthText;
        queryText = bigUploadedFileText.substring(bigUploadedStartKey, bigUploadedEndKey);

        currentFileSize = parseInt(new Blob([queryText]).size);
        totalCountSize = bigUploadedCountSize + currentFileSize;
        if (totalCountSize == bigUploadedTotalSize || bigUploadedEndKey >= bigUploadedFileText.length) {
            isContinue = false;
        }

        $.ajax({
            url: "<?=base_url("sqlQueriesModule/saveBigFile")?>",
            type: "POST",
            data: {
                id: bigUploadedTemporaryId,
                folderId: $("#selected-folder").val(),
                queryTitle: bigUploadedFileName,
                projectCode: $("#selectProject").val(),
                queryBody: queryText,
                loadPatch: true,
                numberOfLoop: numberOfLoop
            },
            dataType: "json",
            success: function(response)
            {
                if (! bigUploadedTemporaryId) {
                    bigUploadedTemporaryId = response.categoryId;
                }

                if (isContinue) {
                    bigUploadedStartKey = bigUploadedEndKey;
                    bigUploadedCountSize = totalCountSize;
                    numberOfLoop = parseInt(numberOfLoop) + 1;
                    saveBigUploadedFile(numberOfLoop);
                } else {
                    showUploadingFilesLoading(response.isError);
                }
            },
            error: function(xhr, status, error)
            {
                showUploadingFilesLoading(true);
            }
        });
    }

    var uploadingFileList = [];
    var uploadingFileKey = 0;
    var totalUploadingFile = 0;
    var countUploadingFile = 0;
    /*
     * Save uploading file
     */
    function saveUploadingFile()
    {
        [categoryId, folderId, type] = $("#js-tree-content").jstree("get_selected")[0].split("~");
        if (type != "file") {
            folderId = categoryId;
        }
        $("#selected-folder").val(folderId);

        var selectedFile = uploadingFileList[uploadingFileKey];
        var reader = new FileReader();

        reader.onload = function (event)
        {
            let isContinue = true;
            let fileNameList = selectedFile.name.split(".");
            let extensionName = fileNameList[fileNameList.length - 1];
            let fileSize = selectedFile.size;

            if (extensionName != "sql" && extensionName != "txt") {
                if (totalUploadingFile == 1) {
                    alert("Invalid file!");
                    showLoading(false, "", false);
                    loadFolderList(true, $("#selectProject").val());
                    allowFields(false, false);

                    isUploadFile = true;
                    $("input[name='input-file']").val(null);
                    return;
                }
                isContinue = false;
            }

            if (isContinue) {
                let textList = event.target.result.split("base64,");

                if (fileSize > maxFileSize) {
                    $.ajax({
                        url: event.target.result,
                        type: "POST",
                        success: function(text)
                        {
                            bigUploadedFileName = "";
                            let nameList = selectedFile.name.split(".");
                            for (key in nameList) {
                                if (key < (nameList.length - 1)) {
                                    bigUploadedFileName += ((! bigUploadedFileName) ? "" : ".")+nameList[key];
                                }
                            }
                            bigUploadedFileText = text;
                            bigUploadedTotalSize = fileSize;
                            bigUploadedCountSize = 0;
                            bigUploadedStartKey = 0;
                            bigUploadedEndKey = 0;
                            bigUploadedTemporaryId = (selectedFile.id) ? selectedFile.id : 0;
                            saveBigUploadedFile(1);
                        }
                    });
                    return;
                }

                $.ajax({
                    url: "<?=base_url("sqlQueriesModule/uploadSQLFile")?>",
                    type: "POST",
                    data: {
                        categoryId: (selectedFile.id) ? selectedFile.id : 0,
                        folderId: $("#selected-folder").val(),
                        fileName: selectedFile.name,
                        projectCode: $("#selectProject").val(),
                        text: textList[1]
                    },
                    dataType: "json",
                    success: function(response)
                    {
                        showUploadingFilesLoading(response.isError);
                    },
                    error: function(xhr, status, error) 
                    {
                        showUploadingFilesLoading(true);
                    }
                });
            } else {
                showUploadingFilesLoading(true);
            }
        }

        reader.readAsDataURL(selectedFile);
    }

    /**
     * Show loading in uploading files
     * @param {bolean}  isError  [Is response is error]
     */
    function showUploadingFilesLoading(isError)
    {
        uploadingFileKey += 1;
        countUploadingFile = (! isError) ? (countUploadingFile + 1) : countUploadingFile;
        showLoading(true, "Loading.. Uploading file: "+countUploadingFile+"/"+totalUploadingFile, true);

        if (uploadingFileKey < totalUploadingFile) {
            saveUploadingFile();
            return;
        }

        alert((countUploadingFile == totalUploadingFile) ? "Successfully uploaded" : "Failed to upload");
        showLoading(false, "", false);
        loadFolderList(true, $("#selectProject").val());
        allowFields(false, false);

        isUploadFile = true;
        $("input[name='input-file']").val(null);
    }

    var dragFileList = [];
    var dragFileIndex = 0;
    var dragFileName = "";
    var dragText = "";
    /**
     * Show drag files
     * @param {string} folderId    [selected folder id]
     * @param {string} categoryId  [selected category id]
     */
    function showDragFiles(folderId, categoryId)
    {
        var selectedFile = dragFileList[dragFileIndex];
        var reader = new FileReader();

        reader.onload = function (event)
        {
            let isContinue = true;
            let fileNameList = selectedFile.name.split(".");
            let extensionName = fileNameList[fileNameList.length - 1];

            if (extensionName != "sql" && extensionName != "txt") {
                isContinue = false;

                if (dragFileList.length == 1) {
                    alert("Invalid file.");
                }
            }

            if (isContinue) {
                $.ajax({
                    url: event.target.result,
                    type: "POST",
                    success: function(text)
                    {
                        if (! $("#input-title").val().trim()) {
                            let fileName = "";
                            let fileNameList = selectedFile.name.split(".");

                            for (key in fileNameList) {
                                if (parseInt(key) < (fileNameList.length - 1)) {
                                    fileName += ((! fileName) ? "" : ".")+fileNameList[key];
                                }
                            }
                            dragFileName += ((dragFileName) ? "-" : "")+fileName;
                        }

                        dragText += ((dragText) ? "\n" : "")+text;

                        dragFileIndex += 1;
                        if (dragFileIndex < dragFileList.length) {
                            showDragFiles(folderId, categoryId);
                        } else {
                            if (! parseInt(categoryId)) {
                                allowFields(true, false);
                            }

                            if (! $("#input-title").val().trim()) {
                                $("#input-title").val(dragFileName);
                            }

                            $("#text-query").val(dragText);
                            showLoading(false, "", false);
                        }
                    }
                });
            } else {
                dragFileIndex += 1;
                if (dragFileIndex < dragFileList.length) {
                    showDragFiles(folderId, categoryId);
                } else {
                    if (! parseInt(categoryId)) {
                        allowFields(true, false);
                    }

                    if (! $("#input-title").val().trim()) {
                        $("#input-title").val(dragFileName);
                    }

                    $("#text-query").val(dragText);
                    showLoading(false, "", false);
                }
            }
        }

        reader.readAsDataURL(selectedFile);

    }

    var textQuerySize = 0;
    var countQuerySize = 0;
    var startStringIndex = 0;
    var endStringIndex = 0;
    var temporaryQueryBody = "";
    var temporaryCategoryId = 0;
    /**
     * Save query file
     * @param  {integer}  numberOfLoop  [number of loop]
     */
    function saveQueryFile(numberOfLoop)
    {
        let queryText = "";
        let isContinue = true;
        let totalCountSize = 0;
        let currentFileSize = 0;

        endStringIndex += maxLengthText;
        queryText = temporaryQueryBody.substring(startStringIndex, endStringIndex);

        currentFileSize = parseInt(new Blob([queryText]).size);
        totalCountSize = countQuerySize + currentFileSize;
        if (totalCountSize == textQuerySize || endStringIndex >= temporaryQueryBody.length) {
            isContinue = false;
        }

        $.ajax({
            url: "<?=base_url("sqlQueriesModule/saveBigFile")?>",
            type: "POST",
            data: {
                id: temporaryCategoryId,
                folderId: $("#selected-folder").val(), 
                queryTitle: $("#input-title").val().trim(),
                projectCode: $("#selectProject").val(),
                queryBody: queryText,
                loadPatch: true,
                numberOfLoop: numberOfLoop
            },
            dataType: "json",
            success: function(response)
            {
                let percentText = (countQuerySize / textQuerySize) * 100;
                showLoading(true, "Saving file... "+parseInt(percentText)+"%", true);

                if (! parseInt(temporaryCategoryId)) {
                    temporaryCategoryId = response.categoryId;
                }

                if (isContinue) {
                    startStringIndex = endStringIndex;
                    countQuerySize = totalCountSize;
                    numberOfLoop += 1;
                    saveQueryFile(numberOfLoop);
                } else {
                    alert(response.message.trim());

                    if (! response.isError) {
                        loadFolderList(true, $("#selectProject").val());
                        allowFields(false, false);
                    }

                    isUpdate = true;
                    $("#selected-file").val(temporaryCategoryId);
                    showLoading(false, "", false);
                }
            },
            error: function(xhr, status, error)
            {
                alert("Failed to saved.");
                isUpdate = true;
                showLoading(false, "", false);
            }
        });
    }

    var openFileSize = 0;
    var openFileStartKey = 0;
    var openFileName = "";
    var openFileBody = "";
    /**
     * Open file by category id
     * @param {string}  categoryId  [category id]
     */
    function openFileByCategoryID(categoryId)
    {
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/getBigFile")?>",
            type: "POST",
            data: {
                categoryId: categoryId,
                startKey: openFileStartKey,
                stringLength: maxLengthText
            },
            dataType: "json",
            success: function(response)
            {
                if (! openFileStartKey) {
                    openFileName = response.title
                }

                openFileBody += response.text;
                let temporaryFileSize = parseInt(new Blob([openFileBody]).size);
                let percent = parseInt((temporaryFileSize / openFileSize) * 100);

                if (temporaryFileSize == openFileSize) {
                    showLoading(true, "Loading.. Please wait.", true);
                    $("#input-title").val(openFileName);
                    $("#text-query").val(openFileBody);
                    showLoading(false, "", false);
                    openFileSize = 0;
                    openFileStartKey = 0;
                    openFileName = "";
                    openFileBody = "";
                } else  {
                    showLoading(true, "Loading.. Getting content. "+(percent)+"%", true);
                    openFileStartKey += maxLengthText;
                    openFileByCategoryID(categoryId);
                }
            },
            error: function(xhr, status, message)
            {
                showLoading(false, "", false);
                alert("Failed to open file");
                $("#input-title").val("");
                $("#text-query").val("");
                openFileSize = 0;
                openFileStartKey = 0;
                openFileName = "";
                openFileBody = "";
            }
        });
    }

    $(function()
    {
        loadFolderList(); 

        $("#btnSwitchProject").live("click", function()
        {
            var getSelectedProject = $("#selectProject").val();

            loadFolderList(true, getSelectedProject); 

            $("#advanced-sql-upload").css({"margin-top": "5px"});
            $("#advanced-sql-upload").removeAttr("disabled");
            $("#add-database-version").removeAttr("disabled");

            $("#input-title").val("");
            $("#text-query").val("");

        });


        $( "#selectProject" ).change(function() {
            $("#advanced-sql-upload").attr("disabled", "disabled");
            $("#add-database-version").attr("disabled", "disabled");

            $("#delete-file, #new-file, #upload-file, #download, #new-folder, #edit-folder").attr("disabled", "disabled");

            $("#input-title").val("");
            $("#text-query").val("");

            $('#js-tree-content" li').each( function() {
                $("#js-tree-content").jstree().disable_node(this.id);
            });

            $('#js-tree-content').jstree().deselect_all(true);

            $("#advanced-sql-upload").css({"margin-top": "5px"});
        });
    });

    function Disable() {
      // disable visible nodes
      $('#js-tree-content li.jstree-node').each(function() {
        $('#js-tree-content').jstree("disable_node", this.id)
      })
      // block open new nodes
      $('#js-tree-content i.jstree-ocl')
      .off('click.block')
      .on('click.block', function() {
        return false;
        });
      // eventually... dbl click
      $('#js-tree-content').jstree().settings.core.dblclick_toggle = false;
      // eventually... block all edits
      $('#js-tree-content').jstree().settings.core.check_callback = false;
    }  

    function Enable() {
      // enable again visible nodes
      $('#js-tree-content li.jstree-node').each(function() {
        $('#js-tree-content').jstree("enable_node", this.id)
      });
      // ublock open new nodes
      $('#js-tree-content i.jstree-ocl')
      //
      .off('click.block');
      // eventually... dbl click
      $('#js-tree-content').jstree().settings.core.dblclick_toggle = true;
      // eventually... unblock all edits
      // set to true OR reset to whatever user defined function you are using
      $('#js-tree-content').jstree().settings.core.check_callback = true;
    }

    var currentFileSelected = "";
    $("#js-tree-content").live("click", function()
    {
        if ($("#js-tree-content").jstree("get_selected")[0] == undefined) {
            $("#selected-folder").val("");
            $("#selected-file").val("");
            return;
        }

        let jsTree = $("#js-tree-content").jstree("get_selected");
        [id, parentId, type] = jsTree[0].split("~");

        let editFolder = "#edit-folder";
        if (jsTree.length > 1 || (jsTree.length == 1 && type == "file")) {
            $("#edit-folder").attr("disabled", "disabled");
            editFolder = "";
        } else {
            editFolder = ", "+editFolder;
        }

        $("#delete-file, #new-file, #upload-file, #download, #new-folder"+editFolder).removeAttr("disabled");

        if (jsTree.length == 1) {
            [id, parentId, type] = jsTree[0].split("~");

            if (type == "file" && id != $("#selected-file").val()) {
                $("#selected-folder").val(parentId);
                $("#selected-file").val(id);

                openFileSize = 0;
                $.ajax({
                    url: "<?=base_url("sqlQueriesModule/getFileQuerySize")?>",
                    type: "POST",
                    data: {categoryId: id},
                    async: false,
                    success: function(fileQuerySize)
                    {
                        openFileSize = fileQuerySize;
                    }
                });

                allowFields(false, false);
                if (openFileSize > maxFileSize) {
                    var openFileStartKey = 0;
                    var openFileName = "";
                    var openFileBody = "";
                    showLoading(true, "Loading.. Getting content. 0%", true);
                    openFileByCategoryID(id);
                    return;
                }

                showLoading(true, "Loading.. Please wait.", true);
                $.ajax({
                    url: "<?=base_url("sqlQueriesModule/getFileQueryData")?>",
                    type: "POST",
                    data: {categoryId: $("#selected-file").val()},
                    dataType: "json",
                    success: function(response)
                    {
                        showLoading(false, "", false);
                        if (response.hasResultFound) {
                            $("#input-title").val(response.title);
                            $("#text-query").val(response.script);
                        }

                        openFileSize = 0;
                        openFileStartKey = 0;
                        openFileName = "";
                        openFileBody = "";
                        $("#edit-folder").attr("disabled", "disabled");
                    }
                });
            }

            if (type != "file") {
                allowFields(false);
                $("#selected-folder").val("");
                $("#selected-file").val("");
            }
        } else {
            allowFields(false);
            $("#selected-folder").val("");
            $("#selected-file").val("");
        }
    });

    $("#image-edit").live("click", function()
    {
        let categoryId = $("#selected-file").val();
        let selected = $("#js-tree-content").jstree("get_selected");

        if (selected[0] == undefined || selected.length > 1) {
            return;
        }

        [id, parentId, type] = selected[0].split("~");
        if (type != "file") {
            return
        }

        $("#selected-folder").val(parentId);
        $("#selected-file").val(id);
        allowFields(true, false);
    });

    var isUpdate = true;
    $("#image-update").live("click", function()
    {
        if (! isUpdate) {
            return;
        }
        isUpdate = false;

        let queryTitle = $("#input-title").val().trim();
        let queryBody = $("#text-query").val();

        if (! queryTitle) {
            alert("Title is required.");
            isUpdate = true;
            return;
        }

        if (! queryBody.trim()) {
            alert("Queries content is required");
            isUpdate = true;
            return;
        }

        textQuerySize = 0;
        textQuerySize = new Blob([queryBody]).size;
        textQuerySize = parseInt(textQuerySize);

        if (textQuerySize > fileSizeLimit) {
            alert("File size exceed 10MB!");
            isUpdate = true;
            return;
        }

        if (textQuerySize > maxFileSize) {
            temporaryQueryBody = queryBody;
            startStringIndex = 0;
            endStringIndex = 0;
            countQuerySize = 0;
            temporaryCategoryId = $("#selected-file").val();
            showLoading(true, "Saving file... 0%", true);
            setTimeout(function()
            {
                saveQueryFile(1);
            }, 1);
            return;
        }

        $.ajax({
            url: "<?=base_url("sqlQueriesModule/saveFileQuery")?>",
            type: "POST",
            data: {
                id: $("#selected-file").val(),
                folderId: $("#selected-folder").val(),
                projectCode: $("#selectProject").val(),
                queryTitle: queryTitle,
                queryBody: queryBody,
                process: "edit",
            },
            dataType: "json",
            success: function(response)
            {
                alert(response.message.trim());

                if (! response.isError) {
                    loadFolderList(true, $("#selectProject").val());
                    allowFields(false, false);

                    $("#image-update").attr("disabled", "disabled");
                    $("#image-edit").attr("disabled", "disabled");
                }

                isUpdate = true;
                $("#selected-file").val(response.categoryId);
            },
            error: function(response)
            {
                alert("Failed to saved");
                isUpdate = true;
            }
        });
    });

    $("#new-file").live("click", function()
    {
        let selected = $("#js-tree-content").jstree("get_selected");
        if (selected[0] == undefined) {
            return;
        }

        let isContinue = true;
        let currentParentId = 0;
        for (key = 0; key < selected.length; key++) {
            [id, parentId, type] = selected[key].split("~");
            if (type != "file") {
                parentId = id;
            }

            if (key == 0) {
                currentParentId = parentId;
            }

            if (type == "folder" || currentParentId != parentId) {
                isContinue = false;
                break;
            }
        }

        if (! isContinue) {
            alert("Please select a specific category folder.");
            return;
        }

        if (! confirm("Are you sure you want to create new query file?")) {
            isDelete = true;
            return;
        }

        allowFields(true);
        $("#selected-file").val("0");
        $("#selected-folder").val(currentParentId);

        $("#image-update").removeAttr("disabled");
        $("#image-edit").removeAttr("disabled");
    });

    $("#advanced-category").live("click", function()
    {
        if (
            $("#js-tree-content").jstree("get_selected")[0] == undefined
            || $("#js-tree-content").jstree("get_selected").length > 1
        ) {
            return;
        }

        let folderId = $("#selected-folder").val();
        if (! confirm("Are you sure you want to create new category folder?")) {
            return;
        }

        $("input[name='folder-id']").val(0);
        $("#folder-name").val("");
        $("input[name='type']").val("category");
        $("#folder-modal").modal("show");
        $("#folder-modal").find(".modal-title").html("Create New Folder");
    });

    $("#edit-folder").live("click", function()
    {
        let jsTree = $("#js-tree-content").jstree("get_selected");
        [folderId, parentId, type] = jsTree[0].split("~");

        if (
            $("#js-tree-content").jstree("get_selected")[0] == undefined
            || ! folderId
            || $("#js-tree-content").jstree("get_selected").length > 1
            || type == "file"
        ) {
            return;
        }

        folderName = $("#js-tree-content").find("a[id='"+jsTree[0]+"_anchor']").text().trim();

        $("input[name='folder-id']").val(folderId);
        $("#folder-name").val(folderName);
        $("input[name='type']").val(type);
        $("#folder-modal").modal("show");
        $("#folder-modal").find(".modal-title").html("Edit Folder");
        isEditFolder = true;
    });

    var isDelete = true;
    $("#delete-file").live("click", function()
    {
        if (! isDelete) {
            return;
        }
        isDelete = false;

        let folderId = $("#selected-folder").val();
        let categoryId = $("#selected-file").val();

        if ($("#js-tree-content").jstree("get_selected")[0] == undefined) {
            isDelete = true;
            return;
        }

        if (! confirm("Do you want to delete the selected folder/files?")) {
            isDelete = true;
            return;
        }

        folderFileList = $("#js-tree-content").jstree("get_selected");
        folderFileIndex = 0;
        countDeleted = 0;
        totalFolder = 0;
        totalFiles = 0;
        countFolder = 0;
        countFiles = 0;

        for (key in folderFileList) {
            [folderId, categoryId, type] = folderFileList[key].split("~");

            if (type != "file") {
                totalFolder += 1;
            } else {
                totalFiles += 1;
            }
        }

        let loadingCaption = "";
        loadingCaption += (totalFolder) ? "Folder: 0/"+totalFolder : "";
        loadingCaption += (totalFiles) ? ((loadingCaption) ? ", " : "")+"File: 0/"+totalFiles : "";
        showLoading(true, "Loading.. Deleting "+loadingCaption, true);
        processDeleteSelected();
        return;
    });

    $("#image-folder-update").live("click", function()
    {
        if (
            ! isAllowImageUpdate
            || $("#js-tree-content").jstree("get_selected")[0] == undefined
            || $("#js-tree-content").jstree("get_selected").length > 1
        ) {
            return;
        }
        isAllowImageUpdate = false;

        let folderName = $("#folder-name").val().trim();

        if (! folderName) {
            alert("Category name is required.");
            isAllowImageUpdate = true;
            isEditFolder = false;
            return;
        }

        let selected = $("#js-tree-content").jstree("get_selected")[0].split("~");
        parentId = (parseInt(selected[1]) == 0) ? selected[0] : selected[1];
        if (isEditFolder) {
            parentId = (selected[2] == "folder") ? 0 : selected[1];
        }

        $.ajax({
            url: "<?=base_url("sqlQueriesModule/saveFolderName")?>",
            type: "POST",
            data: {
                folderId: $("input[name='folder-id']").val(),
                folderName: folderName,
                parentId: parentId,
                projectCode: $("#selectProject").val()
            },
            dataType: "json",
            success: function(response)
            {
                alert(response.message.trim());

                if (! response.isError) {
                    $(".close-modal").click();
                    loadFolderList(true, $("#selectProject").val());
                }

                isAllowImageUpdate = true;
                isEditFolder = false;
            }
        });
    });

    $("#folder-name").live("keypress", function(event)
    {
        if (event.keyCode == 13) {
            $("#image-folder-update").click();
        }

        if ($("input[name='type']").val() == "folder") {
            if (event.which == 46) {
                if ($(this).val().indexOf('.') != -1) {
                    return false;
                }
            }

            if (event.which != 8 && event.which != 0 && event.which != 46 && (event.which < 48 || event.which > 57)) {
                return false;
            }

            if ($(this).val().length > 3) {
                return false;
            }

            if ($(this).val().indexOf('.') == -1 && event.which != 46 && $(this).val().length > 1) {
                return false;
            }

            if ($(this).val().indexOf('.') != -1 && event.which != 46) {
                let splitDecimal = $(this).val().split(".");
                if (splitDecimal[0].length == 1 && splitDecimal[1].length == 1) {
                    return false;
                }
            }
        }
    });

    $("#download").live("click", function()
    {
        let fileList = {
            folder: [],
            category: [],
            file: []
        };
        let folderList = [];
        let countId = 0;
        let countFolder = 0;

        if ($("#js-tree-content").jstree("get_selected")[0] == undefined) {
            alert("No File Selected");
            return;
        }

        for (index in $("#js-tree-content").jstree("get_selected")) {
            [id, parentId, type] = $("#js-tree-content").jstree("get_selected")[index].split("~");

            fileList[type][fileList[type].length] = id;
        }

        let isContent = false;
        let fileName = "";
        let path = "";
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/getFileList")?>",
            type: "POST",
            data: {fileList: fileList},
            dataType: "json",
            async: false,
            success: function(response)
            {
                isContent = response.isContent;
                path = response.parentFolder;
                fileName = response.fileName;
            }
        });

        if (! isContent) {
            alert("No selected file.");
            return;
        }

        showLoading(true, "Loading.. Downloading..", true);
        let resultDownloading = window.open(
            "<?=base_url("sqlQueriesModule/downloadQueriesFile")?>?path="+path+"&fileName="+fileName, "_blank"
        );
        showLoading(false);
    });

    var isUploadFile = true;
    $("#upload-file").live("click", function()
    {
        let folderId = $("#selected-folder").val();
        let categoryId = $("#selected-file").val();
        isUploadFile = false;

        if ($("#js-tree-content").jstree("get_selected")[0] == undefined) {
            alert("Please select a folder");
            isUploadFile = true;
            return;
        }

        let isContinue = true;
        let currentFolderId = 0;
        if ($("#js-tree-content").jstree("get_selected").length) {
            selected = $("#js-tree-content").jstree("get_selected");
            for (key = 0; key < selected.length; key++) {
                [categoryId, folderId, type] = selected[key].split("~");
                if (type != "file") {
                    folderId = categoryId;
                }

                if (key == 0) {
                    currentFolderId = folderId;
                }

                if ((key > 0 && currentFolderId != folderId) || type == "folder") {
                    isContinue = false;
                    break;
                }
            }
        }

        if (! isContinue) {
            alert("Please select a specific folder.");
            isUploadFile = true;
            return;
        }

        $("input[name='input-file']").click();
    });

    $("input[name='input-file']").live("change", function()
    {
        [categoryId, folderId, type] = $("#js-tree-content").jstree("get_selected")[0].split("~");
        if (type != "file") {
            folderId = categoryId;
        }

        showLoading(false);

        uploadingFileList = [];
        uploadingFileKey = 0;
        totalUploadingFile = 0;
        countUploadingFile = 0;

        let fileNameList = [];
        let isExceedFileSize = false;
        for (key = 0; key < this.files.length; key++) {
            uploadingFileList[key] = this.files[key];
            fileNameList[key] = this.files[key].name;

            let originalFileSize = this.files[key].size;
            let fileExtesionNameList = this.files[key].name.split(".");
            let extensionName = fileExtesionNameList[fileExtesionNameList.length - 1];
            if (originalFileSize > fileSizeLimit && (extensionName == "sql" || extensionName == "txt")) {
                isExceedFileSize = true;
            }
        }

        if (isExceedFileSize) {
            alert("File size exceed 10MB! Unable to upload.");
            return;
        }
        totalUploadingFile = uploadingFileList.length;

        let duplicateNameText = "";
        let duplicateNameList = [];
        let duplicateKeyList = [];
        let modifiedKeyList = [];
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/fileNameChecker")?>",
            type: "POST",
            data: {
                folderId: folderId,
                fileNameList: fileNameList,
            },
            dataType: "json",
            async: false,
            success: function(result)
            {
                duplicateNameList = result.fileNameList;
                duplicateKeyList = result.keyList;
                modifiedKeyList = result.modifiedKeyList;
                for (key in result.fileNameList) {
                    duplicateNameText += "<p>&nbsp;&nbsp;&nbsp;* "+result.fileNameList[key]+"</p>";
                }
            }
        });

        if (duplicateNameText) {
            $(".modify-alert").show();
            $(".modify-alert-message").html(duplicateNameText);
            $("body").css({"overflow": "hidden"});
            $(".modify-alert-button-yes2").show();

            $(".modify-alert-button-yes1, .modify-alert-button-yes2").unbind("click").click(function()
            {
                if (this.value == "yes2") {
                    let temporaryUploadingFileList = [];
                    let newIndex = 0;
                    for (key in uploadingFileList) {
                        if (duplicateKeyList.indexOf(parseInt(key)) == -1) {
                            temporaryUploadingFileList[newIndex] = uploadingFileList[key];
                            newIndex += 1;
                        }
                    }
                    uploadingFileList = temporaryUploadingFileList;
                } else {
                    for (key in uploadingFileList) {
                        if (duplicateKeyList.indexOf(parseInt(key)) != -1) {
                            let keyIndex = duplicateKeyList.indexOf(parseInt(key));
                            uploadingFileList[key].id = modifiedKeyList[keyIndex];
                        }
                    }
                }

                totalUploadingFile = uploadingFileList.length;
                $(".modify-alert-button-cancel").click();
                if (uploadingFileList.length > 0) {
                    $("body").removeAttr("style");
                    showLoading(true, "Loading.. Uploading file: 0/"+totalUploadingFile, true);
                    saveUploadingFile();
                }
            });

            return;
        }

        if (uploadingFileList.length > 0) {
            $("body").removeAttr("style");
            showLoading(true, "Loading.. Uploading file: 0/"+totalUploadingFile, true);
            saveUploadingFile();
        }
    });

    $("html").live("dragover", function(event)
    {
        event.preventDefault();
        event.stopPropagation();
    }).live("drop", function(event)
    {
        event.preventDefault();
        event.stopPropagation();
    });

    if (parseInt("<?=(int)$hasPermission?>")) {
        $("#div-query").live("dragover", function(event)
        {
            event.stopPropagation();
            event.preventDefault();
        }).live("drop", function(event)
        {
            event.stopPropagation();
            event.preventDefault();
            event.originalEvent.dataTransfer.dropEffect = 'copy';

            let folderId = $("#selected-folder").val();
            let categoryId = $("#selected-file").val();

            if (
                $("#js-tree-content").jstree("get_selected")[0] == undefined
                || $("#js-tree-content").jstree("get_selected").length > 1
            ) {
                alert("Please select a folder");
                return;
            }

            let currentFolderId = 0;
            let currentCategoryId = 0;
            let isContinue = true;
            if ($("#js-tree-content").jstree("get_selected").length > 0) {
                for (key in $("#js-tree-content").jstree("get_selected")) {
                    [categoryId, folderId, type] = $("#js-tree-content").jstree("get_selected")[key].split("~");
                    if (type == "category") {
                        folderId = categoryId;
                    }

                    if (key == 0) {
                        currentFolderId = folderId;
                    }

                    if (key > 0 && currentFolderId != folderId || type == "folder") {
                        isContinue = false;
                        break;
                    }

                    if (parseInt(currentCategoryId) > 0 && parseInt(currentCategoryId) != categoryId) {
                        categoryId = 0;
                        break;
                    }

                    if (! parseInt(currentCategoryId)) {
                        currentCategoryId = categoryId;
                    }
                }
            }

            if (! isContinue) {
                alert("Please select a specific folder");
                return;
            }

            dragFileList = [];
            dragFileIndex = 0;
            dragText = "";
            dragFileName = "";
            let isExceedFileSize = false;
            for (key = 0; key < event.originalEvent.dataTransfer.files.length; key++) {
                dragFileList[key] = event.originalEvent.dataTransfer.files[key];

                let originalFileSize = event.originalEvent.dataTransfer.files[key].size;
                let fileExtesionNameList = event.originalEvent.dataTransfer.files[key].name.split(".");
                let extensionName = fileExtesionNameList[fileExtesionNameList.length - 1];

                if (originalFileSize > fileSizeLimit && (extensionName == "sql" || extensionName == "txt")) {
                    isExceedFileSize = true;
                }
            }

            if (isExceedFileSize) {
                alert("File size exceed 10MB!");
                isAllowToDrop = false;
                return;
            }

            let selected = $("#js-tree-content").jstree("get_selected");
            [categoryId, folderId, type] = selected[0].split("~");
            if (type == "category") {
                folderId = categoryId;
                categoryId = 0;
            }

            $("#selected-file").val(categoryId);
            $("#selected-folder").val(folderId);

            let isAllowToDrop = false;
            if (type == "category" || (type == "file" && ! $("#input-title").is(":disabled"))) {
                isAllowToDrop = true;
            }

            if (isAllowToDrop && (type == "file" > 0 && ! $("#input-title").is(":disabled"))) {
                if (! confirm("Do you wish to overwrite the content of the existing script?")) {
                    isAllowToDrop = false;
                }
            }

            if (dragFileList.length > 0 && isAllowToDrop) {
                showLoading(true, "Importing contents.. Please wait..", true);
                showDragFiles(folderId, categoryId);
            }
        });
    }

    $("#input-title, #folder-name").live("keypress", function(event)
    {
        let invalidInputList = ['\\', '/', ':', '*', '?', '"', '<', '>', '|'];

        for (key in invalidInputList) {
            if (event.key == invalidInputList[key]) {
                event.preventDefault();
            }
        }
    });

    $("#text-query").live("paste", function(event)
    {
        let text = event.originalEvent.clipboardData.getData('Text');

        if (! text.trim() || $(this).attr("contenteditable") == "false") {
            return;
        }

        if (parseInt(new Blob([text]).size) > fileSizeLimit) {
            alert("File size exceed 10MB!");
            return;
        }

        if (! this.value.trim()) {
            event.preventDefault();
            showLoading(true, "Pasting content.. Please wait..", true);
            setTimeout(function()
            {
                $("#text-query").val(text);
                showLoading(false, "", false);
            }, 100);
        }
    });

    $(".modify-alert-button-cancel").live("click", function()
    {
        $(".modify-alert").fadeOut();
        $("input[name='input-file']").val("");
        $("body").removeAttr("style");
        saveUploadCategory = false;
    });

    var chosenId = "#database_version_name_chzn";
    var isSavingDatabaseVersion = false;
    $("#add-database-version").live("click", function()
    {
        $("#database-version-name").find("option").remove();
        $("#database-version-name").val(null);

        $("#add-database-version-modal").modal("show");
        $("#database-version-name").chosen();
        $("#database-version-name").trigger("liszt:updated");

        $(chosenId).find(".search-field").find("input").css({"min-width": "100px"});
        isSavingDatabaseVersion = false;
    });

    $(chosenId).find(".search-field").find("input").live('keyup', function(event) {
        if (event.which === 13 && this.value.trim()) {
            $("#database-version-name").append("<option value=\""+this.value+"\" selected>"+this.value+"<option>");
            $("#database-version-name").trigger("liszt:updated");
        }
    }).live("keypress", function(event)
    {
        if (event.which == 46){
            if ($(this).val().indexOf('.') != -1) {
                return false;
            }
        }

        if (event.which != 8 && event.which != 0 && event.which != 46 && (event.which < 48 || event.which > 57)) {
            return false;
        }

        if ($(this).val().length > 3) {
            return false;
        }

        if ($(this).val().indexOf('.') == -1 && event.which != 46 && $(this).val().length > 1) {
            return false;
        }

        if ($(this).val().indexOf('.') != -1 && event.which != 46) {
            let splitDecimal = $(this).val().split(".");
            if (splitDecimal[0].length == 1 && splitDecimal[1].length == 1) {
                return false;
            }
        }
    });

    $("#image-database-version-update").live("click", function()
    {
        if (isSavingDatabaseVersion) {
            return;
        }
        isSavingDatabaseVersion = true;

        if (! $("#database-version-name").val()) {
            alert("DB Version is required");
            isSavingDatabaseVersion = false;
            return;
        }

        let countExistTable = 0;
        let databaseList = $("#database-version-name").val();
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/databaseVersionChecking")?>",
            type: "POST",
            data: {
                databaseVersionList: databaseList, 
                projectCode: $("#selectProject").val()
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                countExistTable = response.list.length;
            }
        });

        if (parseInt(countExistTable)) {
            let isAre = (parseInt(countExistTable) > 1) ? "are" : "is";
            alert("Database version "+isAre+" already exist");
            isSavingDatabaseVersion = false;
            return;
        }

        let isError = false;
        showLoading(true, "Loading..", true);
        for (key in databaseList) {
            $.ajax({
                url: "<?=base_url("sqlQueriesModule/saveFolderName")?>",
                type: "POST",
                data: {
                    folderId: 0,
                    folderName: databaseList[key],
                    parentId: 0,
                    projectCode: $("#selectProject").val()
                },
                dataType: "json",
                async: false,
                success: function(response)
                {
                    if (response.isError) {
                        isError = true;
                    }
                }
            });
        }

        alert((isError) ? "Failed to save new folder" : "Successfully saved.");
        isSavingDatabaseVersion = false;
        if (! isError) {
            $(".close-modal").click();
            showLoading(false, "Loading..", true); 
            loadFolderList(true, $("#selectProject").val());

            $("#advanced-sql-upload").css({"margin-top": "5px"});
            $("#advanced-sql-upload").removeAttr("disabled");
            $("#add-database-version").removeAttr("disabled");
        }
    });

    +$("#new-folder").live("click", function()
    {
        let option = "";
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/getAllVersionList")?>",
            type: "POST",
            data: {
                projectCode: $("#selectProject").val()
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                for (key in response.list) {
                    option += "\
                        <option value=\""+response.list[key].id+"\" selected>"+response.list[key].description+"</option>\
                    ";
                }
            }
        });
        $("#category-database-version-name").find("option").remove();
        $("#category-database-version-name").html(option);
        $("#advanced-category-modal").modal("show");
        $("#category-folder-name").val("");
        $("#category-database-version-name").chosen();
        $("#category-database-version-name").trigger("liszt:updated");
    });

    var saveCategoryUpdate = false;
    $("#image-category-update").live("click", function()
    {
        let formdata = {
            projectCode: $("#selectProject").val(),
            categoryName: $("#category-folder-name").val().trim(),
            versionNameList: $("#category-database-version-name").val()
        }
        $(".category-error-message").html("");

        if (saveCategoryUpdate) {
            return;
        }

        if (! formdata.categoryName) {
            alert("Folder name is required.");
            saveCategoryUpdate = false;
            return;
        }

        if (! formdata.versionNameList) {
            alert("DB Version is required");
            saveCategoryUpdate = false;
            return;
        }

        let existCategory = "";
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/checkExistCategory")?>",
            type: "POST",
            data: formdata,
            dataType: "json",
            async: false,
            success: function(response)
            {
                if (response.list.length) {
                    existCategory += "List of Database Version: ";
                }

                for (key in response.list) {
                    existCategory += response.list[key] +((key == (response.list.length - 1)) ? "." : ", ");
                }
            }
        });

        if (existCategory) {
            alert("Category is already exist");
            $(".category-error-message").html(existCategory);
            return;
        }

        let isError = false;
        for (key in formdata.versionNameList) {
            $.ajax({
                url: "<?=base_url("sqlQueriesModule/saveFolderName")?>",
                type: "POST",
                data: {
                    folderId: 0,
                    folderName: formdata.categoryName,
                    parentId: formdata.versionNameList[key],
                    projectCode: $("#selectProject").val()
                },
                dataType: "json",
                success: function(response)
                {
                    if (response.isError) {
                        isError = true;
                    }
                }
            });
        }

        saveCategoryUpdate = false;
        alert((isError) ? "Failed to saved." : "Successfully saved");
        if (! isError) {
            $(".close-modal").click();
            loadFolderList(true, $("#selectProject").val());
        }
    });

    $("#advanced-sql-upload").live("click", function()
    {
        let option = "<option value=\"\" selected>Select category</option>";
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/getAllCategoryList")?>",
            type: "POST",
            data: {
                projectCode: $("#selectProject").val()
            }, 
            dataType: "json",
            async: false,
            success: function(response)
            {
                for (key in response.list) {
                    let category = response.list[key];

                    option += "<option value=\""+category+"\">"+category+"</option>";
                }
            }
        });
        $("#upload-folder-name").html(option);
        $("#upload-database-version-name").html("");
        $("#upload-database-version-name").val(null);

        $("#advanced-sql-upload-modal").modal("show");
        $(".uploaded-loading-status").hide();
        $(".upload-notification-status").show();
        $("#upload-folder-name, #upload-database-version-name").chosen();
        $("#upload-folder-name, #upload-database-version-name").trigger("liszt:updated");
        $("input[name='upload-category-file']").val(null);
    });

    $("#upload-folder-name").live("change", function()
    {
        if (! this.value) {
            $("#upload-database-version-name").html("");
            $("#upload-database-version-name").val(null);
            $("#upload-database-version-name").trigger("liszt:updated");
            return;
        }

        let option = "";
        $.ajax({
            url: "<?=base_url("sqlQueriesModule/getVersionListByCategory")?>",
            type: "POST",
            data: {
                category: this.value,
                projectCode: $("#selectProject").val()
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                for (key in response.list) {
                    option += "\
                        <option value=\""+response.list[key].id+"\" selected>"+response.list[key].description+"</option>\
                    ";
                }
            }
        });
        $("#upload-database-version-name").find("option").remove();
        $("#upload-database-version-name").html(option);
        $("#upload-database-version-name").trigger("liszt:updated");
    });

    $("#advanced-upload").live("click", function()
    {
        $("input[name='upload-category-file']").click();
    });

    $("input[name='upload-category-file']").live("change", function(event)
    {
        if (this.files != undefined) {
            let selectedFiles = "";

            for (key = 0; key < this.files.length; key++) {
                if (this.files[key].name != undefined) {
                    selectedFiles += ((selectedFiles) ? ", ": "")+this.files[key].name;
                }
            }

            selectedFiles = "Selected files: "+ selectedFiles;
            advancedSqlUploadedLoading(true, selectedFiles, false);
        }
    });

    /**
     * Construct advanced upload data
     * @param  {array}   versionList    [version list]
     * @param  {string}  category       [category]
     * @param  {string}  files          [file list]
     * @return {array}   [formdata]
     */
    function constructAdvancedUploadData(versionList, category, files)
    {
        let formdata = [];
        let index = 0;

        for (versionKey in versionList) {
            version = versionList[versionKey];

            for (key in files) {
                formdata[index] = {
                    version: version,
                    category: category,
                    file: files[key],
                    fileLength: files.length
                };

                index += 1;
            }
        }

        return formdata;
    }

    /**
     * Process upload file
     * @param  {string}   text              [version list]
     * @param  {array}    selected          [selected list]
     * @param  {integer}  files             [file list]
     * @param  {array}    categoryFileList  [category file list]
     * @param  {integer}  key               [key]
     * @param  {integer}  startIndex        [start key]
     * @param  {integer}  countSize         [count size]
     */
    function processUploadFile(text, selected, isBigData, categoryFileList, key, startIndex = 0, countSize = 0)
    {
        let content = "";
        let endIndex = startIndex + maxLengthText;
        let isContinue = true;
        if (isBigData) {
            content = text.substring(startIndex, endIndex);

            currentFileSize = parseInt(new Blob([content]).size);
            totalCountSize = countSize + currentFileSize;
            if (totalCountSize == parseInt(new Blob([text]).size) || endIndex >= text.length) {
                isContinue = false;
            }
        }

        $.ajax({
            url: "<?=base_url("sqlQueriesModule/saveAdvancedSqlData")?>",
            type: "POST",
            data: {
                content: (isBigData) ? content : text,
                name: selected.file.name,
                category: selected.category,
                version: selected.version,
                projectCode: $("#selectProject").val(),
                isBigData: isBigData,
                isEdit: (! startIndex) ? 1 : 0
            },
            dataType: "json",
            success: function(response)
            {

                if (! isBigData) {
                    updateLoadingAdvancedSqlUploadStatus(categoryFileList, key, response.isError);
                } else {
                    if (isContinue) {
                        processUploadFile(text, selected, isBigData, categoryFileList, key, endIndex, totalCountSize);
                    } else {
                        updateLoadingAdvancedSqlUploadStatus(categoryFileList, key, response.isError);
                    }
                }
            },
            error: function(xhr, status, error)
            {
                updateLoadingAdvancedSqlUploadStatus(categoryFileList, key, true);
            }
        });
    }

    /**
     * Update loading status
     * @param  {array}    categoryFileList  [category file list]
     * @param  {integer}  key               [key]
     * @param  {integer}  isError           [start key]
     */
    function updateLoadingAdvancedSqlUploadStatus(categoryFileList, key, isError)
    {
        countAdvanceUploadData += ((isError) ? 0 : 1);
        advancedSqlUploadedLoading(true, "Loading.. Uploading file: "+countAdvanceUploadData+"/"+ categoryFileList.length);

        key += 1;
        if (key == categoryFileList.length) {
            advancedSqlUploadedLoading(false, "");
            saveMessage = (countAdvanceUploadData == categoryFileList.length) ? "Successfully saved" : "Failed to saved";
            alert(saveMessage);

            saveUploadCategory = false;
            $("input[name='upload-category-file']").val(null);

            if (countAdvanceUploadData == categoryFileList.length) {
                loadFolderList(true, $("#selectProject").val());
                $(".close-advanced").click();
            }
        } else {
            saveAdvancedSqlUploaded(categoryFileList, key);
        }
    }

    /**
     * save advanced sql uploaded
     * @param  {array}    categoryFileList  [category file list]
     * @param  {integer}  key               [key]
     */
    function saveAdvancedSqlUploaded(categoryFileList, key = 0)
    {
        let selected = categoryFileList[key];
        var reader = new FileReader();

        reader.onload = function (event)
        {
            let isContinue = true;
            let fileNameList = selected.file.name.split(".");
            let extensionName = fileNameList[fileNameList.length - 1];
            let fileSize = selected.file.size;

            if (extensionName != "sql" && extensionName != "txt") {
                if (selected.fileLength == 1) {
                    alert("Invalid file!");
                    advancedSqlUploadedLoading(false);
                    loadFolderList(true, $("#selectProject").val()); 
                    saveUploadCategory = false;
                    $("input[name='upload-category-file']").val(null);
                    return;
                }
                isContinue = false;
            }

            if (isContinue) {
                $.ajax({
                    url: event.target.result,
                    type: "POST",
                    success: function(text)
                    {
                        processUploadFile(text, selected, (fileSize > maxFileSize) ? 1 : 0, categoryFileList, key);
                    }
                });
            }
        }

        reader.readAsDataURL(selected.file);
    }

    /**
     * save advanced sql uploaded
     * @param  {boolean}  isShow          [is show]
     * @param  {integer}  loadingCaption  [loading caption]
     */
    function advancedSqlUploadedLoading(isShow = false, loadingCaption = "Loading..", showLoadingImage = true) {
        if (isShow) {
            $(".upload-notification-status").hide();
            $(".uploaded-loading-status").show();

            let loadingImage = (showLoadingImage)
                ? "<img src='assets/images/loading.gif' width='15px' height='15px'>&nbsp;"
                : "";
            loadingCaption = loadingImage+ loadingCaption;
            $(".uploaded-loading-status").html(loadingCaption);
        } else {
            $(".upload-notification-status").show();
            $(".uploaded-loading-status").hide();
        }
    }

    var saveUploadCategory = false;
    var countAdvanceUploadData = 0;
    $("#image-upload-update").live("click", function()
    {
        let categoryFileList = [];
        let files = $("input[name='upload-category-file']")[0].files;
        if (saveUploadCategory) {
            return;
        }
        saveUploadCategory = true;

        if (files === undefined || files.length == 0) {
            alert("Upload SQL File is required.");
            saveUploadCategory = false;
            return;
        }

        if (! $("#upload-folder-name").val()) {
            alert("Category is required.");
            saveUploadCategory = false;
            return;
        }

        if (! $("#upload-database-version-name").val()) {
            alert("DB Version is required.");
            saveUploadCategory = false;
            return;
        }

        let fileNameList = [];
        let fileList = [];
        let isExceedFileSize = false;
        for (key = 0; key < files.length; key++) {
            fileNameList[key] = files[key].name;
            fileList[key] = files[key];

            let originalFileSize = files[key].size;
            let fileExtesionNameList = files[key].name.split(".");
            let extensionName = fileExtesionNameList[fileExtesionNameList.length - 1];
            if (originalFileSize > fileSizeLimit && (extensionName == "sql" || extensionName == "txt")) {
                isExceedFileSize = true;
            }
        }

        if (isExceedFileSize) {
            alert("File size exceed 10MB! Unable to upload.");
            saveUploadCategory = false;
            return;
        }

        let duplicateNameText = "";
        let versionList = $("#upload-database-version-name").val();
        countAdvanceUploadData = 0;

        $.ajax({
            url: "<?=base_url("sqlQueriesModule/advancedSQLFileExistChecker")?>",
            type: "POST",
            data: {
                category: $("#upload-folder-name").val(), 
                versionList: versionList,
                fileNameList: fileNameList,
                projectCode: $("#selectProject").val()
            },
            dataType: "json",
            async: false,
            success: function(response)
            {
                for (key in response.list) {
                    let row = response.list[key];
                    duplicateNameText += "<p>&nbsp;&nbsp;&nbsp;* "+row.path+"</p>";
                }
            }
        });

        $(".modify-alert-button-yes2").show();
        if (duplicateNameText) {
            $(".modify-alert").show();
            $(".modify-alert-message").html(duplicateNameText);
            $("body").css({"overflow": "hidden"});
            $(".modify-alert-button-yes2").hide();

            $(".modify-alert-button-yes1").unbind("click").click(function()
            {
                categoryFileList = constructAdvancedUploadData(versionList, $("#upload-folder-name").val(), fileList);
                $(".modify-alert-button-cancel").click();

                advancedSqlUploadedLoading(true, "Loading.. Uploading file: 0/"+ categoryFileList.length);
                saveAdvancedSqlUploaded(categoryFileList);
            });
            return;
        }

        categoryFileList = constructAdvancedUploadData(versionList, $("#upload-folder-name").val(), fileList);
        advancedSqlUploadedLoading(true, "Loading.. Uploading file: 0/"+ categoryFileList.length);
        saveAdvancedSqlUploaded(categoryFileList); 
    });

    $(".close-advanced").live("click", function(event)
    {
        event.preventDefault();

        if (! saveUploadCategory) {
            $(".advanced-modal-close").click();
        }
    });
</script>
