<script type="text/javascript">
    var fileSizeLimit = 2000000;

    var myJsTableAnnouncement;
    var tableAnnouncement = document.createElement('table');
    tableAnnouncement.id = "table-announcement-id";
    tableAnnouncement.className = "table table-bordered";
    var columnArray = [];

    var announcementId = document.createElement('span');
    columnArray['announcementId'] = {
        header_title: "",
        edit: [announcementId],
        disp: [announcementId],
        td_class: "tablerow announcement-id td-hide",
        headertd_class : "tdclick announcement-id td-hide"
    };

    var spanAnnouncementId = document.createElement('span');
    spanAnnouncementId.className = 'span-announcement-id';
    columnArray['spanAnnouncementId'] = {
        header_title: "",
        edit: [spanAnnouncementId],
        disp: [spanAnnouncementId],
        td_class: "tablerow span-announcement-id",
        headertd_class : "tdclick span-announcement-id"
    };

    var spanAnnouncementName = document.createElement('span');
    spanAnnouncementName.className = 'span-announcement-name';
    columnArray['spanAnnouncementName'] = {
        header_title: "Announcement List",
        edit: [spanAnnouncementName],
        disp: [spanAnnouncementName],
        td_class: "tablerow span-announcement-name",
        headertd_class : "tdclick span-announcement-name"
    };

    var broadcastAnnouncementImage = document.createElement('span');
    broadcastAnnouncementImage.setAttribute("onclick", "broadcastAnnouncement(this, 0)");
    broadcastAnnouncementImage.setAttribute("id", "broadcast-announcement");
    broadcastAnnouncementImage.innerHTML = "\
        <center>\
            <img src='assets/images/off.ico' style='height: 20px; width: 20px;'>\
        </center>\
    ";
    broadcastAnnouncementImage.style.cursor = "pointer";
    columnArray['columnBroadcastAnnouncement'] = {
        header_title: "",
        edit: [broadcastAnnouncementImage],
        disp: [broadcastAnnouncementImage],
        td_class: " tablerow td-broadcast-announcement",
        headertd_class : "td-broadcast-announcement"
    };

    $(function()
    {
        myJsTableAnnouncement = new my_table(tableAnnouncement, columnArray, {
            ispaging: false,
            tdhighlight_when_hover: "tablerow",
            iscursorchange_when_hover: true
        });

        var root = document.getElementById("table-announcement");
        root.appendChild(myJsTableAnnouncement.tab);
        announcementTable();

        $('#date-live').datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
        $('#date-until').datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
    });

    function announcementTable(rowstart, rowend)
    {
        myJsTableAnnouncement.clear_table();
        $.ajax(
        {
            url: "<?=base_url()?>announcementModule/displayAnnouncementList",
            type: "POST",
            dataType: "json",
            data: {},
            success: function(data)
            {
                allowFields(false, false);
                myJsTableAnnouncement.insert_multiplerow_with_value(1, data.data);
                $("#table-announcement-id").wrap("<div class='scrollable'></div>");
            }
        });
    }

    $(".tablerow").live("click", function(announcement)
    {
        allowFields(false, false);

        var rowIndex = $(this).parents("tr").index();
        var announcementId = myJsTableAnnouncement.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnArray['announcementId'].td_class
        )[0];
        var dateNow = new Date();
        var month = dateNow.getMonth() + 1;
        var day = dateNow.getDate();
        month = (month < 10) ? "0" + month : month;
        day = (day < 10) ? "0" + day : day;
        var currentDate = dateNow.getFullYear() + "-" + month + "-" + day;

        advancedSqlUploadedLoading(true);

        $.ajax({
            url: "<?=base_url("announcementModule/getSpecificAnnouncement")?>",
            type: "POST",
            data: {
                id: announcementId
            },
            dataType: "json",
            success: function(data)
            {
                if (data.dateUntil < currentDate) {
                    $("#image-live").attr("src", "assets/images/expired_icon.png");
                } else if (data.isBroadcast == 1) {
                    $("#image-live").attr("src", "assets/images/live_icon_blue.png");
                } else if (data.isBroadcast == 0) {
                    $("#image-live").attr("src", "assets/images/live_icon_gray.png");
                }

                $("#input-title").val(data.name);
                $("#date-live").val(data.dateLive);
                $("#date-until").val(data.dateUntil);
                $("#delete-file").val(rowIndex);
                $("#image-live").val(rowIndex);
                $("#broadcast-status").val(data.isBroadcast);
                $("#id").val(data.id);
                $(".nicEdit-main").html(data.fileContent);
                advancedSqlUploadedLoading(false);
            }
        });
    });

    /**
     * save advanced sql uploaded
     * @param  {boolean}  isShow          [is show]
     * @param  {integer}  loadingCaption  [loading caption]
     */
    function advancedSqlUploadedLoading(isShow = false, loadingCaption = "Loading...", showLoadingImage = true) {
        if (isShow) {
            $(".uploaded-loading-status").show();
            $("#delete-file").attr("disabled", "disabled");
            $("#create-announcement").attr("disabled", "disabled");
            $("#image-edit").hide();

            let loadingImage = (showLoadingImage)
                ? "<img src='assets/images/loading.gif' width='15px' height='15px'>&nbsp;"
                : "";
            loadingCaption = loadingImage + loadingCaption;
            $(".uploaded-loading-status").html(loadingCaption);
        } else {
            $(".uploaded-loading-status").hide();
            $("#delete-file").removeAttr("disabled");
            $("#create-announcement").removeAttr("disabled");
            $("#image-edit").show();
        }
    }

    /**
     * broadcast current announcement
     * @param  {int}      announcement  [row index of the element]
     * @param  {boolean}  isButton      [from what element the trigger comes from]
     */
    function broadcastAnnouncement(announcement, isButton)
    {
        if (isButton) {
            var rowIndex = $("#image-live").val();
        } else {
            var rowIndex = $(announcement).parents("tr").index();
        }
        var announcementId = myJsTableAnnouncement.getvalue_by_rowindex_tdclass(
            rowIndex,
            columnArray['announcementId'].td_class
        )[0];

        var hasExistingBroadcast = [];
        var existingBroadcastId = 0;
        var message = "";
        var dateNow = new Date();
        var month = dateNow.getMonth() + 1;
        var day = dateNow.getDate();
        month = (month < 10) ? "0" + month : month;
        day = (day < 10) ? "0" + day : day;
        var currentDate = dateNow.getFullYear() + "-" + month + "-" + day;

        $.ajax({
            url: "<?=base_url()?>announcementModule/broadcastingAnnouncementStatus",
            type: "POST",
            dataType: "json",
            data: {
                id: announcementId
            },
            success: function(data)
            {
                hasExistingBroadcast = data.data;
                dateLive = data.dateLive;
                dateUntil = data.dateUntil;

                $.each(hasExistingBroadcast, function( key, value ) {
                  if (value == announcementId) {
                        existingBroadcastId = 1;
                  }
                });

                if (hasExistingBroadcast.length < 3 || existingBroadcastId) {
                    if (isButton) {
                        allowFields(false, false);
                    }

                    if (dateUntil < currentDate && existingBroadcastId) {
                        message = "Are you sure you want to deactivate this live announcement?";
                    } else if (
                        dateLive < currentDate
                        && dateUntil < currentDate
                    ) {
                        alert("Unable to Broadcast Announcement. Please check date validity.");
                        return;
                    }

                    if (! existingBroadcastId) {
                        message = "Are you sure you want to make this announcement to be on live?";
                    } else {
                        message = "Are you sure you want to deactivate this live announcement?";
                    }
                } else if (dateUntil < currentDate) {
                    alert("Unable to Broadcast Announcement. Please check date validity.");
                    return;
                } else if (hasExistingBroadcast.length == 3) {
                    alert("Unable to broadcast more than 3 announcement. De-activate at least 1 announcement before proceeding to a new broadcast");
                    return;
                } else if (hasExistingBroadcast.length == 0) {
                    message = "Are you sure you want to make this announcement to be on live?";
                }

                var answer = confirm(message);
                if (answer) {
                    $.ajax({
                        url: "<?=base_url()?>announcementModule/updateBroadcastingStatus",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id: announcementId
                        },
                        success: function(data)
                        {
                            $("#broadcast-status").val(data);
                            var broadcastImage = ["off.ico", "on.ico"];
                            var imagePath = "\
                                <center>\
                                    <img src='assets/images/"+broadcastImage[data]+"' style='height: 20px; width: 20px;'>\
                                </center>\
                            ";
                            myJsTableAnnouncement.setvalue_to_rowindex_tdclass(
                                [imagePath],
                                rowIndex,
                                columnArray['columnBroadcastAnnouncement'].td_class
                            );

                            if ($("#date-until").val() < currentDate) {
                                $("#image-live").attr("src", "assets/images/expired_icon.png");
                            } else if (data == 1) {
                                $("#image-live").attr("src", "assets/images/live_icon_blue.png");
                            } else {
                                $("#image-live").attr("src", "assets/images/live_icon_gray.png");
                            }
                            announcementTable();
                        }
                    });
                }
            }
        });
        $("#table-announcement-id").wrap("<div class='scrollable'></div>");
    }

    $("#image-live").live("click", function()
    {
        var announcement = $("#image-live").val();

        if ($("#id").val() == 0) {
            return;
        }
        broadcastAnnouncement(announcement, 1);
    });

    var isAllowImageUpdate = true;

    bkLib.onDomLoaded(function()
    {
        new nicEditors.allTextAreas({
            buttonList: [
                'bold',
                'italic',
                'underline',
                'left',
                'center',
                'right',
                'justify',
                'ol',
                'ul',
                'fontSize',
                'fontFamily',
                'fontFormat',
                'indent',
                'outdent'
            ]
        })
        jQuery('.nicEdit-main').attr('contenteditable', 'false');
        jQuery('.nicEdit-panel').hide();
    });

    /**
     * Allowing title and body fields
     * @param {bolean}  isAllow        [is disabled or abled fileds]
     * @param {bolean}  isClearFields  [is clear fields]
     */
    function allowFields(isAllow = false, isClearFields = true)
    {
        if (isClearFields) {
            $("#input-title").val("");
            $("#date-live").val("");
            $("#date-until").val("");
            $(".nicEdit-main").html("");
        }

        if (isAllow) {
            $("#input-title").removeAttr("disabled");
            $("#date-live").removeAttr("disabled");
            $("#date-until").removeAttr("disabled");
            jQuery('.nicEdit-main').attr('contenteditable', 'true');
            jQuery('.nicEdit-panel').show();
            $(".div-left-content").css({"min-height": "619px"});
            $("#image-update").show();
            $("#image-edit").hide();
        } else {
            $("#input-title").attr("disabled", "disabled");
            $("#date-live").attr("disabled", "disabled");
            $("#date-until").attr("disabled", "disabled");
            jQuery('.nicEdit-main').attr('contenteditable', 'false');
            jQuery('.nicEdit-panel').hide();
            $(".div-left-content").removeAttr("style");
            $("#image-update").hide();
            $("#image-edit").show();
        }
    }

    $("#image-edit").live("click", function()
    {
        allowFields(true, false);

        if ($("#broadcast-status").val() == 1) {
            $("#date-live").attr("disabled", "disabled");
            $("#date-until").attr("disabled", "disabled");
        }
    });

    $("#create-announcement").live("click", function()
    {
        allowFields(true, true);

        $("#image-live"). attr("src", "assets/images/live_icon_gray.png");
        $("#id").val("0");
        $("#delete-file").attr("disabled", "disabled");
        $("#date-live").val("<?=date("Y-m-d")?>");
        $("#date-until").val("<?=date("Y-m-d")?>");
    });

    $("#image-update").live("click", function()
    {
        let announcementTitle = $("#input-title").val().trim();
        let announcementDateLive = $("#date-live").val();
        let announcementDateUntil = $("#date-until").val();
        let announcementBody = $(".nicEdit-main").html().trim();
        var announcementId = $("#id").val();
        var isBroadcast = $("#broadcast-status").val();

        var dateNow = new Date();
        var month = dateNow.getMonth() + 1;
        var day = dateNow.getDate();
        month = (month < 10) ? "0" + month : month;
        day = (day < 10) ? "0" + day : day;
        var currentDate = dateNow.getFullYear() + "-" + month + "-" + day;
        var currentTime = dateNow.getHours() + ":" + dateNow.getMinutes() + ":" + dateNow.getSeconds();
        var dateTime = currentDate + ' ' + currentTime;

        var hasExistingAnnouncementTitle = 0;

        if (! announcementTitle) {
            alert("Title is required.");
            return;
        }

        if (announcementTitle) {
            $.ajax({
                url: "<?=base_url()?>announcementModule/existingAnnouncementTitle",
                dataType: "json",
                type: "POST",
                data: {
                    id: announcementId,
                    announcementTitle: announcementTitle
                },
                async: false,
                success: function(data)
                {
                    hasExistingAnnouncementTitle = data[0] > 0;
                }
            });

            if (hasExistingAnnouncementTitle) {
                alert('Title already exist.');
                return;
            }
        }

        if (! announcementDateLive || announcementDateLive == "0000-00-00") {
            alert("Date Live is required.");
            return;
        }

        if (! announcementDateUntil || announcementDateUntil == "0000-00-00") {
            alert("Date Until is required.");
            return;
        }

        if (! announcementBody) {
            alert("Announcement content is required.");
            return;
        }

        if (announcementDateUntil < announcementDateLive) {
            alert("Invalid date range for date live and until.");
            return;
        }

        textAnnouncementSize = 0;
        textAnnouncementSize = new Blob([announcementBody]).size;
        textAnnouncementSize = parseInt(textAnnouncementSize);

        if (textAnnouncementSize > fileSizeLimit) {
            alert("File size exceed 2MB!");
            return;
        }

        if (textAnnouncementSize > 7000000) {
            temporaryAnnouncementId = announcementId;
            temporaryAnnouncementBody = announcementBody;
            temporaryAnnouncementDateLive = announcementDateLive;
            temporaryAnnouncementDateUntil = announcementDateUntil;
            temporaryAnnouncementTitle = announcementTitle;
            temporaryCurrentDate = currentDate;
            temporaryBroadcastStatus = isBroadcast,
            startStringIndex = 0;
            endStringIndex = 0;
            countAnnouncementSize = 0;
            setTimeout(function()
            {
                saveAnnouncementFile(1);
            }, 1);
            return;
        }

        $.ajax({
            url: "<?=base_url("announcementModule/saveFileAnnouncement")?>",
            type: "POST",
            data: {
                id: announcementId,
                announcementTitle: announcementTitle,
                announcementDateLive: announcementDateLive,
                announcementDateUntil: announcementDateUntil,
                announcementBody: announcementBody,
                broadcastStatus: isBroadcast,
                currentDate: currentDate,
                dateTime: dateTime
            },
            dataType: "json",
            success: function(response)
            {
                if (! response.isError) {
                    allowFields(false, false);
                    announcementTable();
                }
                alert(response.message.trim());
                $("#id").val(response.announcementId);
                $("#broadcast-status").val(response.broadcastStatus);

                if ($("#date-until").val() < currentDate) {
                    $("#image-live").attr("src", "assets/images/expired_icon.png");
                } else if (response.broadcastStatus == 1) {
                    $("#image-live").attr("src", "assets/images/live_icon_blue.png");
                } else if (response.broadcastStatus == 0) {
                    $("#image-live").attr("src", "assets/images/live_icon_gray.png");
                }
            }
        });
    });

    var textAnnouncementSize = 0;
    var countAnnouncementSize = 0;
    var startStringIndex = 0;
    var endStringIndex = 0;
    var temporaryAnnouncementBody = "";
    /**
     * Save query file
     * @param  {integer}  numberOfLoop  [number of loop]
     */
    function saveAnnouncementFile(numberOfLoop)
    {
        let announcementText = "";
        let isContinue = true;
        let totalCountSize = 0;
        let currentFileSize = 0;

        endStringIndex += 5000000;
        announcementText = temporaryAnnouncementBody.substring(startStringIndex, endStringIndex);

        currentFileSize = parseInt(new Blob([announcementText]).size);
        totalCountSize = countAnnouncementSize + currentFileSize;
        if (totalCountSize == textAnnouncementSize || endStringIndex >= temporaryAnnouncementBody.length) {
            isContinue = false;
        }

        $.ajax({
            url: "<?=base_url("announcementModule/saveBigFile")?>",
            type: "POST",
            data: {
                id: temporaryAnnouncementId,
                announcementTitle: temporaryAnnouncementTitle,
                announcementDateLive: temporaryAnnouncementDateLive,
                announcementDateUntil: temporaryAnnouncementDateUntil,
                announcementBody: announcementText,
                broadcastStatus: temporaryBroadcastStatus,
                currentDate: temporaryCurrentDate,
                numberOfLoop: numberOfLoop
            },
            dataType: "json",
            success: function(response)
            {
                if (! parseInt(temporaryAnnouncementId)) {
                    temporaryAnnouncementId = response.announcementId;
                }

                if (isContinue) {
                    startStringIndex = endStringIndex;
                    countAnnouncementSize = totalCountSize;
                    numberOfLoop += 1;
                    saveAnnouncementFile(numberOfLoop);
                } else {
                    if (! response.isError) {
                        allowFields(false, false);
                        announcementTable();
                    }

                    alert(response.message.trim());
                    $("#id").val(response.announcementId);
                    $("#broadcast-status").val(response.broadcastStatus);

                    if ($("#date-until").val() < currentDate) {
                        $("#image-live").attr("src", "assets/images/expired_icon.png");
                    } else if (response.broadcastStatus == 1) {
                        $("#image-live").attr("src", "assets/images/live_icon_blue.png");
                    } else if (response.broadcastStatus == 0) {
                        $("#image-live").attr("src", "assets/images/live_icon_gray.png");
                    }
                }
            },
            error: function(xhr, status, error)
            {
                alert("Failed to saved.");
            }
        });
    }

    $("#delete-file").live("click", function()
    {
        var rowIndex = $("#delete-file").val();
        var announcementId = $("#id").val();
        var existingBroadcastId = 0;

        $.ajax(
        {
            url: "<?=base_url()?>announcementModule/broadcastingAnnouncementStatus",
            dataType: "json",
            type: "POST",
            data: {
                id: announcementId
            },
            async: false,
            success: function(data)
            {
                hasExistingBroadcast = data.data;

                $.each(hasExistingBroadcast, function(key, value) {
                  if (value == announcementId) {
                        existingBroadcastId = 1;
                  }
                });
            }
        });

        if (existingBroadcastId) {
            alert("Announcement can only be deleted if it is not currently broadcasting.");
            return;
        }

        if (! confirm("Are you sure you want to delete this announcement?")) {
            return;
        }

        $.ajax({
            url: "<?=base_url("announcementModule/deleteAnnouncement")?>",
            type: "POST",
            data: {
                id: announcementId
            },
            dataType: "json",
            success: function(response)
            {
                if (response) {
                    alert("Deleted Successfully");
                    allowFields(false);
                    myJsTableAnnouncement.delete_row(rowIndex);
                    $("#delete-file").attr("disabled", "disabled");
                } else {
                    alert("Failed to delete.");
                }
            }
        });
    });
</script>
